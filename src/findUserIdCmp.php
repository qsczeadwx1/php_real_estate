<?php
define( "ROOT", $_SERVER["DOCUMENT_ROOT"]."/src/");
include_once(ROOT."/common/pdo.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $arr_get = $_GET;
    $id = base64_decode($arr_get['id']);
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

<h1>아이디 찾기 완료</h1>
<div>아이디 : <?=isset($id) ? $id : '' ?></div>
<a href="./login.php">로그인 하러 가기</a>




<?php include_once("./layout/footer.php"); ?>


</body>
</html>