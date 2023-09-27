<?php
define( "ROOT", $_SERVER["DOCUMENT_ROOT"]."/src/");
include_once(ROOT."/common/pdo.php");
session_start();

// 로그인상태면 메인으로 반환
if (isset($_SESSION["u_id"])) {
    header("Location: main.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $arr_post = $_POST;
    $id = find_user_id($arr_post["email"], $arr_post["name"]);
    
    $hash = base64_encode($id['u_id']);
    if(isset($id) && $id !== false) {
        header("Location: findUserIdCmp.php?id=".$hash."");
        exit();
    }
    else {
        $_SESSION['err_msg'] = '유효하지 않은 값입니다. 알맞은 값을 입력해 주세요.';
        header("Location: findUserId.php");
        exit();
    }

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

<div style="color:red; font-weight:900;"><?=isset($_SESSION['err_msg']) ? $_SESSION['err_msg'] : '' ?></div>
<?php unset($_SESSION['err_msg']); ?>

<h2>아이디찾기</h2>
<div>가입 할때 입력 하셨던 <br> 이메일과 이름을 입력해 주세요.</div>
<br>

<form action="./findUserId.php" method="post">
<label for="email">이메일</label>
<input type="text" id="email" name="email">
<br>
<label for="name">이름</label>
<input type="text" id="name" name="name">
<br>
<br>
<button>아이디 찾기</button>
</form>




<?php include_once("./layout/footer.php"); ?>


</body>
</html>