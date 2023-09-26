// div 생성하는 함수
function createInfoDiv(value) {
  var div = document.createElement("div");
  div.innerHTML = value;
  return div;
}

// 지도 생성 로직
// 지도 생성 및 foreach로 각 위치에 마커, 윈포윈도우 및 클러스터 생성
// 사이드바에 상세 페이지로 이동하는 링크를 가진 이미지와 건물정보들 출력
function displayData(data) {

    let sidebar = document.getElementById("sidebar");
    // 사이드바 내용 초기화 후 생성
    sidebar.innerHTML = '';

    // 사이드바에 출력할 정보 생성
    data.forEach((data2, i) => {
        let s_option;
        let s_type;
        let s_month;
        if (data2.p_month) {
          s_month = " / " + data2.p_month;
        } else {
          s_month = "";
        }
        switch (data2.s_option) {
          case "0":
            s_option = "아파트";
            break;
          case "1":
            s_option = "단독주택";
            break;
          case "2":
            s_option = "오피스텔";
            break;
          case "3":
            s_option = "빌라";
            break;
          case "4":
            s_option = "원룸";
            break;

          default:
            break;
        }
        switch (data2.s_type) {
          case "0":
            s_type = "매매";
            break;
          case "1":
            s_type = "전세";
            break;
          case "2":
            s_type = "월세";
            break;
          default:
            break;
        }
        switch (data2.s_parking) {
          case "0":
            s_parking = "주차 X, ";
            break;
          case "1":
            s_parking = "주차 O, ";
            break;
          default:
            break;
        }
        switch (data2.s_ele) {
          case "0":
            s_ele = "엘베 X";
            break;
          case "1":
            s_ele = "엘베 O";
            break;
          default:
            break;
        }
        switch (data2.animal_size) {
          case "0":
            animal_size = "X";
            break;
          case "1":
            animal_size = "O";
            break;
          default:
            break;
        }

        // 사이드 건물 이미지 + 건물 정보 생성
        let sidebar = document.getElementById("sidebar");

        let info = document.createElement("div");
        info.className = "estate_info";
        info.id = "item" + (i + 1).toString();
        info.style.border = "1px solid black";

        var imgLink = document.createElement("a");
        imgLink.href = "./detailEstate.php?s_no=" + data2.s_no;

        var img = document.createElement("img");
        img.src = data2.url;
        img.style.width = "270px";
        img.style.height = "200px";

        imgLink.appendChild(img);

        info.appendChild(imgLink);
        info.appendChild(createInfoDiv("건물이름 : " + data2.s_name));
        info.appendChild(createInfoDiv("건물유형 : " + s_option));
        info.appendChild(createInfoDiv("매매유형 : " + s_type));
        info.appendChild(createInfoDiv("가격 : " + data2.p_deposit + s_month));
        info.appendChild(createInfoDiv("건물옵션 : " + s_parking + s_ele));
        info.appendChild(createInfoDiv("대형동물 " + animal_size));

        sidebar.appendChild(info);
      });
      //   지도 생성 및 마커 찍기(기본 중심좌표 대구시청)
      var container = document.getElementById("map");
      var options = {
        center: new kakao.maps.LatLng(35.8708274319876, 128.604605757621),
        level: 8,
      };

      var map = new kakao.maps.Map(container, options);

      //   클러스터 설정
      var clusterer = new kakao.maps.MarkerClusterer({
        map: map,
        averageCenter: true,
        minLevel: 8,
      });

      // 건물 위치에 마커 생성 및 인포윈도우 추가
      var markers = data.map((item, i) => {
        var markerPosition = new kakao.maps.LatLng(item.s_log, item.s_lat);
        var marker = new kakao.maps.Marker({
          position: markerPosition,
        });

        // 인포윈도우 생성
        var infowindow = new kakao.maps.InfoWindow({
          content: '<div style="padding:3px;">' + item.s_name + "</div>", // 이 부분은 원하는 정보로 수정 가능합니다.
          removable: true,
        });

        // 마커에 마우스 올리면 인포윈도우 보임
        kakao.maps.event.addListener(marker, "mouseover", function () {
          infowindow.open(map, marker);
        });

        // 마우스 내리면 숨김
        kakao.maps.event.addListener(marker, "mouseout", function () {
          infowindow.close();
        });

        // 마커 클릭하면 해당하는 건물정보가 있는 사이드바로 이동
        kakao.maps.event.addListener(marker, 'click', function() {
            var targetDiv = document.getElementById('item' + (i + 1));
            targetDiv.scrollIntoView({
                behavior: 'auto', 
                block: 'center'
            });
            targetDiv.style.border = "5px solid red";
            setTimeout(function() {
                targetDiv.style.border = "none";
            }, 2000);
        });
    

        return marker;
      });

      clusterer.addMarkers(markers);

      //   구 선택하면 지도 중심이 그쪽으로 바뀜
      document.getElementById("option").addEventListener("change", function () {
        var selectedGu = this.value; // 현재 선택된 구
        let lat;
        let lng;
        switch (selectedGu) {
          case "구 선택":
            lat = 35.8708274319876;
            lng = 128.604605757621;
            break;
          case "달서구":
            lat = 35.8299155224738;
            lng = 128.532835550073;
            break;
          case "달성군":
            lat = 35.7746631676172;
            lng = 128.431389741374;
            break;
          case "동구":
            lat = 35.8868105755475;
            lng = 128.636075097087;
            break;
          case "서구":
            lat = 35.8723387527958;
            lng = 128.559279224869;
            break;
          case "남구":
            lat = 35.8457841445375;
            lng = 128.597259963486;
            break;
          case "북구":
            lat = 35.9069966824932;
            lng = 128.61811675672;
            break;
          case "수성구":
            lat = 35.8582000811537;
            lng = 128.630629788584;
            break;
          case "중구":
            lat = 35.8693256621114;
            lng = 128.60615767581;
            break;
          default:
            break;
        }
        var newCenter = new kakao.maps.LatLng(lat, lng);
        map.setCenter(newCenter); // 지도의 중심을 변경
    });
}


// 페이지에 처음 들어왔을때 실행
// 건물정보 전체를 받아오고
// 사이드바에 건물 이미지와 정보를 출력
// 지도에는 모든 건물의 좌표를 받아 마커를 찍음
addEventListener("DOMContentLoaded", () => {
  fetch("./common/api.php")
    .then((response) => response.json())
    .then((data) => {
        displayData(data);
      })
      .catch((error) => {
        console.error("Error", error);
      });
    });


// 위는 처음 페이지 접속했을 때, 지도생성 및 모든 매물 정보 출력
// 아래는 체크박스 체크 할때 마다 AJAX 통신으로
// 그 값에 맞는 매물 정보를 가져와서
// 사이드바에 출력하는 매물과 지도에 마커를 출력

  document.querySelectorAll('#s_option input, #s_type input, #state_option input').forEach(function(input) {
    input.addEventListener('change', searchEstate);
});

function searchEstate() {
    const s_option_array = [];
    document.querySelectorAll('#s_option input:checked').forEach(input => {
        s_option_array.push(input.value);
    });

    const s_type_array = [];
    document.querySelectorAll('#s_type input:checked').forEach(input => {
        s_type_array.push(input.value);
    });

    const state_option_array = [];
    document.querySelectorAll('#state_option input:checked').forEach(input => {
        state_option_array.push(input.value);
    });

    // php로 데이터 넘김
    fetch('./common/ajax.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            s_option: s_option_array,
            s_type: s_type_array,
            state_option: state_option_array
        })
    })
    // php에서 데이터 받음
    .then(response => response.json())
    // 여기서부터 지도로직
    .then(data => {
        displayData(data.results);
    })
    .catch((error) => {
      console.error("Error", error);
    });
}

let getpark = document.getElementById('getpark');

getpark.addEventListener("click", () => {

});
