<?php
define( "ROOT", $_SERVER["DOCUMENT_ROOT"]."/src/");
include_once(ROOT."/common/pdo.php");

$http_method = $_SERVER["REQUEST_METHOD"];

    if($http_method == "GET") {
        $s_no = $_GET['s_no'];
        $result = get_s_no_info($s_no);

    } else {
        header("Location: main.php");
    }

?>



<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php var_dump($result);?>
    <div style="display:flex;">
    <div>asdf</div>
    <div>zxcv</div>
    </div>
</body>
</html>