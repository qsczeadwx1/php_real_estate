<div class="header">
    <span>로고</span>
    <a href="./main.php">메인</a>
    <a href="./map.php">지도</a>
    
    <span class="header_a">
    <?php // 로그인 안했을때 
    if(!isset($_SESSION["u_id"])) { ?>
        <a href='./login.php'>로그인</a>
        <a href='./regist.php'>회원가입</a>
        <?php } 
    // 일반 유저일때
        elseif(isset($_SESSION["u_id"]) && !isset($_SESSION["seller_license"]))
        { ?>
            <a href='./userDetail.php?id=<?=$_SESSION["u_id"]?>'><?=$_SESSION["u_id"]?></a>
            <!-- <a href='/user/'>마이페이지</a> -->
            <a href='./logout.php'>로그아웃</a>
        <?php }
    // 공인중개사 일때
        elseif(isset($_SESSION["seller_license"]))
        { ?>
            <a href='./registEstate.php'>매물올리기</a>
            <a href='./userDetail.php?id=<?=$_SESSION["u_id"]?>'><?=$_SESSION["u_id"]?>님</a>
            <!-- <a href='/user/'>마이페이지</a> -->
            <a href='./logout.php'>로그아웃</a>
        <?php } ?>
    </div>
    </span>