<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"] . "/src/");
include_once(ROOT . "/common/pdo.php");
session_start();
$http_method = $_SERVER["REQUEST_METHOD"];

if ($http_method == "GET") {
    $s_no = $_GET['s_no'];
    $result = get_s_no_info($s_no);
    $user_info = get_user_no($result['0']['u_no']);
    $user_no['u_no'] = [];

    if (isset($_SESSION['u_id'])) {
        $user_no = get_user($_SESSION['u_id']);
        $wishlist = chk_wishlist($user_no['u_no'], $result['0']['s_no']);
    }

} else {
    header("Location: main.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/detail.css">
    <link rel="stylesheet" href="./css/layout.css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <style>
        .contents {
            text-align: left;
        }
    </style>
</head>

<body>
    <?php include_once("./layout/header.php"); ?>
    <div>
        <div id="scroll-container" class="scroll-item">
            <img id="btn1" style="z-index:10" src="./img/arrow-up-solid.png">
            <br>
            <img id="btn3" style="z-index:10" src="./img/arrow-down-solid.png">
            <div id="photo">
                <?php for ($i = 0; $i < count($result); $i++) {
                    echo '<img class="photo-item" src="' . $result[$i]['url'] . '" alt="사진">';
                } ?>
            </div>
        </div>
        <br>
        <br>

        <?php if($result['0']['u_no'] == $user_no['u_no']) {
        echo '<a href="./updateEstate.php?s_no='.$s_no.'">매물수정하기</a>';
    } ?>
        <?php if($result['0']['u_no'] == $user_no['u_no']) {
        echo '<a href="./deleteEstate.php?s_no='.$s_no.'">매물삭제하기</a>';
    } ?>

        <h1 class="dark:text-white">건물 정보</h1>
        <div style="margin-left: 30px">
            <form action="./jjim.php" method="POST">
                <button class="icon-heart-empty wish" id="empty_heart" style="<?= isset($wishlist) ? 'display:none;' : ''; ?>; background: none; border: none; cursor:pointer;"></button>
                <button class="icon-heart wish" id="full_heart" style="<?= isset($wishlist) ? '' : 'display:none;'; ?>; background: none; border: none; cursor:pointer;"></button>
                <input type="hidden" name="s_no" value="<?= isset($result['0']['s_no']) ? $result['0']['s_no'] : '' ?>">
            </form>

            <div class="contents">
                건물 이름 : <?= $result['0']['s_name'] ?>
            </div>
            <div class="contents">
                건물 주소 : <?= $result['0']['s_add'] ?>
            </div>
            <div class="contents">
                판매 유형 : <?php
                        switch ($result['0']['s_type']) {
                            case '0':
                                echo '매매';
                                break;
                            case '1':
                                echo '전세';
                                break;
                            case '2':
                                echo '월세';
                                break;
                        }
                        ?>
            </div>
            <div class="contents">
                건물 유형 : <?php
                        switch ($result['0']['s_option']) {
                            case '0':
                                echo '아파트';
                                break;
                            case '1':
                                echo '단독주택';
                                break;
                            case '2':
                                echo '오피스텔';
                                break;
                            case '3':
                                echo '빌라';
                                break;
                            case '4':
                                echo '원룸';
                                break;

                            default:
                                break;
                        } ?>
            </div>
            <div class="contents">
                평수 : <?= $result['0']['s_size'] ?>
            </div>
            <div class="contents">
                층수 : <?= $result['0']['s_fl'] ?>
            </div>
            <div class="contents">
                근처역 : <?= $result['0']['s_stai'] ?>
            </div>
            <div class="contents">
                보증금 or 매매가: <?= number_format($result['0']['p_deposit']) ?>
            </div>
            <div class="contents">
                월세 or 관리비: <?= number_format($result['0']['p_month']) ?>
            </div>
            <div class="contents">
                대형동물 가능 여부 :
                <?= $result['0']['animal_size'] == '1' ? '가능' : 'X' ?>
            </div>
            <div class="contents">
                주차가능 여부 :
                <?= $result['0']['s_parking'] == '1' ? 'O' : 'X' ?>
            </div>
            <div class="contents">
                엘레베이터 여부 :
                <?= $result['0']['s_ele'] == '1' ? 'O' : 'X' ?>
            </div>
        </div>
        <div id="detail">
            <div id="proimg"><img src="https://search.pstatic.net/sunny/?src=https%3A%2F%2Fi.pinimg.com%2Foriginals%2F92%2Faf%2F2f%2F92af2fec0dfc6e661ee8a2cdd114e14b.jpg&type=a340" alt="중개인 얼굴"></div>
            <div class="font-bold">판매자 : <?= $user_info['name'] ?></div>
            <div class="font-bold">부동산 : <?= $user_info['b_name'] ?></div>
            <x-button type="button" id="btn2" class="dark:text-white">연락처 보기</x-button>
        </div>
        <br>
        <br>
        <br>
        <a id="bottom"></a>
        <h1 class="dark:text-white">위치</h1>
        <div id="map" style="width: 500px; height: 400px; margin-left:30px; margin-bottom:30px;"></div>

        <?php include_once("./layout/footer.php"); ?>

        <script src="https://kit.fontawesome.com/e615ee2f7e.js" crossorigin="anonymous"></script>
        <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=c3af763d949f96c4cc8cca5e5762703f&libraries=services,clusterer,drawing"></script>
        <script>
            var container = document.getElementById('map');
            var options = {
                center: new kakao.maps.LatLng(<?= $result['0']['s_log'] ?>, <?= $result['0']['s_lat'] ?>),
                level: 5
            };

            var map = new kakao.maps.Map(container, options);

            var position = new kakao.maps.LatLng(<?= $result['0']['s_log'] ?>, <?= $result['0']['s_lat'] ?>); // 마커가 표시될 위치를 설정합니다
            var iwContent = '<div style="padding: 5px;">' + '<?= $result['0']['s_name'] ?>' + '</div>'; // 인포윈도우에 표시될 내용입니다

            // 마커를 생성합니다
            var marker = new kakao.maps.Marker({
                map: map,
                position: position
            });

            // 인포윈도우를 생성합니다
            var infowindow = new kakao.maps.InfoWindow({
                content: iwContent
            });
            // 인포윈도우를 마커 위에 표시합니다
            infowindow.open(map, marker);

            const btn1 = document.getElementById("btn1");
            const btn3 = document.getElementById("btn3");

            btn1.addEventListener("click", () => {
                window.scrollTo(0, 0);
            });

            btn3.addEventListener("click", () => {
                window.scrollTo(0, document.body.scrollHeight);
            });
        </script>

</body>

</html>