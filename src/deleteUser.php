<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"] . "/src/");
include_once(ROOT . "/common/pdo.php");
session_start();

if (!isset($_SESSION['u_id'])) {
    header("Location: main.php");
    exit();
}

$http_method = $_SERVER["REQUEST_METHOD"];

if ($http_method == "GET") {
    $arr_get = $_GET;
    $id = $_GET['id'];
    $get_user = get_user($id);
    var_dump(count(get_s_info_indiv($get_user['u_no'])));
    var_dump(get_s_info_indiv($get_user['u_no'])['0']['s_no']);
} else if ($http_method == "POST") {
    $arr_post = $_POST;
    $id = $_POST['id'];

    $get_user = get_user($id);
    delete_user($get_user['u_no']);
    session_destroy();
    header("Location: main.php");
    exit();
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

    <h3>정말 아이디를 삭제 하시겠습니까?</h3>
    <strong>주의!</strong> 삭제하신 정보는 복구가 불가능 합니다.
    <br>
    삭제를 진행 하시려면 삭제버튼을 눌러주세요.
    <form action="./deleteUser.php" method="POST">
        <button>삭제</button>
        <input type="hidden" name="id" value="<?= $arr_get['id'] ?>">
    </form>
    <a href="./userDetail.php?id=<?= $arr_get['id'] ?>"><button>취소</button></a>
    </div>


    <?php include_once("./layout/footer.php"); ?>


</body>

</html>