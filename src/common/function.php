<?php
include_once(__DIR__ . "/pdo.php");

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

    // 비밀번호 해싱
    $password = password_hash($param_arr["pw"], PASSWORD_DEFAULT);

    $prepare = [
        ":u_id" => $param_arr["id"]
        , ":u_password" => $password
        , ":email" => $param_arr["email"]
        , ":name" => $param_arr["name"]
        , ":phone_no" => $param_arr["phone_no"]
        , ":u_add" => $param_arr["u_add"]
        , ":pw_question" => $param_arr["pw_question"]
        , ":pw_answer" => $param_arr["pw_answer"]
        , ":created_at" => date("Y-m-d H:i:s")
        , ":updated_at" => date("Y-m-d H:i:s")
    ];

    if (isset($param_arr["seller_license"])) {
        $prepare[":seller_license"] = $param_arr["seller_license"];
        $prepare[":b_name"] = $param_arr["b_name"];
    } else if (isset($param_arr["animal_size"])) {
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

/**
 * 함수명 : get_user
 * 기능 : 유저 정보 획득
 * 파라미터 : $id | string
 * 리턴 값 : 획득 성공시 $result | array (유저정보) | 실패시 에러메세지
 */
function get_user($id)
{
    $sql = " SELECT "
        . " * "
        . " FROM "
        . " user "
        . " WHERE "
        . " u_id "
        . " = "
        . " :u_id "
        . " AND "
        . " deleted_at IS NULL "
        . " ; "
        ;

    $prepare = [
        ":u_id" => $id
    ];
    $conn = null;
    try {
        db_conn($conn);
        $stmt = $conn->prepare($sql);
        $stmt->execute($prepare);
        $result = $stmt->fetch();
        return $result;
    } catch (Exception $e) {
        return $e->getMessage();
    } finally {
        $conn = null;
    }
}

/**
 * 함수명 : get_user_no
 * 기능 : 유저 정보 획득
 * 파라미터 : $no | string
 * 리턴 값 : 획득 성공시 $result | array (유저정보) | 실패시 에러메세지
 */
function get_user_no($no)
{
    $sql = " SELECT "
        . " * "
        . " FROM "
        . " user "
        . " WHERE "
        . " u_no "
        . " = "
        . " :u_no ";

    $prepare = [
        ":u_no" => $no
    ];
    $conn = null;
    try {
        db_conn($conn);
        $stmt = $conn->prepare($sql);
        $stmt->execute($prepare);
        $result = $stmt->fetch();
        return $result;
    } catch (Exception $e) {
        return $e->getMessage();
    } finally {
        $conn = null;
    }
}

/**
 * 함수명 : login_user
 * 기능 : 로그인
 * 파라미터 : $param_arr | array
 * 리턴 값 : 성공시 true | 실패시 에러메세지
 */
function login_user($param_arr)
{
    $sql = " SELECT "
        . " * "
        . " FROM "
        . " user "
        . " WHERE "
        . " u_id "
        . " = "
        . " :u_id ";

    $prepare = [
        ":u_id" => $param_arr["id"]
    ];

    $conn = null;
    try {
        db_conn($conn);
        $stmt = $conn->prepare($sql);
        $stmt->execute($prepare);
        $result = $stmt->fetch();
        // 아이디가 없는 경우
        if (!$result) {
            throw new Exception("없는 아이디 입니다. 아이디를 확인해 주세요.");
        }
        // 아이디가 있으면 비밀번호 확인
        if (password_verify($param_arr["pw"], $result["u_password"])) {
            return true;
        } else {
            throw new Exception("비밀번호가 일치하지 않습니다.");
        }
    } catch (Exception $e) {
        return $e->getMessage();
    } finally {
        $conn = null;
    }
}

/**
 * 함수명 : insert_estate
 * 기능 : 매물작성
 * 파라미터 : $param_info | array(건물정보), $param_img | array(이미지정보)
 * 리턴 값 : 성공시 true | 실패시 에러메세지
 */
function insert_estate($param_info, $param_img)
{
    // 매물 작성한 유저 id로 u_no 받아옴
    $get_user_no = get_user($param_info["u_id"]);

    $sql = " INSERT INTO "
        . " s_info( "
        . " u_no "
        . " ,s_name "
        . " ,s_option "
        . " ,s_type "
        . " ,s_size "
        . " ,s_fl "
        . " ,s_stai "
        . " ,s_add "
        . " ,s_log "
        . " ,s_lat "
        . " ,p_deposit "
        . " ,animal_size "
        . " ,created_at "
        . " ,updated_at ";
    if (isset($param_info["p_month"])) {
        $sql .= " ,p_month ";
    }
    $sql .= " ) "
        . " VALUES( "
        . " :u_no "
        . " ,:s_name "
        . " ,:s_option "
        . " ,:s_type "
        . " ,:s_size "
        . " ,:s_fl "
        . " ,:s_stai "
        . " ,:s_add "
        . " ,:s_log "
        . " ,:s_lat "
        . " ,:p_deposit "
        . " ,:animal_size "
        . " ,:created_at "
        . " ,:updated_at ";
    if (isset($param_info["p_month"])) {
        $sql .= " ,:p_month ";
    }
    $sql .= " ); ";

    $prepare = [
        ":u_no" => $get_user_no["u_no"]
        , ":s_name" => $param_info["s_name"]
        , ":s_option" => $param_info["s_option"]
        , ":s_type" => $param_info["s_type"]
        , ":s_size" => intval($param_info["s_size"])
        , ":s_fl" => intval($param_info["s_fl"])
        , ":s_stai" => $param_info["s_stai"]
        , ":s_add" => $param_info["s_add"]
        , ":s_log" => $param_info["s_log"]
        , ":s_lat" => $param_info["s_lat"]
        , ":p_deposit" => intval($param_info["p_deposit"])
        , ":animal_size" => isset($param_info["animal_size"]) ? '1' : '0'
        , ":created_at" => date("Y-m-d H:i:s")
        , ":updated_at" => date("Y-m-d H:i:s")
    ];
    if (isset($param_info["p_month"])) {
        $prepare[":p_month"] = intval($param_info["p_month"]);
    }
    $conn = null;
    try {
        db_conn($conn);
        $conn->beginTransaction();
        $stmt = $conn->prepare($sql);
        $stmt->execute($prepare);

        $s_no = $conn->lastInsertId();
        $option_sql = " INSERT INTO "
            . " state_option( "
            . " s_no "
            . " ,s_parking "
            . " ,s_ele "
            . " ) "
            . " VALUES ( "
            . " :s_no "
            . " ,:s_parking "
            . " ,:s_ele "
            . " ); ";

        $option_prepare = [
            ":s_no" => $s_no
            , ":s_parking" => isset($param_info["s_parking"]) ? '1' : '0'
            , ":s_ele" => isset($param_info["s_ele"]) ? '1' : '0'
        ];
        $option_stmt = $conn->prepare($option_sql);
        $option_stmt->execute($option_prepare);
        $img_sql = " INSERT INTO "
            . " s_img ("
            . " s_no "
            . " ,url "
            . " ,originalname "
            . " ,thumbnail "
            . " ,created_at "
            . " ,updated_at "
            . " ) "
            . " VALUES ( "
            . " :s_no "
            . " ,:url "
            . " ,:originalname "
            . " ,:thumbnail "
            . " ,:created_at "
            . " ,:updated_at "
            . " ); ";

        $img_count = count($param_img['estate_img']['name']);

        for ($i = 0; $i < $img_count; $i++) {
            $img_prepare[$i] = [
                ":s_no" => $s_no
                , ":url" => $param_img['estate_img']['url'][$i]
                , ":originalname" => $param_img['estate_img']['name'][$i]
                , ":thumbnail" => $i == 0 ? '1' : '0'
                , ":created_at" => date("Y-m-d H:i:s")
                , ":updated_at" => date("Y-m-d H:i:s")
            ];

            $img_stmt = $conn->prepare($img_sql);
            $img_stmt->execute($img_prepare[$i]);
        }

        $conn->commit();
        return $s_no;
    } catch (Exception $e) {
        $conn->rollback();
        return $e->getMessage();
    } finally {
        $conn = null;
    }
}

/**
 * 함수명 : update_estate
 * 기능 : 매물정보수정
 * 파라미터 : $param_info | array(건물정보)
 * 리턴 값 : 성공시 1 | 실패시 에러메세지
 */
function update_estate($param_info)
{

    $sql = " UPDATE "
        . " s_info "
        . " SET "
        . " s_name = :s_name "
        . " ,s_option = :s_option "
        . " ,s_type = :s_type "
        . " ,s_size = :s_size "
        . " ,s_fl = :s_fl "
        . " ,s_stai = :s_stai "
        . " ,p_deposit = :p_deposit "
        . " ,animal_size = :animal_size "
        . " ,updated_at = :updated_at "
        ;
    if (isset($param_info["p_month"])) {
        $sql .= " ,p_month = :p_month ";
    }
    $sql .= " WHERE "
        . " s_no = :s_no "
        . " ; ";

    $prepare = [
        ":s_name" => $param_info["s_name"]
        , ":s_option" => $param_info["s_option"]
        , ":s_type" => $param_info["s_type"]
        , ":s_size" => intval($param_info["s_size"])
        , ":s_fl" => intval($param_info["s_fl"])
        , ":s_stai" => $param_info["s_stai"]
        , ":p_deposit" => intval($param_info["p_deposit"])
        , ":animal_size" => isset($param_info["animal_size"]) ? '1' : '0'
        , ":updated_at" => date("Y-m-d H:i:s")
        , ":s_no" => intval($param_info["s_no"])
    ];
    if (isset($param_info["p_month"])) {
        $prepare[":p_month"] = intval($param_info["p_month"]);
    }
    $conn = null;
    try {
        db_conn($conn);
        $conn->beginTransaction();
        $stmt = $conn->prepare($sql);
        $stmt->execute($prepare);

        $option_sql = " UPDATE "
            . " state_option "
            . " SET "
            . " s_parking = :s_parking "
            . " ,s_ele  = :s_ele "
            . " WHERE "
            . " s_no = :s_no "
            . " ; ";

        $option_prepare = [
            ":s_parking" => isset($param_info["s_parking"]) ? '1' : '0'
            , ":s_ele" => isset($param_info["s_ele"]) ? '1' : '0'
            , ":s_no" => $param_info["s_no"]
        ];
        $option_stmt = $conn->prepare($option_sql);
        $option_stmt->execute($option_prepare);

        $conn->commit();
        $result_cnt = $stmt->rowCount();
        return $result_cnt;
    } catch (Exception $e) {
        $conn->rollback();
        return $e->getMessage();
    } finally {
        $conn = null;
    }
}
/**
 * 함수명 : delete_estate
 * 기능 : 매물삭제(delete플래그 타임스탬프로 변경)
 * 파라미터 : $s_no | int
 * 리턴 값 : 성공시 1 | 실패시 에러메세지
 */
function delete_estate($s_no)
{
    $sql = " UPDATE "
        . " s_info "
        . " SET "
        . " deleted_at = :deleted_at "
        . " WHERE "
        . " s_no = :s_no "
        . " ; ";

    $prepare = [
        ":deleted_at" => date("Y-m-d H:i:s")
        , ":s_no" => $s_no
    ];
    $conn = null;
    try {
        db_conn($conn);
        $conn->beginTransaction();
        $stmt = $conn->prepare($sql);
        $stmt->execute($prepare);

        $img_sql = " UPDATE "
            . " s_img "
            . " SET "
            . " deleted_at = :deleted_at "
            . " WHERE "
            . " s_no = :s_no "
            . " ; ";

        $img_prepare = [
            ":deleted_at" => date("Y-m-d H:i:s")
            , ":s_no" => $s_no
        ];
        $img_stmt = $conn->prepare($img_sql);
        $img_stmt->execute($img_prepare);

        $conn->commit();
        $result_cnt = $stmt->rowCount();
        return $result_cnt;
    } catch (Exception $e) {
        $conn->rollback();
        return $e->getMessage();
    } finally {
        $conn = null;
    }
}

/**
 * 함수명 : get_estate_info
 * 기능 : 최근 올라온 최대 20개 까지의 매물 정보를 받아옴
 * 파라미터 : 없음
 * 리턴 값 : $result | array | 순서대로 키 값 0 부터 가져옴
 */
function get_estate_info()
{
    $sql = " SELECT "
        . " * "
        . " FROM "
        . " s_info "
        . " JOIN "
        . " s_img "
        . " ON s_info.s_no "
        . " = s_img.s_no "
        . " JOIN "
        . " state_option "
        . " ON s_info.s_no = state_option.s_no "
        . " WHERE "
        . " s_img.thumbnail "
        . " = "
        . " :thumbnail "
        . " AND "
        . " s_info.deleted_at IS NULL "
        . " ORDER BY "
        . " s_img.updated_at "
        . " DESC "
        . " LIMIT "
        . " :limit ";

    $prepare = [
        ":thumbnail" => '1'
        , ":limit" => 20
    ];

    $conn = null;
    try {
        db_conn($conn);
        $stmt = $conn->prepare($sql);
        $stmt->execute($prepare);
        $result = $stmt->fetchAll();
        return $result;
    } catch (Exception $e) {
        return $e->getMessage();
    } finally {
        $conn = null;
    }
}

/**
 * 함수명 : get_estate_info_wishlist
 * 기능 : s_no를 array로 받아, 해당하는 모든 s_no의 정보를 출력
 * 파라미터 : $s_no_array | array
 * 리턴 값 : $result | array | 순서대로 키 값 0 부터 가져옴
 */
function get_estate_info_wishlist($s_no_array)
{
    // 받아온 배열을 ','로 나누고 값들은 int로 배치
    // int로 안 바꿔주면 아니면 제대로 값안나옴
    $s_no_string = implode(',', array_map('intval', $s_no_array));

    $sql = " SELECT "
        . " * "
        . " FROM "
        . " s_info "
        . " JOIN "
        . " s_img "
        . " ON s_info.s_no "
        . " = s_img.s_no "
        . " JOIN "
        . " state_option "
        . " ON s_info.s_no = state_option.s_no "
        . " WHERE "
        . " s_img.thumbnail "
        . " = "
        . " :thumbnail "
        . " AND "
        . " s_info.s_no IN ( "
        . " $s_no_string "
        . " ) "
        . " ORDER BY "
        . " s_img.updated_at "
        . " DESC "
        . " ; "
        ;

    $prepare = [
        ":thumbnail" => '1'
    ];

    $conn = null;
    try {
        db_conn($conn);
        $stmt = $conn->prepare($sql);
        $stmt->execute($prepare);
        $result = $stmt->fetchAll();
        return $result;
    } catch (Exception $e) {
        return $e->getMessage();
    } finally {
        $conn = null;
    }
}

/**
 * 함수명 : get_s_no_info
 * 기능 : 파라미터로 받은 s_no의 정보를 불러옴
 * 파라미터 : $param_int | int
 * 리턴 값 : $result | array
 */
function get_s_no_info($param_int)
{
    $sql = " SELECT "
        . " * "
        . " FROM "
        . " s_info "
        . " JOIN "
        . " s_img "
        . " ON s_info.s_no "
        . " = s_img.s_no "
        . " JOIN "
        . " state_option "
        . " ON s_info.s_no = state_option.s_no "
        . " WHERE "
        . " s_info.s_no "
        . " = "
        . " :s_no ";

    $prepare = [
        ":s_no" => $param_int
    ];

    $conn = null;
    try {
        db_conn($conn);
        $stmt = $conn->prepare($sql);
        $stmt->execute($prepare);
        $result = $stmt->fetchAll();
        return $result;
    } catch (Exception $e) {
        return $e->getMessage();
    } finally {
        $conn = null;
    }
}

/**
 * 함수명 : get_s_info_search
 * 기능 : 파라미터로 받은 s_no의 정보를 불러옴
 * 파라미터 : $param_str | string
 * 리턴 값 : $result | array
 */
    function get_s_info_search($param_str) {

        $sql = " SELECT "
        . " * "
        . " FROM "
        . " s_info "
        . " JOIN "
        . " s_img "
        . " ON s_info.s_no "
        . " = s_img.s_no "
        . " JOIN "
        . " state_option "
        . " ON s_info.s_no = state_option.s_no "
        . " WHERE "
        . " thumbnail"
        . " = "
        . " :thumbnail "
        . " AND "
        . " (s_stai "
        . " LIKE "
        . " :search "
        . " OR "
        . " s_add "
        . " LIKE "
        . " :search2); "
        ;

        $prepare = [
            ":search" => "%".$param_str."%"
            ,":search2" => "%".$param_str."%"
            ,":thumbnail" => '1'
        ];

        $conn = null;
        try {
            db_conn($conn);
            $stmt = $conn->prepare($sql);
            $stmt->execute($prepare);
            $result = $stmt->fetchAll();
            return $result;
        } catch (Exception $e) {
            return $e->getMessage();
        } finally {
            $conn = null;
        }
    }

    /**
 * 함수명 : get_s_info_indiv
 * 기능 : 한 유저가 올린 모든 s_info의 정보를 가져옴
 * 파라미터 : $param_str | string
 * 리턴 값 : $result | array
 */
function get_s_info_indiv($param_str) {

    $sql = " SELECT "
    . " * "
    . " FROM "
    . " s_info "
    . " JOIN "
    . " s_img "
    . " ON s_info.s_no "
    . " = s_img.s_no "
    . " JOIN "
    . " state_option "
    . " ON s_info.s_no = state_option.s_no "
    . " WHERE "
    . " thumbnail"
    . " = "
    . " :thumbnail "
    . " AND "
    . " u_no "
    . " = "
    . " :u_no "
    ;

    $prepare = [
        "u_no" => $param_str
        ,":thumbnail" => '1'
    ];

    $conn = null;
    try {
        db_conn($conn);
        $stmt = $conn->prepare($sql);
        $stmt->execute($prepare);
        $result = $stmt->fetchAll();
        return $result;
    } catch (Exception $e) {
        return $e->getMessage();
    } finally {
        $conn = null;
    }
}

/**
 * 함수명 : get_estate_info_json
 * 기능 : 모든 매물 정보를 받아옴
 * 파라미터 : 없음
 * 리턴 값 : $result | json
 */
function get_estate_info_json()
{
    $sql = " SELECT "
        . " * "
        . " FROM "
        . " s_info "
        . " JOIN "
        . " s_img "
        . " ON s_info.s_no "
        . " = s_img.s_no "
        . " JOIN "
        . " state_option "
        . " ON s_info.s_no = state_option.s_no "
        . " WHERE "
        . " s_img.thumbnail "
        . " = "
        . " :thumbnail "
        ;

    $prepare = [
        ":thumbnail" => '1'
    ];

    $conn = null;
    try {
        db_conn($conn);
        $stmt = $conn->prepare($sql);
        $stmt->execute($prepare);
        $result = $stmt->fetchAll();
        return json_encode($result);
    } catch (Exception $e) {
        return $e->getMessage();
    } finally {
        $conn = null;
    }
}

/**
 * 함수명 : find_user_id
 * 기능 : 이메일, 이름 값을 받아 유저 아이디 정보 받아옴
 * 파라미터 : $email, $name | string, string
 * 리턴 값 : 획득 성공시 $id | string (유저id) | 실패시 에러메세지
 */
function find_user_id($email, $name)
{
    $sql = " SELECT "
        . " u_id "
        . " FROM "
        . " user "
        . " WHERE "
        . " email "
        . " = "
        . " :email "
        . " AND "
        . " name "
        . " = "
        . " :name ";

    $prepare = [
        ":email" => $email
        ,":name" => $name
    ];

    $conn = null;
    try {
        db_conn($conn);
        $stmt = $conn->prepare($sql);
        $stmt->execute($prepare);
        $id = $stmt->fetch();
        return $id;
    } catch (Exception $e) {
        return $e->getMessage();
    } finally {
        $conn = null;
    }
}

/**
 * 함수명 : find_user_question
 * 기능 : id를 받아서 비밀번호 찾기 전용 질문, 답변 반환
 * 파라미터 : $id | string
 * 리턴 값 : 획득 성공시 $result | array | 실패시 에러메세지
 */
function find_user_question($id)
{
    $sql = " SELECT "
        . " pw_question, "
        . " pw_answer "
        . " FROM "
        . " user "
        . " WHERE "
        . " u_id "
        . " = "
        . " :u_id ";

    $prepare = [
        ":u_id" => $id
    ];

    $conn = null;
    try {
        db_conn($conn);
        $stmt = $conn->prepare($sql);
        $stmt->execute($prepare);
        $result = $stmt->fetch();
        return $result;
    } catch (Exception $e) {
        return $e->getMessage();
    } finally {
        $conn = null;
    }
}


/**
 * 함수명 : find_user_pw
 * 기능 : 유저가 회원가입시 입력했던 질문 답변이 맞는지 확인
 * 파라미터 : $param_arr | array
 * 리턴 값 : 획득 성공시 $result | array | 실패시 에러메세지
 */
function find_user_pw($param_arr)
{
    $sql = " SELECT "
        . " pw_question, "
        . " pw_answer "
        . " FROM "
        . " user "
        . " WHERE "
        . " u_id "
        . " = "
        . " :u_id "
        . " AND "
        . " pw_answer "
        . " = "
        . " :pw_answer ";

    $prepare = [
        ":u_id" => base64_decode($param_arr['u_id']),
        ":pw_answer" => $param_arr['pw_answer']
    ];

    $conn = null;
    try {
        db_conn($conn);
        $stmt = $conn->prepare($sql);
        $stmt->execute($prepare);
        $result = $stmt->fetch();
        return $result;
    } catch (Exception $e) {
        return $e->getMessage();
    } finally {
        $conn = null;
    }
}

/**
 * 함수명 : change_user_pw
 * 기능 : 유저의 비밀번호 변경
 * 파라미터 : $param_arr | array
 * 리턴 값 : $result_cnt | int | 실패시 에러메세지
 */
function change_user_pw($param_arr)
{
    $sql = " UPDATE "
        . " user "
        . " SET "
        . " u_password "
        . " = "
        . " :u_password "
        . " WHERE "
        . " u_id "
        . " = "
        . " :u_id "
        . " ; "
        ;

    $password = password_hash($param_arr["pw"], PASSWORD_DEFAULT);

    $prepare = [
        ":u_id" => base64_decode($param_arr['u_id']),
        ":u_password" => $password
    ];

    $conn = null;
    try {
        db_conn($conn);
        $conn->beginTransaction();
        $stmt = $conn->prepare($sql);
        $stmt->execute($prepare);
        $result_cnt = $stmt->rowCount();
        $conn->commit();
        return $result_cnt;
    } catch (Exception $e) {
        $conn->rollback();
        return $e->getMessage();
    } finally {
        $conn = null;
    }
}

/**
 * 함수명 : change_user_info
 * 기능 : 유저의 정보 변경 (이메일, 전화번호)
 * 파라미터 : $param_arr | array
 * 리턴 값 : $result_cnt | int | 실패시 에러메세지
 */
function change_user_info($param_arr)
{
    $sql = " UPDATE "
        . " user "
        . " SET "
        . " email = :email "
        . " ,phone_no = :phone_no "
        . " ,updated_at = :updated_at"
        . " WHERE "
        . " u_id "
        . " = "
        . " :u_id "
        . " ; "
        ;

    $prepare = [
        ":email" => $param_arr['email']
        ,":phone_no" => $param_arr['phone_no']
        ,":u_id" => $param_arr['u_id']
        ,":updated_at" => date("Y-m-d H:i:s")
    ];

    $conn = null;
    try {
        db_conn($conn);
        $conn->beginTransaction();
        $stmt = $conn->prepare($sql);
        $stmt->execute($prepare);
        $result_cnt = $stmt->rowCount();
        $conn->commit();
        return $result_cnt;
    } catch (Exception $e) {
        $conn->rollback();
        return $e->getMessage();
    } finally {
        $conn = null;
    }
}

/**
 * 함수명 : chk_wishlist
 * 기능 : 찜한 매물인지 확인하는 함수
 * 파라미터 : $u_no, $s_no | int, int
 * 리턴 값 : $result 값이 없을 시 false대신 null로 넘김| array | 실패시 에러메세지
 */
function chk_wishlist($u_no, $s_no) {
    $sql = " SELECT "
        . " * " 
        . " FROM "
        . " wish_list "
        . " WHERE " 
        . " u_no = :u_no "
        . " AND "
        . " s_no = :s_no "
        . " ; "
        ; 
    $prepare = [
            ":u_no" => $u_no
            ,":s_no" => $s_no
    ];

    $conn = null;
    try {
        db_conn($conn);
        $stmt = $conn->prepare($sql);
        $stmt->execute($prepare);
        $result = $stmt->fetch();
        if($result === false) {
            $result = null;
        }
        return $result;
    } catch (Exception $e) {
        return $e->getMessage();
    } finally {
        $conn = null;
    }
}

/**
 * 함수명 : insert_wishlist
 * 기능 : 매물 찜하기
 * 파라미터 : $u_no, $s_no | int, int
 * 리턴 값 : $result_cnt | int | 실패시 에러메세지
 */
function insert_wishlist($u_no, $s_no) {
    $sql = " INSERT INTO "
        . " wish_list " 
        . " (u_no, s_no) "
        . " VALUES " 
        . " (:u_no, :s_no) "
        . " ; "
        ; 
    $prepare = [
            ":u_no" => $u_no
            ,":s_no" => $s_no
    ];

    $conn = null;
    try {
        db_conn($conn);
        $conn->beginTransaction();
        $stmt = $conn->prepare($sql);
        $stmt->execute($prepare);
        $result_cnt = $stmt->rowCount();
        $conn->commit();
        return $result_cnt;
    } catch (Exception $e) {
        $conn->rollback();
        return $e->getMessage();
    } finally {
        $conn = null;
    }
}

/**
 * 함수명 : delete_wishlist
 * 기능 : 찜한 매물 삭제
 * 파라미터 : $u_no, s_no | int, int
 * 리턴 값 : $result_cnt | int | 실패시 에러메세지
 */
function delete_wishlist($u_no, $s_no) {
    $sql = " DELETE FROM "
        . " wish_list "
        . " WHERE " 
        . " u_no = :u_no "
        . " AND "
        . " s_no = :s_no "
        . " ; "
        ; 
    $prepare = [
            ":u_no" => $u_no
            ,":s_no" => $s_no
    ];

    $conn = null;
    try {
        db_conn($conn);
        $conn->beginTransaction();
        $stmt = $conn->prepare($sql);
        $stmt->execute($prepare);
        $result_cnt = $stmt->rowCount();
        $conn->commit();
        return $result_cnt;
    } catch (Exception $e) {
        $conn->rollback();
        return $e->getMessage();
    } finally {
        $conn = null;
    }
}

/**
 * 함수명 : get_wishlist
 * 기능 : u_no가 찜한 모든 s_no 리턴
 * 파라미터 : $u_no | int
 * 리턴 값 : $result | array | 실패시 에러메세지
 */
function get_wishlist($u_no) {
    $sql = " SELECT "
        . " * " 
        . " FROM "
        . " wish_list "
        . " WHERE " 
        . " u_no = :u_no "
        . " ; "
        ; 
    $prepare = [
            ":u_no" => $u_no
    ];

    $conn = null;
    try {
        db_conn($conn);
        $stmt = $conn->prepare($sql);
        $stmt->execute($prepare);
        $result = $stmt->fetchAll();
        return $result;
    } catch (Exception $e) {
        return $e->getMessage();
    } finally {
        $conn = null;
    }
}