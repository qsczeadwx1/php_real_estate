<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"] . "/src/");
include_once(ROOT . "/common/pdo.php");
session_start();

// 로그인상태면 메인으로 반환
if (isset($_SESSION["u_id"])) {
    header("Location: main.php");
}

// 로그인성공하면 세션에 u_id를 담고 메인으로
// 공인중개사면, 라이센스 번호까지 담아서,
// 실패하면 에러메세지
$http_method = $_SERVER["REQUEST_METHOD"];

if ($http_method == "POST") {
    $arr_post = $_POST;
    $login = login_user($arr_post);
    if ($login) {
        session_start();
        $user = get_user($arr_post["id"]);
        $_SESSION["u_id"] = $user["u_id"];

        if (isset($user["seller_license"])) {
            $_SESSION["seller_license"] = $user["seller_license"];
        }

        header("Location: main.php");
        exit();
    } else {
        $_SESSION["login_error"] = $login;
        header("Location: login.php");
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
    <?php if (isset($_SESSION["login_error"])) {
        echo "<p style='color:red;'>" . $_SESSION["login_error"] . "</p>";
        unset($_SESSION["login_error"]);
    }
    ?>
    <form action="./login.php" method="post">
        <label for="id">아이디</label>
        <input type="text" name="id" id="id">
        <br>
        <label for="pw">비밀번호</label>
        <input type="password" name="pw" id="pw">
        <br>
        <button>로그인</button>
        <br>
    </form>
    <a href="./regist.php">아직 회원이 아니신가요?</a>


    <?php include_once("./layout/footer.php"); ?>


</body>

</html>