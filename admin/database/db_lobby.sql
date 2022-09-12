/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.4.11-MariaDB : Database - db_lobby
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
  `akses` enum('admin','user') NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `account` */

insert  into `account`(`username`,`password`,`nama`,`gender`,`bio`,`photo`,`dibuat`,`akses`) values 
('admin','admin','admin','Laki-Laki','Admin',NULL,'2022-03-12','admin'),
('aliffathurrisqi','31032000Alif','Aliffathur Risqi Hidayat','Laki-Laki','Saya adalah Developer Forum Lobby, CEO Alfari Studio dan merupakan Mahasiswa Universitas Teknologi Yogyakarta','aliffathurrisqi_2.jpg','2022-03-12','user'),
('xannen','31032000Alif','xannen','Laki-Laki',NULL,NULL,'2022-03-12','admin');

/*Table structure for table `kategori` */

DROP TABLE IF EXISTS `kategori`;

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(50) DEFAULT NULL,
  `warna` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

/*Data for the table `kategori` */

insert  into `kategori`(`id`,`nama_kategori`,`warna`) values 
(1,'Admin','#0D6EFD'),
(5,'Lainnya','#838996'),
(6,'Tanya','#DC3545'),
(7,'Saran','#F4CA16'),
(9,'Mobile Legends','#0033cc'),
(10,'Rank','#009933'),
(11,'Hero','#33cccc'),
(12,'Bug','#800000'),
(13,'Magic Chess','#cc33ff');

/*Table structure for table `komentar` */

DROP TABLE IF EXISTS `komentar`;

CREATE TABLE `komentar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_post` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `komentar` varchar(1000) NOT NULL,
  `waktu` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `komentar` */

/*Table structure for table `post` */

DROP TABLE IF EXISTS `post`;

CREATE TABLE `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `waktu` datetime DEFAULT NULL,
  `konten` text NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `judul` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `post` */

insert  into `post`(`id`,`username`,`waktu`,`konten`,`kategori`,`judul`) values 
(1,'aliffathurrisqi','2022-03-12 08:33:35','MPL ID Season 9 sudah memasuki minggu kedua. Season kali ini belum ada tim yang dominan penuh tim-tim kuat masih saling memperebutkan posisi, siapakah yang akan bertahta di akhir season kali ini ?. menarik untuk ditunggu.','9','Tim manakah yang akan jadi juara MPL Indonesia Season 9?'),
(2,'xannen','2022-03-12 10:21:37','XIN dan Skylar adalah dua proplayer yang sangat berbakat mereka memiliki mikro dan makro ingame yang diatas rata-rata. Sayangnya mereka gagal menembus skuad utama Timnas MLBB Indonesia yang akan berkompetisi di SEA Games. mengapa hal tersebut bisa terjadi ?.','9','Mengapa XIN dan Skylar tidak terpilih jadi pemain utama Timnas Indonesia?');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
