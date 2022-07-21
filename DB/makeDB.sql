-- --------------------------------------------------------
-- 호스트:                          127.0.0.1
-- 서버 버전:                        10.9.1-MariaDB - mariadb.org binary distribution
-- 서버 OS:                        Win64
-- HeidiSQL 버전:                  11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- farm 데이터베이스 구조 내보내기
CREATE DATABASE IF NOT EXISTS `farm` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `farm`;

-- 테이블 farm.comment 구조 내보내기
CREATE TABLE IF NOT EXISTS `comment` (
  `comment_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '댓글id',
  `p_id` int(11) unsigned DEFAULT NULL COMMENT '장비대여 id',
  `s_id` int(11) unsigned DEFAULT NULL COMMENT '정보판매 id',
  `member_id` varchar(16) NOT NULL COMMENT '작성자 이름',
  `detail` text NOT NULL COMMENT '댓글',
  `upload` date NOT NULL COMMENT '업로드일',
  `deleteDate` date DEFAULT NULL COMMENT '삭제일',
  `reply_id` int(11) unsigned DEFAULT NULL COMMENT '대댓글시 댓글의 id 그냥 댓글시 null',
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='댓글';

-- 내보낼 데이터가 선택되어 있지 않습니다.

-- 테이블 farm.file 구조 내보내기
CREATE TABLE IF NOT EXISTS `file` (
  `file_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '파일 id',
  `p_id` int(11) unsigned DEFAULT NULL COMMENT '장비대여 id',
  `s_id` int(11) unsigned DEFAULT NULL COMMENT '정보판매 id',
  `link` varchar(45) DEFAULT NULL COMMENT '파일주소',
  PRIMARY KEY (`file_id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COMMENT='파일(장비대여 이미지, 정보판매 pdf)';

-- 내보낼 데이터가 선택되어 있지 않습니다.

-- 테이블 farm.info_buy_list 구조 내보내기
CREATE TABLE IF NOT EXISTS `info_buy_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sell_info_id` int(11) unsigned NOT NULL,
  `member_id` varchar(16) NOT NULL DEFAULT '',
  `buy_completion` tinyint(1) DEFAULT NULL COMMENT '기본 NULL 구매확정후 1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='정보 구매 테이블';

-- 내보낼 데이터가 선택되어 있지 않습니다.

-- 테이블 farm.member 구조 내보내기
CREATE TABLE IF NOT EXISTS `member` (
  `id` varchar(16) NOT NULL COMMENT '아이디',
  `password` varchar(64) NOT NULL COMMENT '비밀번호',
  `phone` char(16) DEFAULT NULL COMMENT '전화번호',
  `name` varchar(16) NOT NULL COMMENT '이름',
  `email` varchar(64) DEFAULT NULL COMMENT '이메일',
  `address` varchar(128) DEFAULT NULL,
  `latest` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '가장최근로그인(salt)',
  `datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'latest 직전 로그인(salt)',
  `login_count` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '로그인횟수(salt)',
  `IP` varchar(16) NOT NULL DEFAULT '' COMMENT '접속IP(salt)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='멤버';

-- 내보낼 데이터가 선택되어 있지 않습니다.

-- 테이블 farm.notification 구조 내보내기
CREATE TABLE IF NOT EXISTS `notification` (
  `notification_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` varchar(16) NOT NULL DEFAULT '',
  `comment_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`notification_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='댓글 등 알람';

-- 내보낼 데이터가 선택되어 있지 않습니다.

-- 테이블 farm.product 구조 내보내기
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '대여글 id',
  `category` enum('tractor','combine','rice transplanter','rotary','livestock machinery','forklift','etc') NOT NULL DEFAULT 'etc' COMMENT '기기종류',
  `end_date` date NOT NULL COMMENT '대여종료일',
  `start_date` date NOT NULL COMMENT '대여시작일',
  `priority` tinyint(1) NOT NULL DEFAULT 1 COMMENT '우선순위',
  `detail` mediumtext NOT NULL COMMENT '내용',
  `member_id` varchar(16) NOT NULL COMMENT '등록자 id',
  `member_phone` char(11) DEFAULT NULL COMMENT '등록자 전화번호',
  `member_email` varchar(64) DEFAULT NULL COMMENT '등록자 이메일',
  `member_name` varchar(16) DEFAULT NULL COMMENT '등록자 이름',
  `upload` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '등록일',
  `deleteDate` date DEFAULT NULL COMMENT '삭제일 null일시 미삭제',
  `place` varchar(64) NOT NULL COMMENT '대여장소',
  `price` decimal(16,0) unsigned NOT NULL DEFAULT 0 COMMENT '가격',
  `close` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT '종료 빌리면1 아닌경우 0',
  `maker` varchar(16) NOT NULL COMMENT '제조사',
  `make_year` date NOT NULL COMMENT '제조년식',
  `model` varchar(32) NOT NULL COMMENT '기종 및 형식명',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COMMENT='장비대여';

-- 내보낼 데이터가 선택되어 있지 않습니다.

-- 테이블 farm.sell_info 구조 내보내기
CREATE TABLE IF NOT EXISTS `sell_info` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '판매 id',
  `title` varchar(128) DEFAULT NULL,
  `price` varchar(64) NOT NULL,
  `detail` mediumtext NOT NULL,
  `member_id` varchar(16) NOT NULL,
  `member_name` varchar(16) DEFAULT NULL,
  `member_phone` char(11) DEFAULT NULL,
  `member_email` varchar(64) DEFAULT NULL,
  `upload` date NOT NULL DEFAULT curdate() COMMENT '등록일',
  `deleteDate` date DEFAULT NULL COMMENT '삭제일',
  `sellnum` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '판매수',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=155 DEFAULT CHARSET=utf8mb4 COMMENT='정보 판매';

-- 내보낼 데이터가 선택되어 있지 않습니다.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
