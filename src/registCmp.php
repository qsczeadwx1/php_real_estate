<?php
session_start();

if(isset($_SESSION['u_id'])) {
   header("Location: main.php");
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

<h2>회원가입 완료</h2>
<a href="./login.php">로그인하러 가기</a>



<?php include_once("./layout/footer.php"); ?>


</body>
</html>