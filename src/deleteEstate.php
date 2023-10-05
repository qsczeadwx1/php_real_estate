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
</head>
<body>
    <div>
    <strong>정말 매물을 삭제 하시겠습니까?
        <br>삭제하신 매물은 다시 복구가 불가능 합니다.
    </strong>
    <br>
    삭제를 진행 하시려면 삭제버튼을 눌러주세요.

    <form action="" method="post">
    <button>삭제</button>
    <input type="hidden" name="s_no" value="<?=$arr_get['s_no']?>">
    </form>
    <a href="./detailEstate.php?s_no=<?=$arr_get['s_no']?>"><button>취소</button></a>
    </div>
</body>
</html>