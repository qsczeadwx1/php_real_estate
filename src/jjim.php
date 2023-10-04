<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"] . "/src/");
include_once(ROOT . "/common/pdo.php");
session_start();
$http_method = $_SERVER["REQUEST_METHOD"];

if($http_method == "POST") {
    $arr_post = $_POST;

    if(!isset($_SESSION['u_id'])) {
        header("Location: login.php");
        exit();
    }
    $user_no = get_user($_SESSION['u_id']);
    $wishlist = chk_wishlist($user_no['u_no'], $arr_post['s_no']);

    if($wishlist === null) {
        insert_wishlist($user_no['u_no'], $arr_post['s_no']);
        header("Location: detailEstate.php?s_no=".$arr_post['s_no']."");
        exit();
    } else if($wishlist) {
        delete_wishlist($user_no['u_no'], $arr_post['s_no']);
        header("Location: detailEstate.php?s_no=".$arr_post['s_no']."");
        exit();
    } else {
        header("Location: detailEstate.php?s_no=".$arr_post['s_no']."");
        exit();
    }
}

?>