<?php
define( "ROOT", $_SERVER["DOCUMENT_ROOT"]."/src/");
include_once(ROOT."/common/pdo.php");
session_start();
if(!isset($_SESSION['u_id'])) {
    header("Location: main.php");
    exit;
} 


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $s_no = $_GET['s_no'];
    $result = get_s_no_info($s_no);
    $u_no = get_user($_SESSION['u_id']);
    if($result[0]['u_no'] != $u_no['u_no']) {
        header("Location: main.php");
        exit;
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $arr_post = $_POST;
    $s_no = $arr_post['s_no'];
    $result = get_s_no_info($s_no);
    $arr_post["u_id"] = $_SESSION["u_id"];
    
    // 유효성검사
    if($arr_post['s_option'] == 'n') {
        $_SESSION['err_msg'] = "건물유형을 선택해서 작성해 주세요!";
        header("Location: updateEstate.php?s_no=".$s_no."");
        exit;
    }
    if($arr_post['s_type'] == 'n') {
        $_SESSION['err_msg'] = "매매유형을 선택해서 작성해 주세요!";
        header("Location: updateEstate.php?s_no=".$s_no."");
        exit;
    }

    if($arr_post['s_type'] == '2' && $arr_post['p_month'] == '') {
        $_SESSION['err_msg'] = "월세를 입력해 주세요!";
        header("Location: updateEstate.php?s_no=".$s_no."");
        exit;
    }

    if($arr_post['s_type'] == '0' && !$arr_post['p_month'] == '') {
        $_SESSION['err_msg'] = "매매는 월세가 없습니다!";
        header("Location: updateEstate.php?s_no=".$s_no."");
        exit;
    }
    if($arr_post['p_month'] == '' || $arr_post['p_month'] == 0) {
        $arr_post['p_month'] = NULL;
    }
    update_estate($arr_post);
    header("Location: detailEstate.php?s_no=".$s_no."");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>펫방</title>
    <link rel="stylesheet" href="./css/layout.css">
</head>

<body>
<?php include_once("./layout/header.php"); ?>
<?php 
        
        if(isset($_SESSION['err_msg'])) {
        echo "<p style='color:red;'>" . $_SESSION['err_msg'] . "</p>";
        unset($_SESSION['err_msg']);
        }
         ?>
         <h3>매물 정보 수정</h3>

    <form action="./updateEstate.php?s_no=<?=$s_no?>" id="frm" method="post">
        <input type="hidden" name="s_no" value="<?=$s_no?>">
        <label for="s_name">건물이름</label>
        <input type="text" name="s_name" id="s_name" value="<?=$result[0]['s_name']?>">
        <br>
        <label for="s_option">건물형태</label>
        <select name="s_option" id="s_option">
            <option value="n">건물유형을 선택해 주세요</option>
            <option value="0" <?=$result[0]['s_option'] == 0 ? 'selected' : ''?>>아파트</option>
            <option value="1" <?=$result[0]['s_option'] == 1 ? 'selected' : ''?>>단독주택</option>
            <option value="2" <?=$result[0]['s_option'] == 2 ? 'selected' : ''?>>오피스텔</option>
            <option value="3" <?=$result[0]['s_option'] == 3 ? 'selected' : ''?>>빌라</option>
            <option value="4" <?=$result[0]['s_option'] == 4 ? 'selected' : ''?>>원룸</option>
        </select>
        <br>
        <label for="s_type">매매유형</label>
        <select name="s_type" id="s_type">
            <option value="n">매매유형을 선택해 주세요</option>
            <option value="0" <?=$result[0]['s_type'] == 0 ? 'selected' : ''?>>매매</option>
            <option value="1" <?=$result[0]['s_type'] == 1 ? 'selected' : ''?>>전세</option>
            <option value="2" <?=$result[0]['s_type'] == 2 ? 'selected' : ''?>>월세</option>
        </select>
        <br>
        <label for="s_size">평수</label>
        <input type="number" name="s_size" id="s_size" value="<?=$result[0]['s_size']?>">
        <br>
        <label for="s_fl">층수</label>
        <input type="number" name="s_fl" id="s_fl" value="<?=$result[0]['s_fl']?>">
        <br>
        <label for="s_stai">근처 지하철역</label>
        <input type="text" name="s_stai" id="s_stai" value="<?=$result[0]['s_stai']?>">
        <br>
        <label for="p_deposit">매매 / 전세금</label>
        <input type="number" name="p_deposit" id="p_deposit" value="<?=$result[0]['p_deposit']?>">
        <br>
        <label for="p_month">월세</label>
        <input type="number" name="p_month" id="p_month" value="<?=isset($result[0]['p_month']) ? $result[0]['p_month'] : '' ?>">
        <br>
        <label for="animal_size">대형동물 가능여부</label>
        <input type="checkbox" name="animal_size" id="animal_size" value="1" <?=$result[0]['animal_size'] == 1 ? 'checked' : '' ?>>
        <br>
        <label for="s_parking">주차가능 여부</label>
        <input type="checkbox" name="s_parking" id="s_parking" value="1" <?=$result[0]['s_parking'] == 1 ? 'checked' : '' ?>>
        <label for="s_ele">엘리베이터 여부</label>
        <input type="checkbox" name="s_ele" id="s_ele" value="1" <?=$result[0]['s_ele'] == 1 ? 'checked' : '' ?>>
        <br>
        <button>매물 올리기</button>
        <a href="./detailEstate.php?s_no=<?=$s_no?>"><button type="button">취소</button></a>
    </form>




    <?php include_once("./layout/footer.php"); ?>
    <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=c3af763d949f96c4cc8cca5e5762703f&libraries=services,clusterer,drawing"></script>
    <script src="./js/registEstate.js"></script>
    <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    <script src="./js/geo.js"></script>
</body>
</html>