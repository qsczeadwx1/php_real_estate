<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"] . "/src/");
include_once(ROOT . "/common/pdo.php");
session_start();
$arr_get = $_GET;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    delete_estate(intval($arr_get['s_no']));
    header("Location: main.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/layout.css">
</head>

<body>
    <?php include_once("./layout/header.php"); ?>
    <div>
        <h3>정말 매물을 삭제 하시겠습니까?</h3>
        <strong>주의!</strong> 삭제하신 매물은 다시 복구가 불가능 합니다.
        <br>
        삭제를 진행 하시려면 삭제버튼을 눌러주세요.

        <form action="./deleteEstate.php" method="post">
            <button>삭제</button>
            <input type="hidden" name="s_no" value="<?= $arr_get['s_no'] ?>">
            <a href="./detailEstate.php?s_no=<?= $arr_get['s_no'] ?>"><button>취소</button></a>
        </form>
    </div>
    <?php include_once("./layout/footer.php"); ?>
</body>

</html>