/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50505
Source Host           : 127.0.0.1:3306
Source Database       : kesehatan

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-02-12 19:11:08
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for golongan_logistik
-- ----------------------------
DROP TABLE IF EXISTS `golongan_logistik`;
CREATE TABLE `golongan_logistik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_golongan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `golongan obat` (`nama_golongan`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of golongan_logistik
-- ----------------------------
INSERT INTO `golongan_logistik` VALUES ('27', 'Addition');
INSERT INTO `golongan_logistik` VALUES ('21', 'Anastesi Lokal');
INSERT INTO `golongan_logistik` VALUES ('1', 'Antibiotik');
INSERT INTO `golongan_logistik` VALUES ('6', 'Antidiabetik');
INSERT INTO `golongan_logistik` VALUES ('9', 'Antidislipidemia');
INSERT INTO `golongan_logistik` VALUES ('3', 'Antifungal');
INSERT INTO `golongan_logistik` VALUES ('5', 'Antihipertensi');
INSERT INTO `golongan_logistik` VALUES ('8', 'Antihiperuresemic');
INSERT INTO `golongan_logistik` VALUES ('19', 'Antiparasit');
INSERT INTO `golongan_logistik` VALUES ('11', 'Antipiretik');
INSERT INTO `golongan_logistik` VALUES ('26', 'Antiseptik');
INSERT INTO `golongan_logistik` VALUES ('10', 'Antivertigo');
INSERT INTO `golongan_logistik` VALUES ('4', 'Antivirus');
INSERT INTO `golongan_logistik` VALUES ('23', 'Blades');
INSERT INTO `golongan_logistik` VALUES ('17', 'Bronkodilator');
INSERT INTO `golongan_logistik` VALUES ('30', 'Handscoon');
INSERT INTO `golongan_logistik` VALUES ('24', 'Kapas');
INSERT INTO `golongan_logistik` VALUES ('18', 'Mukolitik & Ekspektoran');
INSERT INTO `golongan_logistik` VALUES ('29', 'Needle');
INSERT INTO `golongan_logistik` VALUES ('20', 'Non-OAINS');
INSERT INTO `golongan_logistik` VALUES ('12', 'Non-SAID');
INSERT INTO `golongan_logistik` VALUES ('25', 'Plester');
INSERT INTO `golongan_logistik` VALUES ('31', 'Protection');
INSERT INTO `golongan_logistik` VALUES ('14', 'Regulator GIT');
INSERT INTO `golongan_logistik` VALUES ('13', 'SAID');
INSERT INTO `golongan_logistik` VALUES ('16', 'Suplemen');
INSERT INTO `golongan_logistik` VALUES ('22', 'Suture');
INSERT INTO `golongan_logistik` VALUES ('28', 'Syringe');
INSERT INTO `golongan_logistik` VALUES ('33', 'Tensocrepe');

-- ----------------------------
-- Table structure for logistik_alat_bahan_sekali_pakai
-- ----------------------------
DROP TABLE IF EXISTS `logistik_alat_bahan_sekali_pakai`;
CREATE TABLE `logistik_alat_bahan_sekali_pakai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) DEFAULT NULL,
  `golongan` varchar(255) DEFAULT NULL,
  `sediaan` varchar(255) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `bentuk` varchar(255) DEFAULT NULL,
  `harga_beli_satuan` varchar(255) DEFAULT NULL,
  `harga_jual_satuan` varchar(255) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of logistik_alat_bahan_sekali_pakai
-- ----------------------------
INSERT INTO `logistik_alat_bahan_sekali_pakai` VALUES ('1', 'Silk 2/0 + Jarum', '22', '75cm', 'IHS Medikom', 'Padat', '4000', '15000', '5');

-- ----------------------------
-- Table structure for logistik_obat_injeksi
-- ----------------------------
DROP TABLE IF EXISTS `logistik_obat_injeksi`;
CREATE TABLE `logistik_obat_injeksi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) DEFAULT NULL,
  `golongan` varchar(255) DEFAULT NULL,
  `sediaan` varchar(255) DEFAULT NULL,
  `bentuk` varchar(255) DEFAULT NULL,
  `harga_beli_satuan` varchar(255) DEFAULT NULL,
  `harga_jual_satuan` varchar(255) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of logistik_obat_injeksi
-- ----------------------------
INSERT INTO `logistik_obat_injeksi` VALUES ('1', 'Kanamycin', '1', '1g', 'Vial 1g', '13000', '75000', '10');

-- ----------------------------
-- Table structure for logistik_obat_oral
-- ----------------------------
DROP TABLE IF EXISTS `logistik_obat_oral`;
CREATE TABLE `logistik_obat_oral` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `golongan` varchar(255) DEFAULT NULL COMMENT 'antibiotik | antifungal | antivirus | antihipertensi | antidiabetik',
  `nama` varchar(500) DEFAULT NULL,
  `sediaan` varchar(255) DEFAULT NULL,
  `bentuk` varchar(255) DEFAULT NULL,
  `satuan_per_box` varchar(255) DEFAULT NULL,
  `harga_beli_per_box` varchar(255) DEFAULT NULL,
  `harga_jual_satuan` varchar(255) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of logistik_obat_oral
-- ----------------------------
INSERT INTO `logistik_obat_oral` VALUES ('1', '1', 'Amoxicillin', '500mg', 'Capsul', '100', '30000', '600', '60');
INSERT INTO `logistik_obat_oral` VALUES ('2', '1', 'Amoxicillin', '250mg', 'Capsul', '0', '0', '0', '0');
INSERT INTO `logistik_obat_oral` VALUES ('3', '1', 'Amoxicillin', '125mg/5ml', 'Syrup 60ml', '1', '2850', '7500', '9');
INSERT INTO `logistik_obat_oral` VALUES ('4', '1', 'Cefadroxil', '500mg', 'Capsul', '100', '65000', '1000', '30');

-- ----------------------------
-- Table structure for logistik_sigma_usus_externum
-- ----------------------------
DROP TABLE IF EXISTS `logistik_sigma_usus_externum`;
CREATE TABLE `logistik_sigma_usus_externum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_obat` varchar(255) DEFAULT NULL,
  `golongan` varchar(255) DEFAULT NULL,
  `presentase` varchar(255) DEFAULT NULL,
  `sediaan` varchar(255) DEFAULT NULL,
  `bentuk` varchar(255) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of logistik_sigma_usus_externum
-- ----------------------------

-- ----------------------------
-- Table structure for log_logistik
-- ----------------------------
DROP TABLE IF EXISTS `log_logistik`;
CREATE TABLE `log_logistik` (
  `id` int(11) NOT NULL,
  `jenis_logistik` varchar(255) DEFAULT NULL,
  `id_obat` varchar(255) DEFAULT NULL,
  `stok_tersisa` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of log_logistik
-- ----------------------------

-- ----------------------------
-- Table structure for settingan
-- ----------------------------
DROP TABLE IF EXISTS `settingan`;
CREATE TABLE `settingan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of settingan
-- ----------------------------
INSERT INTO `settingan` VALUES ('1', '2019-01-27 09:26:17');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `sip` varchar(50) NOT NULL,
  `hak_akses` varchar(225) NOT NULL,
  `alamat` varchar(500) NOT NULL,
  `jenis_kelamin` varchar(50) NOT NULL,
  `NIK` varchar(50) NOT NULL,
  `foto` varchar(555) NOT NULL,
  `verified` varchar(50) NOT NULL,
  `nama` varchar(225) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'admin', 'd12254da81c0b155767984b3c0e721129b320e95fab8d1edb34a494964a115a2', '1231231231231231231231231231233123', 'admin', 'Laki - Laki ', 'gajayana no563', '1231231231231231', 'assets/images/users_photo/dragon-ball.jpg', 'sudah', 'dr. admin');
INSERT INTO `user` VALUES ('2', 'dokter', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', '446.DU/1616.1/35.73.302/2018', 'dokter', 'Laki - Laki ', 'jalan mawar 45 malangJln. Mayjend Sungkono No.09 B', '1405356066621233', 'assets/images/users_photo/juragan.jpg', 'sudah', 'dr. Muchamad Zubait');
INSERT INTO `user` VALUES ('3', 'petugas', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', '', 'petugas', 'Laki - Laki ', 'dinoyo gang 3', '1231231231231239', 'assets/images/users_photo/24a3f397a1058a682ab61e13845e0efd1.jpg', 'sudah', 'petugas');
