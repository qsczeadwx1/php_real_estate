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
    
    $id = get_user($arr_post['u_id']);

    if(isset($id) && $id !== false) {
        $hash = base64_encode($id['u_id']);
        header("Location: findUserPwQues.php?id=".$hash."");
        exit();
    }
    else {
        $_SESSION['err_msg'] = '유효하지 않은 값입니다. 알맞은 값을 입력해 주세요.';
        header("Location: findUserPw.php");
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

<div style="color:red; font-weight:900;"><?=isset($_SESSION['err_msg']) ? $_SESSION['err_msg']  : '' ?></div>
<?php unset($_SESSION['err_msg']); ?>
    
<h2>비밀번호 찾기</h2>


<div>ID를 입력해 주세요.</div>
<div>ID 확인 후, 회원가입시 입력 했던 질문과 답변으로 이동합니다.</div>
<br>

<form action="./findUserPw.php" method="post">
<label for="u_id">ID : </label>
<input type="text" id="u_id" name="u_id">
<br>
<br>
<button>확인</button>
</form>




<?php include_once("./layout/footer.php"); ?>


</body>
</html>