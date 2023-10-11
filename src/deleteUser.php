<?php
define( "ROOT", $_SERVER["DOCUMENT_ROOT"]."/src/");
include_once(ROOT."/common/pdo.php");
session_start();

$http_method = $_SERVER["REQUEST_METHOD"];

if ($http_method == "GET") {
    $arr_get = $_GET;
    $id = $_GET['id'];
    $result = get_s_no_info($s_no);
    $user_info = get_user_no($result['0']['u_no']);
    $u_no = get_user($_SESSION['u_id']);

    if (isset($_SESSION['u_id'])) {
        $user_no = get_user($_SESSION['u_id']);
        $wishlist = chk_wishlist($user_no['u_no'], $result['0']['s_no']);
    }

} else {
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

<h3>정말 삭제하시겠습니까?</h3>
주의! 삭제하신 정보는 복구가 불가능 합니다.
삭제를 진행 하시려면 삭제버튼을 눌러주세요.
<form action="" method="POST">
    <button>삭제</button>
    <input type="hidden" name="s_no" value="<?=$arr_get['s_no']?>">
    </form>
    <a href="./userDetail.php?id=<?=$arr_get['id']?>"><button>취소</button></a>
    </div>


<?php include_once("./layout/footer.php"); ?>


</body>
</html>