<?php
define( "ROOT", $_SERVER["DOCUMENT_ROOT"]."/src/");
include_once(ROOT."/common/pdo.php");
session_start();


    if($_SERVER["REQUEST_METHOD"] == "GET") {
        $arr_get = $_GET;
        $id = base64_decode($arr_get['id']);
        $question = find_user_question($id);

        switch ($question['pw_question']) {
            case '0':
                $ques = '나의 어릴적 꿈은?';
                break;
            
            case '1':
                $ques = '나의 가장 소중한 보물은?';
                break;
            
            case '2':
                $ques = '내가 가장 슬펐던 기억은?';
                break;
            
            case '3':
                $ques = '나와 가장 친한 친구는?';
                break;
            
            case '4':
                $ques = '나의 첫번째 직장의 이름은?';
                break;
            
            default:
                
                break;
        }

    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $arr_post = $_POST;
        $ques = $arr_post['pw_question'];
        $result = find_user_pw($arr_post);

        if($result) {
            header("Location: findUserPwCng.php?id=".$arr_post['u_id']."");
            exit();
        } 
        else if($result === false) {
            $_SESSION['err_msg'] = '유효하지 않은 값입니다. 알맞은 값을 입력해 주세요.';
            header("Location: findUserPwQues.php?id=".$arr_post['u_id']."");
            exit();
        } else {
            $_SESSION['err_msg'] = '예기치 못한 에러가 발생했습니다. 다시 시도해 주세요.';
            header("Location: findUserPwQues.php?id=".$arr_post['u_id']."");
            exit();
        }
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
<div style="color:red; font-weight:900;"><?=isset($_SESSION['err_msg']) ? $_SESSION['err_msg']  : '' ?></div>
<?php unset($_SESSION['err_msg']); ?>

<div>질문 : <?=$ques?></div>
<form action="./findUserPwQues.php?id=<?=isset($arr_get['id']) ? $arr_get['id'] : $arr_post['u_id']?>" method="POST">
    <label for="pw_answer">답변</label>
    <input type="text" id="pw_answer" name="pw_answer">
    <input type="hidden" name="u_id" id="u_id" value="<?=isset($arr_get['id']) ? $arr_get['id'] : $arr_post['u_id']?>">
    <input type="hidden" name="pw_question" id="pw_question" value="<?=isset($ques) ? $ques : '' ?>">
    <br>
    <button>확인</button>
</form>



<?php include_once("./layout/footer.php"); ?>


</body>
</html>