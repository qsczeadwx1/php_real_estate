<?php
define( "ROOT", $_SERVER["DOCUMENT_ROOT"]."/src/");
include_once(ROOT."/common/pdo.php");
session_start();

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

<div>비밀번호 변경이 완료 되었습니다.</div>
<div>다시 로그인 해 주세요.</div>
<a href="./login.php">로그인하러 가기</a>




<?php include_once("./layout/footer.php"); ?>


</body>
</html>