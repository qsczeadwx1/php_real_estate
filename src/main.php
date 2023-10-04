<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"] . "/src/");
include_once(ROOT . "/common/pdo.php");

session_start();

$estate_info = get_estate_info();

?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>펫방</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous"> -->
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/tiny-slider.css" />
    <link rel="stylesheet" href="./css/aos.css" />
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="stylesheet" href="./css/layout.css">

    <style>
        .search {
            text-align: center;
            border: 1px solid black;
            height: 150px;
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
    <h1 style="margin-top:10px;">펫 방</h1>
    <form action="./searchResult.php" method="GET">
    <input type="text" name="search" placeholder="주소나 지하철명으로 검색해 주세요">
    <button>Search</button>
    </form>
    </div>
    <div style="margin-left:20px;">
        <h2>최근 등록된 매물</h2>
        <a href="./map.php" style="text-align:right;"><button>지도에서 매물 검색</button></a>
    </div>
    <div class="content">
    <div class="row">
        <div class="col-12">
            <div class="property-slider-wrap">
                <div class="property-slider">
            <?php
                $i=1;
                foreach ($estate_info as $val) {
            ?>
                    <div class="property-item">
                        <a href="./detailEstate.php?s_no=<?=$val['s_no']?>" class="img">
                            <img src="./upload/img_<?=$i; $i++?>.jpg" alt="Image" class="img-fluid" />
                        </a>

                        <div class="property-content">
                            <div class="price mb-2"><span><?=$val['s_name']?></span></div>
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
                                        <span class="caption">대형동물&nbsp;</span>
                                            <strong><?=$val['animal_size'] == 1 ? 'O' : 'X'?></strong>
                                    </span>
                                </div>
                    
                                <a href="./detailEstate.php?s_no=<?=$val['s_no']?>" class="btn btn-primary py-2 px-3">매물보러가기</a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                </div>
                <div id="property-nav" class="controls" tabindex="0" aria-label="Carousel Navigation">
                    <span class="prev" data-controls="prev" aria-controls="property" tabindex="-1">이전</span>
                    <span class="next" data-controls="next" aria-controls="property" tabindex="-1">다음</span>
                </div>
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