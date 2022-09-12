/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.4.18-MariaDB : Database - db_lobby
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `account` */

DROP TABLE IF EXISTS `account`;

CREATE TABLE `account` (
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `gender` enum('Laki-Laki','Perempuan') DEFAULT NULL,
  `bio` varchar(250) DEFAULT NULL,
  `photo` varchar(9999) DEFAULT NULL,
  `dibuat` date DEFAULT NULL,
  `blokir` date DEFAULT NULL,
  `akses` enum('admin','user','blokir') NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `account` */

insert  into `account`(`username`,`password`,`nama`,`gender`,`bio`,`photo`,`dibuat`,`blokir`,`akses`) values 
('admin','admin','Admin Lobby','Laki-Laki','Saya admin forum diskusi lobby.',NULL,'2022-03-12',NULL,'admin'),
('aliffathurrisqi','31032000Alif','Aliffathur Risqi Hidayat','Laki-Laki','Saya adalah Developer Forum Lobby, CEO Alfari Studio dan merupakan Mahasiswa Universitas Teknologi Yogyakarta','saber.jpg','2022-03-12',NULL,'user'),
('inocent','123','inocent','Laki-Laki','','inocent20220408084540.jpg','2022-04-09',NULL,'user'),
('marukawa','123','marukawa','Laki-Laki','','','2022-04-02',NULL,'user'),
('xannen','31032000Alif','Diego Varsandi','Laki-Laki','Saya Varsandi','xannen20220402040215.jpg','2022-03-12',NULL,'user');

/*Table structure for table `dilihat` */

DROP TABLE IF EXISTS `dilihat`;

CREATE TABLE `dilihat` (
  `id` varchar(100) NOT NULL,
  `id_post` int(11) NOT NULL,
  `sumber` text NOT NULL,
  `waktu` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `dilihat` */

insert  into `dilihat`(`id`,`id_post`,`sumber`,`waktu`) values 
('1admin',1,'admin','2022-04-09 15:30:04'),
('1aliffathurrisqi',1,'aliffathurrisqi','2022-04-09 15:31:23'),
('1inocent',1,'inocent','2022-04-09 15:45:50'),
('2admin',2,'admin','2022-04-09 15:29:59'),
('2aliffathurrisqi',2,'aliffathurrisqi','2022-04-09 15:45:02'),
('3admin',3,'admin','2022-04-09 15:28:37'),
('3aliffathurrisqi',3,'aliffathurrisqi','2022-04-09 15:31:28'),
('3inocent',3,'inocent','2022-04-09 16:06:19'),
('4admin',4,'admin','2022-04-09 15:18:13'),
('4aliffathurrisqi',4,'aliffathurrisqi','2022-04-09 15:42:33'),
('4inocent',4,'inocent','2022-04-09 16:42:31'),
('5admin',5,'admin','2022-05-29 21:28:14'),
('5aliffathurrisqi',5,'aliffathurrisqi','2022-04-09 16:10:49'),
('5marukawa',5,'marukawa','2022-04-09 16:21:39'),
('5xannen',5,'xannen','2022-04-12 15:57:48');

/*Table structure for table `kategori` */

DROP TABLE IF EXISTS `kategori`;

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(50) DEFAULT NULL,
  `warna` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;

/*Data for the table `kategori` */

insert  into `kategori`(`id`,`nama_kategori`,`warna`) values 
(1,'Admin','#38cdff'),
(5,'Lainnya','#838996'),
(6,'Tanya','#ff2e2e'),
(7,'Saran','#ffd92e'),
(9,'Mobile Legends','#2465ff'),
(10,'Rank','#009933'),
(11,'Hero','#cc7d33'),
(12,'Bug','#a00d0d'),
(16,'Magic Chess','#ff00d0'),
(17,'Turnamen','#ffc800');

/*Table structure for table `komentar` */

DROP TABLE IF EXISTS `komentar`;

CREATE TABLE `komentar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_post` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `komentar` text NOT NULL,
  `waktu` datetime DEFAULT NULL,
  `konfirmasi` enum('Ya','Tidak') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

/*Data for the table `komentar` */

insert  into `komentar`(`id`,`id_post`,`username`,`komentar`,`waktu`,`konfirmasi`) values 
(1,3,'xannen','Kalo boleh jujur memang blunder sih, tapi posisi lemon terlalu kepepet dia berada di posisi yang salah juga','2022-03-12 22:04:33','Ya'),
(5,3,'aliffathurrisqi','karena penempatan posisi salah makanya jadi blunder gan.','2022-03-12 22:35:59','Ya'),
(9,4,'aliffathurrisqi','jujur aja gua liat GEEK FAM season ini emang agak aneh, mereka kek gak punya opsi strategi yang pas lebih banyak bikin antisipasi lawan daripada bikin gameplay mereka sendiri','2022-04-09 15:00:54','Ya'),
(12,4,'admin','mereka ketinggalan meta','2022-04-09 15:11:23','Ya'),
(13,1,'inocent','RRQ HOSHI !!!!!','2022-04-09 15:45:56','Ya'),
(14,5,'marukawa','asikk nature spirit jadi lebih enak sekarang','2022-04-09 16:21:54','Ya'),
(16,4,'admin','ok','2022-05-29 21:20:26','Ya');

/*Table structure for table `laporan` */

DROP TABLE IF EXISTS `laporan`;

CREATE TABLE `laporan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pelapor` text NOT NULL,
  `tipe_laporan` enum('user','post','komentar') NOT NULL,
  `suspect` text NOT NULL,
  `alasan` text NOT NULL,
  `waktu` datetime NOT NULL,
  `konfirmasi` enum('Ya','Tidak') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;

/*Data for the table `laporan` */

insert  into `laporan`(`id`,`pelapor`,`tipe_laporan`,`suspect`,`alasan`,`waktu`,`konfirmasi`) values 
(1,'aliffathurrisqi','user','xannen','Pengguna ini melakukan penipuan','2022-04-03 12:55:05','Tidak'),
(2,'aliffathurrisqi','post','4','postingan ini mengandung sara!','2022-05-29 19:49:55','Tidak'),
(3,'xannen','komentar','12\r\n','komentar mengandung sara','2022-05-29 20:00:34','Tidak'),
(7,'admin','post','2','gak jelas banget sih ini postingan...','2022-05-30 17:09:03','Tidak'),
(8,'admin','komentar','9','komentar ini terlalu rasis','2022-05-30 17:19:42','Tidak'),
(9,'admin','post','5','toxic','2022-05-30 17:27:44','Tidak'),
(10,'admin','komentar','14','gaje','2022-05-30 17:27:52','Tidak'),
(11,'aliffathurrisqi','user','aliffathurrisqi','akun ini mencurigakan..','2022-05-30 17:46:34','Tidak'),
(12,'aliffathurrisqi','user','aliffathurrisqi','akun ini mencurigakan..','2022-05-30 17:46:48','Tidak'),
(13,'xannen','user','aliffathurrisqi','akun ini pernah menipu saya...','2022-05-30 17:50:54','Tidak');

/*Table structure for table `like_unlike` */

DROP TABLE IF EXISTS `like_unlike`;

CREATE TABLE `like_unlike` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `id_post` int(11) NOT NULL,
  `waktu` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4;

/*Data for the table `like_unlike` */

insert  into `like_unlike`(`id`,`username`,`id_post`,`waktu`) values 
(25,'inocent',1,'2022-04-09 14:30:11'),
(26,'aliffathurrisqi',3,'2022-04-09 14:51:51'),
(28,'inocent',4,'2022-04-09 14:56:35'),
(30,'admin',3,'2022-04-09 15:02:11'),
(31,'admin',1,'2022-04-09 15:02:13'),
(33,'admin',2,'2022-04-09 15:02:18'),
(37,'admin',4,'2022-04-09 15:27:25'),
(38,'aliffathurrisqi',1,'2022-04-09 15:31:25'),
(39,'aliffathurrisqi',2,'2022-04-09 15:31:50'),
(42,'marukawa',1,'2022-04-09 16:21:30'),
(43,'marukawa',3,'2022-04-09 16:21:32'),
(44,'marukawa',4,'2022-04-09 16:21:36'),
(45,'marukawa',5,'2022-04-09 16:21:38'),
(46,'xannen',4,'2022-04-12 15:55:23'),
(47,'xannen',3,'2022-04-12 15:55:26'),
(48,'aliffathurrisqi',5,'2022-05-23 13:53:24');

/*Table structure for table `notifikasi` */

DROP TABLE IF EXISTS `notifikasi`;

CREATE TABLE `notifikasi` (
  `id` varchar(100) NOT NULL,
  `username` text NOT NULL,
  `tipe` enum('suka','komentar') NOT NULL,
  `notif` text NOT NULL,
  `sumber` text NOT NULL,
  `id_post` int(11) NOT NULL,
  `waktu` datetime NOT NULL,
  `dibaca` enum('Ya','Tidak') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `notifikasi` */

insert  into `notifikasi`(`id`,`username`,`tipe`,`notif`,`sumber`,`id_post`,`waktu`,`dibaca`) values 
('K1inocent','aliffathurrisqi','komentar','baru saja mengomentari diskusi Anda tentang <strong>Tim manakah yang akan jadi juara MPL Indonesia Season 9?</strong>','inocent',1,'2022-04-09 15:45:56','Tidak'),
('K2aliffathurrisqi','xannen','komentar','baru saja mengomentari diskusi Anda tentang <strong>Mengapa XIN dan Skylar tidak terpilih jadi pemain utama Timnas Indonesia?</strong>','aliffathurrisqi',2,'2022-04-09 21:04:00','Tidak'),
('K4admin','inocent','komentar','baru saja mengomentari diskusi Anda tentang <strong>Ada apa dengan GEEK FAM?</strong>','admin',4,'2022-04-09 15:11:23','Ya'),
('K4aliffathurrisqi','inocent','komentar','baru saja mengomentari diskusi Anda','aliffathurrisqi',4,'2022-04-09 15:00:54','Ya'),
('K5marukawa','aliffathurrisqi','komentar','baru saja mengomentari diskusi Anda tentang <strong>Patch baru Magic Chess, Nature Spirit comeback?</strong>','marukawa',5,'2022-04-09 16:21:54','Tidak'),
('L1admin','aliffathurrisqi','suka','baru saja menyukai diskusi Anda','admin',1,'2022-04-09 15:02:13','Ya'),
('L1aliffathurrisqi','aliffathurrisqi','suka','baru saja menyukai diskusi Anda tentang <strong>Tim manakah yang akan jadi juara MPL Indonesia Season 9?</strong>','aliffathurrisqi',1,'2022-04-09 15:31:25','Ya'),
('L1inocent','aliffathurrisqi','suka','baru saja menyukai diskusi Anda','inocent',1,'2022-04-09 14:30:11','Ya'),
('L1marukawa','aliffathurrisqi','suka','baru saja menyukai diskusi Anda tentang <strong>Tim manakah yang akan jadi juara MPL Indonesia Season 9?</strong>','marukawa',1,'2022-04-09 16:21:30','Tidak'),
('L2admin','xannen','suka','baru saja menyukai diskusi Anda','admin',2,'2022-04-09 15:02:18','Tidak'),
('L2aliffathurrisqi','xannen','suka','baru saja menyukai diskusi Anda tentang <strong>Mengapa XIN dan Skylar tidak terpilih jadi pemain utama Timnas Indonesia?</strong>','aliffathurrisqi',2,'2022-04-09 15:31:50','Tidak'),
('L3admin','aliffathurrisqi','suka','baru saja menyukai diskusi Anda','admin',3,'2022-04-09 15:02:11','Ya'),
('L3aliffathurrisqi','aliffathurrisqi','suka','baru saja menyukai diskusi Anda','aliffathurrisqi',3,'2022-04-09 14:51:51','Ya'),
('L3inocent','aliffathurrisqi','suka','baru saja menyukai diskusi Anda','inocent',3,'2022-04-09 14:30:06','Ya'),
('L3marukawa','aliffathurrisqi','suka','baru saja menyukai diskusi Anda tentang <strong>Blunder  \"Lemon\" membuat RRQ  ditumbangkan EVOS</strong>','marukawa',3,'2022-04-09 16:21:32','Tidak'),
('L3xannen','aliffathurrisqi','suka','baru saja menyukai diskusi Anda tentang <strong>Blunder  \"Lemon\" membuat RRQ  ditumbangkan EVOS</strong>','xannen',3,'2022-04-12 15:55:26','Tidak'),
('L4','inocent','suka','baru saja menyukai diskusi Anda tentang <strong>Ada apa dengan GEEK FAM?</strong>','',4,'2022-04-09 15:55:26','Ya'),
('L4admin','inocent','suka','baru saja menyukai diskusi Anda','admin',4,'2022-04-09 15:02:10','Ya'),
('L4aliffathurrisqi','inocent','suka','baru saja menyukai diskusi Anda','aliffathurrisqi',4,'2022-04-09 14:52:23','Ya'),
('L4inocent','inocent','suka','baru saja menyukai diskusi Anda','inocent',4,'2022-04-09 14:56:35','Ya'),
('L4marukawa','inocent','suka','baru saja menyukai diskusi Anda tentang <strong>Ada apa dengan GEEK FAM?</strong>','marukawa',4,'2022-04-09 16:21:36','Tidak'),
('L4xannen','inocent','suka','baru saja menyukai diskusi Anda tentang <strong>Ada apa dengan GEEK FAM?</strong>','xannen',4,'2022-04-12 15:55:23','Tidak'),
('L5aliffathurrisqi','aliffathurrisqi','suka','baru saja menyukai diskusi Anda tentang <strong>Patch baru Magic Chess, Nature Spirit comeback?</strong>','aliffathurrisqi',5,'2022-04-09 16:10:48','Ya'),
('L5marukawa','aliffathurrisqi','suka','baru saja menyukai diskusi Anda tentang <strong>Patch baru Magic Chess, Nature Spirit comeback?</strong>','marukawa',5,'2022-04-09 16:21:38','Tidak');

/*Table structure for table `post` */

DROP TABLE IF EXISTS `post`;

CREATE TABLE `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `waktu` datetime DEFAULT NULL,
  `konten` text NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `judul` text NOT NULL,
  `konfirmasi` enum('Ya','Tidak') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

/*Data for the table `post` */

insert  into `post`(`id`,`username`,`waktu`,`konten`,`kategori`,`judul`,`konfirmasi`) values 
(1,'aliffathurrisqi','2022-03-12 08:33:35','MPL ID Season 9 sudah memasuki minggu kedua. Season kali ini belum ada tim yang dominan penuh tim-tim kuat masih saling memperebutkan posisi, siapakah yang akan bertahta di akhir season kali ini ?. menarik untuk ditunggu.','9','Tim manakah yang akan jadi juara MPL Indonesia Season 9?','Ya'),
(2,'xannen','2022-03-12 10:21:37','XIN dan Skylar adalah dua proplayer yang sangat berbakat mereka memiliki mikro dan makro ingame yang diatas rata-rata. Sayangnya mereka gagal menembus skuad utama Timnas MLBB Indonesia yang akan berkompetisi di SEA Games. mengapa hal tersebut bisa terjadi ?.','9','Mengapa XIN dan Skylar tidak terpilih jadi pemain utama Timnas Indonesia?','Ya'),
(3,'aliffathurrisqi','2022-03-12 21:24:53','Pertandingan el clasico yang mempertemukan RRQ Hoshi dengan EVOS Legend di weekend sebelumnya berlangsung seru. kedua tim sama-sama tidak mau kalah dan menampilkan permainan terbaik. Hingga skor menjadi 1-1, game ketiga menjadi penentuan siapa tim yang akhirnya memenangkan pertandingan. akan tetapi blunder yang dilakukan \"Lemon\" membuat RRQ Hoshi akhirnya ditumbangkan EVOS Legend.','5','Blunder \"Lemon\" membuat RRQ ditumbangkan EVOS','Ya'),
(4,'inocent','2022-04-09 01:47:00','MPL ID Season 9 sudah mau kelar. Tapi sampai sekarang GEEK FAM belum pernah menang lawan siapapun. Sebenarnya apa yang terjadi pada tim mereka?','17','Ada apa dengan GEEK FAM?','Ya'),
(5,'aliffathurrisqi','2022-04-09 16:10:45','Patch baru magic chess kali ini cukup banyak. Banyak buff pada sinergi dan lagi-lagi nerf pada sinergi swordman, yang menarik nature spirit seperti diuntungkan di update kali ini dimana buff besar pada sinergi ini sekaligus buff pada hero seperti eudora dan roger yang di buff job gunnernya.','16','Patch baru Magic Chess, Nature Spirit comeback?','Ya');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
