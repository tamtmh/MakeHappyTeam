-- MySQL dump 10.13  Distrib 5.7.17, for macos10.12 (x86_64)
--
-- Host: 127.0.0.1    Database: make_happy
-- ------------------------------------------------------
-- Server version	8.0.16
DROP DATABASE make_happy;
CREATE DATABASE make_happy;
use make_happy;

--
-- Dumping data for table `t_comment`
--

LOCK TABLES `t_comment` WRITE;
INSERT INTO `t_comment` VALUES (1,7,5,'Very good','2019-06-05 10:20:05'),(2,8,5,'Have a nice day','2019-06-05 10:20:05'),(58,7,5,'hôm nay là thứ ba','2019-06-18 02:49:32'),(59,7,5,'昨日は火曜日','2019-06-18 02:50:23'),(60,7,5,'おはようございます','2019-06-18 03:13:12'),(61,7,5,'Have a good day!','2019-06-18 03:13:54'),(62,7,5,'hôm nay tôi mệt rồi!','2019-06-20 07:08:17'),(63,7,5,'疲れました！','2019-06-20 07:12:17'),(64,7,5,'smile','2019-06-20 07:13:47'),(65,7,5,'月曜日','2019-06-20 07:16:17'),(66,7,5,'一日中働 いちにちちゅうはたら いて 疲 つか れた','2019-06-20 07:37:27'),(67,7,5,'疲れる','2019-06-20 07:41:25'),(68,7,5,'疲れる','2019-06-20 07:44:09'),(69,7,5,'この シャツ シャツ は 疲 つか れた\n','2019-06-20 07:45:21'),(70,7,5,'疲れる','2019-06-20 07:46:39'),(71,7,5,'疲れる','2019-06-20 07:50:40'),(72,7,5,'comment','2019-06-20 07:53:07'),(73,7,5,'hello','2019-06-20 07:53:44'),(74,7,5,'sdsdas','2019-06-20 07:54:20'),(75,7,5,'\n\n','2019-06-20 07:56:15'),(76,7,5,'\n','2019-06-20 07:56:15'),(77,7,5,'213123123','2019-06-20 07:56:24'),(78,7,5,'thao aaaaa','2019-06-20 07:57:30'),(79,7,5,'monday','2019-06-20 07:58:35'),(80,7,5,'monday','2019-06-20 08:00:52'),(81,7,5,'qeqweqweqw','2019-06-20 08:02:15'),(82,7,5,'hhddidi','2019-06-20 08:03:13'),(83,7,5,'tueday','2019-06-20 08:24:31'),(84,7,5,'sdsadasdsadsadsa','2019-06-20 08:24:55'),(85,7,5,'adsadsadsad','2019-06-20 08:25:04'),(86,7,5,'moday','2019-06-20 08:25:55'),(87,7,5,'dsfsdfdfdf','2019-06-20 08:27:36'),(88,7,5,'monday','2019-06-20 08:28:49'),(89,7,5,'cmtJapannese','2019-06-20 08:29:42'),(90,7,5,'monday','2019-06-20 08:30:54'),(91,7,5,'dsfdsfsdfsfd','2019-06-20 08:34:14'),(92,7,5,'monday','2019-06-20 08:36:22'),(93,7,5,'monday','2019-06-20 08:37:46'),(94,7,5,'aaaaaa','2019-06-20 08:38:28'),(95,7,5,'monday','2019-06-20 08:39:36'),(96,7,5,'monday','2019-06-20 08:40:58'),(97,7,5,'tueday','2019-06-20 08:41:36'),(98,7,5,'この シャツ シャツ は 疲 つか れた','2019-06-20 08:49:28'),(99,7,5,'疲れる','2019-06-20 08:49:43'),(100,11,39,'why???','2019-06-27 04:48:40'),(101,11,39,'hello','2019-07-01 09:32:49'),(102,12,39,'what!','2019-07-01 09:38:59'),(103,11,39,'đói quá!','2019-07-01 09:45:37'),(104,11,39,'hôm nay là thứ 2','2019-07-01 09:45:49'),(105,2,5,'1234','2019-07-08 08:45:05'),(106,12,5,'dfdg','2019-07-08 09:47:10');
UNLOCK TABLES;

--
-- Dumping data for table `t_notification`
--

LOCK TABLES `t_notification` WRITE;
INSERT INTO `t_notification` VALUES (1,NULL,2,0,'<a href=\'/leaders/team?date=2019-08-01\'> created report day 2019-08-01</a>','2019-08-01 03:46:47'),(2,NULL,2,0,'<a href=\'/leaders/team?date=2019-08-01\'> created report day 2019-08-01</a>','2019-08-01 03:46:47'),(3,NULL,2,0,'<a href=\'/leaders/team?date=2019-08-01\'> created report day 2019-08-01</a>','2019-08-01 03:48:01'),(4,NULL,2,0,'<a href=\'/leaders/team?date=2019-08-01\'> created report day 2019-08-01</a>','2019-08-01 03:48:01'),(5,2,2,1,'<a href=\'/leaders/team?date=2019-08-01\'> created report day 2019-08-01</a>','2019-08-01 03:48:47'),(6,6,2,0,'<a href=\'/leaders/team?date=2019-08-01\'> created report day 2019-08-01</a>','2019-08-01 03:48:47'),(7,2,2,1,'<a href=\'/leaders/team?date=2019-08-01\'> created report day 2019-08-01</a>','2019-08-01 03:49:54'),(8,6,2,0,'<a href=\'/leaders/team?date=2019-08-01\'> created report day 2019-08-01</a>','2019-08-01 03:49:54'),(9,2,2,1,'<a href=\'/leaders/team?date=2019-08-01\'> created report day 2019-08-01</a>','2019-08-01 03:52:16'),(10,6,2,0,'<a href=\'/leaders/team?date=2019-08-01\'> created report day 2019-08-01</a>','2019-08-01 03:52:16'),(11,2,2,1,'<a href=\'/leaders/team?date=2019-08-01\'> created report day 2019-08-01</a>','2019-08-01 03:53:10'),(12,6,2,0,'<a href=\'/leaders/team?date=2019-08-01\'> created report day 2019-08-01</a>','2019-08-01 03:53:10'),(13,1,2,0,'<a href=/reports?teamid=13>added you to the group Team 1</a>','2019-08-01 03:54:56');
UNLOCK TABLES;

--
-- Dumping data for table `t_report`
--

LOCK TABLES `t_report` WRITE;
INSERT INTO `t_report` VALUES (1,2,3,NULL,80,'have a nice day!',1,'','2019-06-27 10:07:30'),(2,7,1,NULL,60,'comment allow day',2,'{\"2019-06-24 03:58:16\":[{\"Problem\":\"i have a good day\",\"Did it affect to work?\":\"no\",\"How did it affect to work?\":\"sfdsfgfg\",\"How do you think how to fix the problem and affect?\":\"dgfhgfh\",\"What do you want leader help you?\":\"dhgfh\"}]}','2019-06-21 07:10:40'),(4,2,2,NULL,90,'it\'s doable',1,'','2019-06-21 07:10:40'),(5,7,1,1,80,'have a nice day!',2,'{\"2019-06-14 03:51:15\":[{\"Problem\":\"I have a problem\",\"Did it affect to work?\":\"Yes\",\"How did it affect to work?\":\"ewrwerwerwe\",\"How do you think how to fix the problem and affect?\":\"ewrwerwer\",\"What do you want leader help you?\":\"ewrwerewrwe\"}]}','2019-06-07 10:09:32'),(64,2,2,11,10,'dfgf zfsd',1,NULL,'2019-08-01 03:57:48'),(65,2,2,13,10,'Report team 13',0,NULL,'2019-08-01 04:08:59'),(66,2,2,12,10,'Report team 12',0,NULL,'2019-08-01 04:09:50'),(68,7,2,15,10,'tinhtinh@tmh-tech;ab.vn create report',0,NULL,'2019-08-01 06:50:26'),(69,2,2,15,10,'nhinhdt@tmh-techlab.vn',0,NULL,'2019-08-01 06:51:23'),(70,2,2,15,20,'nhinhdt@tmh-techlab.vn ngay khac',1,NULL,'2019-06-07 10:09:32'),(71,2,1,15,40,'nhinhdt@tmh-techlab.vn ngay khac done',2,NULL,'2019-06-05 10:09:32'),(72,2,2,16,30,'Team ăn chơi đi bơi',1,NULL,'2019-08-01 09:52:04'),(73,2,2,17,10,'report team test',0,NULL,'2019-08-02 02:34:58'),(75,2,2,16,10,'report team 16',0,NULL,'2019-08-02 06:18:19'),(77,7,2,16,20,'Report team 16 member',0,NULL,'2019-08-02 06:25:06'),(80,2,2,15,20,'nhinh12 create report',0,NULL,'2019-08-02 06:42:26');
UNLOCK TABLES;

--
-- Dumping data for table `t_team`
--

LOCK TABLES `t_team` WRITE;
INSERT INTO `t_team` VALUES (1,'team1',NULL,'bbbbbbbbbeeeeee','2019-07-16 07:38:33','2019-07-31 08:16:24'),(2,'TMH',NULL,NULL,'2019-07-16 07:38:33','2019-07-31 02:22:19'),(3,'EM',NULL,'xdgfchfg','2019-07-16 07:38:33','2019-07-31 02:22:19'),(11,'Team 11 bbbb',NULL,'dfgdfhf','2019-07-31 08:50:27','2019-08-05 07:48:51'),(12,'Team 12',NULL,'asfsdf','2019-07-31 09:30:16','2019-08-01 07:10:56'),(13,'Team 13',NULL,'','2019-08-01 03:54:56','2019-08-01 04:28:49'),(14,'Team 14',NULL,'sfsdfs','2019-08-01 04:12:54','2019-08-01 04:37:23'),(15,'Team tinh tinh',NULL,'Linh luong thoi','2019-08-01 06:49:58','2019-08-01 06:49:58'),(16,'Team ăn chơi',NULL,'','2019-08-01 09:51:41','2019-08-01 10:41:07'),(17,'Team test   dgdfg',NULL,'editTeamxcbvc sdfsdfs','2019-08-01 10:44:04','2019-08-02 07:45:06');
UNLOCK TABLES;

--
-- Dumping data for table `t_user`
--

LOCK TABLES `t_user` WRITE;
INSERT INTO `t_user` VALUES (1,2,'thaophuong','$2a$10$xfuypn8IHMNfS.DUdYImZOkI.jzSgreSoJHeQzR2kPUxfM3GhpboK','thap@tmh-techlab.vn',NULL,NULL,NULL,NULL,NULL,'2019-07-30 06:51:45','2019-07-30 06:51:45'),(2,2,'nhinh12','$2a$10$xfuypn8IHMNfS.DUdYImZOkI.jzSgreSoJHeQzR2kPUxfM3GhpboK','nhinhdt@tmh-techlab.vn',NULL,NULL,NULL,NULL,NULL,'2019-07-17 07:29:40','2019-07-17 07:29:40'),(3,2,'aaaaaa','$2a$10$xfuypn8IHMNfS.DUdYImZOkI.jzSgreSoJHeQzR2kPUxfM3GhpboK','nhinhdsgdfgdt@tmh-techlab.vn',NULL,NULL,NULL,NULL,NULL,'2019-07-31 08:28:09','2019-07-31 08:28:09'),(4,2,'bbbbb','$2a$10$xfuypn8IHMNfS.DUdYImZOkI.jzSgreSoJHeQzR2kPUxfM3GhpboK','nhinhddgxfgdsgdfgdt@tmh-techlab.vn',NULL,NULL,NULL,NULL,NULL,'2019-07-31 08:28:09','2019-07-31 08:28:09'),(5,2,'cccc','$2a$10$xfuypn8IHMNfS.DUdYImZOkI.jzSgreSoJHeQzR2kPUxfM3GhpboK','dtgdgdsgdfgdt@tmh-techlab.vn',NULL,NULL,NULL,NULL,NULL,'2019-07-31 08:28:09','2019-07-31 08:28:09'),(6,2,'ddddd','$2a$10$xfuypn8IHMNfS.DUdYImZOkI.jzSgreSoJHeQzR2kPUxfM3GhpboK','fdgfhfgj@tmh-techlab.vn',NULL,NULL,NULL,NULL,NULL,'2019-07-31 08:28:09','2019-07-31 08:28:09'),(7,2,'tinhtinh','$2a$10$.EE1REL0KLuldaMu5xcmB.yYpbRed9Ilh7kDaIQt3VKF/R.JJDvRm','tinhtinh@tmh-techlab.vn',NULL,NULL,NULL,NULL,NULL,'2019-08-01 06:49:16','2019-08-01 06:49:16');
UNLOCK TABLES;

--
-- Dumping data for table `t_user_team`
--

LOCK TABLES `t_user_team` WRITE;
INSERT INTO `t_user_team` VALUES (1,1,3,2,'2019-07-17 07:13:43','2019-07-30 12:29:53'),(11,2,11,1,'2019-07-31 08:50:27','2019-07-31 08:50:27'),(16,6,11,1,'2019-07-31 08:50:27','2019-08-05 07:48:51'),(17,2,12,1,'2019-07-31 09:30:16','2019-07-31 09:30:16'),(18,1,12,2,'2019-07-31 09:30:16','2019-08-01 07:10:56'),(23,2,13,1,'2019-08-01 03:54:56','2019-08-01 03:54:56'),(24,1,13,2,'2019-08-01 03:54:56','2019-08-01 04:28:49'),(25,3,13,2,'2019-08-01 03:54:56','2019-08-01 04:28:49'),(26,4,13,2,'2019-08-01 03:54:56','2019-08-01 04:28:49'),(27,5,13,2,'2019-08-01 03:54:56','2019-08-01 04:28:49'),(28,6,13,2,'2019-08-01 03:54:56','2019-08-01 04:28:49'),(29,2,14,1,'2019-08-01 04:12:54','2019-08-01 04:12:54'),(44,7,15,1,'2019-08-01 06:49:58','2019-08-01 06:49:58'),(45,1,15,2,'2019-08-01 06:49:58','2019-08-01 06:49:58'),(46,2,15,2,'2019-08-01 06:49:58','2019-08-01 06:49:58'),(47,3,15,2,'2019-08-01 06:49:58','2019-08-01 06:49:58'),(48,4,15,2,'2019-08-01 06:49:58','2019-08-01 06:49:58'),(49,5,15,2,'2019-08-01 06:49:58','2019-08-01 06:49:58'),(50,6,15,2,'2019-08-01 06:49:58','2019-08-01 06:49:58'),(51,2,16,1,'2019-08-01 09:51:41','2019-08-01 09:51:41'),(52,1,16,2,'2019-08-01 09:51:41','2019-08-01 10:37:55'),(53,3,16,2,'2019-08-01 09:51:41','2019-08-01 10:41:07'),(54,4,16,2,'2019-08-01 09:51:41','2019-08-01 10:41:07'),(55,5,16,2,'2019-08-01 09:51:41','2019-08-01 10:41:07'),(56,6,16,2,'2019-08-01 09:51:41','2019-08-01 10:41:07'),(57,7,16,2,'2019-08-01 09:51:41','2019-08-01 10:37:55'),(58,2,17,1,'2019-08-01 10:44:04','2019-08-01 10:44:04'),(59,1,17,1,'2019-08-01 10:44:04','2019-08-02 07:50:42'),(60,3,17,1,'2019-08-01 10:44:04','2019-08-02 07:50:42'),(61,4,17,1,'2019-08-01 10:44:04','2019-08-02 02:32:24'),(62,5,17,1,'2019-08-01 10:44:04','2019-08-01 10:45:21'),(63,6,17,1,'2019-08-01 10:44:04','2019-08-02 07:50:42'),(64,7,17,1,'2019-08-01 10:44:04','2019-08-02 07:50:42');
UNLOCK TABLES;

-- Dump completed on 2019-08-05 15:25:49
