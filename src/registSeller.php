<?php 
    define( "ROOT", $_SERVER["DOCUMENT_ROOT"]."/src/");
    include_once(ROOT."/common/pdo.php");

    // 로그인상태면 메인으로 반환
if(isset($_SESSION["u_id"])) {
    header("Location: main.php");
}

    $http_method = $_SERVER["REQUEST_METHOD"];

    if( $http_method === "POST" )
    {
        $arr_post = $_POST;
        $result = insert_user($arr_post);

        if ($result == 1) {
            header("Location: registCmp.php");
            exit();
        } else {
            $_SESSION['err_msg'] = "회원가입에 실패했습니다. 다시 작성해 주세요";
            header("Location: registSeller.php");
            exit();
        }
    }
    
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>펫 방</title>
    <link rel="stylesheet" href="./css/layout.css">
    <link rel="stylesheet" href="./css/registUser.css">
    <link rel="stylesheet" href="./css/layout.css">
    
</head>
<body>
    <?php include_once("./layout/header.php"); ?>
    <?php 
        if(isset($_SESSION['err_msg'])) {
        echo "<p style='color:red;'>" . $_SESSION['err_msg'] . "</p>";
        unset($_SESSION['err_msg']);
        }
         ?>

    <form action="./registSeller.php" method="post">
        <label for="id">아이디</label>
        <input type="text" id="id" name="id" required>
        <br>
        <span id="id_error" class="error_message"></span>
        <br>

        <label for="pw">비밀번호</label>
        <input type="password" id="pw" name="pw" required>
        <br>
        <span id="pw_error" class="error_message"></span>
        <br>

        <label for="pwChk">비밀번호 확인</label>
        <input type="password" id="pwChk" name="pwChk" required>
        <br>
        <span id="pwChk_error" class="error_message"></span>
        <br>

        <label for="email">이메일</label>
        <input type="text" id="email" name="email" required>
        <br>
        <span id="email_error" class="error_message"></span>
        <br>

        <label for="name">이름</label>
        <input type="text" id="name" name="name" required>
        <br>
        <span id="name_error" class="error_message"></span>
        <br>

        <label for="phone_no">전화번호</label>
        <input type="tel" name="phone_no" id="phone_no" required>
        <br>
        <span id="phone_no_error" class="error_message"></span>
        <br>

        <label for="b_name">상호명</label>
        <input type="text" id="b_name" name="b_name">
        <br>
        <span id="b_name_error" class="error_message"></span>
        <br>

        <label for="seller_license">공인중개사 라이센스</label>
        <input type="text" id="seller_license" name="seller_license" placeholder="아무숫자나 입력하셔도 됩니다.">
        <br>
        <br>
        <!-- api -->
        <label for="u_add">주소</label>
        <input type="text" id="sample6_address" name="u_add" placeholder="'주소 찾기' 버튼을 눌러서 주소를 입력하세요" readonly required>
        <button type="button" onclick="sample6_execDaumPostcode()">주소 찾기</button>
        <br>

        
        <!-- 아코디언형식 -->
        <label for="pw_question">비밀번호 찾기 전용 질문</label>
        <div class="dropdown">
        <button type="button" class="dropdown_toggle" onclick="questionDropdown()">
            비밀번호 찾기 전용 질문<span class="arrow">&#9662;</span>
        </button>
        <ul class="dropdown_menu" id="dropdownMenu">
            <li onclick="selectAnswer('0', '나의 어릴적 꿈은?')" class="form-control">나의 어릴적 꿈은?</li>
            <li onclick="selectAnswer('1', '나의 가장 소중한 보물은?')" class="form-control">나의 가장 소중한 보물은?</li>
            <li onclick="selectAnswer('2', '내가 가장 슬펐던 기억은?')" class="form-control">내가 가장 슬펐던 기억은?</li>
            <li onclick="selectAnswer('3', '나와 가장 친한 친구는?')" class="form-control">나와 가장 친한 친구는?</li>
            <li onclick="selectAnswer('4', '나의 첫번째 직장의 이름은?')" class="form-control">나의 첫번째 직장의 이름은?</li>
        </ul>
        <input type="hidden" name="pw_question" id="pw_question">
        <br>
    </div>

        <label for="pw_answer">질문 답변</label>
        <input type="text" id="pw_answer" name="pw_answer" required>
        <span id="pw_answer_error" class="error_message"></span>
        
        <br>
        <button>회원가입</button>
    </form>

    <?php include_once("./layout/footer.php"); ?>

    <script src="./js/registUser.js"></script>
    <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
</body>

</html>