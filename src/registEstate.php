<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"] . "/src/");
include_once(ROOT . "/common/pdo.php");

// 공인중개사로 로그인 상태가 아니면 메인으로
if (isset($_SESSION["seller_license"])) {
    header("Location: main.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    $arr_post = $_POST;
    $img_post = $_FILES;
    $arr_post["u_id"] = $_SESSION["u_id"];
    $ext = array('jpg', 'png');
    $upload_dir = "./upload/";
    $min_img = 5;
    $max_img = 10;

    // 파일 개수 확인
    $img_count = count($_FILES['estate_img']['name']);
    if ($img_count < $min_img || $img_count > $max_img) {
        echo "파일은" . $min_img . "개에서 " . $max_img . "개 사이로 업로드해 주세요.";
        exit;
    }

    // 파일 확장자 체크
    for ($i = 0; $i < $img_count; $i++) {
        $file_ext = strtolower(pathinfo($_FILES['estate_img']['name'][$i], PATHINFO_EXTENSION));

        if (!in_array($file_ext, $ext)) {
            echo "파일 확장자는 jpg 또는 png만 허용됩니다.";
            exit;
        }
    }

    // 이미지 서버에 저장및 url저장
    for ($i = 0; $i < $img_count; $i++) {
        $filename = pathinfo($_FILES['estate_img']['name'][$i], PATHINFO_FILENAME);
        $img_name = $filename . time() . "." . $file_ext;
        $target_file = $upload_dir . basename($img_name);
        $img_post['estate_img']['url'][$i] = $target_file;
        move_uploaded_file($_FILES['estate_img']['tmp_name'][$i], $target_file);
    }
    
    $result = insert_estate($arr_post, $img_post);
    header("Location: detailEstate.php?s_no=".$result);

}


?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>펫방</title>
</head>

<body>
    <?php include_once("./layout/header.php"); ?>

    <form action="./registEstate.php" id="frm" method="post" enctype="multipart/form-data">
        <label for="estate_img">건물사진</label>
        <input type="file" name="estate_img[]" id="estate_img" multiple>
        <br>
        <label for="s_name">건물이름</label>
        <input type="text" name="s_name" id="s_name">
        <br>
        <label for="s_option">건물형태</label>
        <select name="s_option" id="s_option">
            <option value="0">아파트</option>
            <option value="1">단독주택</option>
            <option value="2">오피스텔</option>
            <option value="3">빌라</option>
            <option value="4">원룸</option>
        </select>
        <br>
        <label for="s_type">매매형태</label>
        <select name="s_type" id="s_type">
            <option value="0">매매</option>
            <option value="1">전세</option>
            <option value="2">월세</option>
        </select>
        <br>
        <label for="s_size">평수</label>
        <input type="number" name="s_size" id="s_size">
        <br>
        <label for="s_fl">층수</label>
        <input type="number" name="s_fl" id="s_fl">
        <br>
        <label for="s_stai">근처 지하철역</label>
        <input type="text" name="s_stai" id="s_stai">
        <br>
        <label for="s_add">주소</label>
        <input type="text" id="sample6_address" name="s_add" placeholder="'주소 찾기' 버튼을 눌러서 주소를 입력하세요" readonly required>
        <button type="button" onclick="sample6_execDaumPostcode()">주소 찾기</button>
        <br>
        <br>
        <input type="hidden" name="s_log" id="s_log">
        <input type="hidden" name="s_lat" id="s_lat">

        <label for="p_deposit">매매 / 전세금</label>
        <input type="number" name="p_deposit" id="p_deposit">
        <br>
        <label for="p_month">월세</label>
        <input type="number" name="p_month" id="p_month">
        <br>
        <label for="animal_size">대형동물 가능여부</label>
        <input type="checkbox" name="animal_size" id="animal_size" value="1">
        <br>
        <label for="s_parking">주차가능 여부</label>
        <input type="checkbox" name="s_parking" id="s_parking" value="1">
        <label for="s_ele">엘리베이터 여부</label>
        <input type="checkbox" name="s_ele" id="s_ele" value="1">
        <br>
        <button>매물 올리기</button>

    </form>




    <?php include_once("./layout/footer.php"); ?>
    <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=c3af763d949f96c4cc8cca5e5762703f&libraries=services,clusterer,drawing"></script>
    <script src="./js/registEstate.js"></script>
    <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    <script src="./js/geo.js"></script>
</body>

</html>