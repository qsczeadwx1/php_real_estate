<?php
session_start();

if(isset($_SESSION['u_id'])) {
   header("Location: main.php");
}
?>

<!DOCTYPE html>
<html lang="ko">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>회원가입</title>
   <link rel="stylesheet" href="./css/layout.css">
   <link rel="stylesheet" href="./css/regist.css">
</head>

<body>
   <?php include_once("./layout/header.php"); ?>

   <h1>회원가입</h1>
   <h4>일반회원과 공인중개사 중 하나를 선택하세요.</h4>
   <ul>
      <li id="show_user" class="regist_option">일반회원</li>
      <li id="show_seller" class="regist_option">공인중개사</li>
   </ul>
   <div id="user_regist" class="display_none">
      <h3>일반회원 약관</h3>

      <?php include_once("./layout/termsUser.php"); ?>
      <br>
      <label>
         <input type="checkbox" id="userCheckbox" disabled>
         약관에 동의합니다.
      </label>
      <br>
      <a href="./registUser.php" id="registUser"><button>회원가입</button></a>
   </div>

   <div id="seller_regist" class="display_none">
      <h3>공인중개사 약관</h3>

      <?php include_once("./layout/termsSeller.php"); ?>
      <br>
      <label>
         <input type="checkbox" id="sellerCheckbox" disabled required>
         약관에 동의합니다.
      </label>
      <br>
      
      <a href="./registSeller.php" id="registSeller"><button>회원가입</button></a>
   </div>

   <?php include_once("./layout/footer.php"); ?>

   <script src="./js/regist.js"></script>
</body>

</html>