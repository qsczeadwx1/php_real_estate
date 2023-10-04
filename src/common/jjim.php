<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"] . "/src/");
include_once(ROOT . "/common/pdo.php");

header('Content-Type: application/json');
$result = get_estate_info_json();
echo $result;

?>