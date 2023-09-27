<?php
define( "ROOT", $_SERVER["DOCUMENT_ROOT"]."/src/");
include_once(ROOT."/common/pdo.php");
session_start();

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






<?php include_once("./layout/footer.php"); ?>


</body>
</html>