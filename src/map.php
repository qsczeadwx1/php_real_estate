<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"] . "/src/");
include_once(ROOT . "/common/pdo.php");
session_start();

$result = get_estate_info();


?>




<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>펫방</title>
    <link rel="stylesheet" href="./css/layout.css">
    <style>
        .flex {
            display: flex;
        }
    </style>
</head>
<body>
<?php include_once("./layout/header.php"); ?>
<div class="flex">
    <div style="width: 400px;">asdfasaaaaaaaaaaaaaaaaaa</div>
    <div id="map" style="width: 1000px; height: 800px;"></div>

</div>



<?php include_once("./layout/footer.php"); ?>

<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=c3af763d949f96c4cc8cca5e5762703f&libraries=services,clusterer,drawing"></script>
<script src="./js/map.js"></script>
</body>
</html>