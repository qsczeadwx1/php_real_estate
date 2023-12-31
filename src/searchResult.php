<?php
    define("ROOT", $_SERVER["DOCUMENT_ROOT"] . "/src/");
    include_once(ROOT . "/common/pdo.php");

    session_start();
    
if($_SERVER["REQUEST_METHOD"] == "GET") {   
    $arr_get = $_GET;
    $estate_info = get_s_info_search($arr_get);
    }
?>


<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>펫방</title>
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/tiny-slider.css" />
    <link rel="stylesheet" href="./css/aos.css" />
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="stylesheet" href="./css/layout.css">

    <style>
        .search {
            text-align: center;
            border: 1px solid black;
            height: 200px;
            background-color: aqua;
            margin: 20px;
        }

        .content {
            border: 1px solid black;
            margin: 20px;
            padding: 10px;
        }
    </style>
</head>

<body>
<?php include_once("./layout/header.php"); ?>

<div class="search">
<h1 style="margin-top:10px;">Pet bang</h1>
    <form action="./searchResult.php" method="GET">
            <input type="text" name="search" placeholder="주소나 지하철명으로 검색해 주세요">
            <button>검색</button>
            <div id="search_checkbox" style="margin-top: 5px;" >
                <div id="s_option">
                    <span style="font-weight:900;">건물형태</span>
                    <label for="s_option_1">| 아파트 </label>
                    <input type="checkbox" name="s_option[]" id="s_option_1" class="s_option" value="0">
                    <label for="s_option_2">| 단독주택 </label>
                    <input type="checkbox" name="s_option[]" id="s_option_2" class="s_option" value="1">
                    <label for="s_option_3">| 오피스텔</label>
                    <input type="checkbox" name="s_option[]" id="s_option_3" class="s_option" value="2">
                    <label for="s_option_4">| 빌라</label>
                    <input type="checkbox" name="s_option[]" id="s_option_4" class="s_option" value="3">
                    <label for="s_option_5">| 원룸</label>
                    <input type="checkbox" name="s_option[]" id="s_option_5" class="s_option" value="4">
                </div>
                <div id="s_type">
                    <span style="font-weight:900;">거래유형</span>
                    <label for="s_type_1">| 매매</label>
                    <input type="checkbox" name="s_type[]" id="s_type_1" class="s_type" value="0">
                    <label for="s_type_2">| 전세</label>
                    <input type="checkbox" name="s_type[]" id="s_type_2" class="s_type" value="1">
                    <label for="s_type_3">| 월세</label>
                    <input type="checkbox" name="s_type[]" id="s_type_3" class="s_type" value="2">
                </div>
                <div id="state_option">
                    <span style="font-weight:900;">건물옵션</span>
                    <label for="state_option_1">| 주차가능여부</label>
                    <input type="checkbox" name="state_option[]" id="state_option_1" value="s_parking">
                    <label for="state_option_2">| 엘리베이터여부</label>
                    <input type="checkbox" name="state_option[]" id="state_option_2" value="s_ele">
                </div>
            </div>
        </form>
    </div>



<div class="section">
        <div class="container" style="max-width:75%;">
            <div class="row mb-5 align-items-center">
                <div class="col-lg-6">
                    <h2 class="text-primary heading" style="font-family:'S-CoreDream-6Bold';">
                        검색된 매물
                    </h2>
                </div>
                <div class="col-lg-6 text-lg-end">
                    
                </div>
            </div>
        <div class="row">
            <div class="col-12" style="padding:0">
            <?php
                $i=1;
                foreach ($estate_info as $val) {
            ?>
                    <div class="property-item" style="display:inline-block;">
                        <a href="./detailEstate.php?s_no=<?=$val['s_no']?>" class="img">
                            <img src="./upload/img_<?=$i; $i++?>.jpg" alt="Image" class="img-fluid" style="width: 350px; height: 300px; margin-bottom: 50px;" />
                        </a>

                        <div class="property-content">
                            <div class="price mb-2">
                                <a href="{{route('struct.detail',['s_no'=>$photo->s_no])}}">
                                    <span>
                                    <?=$val['s_name']?>
                                    </span>
                                </a>
                            </div>
                            <div>
                            <span class="d-block mb-2 text-black-50"><?=$val['s_add']?></span>
                                <span class="city d-block mb-3"><?=number_format($val['p_deposit']);?>
                                <?=isset($val['p_month']) ? ' / '.$val['p_month'] : null ?>
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
                                        }?></span>
                                    </span>
                                    <span class="d-block d-flex align-items-center">
                                        
                                        <span class="fa-solid fa-dog me-2"></span>
                                        <span class="caption"> 대형동물
                                            <strong><?=$val['animal_size'] == 1 ? 'O' : 'X'?></strong>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- .item -->
                    <?php } ?>
                </div>
                </div>
        </div>
    </div>


<?php include_once("./layout/footer.php"); ?>

<script src="https://kit.fontawesome.com/e615ee2f7e.js" crossorigin="anonymous"></script>
    <!-- <script src="./js/bootstrap.bundle.min.js"></script> -->
    <script src="./js/tiny-slider.js"></script>
    <script src="./js/aos.js"></script>
    <script src="./js/counter.js"></script>
    <script src="./js/custom.js"></script>
</body>
</html>