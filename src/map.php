<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"] . "/src/");
include_once(ROOT . "/common/pdo.php");
session_start();

?>




<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>펫방</title>
    <link rel="stylesheet" href="./css/layout.css">
    <link rel="stylesheet" href="./css/map.css">

</head>

<body>
    <?php include_once("./layout/header.php"); ?>
    <div class="contents">
        <div class="container1">
            <div class="sidebar" id="sidebar" style="width: 400px;"></div>

            <div id="map" style="width: 1000px; height: 800px;">
                <div class="nav-container">
                    <nav class="nav justify-content-end p-3" style="background-color: #9fafc4;">

                        <button class="walk-btn" id="getpark">
                            <i class="fa-solid fa-seedling fa-2x"></i>
                            <p>공원</p>
                        </button>
                        <select id="option" name="gu" class="selectbox">
                            <option>구 선택</option>
                            <option value="달서구">달서구</option>
                            <option value="달성군">달성군</option>
                            <option value="동구">동구</option>
                            <option value="서구">서구</option>
                            <option value="남구">남구</option>
                            <option value="북구">북구</option>
                            <option value="수성구">수성구</option>
                            <option value="중구">중구</option>
                        </select>

                        <div id="search_checkbox">
                            <div id="s_option">
                            <span>건물형태</span>
                            <label for="s_option_1">| 아파트 </label>
                            <input type="checkbox" name="s_option" id="s_option_1" class="s_option" value="0">
                            <label for="s_option_2">| 단독주택 </label>
                            <input type="checkbox" name="s_option" id="s_option_2" class="s_option" value="1">
                            <label for="s_option_3">| 오피스텔</label>
                            <input type="checkbox" name="s_option" id="s_option_3" class="s_option" value="2">
                            <label for="s_option_4">| 빌라</label>
                            <input type="checkbox" name="s_option" id="s_option_4" class="s_option" value="3">
                            <label for="s_option_5">| 원룸</label>
                            <input type="checkbox" name="s_option" id="s_option_5" class="s_option" value="4">
                            </div>
                            <div id="s_type">
                                <span>거래유형</span>
                                <label for="s_type_1">| 매매</label>
                                <input type="checkbox" name="s_type" id="s_type_1" class="s_type" value="0">
                                <label for="s_type_2">| 전세</label>
                                <input type="checkbox" name="s_type" id="s_type_2" class="s_type" value="1">
                                <label for="s_type_3">| 월세</label>
                                <input type="checkbox" name="s_type" id="s_type_3" class="s_type" value="2">
                            </div>
                            <div id="state_option">
                                <span>건물옵션</span>
                                <label for="state_option_1">| 주차가능여부</label>
                                <input type="checkbox" name="state_option" id="state_option_1" value="s_parking">
                                <label for="state_option_2">| 엘리베이터여부</label>
                                <input type="checkbox" name="state_option" id="state_option_2" value="s_ele">
                            </div>
                        </div>
                    </nav>
                </div>
            </div>

        </div>
    </div>

    <?php include_once("./layout/footer.php"); ?>

    <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=c3af763d949f96c4cc8cca5e5762703f&libraries=services,clusterer,drawing"></script>
    <script src="./js/map.js"></script>
</body>

<script>
    

</script>
</html>