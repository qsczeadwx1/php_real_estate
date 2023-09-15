<?php
include_once(__DIR__."/pdo.php");

/**
 * 함수명 : insert_user
 * 기능 : 일반, 공인중개사 유저 회원가입
 * 파라미터 : $param_arr | array
 * 리턴 값 : $result_cnt | 가입성공시 1, 실패시 0
 */
function insert_user($param_arr)
{
    $sql = " INSERT INTO "
        . " user( "
        . " u_id "
        . " ,u_password "
        . " ,email "
        . " ,name "
        . " ,phone_no "
        . " ,u_add "
        . " ,pw_question "
        . " ,pw_answer "
        . " ,created_at "
        . " ,updated_at ";
    if (isset($param_arr["seller_license"])) {
        $sql .= " ,seller_license "
            . " ,b_name ";
    } else if (isset($param_arr["animal_size"])) {
        $sql .= ",animal_size";
    }
    $sql .= " ) "
        . " VALUES( "
        . " :u_id "
        . " ,:u_password "
        . " ,:email "
        . " ,:name "
        . " ,:phone_no "
        . " ,:u_add "
        . " ,:pw_question "
        . " ,:pw_answer "
        . " ,:created_at "
        . " ,:updated_at ";
    if (isset($param_arr["seller_license"])) {
        $sql .= " ,:seller_license "
             . " ,:b_name ";
    } else if (isset($param_arr["animal_size"])) {
        $sql .= " ,:animal_size ";
    }
    $sql .= " ); ";


    $prepare = [
        ":u_id" => $param_arr["id"]
        , ":u_password" => $param_arr["pw"]
        , ":email" => $param_arr["email"]
        , ":name" => $param_arr["name"]
        , ":phone_no" => $param_arr["phone_no"]
        , ":u_add" => $param_arr["u_add"]
        , ":pw_question" => $param_arr["pw_question"]
        , ":pw_answer" => $param_arr["pw_answer"]
        , ":created_at" => date("Y-m-d H:i:s")
        , ":updated_at" => date("Y-m-d H:i:s")
    ];

    if(isset($param_arr["seller_license"])) {
        $prepare[":seller_license"] = $param_arr["seller_license"];
        $prepare[":b_name"] = $param_arr["b_name"];
    } else if(isset($param_arr["animal_size"])) {
        $prepare[":animal_size"] = $param_arr["animal_size"];
    }

    $conn = null;
    try {
        db_conn($conn);
        $conn->beginTransaction();
        $stmt = $conn->prepare($sql);
        $stmt->execute($prepare);
        $result_cnt = $stmt->rowCount();
        $conn->commit();
    } catch (Exception $e) {
        $conn->rollback();
        return $e->getMessage();
    } finally {
        $conn = null;
    }

    return $result_cnt;
}
// function insert_usera($param)
// {

//     db_conn($conn);

//     // 데이터베이스에 데이터 입력
//     try {
//         $sql = "INSERT INTO users (id, pw, email, name, ...) VALUES (:id, :pw, :email, :name, ...)";
//         $stmt = $conn->prepare($sql);

//         $stmt->bindParam(':id', $id);

//         $stmt->execute();

//         echo "회원가입 성공!";
//     } catch (PDOException $e) {
//         echo "오류: " . $e->getMessage();
//     }
// }
// 데이터베이스 연결



?>

