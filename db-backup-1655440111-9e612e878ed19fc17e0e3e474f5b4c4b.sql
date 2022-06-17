DROP TABLE IF EXISTS contact;

CREATE TABLE `contact` (
  `cv_id` int(100) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `message` longtext NOT NULL,
  PRIMARY KEY (`contact_id`),
  KEY `cv_id` (`cv_id`),
  CONSTRAINT `contact_ibfk_1` FOREIGN KEY (`cv_id`) REFERENCES `cv_information` (`cv_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

INSERT INTO contact VALUES("7","Viá»‡t Anh","DÃ­adiasdasd","cloud179200@gmail.com","10","Äá»Št cá»¥ Ä‘an phÆ°á»£ng luÃ´n"),
("7","Viá»‡t Anh","DÃ­adiasdasd","cloud179200@gmail.com","11","Äá»Št cá»¥ Ä‘an phÆ°á»£ng luÃ´n"),
("7","?","?","aaa@gmail.com","12","cv nhÆ° L"),
("10","pro","0332","sd@gmail.com","14","?");



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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

INSERT INTO cv_information VALUES("4","abcd","Viá»‡t Anh","2000-09-17","Thanh HÃ³a","0394252608","{\"careerGoals\":\"Nope\",\"skill\":\"<p>12312312</p>\",\"certificate\":\"\",\"experience\":\"<ul><li><i><strong>e12312dasdasdasd</strong></i></li><li><i><strong>ssaSSDASDAS</strong></i></li><li><i><strong>dfsdfsdfsd</strong></i></li></ul>\",\"education\":\"<p>eqweqw2312fsdf213123123123123123</p>\"}","1","blaster","0"),
("5","anminh1","null","null","null","null","null","0","null","0"),
("6","anminh2","null","null","null","null","null","0","null","1"),
("7","anminh3","a","2009-12-31","a","1234567890","{\"careerGoals\":\"aaasfa\",\"skill\":\"<p>a</p>\",\"certificate\":\"<p>bab</p>\",\"experience\":\"<p>aaab</p>\",\"education\":\"<p>ssssaa</p>\"}","1","asaaa","1"),
("8","na","null","null","null","null","null","0","null","1"),
("9","na2","null","null","null","null","null","0","null","1"),
("10","73pro","anh","2022-06-03","qb","0376678263","{\"careerGoals\":\"pro\",\"skill\":\"<p>Ã¡d</p>\",\"certificate\":\"<p>Ã¡dasd</p>\",\"experience\":\"<p>Ã¡dasasd</p>\",\"education\":\"<p>Ã¡dasd</p>\"}","1","advertising manager","1"),
("11","36vip","36","2022-05-31","th","098","{\"careerGoals\":\"36\",\"skill\":\"\",\"certificate\":\"\",\"experience\":\"\",\"education\":\"\"}","1","accountant","1"),
("12","e","null","null","null","null","null","0","null","1"),
("13","abc","null","null","null","null","null","0","null","1"),
("14","abce","dung nguyen ","2000-11-17","nguyen van cu","0375434166","{\"careerGoals\":\"\",\"skill\":\"<p>wwer</p>\",\"certificate\":\"<p>rwerwer</p>\",\"experience\":\"<p><strong>werwerwer</strong></p>\",\"education\":\"<p>rwwe</p>\"}","1","editor","1");



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
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;

INSERT INTO users VALUES("36","abcd","$2y$10$05LUEuM1obZqzSE2WQz9P.N6SYQ7IU.r1j0COk90johEaI6HY6Tsm","Viet","Anh","1851060380@e.tlu.edu.vn","user","1","0"),
("37","anminh1","$2y$10$x017WV9ihWIo97hD4mm7iOqJwyVDPOwYXgZ61YfbJ7TV8MaNbMK1a","Minh","An","anminh1@gmail.com","user","0","0"),
("38","anminh2","$2y$10$ydRJeQTDdzDFWraOoq1zdunM0TEimrsrUwDjOnDzX5/A2K0rLGOS6","Nguyá»…n","An","anminh2@gmail.com","user","0","1"),
("39","anminh3","$2y$10$FjTFYnmfHPctnOuip20MD.n8A3ojXFuIPE4x6T6JP4alYquY2648S","Nguyá»…n","An","anminh0412@gmail.com","user","1","1"),
("40","na","$2y$10$ZV6v7mmj1YdvlkprHj5ofuYQ54/4IJaMyZYEfPjHUTCGfWiivGzQm","Le","Anh","na@gmail.com","user","0","1"),
("41","na2","$2y$10$Vr/9OKw5Ggosm4yoXa9HqOPC3pHatcLBsws4CKblT4KrUDOEgWAZC","le","na","na2@gmail.com","user","0","1"),
("42","73pro","$2y$10$QH.5zuCEpf/QW3Kkqt1AhOptkX6hTQD4gRx3e3MXp70t1Ji/0YTpy","LÃª ","Anh","tuaasnanh0511@gmail.com","user","1","1"),
("43","36vip","$2y$10$peV8kj6nfBZDBVbojxrFfuB20tsqplxZXKJ8HnXgb9Pfzy91YBCXK","le","anh","anhleqb2000@gmail.com","user","1","1"),
("44","e","$2y$10$ycBJWaiuBJxBNCnAIOJr6.DYwcM0S8hpcJmg9k5FtqSmbs.Gkt1T2","e","e","lengocanhb5ddt@gmail.com","user","0","1"),
("45","abc","$2y$10$/dKzsEGXCls501aZGiX1ROcf38c24jAyaaNtct2hZzO1hrRn3ax1G","Nguyen","Dung","dungnguyen17112000","user","0","1"),
("46","abce","$2y$10$tiM5nTeFMj1JhR2xBPlrx.z6ijdbMk0n.lFbgu5YVsxcoaLhIN2nq","Nguyen","Dung","zeddtt7@gmail.com","user","1","1");



DROP TABLE IF EXISTS users_online;

CREATE TABLE `users_online` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(255) NOT NULL,
  `expired` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`),
  CONSTRAINT `users_online_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=177 DEFAULT CHARSET=latin1;

INSERT INTO users_online VALUES("151","eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpYXQiOjE2NTUzNzE0OTAsImlzcyI6ImxvY2FsaG9zdCIsIm5iZiI6MTY1NTM3MTQ5MCwiZXhwIjoxNjU1OTc2MjkwLCJ1c2VyTmFtZSI6ImFubWluaDEifQ.iEtO8OVj4wE8C0gG3hUVc_xwDEUAFnLqdCLbx-sgSJDBBKWluEqcrJAOw6fhz5Ckby3KTa5QISXNSDgJxcU8pw","1655976290","anminh1"),
("152","eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpYXQiOjE2NTUzNzE2MzYsImlzcyI6ImxvY2FsaG9zdCIsIm5iZiI6MTY1NTM3MTYzNiwiZXhwIjoxNjU1OTc2NDM2LCJ1c2VyTmFtZSI6ImFubWluaDIifQ.UGjod4HlGZX2fFeDDXPkMBevb9O8o_ibwvWP-HhmZlzvuntmiO-i_ugicBWGUHStj5492yV2xzMxBH-UwlM1gQ","1655976436","anminh2"),
("157","eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpYXQiOjE2NTUzNzUyMDAsImlzcyI6ImxvY2FsaG9zdCIsIm5iZiI6MTY1NTM3NTIwMCwiZXhwIjoxNjU1OTgwMDAwLCJ1c2VyTmFtZSI6Im5hIn0.ZX6MS7IxQE5CCAfF5tLNXzfIKbuZW4QtXxeWHAZw6V-o-zRv0WFg6q-Bu4Osozc2On0IxRo-f8sXYvb8HDBpvw","1655980000","na"),
("158","eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpYXQiOjE2NTUzNzUyOTAsImlzcyI6ImxvY2FsaG9zdCIsIm5iZiI6MTY1NTM3NTI5MCwiZXhwIjoxNjU1OTgwMDkwLCJ1c2VyTmFtZSI6Im5hMiJ9.bGW0VkTsGM1BGNXK45qymuKaPtjWrkmtUaNELjqbuFhJRsZ3ITtEv9sR2aMMQ-YTGuyFekfJqWfp4VvQXzqZUg","1655980090","na2"),
("166","eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpYXQiOjE2NTUzNzkzMjksImlzcyI6ImxvY2FsaG9zdCIsIm5iZiI6MTY1NTM3OTMyOSwiZXhwIjoxNjU1OTg0MTI5LCJ1c2VyTmFtZSI6ImUifQ.aJyyFyB_7j8rLWbQQQncHLp7S6mUZgf1dqDRPnFOtQl2vxbtYTb53ElKj5YBbB7Wo3QypF1Gdd30x2PHQo38bg","1655984129","e"),
("169","eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpYXQiOjE2NTUzOTQxNDUsImlzcyI6ImxvY2FsaG9zdCIsIm5iZiI6MTY1NTM5NDE0NSwiZXhwIjoxNjU1OTk4OTQ1LCJ1c2VyTmFtZSI6ImFiYyJ9.dUh07ZT1otRh3GH86yovVWkFfMZGADfA4mnsPGAPImldHaZptp9XOaVxYFOGFgsWHB5tyVP7SejMttq--Cmhsw","1655998945","abc"),
("171","eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpYXQiOjE2NTUzOTY4NDIsImlzcyI6ImxvY2FsaG9zdCIsIm5iZiI6MTY1NTM5Njg0MiwiZXhwIjoxNjU2MDAxNjQyLCJ1c2VyTmFtZSI6IjczcHJvIn0.a77_rAoYYhsOmToqCvrffpPFTc5fCzm66s6_U7KtmCk-lT5k3Ckt29q0BzAlciDfUoZ6yCYlu0dobPISSuRu8A","1656001642","73pro");



