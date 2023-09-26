var geocoder = new kakao.maps.services.Geocoder();
const val = document.getElementById("sample6_address");

val.addEventListener('click', () => {
  var s_log = document.getElementById("s_log");
  var s_lat = document.getElementById("s_lat");
  var callback = function (result, status) {
    if (status === kakao.maps.services.Status.OK) {
      console.log(s_lat.value);
      console.log(s_log.value);

      s_lat.value = result[0]["x"];
      s_log.value = result[0]["y"];
    }
  };
  geocoder.addressSearch(val.value, callback);
});
