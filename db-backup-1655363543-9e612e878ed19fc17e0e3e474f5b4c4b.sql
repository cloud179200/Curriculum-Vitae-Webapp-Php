DROP TABLE IF EXISTS contact;

CREATE TABLE `contact` (
  `cv_id` int(100) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `message` longtext NOT NULL,
  PRIMARY KEY (`contact_id`),
  KEY `cv_id` (`cv_id`),
  CONSTRAINT `contact_ibfk_1` FOREIGN KEY (`cv_id`) REFERENCES `cv_information` (`cv_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;




DROP TABLE IF EXISTS cv_information;

CREATE TABLE `cv_information` (
  `cv_id` int(100) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date_of_birth` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `detail` longtext NOT NULL,
  `status` tinyint(1) NOT NULL,
  `desired_job` varchar(255) NOT NULL,
  `gender` tinyint(1) NOT NULL,
  PRIMARY KEY (`cv_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

INSERT INTO cv_information VALUES("4","abcd","Viá»‡t Anh","2000-09-17","Thanh HÃ³a","0394252608","{\"careerGoals\":\"Nope\",\"skill\":\"<p>12312312</p>\",\"certificate\":\"\",\"experience\":\"<ul><li><i><strong>e12312dasdasdasd</strong></i></li><li><i><strong>ssaSSDASDAS</strong></i></li><li><i><strong>dfsdfsdfsd</strong></i></li></ul>\",\"education\":\"<p>eqweqw2312fsdf213123123123123123</p>\"}","1","blaster","0");



DROP TABLE IF EXISTS users;

CREATE TABLE `users` (
  `user_id` int(3) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_firstname` varchar(255) NOT NULL,
  `user_lastname` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_role` varchar(255) NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `gender` tinyint(1) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

INSERT INTO users VALUES("36","abcd","$2y$10$05LUEuM1obZqzSE2WQz9P.N6SYQ7IU.r1j0COk90johEaI6HY6Tsm","Viet","Anh","1851060380@e.tlu.edu.vn","user","1","0");



DROP TABLE IF EXISTS users_online;

CREATE TABLE `users_online` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(255) NOT NULL,
  `expired` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`),
  CONSTRAINT `users_online_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=150 DEFAULT CHARSET=latin1;

INSERT INTO users_online VALUES("149","eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpYXQiOjE2NTUzMTMxMTUsImlzcyI6ImxvY2FsaG9zdCIsIm5iZiI6MTY1NTMxMzExNSwiZXhwIjoxNjU1OTE3OTE1LCJ1c2VyTmFtZSI6ImFiY2QifQ.PAIjJh-YSe6BkdKmbcCYISniUTlDoiDhhP6G3RYULpPcq92BhfuIQwJz8JT6NiTAdTeG8xrhJnNW-P3ysh0Clw","1655917915","abcd");


