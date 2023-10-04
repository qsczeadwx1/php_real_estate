<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"] . "/src/");
include_once(ROOT . "/common/pdo.php");
session_start();


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $arr_get = $_GET;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $arr_post = $_POST;

    $password = $_POST['pw'];
    $pattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W]).{8,20}$/';

    if ($arr_post['pw'] != $arr_post['pw_chk']) {
        $_SESSION['err_msg'] = '비밀번호가 일치하지 않습니다. 다시 입력해 주세요.';
        header("Location: findUserPwCng.php?id=" . $arr_post['u_id'] . "");
        exit();
    }
    if (!isset($arr_post['pw'])) {
        $_SESSION['err_msg'] = '값을 입력하지 않았습니다. 값을 입력해 주세요';
        header("Location: findUserPwCng.php?id=" . $arr_post['u_id'] . "");
        exit();
    }

    if (preg_match($pattern, $arr_post['pw'])) {
        $result = change_user_pw($arr_post);
        if ($result == 1) {
            header("Location: findUserPwCmp.php");
            exit();
        } else {
            $_SESSION['err_msg'] = '비밀번호를 변경하는 중 에러가 발생했습니다. 값을 다시한번 확인해 주세요.';
            header("Location: findUserPwCng.php?id=" . $arr_post['u_id'] . "");
            exit();
        }
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

    <div>비밀번호 변경</div>
    <div>비밀번호는 대문자, 소문자, 숫자, 특수문자를 포함한<br>
        8 ~ 20 자 사이로 입력해 주세요.
    </div>
    <br>
    <div style="color:red; font-weight:900;"><?= isset($_SESSION['err_msg']) ? $_SESSION['err_msg']  : '' ?></div>
    <?php unset($_SESSION['err_msg']); ?>

    <form action="./findUserPwCng.php?id=<?= isset($arr_get['id']) ? $arr_get['id'] : $arr_post['u_id'] ?>" method="POST">

        <label for="pw">비밀번호</label>
        <input type="password" id="pw" name="pw">
        <br>
        <label for="pw_chk">비밀번호 확인</label>
        <input type="password" id="pw_chk" name="pw_chk">
        <br>
        <input type="hidden" name="u_id" value="<?= isset($arr_get['id']) ? $arr_get['id'] : $arr_post['u_id'] ?>">
        <button>확인</button>
    </form>




    <?php include_once("./layout/footer.php"); ?>


</body>

</html>