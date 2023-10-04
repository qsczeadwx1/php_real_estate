<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"] . "/src/");
include_once(ROOT . "/common/pdo.php");
session_start();

// 로그인상태가 아니라면 메인으로 반환
if (!isset($_SESSION["u_id"])) {
    header("Location: main.php");
}

$user_info = get_user($_SESSION["u_id"]);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 회원정보수정
    $arr_post = $_POST;
    $pattern_email = '/^[\w.-]+@[a-zA-Z\d.-]+\.[a-zA-Z]{2,}$/';
    $pattern_phone_no = '/^\d{10,11}$/';

    if (!preg_match($pattern_email, $arr_post['email'])) {
        $_SESSION['err_msg'] = '유효하지 않은 이메일 값입니다. 다시 입력해 주세요';
        header("Location: userDetail.php?id=" . $arr_post['u_id'] . "");
        exit();
    }
    if (!preg_match($pattern_phone_no, $arr_post['phone_no'])) {
        $_SESSION['err_msg'] = '유효하지 않은 전화번호 입니다. 다시 입력해 주세요.';
        header("Location: userDetail.php?id=" . $_SESSION["u_id"] . "");
        exit();
    }

    $result = change_user_info($arr_post);
    if ($result == 1) {
        $_SESSION['err_msg'] = '성공적으로 정보가 수정되었습니다.';
        header("Location: userDetail.php?id=" . $_SESSION["u_id"] . "");
        exit();
    }
}

if(isset($_SESSION['seller_license'])) {
    $estate_info = get_s_info_indiv($user_info['u_no']);
} else {
    
}


?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>펫방</title>
    <link rel="stylesheet" href="./css/layout.css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/tiny-slider.css" />
    <link rel="stylesheet" href="./css/aos.css" />
    <link rel="stylesheet" href="./css/style.css" />
</head>

<body>
    <?php include_once("./layout/header.php"); ?>
    <div style="margin-left:10px;">
    <h3>회원정보수정</h3>
    <div>ID : <?= $user_info['u_id'] ?></div>
    <br>
    <div>이름 : <?= $user_info['name'] ?></div>
    <br>

    <div style="color:red; font-weight:900;"><?= isset($_SESSION['err_msg']) ? $_SESSION['err_msg']  : '' ?></div>
    <?php unset($_SESSION['err_msg']); ?>
    <form action="./userDetail.php?id=<?= $_SESSION["u_id"] ?>" method="POST">
        <label for="email">이메일 : </label>
        <input type="text" name="email" id="email" value="<?= $user_info['email'] ?>">
        <br>
        <label for="phone_no">전화번호 : </label>
        <input type="text" name="phone_no" id="phone_no" value="<?= $user_info['phone_no'] ?>">
        <br>
        <input type="hidden" name="u_id" value="<?= $_SESSION["u_id"] ?>">
        <button>수정</button>
    </form>
    </div>
    <hr style="color:black;">



    <?php if (isset($_SESSION["seller_license"])) { ?>
        <h3 style="margin-left:10px;">내가 올린 매물</h3>
    <div class="section">
        <div class="container" style="max-width:75%;">
            <div class="row">
                <div class="col-12" style="padding:0">
                    <?php
                    $i = 1;
                    foreach ($estate_info as $val) {
                    ?>
                        <div class="property-item" style="display:inline-block;">
                            <a href="./detailEstate.php?s_no=<?= $val['s_no'] ?>" class="img">
                                <img src="./upload/img_<?= $i;
                                                        $i++ ?>.jpg" alt="Image" class="img-fluid" style="width: 350px; height: 300px; margin-bottom: 50px;" />
                            </a>

                            <div class="property-content">
                                <div class="price mb-2">
                                    <a href="{{route('struct.detail',['s_no'=>$photo->s_no])}}">
                                        <span>
                                            <?= $val['s_name'] ?>
                                        </span>
                                    </a>
                                </div>
                                <div>
                                    <span class="d-block mb-2 text-black-50"><?= $val['s_add'] ?></span>
                                    <span class="city d-block mb-3"><?= number_format($val['p_deposit']); ?>
                                        <?= isset($val['p_month']) ? ' / ' . $val['p_month'] : null ?>
                                    </span>

                                    <div class="specs d-flex mb-4">
                                        <span class="d-block d-flex align-items-center me-3">
                                            <span class="icon-building me-2"></span>
                                            <span class="caption"><?php
                                                                    switch ($val['s_option']) {
                                                                        case '0':
                                                                            echo '아파트';
                                                                            break;
                                                                        case '1':
                                                                            echo '단독주택';
                                                                            break;
                                                                        case '2':
                                                                            echo '오피스텔';
                                                                            break;
                                                                        case '3':
                                                                            echo '빌라';
                                                                            break;
                                                                        case '4':
                                                                            echo '원룸';
                                                                            break;

                                                                        default:
                                                                            break;
                                                                    } ?></span>
                                        </span>
                                        <span class="d-block d-flex align-items-center">

                                            <span class="fa-solid fa-dog me-2"></span>
                                            <span class="caption"> 대형동물
                                                <strong><?= $val['animal_size'] == 1 ? 'O' : 'X' ?></strong>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <?php } else {?>
    <div style="margin-left:10px;">
    <h3>찜한 매물</h3>
    </div>
    <?php } ?>

    <?php include_once("./layout/footer.php"); ?>

    <script src="https://kit.fontawesome.com/e615ee2f7e.js" crossorigin="anonymous"></script>
    <!-- <script src="./js/bootstrap.bundle.min.js"></script> -->
    <script src="./js/tiny-slider.js"></script>
    <script src="./js/aos.js"></script>
    <script src="./js/counter.js"></script>
    <script src="./js/custom.js"></script>
</body>

</html>