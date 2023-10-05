CREATE DATABASE pet_realestate;

USE pet_realestate;

CREATE TABLE `user` (
    `u_no` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `u_id` VARCHAR(100) NOT NULL UNIQUE,
    `u_password` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `name` VARCHAR(100) NOT NULL,
    `phone_no` VARCHAR(20) NOT NULL,
    `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
    `u_add` VARCHAR(255) NOT NULL,
    `seller_license` INT(12) NULL,
    `animal_size` ENUM('0', '1') NOT NULL,
    `pw_question` ENUM('0', '1', '2', '3', '4') NOT NULL,
    `pw_answer` VARCHAR(255) NOT NULL,
    `b_name` VARCHAR(255) NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` TIMESTAMP NULL DEFAULT NULL
);


CREATE TABLE `s_info` (
    `s_no` INT(11) AUTO_INCREMENT,
    `u_no` INT(11),
    `s_name` VARCHAR(100) NOT NULL,
    `s_add` VARCHAR(500) NOT NULL,
    `s_type` ENUM('0', '1', '2') NOT NULL, -- 매매 0, 전세 1, 월세 2
    `s_size` INT(11) NOT NULL,
    `s_fl` INT(11) NOT NULL,
    `s_widra` ENUM('0', '1') DEFAULT '0' NOT NULL, -- 삭제 플래그
    `s_stai` VARCHAR(30) NOT NULL,
    `s_log` VARCHAR(100) NOT NULL,
    `s_lat` VARCHAR(100) NOT NULL,
    `p_deposit` INT(100) NOT NULL,
    `p_month` INT(100),
    `animal_size` ENUM('0', '1') NOT NULL,
    `hits` INT(100) DEFAULT '0' NOT NULL,
    `s_option` ENUM('0', '1', '2', '3', '4') NOT NULL, -- 아파트 0, 단독주택 1, 오피스텔2, 빌라3, 원룸4
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` TIMESTAMP NULL DEFAULT NULL,
    CONSTRAINT `pk_s_info_s_no_u_no` PRIMARY KEY(`s_no`,`u_no`)
);

CREATE TABLE `subways` (
    `sub_no` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `sub_name` VARCHAR(100) NOT NULL
);

CREATE TABLE `state_option` (
    `s_no` INT(11) PRIMARY KEY,
    `s_parking` ENUM('0','1') NOT NULL default('0'),
    `s_ele` ENUM('0','1') NOT NULL default('0')
);

CREATE TABLE `s_img` (
    `p_no` INT(11) AUTO_INCREMENT,
    `s_no` INT(11),
    `url` VARCHAR(255) NOT NULL,
    `originalname` VARCHAR(255) NOT NULL,
    `thumbnail` ENUM('0','1') DEFAULT('0') NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` TIMESTAMP NULL DEFAULT NULL,
    CONSTRAINT `pk_s_img_p_no_s_no` PRIMARY KEY(`p_no`,`s_no`)
);

CREATE TABLE `wish_list` (
    `u_no` INT(11),
    `s_no` INT(11),
    CONSTRAINT `pk_wish_list_u_no_s_no` PRIMARY KEY(`u_no`,`s_no`)
);

CREATE TABLE `seller_license` (
    `sell_no` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `seller_license` INT(12) UNIQUE NOT NULL
);

INSERT INTO `subways` (`sub_name`) VALUES ('문양');
INSERT INTO `subways` (`sub_name`) VALUES ('다사');
INSERT INTO `subways` (`sub_name`) VALUES ('대실');
INSERT INTO `subways` (`sub_name`) VALUES ('강창');
INSERT INTO `subways` (`sub_name`) VALUES ('계명대');
INSERT INTO `subways` (`sub_name`) VALUES ('성서산업단지');
INSERT INTO `subways` (`sub_name`) VALUES ('이곡');
INSERT INTO `subways` (`sub_name`) VALUES ('용산');
INSERT INTO `subways` (`sub_name`) VALUES ('죽전');
INSERT INTO `subways` (`sub_name`) VALUES ('감삼');
INSERT INTO `subways` (`sub_name`) VALUES ('두류');
INSERT INTO `subways` (`sub_name`) VALUES ('내당');
INSERT INTO `subways` (`sub_name`) VALUES ('반고개');
INSERT INTO `subways` (`sub_name`) VALUES ('청라언덕');
INSERT INTO `subways` (`sub_name`) VALUES ('반월당');
INSERT INTO `subways` (`sub_name`) VALUES ('경대병원');
INSERT INTO `subways` (`sub_name`) VALUES ('대구은행');
INSERT INTO `subways` (`sub_name`) VALUES ('범어');
INSERT INTO `subways` (`sub_name`) VALUES ('수성구청');
INSERT INTO `subways` (`sub_name`) VALUES ('만촌');
INSERT INTO `subways` (`sub_name`) VALUES ('담티');
INSERT INTO `subways` (`sub_name`) VALUES ('연호');
INSERT INTO `subways` (`sub_name`) VALUES ('대공원');
INSERT INTO `subways` (`sub_name`) VALUES ('고산');
INSERT INTO `subways` (`sub_name`) VALUES ('신매');
INSERT INTO `subways` (`sub_name`) VALUES ('사월');
INSERT INTO `subways` (`sub_name`) VALUES ('정평');
INSERT INTO `subways` (`sub_name`) VALUES ('임당');
INSERT INTO `subways` (`sub_name`) VALUES ('영남대');

INSERT INTO `subways` (`sub_name`) VALUES ('설화명곡');
INSERT INTO `subways` (`sub_name`) VALUES ('화원');
INSERT INTO `subways` (`sub_name`) VALUES ('대곡');
INSERT INTO `subways` (`sub_name`) VALUES ('진천');
INSERT INTO `subways` (`sub_name`) VALUES ('월배');
INSERT INTO `subways` (`sub_name`) VALUES ('상인');
INSERT INTO `subways` (`sub_name`) VALUES ('월촌');
INSERT INTO `subways` (`sub_name`) VALUES ('송현');
INSERT INTO `subways` (`sub_name`) VALUES ('서부정류장');
INSERT INTO `subways` (`sub_name`) VALUES ('대명');
INSERT INTO `subways` (`sub_name`) VALUES ('안지랑');
INSERT INTO `subways` (`sub_name`) VALUES ('현충로');
INSERT INTO `subways` (`sub_name`) VALUES ('영대병원');
INSERT INTO `subways` (`sub_name`) VALUES ('교대');
INSERT INTO `subways` (`sub_name`) VALUES ('명덕');
INSERT INTO `subways` (`sub_name`) VALUES ('중앙로');
INSERT INTO `subways` (`sub_name`) VALUES ('대구');
INSERT INTO `subways` (`sub_name`) VALUES ('칠성시장');
INSERT INTO `subways` (`sub_name`) VALUES ('신천');
INSERT INTO `subways` (`sub_name`) VALUES ('동대구');
INSERT INTO `subways` (`sub_name`) VALUES ('동구청');
INSERT INTO `subways` (`sub_name`) VALUES ('아양교');
INSERT INTO `subways` (`sub_name`) VALUES ('동촌');
INSERT INTO `subways` (`sub_name`) VALUES ('해안');
INSERT INTO `subways` (`sub_name`) VALUES ('방촌');
INSERT INTO `subways` (`sub_name`) VALUES ('용계');
INSERT INTO `subways` (`sub_name`) VALUES ('율하');
INSERT INTO `subways` (`sub_name`) VALUES ('신기');
INSERT INTO `subways` (`sub_name`) VALUES ('반야월');
INSERT INTO `subways` (`sub_name`) VALUES ('각산');
INSERT INTO `subways` (`sub_name`) VALUES ('안심');

INSERT INTO `subways` (`sub_name`) VALUES ('칠곡경대병원');
INSERT INTO `subways` (`sub_name`) VALUES ('학정');
INSERT INTO `subways` (`sub_name`) VALUES ('팔거');
INSERT INTO `subways` (`sub_name`) VALUES ('동천');
INSERT INTO `subways` (`sub_name`) VALUES ('칠곡운암');
INSERT INTO `subways` (`sub_name`) VALUES ('구암');
INSERT INTO `subways` (`sub_name`) VALUES ('태전');
INSERT INTO `subways` (`sub_name`) VALUES ('매천');
INSERT INTO `subways` (`sub_name`) VALUES ('매천시장');
INSERT INTO `subways` (`sub_name`) VALUES ('팔달');
INSERT INTO `subways` (`sub_name`) VALUES ('공단');
INSERT INTO `subways` (`sub_name`) VALUES ('만평');
INSERT INTO `subways` (`sub_name`) VALUES ('팔달시장');
INSERT INTO `subways` (`sub_name`) VALUES ('원대');
INSERT INTO `subways` (`sub_name`) VALUES ('북구청');
INSERT INTO `subways` (`sub_name`) VALUES ('달성공원');
INSERT INTO `subways` (`sub_name`) VALUES ('서문시장');
INSERT INTO `subways` (`sub_name`) VALUES ('남산');
INSERT INTO `subways` (`sub_name`) VALUES ('건들바위');
INSERT INTO `subways` (`sub_name`) VALUES ('대봉교');
INSERT INTO `subways` (`sub_name`) VALUES ('수성시장');
INSERT INTO `subways` (`sub_name`) VALUES ('수성구민운동장');
INSERT INTO `subways` (`sub_name`) VALUES ('어린이회관');
INSERT INTO `subways` (`sub_name`) VALUES ('황금');
INSERT INTO `subways` (`sub_name`) VALUES ('수성못');
INSERT INTO `subways` (`sub_name`) VALUES ('지산');
INSERT INTO `subways` (`sub_name`) VALUES ('범물');
INSERT INTO `subways` (`sub_name`) VALUES ('용지');

INSERT INTO `seller_license` (`seller_license`) VALUES (123456789);