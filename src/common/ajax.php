<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"] . "/src/");
include_once(ROOT . "/common/pdo.php");


// js에서 json으로 보낸 값 그대로 받는법
// file_get_contents('php://input');
// 데이터 받아서 배열로 만들고
// 각 체크박스에 체크된 값 따라서 where 절 조건 추가 후
// 다시 json으로 값을 넘김

$data = json_decode(file_get_contents("php://input"), true);
$s_option = $data['s_option'];
$s_type = $data['s_type'];
$state_option = $data['state_option'];


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
    . " :thumbnail ";

if (!empty($s_option)) {
    // 들어온 배열 사이에 ,로 나눈 다음 각각 값에 ''를 붙여주기
    // 정수로 넣으면 값이 제대로 안나옴
    $s_option_string = implode(',', array_map(function ($value) {
        return "'$value'";
    }, $s_option));
    $sql .= " AND s_info.s_option IN (" . $s_option_string . ")";
}
if (!empty($s_type)) {
    $s_type_string = implode(',', array_map(function ($value) {
        return "'$value'";
    }, $s_type));
    $sql .= " AND s_info.s_type IN (" . $s_type_string . ")";
}
if (in_array('s_parking', $state_option)) {
    $sql .= " AND state_option.s_parking = '1'";
}
if (in_array('s_ele', $state_option)) {
    $sql .= " AND state_option.s_ele = '1'";
}
$sql .= ";";

$prepare = [
    ":thumbnail" => '1'
];

$conn = null;
try {
    db_conn($conn);
    $stmt = $conn->prepare($sql);
    $stmt->execute($prepare);
    $result = $stmt->fetchAll();
    echo json_encode(["results" => $result]);
} catch (Exception $e) {
    return $e->getMessage();
} finally {
    $conn = null;
}
