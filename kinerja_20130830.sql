-- MySQL dump 10.13  Distrib 5.1.41, for debian-linux-gnu (i486)
--
-- Host: localhost    Database: e_kinerja_20130711
-- ------------------------------------------------------
-- Server version	5.1.41-3ubuntu12.10

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `portal_category`
--

DROP TABLE IF EXISTS `portal_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `portal_category` (
  `category_id` smallint(6) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `portal_category`
--

LOCK TABLES `portal_category` WRITE;
/*!40000 ALTER TABLE `portal_category` DISABLE KEYS */;
INSERT INTO `portal_category` VALUES (1,'Home'),(2,'Informasi_Berita_Kinerja'),(3,'Informasi_About'),(4,'Informasi_Akip'),(5,'Informasi_Regulasi'),(6,'Informasi_Faq'),(7,'Informasi_Kontak'),(8,'Link');
/*!40000 ALTER TABLE `portal_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `portal_content`
--

DROP TABLE IF EXISTS `portal_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `portal_content` (
  `content_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` smallint(6) NOT NULL,
  `content_title` varchar(100) DEFAULT NULL,
  `content` text,
  `summary` text,
  `url` varchar(50) DEFAULT NULL,
  `date_post` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `published` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`content_id`),
  KEY `fk_content_category` (`category_id`),
  CONSTRAINT `fk_content_category` FOREIGN KEY (`category_id`) REFERENCES `portal_category` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `portal_content`
--

LOCK TABLES `portal_content` WRITE;
/*!40000 ALTER TABLE `portal_content` DISABLE KEYS */;
INSERT INTO `portal_content` VALUES (2,3,'e-Performance','<p>e-Performance atau Sistem Aplikasi Pengukuran Kinerja adalah aplikasi yang berfungsi untuk membantu proses pengumpulan dan pengukuran data kinerja di lingkungan Kementerian Perhubungan. e-Performance dapat diakses melalui jaringan intranet/internet di alamat website Kementerian Perhubungan, yaitu http://www.dephub.go.id.</p>\n\n<p><br />\nFungsi-fungsi utama (features) yang dipunyai e-Performance adalah:</p>\n\n<ul>\n <li>Pengelolaan Data Rujukan</li>\n <li>Pengelolaan Data Induk</li>\n <li>Pengolahan Data Transaksi, meliputi RKT, PK dan capaian kinerja</li>\n <li>Pengukuran Kinerja</li>\n <li>Pelaporan</li>\n</ul>\n\n<p>Beberapa manfaat yang didapat dari penggunaan e-Performance:</p>\n\n<ul>\n <li>Terbentuknya keseragaman format data kinerja sesuai peraturan yang diacu, yaitu PermenPANRB Nomor 29 Tahun 2010.</li>\n <li>Meningkatnya akurasi hasil proses pengumpulan dan pengukuran data kinerja, karena data diinput dan diukur per periode tertentu (bulanan).</li>\n <li>Informasi dan laporan yang dihasilkan dapat digunakan untuk menyusun LAKIP sehing proses pembuatannya menjadi lebih mudah.</li>\n <li>Integrasi dengan sistem lain, seperti sistem e-Monitoring &amp; e-Reporting.</li>\n</ul>\n','<p>Pelaksanaan kegiatan pengembangan Sistem dan Aplikasi Pengukuran Data Kinerja Kementerian Perhubungan Berbasis Web dimaksudkan untuk membangun sistem pengumpulan dan pengukuran data kinerja di lingkungan Kementerian Perhubungan.</p>\n','','2013-06-27 00:27:31',1),(21,8,'Kementerian Perhubungan','0','','dephub.go.id','2013-06-27 00:21:45',0),(22,8,'Kementerian PAN dan Reformasi Birorasi','','','menpan.go.id','2013-06-27 00:22:46',0),(23,4,'SISTEM AKUNTABILITAS KINERJA INSTANSI PEMERINTAH','<p>Akuntabilitas Kinerja Instansi Pemerintah (AKIP) adalah perwujudan kewajiban suatu instansi pemerintah untuk mempertanggungjawabkan keberhasilan dan kegagalan pelaksanaan misi organisasi dalam mencapai sasaran dan tujuan yang telah ditetapkan melalui sistem pertanggungjawaban secara periodik. Sistem Akuntabilitas Kinerja Instansi Pemerintah (Sistem AKIP) adalah instrumen yang digunakan instansi pemerintah dalam memenuhi kewajiban untuk mempertanggungjawabkan keberhasilan dan kegagalan pelaksanaan misi organisasi. Sistem AKIP terdiri dari berbagai komponen yang merupakan satu kesatuan, yaitu perencanaan strategis, perencanaan kinerja, pengukuran kinerja, dan pelaporan kinerja. Gambar 2.3 berikut memperlihatkan hubungan keterkaitan antar komponen yang ada dalam Sistem AKIP.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><img alt=\"\" src=\"http://localhost/e-performance/public/js/kcfinder/upload/images/akip.png\"  width:527px\" /></p>\r\n\r\n<p>Gambar 2.3. Sistem AKIP</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Tujuan Sistem AKIP adalah untuk mendorong terciptanya akuntabilitas kinerja instansi pemerintah sebagai salah satu prasyarat untuk terciptanya pemerintah yang baik dan terpercaya. Sedangkan sasaran dari Sistem AKIP adalah:</p>\r\n\r\n<ol>\r\n <li>Menjadikan instansi pemerintah yang akuntabel sehingga dapat beroperasi secara efisien, efektif dan responsif terhadap aspirasi masyarakat dan lingkungannya.</li>\r\n <li>Terwujudnya transparansi instansi pemerintah.</li>\r\n <li>Terwujudnya partisipasi masyarakat dalam pelaksanaan pembangunan nasional.</li>\r\n <li>Terpeliharanya kepercayaan masyarakat kepada pemerintah.</li>\r\n</ol>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Pelaksanaan penyusunan Sistem AKIP dilakukan melalui tahap-tahap sebagai berikut:</p>\r\n\r\n<ol>\r\n <li>Mempersiapkan dan menyusun perencanaan strategik.</li>\r\n <li>Merumuskan visi, misi, faktor-faktor kunci keberhasilan, tujuan, sasaran dan strategi instansi pemerintah.</li>\r\n <li>Merumuskan indikator kinerja instansi pemerintah dengan berpedoman pada kegiatan yang dominan, menjadi isu nasional dan vital bagi pencapaian visi dan misi instansi pemerintah.</li>\r\n <li>Memantau dan mengamati pelaksanaan tugas pokok dan fungsi dengan seksama.</li>\r\n <li>Mengukur pencapaian kinerja dengan:</li>\r\n</ol>\r\n\r\n<ol>\r\n <li>Perbandingan kinerja aktual dengan rencana atau target.</li>\r\n <li>Perbandingan kinerja aktual dengan tahun-tahun sebelumnya.</li>\r\n <li>Perbandingan kinerja aktual dengan kinerja di negara-negara lain, atau dengan standar internasional.</li>\r\n</ol>\r\n\r\n<ol>\r\n <li>Melakukan evaluasi kinerja dengan:</li>\r\n</ol>\r\n\r\n<ol>\r\n <li>Menganalisis hasil pengukuran kinerja .</li>\r\n <li>Menginterprestasikan data yang diperoleh.</li>\r\n <li>Membuat pembobotan (rating) keberhasilan pencapaian program.</li>\r\n <li>Membandingkan pencapaian program dengan visi dan misi instansi pemerintah.</li>\r\n</ol>\r\n\r\n<p>Alat untuk melaksanakan akuntabilitas kinerja instansi pemerintah adalah Laporan Akuntabilitas Kinerja Instansi Pemerintah (LAKIP).</p>\r\n','<p>Akuntabilitas Kinerja Instansi Pemerintah (AKIP) adalah perwujudan kewajiban suatu instansi pemerintah untuk mempertanggungjawabkan keberhasilan dan kegagalan pelaksanaan misi organisasi dalam mencapai sasaran dan tujuan yang telah ditetapkan melalui sistem pertanggungjawaban secara periodik</p>\r\n','','2013-07-05 01:49:58',1),(24,5,'Regulasi tentang Sistem Pengukuran Kinerja','<p><strong>Regulasi tentang Sistem Pengukuran Kinerja:</strong></p>\r\n\r\n<ol>\r\n <li>Instruksi Presiden Nomor 7 Tahun 1999 tentang Akuntabilitas Kinerja Instansi Pemerintah (AKIP).</li>\r\n <li>Surat Keputusan Kepala Lembaga Administrasi Negara Nomor 239/IX/6/8/2003 tentang Perbaikan Pedoman Penyusunan Pelaporan Akuntabilitas Kinerja Instansi Pemerintah.</li>\r\n <li>Peraturan Pemerintah Nomor 8 Tahun 2006 tentang Pelaporan Keuangan dan Kinerja Instansi Pemerintah.</li>\r\n <li>Peraturan Menteri Negara Pendayagunaan Aparatur Negara Nomor PER/09/M.PAN/5/2007 tentang Pedoman Umum Penetapan Indikator Kinerja Utama di Lingkungan Instansi Pemerintah.</li>\r\n <li>Peraturan Menteri Negara Pendayagunaan Aparatur Negara dan Reformasi Birokrasi Nomor 29 Tahun 2010 tentang Pedoman Penyusunan Penetapan Kinerja dan Pelaporan Akuntabilitas Kinerja Instansi Pemerintah.</li>\r\n <li>Peraturan Menteri Perhubungan Nomor PM 68 Tahun 2012 tentang Penetapan Indikator Kinerja Utama (IKU) di Lingkungan Kementerian Perhubungan.</li>\r\n <li>Peraturan Menteri Perhubungan Nomor PM 69 Tahun 2012 tentang Pedoman Penyusunan Rencana Kinerja Tahunan, Penetapan Kinerja dan Laporan Akuntabilitas Kinerja di Lingkungan Kementerian Perhubungan.</li>\r\n <li>Peraturan Menteri Perhubungan Nomor PM 11 Tahun 2013 tentang Pedoman Pengumpulan Data Kinerja di Lingkungan Kementerian Perhubungan.</li>\r\n</ol>\r\n\r\n<p>Peraturan Menteri Perhubungan Nomor PM 12 Tahun 2013 tentang Pedoman Pengukuran Indikator Kinerja di Lingkungan Kementerian Perhubungan.</p>\r\n','<ol>\r\n <li>Instruksi Presiden Nomor 7 Tahun 1999 tentang Akuntabilitas Kinerja Instansi Pemerintah (AKIP).</li>\r\n <li>Surat Keputusan Kepala Lembaga Administrasi Negara Nomor 239/IX/6/8/2003 tentang Perbaikan Pedoman Penyusunan Pelaporan Akuntabilitas Kinerja Instansi Pemerintah.</li>\r\n</ol>\r\n','','2013-07-09 21:13:26',0),(25,7,'Biro Perencanaan','<p>Biro Perencanaan</p>\r\n\r\n<p>Sekretariat Jenderal Kementerian Perhubungan</p>\r\n\r\n<p>Jalan Medan Merdeka Barat No. 8</p>\r\n\r\n<p>Gedung Cipta Lantai 3</p>\r\n','0','0','2013-07-09 21:15:45',0),(26,1,'2012','0','0','0','2013-08-27 09:34:41',0),(27,2,'Prestasi Hebat','<p>Prestasi hebat diraih Direktorat Perhubungan Laut..<br />\nPrestasi hebat diraih Direktorat Perhubungan Laut..<br />\nPrestasi hebat diraih Direktorat Perhubungan Laut..</p>\n\n<p><br />\n&nbsp;</p>\n','<p>Prestasi hebat diraih Direktorat Perhubungan Laut..</p>\n','','2013-08-27 10:10:27',1),(28,2,'Launching','<p>Launching aplikasi kinerja akan dilakukan pada tanggal 3 september 2013</p>\n','<p>Launching aplikasi kinerja</p>\n','','2013-08-27 10:30:18',1);
/*!40000 ALTER TABLE `portal_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_checkpoint_e1`
--

DROP TABLE IF EXISTS `tbl_checkpoint_e1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_checkpoint_e1` (
  `id_checkpoint_e1` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_pk_e1` int(11) NOT NULL,
  `unit_kerja` varchar(100) DEFAULT NULL,
  `periode` smallint(6) DEFAULT NULL,
  `kriteria` varchar(255) DEFAULT NULL,
  `ukuran` varchar(255) DEFAULT NULL,
  `target` float DEFAULT NULL,
  `capaian` float DEFAULT NULL,
  `keterangan` text,
  `log_insert` varchar(50) DEFAULT NULL,
  `log_update` varchar(50) DEFAULT NULL,
  `nama_folder_pendukung` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_checkpoint_e1`),
  KEY `fk_checkpoint_penetapan_e1` (`id_pk_e1`),
  CONSTRAINT `fk_checkpoint_penetapan_e1` FOREIGN KEY (`id_pk_e1`) REFERENCES `tbl_pk_eselon1` (`id_pk_e1`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=176 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_checkpoint_e1`
--

LOCK TABLES `tbl_checkpoint_e1` WRITE;
/*!40000 ALTER TABLE `tbl_checkpoint_e1` DISABLE KEYS */;
INSERT INTO `tbl_checkpoint_e1` VALUES (1,1,'-',12,'Nilai Akuntabilitas Kinerja Kementerian Perhubungan','Nilai Akuntabilitas Kinerja Kementerian Perhubungan',0,0,NULL,NULL,NULL,NULL),(2,2,'-',12,'Nilai akuntabilitas kinerja Sekretariat Jenderal','Nilai akuntabilitas kinerja Sekretariat Jenderal',0,0,NULL,NULL,NULL,NULL),(3,3,'-',12,'Ketepatan waktu pelayanan administrasi perkantoran','Tingkat ketepatan waktu pelayanan administrasi perkantoran',80,85,NULL,NULL,NULL,NULL),(4,4,'-',12,'Rekomendasi hasil analisis informasi untuk penyempurnaan kebijakan sektor transportasi','Jumlah rekomendasi hasil analisis informasi untuk penyempurnaan kebijakan sektor transportasi',60,251,NULL,NULL,NULL,NULL),(5,5,'-',12,'Indeks opini publik terhadap Kementerian Perhubungan','Indeks opini publik terhadap Kementerian Perhubungan',216,1318,NULL,NULL,NULL,NULL),(6,6,'-',12,'Terselenggaranya kerjasama luar negeri di bidang transportasi','Jumlah terselenggaranya kerjasama luar negeri di bidang transportasi',22,15,NULL,NULL,NULL,NULL),(7,7,'-',12,'Penghematan biaya energi, air, dan telepon di lingkungan kantor pusat Kementerian Perhubungan','Penghematan biaya energi, air, dan telepon di lingkungan kantor pusat Kementerian Perhubungan',1.075e+10,8.6899e+09,NULL,NULL,NULL,NULL),(8,8,'-',12,'Pemenuhan kebutuhan sarana dan prasarana Setjen','Tingkat pemenuhan kebutuhan sarana dan prasarana Setjen',100,94.74,NULL,NULL,NULL,NULL),(9,9,'-',12,'Aparatur Kementerian Perhubungan yang telah meningkatkan kualitas dan kompetensi','Jumlah aparatur Kementerian Perhubungan yang telah meningkatkan kualitas dan kompetensi',279,313,NULL,NULL,NULL,NULL),(10,10,'-',12,'Tersusunnya RPM standar kompetensi jabatan aparatur di lingkungan Kementerian Perhubungan','Tersusunnya RPM standar kompetensi jabatan aparatur di lingkungan Kementerian Perhubungan',7,7,NULL,NULL,NULL,NULL),(11,11,'-',12,'Tersusunnya regulasi terkait SDM aparatur di lingkungan Kementerian Perhubungan','Tersusunnya regulasi terkait SDM aparatur di lingkungan Kementerian Perhubungan',11,14,NULL,NULL,NULL,NULL),(12,12,'-',12,'Laporan penataan organisasi/kelembagaan dan tata laksana di lingkungan Kementerian Perhubungan','Jumlah laporan penataan organisasi/kelembagaan dan tata laksana di lingkungan Kementerian Perhubungan',9,12,NULL,NULL,NULL,NULL),(13,13,'-',12,'Unit kerja yang telah memenuhi kaidah kelembagaan yang baik','Persentase unit kerja yang telah memenuhi kaidah kelembagaan yang baik',100,100,NULL,NULL,NULL,NULL),(14,14,'-',12,'Opini BPK atas pengelolaan keuangan Kementerian Perhubungan','Opini BPK atas pengelolaan keuangan Kementerian Perhubungan',0,0,NULL,NULL,NULL,NULL),(15,15,'-',12,'Aset BMN/kekayaan negara Sekretariat Jenderal','Jumlah aset BMN/kekayaan negara Sekretariat Jenderal yang terinventariasi',1.39e+12,1.12e+12,NULL,NULL,NULL,NULL),(16,16,'-',12,'Penyerapan anggaran di lingkungan Sekretariat Jenderal','Tingkat penyerapan anggaran di lingkungan Sekretariat Jenderal',100,89,NULL,NULL,NULL,NULL),(17,17,'-',12,'Dokumen peraturan perundang-undangan di bidang transportasi','Jumlah dokumen peraturan perundang-undangan di bidang transportasi',55,784,NULL,NULL,NULL,NULL),(18,18,'-',12,'Regulasi terkait pelaksanaan tugas Sekretariat Jenderal','Jumlah regulasi terkait pelaksanaan tugas Sekretariat Jenderal',10,23,NULL,NULL,NULL,NULL),(19,19,'-',12,'Kapasitas Jaringan yang dapat melayani Aplikasi Dukungan Operasional dan Pelayanan Publik','Jumlah Kapasitas Jaringan yang dapat melayani Aplikasi Dukungan Operasional dan Pelayanan Publik',100,100,NULL,NULL,NULL,NULL),(20,20,'-',12,'Data operasional sarana, prasarana dan produksi transportasi','Persentase data operasional sarana, prasarana dan produksi transportasi yang ter-update',40,40,NULL,NULL,NULL,NULL),(21,21,'-',12,'Rekomendasi hasil kajian kemitraan dan pelayanan jasa serta lingkungan hidup transportasi','Jumlah rekomendasi hasil kajian kemitraan dan pelayanan jasa serta lingkungan hidup transportasi',22,26,NULL,NULL,NULL,NULL),(22,22,'-',12,'Dokumen pra-studi kelayakan dan evaluasi dokumen proyek kerjasama pemerintah dan swasta yang diselesaikan','Jumlah dokumen pra-studi kelayakan dan evaluasi dokumen proyek kerjasama pemerintah dan swasta yang diselesaikan',3,7,NULL,NULL,NULL,NULL),(23,23,'-',12,'Hasil penilaian pelayanan jasa transportasi','Jumlah hasil penilaian pelayanan jasa transportasi',118,122,NULL,NULL,NULL,NULL),(24,24,'-',12,'Pedoman bidang pengelolaan lingkungan hidup','Jumlah pedoman bidang pengelolaan lingkungan hidup yang dirumuskan',4,6,NULL,NULL,NULL,NULL),(25,25,'-',12,'Perkara kecelakaan kapal yang disidangkan dan diputus tepat waktu','Persentase perkara kecelakaan kapal yang disidangkan dan diputus tepat waktu',40,34,NULL,NULL,NULL,NULL),(26,26,'-',12,'Rekomendasi putusan mahkamah pelayaran','Persentase rekomendasi putusan mahkamah pelayaran yang ditindaklanjuti',40,34,NULL,NULL,NULL,NULL),(27,27,'-',12,'Laporan putusan yang disampaikan','Jumlah laporan putusan yang disampaikan kepada para pihak',40,34,NULL,NULL,NULL,NULL),(28,28,'-',12,'Terselesaikannya laporan final kecelakaan transportasi','Jumlah terselesaikannya laporan final kecelakaan transportasi',136,146,NULL,NULL,NULL,NULL),(29,29,'-',12,'Data kecelakaan 4 moda transportasi (udara, laut, jalan, kereta api) yang diinvestigasi KNKT','Jumlah data kecelakaan 4 moda transportasi (udara, laut, jalan, kereta api) yang diinvestigasi KNKT',252,258,NULL,NULL,NULL,NULL),(30,30,'-',12,'Penurunan kebocoran keuangan negara','Penurunan persentase kebocoran keuangan negara',0.12,0.12,NULL,NULL,NULL,NULL),(31,31,'-',12,'Unit kerja yang ditetapkan menjadi Wilayah Bebas Korupsi (WBK)','Jumlah unit kerja yang ditetapkan menjadi Wilayah Bebas Korupsi (WBK)',0,0,NULL,NULL,NULL,NULL),(32,32,'-',12,'Hasil pengawasan yang ditindaklanjuti','Persentase hasil pengawasan yang ditindaklanjuti',70,70,NULL,NULL,NULL,NULL),(33,33,'-',12,'Penerapan SPIP di Kementerian Perhubungan','Persentase penerapan SPIP di Kementerian Perhubungan',10,10,NULL,NULL,NULL,NULL),(34,34,'-',12,'Nilai rata-rata LAKIP Eselon I hasil evaluasi Inspektorat Jenderal','Nilai rata-rata LAKIP Eselon I hasil evaluasi Inspektorat Jenderal',82,82,NULL,NULL,NULL,NULL),(35,35,'-',12,'Rekomendasi strategis hasil pengawasan','Jumlah rekomendasi strategis hasil pengawasan',50,50,NULL,NULL,NULL,NULL),(36,36,'-',12,'Audit khusus (investigasi) yang terbukti','Persentase audit khusus (investigasi) yang terbukti',90,90,NULL,NULL,NULL,NULL),(37,37,'-',12,'Pedoman pengawasan yang ditetapkan','Jumlah pedoman pengawasan yang ditetapkan',9,9,NULL,NULL,NULL,NULL),(38,38,'-',12,'Pencapaian Program Kerja Pengawasan Tahunan','Persentase pencapaian Program Kerja Pengawasan Tahunan',90,90,NULL,NULL,NULL,NULL),(39,39,'-',12,'Rasio penyerapan anggaran terhadap persentase pencapaian program dan kegiatan','Rasio persentase penyerapan anggaran terhadap persentase pencapaian program dan kegiatan',0.85,0.85,NULL,NULL,NULL,NULL),(40,40,'-',12,'Nilai AKIP Inspektorat Jenderal','Nilai AKIP Inspektorat Jenderal',82,82,NULL,NULL,NULL,NULL),(41,41,'-',12,'Peningkatan Auditor yang sesuai dengan standard Kompetensi','Peningkatan persentase Auditor yang sesuai dengan standard Kompetensi',30,30,NULL,NULL,NULL,NULL),(42,42,'-',12,'SDM Pengawasan yang mengikuti pelatihan dan pengembangan bidang pengawasan','Jumlah SDM Pengawasan yang mengikuti pelatihan dan pengembangan bidang pengawasan',160,160,NULL,NULL,NULL,NULL),(43,43,'-',12,'Proses bisnis yang telah memanfaatkan Teknologi Informasi dan Komunikasi','Persentase proses bisnis yang telah memanfaatkan Teknologi Informasi dan Komunikasi',50,50,NULL,NULL,NULL,NULL),(44,44,'-',12,'Konsumsi energi tak tergantikan oleh angkutan umum sub sektor transportasi darat','Jumlah konsumsi energi tak tergantikan oleh angkutan umum sub sektor transportasi darat',0.244,0.206,NULL,NULL,NULL,NULL),(45,45,'-',12,'Produksi emisi gas buang dari sub sektor transportasi darat','Jumlah produksi emisi gas buang dari sub sektor transportasi darat',522,480,NULL,NULL,NULL,NULL),(46,46,'-',12,'Pertumbuhan transportasi darat terhadap PDRB (LLAJ)','Persentase pertumbuhan transportasi darat terhadap PDRB (LLAJ)',17,4.27,NULL,NULL,NULL,NULL),(47,47,'-',12,'Pertumbuhan transportasi darat terhadap PDRB (LLASDP)','Persentase pertumbuhan transportasi darat terhadap PDRB (LLASDP)',11,10.38,NULL,NULL,NULL,NULL),(48,48,'-',12,'Kejadian kecelakaan lalu lintas jalan yang terkait dengan kewenangan Ditjen Hubdat','Kejadian kecelakaan lalu lintas jalan yang terkait dengan kewenangan Ditjen Hubdat',4836,5234,NULL,NULL,NULL,NULL),(49,49,'-',12,'Kejadian kecelakaan SDP yang terkait dengan kewenangan Ditjen Hubdat','Kejadian kecelakaan SDP yang terkait dengan kewenangan Ditjen Hubdat',2,1,NULL,NULL,NULL,NULL),(50,50,'-',12,'Terpenuhinya frekuensi pelayanan pada lintas penyeberangan utama','Persentase terpenuhinya frekuensi pelayanan pada lintas penyeberangan utama',100,95.82,NULL,NULL,NULL,NULL),(51,51,'-',12,'Kinerja pelayanan AKAP','Persentase kinerja pelayanan AKAP',69,69,NULL,NULL,NULL,NULL),(52,52,'-',12,'Lokasi yang memanfaatkan sarana transportasi darat berteknologi efisien dan ramah lingkungan','Jumlah lokasi yang memanfaatkan sarana transportasi darat berteknologi efisien dan ramah lingkungan',3,3,NULL,NULL,NULL,NULL),(53,53,'-',12,'Prasarana transportasi jalan yang memanfaatkaan teknologi efisien dan ramah lingkungan di jalan nasional','Jumlah prasarana transportasi jalan yang memanfaatkaan teknologi efisien dan ramah lingkungan di jalan nasional',96,205,NULL,NULL,NULL,NULL),(54,54,'-',12,'Pembangunan kenavigasian untuk angkutan sungai danau penyeberangan yang memanfaatkan teknologi ramah lingkungan','Jumlah pembangunan kenavigasian untuk angkutan sungai danau penyeberangan yang memanfaatkan teknologi ramah lingkungan',28,24,NULL,NULL,NULL,NULL),(55,55,'-',12,'Kota yang menerapkan ATCS dalam pelaksanaan Manajemen Rekayasa Lalu Lintas','Jumlah Kota yang menerapkan ATCS dalam pelaksanaan Manajemen rekayasa Lalu Lintas',14,14,NULL,NULL,NULL,NULL),(56,56,'-',12,'Kota yang memanfaatkan angkutan massal untuk pelayanan angkutan perkotaan','Jumlah kota yang memanfaatkan angkutan massal untuk pelayanan angkutan perkotaan',15,15,NULL,NULL,NULL,NULL),(57,57,'-',12,'Trayek keperintisan angkutan jalan','Jumlah trayek keperintisan angkutan jalan',169,169,NULL,NULL,NULL,NULL),(58,58,'-',12,'Trayek AKAP','Jumlah trayek AKAP',2335,2335,NULL,NULL,NULL,NULL),(59,59,'-',12,'Lintas penyeberangan perintis','Jumlah lintas penyeberangan perintis',135,135,NULL,NULL,NULL,NULL),(60,60,'-',12,'Lintas penyeberangan komersial','Jumlah lintas penyeberangan komersial',47,42,NULL,NULL,NULL,NULL),(61,61,'-',12,'Produksi angkutan penyeberangan (penumpang)','Jumlah produksi angkutan penyeberangan (penumpang)',5.48827e+07,6.14e+07,NULL,NULL,NULL,NULL),(62,62,'-',12,'Produksi angkutan penyeberangan (kendaraan)','Jumlah produksi angkutan penyeberangan (kendaraan)',6.8222e+06,1.3768e+07,NULL,NULL,NULL,NULL),(63,63,'-',12,'Penumpang angkutan umum pada pelayanan angkutan lebaran (penumpang)','Jumlah penumpang angkutan umum pada pelayanan angkutan lebaran (penumpang)',5.52488e+06,5.52488e+06,NULL,NULL,NULL,NULL),(64,64,'-',12,'Penumpang angkutan umum pada pelayanan angkutan lebaran (kendaraan)','Jumlah penumpang angkutan umum pada pelayanan angkutan lebaran (kendaraan)',3.27685e+06,3.27685e+06,NULL,NULL,NULL,NULL),(65,65,'-',12,'Kapasitas penumpang angkutan umum massal di perkotaan','Jumlah kapasitas penumpang angkutan umum massal di perkotaan',5.43061e+08,5.43061e+08,NULL,NULL,NULL,NULL),(66,66,'-',12,'Penyelenggaraan operasional prasarana LLAJ yang memenuhi SPM','Persentase penyelenggaraan operasional prasarana LLAJ yang memenuhi SPM',67,59,NULL,NULL,NULL,NULL),(67,67,'-',12,'Sarana pelayanan AKAP yang memenuhi SPM','Persentase sarana pelayanan AKAP yang memenuhi SPM',70,63,NULL,NULL,NULL,NULL),(68,68,'-',12,'Pemenuhan standar operasional pelabuhan penyeberangan','Persentase pemenuhan standar operasional pelabuhan penyeberangan',100,88.19,NULL,NULL,NULL,NULL),(69,69,'-',12,'Kapal penyeberangan yang memenuhi SPM','Persentase kapal penyeberangan yang memenuhi SPM',43.02,92.62,NULL,NULL,NULL,NULL),(70,70,'-',12,'Nilai AKIP Ditjen Perhubungan Darat','Nilai AKIP Ditjen Perhubungan Darat',84,83.07,NULL,NULL,NULL,NULL),(71,71,'-',12,'Penyerapan anggaran Ditjen Perhubungan Darat','Tingkat penyerapan anggaran Ditjen Perhubungan Darat',92.19,90.55,NULL,NULL,NULL,NULL),(72,72,'-',12,'Nilai aset Direktorat Jenderal Perhubungan Darat','Nilai aset Direktorat Jenderal Perhubungan Darat yang berhasil diinventarisasi',6.58e+12,9.35e+12,NULL,NULL,NULL,NULL),(73,73,'-',12,'Pemberian sertifikat dan kualifikasi teknis petugas operasional','Jumlah pemberian sertifikat dan kualifikasi teknis petugas operasional',100,100,NULL,NULL,NULL,NULL),(74,74,'-',12,'Pegawai yang sudah memiliki sertifikat','Jumlah pegawai yang sudah memiliki sertifikat',202,202,NULL,NULL,NULL,NULL),(75,75,'-',12,'Kerjasama dengan Pemda/swasta di sub sektor transportasi darat','Jumlah kerjasama dengan Pemda/swasta di sub sektor transportasi darat',4,4,NULL,NULL,NULL,NULL),(76,76,'-',12,'Tersusunnya peraturan perundang-undangan dan peraturan pelaksanaannya','Jumlah tersusunnya peraturan perundang-undangan dan peraturan pelaksanaannya',17,22,NULL,NULL,NULL,NULL),(77,77,'-',12,'Kejadian kecelakaan yang disebabkan oleh manusia','Jumlah kejadian kecelakaan yang disebabkan oleh manusia',31,24,NULL,NULL,NULL,NULL),(78,78,'-',12,'Kejadian kecelakaan yang disebabkan oleh teknis dan lain-lain','Jumlah kejadian kecelakaan yang disebabkan oleh teknis dan lain-lain',48,66,NULL,NULL,NULL,NULL),(79,79,'-',12,'Kapal yang memiliki sertifikat kelaiklautan kapal','Jumlah kapal yang memiliki sertifikat kelaiklautan kapal',7146,9298,NULL,NULL,NULL,NULL),(80,80,'-',12,'Rute perintis yang dilayani transportasi laut','Jumlah rute perintis yang dilayani transportasi laut',80,80,NULL,NULL,NULL,NULL),(81,81,'-',12,'Pelabuhan yang dapat menghubungkan daerah terpencil, terluar, daerah perbatasan, daerah belum berkembang dan daerah telah berkembang','Jumlah pelabuhan yang dapat menghubungkan daerah-daerah terpencil, terluar, daerah perbatasan, daerah belum berkembang dan daerah telah berkembang',393,386,NULL,NULL,NULL,NULL),(82,82,'-',12,'Penumpang transportasi laut yang terangkut','Jumlah penumpang transportasi laut yang terangkut',5.02766e+06,6.06157e+06,NULL,NULL,NULL,NULL),(83,83,'-',12,'Penumpang angkutan laut perintis','Jumlah penumpang angkutan laut perintis',629847,634000,NULL,NULL,NULL,NULL),(84,84,'-',12,'Muatan angkutan laut dalam negeri yang diangkut oleh kapal nasional','Jumlah muatan angkutan laut dalam negeri yang diangkut oleh kapal nasional',3.273e+08,3.51985e+08,NULL,NULL,NULL,NULL),(85,85,'-',12,'Pangsa muatan angkutan laut dalam negeri yang diangkut oleh kapal nasional','Persentase pangsa muatan angkutan laut dalam negeri yang diangkut oleh kapal nasional',98.85,98.9,NULL,NULL,NULL,NULL),(86,86,'-',12,'Muatan angkutan laut luar negeri yang diangkut oleh kapal nasional','Jumlah muatan angkutan laut luar negeri yang diangkut oleh kapal nasional',5.9599e+07,5.9851e+07,NULL,NULL,NULL,NULL),(87,87,'-',12,'Pangsa muatan angkutan laut luar negeri yang diangkut oleh kapal nasional','Persentase pangsa muatan angkutan laut luar negeri yang diangkut oleh kapal nasional',10,11.8,NULL,NULL,NULL,NULL),(88,88,'-',12,'Penurunan Turn-Around Time (TRT) di pelabuhan yang diusahakan','Penurunan Turn-Around Time (TRT) di pelabuhan yang diusahakan',30,0,NULL,NULL,NULL,NULL),(89,89,'-',12,'Pelabuhan mempunyai pencapaian Waiting Time (WT)','Jumlah pelabuhan mempunyai pencapaian Waiting Time (WT)',48,36,NULL,NULL,NULL,NULL),(90,90,'-',12,'Pelabuhan mempunyai pencapaian approach time (AT)','Jumlah pelabuhan mempunyai pencapaian approach time (AT)',48,36,NULL,NULL,NULL,NULL),(91,91,'-',12,'Pelabuhan mempunyai pencapaian Waktu Efektif (Effective Time/ET)','Jumlah pelabuhan mempunyai pencapaian Waktu Efektif (Effective Time/ET)',48,15,NULL,NULL,NULL,NULL),(92,92,'-',12,'MOU, perizinan, konstruksi, dan operasional kerjasama pemerintah dengan Pemda dan Swasta di bidang transportasi laut','Jumlah MOU, perizinan, konstruksi, dan operasional kerjasama pemerintah dengan Pemda dan Swasta di bidang transportasi laut',2,2,NULL,NULL,NULL,NULL),(93,93,'-',12,'Kebutuhan tenaga Marine Inspector A','Jumlah kebutuhan tenaga Marine Inspector A',60,60,NULL,NULL,NULL,NULL),(94,94,'-',12,'Kebutuhan tenaga Marine Inspector B','Jumlah kebutuhan tenaga Marine Inspector B',120,120,NULL,NULL,NULL,NULL),(95,95,'-',12,'Kebutuhan tenaga PPNS','Jumlah kebutuhan tenaga PPNS',60,59,NULL,NULL,NULL,NULL),(96,96,'-',12,'Tenaga PPNS','Jumlah tenaga PPNS',367,367,NULL,NULL,NULL,NULL),(97,97,'-',12,'Kebutuhan tenaga kesyahbandaran kelas A','Jumlah kebutuhan tenaga kesyahbandaran kelas A',60,60,NULL,NULL,NULL,NULL),(98,98,'-',12,'Kebutuhan tenaga kesyahbandaran kelas B','Jumlah kebutuhan tenaga kesyahbandaran kelas B',120,120,NULL,NULL,NULL,NULL),(99,99,'-',12,'Kebutuhan tenaga penanggulangan pencemaran','Jumlah kebutuhan tenaga penanggulangan pencemaran',0,0,NULL,NULL,NULL,NULL),(100,100,'-',12,'Kebutuhan tenaga penanggulangan kebakaran','Jumlah kebutuhan tenaga penanggulangan kebakaran',0,0,NULL,NULL,NULL,NULL),(101,101,'-',12,'Kebutuhan tenaga penyelam','Jumlah kebutuhan tenaga penyelam',0,0,NULL,NULL,NULL,NULL),(102,102,'-',12,'Nilai AKIP Direktorat Jenderal Perhubungan Laut','Nilai AKIP Direktorat Jenderal Perhubungan Laut',78,78,NULL,NULL,NULL,NULL),(103,103,'-',12,'Realisasi pendapatan Direktorat Jenderal Perhubungan Laut','Jumlah realisasi pendapatan Direktorat Jenderal Perhubungan Laut',3.31e+11,6.21e+11,NULL,NULL,NULL,NULL),(104,104,'-',12,'Realisasi belanja anggaran Direktorat Jenderal Perhubungan Laut','Jumlah realisasi belanja anggaran Direktorat Jenderal Perhubungan Laut',1.16e+13,9.99e+12,NULL,NULL,NULL,NULL),(105,105,'-',12,'Nilai BMN pada neraca Direktorat Jenderal Perhubungan Laut','Nilai BMN pada neraca Direktorat Jenderal Perhubungan Laut',2.67e+13,2.52e+13,NULL,NULL,NULL,NULL),(106,106,'-',12,'Penyelesaian regulasi','Jumlah penyelesaian regulasi',11,11,NULL,NULL,NULL,NULL),(107,107,'-',12,'Penurunan emisi gas buang (CO2) transportasi laut','Jumlah penurunan emisi gas buang (CO2) transportasi laut',0.4853,0.102,NULL,NULL,NULL,NULL),(108,108,'-',12,'Pelabuhan yang menerapkan Eco-Port (penanganan sampah dan kebersihan lingkungan pelabuhan)','Jumlah pelabuhan yang menerapkan Eco-Port (penanganan sampah dan kebersihan lingkungan pelabuhan)',6,6,NULL,NULL,NULL,NULL),(109,109,'-',12,'Pemilikan sertifikat IOPP (International Oil Polution Prevention)','Jumlah pemilikan sertifikat IOPP (International Oil Polution Prevention)',1021,972,NULL,NULL,NULL,NULL),(110,110,'-',12,'Pemilikan SNPP (Sertifikat Nasional Pencegahan Pencemaran)','Jumlah pemilikan SNPP (Sertifikat Nasional Pencegahan Pencemaran)',1527,1332,NULL,NULL,NULL,NULL),(111,111,'-',12,'Pemilikan sertifikat bahan cair beracun (Noxius Liquid Substance)','Jumlah pemilikan sertifikat bahan cair beracun (Noxius Liquid Substance)',134,107,NULL,NULL,NULL,NULL),(112,112,'-',12,'Pemilikan sertifikat ISPP (International Sewage Pollution Prevention)','Jumlah pemilikan sertifikat ISPP (International Sewage Pollution Prevention)',245,205,NULL,NULL,NULL,NULL),(113,113,'-',12,'Kecelakaan transportasi udara pada AOC 121 dan AOC 135','Rasio kecelakaan transportasi udara pada AOC 121 dan AOC 135 dengan korban jiwa dan pesawat rusak berat',7.05,5.56,NULL,NULL,NULL,NULL),(114,114,'-',12,'Airtraffic Incident dengan rasio 4:100.000 pergerakan','Jumlah Airtraffic Incident dengan rasio 4:100.000 pergerakan',56,9,NULL,NULL,NULL,NULL),(115,115,'-',12,'Lolosnya barang-barang terlarang (prohibited item) ke bandar udara','Jumlah lolosnya barang-barang terlarang (prohibited item) ke bandar udara',9,6,NULL,NULL,NULL,NULL),(116,116,'-',12,'Pencapaian On Time Performance (OTP)','Persentase pencapaian On Time Performance (OTP)',76.26,76.87,NULL,NULL,NULL,NULL),(117,117,'-',12,'Rute pelayanan perintis','Jumlah rute pelayanan perintis',132,130,NULL,NULL,NULL,NULL),(118,118,'-',12,'Penumpang perintis yang diangkut','Jumlah penumpang perintis yang diangkut',274456,159792,NULL,NULL,NULL,NULL),(119,119,'-',12,'Kota/daerah yang terhubungi','Jumlah kota/daerah yang terhubungi',129,127,NULL,NULL,NULL,NULL),(120,120,'-',12,'Bandar udara dengan kapasitas sesuai kebutuhan jaringan dan kategori','Jumlah bandar udara dengan kapasitas sesuai kebutuhan jaringan dan kategori',115,159,NULL,NULL,NULL,NULL),(121,121,'-',12,'Penumpang yang diangkut','Jumlah penumpang yang diangkut',7.72216e+07,8.13576e+07,NULL,NULL,NULL,NULL),(122,122,'-',12,'Kargo yang diangkut','Jumlah kargo yang diangkut',1.09602e+06,662238,NULL,NULL,NULL,NULL),(123,123,'-',12,'Pesawat udara yang memiliki sertifikat kelaikudaraan','Jumlah pesawat udara yang memiliki sertifikat kelaikudaraan',1025,1042,NULL,NULL,NULL,NULL),(124,124,'-',12,'Bandar udara yang memiliki sertifikat','Jumlah bandar udara yang memiliki sertifikat',15,16,NULL,NULL,NULL,NULL),(125,125,'-',12,'Inspektur Penerbangan','Jumlah Inspektur Penerbangan',659,659,NULL,NULL,NULL,NULL),(126,126,'-',12,'Personil penerbangan yang memiliki lisensi','Jumlah personil penerbangan yang memiliki lisensi',56396,58175,NULL,NULL,NULL,NULL),(127,127,'-',12,'Kerjasama pemerintah dengan swasta dan/atau Pemerintah Daerah di bidang transportasi udara','Jumlah kerjasama pemerintah dengan swasta dan/atau Pemerintah Daerah di bidang transportasi udara',10,9,NULL,NULL,NULL,NULL),(128,128,'-',12,'Peraturan yang diterbitkan di bidang transportasi udara','Jumlah peraturan yang diterbitkan di bidang transportasi udara',30,36,NULL,NULL,NULL,NULL),(129,129,'-',12,'Nilai AKIP Direktorat Jenderal Perhubungan Udara','Nilai AKIP Direktorat Jenderal Perhubungan Udara',83.61,83.36,NULL,NULL,NULL,NULL),(130,130,'-',12,'Penyerapan anggaran Direktorat Jenderal Perhubungan Udara','Tingkat penyerapan anggaran Direktorat Jenderal Perhubungan Udara',86,87.59,NULL,NULL,NULL,NULL),(131,131,'-',12,'Nilai aset Direktorat Jenderal Perhubungan Udara','Nilai aset Direktorat Jenderal Perhubungan Udara yang berhasil diinventarisasi',2.94e+13,3.61e+13,NULL,NULL,NULL,NULL),(132,132,'-',12,'Bandara yang memenuhi eco airport (AMDAL)','Persentase bandara yang memenuhi eco airport (AMDAL)',15,15,NULL,NULL,NULL,NULL),(133,133,'-',12,'Konsumsi energi dari sumber tak terbarukan untuk transportasi udara','Jumlah konsumsi energi dari sumber tak terbarukan untuk transportasi udara',3.75101e+06,3.75848e+06,NULL,NULL,NULL,NULL),(134,134,'-',12,'Emisi gas buang CO2 dengan kegiatan peremajaan armada angkutan udara','Penurunan emisi gas buang CO2 dengan kegiatan peremajaan armada angkutan udara',66272.1,56331.3,NULL,NULL,NULL,NULL),(135,135,'-',12,'Kejadian kecelakaan kereta api','Jumlah kejadian kecelakaan kereta api khususnya kejadian anjlokan dan kejadian tabrakan antar kereta api',30,31,NULL,NULL,NULL,NULL),(136,136,'-',12,'Realisasi ketepatan waktu keberangkatan dan kedatangan kereta api (on-time performance)','Persentase realisasi ketepatan waktu keberangkatan dan kedatangan kereta api (on-time performance)',78.94,75.6,NULL,NULL,NULL,NULL),(137,137,'-',12,'Keterlambatan kereta api','Rata-rata keterlambatan kereta api',40,44.64,NULL,NULL,NULL,NULL),(138,138,'-',12,'Sertifikat kelaikan sarana perkeretaapian','Jumlah sertifikat kelaikan sarana perkeretaapian yang dikeluarkan tepat waktu',2568,3307,NULL,NULL,NULL,NULL),(139,139,'-',12,'Sertifikat kelaikan prasarana perkeretaapian','Jumlah sertifikat kelaikan prasarana perkeretaapian yang dikeluarkan tepat waktu',17,5,NULL,NULL,NULL,NULL),(140,140,'-',12,'Lintas pelayanan (penambahan/perubahan rute)','Jumlah lintas pelayanan (penambahan/perubahan rute)',148,168,NULL,NULL,NULL,NULL),(141,141,'-',12,'Lintas PSO dan perintis angkutan kereta api','Jumlah lintas PSO dan perintis angkutan kereta api',63,69,NULL,NULL,NULL,NULL),(142,142,'-',12,'Jalur KA yang dibangun dan direvitalisasi','Panjang jalur KA yang dibangun dan direvitalisasi',377.95,225.93,NULL,NULL,NULL,NULL),(143,143,'-',12,'Peningkatan kontribusi moda KA dalam angkutan barang','Persentase peningkatan kontribusi moda KA dalam angkutan barang sebagai indikator keberhasilan kebijakan modal-shifting ke kereta api',5.5,0.39,NULL,NULL,NULL,NULL),(144,144,'-',12,'Peningkatan kontribusi moda KA dalam angkutan penumpang','Persentase peningkatan kontribusi moda KA dalam angkutan penumpang sebagai indikator keberhasilan kebijakan modal-shifting ke kereta api',8.26,0.17,NULL,NULL,NULL,NULL),(145,145,'-',12,'Sarana (pengadaan/modifikasi/ rehabilitasi)','Jumlah sarana (pengadaan/modifikasi/ rehabilitasi)',99,85,NULL,NULL,NULL,NULL),(146,146,'-',12,'Penumpang KA yang dilayani','Jumlah penumpang KA yang dilayani',2.284e+08,1.32746e+08,NULL,NULL,NULL,NULL),(147,147,'-',12,'Angkutan barang yang dilayani oleh KA','Jumlah angkutan barang yang dilayani oleh KA',2.9318e+07,2.20791e+07,NULL,NULL,NULL,NULL),(148,148,'-',12,'Perizinan (izin usaha, izin pembangunan, izin operasi sarana/prasarana) dan jumlah rekomendasi/persetujuan perizinan penyelenggaraan perkeretaapian','Jumlah perizinan: jumlah izin usaha, jumlah izin pembangunan, jumlah izin operasi sarana/prasarana dan jumlah rekomendasi/ persetujuan perizinan penyelenggaraan perkeretaapian',70,70,NULL,NULL,NULL,NULL),(149,149,'-',12,'Nilai AKIP Direktorat Jenderal Perkeretaapian','Nilai AKIP Direktorat Jenderal Perkeretaapian',80.41,82.17,NULL,NULL,NULL,NULL),(150,150,'-',12,'Penyerapan anggaran Direktorat Jenderal Perkeretaapian','Tingkat penyerapan anggaran Direktorat Jenderal Perkeretaapian',76.04,89.39,NULL,NULL,NULL,NULL),(151,151,'-',12,'Nilai aset Direktorat Jenderal Perkeretaapian yang berhasil diinventarisasi','Nilai aset Direktorat Jenderal Perkeretaapian yang berhasil diinventarisasi',76,81.7,NULL,NULL,NULL,NULL),(152,152,'-',12,'Sertifikat kecakapan SDM perkeretaapian','Jumlah sertifikat kecakapan SDM perkeretaapian',600,1990,NULL,NULL,NULL,NULL),(153,153,'-',12,'Peraturan perundang-undangan di bidang perkeretaapian','Jumlah peraturan perundang-undangan di bidang perkeretaapian yang diterbitkan',7,5,NULL,NULL,NULL,NULL),(154,154,'-',12,'Jalur kereta api yang sudah terelektifikasi','Panjang jalur kereta api yang sudah terelektifikasi',38,44,NULL,NULL,NULL,NULL),(155,155,'-',12,'Penerapan teknologi yang efisien dan ramah lingkungan di bidang perkeretaapian ','Jumlah penerapan teknologi yang efisien dan ramah lingkungan di bidang perkeretaapian ',1,1,NULL,NULL,NULL,NULL),(156,156,'-',12,'Penelitian yang dijadikan bahan masukan/rekomendasi kebijakan bidang perhubungan','Jumlah penelitian yang dijadikan bahan masukan/rekomendasi kebijakan bidang perhubungan',42,45,NULL,NULL,NULL,NULL),(157,157,'-',12,'Penelitian yang dipublikasikan pada jurnal atau buletin yang terakreditasi','Jumlah penelitian yang dipublikasikan pada jurnal atau buletin yang terakreditasi',158,112,NULL,NULL,NULL,NULL),(158,158,'-',12,'Kajian per peneliti','Jumlah kajian per peneliti',370,243,NULL,NULL,NULL,NULL),(159,159,'-',12,'Peserta diklat Transportasi Darat, Laut, Udara, Perkeretaapian dan Aparatur Perhubungan pertahun','Jumlah peserta diklat Transportasi Darat, Laut, Udara, Perkeretaapian dan Aparatur Perhubungan pertahun sesuai standar diklat BPSDM Perhubungan',158305,175793,NULL,NULL,NULL,NULL),(160,160,'-',12,'Lulusan Diklat Transportasi Darat, Laut, Udara, Perkeretaapian dan Aparatur Perhubungan','Jumlah lulusan Diklat Transportasi Darat, Laut, Udara, Perkeretaapian dan Aparatur Perhubungan',149216,162364,NULL,NULL,NULL,NULL),(161,161,'-',12,'Dokumen metode penyelenggaraan Diklat Transportasi Darat, Laut, Udara, Perkeretaapian dan Aparatur Perhubungan','Jumlah dokumen metode penyelenggaraan Diklat Transportasi Darat, Laut, Udara, Perkeretaapian dan Aparatur Perhubungan yang berbasis teknologi informasi',94,100,NULL,NULL,NULL,NULL),(162,162,'-',12,'Sistem informasi yang dibangun','Jumlah sistem informasi yang dibangun',17,17,NULL,NULL,NULL,NULL),(163,163,'-',12,'Kurikulum Diklat Transportasi Darat, Laut, Udara, Perkeretaapian dan Aparatur Perhubungan','Jumlah kurikulum Diklat Transportasi Darat, Laut, Udara, Perkeretaapian dan Aparatur Perhubungan yang berbasis kompetensi',33,30,NULL,NULL,NULL,NULL),(164,164,'-',12,'Silabi Diklat Transportasi Darat, Laut, Udara, Perkeretaapian dan Aparatur Perhubungan','Jumlah silabi Diklat Transportasi Darat, Laut, Udara, Perkeretaapian dan Aparatur Perhubungan yang berbasis kompetensi',1,1,NULL,NULL,NULL,NULL),(165,165,'-',12,'Modul/bahan ajar diklat Transportasi Darat, Laut, Udara, Perkeretaapian dan Aparatur Perhubungan','Jumlah modul/bahan ajar diklat Transportasi Darat, Laut, Udara, Perkeretaapian dan Aparatur Perhubungan yang berbasis kompetensi ',229,664,NULL,NULL,NULL,NULL),(166,166,'-',12,'Lembaga diklat Transportasi Darat, Laut, Udara dan Perkeretaapian yang menjadi Badan Layanan Umum (BLU)','Jumlah lembaga diklat Transportasi Darat, Laut, Udara dan Perkeretaapian yang menjadi Badan Layanan Umum (BLU)',1,0,NULL,NULL,NULL,NULL),(167,167,'-',12,'Dokumen kerjasama dengan lembaga pemerintah/swasta nasional atau asing di Bidang Diklat Transportasi','Jumlah dokumen kerjasama dengan lembaga pemerintah/swasta nasional atau asing di Bidang Diklat Transportasi',4,38,NULL,NULL,NULL,NULL),(168,168,'-',12,'Nilai AKIP BPSDM Perhubungan','Nilai AKIP BPSDM Perhubungan',89.5,89.5,NULL,NULL,NULL,NULL),(169,169,'-',12,'Penyerapan Anggaran BPSDM Perhubungan','Tingkat Penyerapan Anggaran BPSDM Perhubungan',82.17,86.38,NULL,NULL,NULL,NULL),(170,170,'-',12,'Nilai aset BPSDM Perhubungan','Nilai aset BPSDM Perhubungan yang berhasil diinventasisasi',8.81e+12,8.9e+12,NULL,NULL,NULL,NULL),(171,171,'-',12,'Draft peraturan perundangan dan ketentuan pelaksanaan lainnya yang dihasilkan di Bidang SDM Transportasi','Jumlah draft peraturan perundangan dan ketentuan pelaksanaan lainnya yang dihasilkan di Bidang SDM Transportasi',12,20,NULL,NULL,NULL,NULL),(172,172,'-',12,'Sarana diklat Transportasi Darat, Laut, Udara, Perkeretaapian dan Aparatur Perhubungan','Jumlah sarana diklat Transportasi Darat, Laut, Udara, Perkeretaapian dan Aparatur Perhubungan yang berbasis teknologi tinggi/mutakhir',18241,20030,NULL,NULL,NULL,NULL),(173,173,'-',12,'Prasarana diklat Transportasi Darat, Laut, Udara, Perkeretaapian dan Aparatur Perhubungan','Jumlah prasarana diklat Transportasi Darat, Laut, Udara, Perkeretaapian dan Aparatur Perhubungan',261062,244111,NULL,NULL,NULL,NULL),(174,174,'-',12,'Tenaga kependidikan di BPSDM Perhubungan','Jumlah tenaga kependidikan di BPSDM Perhubungan yang prima, profesional dan beretika ',2905,2578,NULL,NULL,NULL,NULL),(175,204,'Inspektorat Jenderal Kementerian Perhubungan',8,'Kritera keberhasilan','Ukuran keberhasilan',80,NULL,'tes','8;2013-08-28 11:38:34',NULL,NULL);
/*!40000 ALTER TABLE `tbl_checkpoint_e1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_checkpoint_kl`
--

DROP TABLE IF EXISTS `tbl_checkpoint_kl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_checkpoint_kl` (
  `id_checkpoint_kl` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_pk_kl` int(11) NOT NULL,
  `unit_kerja` varchar(100) DEFAULT NULL,
  `periode` smallint(6) DEFAULT NULL,
  `kriteria` varchar(255) DEFAULT NULL,
  `ukuran` varchar(255) DEFAULT NULL,
  `target` float DEFAULT NULL,
  `capaian` float DEFAULT NULL,
  `keterangan` text,
  `log_insert` varchar(50) DEFAULT NULL,
  `log_update` varchar(50) DEFAULT NULL,
  `nama_folder_pendukung` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_checkpoint_kl`),
  KEY `fk_checkpoint_penetapan` (`id_pk_kl`),
  CONSTRAINT `fk_checkpoint_penetapan` FOREIGN KEY (`id_pk_kl`) REFERENCES `tbl_pk_kl` (`id_pk_kl`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_checkpoint_kl`
--

LOCK TABLES `tbl_checkpoint_kl` WRITE;
/*!40000 ALTER TABLE `tbl_checkpoint_kl` DISABLE KEYS */;
INSERT INTO `tbl_checkpoint_kl` VALUES (1,1,'Hubdat, KA, Hubla dan Hubud',12,'Kejadian kecelakaan transportasi nasional','Jumlah kejadian kecelakaan transportasi nasional',5003,5356,NULL,NULL,NULL,NULL),(2,2,'Hubla',12,'Gangguan keamanan pada sektor transportasi','Jumlah gangguan keamanan pada sektor transportasi',9,6,NULL,NULL,NULL,NULL),(3,3,'KA, Hubla dan Hubud',12,'Pencapaian On-Time Performance (OTP) sektor transportasi (selain transportasi darat)','Rata-rata persentase pencapaian On-Time Performance (OTP) sektor transportasi (selain transportasi darat)',71.73,72.24,NULL,NULL,NULL,NULL),(4,4,'Hubdat, KA, Hubla dan Hubud',12,'Sarana transportasi yang sudah tersertifikasi','Jumlah sarana transportasi yang sudah tersertifikasi',10981,13619,NULL,NULL,NULL,NULL),(5,5,'Hubdat, KA, dan Hubud',12,'Jumlah prasarana transportasi yang sudah tersertifikasi','Jumlah prasarana transportasi yang sudah tersertifikasi',32,13,NULL,NULL,NULL,NULL),(6,6,'Hubdat, KA, Hubla dan Hubud',12,'Lintas pelayanan angkutan perintis dan subsidi','Jumlah lintas pelayanan angkutan perintis dan subsidi',579,583,NULL,NULL,NULL,NULL),(7,7,'-',12,'Kontribusi sektor transportasi terhadap pertumbuhan ekonomi nasional','Persentase kontribusi sektor transportasi terhadap pertumbuhan ekonomi nasional',1.5,1.15,NULL,NULL,NULL,NULL),(8,8,'Hubdat, KA, Hubla dan Hubud',12,'Total produksi angkutan penumpang','Total produksi angkutan penumpang',8.37526e+08,8.30786e+08,NULL,NULL,NULL,NULL),(9,9,'Hubdat, KA, Hubla dan Hubud',12,'Total produksi angkutan barang','Total produksi angkutan barang',4.17313e+08,3.74727e+08,NULL,NULL,NULL,NULL),(10,10,'Hubdat, Hubla, Hubud, BPSDMP dan PKKPJT',12,'Infrastruktur transportasi yang siap ditawarkan melalui kerjasama Pemerintah-Swasta','Jumlah infrastruktur transportasi yang siap ditawarkan melalui kerjasama Pemerintah-Swasta',2,3,NULL,NULL,NULL,NULL),(11,11,'-',12,'Nilai AKIP Kementerian Perhubungan','Nilai AKIP Kementerian Perhubungan',0,0,NULL,NULL,NULL,NULL),(12,12,'-',12,'Opini BPK atas laporan keuangan Kementerian Perhubungan','Opini BPK atas laporan keuangan Kementerian Perhubungan',0,0,NULL,NULL,NULL,NULL),(13,13,'Setjen, Hubdat, Hubla, Hubud, KA, dan BPSDMP',12,'Aset negara yang berhasil diinventarisasi sesuai kaidah pengelolaan BMN','Nilai aset negara yang berhasil diinventarisasi sesuai kaidah pengelolaan BMN',1.25e+14,1.63e+14,NULL,NULL,NULL,NULL),(14,14,'Hubud',12,'SDM operator prasarana dan sarana transportasi yang telah memiliki sertifikat','Jumlah SDM operator prasarana dan sarana transportasi yang telah memiliki sertifikat',56396,58175,NULL,NULL,NULL,NULL),(15,15,'Hubdat, KA, Hubla dan Hubud',12,'SDM fungsional teknis Kementerian Perhubungan','Jumlah SDM fungsional teknis Kementerian Perhubungan',2249,3637,NULL,NULL,NULL,NULL),(16,16,'BPSDMP',12,'Lulusan diklat SDM Transportasi Darat, Laut, Udara, Perkeretaapian dan Aparatur','Jumlah lulusan diklat SDM Transportasi Darat, Laut, Udara, Perkeretaapian dan Aparatur',149216,162364,NULL,NULL,NULL,NULL),(17,17,'Biro Hukum, Hubdat, KA, Hubla, Hubud dan KSLN',12,'Peraturan perundang-undangan di sektor transportasi yang ditetapkan','Jumlah peraturan perundang-undangan di sektor transportasi yang ditetapkan',55,65,NULL,NULL,NULL,NULL),(18,18,'-',12,'Konsumsi energi tak terbarukan dari sektor transportasi nasional','Jumlah konsumsi energi tak terbarukan dari sektor transportasi nasional',3751.01,3758.48,NULL,NULL,NULL,NULL),(19,19,'-',12,'Emisi gas buang dari sektor transportasi nasional','Jumlah emisi gas buang dari sektor transportasi nasional',89571.3,88691.3,NULL,NULL,NULL,NULL),(20,20,'Hubdat, KA dan Hubla',12,'Penerapan teknologi ramah lingkungan pada sarana dan prasarana transportasi','Jumlah penerapan teknologi ramah lingkungan pada sarana dan prasarana transportasi',3052,2946,NULL,NULL,NULL,NULL),(21,21,'Hubdat, Hubla dan Hubud',12,'Lokasi simpul transportasi yang telah menerapkan konsep ramah lingkungan','Jumlah lokasi simpul transportasi yang telah menerapkan konsep ramah lingkungan',53,53,NULL,NULL,NULL,NULL),(24,22,'Inspektorat Jenderal Kementerian Perhubungan',8,'Kritera keberhasilan','Ukuran keberhasilan',0,0,'','8;2013-08-14 16:27:29','8;2013-08-28 11:33:58','http://192.168.0.100/e-performance/upload/pendukung/kl/22/'),(25,22,'UNit kerja terkait',11,'Kritera keberhasilan','Ukuran keberhasilan',80,0,'tes','8;2013-08-14 16:39:44','8;2013-08-27 17:49:47','http://192.168.0.100/e-performance/upload/pendukung/kl/22/'),(26,22,'UNit kerja terkait',9,'Kritera keberhasilan','Ukuran keberhasilan',80,NULL,'tes','8;2013-08-28 11:21:28',NULL,NULL);
/*!40000 ALTER TABLE `tbl_checkpoint_kl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_datapendukung_e1`
--

DROP TABLE IF EXISTS `tbl_datapendukung_e1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_datapendukung_e1` (
  `id_datapendukung_e1` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_checkpoint_e1` bigint(20) NOT NULL,
  `nama_file` varchar(100) DEFAULT NULL,
  `lokasi_file` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_datapendukung_e1`),
  KEY `fk_checkpoint_pendukung_e1` (`id_checkpoint_e1`),
  CONSTRAINT `fk_checkpoint_pendukung_e1` FOREIGN KEY (`id_checkpoint_e1`) REFERENCES `tbl_checkpoint_e1` (`id_checkpoint_e1`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_datapendukung_e1`
--

LOCK TABLES `tbl_datapendukung_e1` WRITE;
/*!40000 ALTER TABLE `tbl_datapendukung_e1` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_datapendukung_e1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_datapendukung_kl`
--

DROP TABLE IF EXISTS `tbl_datapendukung_kl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_datapendukung_kl` (
  `id_datapendukung_kl` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_checkpoint_kl` bigint(20) NOT NULL,
  `nama_file` varchar(100) DEFAULT NULL,
  `lokasi_file` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_datapendukung_kl`),
  KEY `fk_checkpoint_pendukung_kl` (`id_checkpoint_kl`),
  CONSTRAINT `fk_checkpoint_pendukung_kl` FOREIGN KEY (`id_checkpoint_kl`) REFERENCES `tbl_checkpoint_kl` (`id_checkpoint_kl`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_datapendukung_kl`
--

LOCK TABLES `tbl_datapendukung_kl` WRITE;
/*!40000 ALTER TABLE `tbl_datapendukung_kl` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_datapendukung_kl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_eselon1`
--

DROP TABLE IF EXISTS `tbl_eselon1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_eselon1` (
  `kode_e1` varchar(10) NOT NULL,
  `kode_kl` varchar(10) NOT NULL,
  `nama_e1` varchar(70) DEFAULT NULL,
  `singkatan` varchar(30) NOT NULL,
  `nama_dirjen` varchar(50) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `pangkat` varchar(50) NOT NULL,
  `gol` varchar(5) NOT NULL,
  `log_insert` varchar(50) DEFAULT NULL,
  `log_update` varchar(50) DEFAULT NULL,
  `kunci` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`kode_e1`),
  KEY `fk_eselon1_kl` (`kode_kl`),
  CONSTRAINT `tbl_eselon1_ibfk_1` FOREIGN KEY (`kode_kl`) REFERENCES `tbl_kl` (`kode_kl`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_eselon1`
--

LOCK TABLES `tbl_eselon1` WRITE;
/*!40000 ALTER TABLE `tbl_eselon1` DISABLE KEYS */;
INSERT INTO `tbl_eselon1` VALUES ('022.01','022','Sekretariat Jenderal Kementerian Perhubungan','Setjen','Leon Muhammad','19540404 198703 1001','Pembina Utama Madya','IV/D',NULL,NULL,0),('022.02','022','Inspektorat Jenderal Kementerian Perhubungan','Itjen','Iskandar Abubakar','19530627 197803 1001','Pembina Utama','IV/E',NULL,NULL,1),('022.03','022','Direktorat Jenderal Perhubungan Darat','Ditjen Hubdat','Soeroyo Alimoeso','19531018 197602 1001','Pembina Utama Madya','IV/D',NULL,NULL,1),('022.04','022','Direktorat Jenderal Perhubungan Laut','Ditjen Hubla','Capt. Bobby R. Mamahit','19560912 198503 1002','Pembina Utama','IV/E',NULL,NULL,1),('022.05','022','Direktorat Jenderal Perhubungan Udara','Ditjen Hubud','Herry Bakti','19530419 198003 1001','Pembina Utama Madya','IV/D',NULL,NULL,1),('022.08','022','Direktorat Jenderal Perkeretaapian','Ditjen KA','Tundjung Inderawan','19530731 197703 1002','Pembina Utama Muda','IV/D',NULL,NULL,1),('022.11','022','Badan Penelitian dan Pengembangan Perhubungan','Balitbang','L. Denny Siahaan','19520327 197803 1003','Pembina Utama','IV/E',NULL,NULL,1),('022.12','022','Badan Pengembangan Sumber Daya Manusia Perhubungan','BPSDMP','Santoso Eddy Wibowo','19550720 198102 1001','Pembina Utama','IV/E',NULL,NULL,1);
/*!40000 ALTER TABLE `tbl_eselon1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_eselon2`
--

DROP TABLE IF EXISTS `tbl_eselon2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_eselon2` (
  `kode_e2` varchar(10) NOT NULL,
  `kode_e1` varchar(10) NOT NULL,
  `nama_e2` varchar(70) DEFAULT NULL,
  `singkatan` varchar(30) NOT NULL,
  `nama_direktur` varchar(50) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `pangkat` varchar(50) NOT NULL,
  `gol` varchar(5) NOT NULL,
  `log_insert` varchar(50) DEFAULT NULL,
  `log_update` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`kode_e2`),
  KEY `FK_tbl_eselon2` (`kode_e1`),
  CONSTRAINT `tbl_eselon2_ibfk_1` FOREIGN KEY (`kode_e1`) REFERENCES `tbl_eselon1` (`kode_e1`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_eselon2`
--

LOCK TABLES `tbl_eselon2` WRITE;
/*!40000 ALTER TABLE `tbl_eselon2` DISABLE KEYS */;
INSERT INTO `tbl_eselon2` VALUES ('022.01.01','022.01','Biro Perencanaan','Biroren','tbd','tbd','tbd','tbd',NULL,NULL),('022.01.02','022.01','Biro Kepegawaian dan Organisasi','','tbd','tbd','tbd','tbd',NULL,NULL),('022.01.03','022.01','Biro Keuangan dan Perlengkapan','','tbd','tbd','tbd','tbd',NULL,NULL),('022.01.04','022.01','Biro Hukum dan Kerjasama Luar Negeri','Biro HKLN','tbd','tbd','tbd','tbd',NULL,NULL),('022.01.05','022.01','Biro Umum','','tbd','tbd','tbd','tbd',NULL,NULL),('022.01.06','022.01','Pusat Komunikasi Publik','','tbd','tbd','tbd','tbd',NULL,NULL),('022.01.07','022.01','Pusat Kajian Kemitraan dan Pelayanan Jasa Transpor','','tbd','tbd','tbd','tbd',NULL,NULL),('022.01.08','022.01','Mahkamah Pelayaran','','tbd','tbd','tbd','tbd',NULL,NULL),('022.01.09','022.01','Pusat Data dan Informasi','Pusdatin','tbd','tbd','tbd','tbd',NULL,NULL);
/*!40000 ALTER TABLE `tbl_eselon2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_exception_ikk`
--

DROP TABLE IF EXISTS `tbl_exception_ikk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_exception_ikk` (
  `tahun` year(4) NOT NULL,
  `kode_ikk` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_exception_ikk`
--

LOCK TABLES `tbl_exception_ikk` WRITE;
/*!40000 ALTER TABLE `tbl_exception_ikk` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_exception_ikk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_exception_iku_eselon1`
--

DROP TABLE IF EXISTS `tbl_exception_iku_eselon1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_exception_iku_eselon1` (
  `tahun` year(4) NOT NULL,
  `kode_iku_e1` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_exception_iku_eselon1`
--

LOCK TABLES `tbl_exception_iku_eselon1` WRITE;
/*!40000 ALTER TABLE `tbl_exception_iku_eselon1` DISABLE KEYS */;
INSERT INTO `tbl_exception_iku_eselon1` VALUES (2012,'IKUSSPD03.01'),(2012,'IKUSSPD03.02'),(2012,'IKUSSPL01.01'),(2012,'IKUSSPL01.02'),(2012,'IKUSSPL05.01'),(2012,'IKUSSPU01.02'),(2012,'IKUSSPU02.01'),(2012,'IKUSSPU02.02'),(2012,'IKUSSPU03.01'),(2012,'IKUSSPU04.01'),(2012,'IKUSSKA02.01'),(2012,'IKUSSKA03.01'),(2012,'IKUSSKA03.02'),(2013,'IKUSSPD03.01'),(2013,'IKUSSPD03.02'),(2013,'IKUSSPL01.01'),(2013,'IKUSSPL01.02'),(2013,'IKUSSPL05.01'),(2013,'IKUSSPU01.02'),(2013,'IKUSSPU02.01'),(2013,'IKUSSPU02.02'),(2013,'IKUSSPU03.01'),(2013,'IKUSSPU04.01'),(2013,'IKUSSKA02.01'),(2013,'IKUSSKA03.01'),(2013,'IKUSSKA03.02'),(2012,'IKUSSPD03.01'),(2012,'IKUSSPD03.02'),(2012,'IKUSSPL01.01'),(2012,'IKUSSPL01.02'),(2012,'IKUSSPL05.01'),(2012,'IKUSSPU01.02'),(2012,'IKUSSPU02.01'),(2012,'IKUSSPU02.02'),(2012,'IKUSSPU03.01'),(2012,'IKUSSPU04.01'),(2012,'IKUSSKA02.01'),(2012,'IKUSSKA03.01'),(2012,'IKUSSKA03.02'),(2013,'IKUSSPD03.01'),(2013,'IKUSSPD03.02'),(2013,'IKUSSPL01.01'),(2013,'IKUSSPL01.02'),(2013,'IKUSSPL05.01'),(2013,'IKUSSPU01.02'),(2013,'IKUSSPU02.01'),(2013,'IKUSSPU02.02'),(2013,'IKUSSPU03.01'),(2013,'IKUSSPU04.01'),(2013,'IKUSSKA02.01'),(2013,'IKUSSKA03.01'),(2013,'IKUSSKA03.02');
/*!40000 ALTER TABLE `tbl_exception_iku_eselon1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_exception_iku_kl`
--

DROP TABLE IF EXISTS `tbl_exception_iku_kl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_exception_iku_kl` (
  `tahun` year(4) NOT NULL,
  `kode_iku_kl` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_exception_iku_kl`
--

LOCK TABLES `tbl_exception_iku_kl` WRITE;
/*!40000 ALTER TABLE `tbl_exception_iku_kl` DISABLE KEYS */;
INSERT INTO `tbl_exception_iku_kl` VALUES (2012,'IKUSSKP01.01'),(2012,'IKUSSKP02.01'),(2012,'IKUSSKP03.01'),(2012,'IKUSSKP12.02'),(2013,'IKUSSKP01.01'),(2013,'IKUSSKP02.01'),(2013,'IKUSSKP03.01'),(2013,'IKUSSKP12.02'),(2012,'IKUSSKP01.01'),(2012,'IKUSSKP02.01'),(2012,'IKUSSKP03.01'),(2012,'IKUSSKP12.02'),(2013,'IKUSSKP01.01'),(2013,'IKUSSKP02.01'),(2013,'IKUSSKP03.01'),(2013,'IKUSSKP12.02');
/*!40000 ALTER TABLE `tbl_exception_iku_kl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_group_access`
--

DROP TABLE IF EXISTS `tbl_group_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_group_access` (
  `menu_id` smallint(6) NOT NULL DEFAULT '0',
  `level_id` smallint(6) NOT NULL DEFAULT '0',
  `group_id` smallint(6) NOT NULL DEFAULT '0',
  `policy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`menu_id`,`level_id`,`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_group_access`
--

LOCK TABLES `tbl_group_access` WRITE;
/*!40000 ALTER TABLE `tbl_group_access` DISABLE KEYS */;
INSERT INTO `tbl_group_access` VALUES (1,3,1,''),(2,3,1,'VIEW;PRINT;EXCEL;'),(3,3,1,'VIEW;PRINT;EXCEL;'),(4,3,1,'VIEW;PRINT;EXCEL;'),(6,3,1,'VIEW;PRINT;EXCEL;'),(7,3,1,'VIEW;PRINT;EXCEL;'),(30,3,1,''),(31,3,1,'VIEW;ADD;EDIT;PRINT;EXCEL;IMPORT;'),(32,3,1,'VIEW;'),(33,3,1,''),(34,3,1,'VIEW;ADD;EDIT;PRINT;EXCEL;IMPORT;'),(35,3,1,'VIEW;'),(36,3,1,''),(50,3,1,''),(51,3,1,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(52,3,1,'VIEW;'),(53,3,1,''),(100,3,1,''),(101,3,1,''),(102,3,1,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(103,3,1,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(104,3,1,''),(105,3,1,'VIEW;'),(106,3,1,''),(107,3,1,''),(108,3,1,''),(109,3,1,''),(150,3,1,''),(151,3,1,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(152,3,1,'VIEW;'),(153,3,1,''),(200,3,1,''),(201,3,1,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(202,3,1,'VIEW;'),(203,3,1,''),(250,3,1,''),(251,3,1,''),(252,3,1,'VIEW;PRINT;EXCEL;'),(253,3,1,'VIEW;'),(254,3,1,''),(255,3,1,''),(256,3,1,'VIEW;PRINT;EXCEL;'),(257,3,1,'VIEW;'),(258,3,1,''),(260,3,1,''),(261,3,1,'VIEW;PRINT;EXCEL;'),(262,3,1,'VIEW;'),(263,3,1,''),(265,3,1,''),(266,3,1,'VIEW;PRINT;EXCEL;'),(267,3,1,'VIEW;'),(268,3,1,''),(270,3,1,''),(271,3,1,'VIEW;PRINT;EXCEL;'),(272,3,1,'VIEW;'),(273,3,1,''),(274,3,1,'VIEW;PRINT;EXCEL;'),(300,3,1,''),(302,3,1,''),(303,3,1,''),(350,3,1,''),(351,3,1,''),(352,3,1,''),(353,3,1,''),(355,3,1,''),(356,3,1,''),(357,3,1,''),(358,3,1,''),(359,3,1,''),(360,3,1,''),(1,4,1,''),(2,4,1,'VIEW;PRINT;'),(3,4,1,'VIEW;PRINT;'),(4,4,1,'VIEW;PRINT;'),(6,4,1,'VIEW;PRINT;'),(7,4,1,'VIEW;PRINT;'),(30,4,1,''),(31,4,1,'VIEW;PRINT;'),(32,4,1,'VIEW;PRINT;'),(33,4,1,''),(34,4,1,'VIEW;PRINT;'),(35,4,1,'VIEW;PRINT;'),(36,4,1,''),(50,4,1,''),(51,4,1,'VIEW;PRINT;'),(52,4,1,'VIEW;PRINT;'),(53,4,1,''),(100,4,1,''),(101,4,1,''),(102,4,1,'VIEW;PRINT;'),(103,4,1,''),(104,4,1,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(105,4,1,'VIEW;PRINT;'),(106,4,1,''),(107,4,1,''),(108,4,1,''),(109,4,1,''),(150,4,1,''),(151,4,1,'VIEW;PRINT;'),(152,4,1,'VIEW;PRINT;'),(153,4,1,''),(200,4,1,''),(201,4,1,'VIEW;PRINT;'),(202,4,1,'VIEW;PRINT;'),(203,4,1,''),(250,4,1,''),(251,4,1,''),(252,4,1,'VIEW;PRINT;'),(253,4,1,'VIEW;PRINT;'),(254,4,1,''),(255,4,1,''),(256,4,1,'VIEW;PRINT;'),(257,4,1,'VIEW;PRINT;'),(258,4,1,''),(260,4,1,''),(261,4,1,'VIEW;PRINT;EXCEL;'),(262,4,1,'VIEW;'),(263,4,1,''),(265,4,1,''),(266,4,1,'VIEW;PRINT;'),(267,4,1,'VIEW;PRINT;'),(268,4,1,''),(270,4,1,''),(271,4,1,'VIEW;PRINT;'),(272,4,1,'VIEW;PRINT;'),(273,4,1,''),(274,4,1,''),(300,4,1,''),(302,4,1,''),(303,4,1,''),(350,4,1,''),(351,4,1,''),(352,4,1,''),(353,4,1,''),(355,4,1,''),(356,4,1,''),(357,4,1,''),(358,4,1,''),(359,4,1,''),(360,4,1,''),(1,3,2,''),(2,3,2,'VIEW;PRINT;EXCEL;'),(3,3,2,'VIEW;PRINT;EXCEL;'),(4,3,2,'VIEW;PRINT;EXCEL;'),(6,3,2,'VIEW;PRINT;EXCEL;'),(7,3,2,'VIEW;PRINT;EXCEL;'),(30,3,2,''),(31,3,2,''),(32,3,2,'VIEW;ADD;EDIT;PRINT;EXCEL;IMPORT;'),(33,3,2,'VIEW;'),(34,3,2,''),(35,3,2,'VIEW;ADD;EDIT;PRINT;EXCEL;IMPORT;'),(36,3,2,'VIEW;'),(50,3,2,''),(51,3,2,''),(52,3,2,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(53,3,2,'VIEW;'),(100,3,2,''),(101,3,2,''),(102,3,2,''),(103,3,2,''),(104,3,2,''),(105,3,2,''),(106,3,2,''),(107,3,2,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(108,3,2,''),(109,3,2,''),(150,3,2,''),(151,3,2,''),(152,3,2,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(153,3,2,'VIEW;'),(200,3,2,''),(201,3,2,''),(202,3,2,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(203,3,2,'VIEW;'),(250,3,2,''),(251,3,2,''),(252,3,2,''),(253,3,2,'VIEW;PRINT;EXCEL;'),(254,3,2,'VIEW;'),(255,3,2,''),(256,3,2,''),(257,3,2,'VIEW;PRINT;EXCEL;'),(258,3,2,'VIEW;'),(260,3,2,''),(261,3,2,''),(262,3,2,'VIEW;PRINT;EXCEL;'),(263,3,2,'VIEW;'),(265,3,2,''),(266,3,2,''),(267,3,2,'VIEW;PRINT;EXCEL;'),(268,3,2,'VIEW;'),(270,3,2,''),(271,3,2,''),(272,3,2,'VIEW;PRINT;EXCEL;'),(273,3,2,'VIEW;'),(274,3,2,'VIEW;PRINT;EXCEL;'),(300,3,2,''),(302,3,2,''),(303,3,2,''),(350,3,2,''),(351,3,2,''),(352,3,2,''),(353,3,2,''),(355,3,2,''),(356,3,2,''),(357,3,2,''),(358,3,2,''),(359,3,2,''),(360,3,2,''),(1,4,2,''),(2,4,2,'VIEW;PRINT;EXCEL;'),(3,4,2,'VIEW;PRINT;EXCEL;'),(4,4,2,'VIEW;PRINT;EXCEL;'),(6,4,2,'VIEW;PRINT;EXCEL;'),(7,4,2,'VIEW;PRINT;EXCEL;'),(30,4,2,''),(31,4,2,''),(32,4,2,'VIEW;ADD;EDIT;PRINT;EXCEL;IMPORT;'),(33,4,2,'VIEW;'),(34,4,2,''),(35,4,2,'VIEW;ADD;EDIT;PRINT;EXCEL;IMPORT;'),(36,4,2,'VIEW;'),(50,4,2,''),(51,4,2,''),(52,4,2,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(53,4,2,'VIEW;'),(100,4,2,''),(101,4,2,''),(102,4,2,''),(103,4,2,''),(104,4,2,''),(105,4,2,''),(106,4,2,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(107,4,2,''),(108,4,2,'VIEW;'),(109,4,2,''),(150,4,2,''),(151,4,2,''),(152,4,2,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(153,4,2,'VIEW;'),(200,4,2,''),(201,4,2,''),(202,4,2,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(203,4,2,'VIEW;'),(250,4,2,''),(251,4,2,''),(252,4,2,''),(253,4,2,'VIEW;PRINT;EXCEL;'),(254,4,2,'VIEW;'),(255,4,2,''),(256,4,2,''),(257,4,2,'VIEW;PRINT;EXCEL;'),(258,4,2,'VIEW;'),(260,4,2,''),(261,4,2,''),(262,4,2,'VIEW;PRINT;EXCEL;'),(263,4,2,'VIEW;'),(265,4,2,''),(266,4,2,''),(267,4,2,'VIEW;PRINT;EXCEL;'),(268,4,2,'VIEW;'),(270,4,2,''),(271,4,2,''),(272,4,2,'VIEW;PRINT;EXCEL;'),(273,4,2,'VIEW;'),(274,4,2,'VIEW;PRINT;EXCEL;'),(300,4,2,''),(302,4,2,''),(303,4,2,''),(350,4,2,''),(351,4,2,''),(352,4,2,''),(353,4,2,''),(355,4,2,''),(356,4,2,''),(357,4,2,''),(358,4,2,''),(359,4,2,''),(360,4,2,''),(1,3,3,''),(2,3,3,'VIEW;PRINT;EXCEL;'),(3,3,3,'VIEW;PRINT;EXCEL;'),(4,3,3,'VIEW;PRINT;EXCEL;'),(6,3,3,'VIEW;PRINT;EXCEL;'),(7,3,3,'VIEW;PRINT;EXCEL;'),(30,3,3,''),(31,3,3,''),(32,3,3,''),(33,3,3,'VIEW;ADD;EDIT;PRINT;EXCEL;IMPORT;'),(34,3,3,''),(35,3,3,''),(36,3,3,'VIEW;ADD;EDIT;PRINT;EXCEL;IMPORT;'),(50,3,3,''),(51,3,3,''),(52,3,3,''),(53,3,3,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(100,3,3,''),(101,3,3,''),(102,3,3,''),(103,3,3,''),(104,3,3,''),(105,3,3,''),(106,3,3,''),(107,3,3,''),(108,3,3,'VIEW;ADD;EDIT;DELETE;'),(109,3,3,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(150,3,3,''),(151,3,3,''),(152,3,3,''),(153,3,3,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(200,3,3,''),(201,3,3,''),(202,3,3,''),(203,3,3,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(250,3,3,''),(251,3,3,''),(252,3,3,''),(253,3,3,''),(254,3,3,'VIEW;PRINT;EXCEL;'),(255,3,3,''),(256,3,3,''),(257,3,3,''),(258,3,3,'VIEW;PRINT;EXCEL;'),(260,3,3,''),(261,3,3,''),(262,3,3,''),(263,3,3,'VIEW;PRINT;EXCEL;'),(265,3,3,''),(266,3,3,''),(267,3,3,''),(268,3,3,'VIEW;PRINT;EXCEL;'),(270,3,3,''),(271,3,3,''),(272,3,3,''),(273,3,3,'VIEW;PRINT;EXCEL;'),(274,3,3,'VIEW;PRINT;EXCEL;'),(300,3,3,''),(302,3,3,''),(303,3,3,''),(350,3,3,''),(351,3,3,''),(352,3,3,''),(353,3,3,''),(355,3,3,''),(356,3,3,''),(357,3,3,''),(358,3,3,''),(359,3,3,''),(360,3,3,''),(1,4,3,''),(2,4,3,'VIEW;PRINT;EXCEL;'),(3,4,3,'VIEW;PRINT;EXCEL;'),(4,4,3,'VIEW;PRINT;EXCEL;'),(6,4,3,'VIEW;PRINT;EXCEL;'),(7,4,3,'VIEW;PRINT;EXCEL;'),(30,4,3,''),(31,4,3,''),(32,4,3,''),(33,4,3,'VIEW;ADD;EDIT;PRINT;EXCEL;IMPORT;'),(34,4,3,''),(35,4,3,''),(36,4,3,'VIEW;ADD;EDIT;PRINT;EXCEL;IMPORT;'),(50,4,3,''),(51,4,3,''),(52,4,3,''),(53,4,3,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(100,4,3,''),(101,4,3,''),(102,4,3,''),(103,4,3,''),(104,4,3,''),(105,4,3,''),(106,4,3,''),(107,4,3,''),(108,4,3,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(109,4,3,''),(150,4,3,''),(151,4,3,''),(152,4,3,''),(153,4,3,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(200,4,3,''),(201,4,3,''),(202,4,3,''),(203,4,3,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(250,4,3,''),(251,4,3,''),(252,4,3,''),(253,4,3,''),(254,4,3,'VIEW;PRINT;EXCEL;'),(255,4,3,''),(256,4,3,''),(257,4,3,''),(258,4,3,'VIEW;PRINT;EXCEL;'),(260,4,3,''),(261,4,3,''),(262,4,3,''),(263,4,3,'VIEW;PRINT;EXCEL;'),(265,4,3,''),(266,4,3,''),(267,4,3,''),(268,4,3,'VIEW;PRINT;EXCEL;'),(270,4,3,''),(271,4,3,''),(272,4,3,''),(273,4,3,'VIEW;PRINT;EXCEL;'),(274,4,3,'VIEW;PRINT;EXCEL;'),(300,4,3,''),(302,4,3,''),(303,4,3,''),(350,4,3,''),(351,4,3,''),(352,4,3,''),(353,4,3,''),(355,4,3,''),(356,4,3,''),(357,4,3,''),(358,4,3,''),(359,4,3,''),(360,4,3,''),(0,4,1,''),(0,3,1,''),(0,3,2,''),(0,4,2,''),(0,3,3,''),(0,4,3,''),(1,2,3,''),(2,2,3,'VIEW;PRINT;EXCEL;'),(3,2,3,'VIEW;PRINT;EXCEL;'),(4,2,3,'VIEW;PRINT;EXCEL;'),(6,2,3,'VIEW;PRINT;EXCEL;'),(7,2,3,'VIEW;PRINT;EXCEL;'),(30,2,3,''),(31,2,3,'VIEW;PRINT;EXCEL;'),(32,2,3,'VIEW;PRINT;EXCEL;'),(33,2,3,'VIEW;ADD;EDIT;PRINT;EXCEL;IMPORT;'),(34,2,3,'VIEW;PRINT;EXCEL;'),(35,2,3,'VIEW;PRINT;EXCEL;'),(36,2,3,'VIEW;ADD;EDIT;PRINT;EXCEL;IMPORT;'),(50,2,3,''),(51,2,3,''),(52,2,3,'VIEW;PRINT;EXCEL;'),(53,2,3,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(100,2,3,''),(102,2,3,''),(103,2,3,''),(105,2,3,'VIEW;PRINT;EXCEL;'),(106,2,3,''),(108,2,3,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(109,2,3,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(150,2,3,''),(151,2,3,''),(152,2,3,''),(153,2,3,''),(200,2,3,''),(201,2,3,''),(202,2,3,''),(203,2,3,''),(250,2,3,''),(252,2,3,''),(253,2,3,''),(254,2,3,''),(256,2,3,''),(257,2,3,''),(258,2,3,''),(261,2,3,''),(262,2,3,''),(263,2,3,''),(266,2,3,''),(267,2,3,''),(268,2,3,''),(271,2,3,''),(272,2,3,''),(273,2,3,''),(274,2,3,''),(300,2,3,''),(302,2,3,''),(303,2,3,''),(350,2,3,''),(351,2,3,''),(352,2,3,''),(353,2,3,''),(356,2,3,''),(357,2,3,''),(358,2,3,''),(359,2,3,''),(360,2,3,''),(0,2,3,''),(1,2,1,''),(2,2,1,'VIEW;ADD;EDIT;PRINT;EXCEL;'),(3,2,1,'VIEW;ADD;EDIT;PRINT;EXCEL;'),(4,2,1,'VIEW;ADD;EDIT;PRINT;EXCEL;'),(6,2,1,'VIEW;ADD;EDIT;PRINT;EXCEL;'),(7,2,1,'VIEW;ADD;EDIT;PRINT;EXCEL;'),(30,2,1,''),(31,2,1,'VIEW;ADD;EDIT;PRINT;EXCEL;IMPORT;'),(32,2,1,'VIEW;ADD;EDIT;PRINT;EXCEL;IMPORT;'),(33,2,1,'VIEW;ADD;EDIT;PRINT;EXCEL;IMPORT;'),(34,2,1,'VIEW;ADD;EDIT;PRINT;EXCEL;IMPORT;'),(35,2,1,'VIEW;ADD;EDIT;PRINT;EXCEL;IMPORT;'),(36,2,1,'VIEW;ADD;EDIT;PRINT;EXCEL;IMPORT;'),(50,2,1,''),(51,2,1,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(52,2,1,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(53,2,1,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(100,2,1,''),(102,2,1,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(103,2,1,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(105,2,1,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(106,2,1,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(108,2,1,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(109,2,1,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(150,2,1,''),(151,2,1,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(152,2,1,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(153,2,1,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(200,2,1,''),(201,2,1,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(202,2,1,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(203,2,1,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(250,2,1,''),(252,2,1,'VIEW;PRINT;EXCEL;'),(253,2,1,'VIEW;PRINT;EXCEL;'),(254,2,1,'VIEW;PRINT;EXCEL;'),(256,2,1,'VIEW;PRINT;EXCEL;'),(257,2,1,'VIEW;PRINT;EXCEL;'),(258,2,1,'VIEW;PRINT;EXCEL;'),(261,2,1,'VIEW;PRINT;EXCEL;'),(262,2,1,'VIEW;PRINT;EXCEL;'),(263,2,1,'VIEW;PRINT;EXCEL;'),(266,2,1,'VIEW;PRINT;EXCEL;'),(267,2,1,'VIEW;PRINT;EXCEL;'),(268,2,1,'VIEW;PRINT;EXCEL;'),(271,2,1,'VIEW;PRINT;EXCEL;'),(272,2,1,'VIEW;PRINT;EXCEL;'),(273,2,1,'VIEW;PRINT;EXCEL;'),(274,2,1,'VIEW;PRINT;EXCEL;'),(300,2,1,''),(302,2,1,'VIEW;ADD;EDIT;PRINT;'),(303,2,1,'EDIT;'),(350,2,1,''),(351,2,1,'PROSES;'),(352,2,1,'PROSES;'),(353,2,1,'PROSES;'),(356,2,1,'VIEW;PRINT;'),(357,2,1,'VIEW;PRINT;'),(358,2,1,'VIEW;PRINT;'),(359,2,1,'VIEW;PRINT;'),(360,2,1,'VIEW;PRINT;'),(0,2,1,''),(1,2,2,''),(2,2,2,'VIEW;ADD;EDIT;PRINT;EXCEL;'),(3,2,2,'VIEW;ADD;EDIT;PRINT;EXCEL;'),(4,2,2,'VIEW;ADD;EDIT;PRINT;EXCEL;'),(6,2,2,'VIEW;ADD;EDIT;PRINT;EXCEL;'),(7,2,2,'VIEW;ADD;EDIT;PRINT;EXCEL;'),(30,2,2,''),(31,2,2,'VIEW;ADD;EDIT;PRINT;EXCEL;IMPORT;'),(32,2,2,'VIEW;ADD;EDIT;PRINT;EXCEL;IMPORT;'),(33,2,2,'VIEW;ADD;EDIT;PRINT;EXCEL;IMPORT;'),(34,2,2,'VIEW;ADD;EDIT;PRINT;EXCEL;IMPORT;'),(35,2,2,'VIEW;ADD;EDIT;PRINT;EXCEL;IMPORT;'),(36,2,2,'VIEW;ADD;EDIT;PRINT;EXCEL;IMPORT;'),(50,2,2,''),(51,2,2,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(52,2,2,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(53,2,2,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(100,2,2,''),(102,2,2,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(103,2,2,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(105,2,2,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(106,2,2,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(108,2,2,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(109,2,2,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(150,2,2,''),(151,2,2,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(152,2,2,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(153,2,2,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(200,2,2,''),(201,2,2,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(202,2,2,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(203,2,2,'VIEW;ADD;EDIT;DELETE;PRINT;EXCEL;'),(250,2,2,''),(252,2,2,'VIEW;PRINT;EXCEL;'),(253,2,2,'VIEW;PRINT;EXCEL;'),(254,2,2,'VIEW;PRINT;EXCEL;'),(256,2,2,'VIEW;PRINT;EXCEL;'),(257,2,2,'VIEW;PRINT;EXCEL;'),(258,2,2,'VIEW;PRINT;EXCEL;'),(261,2,2,'VIEW;PRINT;EXCEL;'),(262,2,2,'VIEW;PRINT;EXCEL;'),(263,2,2,'VIEW;PRINT;EXCEL;'),(266,2,2,'VIEW;PRINT;EXCEL;'),(267,2,2,'VIEW;PRINT;EXCEL;'),(268,2,2,'VIEW;PRINT;EXCEL;'),(271,2,2,'VIEW;PRINT;EXCEL;'),(272,2,2,'VIEW;PRINT;EXCEL;'),(273,2,2,'VIEW;PRINT;EXCEL;'),(274,2,2,'VIEW;PRINT;EXCEL;'),(300,2,2,''),(302,2,2,'VIEW;ADD;EDIT;PRINT;'),(303,2,2,'EDIT;'),(350,2,2,''),(351,2,2,'PROSES;'),(352,2,2,'PROSES;'),(353,2,2,'PROSES;'),(356,2,2,'VIEW;PRINT;'),(357,2,2,'VIEW;PRINT;'),(358,2,2,'VIEW;PRINT;'),(359,2,2,'VIEW;PRINT;'),(360,2,2,'VIEW;PRINT;'),(0,2,2,''),(120,2,1,''),(122,2,1,''),(123,2,1,''),(125,2,1,''),(126,2,1,''),(127,2,1,''),(128,2,1,''),(290,2,1,''),(291,2,1,'VIEW;AUTOTAB;'),(292,2,1,'VIEW;'),(293,2,1,'VIEW;'),(294,2,1,'VIEW;'),(400,2,1,''),(401,2,1,''),(402,2,1,''),(404,2,1,''),(405,2,1,''),(406,2,1,''),(407,2,1,''),(408,2,1,''),(409,2,1,'');
/*!40000 ALTER TABLE `tbl_group_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_group_level`
--

DROP TABLE IF EXISTS `tbl_group_level`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_group_level` (
  `level_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `level_name` varchar(40) DEFAULT NULL,
  `level` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`level_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_group_level`
--

LOCK TABLES `tbl_group_level` WRITE;
/*!40000 ALTER TABLE `tbl_group_level` DISABLE KEYS */;
INSERT INTO `tbl_group_level` VALUES (1,'Superadmin',100),(2,'Administrator',90),(3,'Pimpinan',80),(4,'Staff/Operator',10);
/*!40000 ALTER TABLE `tbl_group_level` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_group_user`
--

DROP TABLE IF EXISTS `tbl_group_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_group_user` (
  `group_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(50) DEFAULT NULL,
  `app_type` enum('KL','E1','E2') DEFAULT NULL,
  `level` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_group_user`
--

LOCK TABLES `tbl_group_user` WRITE;
/*!40000 ALTER TABLE `tbl_group_user` DISABLE KEYS */;
INSERT INTO `tbl_group_user` VALUES (1,'Tingkat Kementerian','KL',9),(2,'Tingkat Eselon 1','E1',8),(3,'Tingkat Eselon 2','E2',7),(7,'SuperAdmin',NULL,100);
/*!40000 ALTER TABLE `tbl_group_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_ikk`
--

DROP TABLE IF EXISTS `tbl_ikk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_ikk` (
  `tahun` year(4) NOT NULL,
  `kode_ikk` varchar(20) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `satuan` varchar(40) NOT NULL,
  `kode_iku_e1` varchar(20) DEFAULT NULL,
  `kode_e2` varchar(10) NOT NULL,
  `log_insert` varchar(50) DEFAULT NULL,
  `log_update` varchar(50) DEFAULT NULL,
  `kode_sasaran_e2` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`kode_ikk`,`tahun`),
  KEY `FK_tbl_ikk_e2` (`kode_e2`),
  KEY `FK_tbl_ikk_iku_e1` (`kode_iku_e1`),
  CONSTRAINT `tbl_ikk_ibfk_1` FOREIGN KEY (`kode_e2`) REFERENCES `tbl_eselon2` (`kode_e2`) ON UPDATE CASCADE,
  CONSTRAINT `tbl_ikk_ibfk_2` FOREIGN KEY (`kode_iku_e1`) REFERENCES `tbl_iku_eselon1` (`kode_iku_e1`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_ikk`
--

LOCK TABLES `tbl_ikk` WRITE;
/*!40000 ALTER TABLE `tbl_ikk` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_ikk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_ikk_log`
--

DROP TABLE IF EXISTS `tbl_ikk_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_ikk_log` (
  `tahun` year(4) DEFAULT NULL,
  `kode_ikk` varchar(20) DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `satuan` varchar(40) DEFAULT NULL,
  `kode_iku_e1` varchar(20) DEFAULT NULL,
  `kode_e2` varchar(10) DEFAULT NULL,
  `log` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_ikk_log`
--

LOCK TABLES `tbl_ikk_log` WRITE;
/*!40000 ALTER TABLE `tbl_ikk_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_ikk_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_iku_eselon1`
--

DROP TABLE IF EXISTS `tbl_iku_eselon1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_iku_eselon1` (
  `kode_e1` varchar(10) NOT NULL,
  `tahun` year(4) NOT NULL,
  `kode_iku_e1` varchar(20) NOT NULL,
  `kode_iku_kl` varchar(20) DEFAULT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `satuan` varchar(40) NOT NULL,
  `kode_e2` varchar(10) DEFAULT NULL,
  `log_insert` varchar(50) DEFAULT NULL,
  `log_update` varchar(50) DEFAULT NULL,
  `kode_sasaran_e1` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`kode_iku_e1`,`tahun`),
  KEY `FK_tbl_iku_eselon1` (`kode_e1`),
  KEY `FK_tbl_iku_eselon1_iku_kl` (`kode_iku_kl`),
  KEY `FK_tbl_iku_eselon1_e2` (`kode_e2`),
  KEY `kode_e2_2` (`kode_e2`),
  CONSTRAINT `tbl_iku_eselon1_ibfk_1` FOREIGN KEY (`kode_e1`) REFERENCES `tbl_eselon1` (`kode_e1`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_iku_eselon1`
--

LOCK TABLES `tbl_iku_eselon1` WRITE;
/*!40000 ALTER TABLE `tbl_iku_eselon1` DISABLE KEYS */;
INSERT INTO `tbl_iku_eselon1` VALUES ('022.02',2012,'IKUSSIJ01.01',NULL,'Penurunan persentase kebocoran keuangan negara','%',NULL,NULL,NULL,NULL),('022.02',2013,'IKUSSIJ01.01',NULL,'Penurunan persentase kebocoran keuangan negara','%',NULL,NULL,NULL,NULL),('022.02',2012,'IKUSSIJ01.02',NULL,'Jumlah unit kerja yang ditetapkan menjadi Wilayah Bebas Korupsi (WBK)','Unit Kerja',NULL,NULL,NULL,NULL),('022.02',2013,'IKUSSIJ01.02',NULL,'Jumlah unit kerja yang ditetapkan menjadi Wilayah Bebas Korupsi (WBK)','Unit Kerja',NULL,NULL,NULL,NULL),('022.02',2012,'IKUSSIJ02.01',NULL,'Persentase hasil pengawasan yang ditindaklanjuti','%',NULL,NULL,NULL,NULL),('022.02',2013,'IKUSSIJ02.01',NULL,'Persentase hasil pengawasan yang ditindaklanjuti','%',NULL,NULL,NULL,NULL),('022.02',2012,'IKUSSIJ03.01',NULL,'Persentase penerapan SPIP di Kementerian Perhubungan','%',NULL,NULL,NULL,NULL),('022.02',2013,'IKUSSIJ03.01',NULL,'Persentase penerapan SPIP di Kementerian Perhubungan','%',NULL,NULL,NULL,NULL),('022.02',2012,'IKUSSIJ04.01',NULL,'Nilai rata-rata LAKIP Eselon I hasil evaluasi Inspektorat Jenderal','Nilai',NULL,NULL,NULL,NULL),('022.02',2013,'IKUSSIJ04.01',NULL,'Nilai rata-rata LAKIP Eselon I hasil evaluasi Inspektorat Jenderal','Nilai',NULL,NULL,NULL,NULL),('022.02',2012,'IKUSSIJ05.01',NULL,'Jumlah rekomendasi strategis hasil pengawasan','Rekomendasi',NULL,NULL,NULL,NULL),('022.02',2013,'IKUSSIJ05.01',NULL,'Jumlah rekomendasi strategis hasil pengawasan','Rekomendasi',NULL,NULL,NULL,NULL),('022.02',2012,'IKUSSIJ05.02',NULL,'Persentase audit khusus (investigasi) yang terbukti','%',NULL,NULL,NULL,NULL),('022.02',2013,'IKUSSIJ05.02',NULL,'Persentase audit khusus (investigasi) yang terbukti','%',NULL,NULL,NULL,NULL),('022.02',2012,'IKUSSIJ06.01',NULL,'Jumlah pedoman pengawasan yang ditetapkan','Pedoman',NULL,NULL,NULL,NULL),('022.02',2013,'IKUSSIJ06.01',NULL,'Jumlah pedoman pengawasan yang ditetapkan','Pedoman',NULL,NULL,NULL,NULL),('022.02',2012,'IKUSSIJ07.01',NULL,'Persentase pencapaian Program Kerja Pengawasan Tahunan','%',NULL,NULL,NULL,NULL),('022.02',2013,'IKUSSIJ07.01',NULL,'Persentase pencapaian Program Kerja Pengawasan Tahunan','%',NULL,NULL,NULL,NULL),('022.02',2012,'IKUSSIJ07.02',NULL,'Rasio persentase penyerapan anggaran terhadap persentase pencapaian program dan kegiatan','Rasio',NULL,NULL,NULL,NULL),('022.02',2013,'IKUSSIJ07.02',NULL,'Rasio persentase penyerapan anggaran terhadap persentase pencapaian program dan kegiatan','Rasio',NULL,NULL,NULL,NULL),('022.02',2012,'IKUSSIJ07.03',NULL,'Nilai AKIP Inspektorat Jenderal','Nilai',NULL,NULL,NULL,NULL),('022.02',2013,'IKUSSIJ07.03',NULL,'Nilai AKIP Inspektorat Jenderal','Nilai',NULL,NULL,NULL,NULL),('022.02',2012,'IKUSSIJ08.01',NULL,'Peningkatan persentase Auditor yang sesuai dengan standard Kompetensi','%',NULL,NULL,NULL,NULL),('022.02',2013,'IKUSSIJ08.01',NULL,'Peningkatan persentase Auditor yang sesuai dengan standard Kompetensi','%',NULL,NULL,NULL,NULL),('022.02',2012,'IKUSSIJ08.02',NULL,'Jumlah SDM Pengawasan yang mengikuti pelatihan dan pengembangan bidang pengawasan','Orang',NULL,NULL,NULL,NULL),('022.02',2013,'IKUSSIJ08.02',NULL,'Jumlah SDM Pengawasan yang mengikuti pelatihan dan pengembangan bidang pengawasan','Orang',NULL,NULL,NULL,NULL),('022.02',2012,'IKUSSIJ09.01',NULL,'Persentase proses bisnis yang telah memanfaatkan Teknologi Informasi dan Komunikasi','%',NULL,NULL,NULL,NULL),('022.02',2013,'IKUSSIJ09.01',NULL,'Persentase proses bisnis yang telah memanfaatkan Teknologi Informasi dan Komunikasi','%',NULL,NULL,NULL,NULL),('022.08',2012,'IKUSSKA01.01','IKUSSKP01.01','Jumlah kejadian kecelakaan kereta api khususnya kejadian anjlokan dan kejadian tabrakan antar kereta api','Kejadian/Tahun',NULL,NULL,NULL,NULL),('022.08',2013,'IKUSSKA01.01','IKUSSKP01.01','Jumlah kejadian kecelakaan kereta api khususnya kejadian anjlokan dan kejadian tabrakan antar kereta api','Kejadian/Tahun','0',NULL,'8;2013-05-30 14:32:58',NULL),('022.08',2012,'IKUSSKA02.01','IKUSSKP03.01','Persentase realisasi ketepatan waktu keberangkatan dan kedatangan kereta api (on-time performance)','%',NULL,NULL,NULL,NULL),('022.08',2013,'IKUSSKA02.01','IKUSSKP03.01','Persentase realisasi ketepatan waktu keberangkatan dan kedatangan kereta api (on-time performance)','%',NULL,NULL,NULL,NULL),('022.08',2012,'IKUSSKA02.02','IKUSSKP03.01','Rata-rata keterlambatan kereta api','Menit',NULL,NULL,NULL,NULL),('022.08',2013,'IKUSSKA02.02','IKUSSKP03.01','Rata-rata keterlambatan kereta api','Menit',NULL,NULL,NULL,NULL),('022.08',2012,'IKUSSKA03.01','IKUSSKP04.01','Jumlah sertifikat kelaikan sarana perkeretaapian yang dikeluarkan tepat waktu','Sertifikat',NULL,NULL,NULL,NULL),('022.08',2013,'IKUSSKA03.01','IKUSSKP04.01','Jumlah sertifikat kelaikan sarana perkeretaapian yang dikeluarkan tepat waktu','Sertifikat',NULL,NULL,NULL,NULL),('022.08',2012,'IKUSSKA03.02','IKUSSKP04.02','Jumlah sertifikat kelaikan prasarana perkeretaapian yang dikeluarkan tepat waktu','Sertifikat',NULL,NULL,NULL,NULL),('022.08',2013,'IKUSSKA03.02','IKUSSKP04.02','Jumlah sertifikat kelaikan prasarana perkeretaapian yang dikeluarkan tepat waktu','Sertifikat',NULL,NULL,NULL,NULL),('022.08',2012,'IKUSSKA04.01',NULL,'Jumlah lintas pelayanan (penambahan/perubahan rute)','Lintas',NULL,NULL,NULL,NULL),('022.08',2013,'IKUSSKA04.01',NULL,'Jumlah lintas pelayanan (penambahan/perubahan rute)','Lintas',NULL,NULL,NULL,NULL),('022.08',2012,'IKUSSKA04.02','IKUSSKP05.01','Jumlah lintas PSO dan perintis angkutan kereta api','Lintas',NULL,NULL,NULL,NULL),('022.08',2013,'IKUSSKA04.02','IKUSSKP05.01','Jumlah lintas PSO dan perintis angkutan kereta api','Lintas',NULL,NULL,NULL,NULL),('022.08',2012,'IKUSSKA04.03',NULL,'Panjang jalur KA yang dibangun (jalur baru maupun jalur ganda), direvitalisasi (reaktivasi lintas-lintas non-operasi maupun peningkatan daya dukung dan kecepatan)','KM',NULL,NULL,NULL,NULL),('022.08',2013,'IKUSSKA04.03',NULL,'Panjang jalur KA yang dibangun (jalur baru maupun jalur ganda), direvitalisasi (reaktivasi lintas-lintas non-operasi maupun peningkatan daya dukung dan kecepatan)','KM',NULL,NULL,NULL,NULL),('022.08',2012,'IKUSSKA05.01',NULL,'Persentase peningkatan kontribusi moda KA dalam angkutan barang sebagai indikator keberhasilan kebijakan modal-shifting ke kereta api','%',NULL,NULL,NULL,NULL),('022.08',2013,'IKUSSKA05.01',NULL,'Persentase peningkatan kontribusi moda KA dalam angkutan barang sebagai indikator keberhasilan kebijakan modal-shifting ke kereta api','%',NULL,NULL,NULL,NULL),('022.08',2012,'IKUSSKA05.02',NULL,'Persentase peningkatan kontribusi moda KA dalam angkutan penumpang sebagai indikator keberhasilan kebijakan modal-shifting ke kereta api','%',NULL,NULL,NULL,NULL),('022.08',2013,'IKUSSKA05.02',NULL,'Persentase peningkatan kontribusi moda KA dalam angkutan penumpang sebagai indikator keberhasilan kebijakan modal-shifting ke kereta api','%',NULL,NULL,NULL,NULL),('022.08',2012,'IKUSSKA06.01',NULL,'Jumlah sarana (pengadaan/modifikasi/ rehabilitasi)','Unit',NULL,NULL,NULL,NULL),('022.08',2013,'IKUSSKA06.01',NULL,'Jumlah sarana (pengadaan/modifikasi/ rehabilitasi)','Unit',NULL,NULL,NULL,NULL),('022.08',2012,'IKUSSKA06.02','IKUSSKP07.01','Jumlah penumpang KA yang dilayani','Orang',NULL,NULL,NULL,NULL),('022.08',2013,'IKUSSKA06.02','IKUSSKP07.01','Jumlah penumpang KA yang dilayani','Orang',NULL,NULL,NULL,NULL),('022.08',2012,'IKUSSKA06.03','IKUSSKP07.02','Jumlah angkutan barang yang dilayani oleh KA','Ton',NULL,NULL,NULL,NULL),('022.08',2013,'IKUSSKA06.03','IKUSSKP07.02','Jumlah angkutan barang yang dilayani oleh KA','Ton',NULL,NULL,NULL,NULL),('022.08',2012,'IKUSSKA07.01',NULL,'Jumlah perizinan: jumlah izin usaha, jumlah izin pembangunan, jumlah izin operasi sarana/prasarana dan jumlah rekomendasi/ persetujuan perizinan penyelenggaraan perkeretaapian','Perizinan',NULL,NULL,NULL,NULL),('022.08',2013,'IKUSSKA07.01',NULL,'Jumlah perizinan: jumlah izin usaha, jumlah izin pembangunan, jumlah izin operasi sarana/prasarana dan jumlah rekomendasi/ persetujuan perizinan penyelenggaraan perkeretaapian','Perizinan',NULL,NULL,NULL,NULL),('022.08',2012,'IKUSSKA08.01',NULL,'Nilai AKIP Direktorat Jenderal Perkeretaapian','Nilai','0',NULL,'8;2013-06-03 07:21:17',NULL),('022.08',2013,'IKUSSKA08.01',NULL,'Nilai AKIP Direktorat Jenderal Perkeretaapian','Nilai',NULL,NULL,NULL,NULL),('022.08',2012,'IKUSSKA08.02',NULL,'Tingkat penyerapan anggaran Direktorat Jenderal Perkeretaapian','%',NULL,NULL,NULL,NULL),('022.08',2013,'IKUSSKA08.02',NULL,'Tingkat penyerapan anggaran Direktorat Jenderal Perkeretaapian','%',NULL,NULL,NULL,NULL),('022.08',2012,'IKUSSKA08.03','IKUSSKP09.03','Nilai aset Direktorat Jenderal Perkeretaapian yang berhasil diinventarisasi','Rp. Trilliun',NULL,NULL,NULL,NULL),('022.08',2013,'IKUSSKA08.03','IKUSSKP09.03','Nilai aset Direktorat Jenderal Perkeretaapian yang berhasil diinventarisasi','Rp. Trilliun',NULL,NULL,NULL,NULL),('022.08',2012,'IKUSSKA09.01','IKUSSKP10.02','Jumlah sertifikat kecakapan SDM perkeretaapian','Sertifikat',NULL,NULL,NULL,NULL),('022.08',2013,'IKUSSKA09.01','IKUSSKP10.02','Jumlah sertifikat kecakapan SDM perkeretaapian','Sertifikat',NULL,NULL,NULL,NULL),('022.08',2012,'IKUSSKA10.01',NULL,'Jumlah peraturan perundang-undangan di bidang perkeretaapian yang diterbitkan','Peraturan',NULL,NULL,NULL,NULL),('022.08',2013,'IKUSSKA10.01',NULL,'Jumlah peraturan perundang-undangan di bidang perkeretaapian yang diterbitkan','Peraturan',NULL,NULL,NULL,NULL),('022.08',2012,'IKUSSKA11.01',NULL,'Panjang jalur kereta api yang sudah terelektifikasi','KM',NULL,NULL,NULL,NULL),('022.08',2013,'IKUSSKA11.01',NULL,'Panjang jalur kereta api yang sudah terelektifikasi','KM',NULL,NULL,NULL,NULL),('022.08',2012,'IKUSSKA11.02','IKUSSKP13.01','Jumlah penerapan teknologi yang efisien dan ramah lingkungan di bidang perkeretaapian ','Kegiatan',NULL,NULL,NULL,NULL),('022.08',2013,'IKUSSKA11.02','IKUSSKP13.01','Jumlah penerapan teknologi yang efisien dan ramah lingkungan di bidang perkeretaapian ','Kegiatan',NULL,NULL,NULL,NULL),('022.03',2012,'IKUSSPD01.01',NULL,'Jumlah konsumsi energi tak tergantikan oleh angkutan umum sub sektor transportasi darat','Juta Liter/Tahun',NULL,NULL,NULL,NULL),('022.03',2013,'IKUSSPD01.01',NULL,'Jumlah konsumsi energi tak tergantikan oleh angkutan umum sub sektor transportasi darat','Juta Liter/Tahun',NULL,NULL,NULL,NULL),('022.03',2012,'IKUSSPD01.02',NULL,'Jumlah produksi emisi gas buang dari sub sektor transportasi darat','Ton/Tahun',NULL,NULL,NULL,NULL),('022.03',2013,'IKUSSPD01.02',NULL,'Jumlah produksi emisi gas buang dari sub sektor transportasi darat','Ton/Tahun',NULL,NULL,NULL,NULL),('022.03',2012,'IKUSSPD02.01',NULL,'Persentase pertumbuhan transportasi darat terhadap PDRB (LLAJ)','%',NULL,NULL,NULL,NULL),('022.03',2013,'IKUSSPD02.01',NULL,'Persentase pertumbuhan transportasi darat terhadap PDRB (LLAJ)','%',NULL,NULL,NULL,NULL),('022.03',2012,'IKUSSPD02.02',NULL,'Persentase pertumbuhan transportasi darat terhadap PDRB (LLASDP)','%',NULL,NULL,NULL,NULL),('022.03',2013,'IKUSSPD02.02',NULL,'Persentase pertumbuhan transportasi darat terhadap PDRB (LLASDP)','%',NULL,NULL,NULL,NULL),('022.03',2012,'IKUSSPD03.01','IKUSSKP01.01','Kejadian kecelakaan lalu lintas jalan yang terkait dengan kewenangan Ditjen Hubdat','Kejadian',NULL,NULL,NULL,NULL),('022.03',2013,'IKUSSPD03.01','IKUSSKP01.01','Kejadian kecelakaan lalu lintas jalan yang terkait dengan kewenangan Ditjen Hubdat','Kejadian',NULL,NULL,NULL,NULL),('022.03',2012,'IKUSSPD03.02','IKUSSKP01.01','Kejadian kecelakaan SDP yang terkait dengan kewenangan Ditjen Hubdat','Kejadian',NULL,NULL,NULL,NULL),('022.03',2013,'IKUSSPD03.02','IKUSSKP01.01','Kejadian kecelakaan SDP yang terkait dengan kewenangan Ditjen Hubdat','Kejadian',NULL,NULL,NULL,NULL),('022.03',2012,'IKUSSPD04.01','IKUSSKP03.01','Persentase terpenuhinya frekuensi pelayanan pada lintas penyeberangan utama','%',NULL,NULL,NULL,NULL),('022.03',2013,'IKUSSPD04.01','IKUSSKP03.01','Persentase terpenuhinya frekuensi pelayanan pada lintas penyeberangan utama','%',NULL,NULL,NULL,NULL),('022.03',2012,'IKUSSPD04.02','IKUSSKP03.01','Persentase kinerja pelayanan AKAP','%',NULL,NULL,NULL,NULL),('022.03',2013,'IKUSSPD04.02','IKUSSKP03.01','Persentase kinerja pelayanan AKAP','%',NULL,NULL,NULL,NULL),('022.03',2012,'IKUSSPD05.01','IKUSSKP13.02','Jumlah lokasi yang memanfaatkan sarana transportasi darat berteknologi efisien dan ramah lingkungan','Lokasi',NULL,NULL,NULL,NULL),('022.03',2013,'IKUSSPD05.01','IKUSSKP13.02','Jumlah lokasi yang memanfaatkan sarana transportasi darat berteknologi efisien dan ramah lingkungan','Lokasi',NULL,NULL,NULL,NULL),('022.03',2012,'IKUSSPD05.02','IKUSSKP13.01','Jumlah prasarana transportasi jalan yang memanfaatkaan teknologi efisien dan ramah lingkungan di jalan nasional','Unit',NULL,NULL,NULL,NULL),('022.03',2013,'IKUSSPD05.02','IKUSSKP13.01','Jumlah prasarana transportasi jalan yang memanfaatkaan teknologi efisien dan ramah lingkungan di jalan nasional','Unit',NULL,NULL,NULL,NULL),('022.03',2012,'IKUSSPD05.03','IKUSSKP13.01','Jumlah pembangunan kenavigasian untuk angkutan sungai danau penyeberangan yang memanfaatkan teknologi ramah lingkungan','Unit',NULL,NULL,NULL,NULL),('022.03',2013,'IKUSSPD05.03','IKUSSKP13.01','Jumlah pembangunan kenavigasian untuk angkutan sungai danau penyeberangan yang memanfaatkan teknologi ramah lingkungan','Unit',NULL,NULL,NULL,NULL),('022.03',2012,'IKUSSPD05.04','IKUSSKP13.02','Jumlah Kota yang menerapkan ATCS dalam pelaksanaan Manajemen rekayasa Lalu Lintas','Kota',NULL,NULL,NULL,NULL),('022.03',2013,'IKUSSPD05.04','IKUSSKP13.02','Jumlah Kota yang menerapkan ATCS dalam pelaksanaan Manajemen rekayasa Lalu Lintas','Kota',NULL,NULL,NULL,NULL),('022.03',2012,'IKUSSPD05.05','IKUSSKP13.02','Jumlah kota yang memanfaatkan angkutan massal untuk pelayanan angkutan perkotaan','Kota',NULL,NULL,NULL,NULL),('022.03',2013,'IKUSSPD05.05','IKUSSKP13.02','Jumlah kota yang memanfaatkan angkutan massal untuk pelayanan angkutan perkotaan','Kota',NULL,NULL,NULL,NULL),('022.03',2012,'IKUSSPD06.01','IKUSSKP05.01','Jumlah trayek keperintisan angkutan jalan','Trayek',NULL,NULL,NULL,NULL),('022.03',2013,'IKUSSPD06.01','IKUSSKP05.01','Jumlah trayek keperintisan angkutan jalan','Trayek',NULL,NULL,NULL,NULL),('022.03',2012,'IKUSSPD06.02',NULL,'Jumlah trayek AKAP','Trayek',NULL,NULL,NULL,NULL),('022.03',2013,'IKUSSPD06.02',NULL,'Jumlah trayek AKAP','Trayek',NULL,NULL,NULL,NULL),('022.03',2012,'IKUSSPD06.03','IKUSSKP05.01','Jumlah lintas penyeberangan perintis','Lintas',NULL,NULL,NULL,NULL),('022.03',2013,'IKUSSPD06.03','IKUSSKP05.01','Jumlah lintas penyeberangan perintis','Lintas',NULL,NULL,NULL,NULL),('022.03',2012,'IKUSSPD06.04',NULL,'Jumlah lintas penyeberangan komersial','Lintas',NULL,NULL,NULL,NULL),('022.03',2013,'IKUSSPD06.04',NULL,'Jumlah lintas penyeberangan komersial','Lintas',NULL,NULL,NULL,NULL),('022.03',2012,'IKUSSPD07.01','IKUSSKP07.01','Jumlah produksi angkutan penyeberangan (penumpang)','Penumpang/Tahun',NULL,NULL,NULL,NULL),('022.03',2013,'IKUSSPD07.01','IKUSSKP07.01','Jumlah produksi angkutan penyeberangan (penumpang)','Penumpang/Tahun',NULL,NULL,NULL,NULL),('022.03',2012,'IKUSSPD07.02','IKUSSKP07.02','Jumlah produksi angkutan penyeberangan (kendaraan)','Kendaraan/Tahun',NULL,NULL,NULL,NULL),('022.03',2013,'IKUSSPD07.02','IKUSSKP07.02','Jumlah produksi angkutan penyeberangan (kendaraan)','Kendaraan/Tahun',NULL,NULL,NULL,NULL),('022.03',2012,'IKUSSPD07.03','IKUSSKP07.01','Jumlah penumpang angkutan umum pada pelayanan angkutan lebaran (penumpang)','Penumpang/Tahun',NULL,NULL,NULL,NULL),('022.03',2013,'IKUSSPD07.03','IKUSSKP07.01','Jumlah penumpang angkutan umum pada pelayanan angkutan lebaran (penumpang)','Penumpang/Tahun',NULL,NULL,NULL,NULL),('022.03',2012,'IKUSSPD07.04','IKUSSKP07.02','Jumlah penumpang angkutan umum pada pelayanan angkutan lebaran (kendaraan)','Kendaraan/Tahun',NULL,NULL,NULL,NULL),('022.03',2013,'IKUSSPD07.04','IKUSSKP07.02','Jumlah penumpang angkutan umum pada pelayanan angkutan lebaran (kendaraan)','Kendaraan/Tahun',NULL,NULL,NULL,NULL),('022.03',2012,'IKUSSPD07.05','IKUSSKP07.01','Jumlah penumpang angkutan umum pada pelayanan angkutan natal (penumpang)','Penumpang/Tahun',NULL,NULL,NULL,NULL),('022.03',2013,'IKUSSPD07.05','IKUSSKP07.01','Jumlah penumpang angkutan umum pada pelayanan angkutan natal (penumpang)','Penumpang/Tahun',NULL,NULL,NULL,NULL),('022.03',2012,'IKUSSPD07.06','IKUSSKP07.02','Jumlah penumpang angkutan umum pada pelayanan angkutan natal (kendaraan)','Kendaraan/Tahun',NULL,NULL,NULL,NULL),('022.03',2013,'IKUSSPD07.06','IKUSSKP07.02','Jumlah penumpang angkutan umum pada pelayanan angkutan natal (kendaraan)','Kendaraan/Tahun',NULL,NULL,NULL,NULL),('022.03',2012,'IKUSSPD07.07','IKUSSKP07.01','Jumlah kapasitas penumpang angkutan umum massal di perkotaan','Penumpang/Tahun',NULL,NULL,NULL,NULL),('022.03',2013,'IKUSSPD07.07','IKUSSKP07.01','Jumlah kapasitas penumpang angkutan umum massal di perkotaan','Penumpang/Tahun',NULL,NULL,NULL,NULL),('022.03',2012,'IKUSSPD08.01','IKUSSKP04.02','Persentase penyelenggaraan operasional prasarana LLAJ yang memenuhi SPM','%',NULL,NULL,NULL,NULL),('022.03',2013,'IKUSSPD08.01','IKUSSKP04.02','Persentase penyelenggaraan operasional prasarana LLAJ yang memenuhi SPM','%',NULL,NULL,NULL,NULL),('022.03',2012,'IKUSSPD08.02','IKUSSKP04.01','Persentase sarana pelayanan AKAP yang memenuhi SPM','%',NULL,NULL,NULL,NULL),('022.03',2013,'IKUSSPD08.02','IKUSSKP04.01','Persentase sarana pelayanan AKAP yang memenuhi SPM','%',NULL,NULL,NULL,NULL),('022.03',2012,'IKUSSPD08.03','IKUSSKP04.02','Persentase pemenuhan standar operasional pelabuhan penyeberangan','%',NULL,NULL,NULL,NULL),('022.03',2013,'IKUSSPD08.03','IKUSSKP04.02','Persentase pemenuhan standar operasional pelabuhan penyeberangan','%',NULL,NULL,NULL,NULL),('022.03',2012,'IKUSSPD08.04','IKUSSKP04.01','Persentase kapal penyeberangan yang memenuhi SPM','%',NULL,NULL,NULL,NULL),('022.03',2013,'IKUSSPD08.04','IKUSSKP04.01','Persentase kapal penyeberangan yang memenuhi SPM','%',NULL,NULL,NULL,NULL),('022.03',2012,'IKUSSPD09.01',NULL,'Nilai AKIP Ditjen Perhubungan Darat','Nilai',NULL,NULL,NULL,NULL),('022.03',2013,'IKUSSPD09.01',NULL,'Nilai AKIP Ditjen Perhubungan Darat','Nilai',NULL,NULL,NULL,NULL),('022.03',2012,'IKUSSPD09.02',NULL,'Tingkat penyerapan anggaran Ditjen Perhubungan Darat','%',NULL,NULL,NULL,NULL),('022.03',2013,'IKUSSPD09.02',NULL,'Tingkat penyerapan anggaran Ditjen Perhubungan Darat','%',NULL,NULL,NULL,NULL),('022.03',2012,'IKUSSPD09.03','IKUSSKP09.03','Nilai aset Direktorat Jenderal Perhubungan Darat yang berhasil diinventarisasi','Rp.',NULL,NULL,NULL,NULL),('022.03',2013,'IKUSSPD09.03','IKUSSKP09.03','Nilai aset Direktorat Jenderal Perhubungan Darat yang berhasil diinventarisasi','Rp.',NULL,NULL,NULL,NULL),('022.03',2012,'IKUSSPD10.01','IKUSSKP10.02','Jumlah pemberian sertifikat dan kualifikasi teknis petugas operasional','Sertifikat',NULL,NULL,NULL,NULL),('022.03',2013,'IKUSSPD10.01','IKUSSKP10.02','Jumlah pemberian sertifikat dan kualifikasi teknis petugas operasional','Sertifikat',NULL,NULL,NULL,NULL),('022.03',2012,'IKUSSPD10.02','IKUSSKP10.02','Jumlah pegawai yang sudah memiliki sertifikat','Orang',NULL,NULL,NULL,NULL),('022.03',2013,'IKUSSPD10.02','IKUSSKP10.02','Jumlah pegawai yang sudah memiliki sertifikat','Orang',NULL,NULL,NULL,NULL),('022.03',2012,'IKUSSPD11.01','IKUSSKP08.01','Jumlah kerjasama dengan Pemda/swasta di sub sektor transportasi darat','Kerjasama',NULL,NULL,NULL,NULL),('022.03',2013,'IKUSSPD11.01','IKUSSKP08.01','Jumlah kerjasama dengan Pemda/swasta di sub sektor transportasi darat','Kerjasama',NULL,NULL,NULL,NULL),('022.03',2012,'IKUSSPD12.01',NULL,'Jumlah tersusunnya peraturan perundang-undangan dan peraturan pelaksanaannya','Peraturan',NULL,NULL,NULL,NULL),('022.03',2013,'IKUSSPD12.01',NULL,'Jumlah tersusunnya peraturan perundang-undangan dan peraturan pelaksanaannya','Peraturan',NULL,NULL,NULL,NULL),('022.04',2012,'IKUSSPL01.01','IKUSSKP01.01','Jumlah kejadian kecelakaan yang disebabkan oleh manusia','Kejadian Kecelakaan',NULL,NULL,NULL,NULL),('022.04',2013,'IKUSSPL01.01','IKUSSKP01.01','Jumlah kejadian kecelakaan yang disebabkan oleh manusia','Kejadian Kecelakaan',NULL,NULL,NULL,NULL),('022.04',2012,'IKUSSPL01.02','IKUSSKP01.01','Jumlah kejadian kecelakaan yang disebabkan oleh teknis dan lain-lain','Kejadian Kecelakaan',NULL,NULL,NULL,NULL),('022.04',2013,'IKUSSPL01.02','IKUSSKP01.01','Jumlah kejadian kecelakaan yang disebabkan oleh teknis dan lain-lain','Kejadian Kecelakaan',NULL,NULL,NULL,NULL),('022.04',2012,'IKUSSPL02.01','IKUSSKP04.01','Jumlah kapal yang memiliki sertifikat kelaiklautan kapal','Sertifikat',NULL,NULL,NULL,NULL),('022.04',2013,'IKUSSPL02.01','IKUSSKP04.01','Jumlah kapal yang memiliki sertifikat kelaiklautan kapal','Sertifikat',NULL,NULL,NULL,NULL),('022.04',2012,'IKUSSPL03.01','IKUSSKP05.01','Jumlah rute perintis yang dilayani transportasi laut','Rute Perintis',NULL,NULL,NULL,NULL),('022.04',2013,'IKUSSPL03.01','IKUSSKP05.01','Jumlah rute perintis yang dilayani transportasi laut','Rute Perintis',NULL,NULL,NULL,NULL),('022.04',2012,'IKUSSPL03.02',NULL,'Jumlah pelabuhan yang dapat menghubungkan daerah-daerah terpencil, terluar, daerah perbatasan, daerah belum berkembang dan daerah telah berkembang','Pelabuhan',NULL,NULL,NULL,NULL),('022.04',2013,'IKUSSPL03.02',NULL,'Jumlah pelabuhan yang dapat menghubungkan daerah-daerah terpencil, terluar, daerah perbatasan, daerah belum berkembang dan daerah telah berkembang','Pelabuhan',NULL,NULL,NULL,NULL),('022.04',2012,'IKUSSPL04.01','IKUSSKP07.01','Jumlah penumpang transportasi laut yang terangkut','Orang',NULL,NULL,NULL,NULL),('022.04',2013,'IKUSSPL04.01','IKUSSKP07.01','Jumlah penumpang transportasi laut yang terangkut','Orang',NULL,NULL,NULL,NULL),('022.04',2012,'IKUSSPL04.02','IKUSSKP07.01','Jumlah penumpang angkutan laut perintis','Orang',NULL,NULL,NULL,NULL),('022.04',2013,'IKUSSPL04.02','IKUSSKP07.01','Jumlah penumpang angkutan laut perintis','Orang',NULL,NULL,NULL,NULL),('022.04',2012,'IKUSSPL04.03','IKUSSKP07.02','Jumlah muatan angkutan laut dalam negeri yang diangkut oleh kapal nasional','Ton',NULL,NULL,NULL,NULL),('022.04',2013,'IKUSSPL04.03','IKUSSKP07.02','Jumlah muatan angkutan laut dalam negeri yang diangkut oleh kapal nasional','Ton',NULL,NULL,NULL,NULL),('022.04',2012,'IKUSSPL04.04',NULL,'Persentase pangsa muatan angkutan laut dalam negeri yang diangkut oleh kapal nasional','%',NULL,NULL,NULL,NULL),('022.04',2013,'IKUSSPL04.04',NULL,'Persentase pangsa muatan angkutan laut dalam negeri yang diangkut oleh kapal nasional','%',NULL,NULL,NULL,NULL),('022.04',2012,'IKUSSPL04.05','IKUSSKP07.02','Jumlah muatan angkutan laut luar negeri yang diangkut oleh kapal nasional','Ton',NULL,NULL,NULL,NULL),('022.04',2013,'IKUSSPL04.05','IKUSSKP07.02','Jumlah muatan angkutan laut luar negeri yang diangkut oleh kapal nasional','Ton',NULL,NULL,NULL,NULL),('022.04',2012,'IKUSSPL04.06',NULL,'Persentase pangsa muatan angkutan laut luar negeri yang diangkut oleh kapal nasional','%',NULL,NULL,NULL,NULL),('022.04',2013,'IKUSSPL04.06',NULL,'Persentase pangsa muatan angkutan laut luar negeri yang diangkut oleh kapal nasional','%',NULL,NULL,NULL,NULL),('022.04',2012,'IKUSSPL05.01',NULL,'Penurunan Turn-Around Time (TRT) di pelabuhan yang diusahakan','Menit',NULL,NULL,NULL,NULL),('022.04',2013,'IKUSSPL05.01',NULL,'Penurunan Turn-Around Time (TRT) di pelabuhan yang diusahakan','Menit',NULL,NULL,NULL,NULL),('022.04',2012,'IKUSSPL06.01','IKUSSKP03.01','Jumlah pelabuhan mempunyai pencapaian Waiting Time (WT) sesuai SK Dirjen yang belaku terkait Standar Kinerja Pelayanan Operasional Pelabuhan','Pelabuhan',NULL,NULL,NULL,NULL),('022.04',2013,'IKUSSPL06.01','IKUSSKP03.01','Jumlah pelabuhan mempunyai pencapaian Waiting Time (WT) sesuai SK Dirjen yang belaku terkait Standar Kinerja Pelayanan Operasional Pelabuhan','Pelabuhan',NULL,NULL,NULL,NULL),('022.04',2012,'IKUSSPL06.02','IKUSSKP03.01','Jumlah pelabuhan mempunyai pencapaian approach time (AT) sesuai SK Dirjen yang berlaku terkait Standar Kinerja Pelayanan Operasional Pelabuhan','Pelabuhan',NULL,NULL,NULL,NULL),('022.04',2013,'IKUSSPL06.02','IKUSSKP03.01','Jumlah pelabuhan mempunyai pencapaian approach time (AT) sesuai SK Dirjen yang berlaku terkait Standar Kinerja Pelayanan Operasional Pelabuhan','Pelabuhan',NULL,NULL,NULL,NULL),('022.04',2012,'IKUSSPL06.03','IKUSSKP03.01','Jumlah pelabuhan mempunyai pencapaian Waktu Efektif (Effective Time/ET) sesuai SK Dirjen yang berlaku terkait Standar Kinerja Pelayanan Operasional Pelabuhan','Pelabuhan',NULL,NULL,NULL,NULL),('022.04',2013,'IKUSSPL06.03','IKUSSKP03.01','Jumlah pelabuhan mempunyai pencapaian Waktu Efektif (Effective Time/ET) sesuai SK Dirjen yang berlaku terkait Standar Kinerja Pelayanan Operasional Pelabuhan','Pelabuhan',NULL,NULL,NULL,NULL),('022.04',2012,'IKUSSPL07.01','IKUSSKP08.01','Jumlah MOU, perizinan, konstruksi, dan operasional kerjasama pemerintah dengan Pemda dan Swasta di bidang transportasi laut','Dokumen',NULL,NULL,NULL,NULL),('022.04',2013,'IKUSSPL07.01','IKUSSKP08.01','Jumlah MOU, perizinan, konstruksi, dan operasional kerjasama pemerintah dengan Pemda dan Swasta di bidang transportasi laut','Dokumen',NULL,NULL,NULL,NULL),('022.04',2012,'IKUSSPL08.01','IKUSSKP10.02','Jumlah kebutuhan tenaga Marine Inspector A','Orang',NULL,NULL,NULL,NULL),('022.04',2013,'IKUSSPL08.01','IKUSSKP10.02','Jumlah kebutuhan tenaga Marine Inspector A','Orang',NULL,NULL,NULL,NULL),('022.04',2012,'IKUSSPL08.02','IKUSSKP10.02','Jumlah kebutuhan tenaga Marine Inspector B','Orang',NULL,NULL,NULL,NULL),('022.04',2013,'IKUSSPL08.02','IKUSSKP10.02','Jumlah kebutuhan tenaga Marine Inspector B','Orang',NULL,NULL,NULL,NULL),('022.04',2012,'IKUSSPL08.03','IKUSSKP10.02','Jumlah kebutuhan tenaga PPNS','Orang',NULL,NULL,NULL,NULL),('022.04',2013,'IKUSSPL08.03','IKUSSKP10.02','Jumlah kebutuhan tenaga PPNS','Orang',NULL,NULL,NULL,NULL),('022.04',2012,'IKUSSPL08.04','IKUSSKP10.02','Jumlah tenaga PPNS','Orang',NULL,NULL,NULL,NULL),('022.04',2013,'IKUSSPL08.04','IKUSSKP10.02','Jumlah tenaga PPNS','Orang',NULL,NULL,NULL,NULL),('022.04',2012,'IKUSSPL08.05','IKUSSKP10.02','Jumlah kebutuhan tenaga kesyahbandaran kelas A','Orang',NULL,NULL,NULL,NULL),('022.04',2013,'IKUSSPL08.05','IKUSSKP10.02','Jumlah kebutuhan tenaga kesyahbandaran kelas A','Orang',NULL,NULL,NULL,NULL),('022.04',2012,'IKUSSPL08.06','IKUSSKP10.02','Jumlah kebutuhan tenaga kesyahbandaran kelas B','Orang',NULL,NULL,NULL,NULL),('022.04',2013,'IKUSSPL08.06','IKUSSKP10.02','Jumlah kebutuhan tenaga kesyahbandaran kelas B','Orang',NULL,NULL,NULL,NULL),('022.04',2012,'IKUSSPL08.07','IKUSSKP10.02','Jumlah kebutuhan tenaga penanggulangan pencemaran','Orang',NULL,NULL,NULL,NULL),('022.04',2013,'IKUSSPL08.07','IKUSSKP10.02','Jumlah kebutuhan tenaga penanggulangan pencemaran','Orang',NULL,NULL,NULL,NULL),('022.04',2012,'IKUSSPL08.08','IKUSSKP10.02','Jumlah kebutuhan tenaga penanggulangan kebakaran','Orang',NULL,NULL,NULL,NULL),('022.04',2013,'IKUSSPL08.08','IKUSSKP10.02','Jumlah kebutuhan tenaga penanggulangan kebakaran','Orang',NULL,NULL,NULL,NULL),('022.04',2012,'IKUSSPL08.09','IKUSSKP10.02','Jumlah kebutuhan tenaga penyelam','Orang',NULL,NULL,NULL,NULL),('022.04',2013,'IKUSSPL08.09','IKUSSKP10.02','Jumlah kebutuhan tenaga penyelam','Orang',NULL,NULL,NULL,NULL),('022.04',2012,'IKUSSPL09.01',NULL,'Nilai AKIP Direktorat Jenderal Perhubungan Laut','Nilai',NULL,NULL,NULL,NULL),('022.04',2013,'IKUSSPL09.01',NULL,'Nilai AKIP Direktorat Jenderal Perhubungan Laut','Nilai',NULL,NULL,NULL,NULL),('022.04',2012,'IKUSSPL09.02',NULL,'Jumlah realisasi pendapatan Direktorat Jenderal Perhubungan Laut','Rp.',NULL,NULL,NULL,NULL),('022.04',2013,'IKUSSPL09.02',NULL,'Jumlah realisasi pendapatan Direktorat Jenderal Perhubungan Laut','Rp.',NULL,NULL,NULL,NULL),('022.04',2012,'IKUSSPL09.03',NULL,'Jumlah realisasi belanja anggaran Direktorat Jenderal Perhubungan Laut','Rp.',NULL,NULL,NULL,NULL),('022.04',2013,'IKUSSPL09.03',NULL,'Jumlah realisasi belanja anggaran Direktorat Jenderal Perhubungan Laut','Rp.',NULL,NULL,NULL,NULL),('022.04',2012,'IKUSSPL09.04','IKUSSKP09.03','Nilai BMN pada neraca Direktorat Jenderal Perhubungan Laut','Rp.',NULL,NULL,NULL,NULL),('022.04',2013,'IKUSSPL09.04','IKUSSKP09.03','Nilai BMN pada neraca Direktorat Jenderal Perhubungan Laut','Rp.',NULL,NULL,NULL,NULL),('022.04',2012,'IKUSSPL10.01',NULL,'Jumlah penyelesaian regulasi','Regulasi',NULL,NULL,NULL,NULL),('022.04',2013,'IKUSSPL10.01',NULL,'Jumlah penyelesaian regulasi','Regulasi',NULL,NULL,NULL,NULL),('022.04',2012,'IKUSSPL11.01','IKUSSKP12.02','Jumlah penurunan emisi gas buang (CO2) transportasi laut','Mega Ton',NULL,NULL,NULL,NULL),('022.04',2013,'IKUSSPL11.01','IKUSSKP12.02','Jumlah penurunan emisi gas buang (CO2) transportasi laut','Mega Ton',NULL,NULL,NULL,NULL),('022.04',2012,'IKUSSPL12.01','IKUSSKP13.02','Jumlah pelabuhan yang menerapkan Eco-Port (penanganan sampah dan kebersihan lingkungan pelabuhan)','Pelabuhan',NULL,NULL,NULL,NULL),('022.04',2013,'IKUSSPL12.01','IKUSSKP13.02','Jumlah pelabuhan yang menerapkan Eco-Port (penanganan sampah dan kebersihan lingkungan pelabuhan)','Pelabuhan',NULL,NULL,NULL,NULL),('022.04',2012,'IKUSSPL12.02','IKUSSKP13.01','Jumlah pemilikan sertifikat IOPP (International Oil Polution Prevention)','Sertifikat',NULL,NULL,NULL,NULL),('022.04',2013,'IKUSSPL12.02','IKUSSKP13.01','Jumlah pemilikan sertifikat IOPP (International Oil Polution Prevention)','Sertifikat',NULL,NULL,NULL,NULL),('022.04',2012,'IKUSSPL12.03','IKUSSKP13.01','Jumlah pemilikan SNPP (Sertifikat Nasional Pencegahan Pencemaran)','Sertifikat',NULL,NULL,NULL,NULL),('022.04',2013,'IKUSSPL12.03','IKUSSKP13.01','Jumlah pemilikan SNPP (Sertifikat Nasional Pencegahan Pencemaran)','Sertifikat',NULL,NULL,NULL,NULL),('022.04',2012,'IKUSSPL12.04','IKUSSKP13.01','Jumlah pemilikan sertifikat bahan cair beracun (Noxius Liquid Substance)','Sertifikat',NULL,NULL,NULL,NULL),('022.04',2013,'IKUSSPL12.04','IKUSSKP13.01','Jumlah pemilikan sertifikat bahan cair beracun (Noxius Liquid Substance)','Sertifikat',NULL,NULL,NULL,NULL),('022.04',2012,'IKUSSPL12.05','IKUSSKP13.01','Jumlah pemilikan sertifikat ISPP (International Sewage Pollution Prevention)','Sertifikat',NULL,NULL,NULL,NULL),('022.04',2013,'IKUSSPL12.05','IKUSSKP13.01','Jumlah pemilikan sertifikat ISPP (International Sewage Pollution Prevention)','Sertifikat',NULL,NULL,NULL,NULL),('022.11',2012,'IKUSSPP01.01',NULL,'Jumlah penelitian yang dijadikan bahan masukan/rekomendasi kebijakan bidang perhubungan','Penelitian',NULL,NULL,NULL,NULL),('022.11',2013,'IKUSSPP01.01',NULL,'Jumlah penelitian yang dijadikan bahan masukan/rekomendasi kebijakan bidang perhubungan','Penelitian',NULL,NULL,NULL,NULL),('022.11',2012,'IKUSSPP01.02',NULL,'Jumlah penelitian yang dipublikasikan pada jurnal atau buletin yang terakreditasi','Penelitian',NULL,NULL,NULL,NULL),('022.11',2013,'IKUSSPP01.02',NULL,'Jumlah penelitian yang dipublikasikan pada jurnal atau buletin yang terakreditasi','Penelitian',NULL,NULL,NULL,NULL),('022.11',2012,'IKUSSPP02.01',NULL,'Jumlah kajian per peneliti','Kajian',NULL,NULL,NULL,NULL),('022.11',2013,'IKUSSPP02.01',NULL,'Jumlah kajian per peneliti','Kajian',NULL,NULL,NULL,NULL),('022.05',2012,'IKUSSPU01.01','IKUSSKP01.01','Rasio kecelakaan transportasi udara pada AOC 121 dan AOC 135 dengan korban jiwa dan pesawat rusak berat','Kejadian/1 Juta Flight Cycle',NULL,NULL,NULL,NULL),('022.05',2013,'IKUSSPU01.01','IKUSSKP01.01','Rasio kecelakaan transportasi udara pada AOC 121 dan AOC 135 dengan korban jiwa dan pesawat rusak berat','Kejadian/1 Juta Flight Cycle',NULL,NULL,NULL,NULL),('022.05',2012,'IKUSSPU01.02','IKUSSKP01.01','Jumlah Airtraffic Incident dengan rasio 4:100.000 pergerakan','Insiden/1 Juta Pergerakan',NULL,NULL,NULL,NULL),('022.05',2013,'IKUSSPU01.02','IKUSSKP01.01','Jumlah Airtraffic Incident dengan rasio 4:100.000 pergerakan','Insiden/1 Juta Pergerakan',NULL,NULL,NULL,NULL),('022.05',2012,'IKUSSPU02.01','IKUSSKP02.01','Jumlah lolosnya barang-barang terlarang (prohibited item) yang terdiri dari security item, dangerous goods, dangerous artical, dan ancaman bom serta penyusupan orang/hewan ke bandar udara','Kejadian/Gangguan',NULL,NULL,NULL,NULL),('022.05',2013,'IKUSSPU02.01','IKUSSKP02.01','Jumlah lolosnya barang-barang terlarang (prohibited item) yang terdiri dari security item, dangerous goods, dangerous artical, dan ancaman bom serta penyusupan orang/hewan ke bandar udara','Kejadian/Gangguan',NULL,NULL,NULL,NULL),('022.05',2012,'IKUSSPU03.01','IKUSSKP03.01','Persentase pencapaian On Time Performance (OTP)','%',NULL,NULL,NULL,NULL),('022.05',2013,'IKUSSPU03.01','IKUSSKP03.01','Persentase pencapaian On Time Performance (OTP)','%',NULL,NULL,NULL,NULL),('022.05',2012,'IKUSSPU04.01','IKUSSKP05.01','Jumlah rute pelayanan perintis','Rute',NULL,NULL,NULL,NULL),('022.05',2013,'IKUSSPU04.01','IKUSSKP05.01','Jumlah rute pelayanan perintis','Rute',NULL,NULL,NULL,NULL),('022.05',2012,'IKUSSPU04.02',NULL,'Jumlah penumpang perintis yang diangkut','Orang/Tahun',NULL,NULL,NULL,NULL),('022.05',2013,'IKUSSPU04.02',NULL,'Jumlah penumpang perintis yang diangkut','Orang/Tahun',NULL,NULL,NULL,NULL),('022.05',2012,'IKUSSPU04.03',NULL,'Jumlah kota/daerah yang terhubungi','Kota/Daerah',NULL,NULL,NULL,NULL),('022.05',2013,'IKUSSPU04.03',NULL,'Jumlah kota/daerah yang terhubungi','Kota/Daerah',NULL,NULL,NULL,NULL),('022.05',2012,'IKUSSPU05.01',NULL,'Jumlah bandar udara dengan kapasitas sesuai kebutuhan jaringan dan kategori','Bandara',NULL,NULL,NULL,NULL),('022.05',2013,'IKUSSPU05.01',NULL,'Jumlah bandar udara dengan kapasitas sesuai kebutuhan jaringan dan kategori','Bandara',NULL,NULL,NULL,NULL),('022.05',2012,'IKUSSPU05.02','IKUSSKP07.01','Jumlah penumpang yang diangkut','Orang/Tahun',NULL,NULL,NULL,NULL),('022.05',2013,'IKUSSPU05.02','IKUSSKP07.01','Jumlah penumpang yang diangkut','Orang/Tahun',NULL,NULL,NULL,NULL),('022.05',2012,'IKUSSPU05.03','IKUSSKP07.02','Jumlah kargo yang diangkut','Ton/Tahun',NULL,NULL,NULL,NULL),('022.05',2013,'IKUSSPU05.03','IKUSSKP07.02','Jumlah kargo yang diangkut','Ton/Tahun',NULL,NULL,NULL,NULL),('022.05',2012,'IKUSSPU06.01','IKUSSKP04.01','Jumlah pesawat udara yang memiliki sertifikat kelaikudaraan','Sertifikat',NULL,NULL,NULL,NULL),('022.05',2013,'IKUSSPU06.01','IKUSSKP04.01','Jumlah pesawat udara yang memiliki sertifikat kelaikudaraan','Sertifikat',NULL,NULL,NULL,NULL),('022.05',2012,'IKUSSPU06.02','IKUSSKP04.02','Jumlah bandar udara yang memiliki sertifikat','Sertifikat',NULL,NULL,NULL,NULL),('022.05',2013,'IKUSSPU06.02','IKUSSKP04.02','Jumlah bandar udara yang memiliki sertifikat','Sertifikat',NULL,NULL,NULL,NULL),('022.05',2012,'IKUSSPU07.01','IKUSSKP10.02','Jumlah Inspektur Penerbangan','Orang',NULL,NULL,NULL,NULL),('022.05',2013,'IKUSSPU07.01','IKUSSKP10.02','Jumlah Inspektur Penerbangan','Orang',NULL,NULL,NULL,NULL),('022.05',2012,'IKUSSPU07.02','IKUSSKP10.01','Jumlah personil penerbangan yang memiliki lisensi','Orang',NULL,NULL,NULL,NULL),('022.05',2013,'IKUSSPU07.02','IKUSSKP10.01','Jumlah personil penerbangan yang memiliki lisensi','Orang',NULL,NULL,NULL,NULL),('022.05',2012,'IKUSSPU08.01','IKUSSKP08.01','Jumlah kerjasama pemerintah dengan swasta dan/atau Pemerintah Daerah di bidang transportasi udara','Kerjasama',NULL,NULL,NULL,NULL),('022.05',2013,'IKUSSPU08.01','IKUSSKP08.01','Jumlah kerjasama pemerintah dengan swasta dan/atau Pemerintah Daerah di bidang transportasi udara','Kerjasama',NULL,NULL,NULL,NULL),('022.05',2012,'IKUSSPU09.01',NULL,'Jumlah peraturan yang diterbitkan di bidang transportasi udara','Peraturan',NULL,NULL,NULL,NULL),('022.05',2013,'IKUSSPU09.01',NULL,'Jumlah peraturan yang diterbitkan di bidang transportasi udara','Peraturan',NULL,NULL,NULL,NULL),('022.05',2012,'IKUSSPU10.01',NULL,'Nilai AKIP Direktorat Jenderal Perhubungan Udara','Nilai',NULL,NULL,NULL,NULL),('022.05',2013,'IKUSSPU10.01',NULL,'Nilai AKIP Direktorat Jenderal Perhubungan Udara','Nilai',NULL,NULL,NULL,NULL),('022.05',2012,'IKUSSPU10.02',NULL,'Tingkat penyerapan anggaran Direktorat Jenderal Perhubungan Udara','%',NULL,NULL,NULL,NULL),('022.05',2013,'IKUSSPU10.02',NULL,'Tingkat penyerapan anggaran Direktorat Jenderal Perhubungan Udara','%',NULL,NULL,NULL,NULL),('022.05',2012,'IKUSSPU10.03','IKUSSKP09.03','Nilai aset Direktorat Jenderal Perhubungan Udara yang berhasil diinventarisasi','Rp.',NULL,NULL,NULL,NULL),('022.05',2013,'IKUSSPU10.03','IKUSSKP09.03','Nilai aset Direktorat Jenderal Perhubungan Udara yang berhasil diinventarisasi','Rp.',NULL,NULL,NULL,NULL),('022.05',2012,'IKUSSPU11.01','IKUSSKP13.02','Persentase bandara yang memenuhi eco airport (AMDAL)','Bandara',NULL,NULL,NULL,NULL),('022.05',2013,'IKUSSPU11.01','IKUSSKP13.02','Persentase bandara yang memenuhi eco airport (AMDAL)','Bandara',NULL,NULL,NULL,NULL),('022.05',2012,'IKUSSPU12.01','IKUSSKP12.01','Jumlah konsumsi energi dari sumber tak terbarukan untuk transportasi udara','Kilo Liter/Tahun',NULL,NULL,NULL,NULL),('022.05',2013,'IKUSSPU12.01','IKUSSKP12.01','Jumlah konsumsi energi dari sumber tak terbarukan untuk transportasi udara','Kilo Liter/Tahun',NULL,NULL,NULL,NULL),('022.05',2012,'IKUSSPU12.02','IKUSSKP12.02','Penurunan emisi gas buang CO2 dengan kegiatan peremajaan armada angkutan udara','Juta Ton CO2 ',NULL,NULL,NULL,NULL),('022.05',2013,'IKUSSPU12.02','IKUSSKP12.02','Penurunan emisi gas buang CO2 dengan kegiatan peremajaan armada angkutan udara','Juta Ton CO2 ',NULL,NULL,NULL,NULL),('022.12',2012,'IKUSSSDM01.01',NULL,'Jumlah peserta diklat Transportasi Darat, Laut, Udara, Perkeretaapian dan Aparatur Perhubungan pertahun sesuai standar diklat BPSDM Perhubungan','Orang',NULL,NULL,NULL,NULL),('022.12',2013,'IKUSSSDM01.01',NULL,'Jumlah peserta diklat Transportasi Darat, Laut, Udara, Perkeretaapian dan Aparatur Perhubungan pertahun sesuai standar diklat BPSDM Perhubungan','Orang',NULL,NULL,NULL,NULL),('022.12',2012,'IKUSSSDM02.01','IKUSSKP10.03','Jumlah lulusan Diklat Transportasi Darat, Laut, Udara, Perkeretaapian dan Aparatur Perhubungan yang prima, profesional dan beretika yang dihasilkan BPSDM Perhubungan setiap tahun yang sesuai standar kompetensi/kelulusan','Orang',NULL,NULL,NULL,NULL),('022.12',2013,'IKUSSSDM02.01','IKUSSKP10.03','Jumlah lulusan Diklat Transportasi Darat, Laut, Udara, Perkeretaapian dan Aparatur Perhubungan yang prima, profesional dan beretika yang dihasilkan BPSDM Perhubungan setiap tahun yang sesuai standar kompetensi/kelulusan','Orang',NULL,NULL,NULL,NULL),('022.12',2012,'IKUSSSDM03.01',NULL,'Jumlah dokumen metode penyelenggaraan Diklat Transportasi Darat, Laut, Udara, Perkeretaapian dan Aparatur Perhubungan yang berbasis teknologi informasi','Dokumen',NULL,NULL,NULL,NULL),('022.12',2013,'IKUSSSDM03.01',NULL,'Jumlah dokumen metode penyelenggaraan Diklat Transportasi Darat, Laut, Udara, Perkeretaapian dan Aparatur Perhubungan yang berbasis teknologi informasi','Dokumen',NULL,NULL,NULL,NULL),('022.12',2012,'IKUSSSDM03.02',NULL,'Jumlah sistem informasi yang dibangun','Sistem',NULL,NULL,NULL,NULL),('022.12',2013,'IKUSSSDM03.02',NULL,'Jumlah sistem informasi yang dibangun','Sistem',NULL,NULL,NULL,NULL),('022.12',2012,'IKUSSSDM04.01',NULL,'Jumlah kurikulum Diklat Transportasi Darat, Laut, Udara, Perkeretaapian dan Aparatur Perhubungan yang berbasis kompetensi','Dokumen',NULL,NULL,NULL,NULL),('022.12',2013,'IKUSSSDM04.01',NULL,'Jumlah kurikulum Diklat Transportasi Darat, Laut, Udara, Perkeretaapian dan Aparatur Perhubungan yang berbasis kompetensi','Dokumen',NULL,NULL,NULL,NULL),('022.12',2012,'IKUSSSDM04.02',NULL,'Jumlah silabi Diklat Transportasi Darat, Laut, Udara, Perkeretaapian dan Aparatur Perhubungan yang berbasis kompetensi','Dokumen',NULL,NULL,NULL,NULL),('022.12',2013,'IKUSSSDM04.02',NULL,'Jumlah silabi Diklat Transportasi Darat, Laut, Udara, Perkeretaapian dan Aparatur Perhubungan yang berbasis kompetensi','Dokumen',NULL,NULL,NULL,NULL),('022.12',2012,'IKUSSSDM04.03',NULL,'Jumlah modul/bahan ajar diklat Transportasi Darat, Laut, Udara, Perkeretaapian dan Aparatur Perhubungan yang berbasis kompetensi ','Dokumen',NULL,NULL,NULL,NULL),('022.12',2013,'IKUSSSDM04.03',NULL,'Jumlah modul/bahan ajar diklat Transportasi Darat, Laut, Udara, Perkeretaapian dan Aparatur Perhubungan yang berbasis kompetensi ','Dokumen',NULL,NULL,NULL,NULL),('022.12',2012,'IKUSSSDM05.01',NULL,'Jumlah lembaga diklat Transportasi Darat, Laut, Udara dan Perkeretaapian yang menjadi Badan Layanan Umum (BLU)','Lembaga',NULL,NULL,NULL,NULL),('022.12',2013,'IKUSSSDM05.01',NULL,'Jumlah lembaga diklat Transportasi Darat, Laut, Udara dan Perkeretaapian yang menjadi Badan Layanan Umum (BLU)','Lembaga',NULL,NULL,NULL,NULL),('022.12',2012,'IKUSSSDM06.01','IKUSSKP08.01','Jumlah dokumen kerjasama dengan lembaga pemerintah/swasta nasional atau asing di Bidang Diklat Transportasi','Dokumen',NULL,NULL,NULL,NULL),('022.12',2013,'IKUSSSDM06.01','IKUSSKP08.01','Jumlah dokumen kerjasama dengan lembaga pemerintah/swasta nasional atau asing di Bidang Diklat Transportasi','Dokumen',NULL,NULL,NULL,NULL),('022.12',2012,'IKUSSSDM07.01',NULL,'Nilai AKIP BPSDM Perhubungan','Nilai',NULL,NULL,NULL,NULL),('022.12',2013,'IKUSSSDM07.01',NULL,'Nilai AKIP BPSDM Perhubungan','Nilai',NULL,NULL,NULL,NULL),('022.12',2012,'IKUSSSDM07.02',NULL,'Tingkat Penyerapan Anggaran BPSDM Perhubungan','%',NULL,NULL,NULL,NULL),('022.12',2013,'IKUSSSDM07.02',NULL,'Tingkat Penyerapan Anggaran BPSDM Perhubungan','%',NULL,NULL,NULL,NULL),('022.12',2012,'IKUSSSDM07.03','IKUSSKP09.03','Nilai aset BPSDM Perhubungan yang berhasil diinventasisasi','Rp .',NULL,NULL,NULL,NULL),('022.12',2013,'IKUSSSDM07.03','IKUSSKP09.03','Nilai aset BPSDM Perhubungan yang berhasil diinventasisasi','Rp ',NULL,NULL,NULL,NULL),('022.12',2012,'IKUSSSDM08.01',NULL,'Jumlah draft peraturan perundangan dan ketentuan pelaksanaan lainnya yang dihasilkan di Bidang SDM Transportasi','Peraturan',NULL,NULL,NULL,NULL),('022.12',2013,'IKUSSSDM08.01',NULL,'Jumlah draft peraturan perundangan dan ketentuan pelaksanaan lainnya yang dihasilkan di Bidang SDM Transportasi','Peraturan',NULL,NULL,NULL,NULL),('022.12',2012,'IKUSSSDM09.01',NULL,'Jumlah sarana diklat Transportasi Darat, Laut, Udara, Perkeretaapian dan Aparatur Perhubungan yang berbasis teknologi tinggi/mutakhir','Unit',NULL,NULL,NULL,NULL),('022.12',2013,'IKUSSSDM09.01',NULL,'Jumlah sarana diklat Transportasi Darat, Laut, Udara, Perkeretaapian dan Aparatur Perhubungan yang berbasis teknologi tinggi/ mutakhir','Unit',NULL,NULL,NULL,NULL),('022.12',2012,'IKUSSSDM09.02',NULL,'Jumlah prasarana diklat Transportasi Darat, Laut, Udara, Perkeretaapian dan Aparatur Perhubungan','M2',NULL,NULL,NULL,NULL),('022.12',2013,'IKUSSSDM09.02',NULL,'Jumlah prasarana diklat Transportasi Darat, Laut, Udara, Perkeretaapian dan Aparatur Perhubungan','M2',NULL,NULL,NULL,NULL),('022.12',2012,'IKUSSSDM10.01',NULL,'Jumlah tenaga kependidikan di BPSDM Perhubungan yang prima, profesional dan beretika ','Orang',NULL,NULL,NULL,NULL),('022.12',2013,'IKUSSSDM10.01',NULL,'Jumlah tenaga kependidikan di BPSDM Perhubungan yang prima, profesional dan beretika ','Orang',NULL,NULL,NULL,NULL),('022.01',2012,'IKUSSSJ01.01',NULL,'Nilai Akuntabilitas Kinerja Kementerian Perhubungan berdasarkan hasil evaluasi Kemenpan dan Reformasi Birokrasi','Nilai',NULL,NULL,NULL,NULL),('022.01',2013,'IKUSSSJ01.01',NULL,'Nilai Akuntabilitas Kinerja Kementerian Perhubungan berdasarkan hasil evaluasi Kemenpan dan Reformasi Birokrasi','Nilai',NULL,NULL,NULL,NULL),('022.01',2012,'IKUSSSJ01.02',NULL,'Nilai akuntabilitas kinerja Sekretariat Jenderal berdasarkan hasil evaluasi Inspektorat Jenderal','Nilai',NULL,NULL,NULL,NULL),('022.01',2013,'IKUSSSJ01.02',NULL,'Nilai akuntabilitas kinerja Sekretariat Jenderal berdasarkan hasil evaluasi Inspektorat Jenderal','Nilai',NULL,NULL,NULL,NULL),('022.01',2012,'IKUSSSJ02.01',NULL,'Tingkat ketepatan waktu pelayanan administrasi perkantoran','%',NULL,NULL,NULL,NULL),('022.01',2013,'IKUSSSJ02.01',NULL,'Tingkat ketepatan waktu pelayanan administrasi perkantoran','%',NULL,NULL,NULL,NULL),('022.01',2012,'IKUSSSJ03.01',NULL,'Jumlah rekomendasi hasil analisis informasi untuk penyempurnaan kebijakan sektor transportasi','Rekomendasi',NULL,NULL,NULL,NULL),('022.01',2013,'IKUSSSJ03.01',NULL,'Jumlah rekomendasi hasil analisis informasi untuk penyempurnaan kebijakan sektor transportasi','Rekomendasi',NULL,NULL,NULL,NULL),('022.01',2012,'IKUSSSJ03.02',NULL,'Indeks opini publik terhadap Kementerian Perhubungan','Indeks ',NULL,NULL,NULL,NULL),('022.01',2013,'IKUSSSJ03.02',NULL,'Indeks opini publik terhadap Kementerian Perhubungan','Indeks ',NULL,NULL,NULL,NULL),('022.01',2012,'IKUSSSJ04.01',NULL,'Jumlah terselenggaranya kerjasama luar negeri di bidang transportasi','Kerjasama',NULL,NULL,NULL,NULL),('022.01',2013,'IKUSSSJ04.01',NULL,'Jumlah terselenggaranya kerjasama luar negeri di bidang transportasi','Kerjasama',NULL,NULL,NULL,NULL),('022.01',2012,'IKUSSSJ05.01',NULL,'Penghematan biaya energi, air, dan telepon di lingkungan kantor pusat Kementerian Perhubungan','Rp',NULL,NULL,NULL,NULL),('022.01',2013,'IKUSSSJ05.01',NULL,'Penghematan biaya energi, air, dan telepon di lingkungan kantor pusat Kementerian Perhubungan','Rp',NULL,NULL,NULL,NULL),('022.01',2012,'IKUSSSJ05.02',NULL,'Tingkat pemenuhan kebutuhan sarana dan prasarana Setjen','%',NULL,NULL,NULL,NULL),('022.01',2013,'IKUSSSJ05.02',NULL,'Tingkat pemenuhan kebutuhan sarana dan prasarana Setjen','%',NULL,NULL,NULL,NULL),('022.01',2012,'IKUSSSJ06.01',NULL,'Jumlah aparatur Kementerian Perhubungan yang telah meningkatkan kualitas dan kompetensi','Orang',NULL,NULL,NULL,NULL),('022.01',2013,'IKUSSSJ06.01',NULL,'Jumlah aparatur Kementerian Perhubungan yang telah meningkatkan kualitas dan kompetensi','Orang',NULL,NULL,NULL,NULL),('022.01',2012,'IKUSSSJ06.02',NULL,'Tersusunnya RPM standar kompetensi jabatan aparatur di lingkungan Kementerian Perhubungan','RPM',NULL,NULL,NULL,NULL),('022.01',2013,'IKUSSSJ06.02',NULL,'Tersusunnya RPM standar kompetensi jabatan aparatur di lingkungan Kementerian Perhubungan','RPM',NULL,NULL,NULL,NULL),('022.01',2012,'IKUSSSJ06.03',NULL,'Tersusunnya regulasi terkait SDM aparatur di lingkungan Kementerian Perhubungan','Regulasi',NULL,NULL,NULL,NULL),('022.01',2013,'IKUSSSJ06.03',NULL,'Tersusunnya regulasi terkait SDM aparatur di lingkungan Kementerian Perhubungan','Regulasi',NULL,NULL,NULL,NULL),('022.01',2012,'IKUSSSJ07.01',NULL,'Jumlah laporan penataan organisasi/kelembagaan dan tata laksana di lingkungan Kementerian Perhubungan','Dokumen/Tahun',NULL,NULL,NULL,NULL),('022.01',2013,'IKUSSSJ07.01',NULL,'Jumlah laporan penataan organisasi/kelembagaan dan tata laksana di lingkungan Kementerian Perhubungan','Dokumen/Tahun',NULL,NULL,NULL,NULL),('022.01',2012,'IKUSSSJ07.02',NULL,'Persentase unit kerja yang telah memenuhi kaidah kelembagaan yang baik','%',NULL,NULL,NULL,NULL),('022.01',2013,'IKUSSSJ07.02',NULL,'Persentase unit kerja yang telah memenuhi kaidah kelembagaan yang baik','%',NULL,NULL,NULL,NULL),('022.01',2012,'IKUSSSJ08.01',NULL,'Opini BPK atas pengelolaan keuangan Kementerian Perhubungan','Opini',NULL,NULL,NULL,NULL),('022.01',2013,'IKUSSSJ08.01',NULL,'Opini BPK atas pengelolaan keuangan Kementerian Perhubungan','Opini',NULL,NULL,NULL,NULL),('022.01',2012,'IKUSSSJ08.02','IKUSSKP09.03','Jumlah aset BMN/kekayaan negara Sekretariat Jenderal yang terinventariasi','Rp.',NULL,NULL,NULL,NULL),('022.01',2013,'IKUSSSJ08.02','IKUSSKP09.03','Jumlah aset BMN/kekayaan negara Sekretariat Jenderal yang terinventariasi','Rp.',NULL,NULL,NULL,NULL),('022.01',2012,'IKUSSSJ08.03',NULL,'Tingkat penyerapan anggaran di lingkungan Sekretariat Jenderal','%',NULL,NULL,NULL,NULL),('022.01',2013,'IKUSSSJ08.03',NULL,'Tingkat penyerapan anggaran di lingkungan Sekretariat Jenderal','%',NULL,NULL,NULL,NULL),('022.01',2012,'IKUSSSJ09.01','IKUSSKP11.01','Jumlah dokumen peraturan perundang-undangan di bidang transportasi','Dokumen',NULL,NULL,NULL,NULL),('022.01',2013,'IKUSSSJ09.01','IKUSSKP11.01','Jumlah dokumen peraturan perundang-undangan di bidang transportasi','Dokumen',NULL,NULL,NULL,NULL),('022.01',2012,'IKUSSSJ09.02','IKUSSKP11.01','Jumlah regulasi terkait pelaksanaan tugas Sekretariat Jenderal','Peraturan',NULL,NULL,NULL,NULL),('022.01',2013,'IKUSSSJ09.02','IKUSSKP11.01','Jumlah regulasi terkait pelaksanaan tugas Sekretariat Jenderal','Peraturan',NULL,NULL,NULL,NULL),('022.01',2012,'IKUSSSJ10.01',NULL,'Jumlah Kapasitas Jaringan yang dapat melayani Aplikasi Dukungan Operasional dan Pelayanan Publik','Mbps',NULL,NULL,NULL,NULL),('022.01',2013,'IKUSSSJ10.01',NULL,'Jumlah Kapasitas Jaringan yang dapat melayani Aplikasi Dukungan Operasional dan Pelayanan Publik','Mbps',NULL,NULL,NULL,NULL),('022.01',2012,'IKUSSSJ10.02',NULL,'Persentase data operasional sarana, prasarana dan produksi transportasi yang ter-update','%',NULL,NULL,NULL,NULL),('022.01',2013,'IKUSSSJ10.02',NULL,'Persentase data operasional sarana, prasarana dan produksi transportasi yang ter-update','%',NULL,NULL,NULL,NULL),('022.01',2012,'IKUSSSJ11.01',NULL,'Jumlah rekomendasi hasil kajian kemitraan dan pelayanan jasa serta lingkungan hidup transportasi','Dokumen ',NULL,NULL,NULL,NULL),('022.01',2013,'IKUSSSJ11.01',NULL,'Jumlah rekomendasi hasil kajian kemitraan dan pelayanan jasa serta lingkungan hidup transportasi','Dokumen ',NULL,NULL,NULL,NULL),('022.01',2012,'IKUSSSJ11.02','IKUSSKP08.01','Jumlah dokumen pra-studi kelayakan dan evaluasi dokumen proyek kerjasama pemerintah dan swasta yang diselesaikan','Dokumen ',NULL,NULL,NULL,NULL),('022.01',2013,'IKUSSSJ11.02','IKUSSKP08.01','Jumlah dokumen pra-studi kelayakan dan evaluasi dokumen proyek kerjasama pemerintah dan swasta yang diselesaikan','Dokumen ',NULL,NULL,NULL,NULL),('022.01',2012,'IKUSSSJ11.03',NULL,'Jumlah hasil penilaian pelayanan jasa transportasi','Unit Pelayanan Publik',NULL,NULL,NULL,NULL),('022.01',2013,'IKUSSSJ11.03',NULL,'Jumlah hasil penilaian pelayanan jasa transportasi','Unit Pelayanan Publik',NULL,NULL,NULL,NULL),('022.01',2012,'IKUSSSJ11.04',NULL,'Jumlah pedoman bidang pengelolaan lingkungan hidup yang dirumuskan','Pedoman',NULL,NULL,NULL,NULL),('022.01',2013,'IKUSSSJ11.04',NULL,'Jumlah pedoman bidang pengelolaan lingkungan hidup yang dirumuskan','Pedoman',NULL,NULL,NULL,NULL),('022.01',2012,'IKUSSSJ12.01',NULL,'Persentase perkara kecelakaan kapal yang disidangkan dan diputus tepat waktu','%',NULL,NULL,NULL,NULL),('022.01',2013,'IKUSSSJ12.01',NULL,'Persentase perkara kecelakaan kapal yang disidangkan dan diputus tepat waktu','%',NULL,NULL,NULL,NULL),('022.01',2012,'IKUSSSJ12.02',NULL,'Persentase rekomendasi putusan mahkamah pelayaran yang ditindaklanjuti','%',NULL,NULL,NULL,NULL),('022.01',2013,'IKUSSSJ12.02',NULL,'Persentase rekomendasi putusan mahkamah pelayaran yang ditindaklanjuti','%',NULL,NULL,NULL,NULL),('022.01',2012,'IKUSSSJ13.01',NULL,'Jumlah laporan putusan yang disampaikan kepada para pihak','Laporan',NULL,NULL,NULL,NULL),('022.01',2013,'IKUSSSJ13.01',NULL,'Jumlah laporan putusan yang disampaikan kepada para pihak','Laporan',NULL,NULL,NULL,NULL),('022.01',2012,'IKUSSSJ14.01',NULL,'Jumlah terselesaikannya laporan final kecelakaan transportasi','Laporan',NULL,NULL,NULL,NULL),('022.01',2013,'IKUSSSJ14.01',NULL,'Jumlah terselesaikannya laporan final kecelakaan transportasi','Laporan',NULL,NULL,NULL,NULL),('022.01',2012,'IKUSSSJ14.02',NULL,'Jumlah data kecelakaan 4 moda transportasi (udara, laut, jalan, kereta api) yang diinvestigasi KNKT','Laporan',NULL,NULL,NULL,NULL),('022.01',2013,'IKUSSSJ14.02',NULL,'Jumlah data kecelakaan 4 moda transportasi (udara, laut, jalan, kereta api) yang diinvestigasi KNKT','Laporan',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `tbl_iku_eselon1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_iku_eselon1_log`
--

DROP TABLE IF EXISTS `tbl_iku_eselon1_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_iku_eselon1_log` (
  `kode_e1` varchar(10) DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `kode_iku_e1` varchar(20) DEFAULT NULL,
  `kode_iku_kl` varchar(20) DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `satuan` varchar(40) DEFAULT NULL,
  `kode_e2` varchar(10) DEFAULT NULL,
  `log` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_iku_eselon1_log`
--

LOCK TABLES `tbl_iku_eselon1_log` WRITE;
/*!40000 ALTER TABLE `tbl_iku_eselon1_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_iku_eselon1_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_iku_kl`
--

DROP TABLE IF EXISTS `tbl_iku_kl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_iku_kl` (
  `kode_kl` varchar(10) NOT NULL,
  `tahun` year(4) NOT NULL,
  `kode_iku_kl` varchar(20) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `satuan` varchar(40) NOT NULL,
  `kode_e1` varchar(10) DEFAULT NULL,
  `log_insert` varchar(50) DEFAULT NULL,
  `log_update` varchar(50) DEFAULT NULL,
  `kode_sasaran_kl` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`kode_iku_kl`,`tahun`),
  KEY `FK_tbl_iku_kl` (`kode_kl`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_iku_kl`
--

LOCK TABLES `tbl_iku_kl` WRITE;
/*!40000 ALTER TABLE `tbl_iku_kl` DISABLE KEYS */;
INSERT INTO `tbl_iku_kl` VALUES ('022',2012,'IKUSSKP01.01','Jumlah kejadian kecelakaan transportasi nasional yang disebabkan oleh faktor yang terkait dengan kewenangan Kementerian Perhubungan','Kejadian/Tahun',NULL,NULL,NULL,NULL),('022',2013,'IKUSSKP01.01','Jumlah kejadian kecelakaan transportasi nasional yang disebabkan oleh faktor yang terkait dengan kewenangan Kementerian Perhubungan','Kejadian/Tahun',NULL,NULL,NULL,NULL),('022',2012,'IKUSSKP02.01','Jumlah gangguan keamanan pada sektor transportasi oleh faktor yang terkait dengan kewenangan Kementerian Perhubungan','Kejadian/Tahun',NULL,NULL,NULL,NULL),('022',2013,'IKUSSKP02.01','Jumlah gangguan keamanan pada sektor transportasi oleh faktor yang terkait dengan kewenangan Kementerian Perhubungan','Kejadian/Tahun',NULL,NULL,NULL,NULL),('022',2012,'IKUSSKP03.01','Rata-rata persentase pencapaian On-Time Performance (OTP) sektor transportasi (selain transportasi darat)','%',NULL,NULL,NULL,NULL),('022',2013,'IKUSSKP03.01','Rata-rata persentase pencapaian On-Time Performance (OTP) sektor transportasi (selain transportasi darat)','%',NULL,NULL,NULL,NULL),('022',2012,'IKUSSKP04.01','Jumlah sarana transportasi yang sudah tersertifikasi','Unit',NULL,NULL,NULL,NULL),('022',2013,'IKUSSKP04.01','Jumlah sarana transportasi yang sudah tersertifikasi','Unit',NULL,NULL,NULL,NULL),('022',2012,'IKUSSKP04.02','Jumlah prasarana transportasi yang sudah tersertifikasi','Unit',NULL,NULL,NULL,NULL),('022',2013,'IKUSSKP04.02','Jumlah prasarana transportasi yang sudah tersertifikasi','Unit',NULL,NULL,NULL,NULL),('022',2012,'IKUSSKP05.01','Jumlah lintas pelayanan angkutan perintis dan subsidi','Lintas',NULL,NULL,NULL,NULL),('022',2013,'IKUSSKP05.01','Jumlah lintas pelayanan angkutan perintis dan subsidi','Lintas',NULL,NULL,NULL,NULL),('022',2012,'IKUSSKP06.01','Kontribusi sektor transportasi terhadap pertumbuhan ekonomi nasional','%',NULL,NULL,NULL,NULL),('022',2013,'IKUSSKP06.01','Kontribusi sektor transportasi terhadap pertumbuhan ekonomi nasional','%',NULL,NULL,NULL,NULL),('022',2012,'IKUSSKP07.01','Total produksi angkutan penumpang','Penumpang/Tahun',NULL,NULL,NULL,NULL),('022',2013,'IKUSSKP07.01','Total produksi angkutan penumpang','Penumpang/Tahun',NULL,NULL,NULL,NULL),('022',2012,'IKUSSKP07.02','Total produksi angkutan barang','Ton/Tahun',NULL,NULL,NULL,NULL),('022',2013,'IKUSSKP07.02','Total produksi angkutan barang','Ton/Tahun',NULL,NULL,NULL,NULL),('022',2012,'IKUSSKP08.01','Jumlah infrastruktur transportasi yang siap ditawarkan melalui kerjasama Pemerintah-Swasta','Jumlah Proyek yang Siap Ditawarkan Melal',NULL,NULL,NULL,NULL),('022',2013,'IKUSSKP08.01','Jumlah infrastruktur transportasi yang siap ditawarkan melalui kerjasama Pemerintah-Swasta','Jumlah Proyek yang Siap Ditawarkan Melal',NULL,NULL,NULL,NULL),('022',2012,'IKUSSKP09.01','Nilai AKIP Kementerian Perhubungan','Nilai',NULL,NULL,NULL,NULL),('022',2013,'IKUSSKP09.01','Nilai AKIP Kementerian Perhubungan','Nilai',NULL,NULL,NULL,NULL),('022',2012,'IKUSSKP09.02','Opini BPK atas laporan keuangan Kementerian Perhubungan','Opini',NULL,NULL,NULL,NULL),('022',2013,'IKUSSKP09.02','Opini BPK atas laporan keuangan Kementerian Perhubungan','Opini',NULL,NULL,NULL,NULL),('022',2012,'IKUSSKP09.03','Nilai aset negara yang berhasil diinventarisasi sesuai kaidah pengelolaan BMN','Rp Trilliun',NULL,NULL,NULL,NULL),('022',2013,'IKUSSKP09.03','Nilai aset negara yang berhasil diinventarisasi sesuai kaidah pengelolaan BMN','Rp Trilliun',NULL,NULL,NULL,NULL),('022',2012,'IKUSSKP10.01','Jumlah SDM operator prasarana dan sarana transportasi yang telah memiliki sertifikat','Orang',NULL,NULL,NULL,NULL),('022',2013,'IKUSSKP10.01','Jumlah SDM operator prasarana dan sarana transportasi yang telah memiliki sertifikat','Orang',NULL,NULL,NULL,NULL),('022',2012,'IKUSSKP10.02','Jumlah SDM fungsional teknis Kementerian Perhubungan','Orang',NULL,NULL,NULL,NULL),('022',2013,'IKUSSKP10.02','Jumlah SDM fungsional teknis Kementerian Perhubungan','Orang',NULL,NULL,NULL,NULL),('022',2012,'IKUSSKP10.03','Jumlah lulusan diklat SDM Transportasi Darat, Laut, Udara, Perkeretaapian dan Aparatur yang prima, profesional dan beretika yang dihasilkan setiap tahun yang sesuai standar kompetensi/kelulusan','Orang',NULL,NULL,NULL,NULL),('022',2013,'IKUSSKP10.03','Jumlah lulusan diklat SDM Transportasi Darat, Laut, Udara, Perkeretaapian dan Aparatur yang prima, profesional dan beretika yang dihasilkan setiap tahun yang sesuai standar kompetensi/kelulusan','Orang',NULL,NULL,NULL,NULL),('022',2012,'IKUSSKP11.01','Jumlah peraturan perundang-undangan di sektor transportasi yang ditetapkan','Peraturan',NULL,NULL,NULL,NULL),('022',2013,'IKUSSKP11.01','Jumlah peraturan perundang-undangan di sektor transportasi yang ditetapkan','Peraturan',NULL,NULL,NULL,NULL),('022',2012,'IKUSSKP12.01','Jumlah konsumsi energi tak terbarukan dari sektor transportasi nasional','Juta Liter/Tahun',NULL,NULL,NULL,NULL),('022',2013,'IKUSSKP12.01','Jumlah konsumsi energi tak terbarukan dari sektor transportasi nasional','Juta Liter/Tahun',NULL,NULL,NULL,NULL),('022',2012,'IKUSSKP12.02','Jumlah emisi gas buang dari sektor transportasi nasional','Juta Ton/Tahun',NULL,NULL,NULL,NULL),('022',2013,'IKUSSKP12.02','Jumlah emisi gas buang dari sektor transportasi nasional','Juta Ton/Tahun',NULL,NULL,NULL,NULL),('022',2012,'IKUSSKP13.01','Jumlah penerapan teknologi ramah lingkungan pada sarana dan prasarana transportasi','Lokasi (Unit)',NULL,NULL,NULL,NULL),('022',2013,'IKUSSKP13.01','Jumlah penerapan teknologi ramah lingkungan pada sarana dan prasarana transportasi','Lokasi (Unit)',NULL,NULL,NULL,NULL),('022',2012,'IKUSSKP13.02','Jumlah lokasi simpul transportasi yang telah menerapkan konsep ramah lingkungan','Lokasi',NULL,NULL,NULL,NULL),('022',2013,'IKUSSKP13.02','Jumlah lokasi simpul transportasi yang telah menerapkan konsep ramah lingkungan','Lokasi',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `tbl_iku_kl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_iku_kl_log`
--

DROP TABLE IF EXISTS `tbl_iku_kl_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_iku_kl_log` (
  `kode_kl` varchar(10) DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `kode_iku_kl` varchar(20) DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `satuan` varchar(40) DEFAULT NULL,
  `kode_e1` varchar(10) DEFAULT NULL,
  `log` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_iku_kl_log`
--

LOCK TABLES `tbl_iku_kl_log` WRITE;
/*!40000 ALTER TABLE `tbl_iku_kl_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_iku_kl_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_kegiatan_kl`
--

DROP TABLE IF EXISTS `tbl_kegiatan_kl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_kegiatan_kl` (
  `id_kegiatan_kl` int(11) NOT NULL AUTO_INCREMENT,
  `tahun` year(4) NOT NULL,
  `kode_kegiatan` varchar(20) NOT NULL,
  `nama_kegiatan` varchar(255) NOT NULL,
  `kode_program` varchar(20) NOT NULL,
  `total` bigint(20) NOT NULL,
  `kode_e2` varchar(10) NOT NULL,
  `log_insert` varchar(50) DEFAULT NULL,
  `log_update` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_kegiatan_kl`),
  KEY `FK_tbl_kegiatan_kl_eselon2` (`kode_e2`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_kegiatan_kl`
--

LOCK TABLES `tbl_kegiatan_kl` WRITE;
/*!40000 ALTER TABLE `tbl_kegiatan_kl` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_kegiatan_kl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_kinerja_eselon1`
--

DROP TABLE IF EXISTS `tbl_kinerja_eselon1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_kinerja_eselon1` (
  `id_kinerja_e1` int(11) NOT NULL AUTO_INCREMENT,
  `tahun` year(4) NOT NULL,
  `triwulan` int(11) NOT NULL,
  `kode_e1` varchar(10) NOT NULL,
  `kode_sasaran_e1` varchar(20) NOT NULL,
  `kode_iku_e1` varchar(20) NOT NULL,
  `realisasi` varchar(20) NOT NULL,
  `log_insert` varchar(50) DEFAULT NULL,
  `log_update` varchar(50) DEFAULT NULL,
  `realisasi_persen` float DEFAULT NULL,
  `keterangan` varchar(150) DEFAULT NULL,
  `action_plan` text,
  PRIMARY KEY (`id_kinerja_e1`),
  KEY `FK_tbl_kinerja_eselon1` (`kode_e1`),
  KEY `FK_tbl_kinerja_eselon1_sasaran` (`kode_sasaran_e1`),
  KEY `FK_tbl_kinerja_eselon1_iku` (`kode_iku_e1`),
  CONSTRAINT `tbl_kinerja_eselon1_ibfk_1` FOREIGN KEY (`kode_e1`) REFERENCES `tbl_eselon1` (`kode_e1`) ON UPDATE CASCADE,
  CONSTRAINT `tbl_kinerja_eselon1_ibfk_2` FOREIGN KEY (`kode_sasaran_e1`) REFERENCES `tbl_sasaran_eselon1` (`kode_sasaran_e1`) ON UPDATE CASCADE,
  CONSTRAINT `tbl_kinerja_eselon1_ibfk_3` FOREIGN KEY (`kode_iku_e1`) REFERENCES `tbl_iku_eselon1` (`kode_iku_e1`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=935 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_kinerja_eselon1`
--

LOCK TABLES `tbl_kinerja_eselon1` WRITE;
/*!40000 ALTER TABLE `tbl_kinerja_eselon1` DISABLE KEYS */;
INSERT INTO `tbl_kinerja_eselon1` VALUES (1,2012,12,'022.01','SSSJ.01','IKUSSSJ01.01','B',NULL,NULL,113.55,NULL,NULL),(2,2012,12,'022.01','SSSJ.01','IKUSSSJ01.02','AA',NULL,NULL,113.52,NULL,NULL),(3,2012,12,'022.01','SSSJ.02','IKUSSSJ02.01','85',NULL,NULL,106.25,NULL,NULL),(4,2012,12,'022.01','SSSJ.03','IKUSSSJ03.01','251',NULL,NULL,418.33,NULL,NULL),(5,2012,12,'022.01','SSSJ.03','IKUSSSJ03.02','1318',NULL,NULL,610.19,NULL,NULL),(6,2012,12,'022.01','SSSJ.04','IKUSSSJ04.01','15',NULL,NULL,68.18,NULL,NULL),(7,2012,12,'022.01','SSSJ.05','IKUSSSJ05.01','8689894992',NULL,NULL,147.41,NULL,NULL),(8,2012,12,'022.01','SSSJ.05','IKUSSSJ05.02','94.74',NULL,NULL,94.74,NULL,NULL),(9,2012,12,'022.01','SSSJ.06','IKUSSSJ06.01','313',NULL,NULL,112.19,NULL,NULL),(10,2012,12,'022.01','SSSJ.06','IKUSSSJ06.02','7',NULL,NULL,100,NULL,NULL),(11,2012,12,'022.01','SSSJ.06','IKUSSSJ06.03','14',NULL,NULL,127.27,NULL,NULL),(12,2012,12,'022.01','SSSJ.07','IKUSSSJ07.01','12',NULL,NULL,133.33,NULL,NULL),(13,2012,12,'022.01','SSSJ.07','IKUSSSJ07.02','100',NULL,NULL,100,NULL,NULL),(14,2012,12,'022.01','SSSJ.08','IKUSSSJ08.01','WDP',NULL,NULL,80,NULL,NULL),(15,2012,12,'022.01','SSSJ.08','IKUSSSJ08.02','1124600356389',NULL,NULL,80.91,NULL,NULL),(16,2012,12,'022.01','SSSJ.08','IKUSSSJ08.03','89',NULL,NULL,89,NULL,NULL),(17,2012,12,'022.01','SSSJ.09','IKUSSSJ09.01','784',NULL,NULL,1425.45,NULL,NULL),(18,2012,12,'022.01','SSSJ.09','IKUSSSJ09.02','23',NULL,NULL,230,NULL,NULL),(19,2012,12,'022.01','SSSJ.10','IKUSSSJ10.01','100',NULL,NULL,100,NULL,NULL),(20,2012,12,'022.01','SSSJ.10','IKUSSSJ10.02','40',NULL,NULL,100,NULL,NULL),(21,2012,12,'022.01','SSSJ.11','IKUSSSJ11.01','26',NULL,NULL,118.18,NULL,NULL),(22,2012,12,'022.01','SSSJ.11','IKUSSSJ11.02','7',NULL,NULL,233.33,NULL,NULL),(23,2012,12,'022.01','SSSJ.11','IKUSSSJ11.03','122',NULL,NULL,103.39,NULL,NULL),(24,2012,12,'022.01','SSSJ.11','IKUSSSJ11.04','6',NULL,NULL,150,NULL,NULL),(25,2012,12,'022.01','SSSJ.12','IKUSSSJ12.01','34',NULL,NULL,85,NULL,NULL),(26,2012,12,'022.01','SSSJ.12','IKUSSSJ12.02','34',NULL,NULL,85,NULL,NULL),(27,2012,12,'022.01','SSSJ.13','IKUSSSJ13.01','34',NULL,NULL,85,NULL,NULL),(28,2012,12,'022.01','SSSJ.14','IKUSSSJ14.01','146',NULL,NULL,107.35,NULL,NULL),(29,2012,12,'022.01','SSSJ.14','IKUSSSJ14.02','258',NULL,NULL,102.38,NULL,NULL),(30,2012,12,'022.02','SSIJ.01','IKUSSIJ01.01','0.12',NULL,NULL,100,NULL,NULL),(31,2012,12,'022.02','SSIJ.01','IKUSSIJ01.02','0',NULL,NULL,100,NULL,NULL),(32,2012,12,'022.02','SSIJ.02','IKUSSIJ02.01','70',NULL,NULL,100,NULL,NULL),(33,2012,12,'022.02','SSIJ.03','IKUSSIJ03.01','10',NULL,NULL,100,NULL,NULL),(34,2012,12,'022.02','SSIJ.04','IKUSSIJ04.01','82',NULL,NULL,100,NULL,NULL),(35,2012,12,'022.02','SSIJ.05','IKUSSIJ05.01','50',NULL,NULL,100,NULL,NULL),(36,2012,12,'022.02','SSIJ.05','IKUSSIJ05.02','90',NULL,NULL,100,NULL,NULL),(37,2012,12,'022.02','SSIJ.06','IKUSSIJ06.01','9',NULL,NULL,100,NULL,NULL),(38,2012,12,'022.02','SSIJ.07','IKUSSIJ07.01','90',NULL,NULL,100,NULL,NULL),(39,2012,12,'022.02','SSIJ.07','IKUSSIJ07.02','0.85',NULL,NULL,100,NULL,NULL),(40,2012,12,'022.02','SSIJ.07','IKUSSIJ07.03','82',NULL,NULL,100,NULL,NULL),(41,2012,12,'022.02','SSIJ.08','IKUSSIJ08.01','30',NULL,NULL,100,NULL,NULL),(42,2012,12,'022.02','SSIJ.08','IKUSSIJ08.02','160',NULL,NULL,100,NULL,NULL),(43,2012,12,'022.02','SSIJ.09','IKUSSIJ09.01','50',NULL,NULL,100,NULL,NULL),(44,2012,12,'022.03','SSPD.01','IKUSSPD01.01','0.206',NULL,NULL,91.96,NULL,NULL),(45,2012,12,'022.03','SSPD.01','IKUSSPD01.02','480',NULL,NULL,92,NULL,NULL),(46,2012,12,'022.03','SSPD.02','IKUSSPD02.01','4.27',NULL,NULL,25.12,NULL,NULL),(47,2012,12,'022.03','SSPD.02','IKUSSPD02.02','10.38',NULL,NULL,98.45,NULL,NULL),(48,2012,12,'022.03','SSPD.03','IKUSSPD03.01','5234',NULL,NULL,108.22,NULL,NULL),(49,2012,12,'022.03','SSPD.03','IKUSSPD03.02','1',NULL,NULL,50,NULL,NULL),(50,2012,12,'022.03','SSPD.04','IKUSSPD04.01','95.82',NULL,NULL,95.82,NULL,NULL),(51,2012,12,'022.03','SSPD.04','IKUSSPD04.02','69',NULL,NULL,100,NULL,NULL),(52,2012,12,'022.03','SSPD.05','IKUSSPD05.01','3',NULL,NULL,100,NULL,NULL),(53,2012,12,'022.03','SSPD.05','IKUSSPD05.02','205',NULL,NULL,298.55,NULL,NULL),(54,2012,12,'022.03','SSPD.05','IKUSSPD05.03','24',NULL,NULL,85.71,NULL,NULL),(55,2012,12,'022.03','SSPD.05','IKUSSPD05.04','14',NULL,NULL,100,NULL,NULL),(56,2012,12,'022.03','SSPD.05','IKUSSPD05.05','15',NULL,NULL,100,NULL,NULL),(57,2012,12,'022.03','SSPD.06','IKUSSPD06.01','169',NULL,NULL,100,NULL,NULL),(58,2012,12,'022.03','SSPD.06','IKUSSPD06.02','2335',NULL,NULL,100,NULL,NULL),(59,2012,12,'022.03','SSPD.06','IKUSSPD06.03','135',NULL,NULL,100,NULL,NULL),(60,2012,12,'022.03','SSPD.06','IKUSSPD06.04','42',NULL,NULL,89,NULL,NULL),(61,2012,12,'022.03','SSPD.07','IKUSSPD07.01','61400028',NULL,NULL,111.87,NULL,NULL),(62,2012,12,'022.03','SSPD.07','IKUSSPD07.02','13767975',NULL,NULL,201.81,NULL,NULL),(63,2012,12,'022.03','SSPD.07','IKUSSPD07.03','5524875',NULL,NULL,100,NULL,NULL),(64,2012,12,'022.03','SSPD.07','IKUSSPD07.04','3276851',NULL,NULL,100,NULL,NULL),(65,2012,12,'022.03','SSPD.07','IKUSSPD07.07','543061239',NULL,NULL,100,NULL,NULL),(66,2012,12,'022.03','SSPD.08','IKUSSPD08.01','59',NULL,NULL,88,NULL,NULL),(67,2012,12,'022.03','SSPD.08','IKUSSPD08.02','63',NULL,NULL,90,NULL,NULL),(68,2012,12,'022.03','SSPD.08','IKUSSPD08.03','88.19',NULL,NULL,88.19,NULL,NULL),(69,2012,12,'022.03','SSPD.08','IKUSSPD08.04','92.62',NULL,NULL,215,NULL,NULL),(70,2012,12,'022.03','SSPD.09','IKUSSPD09.01','83.07',NULL,NULL,98.89,NULL,NULL),(71,2012,12,'022.03','SSPD.09','IKUSSPD09.02','90.55',NULL,NULL,98.22,NULL,NULL),(72,2012,12,'022.03','SSPD.09','IKUSSPD09.03','9347923692208',NULL,NULL,142.17,NULL,NULL),(73,2012,12,'022.03','SSPD.10','IKUSSPD10.01','100',NULL,NULL,100,NULL,NULL),(74,2012,12,'022.03','SSPD.10','IKUSSPD10.02','202',NULL,NULL,100,NULL,NULL),(75,2012,12,'022.03','SSPD.11','IKUSSPD11.01','4',NULL,NULL,100,NULL,NULL),(76,2012,12,'022.03','SSPD.12','IKUSSPD12.01','22',NULL,NULL,129,NULL,NULL),(77,2012,12,'022.04','SSPL.01','IKUSSPL01.01','24',NULL,NULL,129.17,NULL,NULL),(78,2012,12,'022.04','SSPL.01','IKUSSPL01.02','66',NULL,NULL,72.73,NULL,NULL),(79,2012,12,'022.04','SSPL.02','IKUSSPL02.01','9298',NULL,NULL,130.11,NULL,NULL),(80,2012,12,'022.04','SSPL.03','IKUSSPL03.01','80',NULL,NULL,100,NULL,NULL),(81,2012,12,'022.04','SSPL.03','IKUSSPL03.02','386',NULL,NULL,98.22,NULL,NULL),(82,2012,12,'022.04','SSPL.04','IKUSSPL04.01','6061571',NULL,NULL,120.56,NULL,NULL),(83,2012,12,'022.04','SSPL.04','IKUSSPL04.02','634000',NULL,NULL,100.66,NULL,NULL),(84,2012,12,'022.04','SSPL.04','IKUSSPL04.03','351985284',NULL,NULL,107.54,NULL,NULL),(85,2012,12,'022.04','SSPL.04','IKUSSPL04.04','98.9',NULL,NULL,100.05,NULL,NULL),(86,2012,12,'022.04','SSPL.04','IKUSSPL04.05','59851000',NULL,NULL,100.59,NULL,NULL),(87,2012,12,'022.04','SSPL.04','IKUSSPL04.06','11.8',NULL,NULL,118,NULL,NULL),(88,2012,12,'022.04','SSPL.05','IKUSSPL05.01','0',NULL,NULL,0,'Rata-rata TRT tahun 2012 sebesar 87.94 Jam/Kapal',NULL),(89,2012,12,'022.04','SSPL.06','IKUSSPL06.01','36',NULL,NULL,75,NULL,NULL),(90,2012,12,'022.04','SSPL.06','IKUSSPL06.02','36',NULL,NULL,75,NULL,NULL),(91,2012,12,'022.04','SSPL.06','IKUSSPL06.03','15',NULL,NULL,31.25,NULL,NULL),(92,2012,12,'022.04','SSPL.07','IKUSSPL07.01','2',NULL,NULL,100,NULL,NULL),(93,2012,12,'022.04','SSPL.08','IKUSSPL08.01','60',NULL,NULL,100,NULL,NULL),(94,2012,12,'022.04','SSPL.08','IKUSSPL08.02','120',NULL,NULL,100,NULL,NULL),(95,2012,12,'022.04','SSPL.08','IKUSSPL08.03','59',NULL,NULL,98.33,NULL,NULL),(96,2012,12,'022.04','SSPL.08','IKUSSPL08.04','367',NULL,NULL,100,NULL,NULL),(97,2012,12,'022.04','SSPL.08','IKUSSPL08.05','60',NULL,NULL,100,NULL,NULL),(98,2012,12,'022.04','SSPL.08','IKUSSPL08.06','120',NULL,NULL,100,NULL,NULL),(99,2012,12,'022.04','SSPL.08','IKUSSPL08.07','0',NULL,NULL,0,'Alokasi anggaran tidak ada karena penghematan',NULL),(100,2012,12,'022.04','SSPL.08','IKUSSPL08.08','0',NULL,NULL,0,'Alokasi anggaran tidak ada karena penghematan',NULL),(101,2012,12,'022.04','SSPL.08','IKUSSPL08.09','0',NULL,NULL,0,'Alokasi anggaran tidak ada karena penghematan',NULL),(102,2012,12,'022.04','SSPL.09','IKUSSPL09.01','78',NULL,NULL,100,NULL,NULL),(103,2012,12,'022.04','SSPL.09','IKUSSPL09.02','620559000000',NULL,NULL,187.21,NULL,NULL),(104,2012,12,'022.04','SSPL.09','IKUSSPL09.03','9993260000000',NULL,NULL,86.52,NULL,NULL),(105,2012,12,'022.04','SSPL.09','IKUSSPL09.04','25241600000000',NULL,NULL,94.61,NULL,NULL),(106,2012,12,'022.04','SSPL.10','IKUSSPL10.01','11',NULL,NULL,100,NULL,NULL),(107,2012,12,'022.04','SSPL.11','IKUSSPL11.01','0.102',NULL,NULL,20.59,NULL,NULL),(108,2012,12,'022.04','SSPL.12','IKUSSPL12.01','6',NULL,NULL,100,NULL,NULL),(109,2012,12,'022.04','SSPL.12','IKUSSPL12.02','972',NULL,NULL,95.2,NULL,NULL),(110,2012,12,'022.04','SSPL.12','IKUSSPL12.03','1332',NULL,NULL,87.23,NULL,NULL),(111,2012,12,'022.04','SSPL.12','IKUSSPL12.04','107',NULL,NULL,79.85,NULL,NULL),(112,2012,12,'022.04','SSPL.12','IKUSSPL12.05','205',NULL,NULL,80.33,NULL,NULL),(113,2012,12,'022.05','SSPU.01','IKUSSPU01.01','5.56',NULL,NULL,121.13,NULL,NULL),(114,2012,12,'022.05','SSPU.01','IKUSSPU01.02','9',NULL,NULL,183.93,NULL,NULL),(115,2012,12,'022.05','SSPU.02','IKUSSPU02.01','6',NULL,NULL,133.3,NULL,NULL),(116,2012,12,'022.05','SSPU.03','IKUSSPU03.01','76.87',NULL,NULL,100.8,NULL,NULL),(117,2012,12,'022.05','SSPU.04','IKUSSPU04.01','130',NULL,NULL,98.48,NULL,NULL),(118,2012,12,'022.05','SSPU.04','IKUSSPU04.02','159792',NULL,NULL,58.22,NULL,NULL),(119,2012,12,'022.05','SSPU.04','IKUSSPU04.03','127',NULL,NULL,98.45,NULL,NULL),(120,2012,12,'022.05','SSPU.05','IKUSSPU05.01','159',NULL,NULL,138.26,NULL,NULL),(121,2012,12,'022.05','SSPU.05','IKUSSPU05.02','81357603',NULL,NULL,105.36,NULL,NULL),(122,2012,12,'022.05','SSPU.05','IKUSSPU05.03','662238',NULL,NULL,60.42,NULL,NULL),(123,2012,12,'022.05','SSPU.06','IKUSSPU06.01','1042',NULL,NULL,101.66,NULL,NULL),(124,2012,12,'022.05','SSPU.06','IKUSSPU06.02','16',NULL,NULL,106.67,NULL,NULL),(125,2012,12,'022.05','SSPU.07','IKUSSPU07.01','659',NULL,NULL,100,NULL,NULL),(126,2012,12,'022.05','SSPU.07','IKUSSPU07.02','58175',NULL,NULL,103.15,NULL,NULL),(127,2012,12,'022.05','SSPU.08','IKUSSPU08.01','9',NULL,NULL,90,NULL,NULL),(128,2012,12,'022.05','SSPU.09','IKUSSPU09.01','36',NULL,NULL,120,NULL,NULL),(129,2012,12,'022.05','SSPU.10','IKUSSPU10.01','83.36',NULL,NULL,99.7,NULL,NULL),(130,2012,12,'022.05','SSPU.10','IKUSSPU10.02','87.59',NULL,NULL,101.85,NULL,NULL),(131,2012,12,'022.05','SSPU.10','IKUSSPU10.03','36122371519324',NULL,NULL,122.85,NULL,NULL),(132,2012,12,'022.05','SSPU.11','IKUSSPU11.01','15',NULL,NULL,100,NULL,NULL),(133,2012,12,'022.05','SSPU.12','IKUSSPU12.01','3758484',NULL,NULL,100.2,NULL,NULL),(134,2012,12,'022.05','SSPU.12','IKUSSPU12.02','56331.33',NULL,NULL,85,NULL,NULL),(135,2012,12,'022.08','SSKA.01','IKUSSKA01.01','31',NULL,NULL,96.67,NULL,NULL),(136,2012,12,'022.08','SSKA.02','IKUSSKA02.01','75.6',NULL,NULL,95.77,NULL,NULL),(137,2012,12,'022.08','SSKA.02','IKUSSKA02.02','44.64',NULL,NULL,88.4,NULL,NULL),(138,2012,12,'022.08','SSKA.03','IKUSSKA03.01','3307',NULL,NULL,118.27,NULL,NULL),(139,2012,12,'022.08','SSKA.03','IKUSSKA03.02','5',NULL,NULL,29.41,NULL,NULL),(140,2012,12,'022.08','SSKA.04','IKUSSKA04.01','168',NULL,NULL,113.51,NULL,NULL),(141,2012,12,'022.08','SSKA.04','IKUSSKA04.02','69',NULL,NULL,109.52,NULL,NULL),(142,2012,12,'022.08','SSKA.04','IKUSSKA04.03','225.93',NULL,NULL,59.78,NULL,NULL),(143,2012,12,'022.08','SSKA.05','IKUSSKA05.01','0.39',NULL,NULL,7.09,NULL,NULL),(144,2012,12,'022.08','SSKA.05','IKUSSKA05.02','0.17',NULL,NULL,2.06,NULL,NULL),(145,2012,12,'022.08','SSKA.06','IKUSSKA06.01','85',NULL,NULL,85.86,NULL,NULL),(146,2012,12,'022.08','SSKA.06','IKUSSKA06.02','132746437',NULL,NULL,58.12,NULL,NULL),(147,2012,12,'022.08','SSKA.06','IKUSSKA06.03','22079119',NULL,NULL,75.31,NULL,NULL),(148,2012,12,'022.08','SSKA.07','IKUSSKA07.01','70',NULL,NULL,100,NULL,NULL),(149,2012,12,'022.08','SSKA.08','IKUSSKA08.01','82.17',NULL,NULL,102.19,NULL,NULL),(150,2012,12,'022.08','SSKA.08','IKUSSKA08.02','89.39',NULL,NULL,117.56,NULL,NULL),(151,2012,12,'022.08','SSKA.08','IKUSSKA08.03','81.7',NULL,NULL,107.5,NULL,NULL),(152,2012,12,'022.08','SSKA.09','IKUSSKA09.01','1990',NULL,NULL,331.67,NULL,NULL),(153,2012,12,'022.08','SSKA.10','IKUSSKA10.01','5',NULL,NULL,71.43,NULL,NULL),(154,2012,12,'022.08','SSKA.11','IKUSSKA11.01','44',NULL,NULL,115.79,NULL,NULL),(155,2012,12,'022.08','SSKA.11','IKUSSKA11.02','1',NULL,NULL,100,NULL,NULL),(156,2012,12,'022.11','SSPP.01','IKUSSPP01.01','45',NULL,NULL,107.14,NULL,NULL),(157,2012,12,'022.11','SSPP.01','IKUSSPP01.02','112',NULL,NULL,70.89,NULL,NULL),(158,2012,12,'022.11','SSPP.02','IKUSSPP02.01','243',NULL,NULL,65.68,NULL,NULL),(159,2012,12,'022.12','SSSDM.01','IKUSSSDM01.01','175793',NULL,NULL,111.05,NULL,NULL),(160,2012,12,'022.12','SSSDM.02','IKUSSSDM02.01','162364',NULL,NULL,108.81,NULL,NULL),(161,2012,12,'022.12','SSSDM.03','IKUSSSDM03.01','100',NULL,NULL,106.39,NULL,NULL),(162,2012,12,'022.12','SSSDM.03','IKUSSSDM03.02','17',NULL,NULL,100,NULL,NULL),(163,2012,12,'022.12','SSSDM.04','IKUSSSDM04.01','30',NULL,NULL,90.91,NULL,NULL),(164,2012,12,'022.12','SSSDM.04','IKUSSSDM04.02','1',NULL,NULL,100,NULL,NULL),(165,2012,12,'022.12','SSSDM.04','IKUSSSDM04.03','664',NULL,NULL,289.96,NULL,NULL),(166,2012,12,'022.12','SSSDM.05','IKUSSSDM05.01','0',NULL,NULL,0,NULL,NULL),(167,2012,12,'022.12','SSSDM.06','IKUSSSDM06.01','38',NULL,NULL,950,NULL,NULL),(168,2012,12,'022.12','SSSDM.07','IKUSSSDM07.01','89.5',NULL,NULL,100,NULL,NULL),(169,2012,12,'022.12','SSSDM.07','IKUSSSDM07.02','86.38',NULL,NULL,105.12,NULL,NULL),(170,2012,12,'022.12','SSSDM.07','IKUSSSDM07.03','8897224987516',NULL,NULL,101,NULL,NULL),(171,2012,12,'022.12','SSSDM.08','IKUSSSDM08.01','20',NULL,NULL,166.67,NULL,NULL),(172,2012,12,'022.12','SSSDM.09','IKUSSSDM09.01','20030',NULL,NULL,109.81,NULL,NULL),(173,2012,12,'022.12','SSSDM.09','IKUSSSDM09.02','244110.675',NULL,NULL,93.51,NULL,NULL),(174,2012,12,'022.12','SSSDM.10','IKUSSSDM10.01','2578',NULL,NULL,88.74,NULL,NULL),(201,2013,3,'022.01','SSSJ.01','IKUSSSJ01.01','0',NULL,NULL,0,NULL,NULL),(202,2013,3,'022.01','SSSJ.01','IKUSSSJ01.02','0',NULL,NULL,0,NULL,NULL),(203,2013,3,'022.01','SSSJ.02','IKUSSSJ02.01','90',NULL,NULL,100,NULL,NULL),(204,2013,3,'022.01','SSSJ.03','IKUSSSJ03.01','67',NULL,NULL,100,NULL,NULL),(205,2013,3,'022.01','SSSJ.03','IKUSSSJ03.02','250',NULL,NULL,113.64,NULL,NULL),(206,2013,3,'022.01','SSSJ.04','IKUSSSJ04.01','10',NULL,NULL,50,NULL,NULL),(207,2013,3,'022.01','SSSJ.05','IKUSSSJ05.01','0',NULL,NULL,0,NULL,NULL),(208,2013,3,'022.01','SSSJ.05','IKUSSSJ05.02','0',NULL,NULL,0,NULL,NULL),(209,2013,3,'022.01','SSSJ.06','IKUSSSJ06.01','0',NULL,NULL,0,NULL,NULL),(210,2013,3,'022.01','SSSJ.06','IKUSSSJ06.02','0',NULL,NULL,0,NULL,NULL),(211,2013,3,'022.01','SSSJ.06','IKUSSSJ06.03','12',NULL,NULL,200,NULL,NULL),(212,2013,3,'022.01','SSSJ.07','IKUSSSJ07.01','4',NULL,NULL,57.14,NULL,NULL),(213,2013,3,'022.01','SSSJ.07','IKUSSSJ07.02','0',NULL,NULL,0,NULL,NULL),(214,2013,3,'022.01','SSSJ.08','IKUSSSJ08.01','0',NULL,NULL,0,'Opini terbit pada pertengahan Juni 2013',NULL),(215,2013,3,'022.01','SSSJ.08','IKUSSSJ08.02','0',NULL,NULL,0,NULL,NULL),(216,2013,3,'022.01','SSSJ.08','IKUSSSJ08.03','80652813000',NULL,NULL,1.59,NULL,NULL),(217,2013,3,'022.01','SSSJ.09','IKUSSSJ09.01','201',NULL,NULL,100.5,NULL,NULL),(218,2013,3,'022.01','SSSJ.09','IKUSSSJ09.02','8',NULL,NULL,80,NULL,NULL),(219,2013,3,'022.01','SSSJ.10','IKUSSSJ10.01','0',NULL,NULL,0,NULL,NULL),(220,2013,3,'022.01','SSSJ.10','IKUSSSJ10.02','0',NULL,NULL,0,NULL,NULL),(221,2013,3,'022.01','SSSJ.11','IKUSSSJ11.01','0',NULL,NULL,0,NULL,NULL),(222,2013,3,'022.01','SSSJ.11','IKUSSSJ11.02','0',NULL,NULL,0,NULL,NULL),(223,2013,3,'022.01','SSSJ.11','IKUSSSJ11.03','0',NULL,NULL,0,'Penilaian dilaksanakan 2 tahun sekali',NULL),(224,2013,3,'022.01','SSSJ.11','IKUSSSJ11.04','0',NULL,NULL,0,NULL,NULL),(225,2013,3,'022.01','SSSJ.12','IKUSSSJ12.01','0',NULL,NULL,0,NULL,NULL),(226,2013,3,'022.01','SSSJ.12','IKUSSSJ12.02','0',NULL,NULL,0,NULL,NULL),(227,2013,3,'022.01','SSSJ.13','IKUSSSJ13.01','14',NULL,NULL,31.11,NULL,NULL),(228,2013,3,'022.01','SSSJ.14','IKUSSSJ14.01','130',NULL,NULL,78.79,NULL,NULL),(229,2013,3,'022.01','SSSJ.14','IKUSSSJ14.02','240',NULL,NULL,85.11,NULL,NULL),(230,2013,5,'022.01','SSSJ.01','IKUSSSJ01.01','0',NULL,NULL,0,NULL,NULL),(231,2013,5,'022.01','SSSJ.01','IKUSSSJ01.02','0',NULL,NULL,0,NULL,NULL),(232,2013,5,'022.01','SSSJ.02','IKUSSSJ02.01','90',NULL,NULL,100,NULL,NULL),(233,2013,5,'022.01','SSSJ.03','IKUSSSJ03.01','67',NULL,NULL,100,NULL,NULL),(234,2013,5,'022.01','SSSJ.03','IKUSSSJ03.02','378',NULL,NULL,171.82,NULL,NULL),(235,2013,5,'022.01','SSSJ.04','IKUSSSJ04.01','12',NULL,NULL,60,NULL,NULL),(236,2013,5,'022.01','SSSJ.05','IKUSSSJ05.01','3468344456',NULL,NULL,35.85,NULL,NULL),(237,2013,5,'022.01','SSSJ.05','IKUSSSJ05.02','1773018680',NULL,NULL,3.77,NULL,NULL),(238,2013,5,'022.01','SSSJ.06','IKUSSSJ06.01','0',NULL,NULL,0,NULL,NULL),(239,2013,5,'022.01','SSSJ.06','IKUSSSJ06.02','1',NULL,NULL,100,NULL,NULL),(240,2013,5,'022.01','SSSJ.06','IKUSSSJ06.03','12',NULL,NULL,200,NULL,NULL),(241,2013,5,'022.01','SSSJ.07','IKUSSSJ07.01','6',NULL,NULL,85.71,NULL,NULL),(242,2013,5,'022.01','SSSJ.07','IKUSSSJ07.02','0',NULL,NULL,0,NULL,NULL),(243,2013,5,'022.01','SSSJ.08','IKUSSSJ08.01','0',NULL,NULL,0,'Opini terbit pada pertengahan Juni 2013',NULL),(244,2013,5,'022.01','SSSJ.08','IKUSSSJ08.02','0',NULL,NULL,0,NULL,NULL),(245,2013,5,'022.01','SSSJ.08','IKUSSSJ08.03','80652813000',NULL,NULL,1.59,NULL,NULL),(246,2013,5,'022.01','SSSJ.09','IKUSSSJ09.01','201',NULL,NULL,100.5,NULL,NULL),(247,2013,5,'022.01','SSSJ.09','IKUSSSJ09.02','12',NULL,NULL,120,NULL,NULL),(248,2013,5,'022.01','SSSJ.10','IKUSSSJ10.01','0',NULL,NULL,33.3,'On progress',NULL),(249,2013,5,'022.01','SSSJ.10','IKUSSSJ10.02','45.33',NULL,NULL,26.67,NULL,NULL),(250,2013,5,'022.01','SSSJ.11','IKUSSSJ11.01','0',NULL,NULL,44,'Fisik 44%',NULL),(251,2013,5,'022.01','SSSJ.11','IKUSSSJ11.02','0',NULL,NULL,30,'Fisik 30%',NULL),(252,2013,5,'022.01','SSSJ.11','IKUSSSJ11.03','0',NULL,NULL,0,'Penilaian dilaksanakan 2 tahun sekali',NULL),(253,2013,5,'022.01','SSSJ.11','IKUSSSJ11.04','0',NULL,NULL,30,'Fisik 30%',NULL),(254,2013,5,'022.01','SSSJ.12','IKUSSSJ12.01','42',NULL,NULL,93.33,NULL,NULL),(255,2013,5,'022.01','SSSJ.12','IKUSSSJ12.02','0',NULL,NULL,0,NULL,NULL),(256,2013,5,'022.01','SSSJ.13','IKUSSSJ13.01','14',NULL,NULL,31.11,NULL,NULL),(257,2013,5,'022.01','SSSJ.14','IKUSSSJ14.01','154',NULL,NULL,93.33,NULL,NULL),(258,2013,5,'022.01','SSSJ.14','IKUSSSJ14.02','279',NULL,NULL,98.94,NULL,NULL),(301,2013,3,'022.02','SSIJ.01','IKUSSIJ01.01','0',NULL,'8;2013-07-25 10:28:19',0,'Keterangan','Action Plan'),(302,2013,3,'022.02','SSIJ.01','IKUSSIJ01.02','0',NULL,NULL,0,NULL,NULL),(303,2013,3,'022.02','SSIJ.02','IKUSSIJ02.01','7',NULL,NULL,9.59,NULL,NULL),(304,2013,3,'022.02','SSIJ.03','IKUSSIJ03.01','0',NULL,NULL,0,NULL,NULL),(305,2013,3,'022.02','SSIJ.04','IKUSSIJ04.01','0',NULL,NULL,0,NULL,NULL),(306,2013,3,'022.02','SSIJ.05','IKUSSIJ05.01','20',NULL,NULL,33.33,NULL,NULL),(307,2013,3,'022.02','SSIJ.05','IKUSSIJ05.02','0',NULL,NULL,0,NULL,NULL),(308,2013,3,'022.02','SSIJ.06','IKUSSIJ06.01','3',NULL,NULL,23.08,NULL,NULL),(309,2013,3,'022.02','SSIJ.07','IKUSSIJ07.01','27.44',NULL,NULL,29.51,NULL,NULL),(310,2013,3,'022.02','SSIJ.07','IKUSSIJ07.02','0',NULL,NULL,0,NULL,NULL),(311,2013,3,'022.02','SSIJ.07','IKUSSIJ07.03','0',NULL,NULL,0,NULL,NULL),(312,2013,3,'022.02','SSIJ.08','IKUSSIJ08.01','0',NULL,NULL,0,NULL,NULL),(313,2013,3,'022.02','SSIJ.08','IKUSSIJ08.02','50',NULL,NULL,29.41,NULL,NULL),(314,2013,3,'022.02','SSIJ.09','IKUSSIJ09.01','45',NULL,NULL,60,NULL,NULL),(315,2013,5,'022.02','SSIJ.01','IKUSSIJ01.01','0.09',NULL,NULL,100,NULL,NULL),(316,2013,5,'022.02','SSIJ.01','IKUSSIJ01.02','0',NULL,NULL,0,NULL,NULL),(317,2013,5,'022.02','SSIJ.02','IKUSSIJ02.01','10.99',NULL,NULL,15.055,NULL,NULL),(318,2013,5,'022.02','SSIJ.03','IKUSSIJ03.01','0',NULL,NULL,0,NULL,NULL),(319,2013,5,'022.02','SSIJ.04','IKUSSIJ04.01','0',NULL,NULL,0,NULL,NULL),(320,2013,5,'022.02','SSIJ.05','IKUSSIJ05.01','25',NULL,NULL,41.67,NULL,NULL),(321,2013,5,'022.02','SSIJ.05','IKUSSIJ05.02','0',NULL,NULL,0,NULL,NULL),(322,2013,5,'022.02','SSIJ.06','IKUSSIJ06.01','3',NULL,NULL,23.08,NULL,NULL),(323,2013,5,'022.02','SSIJ.07','IKUSSIJ07.01','27.44',NULL,NULL,29.51,NULL,NULL),(324,2013,5,'022.02','SSIJ.07','IKUSSIJ07.02','0.77',NULL,NULL,90.59,NULL,NULL),(325,2013,5,'022.02','SSIJ.07','IKUSSIJ07.03','0',NULL,NULL,0,NULL,NULL),(326,2013,5,'022.02','SSIJ.08','IKUSSIJ08.01','0',NULL,NULL,0,NULL,NULL),(327,2013,5,'022.02','SSIJ.08','IKUSSIJ08.02','90',NULL,NULL,52.94,NULL,NULL),(328,2013,5,'022.02','SSIJ.09','IKUSSIJ09.01','53',NULL,NULL,70.67,NULL,NULL),(401,2013,3,'022.03','SSPD.01','IKUSSPD01.01','0',NULL,NULL,0,NULL,NULL),(402,2013,3,'022.03','SSPD.01','IKUSSPD01.02','0',NULL,NULL,0,NULL,NULL),(403,2013,3,'022.03','SSPD.02','IKUSSPD02.01','0',NULL,NULL,0,NULL,NULL),(404,2013,3,'022.03','SSPD.02','IKUSSPD02.02','0',NULL,NULL,0,NULL,NULL),(405,2013,3,'022.03','SSPD.03','IKUSSPD03.01','0',NULL,NULL,0,NULL,NULL),(406,2013,3,'022.03','SSPD.03','IKUSSPD03.02','0',NULL,NULL,100,NULL,NULL),(407,2013,3,'022.03','SSPD.04','IKUSSPD04.01','0',NULL,NULL,0,NULL,NULL),(408,2013,3,'022.03','SSPD.04','IKUSSPD04.02','1',NULL,NULL,1.35,NULL,NULL),(409,2013,3,'022.03','SSPD.05','IKUSSPD05.01','0',NULL,NULL,0,NULL,NULL),(410,2013,3,'022.03','SSPD.05','IKUSSPD05.02','0',NULL,NULL,0,NULL,NULL),(411,2013,3,'022.03','SSPD.05','IKUSSPD05.03','0',NULL,NULL,0,NULL,NULL),(412,2013,3,'022.03','SSPD.05','IKUSSPD05.04','0',NULL,NULL,0,NULL,NULL),(413,2013,3,'022.03','SSPD.05','IKUSSPD05.05','0',NULL,NULL,0,NULL,NULL),(414,2013,3,'022.03','SSPD.06','IKUSSPD06.01','0',NULL,NULL,0,NULL,NULL),(415,2013,3,'022.03','SSPD.06','IKUSSPD06.02','0',NULL,NULL,0,NULL,NULL),(416,2013,3,'022.03','SSPD.06','IKUSSPD06.03','0',NULL,NULL,0,NULL,NULL),(417,2013,3,'022.03','SSPD.06','IKUSSPD06.04','0',NULL,NULL,0,NULL,NULL),(418,2013,3,'022.03','SSPD.07','IKUSSPD07.01','0',NULL,NULL,0,NULL,NULL),(419,2013,3,'022.03','SSPD.07','IKUSSPD07.02','0',NULL,NULL,0,NULL,NULL),(420,2013,3,'022.03','SSPD.07','IKUSSPD07.03','0',NULL,NULL,0,NULL,NULL),(421,2013,3,'022.03','SSPD.07','IKUSSPD07.04','0',NULL,NULL,0,NULL,NULL),(422,2013,3,'022.03','SSPD.07','IKUSSPD07.05','0',NULL,NULL,0,NULL,NULL),(423,2013,3,'022.03','SSPD.07','IKUSSPD07.06','0',NULL,NULL,0,NULL,NULL),(424,2013,3,'022.03','SSPD.07','IKUSSPD07.07','0',NULL,NULL,0,NULL,NULL),(425,2013,3,'022.03','SSPD.08','IKUSSPD08.01','0',NULL,NULL,0,NULL,NULL),(426,2013,3,'022.03','SSPD.08','IKUSSPD08.02','0',NULL,NULL,0,NULL,NULL),(427,2013,3,'022.03','SSPD.08','IKUSSPD08.03','0',NULL,NULL,0,NULL,NULL),(428,2013,3,'022.03','SSPD.08','IKUSSPD08.04','0',NULL,NULL,0,NULL,NULL),(429,2013,3,'022.03','SSPD.09','IKUSSPD09.01','0',NULL,NULL,0,NULL,NULL),(430,2013,3,'022.03','SSPD.09','IKUSSPD09.02','1.7',NULL,NULL,1.7,'Rp. 48.449.429.780',NULL),(431,2013,3,'022.03','SSPD.09','IKUSSPD09.03','0',NULL,NULL,0,NULL,NULL),(432,2013,3,'022.03','SSPD.10','IKUSSPD10.01','1',NULL,NULL,1,NULL,NULL),(433,2013,3,'022.03','SSPD.10','IKUSSPD10.02','207',NULL,NULL,68.54,NULL,NULL),(434,2013,3,'022.03','SSPD.11','IKUSSPD11.01','0',NULL,NULL,0,NULL,NULL),(435,2013,3,'022.03','SSPD.12','IKUSSPD12.01','0',NULL,NULL,0,NULL,NULL),(436,2013,5,'022.03','SSPD.01','IKUSSPD01.01','0',NULL,NULL,0,NULL,NULL),(437,2013,5,'022.03','SSPD.01','IKUSSPD01.02','0',NULL,NULL,0,NULL,NULL),(438,2013,5,'022.03','SSPD.02','IKUSSPD02.01','0',NULL,NULL,0,NULL,NULL),(439,2013,5,'022.03','SSPD.02','IKUSSPD02.02','0',NULL,NULL,0,NULL,NULL),(440,2013,5,'022.03','SSPD.03','IKUSSPD03.01','0',NULL,NULL,0,NULL,NULL),(441,2013,5,'022.03','SSPD.03','IKUSSPD03.02','0',NULL,NULL,100,NULL,NULL),(442,2013,5,'022.03','SSPD.04','IKUSSPD04.01','0',NULL,NULL,0,NULL,NULL),(443,2013,5,'022.03','SSPD.04','IKUSSPD04.02','2',NULL,NULL,2.703,NULL,NULL),(444,2013,5,'022.03','SSPD.05','IKUSSPD05.01','0',NULL,NULL,0,NULL,NULL),(445,2013,5,'022.03','SSPD.05','IKUSSPD05.02','0',NULL,NULL,0,NULL,NULL),(446,2013,5,'022.03','SSPD.05','IKUSSPD05.03','0',NULL,NULL,0,NULL,NULL),(447,2013,5,'022.03','SSPD.05','IKUSSPD05.04','0',NULL,NULL,0,NULL,NULL),(448,2013,5,'022.03','SSPD.05','IKUSSPD05.05','0',NULL,NULL,0,NULL,NULL),(449,2013,5,'022.03','SSPD.06','IKUSSPD06.01','0',NULL,NULL,0,NULL,NULL),(450,2013,5,'022.03','SSPD.06','IKUSSPD06.02','0',NULL,NULL,0,NULL,NULL),(451,2013,5,'022.03','SSPD.06','IKUSSPD06.03','0',NULL,NULL,0,NULL,NULL),(452,2013,5,'022.03','SSPD.06','IKUSSPD06.04','0',NULL,NULL,0,NULL,NULL),(453,2013,5,'022.03','SSPD.07','IKUSSPD07.01','0',NULL,NULL,0,NULL,NULL),(454,2013,5,'022.03','SSPD.07','IKUSSPD07.02','0',NULL,NULL,0,NULL,NULL),(455,2013,5,'022.03','SSPD.07','IKUSSPD07.03','0',NULL,NULL,0,NULL,NULL),(456,2013,5,'022.03','SSPD.07','IKUSSPD07.04','0',NULL,NULL,0,NULL,NULL),(457,2013,5,'022.03','SSPD.07','IKUSSPD07.05','0',NULL,NULL,0,NULL,NULL),(458,2013,5,'022.03','SSPD.07','IKUSSPD07.06','0',NULL,NULL,0,NULL,NULL),(459,2013,5,'022.03','SSPD.07','IKUSSPD07.07','0',NULL,NULL,0,NULL,NULL),(460,2013,5,'022.03','SSPD.08','IKUSSPD08.01','0',NULL,NULL,0,NULL,NULL),(461,2013,5,'022.03','SSPD.08','IKUSSPD08.02','0',NULL,NULL,0,NULL,NULL),(462,2013,5,'022.03','SSPD.08','IKUSSPD08.03','0',NULL,NULL,0,NULL,NULL),(463,2013,5,'022.03','SSPD.08','IKUSSPD08.04','0',NULL,NULL,0,NULL,NULL),(464,2013,5,'022.03','SSPD.09','IKUSSPD09.01','0',NULL,NULL,0,NULL,NULL),(465,2013,5,'022.03','SSPD.09','IKUSSPD09.02','8.82',NULL,NULL,8.82,'Rp. 250.837.730.630',NULL),(466,2013,5,'022.03','SSPD.09','IKUSSPD09.03','0',NULL,NULL,0,NULL,NULL),(467,2013,5,'022.03','SSPD.10','IKUSSPD10.01','19',NULL,NULL,19,NULL,NULL),(468,2013,5,'022.03','SSPD.10','IKUSSPD10.02','240',NULL,NULL,79.48,NULL,NULL),(469,2013,5,'022.03','SSPD.11','IKUSSPD11.01','0',NULL,NULL,0,NULL,NULL),(470,2013,5,'022.03','SSPD.12','IKUSSPD12.01','7',NULL,NULL,46.67,NULL,NULL),(501,2013,3,'022.04','SSPL.01','IKUSSPL01.01','1',NULL,NULL,3.23,NULL,NULL),(502,2013,3,'022.04','SSPL.01','IKUSSPL01.02','4',NULL,NULL,8.33,NULL,NULL),(503,2013,3,'022.04','SSPL.02','IKUSSPL02.01','765',NULL,NULL,9.75,NULL,NULL),(504,2013,3,'022.04','SSPL.03','IKUSSPL03.01','80',NULL,NULL,100,NULL,NULL),(505,2013,3,'022.04','SSPL.03','IKUSSPL03.02','0',NULL,NULL,0,NULL,NULL),(506,2013,3,'022.04','SSPL.04','IKUSSPL04.01','2091240',NULL,NULL,31.4,NULL,NULL),(507,2013,3,'022.04','SSPL.04','IKUSSPL04.02','263110',NULL,NULL,41.5,NULL,NULL),(508,2013,3,'022.04','SSPL.04','IKUSSPL04.03','91677850',NULL,NULL,26.89,NULL,NULL),(509,2013,3,'022.04','SSPL.04','IKUSSPL04.04','25.75',NULL,NULL,26.25,NULL,NULL),(510,2013,3,'022.04','SSPL.04','IKUSSPL04.05','16732200',NULL,NULL,26.48,NULL,NULL),(511,2013,3,'022.04','SSPL.04','IKUSSPL04.06','3.05',NULL,NULL,29.53,NULL,NULL),(512,2013,3,'022.04','SSPL.05','IKUSSPL05.01','0',NULL,NULL,0,NULL,NULL),(513,2013,3,'022.04','SSPL.06','IKUSSPL06.01','36',NULL,NULL,75,NULL,NULL),(514,2013,3,'022.04','SSPL.06','IKUSSPL06.02','36',NULL,NULL,75,NULL,NULL),(515,2013,3,'022.04','SSPL.06','IKUSSPL06.03','15',NULL,NULL,31.25,NULL,NULL),(516,2013,3,'022.04','SSPL.07','IKUSSPL07.01','2',NULL,NULL,100,NULL,NULL),(517,2013,3,'022.04','SSPL.08','IKUSSPL08.01','0',NULL,NULL,0,NULL,NULL),(518,2013,3,'022.04','SSPL.08','IKUSSPL08.02','0',NULL,NULL,0,NULL,NULL),(519,2013,3,'022.04','SSPL.08','IKUSSPL08.03','0',NULL,NULL,0,NULL,NULL),(520,2013,3,'022.04','SSPL.08','IKUSSPL08.04','0',NULL,NULL,0,NULL,NULL),(521,2013,3,'022.04','SSPL.08','IKUSSPL08.05','0',NULL,NULL,0,NULL,NULL),(522,2013,3,'022.04','SSPL.08','IKUSSPL08.06','0',NULL,NULL,0,NULL,NULL),(523,2013,3,'022.04','SSPL.08','IKUSSPL08.07','0',NULL,NULL,0,NULL,NULL),(524,2013,3,'022.04','SSPL.08','IKUSSPL08.08','0',NULL,NULL,0,NULL,NULL),(525,2013,3,'022.04','SSPL.08','IKUSSPL08.09','0',NULL,NULL,0,NULL,NULL),(526,2013,3,'022.04','SSPL.09','IKUSSPL09.01','0',NULL,NULL,0,NULL,NULL),(527,2013,3,'022.04','SSPL.09','IKUSSPL09.02','56447402360',NULL,NULL,18.27,NULL,NULL),(528,2013,3,'022.04','SSPL.09','IKUSSPL09.03','418000000000',NULL,NULL,4.35,NULL,NULL),(529,2013,3,'022.04','SSPL.09','IKUSSPL09.04','0',NULL,NULL,0,NULL,NULL),(530,2013,3,'022.04','SSPL.10','IKUSSPL10.01','5',NULL,NULL,62.5,NULL,NULL),(531,2013,3,'022.04','SSPL.11','IKUSSPL11.01','0',NULL,NULL,0,NULL,NULL),(532,2013,3,'022.04','SSPL.12','IKUSSPL12.01','6',NULL,NULL,50,NULL,NULL),(533,2013,3,'022.04','SSPL.12','IKUSSPL12.02','50',NULL,NULL,4.46,NULL,NULL),(534,2013,3,'022.04','SSPL.12','IKUSSPL12.03','21',NULL,NULL,1.25,NULL,NULL),(535,2013,3,'022.04','SSPL.12','IKUSSPL12.04','9',NULL,NULL,5.92,NULL,NULL),(536,2013,3,'022.04','SSPL.12','IKUSSPL12.05','11',NULL,NULL,4.08,NULL,NULL),(537,2013,5,'022.04','SSPL.01','IKUSSPL01.01','0',NULL,NULL,0,NULL,NULL),(538,2013,5,'022.04','SSPL.01','IKUSSPL01.02','0',NULL,NULL,0,NULL,NULL),(539,2013,5,'022.04','SSPL.02','IKUSSPL02.01','709',NULL,NULL,9.03,NULL,NULL),(540,2013,5,'022.04','SSPL.03','IKUSSPL03.01','80',NULL,NULL,100,NULL,NULL),(541,2013,5,'022.04','SSPL.03','IKUSSPL03.02','0',NULL,NULL,0,NULL,NULL),(542,2013,5,'022.04','SSPL.04','IKUSSPL04.01','0',NULL,NULL,0,NULL,NULL),(543,2013,5,'022.04','SSPL.04','IKUSSPL04.02','0',NULL,NULL,0,NULL,NULL),(544,2013,5,'022.04','SSPL.04','IKUSSPL04.03','0',NULL,NULL,0,NULL,NULL),(545,2013,5,'022.04','SSPL.04','IKUSSPL04.04','0',NULL,NULL,0,NULL,NULL),(546,2013,5,'022.04','SSPL.04','IKUSSPL04.05','0',NULL,NULL,0,NULL,NULL),(547,2013,5,'022.04','SSPL.04','IKUSSPL04.06','0',NULL,NULL,0,NULL,NULL),(548,2013,5,'022.04','SSPL.05','IKUSSPL05.01','0',NULL,NULL,0,NULL,NULL),(549,2013,5,'022.04','SSPL.06','IKUSSPL06.01','0',NULL,NULL,0,NULL,NULL),(550,2013,5,'022.04','SSPL.06','IKUSSPL06.02','0',NULL,NULL,0,NULL,NULL),(551,2013,5,'022.04','SSPL.06','IKUSSPL06.03','0',NULL,NULL,0,NULL,NULL),(552,2013,5,'022.04','SSPL.07','IKUSSPL07.01','2',NULL,NULL,100,NULL,NULL),(553,2013,5,'022.04','SSPL.08','IKUSSPL08.01','0',NULL,NULL,0,NULL,NULL),(554,2013,5,'022.04','SSPL.08','IKUSSPL08.02','0',NULL,NULL,0,NULL,NULL),(555,2013,5,'022.04','SSPL.08','IKUSSPL08.03','0',NULL,NULL,0,NULL,NULL),(556,2013,5,'022.04','SSPL.08','IKUSSPL08.04','0',NULL,NULL,0,NULL,NULL),(557,2013,5,'022.04','SSPL.08','IKUSSPL08.05','0',NULL,NULL,0,NULL,NULL),(558,2013,5,'022.04','SSPL.08','IKUSSPL08.06','0',NULL,NULL,0,NULL,NULL),(559,2013,5,'022.04','SSPL.08','IKUSSPL08.07','0',NULL,NULL,0,NULL,NULL),(560,2013,5,'022.04','SSPL.08','IKUSSPL08.08','0',NULL,NULL,0,NULL,NULL),(561,2013,5,'022.04','SSPL.08','IKUSSPL08.09','0',NULL,NULL,0,NULL,NULL),(562,2013,5,'022.04','SSPL.09','IKUSSPL09.01','0',NULL,NULL,0,NULL,NULL),(563,2013,5,'022.04','SSPL.09','IKUSSPL09.02','0',NULL,NULL,0,NULL,NULL),(564,2013,5,'022.04','SSPL.09','IKUSSPL09.03','1283340286291',NULL,NULL,13.36,NULL,NULL),(565,2013,5,'022.04','SSPL.09','IKUSSPL09.04','0',NULL,NULL,0,NULL,NULL),(566,2013,5,'022.04','SSPL.10','IKUSSPL10.01','5',NULL,NULL,62.5,NULL,NULL),(567,2013,5,'022.04','SSPL.11','IKUSSPL11.01','0',NULL,NULL,0,NULL,NULL),(568,2013,5,'022.04','SSPL.12','IKUSSPL12.01','6',NULL,NULL,50,NULL,NULL),(569,2013,5,'022.04','SSPL.12','IKUSSPL12.02','42',NULL,NULL,3.74,NULL,NULL),(570,2013,5,'022.04','SSPL.12','IKUSSPL12.03','27',NULL,NULL,1.61,NULL,NULL),(571,2013,5,'022.04','SSPL.12','IKUSSPL12.04','4',NULL,NULL,2.63,NULL,NULL),(572,2013,5,'022.04','SSPL.12','IKUSSPL12.05','12',NULL,NULL,4.44,NULL,NULL),(601,2013,3,'022.05','SSPU.01','IKUSSPU01.01','0',NULL,NULL,0,NULL,NULL),(602,2013,3,'022.05','SSPU.01','IKUSSPU01.02','0',NULL,NULL,0,NULL,NULL),(603,2013,3,'022.05','SSPU.02','IKUSSPU02.01','1',NULL,NULL,12.5,NULL,NULL),(604,2013,3,'022.05','SSPU.03','IKUSSPU03.01','0',NULL,NULL,0,NULL,NULL),(605,2013,3,'022.05','SSPU.04','IKUSSPU04.01','0',NULL,NULL,0,NULL,NULL),(606,2013,3,'022.05','SSPU.04','IKUSSPU04.02','0',NULL,NULL,0,'Belum ada penerbangan',NULL),(607,2013,3,'022.05','SSPU.04','IKUSSPU04.03','0',NULL,NULL,0,NULL,NULL),(608,2013,3,'022.05','SSPU.05','IKUSSPU05.01','0',NULL,NULL,0,NULL,NULL),(609,2013,3,'022.05','SSPU.05','IKUSSPU05.02','0',NULL,NULL,0,NULL,NULL),(610,2013,3,'022.05','SSPU.05','IKUSSPU05.03','0',NULL,NULL,0,NULL,NULL),(611,2013,3,'022.05','SSPU.06','IKUSSPU06.01','161',NULL,NULL,13.42,NULL,NULL),(612,2013,3,'022.05','SSPU.06','IKUSSPU06.02','3',NULL,NULL,20,NULL,NULL),(613,2013,3,'022.05','SSPU.07','IKUSSPU07.01','659',NULL,NULL,93.74,NULL,NULL),(614,2013,3,'022.05','SSPU.07','IKUSSPU07.02','58.175',NULL,NULL,0.09,NULL,NULL),(615,2013,3,'022.05','SSPU.08','IKUSSPU08.01','3',NULL,NULL,30,NULL,NULL),(616,2013,3,'022.05','SSPU.09','IKUSSPU09.01','21',NULL,NULL,84,NULL,NULL),(617,2013,3,'022.05','SSPU.10','IKUSSPU10.01','0',NULL,NULL,0,'Belum dinilai',NULL),(618,2013,3,'022.05','SSPU.10','IKUSSPU10.02','2.1',NULL,NULL,2.41,NULL,NULL),(619,2013,3,'022.05','SSPU.10','IKUSSPU10.03','3.60298E+13',NULL,NULL,107.98,NULL,NULL),(620,2013,3,'022.05','SSPU.11','IKUSSPU11.01','15',NULL,NULL,75,NULL,NULL),(621,2013,3,'022.05','SSPU.12','IKUSSPU12.01','0',NULL,NULL,0,'Data tahunan',NULL),(622,2013,3,'022.05','SSPU.12','IKUSSPU12.02','0',NULL,NULL,0,'Data tahunan',NULL),(623,2013,5,'022.05','SSPU.01','IKUSSPU01.01','3.11',NULL,NULL,147.11,NULL,NULL),(624,2013,5,'022.05','SSPU.01','IKUSSPU01.02','0',NULL,NULL,200,NULL,NULL),(625,2013,5,'022.05','SSPU.02','IKUSSPU02.01','2',NULL,NULL,175,NULL,NULL),(626,2013,5,'022.05','SSPU.03','IKUSSPU03.01','76',NULL,NULL,95.58,NULL,NULL),(627,2013,5,'022.05','SSPU.04','IKUSSPU04.01','136',NULL,NULL,98.56,NULL,NULL),(628,2013,5,'022.05','SSPU.04','IKUSSPU04.02','950',NULL,NULL,0.33,NULL,NULL),(629,2013,5,'022.05','SSPU.04','IKUSSPU04.03','130',NULL,NULL,100,NULL,NULL),(630,2013,5,'022.05','SSPU.05','IKUSSPU05.01','19',NULL,NULL,12.84,NULL,NULL),(631,2013,5,'022.05','SSPU.05','IKUSSPU05.02','18740971',NULL,NULL,21.1,NULL,NULL),(632,2013,5,'022.05','SSPU.05','IKUSSPU05.03','109574',NULL,NULL,8.7,NULL,NULL),(633,2013,5,'022.05','SSPU.06','IKUSSPU06.01','208',NULL,NULL,17.33,NULL,NULL),(634,2013,5,'022.05','SSPU.06','IKUSSPU06.02','6',NULL,NULL,40,NULL,NULL),(635,2013,5,'022.05','SSPU.07','IKUSSPU07.01','659',NULL,NULL,93.74,NULL,NULL),(636,2013,5,'022.05','SSPU.07','IKUSSPU07.02','58.175',NULL,NULL,0.089,NULL,NULL),(637,2013,5,'022.05','SSPU.08','IKUSSPU08.01','9',NULL,NULL,90,NULL,NULL),(638,2013,5,'022.05','SSPU.09','IKUSSPU09.01','21',NULL,NULL,84,NULL,NULL),(639,2013,5,'022.05','SSPU.10','IKUSSPU10.01','0',NULL,NULL,0,'Belum dinilai',NULL),(640,2013,5,'022.05','SSPU.10','IKUSSPU10.02','7',NULL,NULL,8.05,NULL,NULL),(641,2013,5,'022.05','SSPU.10','IKUSSPU10.03','3.6141E+13',NULL,NULL,108.31,NULL,NULL),(642,2013,5,'022.05','SSPU.11','IKUSSPU11.01','15',NULL,NULL,75,NULL,NULL),(643,2013,5,'022.05','SSPU.12','IKUSSPU12.01','0',NULL,NULL,0,'Data tahunan',NULL),(644,2013,5,'022.05','SSPU.12','IKUSSPU12.02','0',NULL,NULL,0,'Data tahunan',NULL),(701,2013,3,'022.08','SSKA.01','IKUSSKA01.01','0',NULL,NULL,0,NULL,NULL),(702,2013,3,'022.08','SSKA.02','IKUSSKA02.01','0',NULL,NULL,0,NULL,NULL),(703,2013,3,'022.08','SSKA.02','IKUSSKA02.02','0',NULL,NULL,0,NULL,NULL),(704,2013,3,'022.08','SSKA.03','IKUSSKA03.01','205',NULL,NULL,10.13,NULL,NULL),(705,2013,3,'022.08','SSKA.03','IKUSSKA03.02','2',NULL,NULL,8.33,NULL,NULL),(706,2013,3,'022.08','SSKA.04','IKUSSKA04.01','0',NULL,NULL,0,NULL,NULL),(707,2013,3,'022.08','SSKA.04','IKUSSKA04.02','0',NULL,NULL,0,NULL,NULL),(708,2013,3,'022.08','SSKA.04','IKUSSKA04.03','0',NULL,NULL,0,NULL,NULL),(709,2013,3,'022.08','SSKA.05','IKUSSKA05.01','0',NULL,NULL,0,NULL,NULL),(710,2013,3,'022.08','SSKA.05','IKUSSKA05.02','0',NULL,NULL,0,NULL,NULL),(711,2013,3,'022.08','SSKA.06','IKUSSKA06.01','0',NULL,NULL,0,NULL,NULL),(712,2013,3,'022.08','SSKA.06','IKUSSKA06.02','105400320',NULL,NULL,39.85,NULL,NULL),(713,2013,3,'022.08','SSKA.06','IKUSSKA06.03','5831161',NULL,NULL,15.51,NULL,NULL),(714,2013,3,'022.08','SSKA.07','IKUSSKA07.01','5',NULL,NULL,23.81,NULL,NULL),(715,2013,3,'022.08','SSKA.08','IKUSSKA08.01','0',NULL,NULL,0,NULL,NULL),(716,2013,3,'022.08','SSKA.08','IKUSSKA08.02','9',NULL,NULL,10.76,NULL,NULL),(717,2013,3,'022.08','SSKA.08','IKUSSKA08.03','0',NULL,NULL,0,NULL,NULL),(718,2013,3,'022.08','SSKA.09','IKUSSKA09.01','215',NULL,NULL,4.78,NULL,NULL),(719,2013,3,'022.08','SSKA.10','IKUSSKA10.01','0',NULL,NULL,0,NULL,NULL),(720,2013,3,'022.08','SSKA.11','IKUSSKA11.01','0',NULL,NULL,0,NULL,NULL),(721,2013,3,'022.08','SSKA.11','IKUSSKA11.02','0',NULL,NULL,0,NULL,NULL),(722,2013,5,'022.08','SSKA.01','IKUSSKA01.01','3',NULL,NULL,11.11,NULL,NULL),(723,2013,5,'022.08','SSKA.02','IKUSSKA02.01','59.25',NULL,NULL,74.69,NULL,NULL),(724,2013,5,'022.08','SSKA.02','IKUSSKA02.02','68',NULL,NULL,170,NULL,NULL),(725,2013,5,'022.08','SSKA.03','IKUSSKA03.01','450',NULL,NULL,22.24,NULL,NULL),(726,2013,5,'022.08','SSKA.03','IKUSSKA03.02','5',NULL,NULL,20.83,NULL,NULL),(727,2013,5,'022.08','SSKA.04','IKUSSKA04.01','272',NULL,NULL,182.55,NULL,NULL),(728,2013,5,'022.08','SSKA.04','IKUSSKA04.02','0',NULL,NULL,0,NULL,NULL),(729,2013,5,'022.08','SSKA.04','IKUSSKA04.03','120.93',NULL,NULL,20.71,NULL,NULL),(730,2013,5,'022.08','SSKA.05','IKUSSKA05.01','0',NULL,NULL,0,NULL,NULL),(731,2013,5,'022.08','SSKA.05','IKUSSKA05.02','0',NULL,NULL,0,NULL,NULL),(732,2013,5,'022.08','SSKA.06','IKUSSKA06.01','3',NULL,NULL,17.65,NULL,NULL),(733,2013,5,'022.08','SSKA.06','IKUSSKA06.02','205777101',NULL,NULL,77.8,NULL,NULL),(734,2013,5,'022.08','SSKA.06','IKUSSKA06.03','10831161',NULL,NULL,28.81,NULL,NULL),(735,2013,5,'022.08','SSKA.07','IKUSSKA07.01','9',NULL,NULL,42.86,NULL,NULL),(736,2013,5,'022.08','SSKA.08','IKUSSKA08.01','0',NULL,NULL,0,NULL,NULL),(737,2013,5,'022.08','SSKA.08','IKUSSKA08.02','14.71',NULL,NULL,17.59,NULL,NULL),(738,2013,5,'022.08','SSKA.08','IKUSSKA08.03','82',NULL,NULL,91.11,NULL,NULL),(739,2013,5,'022.08','SSKA.09','IKUSSKA09.01','442',NULL,NULL,9.82,NULL,NULL),(740,2013,5,'022.08','SSKA.10','IKUSSKA10.01','0',NULL,NULL,0,NULL,NULL),(741,2013,5,'022.08','SSKA.11','IKUSSKA11.01','21.08',NULL,NULL,50.82,NULL,NULL),(742,2013,5,'022.08','SSKA.11','IKUSSKA11.02','1',NULL,NULL,100,NULL,NULL),(801,2013,3,'022.11','SSPP.01','IKUSSPP01.01','14',NULL,NULL,29.79,NULL,NULL),(802,2013,3,'022.11','SSPP.01','IKUSSPP01.02','15',NULL,NULL,9.2,NULL,NULL),(803,2013,3,'022.11','SSPP.02','IKUSSPP02.01','1',NULL,NULL,33.33,NULL,NULL),(804,2013,5,'022.11','SSPP.01','IKUSSPP01.01','14',NULL,NULL,29.79,NULL,NULL),(805,2013,5,'022.11','SSPP.01','IKUSSPP01.02','41',NULL,NULL,25.15,NULL,NULL),(806,2013,5,'022.11','SSPP.02','IKUSSPP02.01','1',NULL,NULL,33.33,NULL,NULL),(901,2013,3,'022.12','SSSDM.01','IKUSSSDM01.01','0',NULL,NULL,0,NULL,NULL),(902,2013,3,'022.12','SSSDM.02','IKUSSSDM02.01','0',NULL,NULL,0,NULL,NULL),(903,2013,3,'022.12','SSSDM.03','IKUSSSDM03.01','0',NULL,NULL,0,NULL,NULL),(904,2013,3,'022.12','SSSDM.03','IKUSSSDM03.02','0',NULL,NULL,0,NULL,NULL),(905,2013,3,'022.12','SSSDM.04','IKUSSSDM04.01','0',NULL,NULL,0,NULL,NULL),(906,2013,3,'022.12','SSSDM.04','IKUSSSDM04.02','0',NULL,NULL,0,NULL,NULL),(907,2013,3,'022.12','SSSDM.04','IKUSSSDM04.03','0',NULL,NULL,0,NULL,NULL),(908,2013,3,'022.12','SSSDM.05','IKUSSSDM05.01','0',NULL,NULL,0,NULL,NULL),(909,2013,3,'022.12','SSSDM.06','IKUSSSDM06.01','0',NULL,NULL,0,NULL,NULL),(910,2013,3,'022.12','SSSDM.07','IKUSSSDM07.01','0',NULL,NULL,0,NULL,NULL),(911,2013,3,'022.12','SSSDM.07','IKUSSSDM07.02','0',NULL,NULL,0,NULL,NULL),(912,2013,3,'022.12','SSSDM.07','IKUSSSDM07.03','0',NULL,NULL,0,NULL,NULL),(913,2013,3,'022.12','SSSDM.08','IKUSSSDM08.01','0',NULL,NULL,0,NULL,NULL),(914,2013,3,'022.12','SSSDM.09','IKUSSSDM09.01','0',NULL,NULL,0,NULL,NULL),(915,2013,3,'022.12','SSSDM.09','IKUSSSDM09.02','0',NULL,NULL,0,NULL,NULL),(916,2013,3,'022.12','SSSDM.10','IKUSSSDM10.01','0',NULL,NULL,0,NULL,NULL),(917,2013,5,'022.12','SSSDM.01','IKUSSSDM01.01','63690',NULL,NULL,37.06,NULL,NULL),(918,2013,5,'022.12','SSSDM.02','IKUSSSDM02.01','47265',NULL,NULL,28.29,NULL,NULL),(919,2013,5,'022.12','SSSDM.03','IKUSSSDM03.01','0',NULL,NULL,0,NULL,NULL),(920,2013,5,'022.12','SSSDM.03','IKUSSSDM03.02','0',NULL,NULL,0,NULL,NULL),(921,2013,5,'022.12','SSSDM.04','IKUSSSDM04.01','0',NULL,NULL,0,NULL,NULL),(922,2013,5,'022.12','SSSDM.04','IKUSSSDM04.02','0',NULL,NULL,0,NULL,NULL),(923,2013,5,'022.12','SSSDM.04','IKUSSSDM04.03','0',NULL,NULL,0,NULL,NULL),(924,2013,5,'022.12','SSSDM.05','IKUSSSDM05.01','0',NULL,NULL,0,NULL,NULL),(925,2013,5,'022.12','SSSDM.06','IKUSSSDM06.01','6',NULL,NULL,28.58,NULL,NULL),(926,2013,5,'022.12','SSSDM.07','IKUSSSDM07.01','0',NULL,NULL,0,NULL,NULL),(927,2013,5,'022.12','SSSDM.07','IKUSSSDM07.02','16.82',NULL,NULL,18.28,NULL,NULL),(928,2013,5,'022.12','SSSDM.07','IKUSSSDM07.03','8.90E+12',NULL,NULL,87.57,NULL,NULL),(929,2013,5,'022.12','SSSDM.08','IKUSSSDM08.01','9',NULL,NULL,45,NULL,NULL),(930,2013,5,'022.12','SSSDM.09','IKUSSSDM09.01','0',NULL,NULL,0,NULL,NULL),(931,2013,5,'022.12','SSSDM.09','IKUSSSDM09.02','0',NULL,NULL,0,NULL,NULL),(932,2013,5,'022.12','SSSDM.10','IKUSSSDM10.01','2578',NULL,NULL,102.39,NULL,NULL),(933,2012,11,'022.11','SSPP.01','IKUSSPP01.01','20','8;2013-07-20 13:27:17',NULL,NULL,'keterangan','action plan'),(934,2012,11,'022.11','SSPP.01','IKUSSPP01.02','100','8;2013-07-20 13:27:17',NULL,NULL,'keterangan  Jumlah penelitian yang dipublikasikan pada jurnal atau buletin yang terakreditasi','action plan  Jumlah penelitian yang dipublikasikan pada jurnal atau buletin yang terakreditasi');
/*!40000 ALTER TABLE `tbl_kinerja_eselon1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_kinerja_eselon1_log`
--

DROP TABLE IF EXISTS `tbl_kinerja_eselon1_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_kinerja_eselon1_log` (
  `id_kinerja_e1` int(11) NOT NULL AUTO_INCREMENT,
  `tahun` year(4) DEFAULT NULL,
  `triwulan` int(11) DEFAULT NULL,
  `kode_e1` varchar(10) DEFAULT NULL,
  `kode_sasaran_e1` varchar(20) DEFAULT NULL,
  `kode_iku_e1` varchar(20) DEFAULT NULL,
  `realisasi` varchar(20) DEFAULT NULL,
  `log` varchar(30) DEFAULT NULL,
  `realisasi_persen` float DEFAULT NULL,
  `keterangan` varchar(150) DEFAULT NULL,
  `action_plan` text,
  PRIMARY KEY (`id_kinerja_e1`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_kinerja_eselon1_log`
--

LOCK TABLES `tbl_kinerja_eselon1_log` WRITE;
/*!40000 ALTER TABLE `tbl_kinerja_eselon1_log` DISABLE KEYS */;
INSERT INTO `tbl_kinerja_eselon1_log` VALUES (1,2012,11,'022.11','SSPP.01','IKUSSPP01.01','20','INSERT;8;2013-07-20 13:27:17',NULL,'keterangan','action plan'),(2,2012,11,'022.11','SSPP.01','IKUSSPP01.02','100','INSERT;8;2013-07-20 13:27:17',NULL,'keterangan  Jumlah penelitian yang dipublikasikan pada jurnal atau buletin yang terakreditasi','action plan  Jumlah penelitian yang dipublikasikan pada jurnal atau buletin yang terakreditasi'),(3,2013,3,'022.02','SSIJ.01','IKUSSIJ01.01','0','UPDATE;8;2013-07-25 10:28:19',NULL,'Keterangan','Action Plan');
/*!40000 ALTER TABLE `tbl_kinerja_eselon1_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_kinerja_eselon2`
--

DROP TABLE IF EXISTS `tbl_kinerja_eselon2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_kinerja_eselon2` (
  `id_kinerja_e2` int(11) NOT NULL AUTO_INCREMENT,
  `kode_e2` varchar(10) DEFAULT NULL,
  `tahun` year(4) NOT NULL,
  `triwulan` int(11) NOT NULL,
  `kode_sasaran_e2` varchar(20) NOT NULL,
  `kode_ikk` varchar(20) NOT NULL,
  `realisasi` varchar(20) NOT NULL,
  `log_insert` varchar(50) DEFAULT NULL,
  `log_update` varchar(50) DEFAULT NULL,
  `realisasi_persen` float DEFAULT NULL,
  `keterangan` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_kinerja_e2`),
  KEY `FK_tbl_kinerja_eselon2_sasaran` (`kode_sasaran_e2`),
  KEY `FK_tbl_kinerja_eselon2_ikk` (`kode_ikk`),
  KEY `FK_tbl_kinerja_eselon2_e2` (`kode_e2`),
  CONSTRAINT `tbl_kinerja_eselon2_ibfk_2` FOREIGN KEY (`kode_sasaran_e2`) REFERENCES `tbl_sasaran_eselon2` (`kode_sasaran_e2`) ON UPDATE CASCADE,
  CONSTRAINT `tbl_kinerja_eselon2_ibfk_3` FOREIGN KEY (`kode_ikk`) REFERENCES `tbl_ikk` (`kode_ikk`) ON UPDATE CASCADE,
  CONSTRAINT `tbl_kinerja_eselon2_ibfk_4` FOREIGN KEY (`kode_e2`) REFERENCES `tbl_eselon2` (`kode_e2`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_kinerja_eselon2`
--

LOCK TABLES `tbl_kinerja_eselon2` WRITE;
/*!40000 ALTER TABLE `tbl_kinerja_eselon2` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_kinerja_eselon2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_kinerja_eselon2_log`
--

DROP TABLE IF EXISTS `tbl_kinerja_eselon2_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_kinerja_eselon2_log` (
  `id_kinerja_e2` int(11) NOT NULL AUTO_INCREMENT,
  `kode_e2` varchar(10) DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `triwulan` int(11) DEFAULT NULL,
  `kode_sasaran_e2` varchar(20) DEFAULT NULL,
  `kode_ikk` varchar(20) DEFAULT NULL,
  `realisasi` varchar(20) DEFAULT NULL,
  `log` varchar(30) DEFAULT NULL,
  `realisasi_persen` float DEFAULT NULL,
  `keterangan` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_kinerja_e2`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_kinerja_eselon2_log`
--

LOCK TABLES `tbl_kinerja_eselon2_log` WRITE;
/*!40000 ALTER TABLE `tbl_kinerja_eselon2_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_kinerja_eselon2_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_kinerja_kl`
--

DROP TABLE IF EXISTS `tbl_kinerja_kl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_kinerja_kl` (
  `id_kinerja_kl` int(11) NOT NULL AUTO_INCREMENT,
  `tahun` year(4) NOT NULL,
  `triwulan` int(11) NOT NULL,
  `kode_kl` varchar(10) NOT NULL,
  `kode_sasaran_kl` varchar(20) NOT NULL,
  `kode_iku_kl` varchar(20) NOT NULL,
  `realisasi` varchar(20) NOT NULL,
  `log_insert` varchar(50) DEFAULT NULL,
  `log_update` varchar(50) DEFAULT NULL,
  `realisasi_persen` float DEFAULT NULL,
  `keterangan` varchar(150) DEFAULT NULL,
  `action_plan` text,
  PRIMARY KEY (`id_kinerja_kl`),
  KEY `FK_tbl_kinerja_kl` (`kode_kl`),
  KEY `FK_tbl_kinerja_kl_sasaran` (`kode_sasaran_kl`),
  KEY `FK_tbl_kinerja_kl_iku` (`kode_iku_kl`),
  CONSTRAINT `tbl_kinerja_kl_ibfk_1` FOREIGN KEY (`kode_kl`) REFERENCES `tbl_kl` (`kode_kl`) ON UPDATE CASCADE,
  CONSTRAINT `tbl_kinerja_kl_ibfk_2` FOREIGN KEY (`kode_sasaran_kl`) REFERENCES `tbl_sasaran_kl` (`kode_sasaran_kl`) ON UPDATE CASCADE,
  CONSTRAINT `tbl_kinerja_kl_ibfk_3` FOREIGN KEY (`kode_iku_kl`) REFERENCES `tbl_iku_kl` (`kode_iku_kl`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_kinerja_kl`
--

LOCK TABLES `tbl_kinerja_kl` WRITE;
/*!40000 ALTER TABLE `tbl_kinerja_kl` DISABLE KEYS */;
INSERT INTO `tbl_kinerja_kl` VALUES (1,2012,12,'022','SSKP.01','IKUSSKP01.01','5356',NULL,NULL,91.73,'Menurun',NULL),(2,2012,12,'022','SSKP.02','IKUSSKP02.01','6',NULL,NULL,133.33,'Meningkat',NULL),(3,2012,12,'022','SSKP.03','IKUSSKP03.01','72.24',NULL,NULL,99.29,'Menurun',NULL),(4,2012,12,'022','SSKP.04','IKUSSKP04.01','13619',NULL,NULL,124.02,'Meningkat',NULL),(5,2012,12,'022','SSKP.04','IKUSSKP04.02','13',NULL,NULL,40.63,'Menurun',NULL),(6,2012,12,'022','SSKP.05','IKUSSKP05.01','583',NULL,NULL,100.69,'Meningkat',NULL),(7,2012,12,'022','SSKP.06','IKUSSKP06.01','1.15',NULL,NULL,76.67,'Menurun',NULL),(8,2012,12,'022','SSKP.07','IKUSSKP07.01','830785753',NULL,NULL,99.2,'Menurun',NULL),(9,2012,12,'022','SSKP.07','IKUSSKP07.02','374726641',NULL,NULL,89.8,'Menurun',NULL),(10,2012,12,'022','SSKP.08','IKUSSKP08.01','3',NULL,NULL,150,'Meningkat',NULL),(11,2012,12,'022','SSKP.09','IKUSSKP09.01','B',NULL,NULL,133.33,'Meningkat',NULL),(12,2012,12,'022','SSKP.09','IKUSSKP09.02','WDP',NULL,NULL,80,'Menurun',NULL),(13,2012,12,'022','SSKP.09','IKUSSKP09.03','162761231073098',NULL,NULL,130.45,'Meningkat',NULL),(14,2012,12,'022','SSKP.10','IKUSSKP10.01','58175',NULL,NULL,103.15,'Meningkat',NULL),(15,2012,12,'022','SSKP.10','IKUSSKP10.02','3637',NULL,NULL,161.72,'Meningkat',NULL),(16,2012,12,'022','SSKP.10','IKUSSKP10.03','162364',NULL,NULL,108.81,'Meningkat',NULL),(17,2012,12,'022','SSKP.11','IKUSSKP11.01','65',NULL,NULL,118.18,'Meningkat',NULL),(18,2012,12,'022','SSKP.12','IKUSSKP12.01','3758.48',NULL,NULL,100.2,'Meningkat',NULL),(19,2012,12,'022','SSKP.12','IKUSSKP12.02','88691.33',NULL,NULL,100.98,'Meningkat',NULL),(20,2012,12,'022','SSKP.13','IKUSSKP13.01','2946',NULL,NULL,96.53,'Menurun',NULL),(21,2012,12,'022','SSKP.13','IKUSSKP13.02','53',NULL,NULL,100,'Tetap',NULL),(22,2013,1,'022','SSKP.01','IKUSSKP01.01','11','8;2013-07-20 13:28:10','8;2013-08-16 14:36:55',NULL,'tes','tes'),(23,2012,1,'022','SSKP.01','IKUSSKP01.01','1000','8;2013-08-16 14:34:51',NULL,NULL,'','');
/*!40000 ALTER TABLE `tbl_kinerja_kl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_kinerja_kl_log`
--

DROP TABLE IF EXISTS `tbl_kinerja_kl_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_kinerja_kl_log` (
  `id_kinerja_kl` int(11) NOT NULL AUTO_INCREMENT,
  `tahun` year(4) DEFAULT NULL,
  `triwulan` int(11) DEFAULT NULL,
  `kode_kl` varchar(10) DEFAULT NULL,
  `kode_sasaran_kl` varchar(20) DEFAULT NULL,
  `kode_iku_kl` varchar(20) DEFAULT NULL,
  `realisasi` varchar(20) DEFAULT NULL,
  `log` varchar(30) DEFAULT NULL,
  `realisasi_persen` float DEFAULT NULL,
  `keterangan` varchar(150) DEFAULT NULL,
  `action_plan` text,
  PRIMARY KEY (`id_kinerja_kl`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_kinerja_kl_log`
--

LOCK TABLES `tbl_kinerja_kl_log` WRITE;
/*!40000 ALTER TABLE `tbl_kinerja_kl_log` DISABLE KEYS */;
INSERT INTO `tbl_kinerja_kl_log` VALUES (1,2013,1,'022','SSKP.01','IKUSSKP01.01','1000','INSERT;8;2013-07-20 13:28:10',NULL,'ketarngan ','action plan'),(2,2013,1,'022','SSKP.01','IKUSSKP01.01','1000','UPDATE;8;2013-07-25 10:23:37',NULL,NULL,NULL),(3,2013,1,'022','SSKP.01','IKUSSKP01.01','1000','UPDATE;8;2013-07-25 10:25:04',NULL,NULL,NULL),(4,2013,1,'022','SSKP.01','IKUSSKP01.01','1000','UPDATE;8;2013-07-25 10:26:16',NULL,'Keterangan','Action Plan'),(5,2012,1,'022','SSKP.01','IKUSSKP01.01','1000','INSERT;8;2013-08-16 14:34:51',NULL,'',''),(6,2013,1,'022','SSKP.01','IKUSSKP01.01','11','UPDATE;8;2013-08-16 14:36:55',NULL,'tes','tes');
/*!40000 ALTER TABLE `tbl_kinerja_kl_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_kl`
--

DROP TABLE IF EXISTS `tbl_kl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_kl` (
  `kode_kl` varchar(10) NOT NULL,
  `nama_kl` varchar(50) NOT NULL,
  `singkatan` varchar(30) NOT NULL,
  `nama_menteri` varchar(50) NOT NULL,
  `log_insert` varchar(50) DEFAULT NULL,
  `log_update` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`kode_kl`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_kl`
--

LOCK TABLES `tbl_kl` WRITE;
/*!40000 ALTER TABLE `tbl_kl` DISABLE KEYS */;
INSERT INTO `tbl_kl` VALUES ('022','Kementerian Perhubungan','Kemenhub','E.E. Mangindaan',NULL,NULL);
/*!40000 ALTER TABLE `tbl_kl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_masterpk_eselon1`
--

DROP TABLE IF EXISTS `tbl_masterpk_eselon1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_masterpk_eselon1` (
  `id_masterpk_e1` int(11) NOT NULL AUTO_INCREMENT,
  `tahun` year(4) NOT NULL,
  `kode_e1` varchar(10) NOT NULL,
  `kode_program` varchar(20) NOT NULL,
  `log_insert` varchar(50) DEFAULT NULL,
  `log_update` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_masterpk_e1`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_masterpk_eselon1`
--

LOCK TABLES `tbl_masterpk_eselon1` WRITE;
/*!40000 ALTER TABLE `tbl_masterpk_eselon1` DISABLE KEYS */;
INSERT INTO `tbl_masterpk_eselon1` VALUES (1,2012,'022.01','022.01.01',NULL,NULL),(2,2012,'022.02','022.02.03',NULL,NULL),(3,2012,'022.03','022.03.06',NULL,NULL),(4,2012,'022.04','022.04.08',NULL,NULL),(5,2012,'022.05','022.05.09',NULL,NULL),(6,2012,'022.08','022.08.07',NULL,NULL),(7,2012,'022.11','022.11.04',NULL,NULL),(8,2012,'022.12','022.12.05',NULL,NULL),(9,2013,'022.01','022.01.01',NULL,NULL),(10,2013,'022.02','022.02.03',NULL,NULL),(11,2013,'022.03','022.03.06',NULL,NULL),(12,2013,'022.04','022.04.08',NULL,NULL),(13,2013,'022.05','022.05.09',NULL,NULL),(14,2013,'022.08','022.08.07',NULL,NULL),(15,2013,'022.11','022.11.04',NULL,NULL),(16,2013,'022.12','022.12.05',NULL,NULL);
/*!40000 ALTER TABLE `tbl_masterpk_eselon1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_masterpk_eselon2`
--

DROP TABLE IF EXISTS `tbl_masterpk_eselon2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_masterpk_eselon2` (
  `id_masterpk_e2` int(11) NOT NULL AUTO_INCREMENT,
  `tahun` year(4) NOT NULL,
  `kode_e2` varchar(10) NOT NULL,
  `kode_kegiatan` varchar(20) NOT NULL,
  `log_insert` varchar(50) DEFAULT NULL,
  `log_update` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_masterpk_e2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_masterpk_eselon2`
--

LOCK TABLES `tbl_masterpk_eselon2` WRITE;
/*!40000 ALTER TABLE `tbl_masterpk_eselon2` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_masterpk_eselon2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_masterpk_kl`
--

DROP TABLE IF EXISTS `tbl_masterpk_kl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_masterpk_kl` (
  `id_masterpk_kl` int(11) NOT NULL AUTO_INCREMENT,
  `tahun` year(4) NOT NULL,
  `kode_kl` varchar(10) NOT NULL,
  `kode_program` varchar(20) NOT NULL,
  `log_insert` varchar(50) DEFAULT NULL,
  `log_update` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_masterpk_kl`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_masterpk_kl`
--

LOCK TABLES `tbl_masterpk_kl` WRITE;
/*!40000 ALTER TABLE `tbl_masterpk_kl` DISABLE KEYS */;
INSERT INTO `tbl_masterpk_kl` VALUES (1,2012,'022','022.01.01',NULL,NULL),(2,2012,'022','022.02.03',NULL,NULL),(3,2012,'022','022.03.06',NULL,NULL),(4,2012,'022','022.04.08',NULL,NULL),(5,2012,'022','022.05.09',NULL,NULL),(6,2012,'022','022.08.07',NULL,NULL),(7,2012,'022','022.11.04',NULL,NULL),(8,2012,'022','022.12.05',NULL,NULL),(9,2013,'022','022.01.01',NULL,NULL),(10,2013,'022','022.02.03',NULL,NULL),(11,2013,'022','022.03.06',NULL,NULL),(12,2013,'022','022.04.08',NULL,NULL),(13,2013,'022','022.05.09',NULL,NULL),(14,2013,'022','022.08.07',NULL,NULL),(15,2013,'022','022.11.04',NULL,NULL),(16,2013,'022','022.12.05',NULL,NULL);
/*!40000 ALTER TABLE `tbl_masterpk_kl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_menu`
--

DROP TABLE IF EXISTS `tbl_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_menu` (
  `menu_id` smallint(6) NOT NULL DEFAULT '0',
  `menu_group` varchar(30) DEFAULT NULL,
  `menu_name` varchar(50) DEFAULT NULL,
  `menu_parent` smallint(6) DEFAULT NULL,
  `app_types` varchar(50) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `hide` smallint(6) DEFAULT NULL,
  `imported` smallint(6) DEFAULT '1',
  `policy` varchar(50) DEFAULT '',
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_menu`
--

LOCK TABLES `tbl_menu` WRITE;
/*!40000 ALTER TABLE `tbl_menu` DISABLE KEYS */;
INSERT INTO `tbl_menu` VALUES (1,'RUJUKAN','Data Rujukan',NULL,'KL;E1;E2','#',0,1,''),(2,'RUJUKAN','Kementerian',1,'KL;E1;E2','rujukan/kl',0,1,'ADD;EDIT;VIEW;PRINT;EXCEL;AUTOTAB;'),(3,'RUJUKAN','Eselon I',1,'KL;E1;E2','rujukan/eselon1',0,1,'ADD;EDIT;VIEW;PRINT;EXCEL;AUTOTAB;'),(4,'RUJUKAN','Eselon II',1,'KL;E1;E2','rujukan/eselon2',0,1,'ADD;EDIT;VIEW;PRINT;EXCEL;AUTOTAB;'),(5,'RUJUKAN','Satuan Kerja',1,'KL;E1;E2','rujukan/satker',1,0,'ADD;EDIT;VIEW;PRINT;EXCEL;AUTOTAB;'),(6,'RUJUKAN','Program',1,'KL;E1;E2','rujukan/programkl',0,1,'ADD;EDIT;VIEW;PRINT;EXCEL;AUTOTAB;'),(7,'RUJUKAN','Kegiatan',1,'KL;E1;E2','rujukan/kegiatankl',0,1,'ADD;EDIT;VIEW;PRINT;EXCEL;AUTOTAB;'),(8,'RUJUKAN','Sub Kegiatan',1,'KL;E1;E2','rujukan/subkegiatankl',1,0,'ADD;EDIT;VIEW;PRINT;EXCEL;AUTOTAB;'),(30,'PENGATURAN','Pengaturan Data',NULL,'KL;E1;E2;','#',0,0,''),(31,'PENGATURAN','Sasaran Strategis',30,'KL;','pengaturan/sasaran_strategis',0,0,'ADD;EDIT;VIEW;PRINT;EXCEL;IMPORT;AUTOTAB;'),(32,'PENGATURAN','Sasaran Eselon I',30,'KL;E1;','pengaturan/sasaran_eselon1',0,0,'ADD;EDIT;VIEW;PRINT;EXCEL;IMPORT;AUTOTAB;'),(33,'PENGATURAN','Sasaran Eselon II',30,'E1;E2;','pengaturan/sasaran_eselon2',0,0,'ADD;EDIT;VIEW;PRINT;EXCEL;IMPORT;AUTOTAB;'),(34,'PENGATURAN','Indikator Kinerja Utama Kementerian',30,'KL;','pengaturan/iku_kl',0,0,'ADD;EDIT;VIEW;PRINT;EXCEL;IMPORT;AUTOTAB;'),(35,'PENGATURAN','Indikator Kinerja Utama Eselon I',30,'KL;E1;','pengaturan/iku_e1',0,0,'ADD;EDIT;VIEW;PRINT;EXCEL;IMPORT;AUTOTAB;'),(36,'PENGATURAN','Indikator Kinerja Kegiatan',30,'E1;E2;','pengaturan/ikk',0,0,'ADD;EDIT;VIEW;PRINT;EXCEL;IMPORT;AUTOTAB;'),(37,'PENGATURAN','Sasaran Program/Kegiatan',30,'E1;','pengaturan/sasaran_program',1,0,'ADD;EDIT;VIEW;PRINT;EXCEL;AUTOTAB;'),(50,'RKT','Rencana Kinerja Tahunan (RKT)',NULL,'KL;E1;E2;','#',0,0,''),(51,'RKT','RKT Kementerian',50,'KL;','rencana/rktkl',0,0,'ADD;EDIT;VIEW;PRINT;EXCEL;DELETE;AUTOTAB;'),(52,'RKT','RKT Eselon I',50,'KL;E1;','rencana/rkteselon1',0,0,'ADD;EDIT;VIEW;PRINT;EXCEL;DELETE;AUTOTAB;'),(53,'RKT','RKT Eselon II',50,'E1;E2;','rencana/rkteselon2',0,0,'ADD;EDIT;VIEW;PRINT;EXCEL;DELETE;AUTOTAB;'),(100,'PENETAPAN','Penetapan Kinerja (PK)',NULL,'KL;E1;E2;','#',0,0,''),(101,'PENETAPAN','Kementerian',100,'KL;','#',0,0,'ADD;EDIT;VIEW;PRINT;EXCEL;DELETE;'),(102,'PENETAPAN','PK Kementerian',101,'KL;','penetapan/penetapankl',0,0,'ADD;EDIT;VIEW;PRINT;EXCEL;DELETE;AUTOTAB;'),(103,'PENETAPAN','Pengesahan PK Kementerian',101,'KL;','penetapan/pengesahan_penetapankl',0,0,'ADD;EDIT;VIEW;PRINT;EXCEL;DELETE;AUTOTAB;'),(104,'PENETAPAN','Eselon I',100,'KL;E1;','#',0,0,'ADD;EDIT;VIEW;PRINT;EXCEL;DELETE;'),(105,'PENETAPAN','PK Eselon I',104,'KL;E1;','penetapan/penetapaneselon1',0,0,'ADD;EDIT;VIEW;PRINT;EXCEL;DELETE;AUTOTAB;'),(106,'PENETAPAN','Pengesahan PK Eselon 1',104,'E1;','penetapan/pengesahan_penetapaneselon1',0,0,'ADD;EDIT;VIEW;PRINT;EXCEL;DELETE;AUTOTAB;'),(107,'PENETAPAN','Eselon II',100,'E1;E2;','#',0,0,'ADD;EDIT;VIEW;PRINT;EXCEL;DELETE;'),(108,'PENETAPAN','PK Eselon II',107,'E1;E2;','penetapan/penetapaneselon2',0,0,'ADD;EDIT;VIEW;PRINT;EXCEL;DELETE;AUTOTAB;'),(109,'PENETAPAN','Pengesahan PK Eselon 2',107,'E2;','penetapan/pengesahan_penetapaneselon2',0,0,'ADD;EDIT;VIEW;PRINT;EXCEL;DELETE;AUTOTAB;'),(120,'CHECKPOINT','Checkpoint',NULL,'KL;E1;E2','#',0,0,''),(121,'CHECKPOINT','Kementerian',120,'KL;','#',0,0,'ADD;EDIT;VIEW;PRINT;EXCEL;DELETE;'),(122,'CHECKPOINT','Rencana Checkpoint KL',121,'KL;','checkpoint/checkpointkl',0,0,'ADD;EDIT;VIEW;PRINT;EXCEL;DELETE;AUTOTAB;'),(123,'CHECKPOINT','Capaian Checkpoint KL',121,'KL;','checkpoint/checkpointkl/capaian',0,0,'ADD;EDIT;VIEW;PRINT;EXCEL;DELETE;AUTOTAB;'),(124,'CHECKPOINT','Eselon I',120,'E1;','#',0,0,'ADD;EDIT;VIEW;PRINT;EXCEL;DELETE;'),(125,'CHECKPOINT','Rencana Checkpoint Eselon I',124,'E1;','checkpoint/checkpointe1',0,0,'ADD;EDIT;VIEW;PRINT;EXCEL;DELETE;AUTOTAB;'),(126,'CHECKPOINT','Capaian Checkpoint Eselon I',124,'E1;','checkpoint/checkpointe1/capaian',0,0,'ADD;EDIT;VIEW;PRINT;EXCEL;DELETE;AUTOTAB;'),(127,'CHECKPOINT','Monitoring KL',121,'KL;','checkpoint/monitoring_kl',0,0,'VIEW;AUTOTAB;'),(128,'CHECKPOINT','Monitoring Eselon I',124,'E1;','checkpoint/monitoring_e1',0,0,'VIEW;AUTOTAB;'),(150,'REALISASI','Capaian Kinerja',NULL,'KL;E1;E2;','#',0,0,''),(151,'REALISASI','Capaian Kinerja Kementerian',150,'KL;','realisasi/rskl',0,0,'ADD;EDIT;VIEW;PRINT;EXCEL;DELETE;AUTOTAB;'),(152,'REALISASI','Capaian Kinerja Eselon I',150,'KL;E1;','realisasi/rseselon1',0,0,'ADD;EDIT;VIEW;PRINT;EXCEL;DELETE;AUTOTAB;'),(153,'REALISASI','Capaian Kinerja Eselon II',150,'E1;E2;','realisasi/rseselon2',0,0,'ADD;EDIT;VIEW;PRINT;EXCEL;DELETE;AUTOTAB;'),(200,'PENGUKURAN','Pengukuran Kinerja',NULL,'KL;E1;E2;','#',0,0,''),(201,'PENGUKURAN','Kinerja Kementerian',200,'KL;','pengukuran/pengukurankl',0,0,'ADD;EDIT;VIEW;PRINT;EXCEL;DELETE;AUTOTAB;'),(202,'PENGUKURAN','Kinerja Eselon I',200,'KL;E1;','pengukuran/pengukuraneselon1',0,0,'ADD;EDIT;VIEW;PRINT;EXCEL;DELETE;AUTOTAB;'),(203,'PENGUKURAN','Kinerja Eselon II',200,'E1;E2;','pengukuran/pengukuraneselon2',0,0,'ADD;EDIT;VIEW;PRINT;EXCEL;DELETE;AUTOTAB;'),(250,'REPORT','Laporan',NULL,'KL;E1;E2;','#',0,0,''),(251,'REPORT','Rencana Kinerja Tahunan',250,'KL;E1;E2;','#',0,0,''),(252,'REPORT','Lap. RKT Kementerian',251,'KL;','rencana/rpt_rktkl',0,0,'VIEW;PRINT;EXCEL;AUTOTAB;'),(253,'REPORT','Lap. RKT Eselon I',251,'KL;E1;','rencana/rpt_rkteselon1',0,0,'VIEW;PRINT;EXCEL;AUTOTAB;'),(254,'REPORT','Lap. RKT Eselon II',251,'E1;E2;','rencana/rpt_rkteselon2',0,0,'VIEW;PRINT;EXCEL;AUTOTAB;'),(255,'REPORT','Penetapan Kinerja',250,'KL;E1;E2;','#',0,0,''),(256,'REPORT','Lap. PK Kementerian',255,'KL;','penetapan/rpt_penetapankl',0,0,'VIEW;PRINT;EXCEL;AUTOTAB;'),(257,'REPORT','Lap. PK Eselon I',255,'KL;E1;','penetapan/rpt_penetapaneselon1',0,0,'VIEW;PRINT;EXCEL;AUTOTAB;'),(258,'REPORT','Lap. PK Eselon II',255,'E1;E2;','penetapan/rpt_penetapaneselon2',0,0,'VIEW;PRINT;EXCEL;AUTOTAB;'),(260,'REPORT','Sebaran Indikator',250,'KL;E1;E2;','#',1,0,''),(261,'REPORT','Sebaran IKU Kementerian',260,'KL;','realisasi/rpt_akuntabilitaskl',1,0,'VIEW;PRINT;EXCEL;AUTOTAB;'),(262,'REPORT','Sebaran IKU Eselon I',260,'KL;E1;','realisasi/rpt_akuntabilitase1',1,0,'VIEW;PRINT;EXCEL;AUTOTAB;'),(263,'REPORT','Sebaran IKK Eselon II',260,'E1;E2;','realisasi/rpt_akuntabilitase2',1,0,'VIEW;PRINT;EXCEL;AUTOTAB;'),(265,'REPORT','Realisasi Capaian Kinerja',250,'KL;E1;E2;','#',0,0,''),(266,'REPORT','Capaian Kinerja Kementerian',265,'KL;','realisasi/rpt_capaian_kinerjakl',0,0,'VIEW;PRINT;EXCEL;AUTOTAB;'),(267,'REPORT','Capaian Kinerja Eselon I',265,'KL;E1;','realisasi/rpt_capaian_kinerjae1',0,0,'VIEW;PRINT;EXCEL;AUTOTAB;'),(268,'REPORT','Capaian Kinerja Eselon II',265,'E1;E2;','realisasi/rpt_capaian_kinerjae2',0,0,'VIEW;PRINT;EXCEL;AUTOTAB;'),(270,'REPORT','Pengukuran Kinerja',250,'KL;E1;E2;','#',0,0,''),(271,'REPORT','Pengukuran Kinerja Kementerian',270,'KL;','pengukuran/rpt_pengukurankl',0,0,'VIEW;PRINT;EXCEL;AUTOTAB;'),(272,'REPORT','Pengukuran Kinerja Eselon I',270,'KL;E1;','pengukuran/rpt_pengukurane1',0,0,'VIEW;PRINT;EXCEL;AUTOTAB;'),(273,'REPORT','Pengukuran Kinerja Eselon II',270,'E1;E2;','pengukuran/rpt_pengukurane2',0,0,'VIEW;PRINT;EXCEL;AUTOTAB;'),(274,'REPORT','Status Pengumpulan Data Kinerja',250,'KL;E1;E2;','pengukuran/rpt_status_pengumpulan',0,0,'VIEW;PRINT;EXCEL;AUTOTAB;'),(290,'DASHBOARD','Dashboard',NULL,'KL;E1;E2;','#',0,0,''),(291,'DASHBOARD','Dashboard Kementerian',290,'KL;','dashboard/dsb_kl',0,0,'VIEW;AUTOTAB;'),(292,'DASHBOARD','Dashboard Eselon I',290,'E1;','dashboard/dsb_e1',0,0,'VIEW;AUTOTAB;'),(293,'DASHBOARD','Capaian IKU Kementerian',290,'KL;','dashboard/dsb_capaian_kl',0,0,'VIEW;AUTOTAB;'),(294,'DASHBOARD','Capaian IKU Eselon I',290,'E1;','dashboard/dsb_capaian_e1',0,0,'VIEW;AUTOTAB;'),(300,'ADMIN','Admin',NULL,'KL;E1;E2;','#',0,0,''),(301,'ADMIN','Grup Pengguna',300,'KL;E1;E2;','admin/group_user',1,0,'ADD;EDIT;VIEW;PRINT;AUTOTAB;'),(302,'ADMIN','Pengguna',300,'KL;E1;E2;','admin/user',0,0,'ADD;EDIT;VIEW;PRINT;AUTOTAB;'),(303,'ADMIN','Hak Pengguna',300,'KL;E1;E2;','admin/group_access',0,0,'EDIT;AUTOTAB;'),(350,'UTILITY','Utility',NULL,'KL;E1;E2;','#',0,0,''),(351,'UTILITY','Backup Data Kinerja',350,'KL;E1;E2;','utility/backup_restore/backupView',0,0,'PROSES;AUTOTAB;'),(352,'UTILITY','Load Data Kinerja',350,'KL;E1;E2;','utility/backup_restore/restoreView',0,0,'PROSES;AUTOTAB;'),(353,'UTILITY','Import Data Rujukan',350,'KL;E1;E2;','utility/import',0,0,'PROSES;AUTOTAB;'),(354,'UTILITY','Export Data Kinerja',350,'KL;E1;E2;','underconstruction',1,0,'PROSES;AUTOTAB;'),(355,'UTILITY','System Log',350,'KL;E1;E2','#',0,0,''),(356,'UTILITY','Pengaturan Data',355,'KL;E1;E2','utility/histori_pengaturan',0,0,'VIEW;PRINT;AUTOTAB;'),(357,'UTILITY','Rencana Kinerja',355,'KL;E1;E2','utility/histori_rencana',0,0,'VIEW;PRINT;AUTOTAB;'),(358,'UTILITY','Penetapan Kinerja',355,'KL;E1;E2','underconstruction',1,0,'VIEW;PRINT;AUTOTAB;'),(359,'UTILITY','Realisasi Kinerja',355,'KL;E1;E2','utility/histori_realisasi',0,0,'VIEW;PRINT;AUTOTAB;'),(360,'UTILITY','Pengukuran Kinerja',355,'KL;E1;E2','underconstruction',1,0,'VIEW;PRINT;AUTOTAB;'),(400,'PORTAL','Manajemen Website',NULL,'KL:E1:E2','#',0,0,''),(401,'PORTAL','Filter Dashboard',400,'KL:E1:E2','portal/content/1',0,0,'VIEW;EDIT;AUTOTAB;'),(402,'PORTAL','Berita Kinerja',403,'KL:E1:E2','portal/content/2',0,0,'VIEW;ADD;EDIT;DELETE;AUTOTAB;'),(403,'PORTAL','Informasi',400,'KL:E1:E2','#',0,0,'VIEW;ADD;EDIT;DELETE;'),(404,'PORTAL','About',403,'KL:E1:E2','portal/content/3',0,0,'VIEW;EDIT;AUTOTAB;'),(405,'PORTAL','AKIP',403,'KL:E1:E2','portal/content/4',0,0,'VIEW;ADD;EDIT;DELETE;AUTOTAB;'),(406,'PORTAL','Regulasi',403,'KL:E1:E2','portal/content/5',0,0,'VIEW;ADD;EDIT;DELETE;AUTOTAB;'),(407,'PORTAL','FAQ',403,'KL:E1:E2','portal/content/6',0,0,'VIEW;ADD;EDIT;DELETE;AUTOTAB;'),(408,'PORTAL','Kontak',403,'KL:E1:E2','portal/content/7',0,0,'VIEW;EDIT;AUTOTAB;'),(409,'PORTAL','Link Terkait',400,'KL:E1:E2','portal/content/8',0,0,'VIEW;ADD;EDIT;DELETE;AUTOTAB;');
/*!40000 ALTER TABLE `tbl_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_pengukuran_eselon1`
--

DROP TABLE IF EXISTS `tbl_pengukuran_eselon1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_pengukuran_eselon1` (
  `id_pengukuran_e1` int(11) NOT NULL AUTO_INCREMENT,
  `tahun` year(4) NOT NULL,
  `triwulan` int(11) NOT NULL,
  `kode_e1` varchar(10) NOT NULL,
  `kode_sasaran_e1` varchar(20) NOT NULL,
  `kode_iku_e1` varchar(20) NOT NULL,
  `realisasi` varchar(20) NOT NULL,
  `persen` double NOT NULL,
  `opini` varchar(255) NOT NULL,
  `persetujuan` tinyint(4) NOT NULL,
  `log_insert` varchar(50) DEFAULT NULL,
  `log_update` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_pengukuran_e1`)
) ENGINE=InnoDB AUTO_INCREMENT=175 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_pengukuran_eselon1`
--

LOCK TABLES `tbl_pengukuran_eselon1` WRITE;
/*!40000 ALTER TABLE `tbl_pengukuran_eselon1` DISABLE KEYS */;
INSERT INTO `tbl_pengukuran_eselon1` VALUES (1,2012,12,'022.01','SSSJ.01','IKUSSSJ01.01','B',113.55,'  ',1,NULL,NULL),(2,2012,12,'022.01','SSSJ.01','IKUSSSJ01.02','AA',113.52,'  ',1,NULL,NULL),(3,2012,12,'022.01','SSSJ.02','IKUSSSJ02.01','85',106.25,'  ',1,NULL,NULL),(4,2012,12,'022.01','SSSJ.03','IKUSSSJ03.01','251',418.33,'  ',1,NULL,NULL),(5,2012,12,'022.01','SSSJ.03','IKUSSSJ03.02','1318',610.19,'  ',1,NULL,NULL),(6,2012,12,'022.01','SSSJ.04','IKUSSSJ04.01','15',68.18,'  ',1,NULL,NULL),(7,2012,12,'022.01','SSSJ.05','IKUSSSJ05.01','8689894992',147.41,'  ',1,NULL,NULL),(8,2012,12,'022.01','SSSJ.05','IKUSSSJ05.02','94.74',94.74,'  ',1,NULL,NULL),(9,2012,12,'022.01','SSSJ.06','IKUSSSJ06.01','313',112.19,'  ',1,NULL,NULL),(10,2012,12,'022.01','SSSJ.06','IKUSSSJ06.02','7',100,'  ',1,NULL,NULL),(11,2012,12,'022.01','SSSJ.06','IKUSSSJ06.03','14',127.27,'  ',1,NULL,NULL),(12,2012,12,'022.01','SSSJ.07','IKUSSSJ07.01','12',133.33,'  ',1,NULL,NULL),(13,2012,12,'022.01','SSSJ.07','IKUSSSJ07.02','100',100,'  ',1,NULL,NULL),(14,2012,12,'022.01','SSSJ.08','IKUSSSJ08.01','WDP',80,'  ',1,NULL,NULL),(15,2012,12,'022.01','SSSJ.08','IKUSSSJ08.02','1124600356389.00',80.91,'  ',1,NULL,NULL),(16,2012,12,'022.01','SSSJ.08','IKUSSSJ08.03','89',89,'  ',1,NULL,NULL),(17,2012,12,'022.01','SSSJ.09','IKUSSSJ09.01','784',1425.45,'  ',1,NULL,NULL),(18,2012,12,'022.01','SSSJ.09','IKUSSSJ09.02','23',230,'  ',1,NULL,NULL),(19,2012,12,'022.01','SSSJ.10','IKUSSSJ10.01','100',100,'  ',1,NULL,NULL),(20,2012,12,'022.01','SSSJ.10','IKUSSSJ10.02','40',100,'  ',1,NULL,NULL),(21,2012,12,'022.01','SSSJ.11','IKUSSSJ11.01','26',118.18,'  ',1,NULL,NULL),(22,2012,12,'022.01','SSSJ.11','IKUSSSJ11.02','7',233.33,'  ',1,NULL,NULL),(23,2012,12,'022.01','SSSJ.11','IKUSSSJ11.03','122',103.39,'  ',1,NULL,NULL),(24,2012,12,'022.01','SSSJ.11','IKUSSSJ11.04','6',150,'  ',1,NULL,NULL),(25,2012,12,'022.01','SSSJ.12','IKUSSSJ12.01','34',85,'  ',1,NULL,NULL),(26,2012,12,'022.01','SSSJ.12','IKUSSSJ12.02','34',85,'  ',1,NULL,NULL),(27,2012,12,'022.01','SSSJ.13','IKUSSSJ13.01','34',85,'  ',1,NULL,NULL),(28,2012,12,'022.01','SSSJ.14','IKUSSSJ14.01','146',107.35,'  ',1,NULL,NULL),(29,2012,12,'022.01','SSSJ.14','IKUSSSJ14.02','258',102.38,'  ',1,NULL,NULL),(30,2012,12,'022.02','SSIJ.01','IKUSSIJ01.01','0.12',100,'  ',1,NULL,NULL),(31,2012,12,'022.02','SSIJ.01','IKUSSIJ01.02','0',100,'  ',1,NULL,NULL),(32,2012,12,'022.02','SSIJ.02','IKUSSIJ02.01','70',100,'  ',1,NULL,NULL),(33,2012,12,'022.02','SSIJ.03','IKUSSIJ03.01','10',100,'  ',1,NULL,NULL),(34,2012,12,'022.02','SSIJ.04','IKUSSIJ04.01','82',100,'  ',1,NULL,NULL),(35,2012,12,'022.02','SSIJ.05','IKUSSIJ05.01','50',100,'  ',1,NULL,NULL),(36,2012,12,'022.02','SSIJ.05','IKUSSIJ05.02','90',100,'  ',1,NULL,NULL),(37,2012,12,'022.02','SSIJ.06','IKUSSIJ06.01','9',100,'  ',1,NULL,NULL),(38,2012,12,'022.02','SSIJ.07','IKUSSIJ07.01','90',100,'  ',1,NULL,NULL),(39,2012,12,'022.02','SSIJ.07','IKUSSIJ07.02','0.85',100,'  ',1,NULL,NULL),(40,2012,12,'022.02','SSIJ.07','IKUSSIJ07.03','82',100,'  ',1,NULL,NULL),(41,2012,12,'022.02','SSIJ.08','IKUSSIJ08.01','30',100,'  ',1,NULL,NULL),(42,2012,12,'022.02','SSIJ.08','IKUSSIJ08.02','160',100,'  ',1,NULL,NULL),(43,2012,12,'022.02','SSIJ.09','IKUSSIJ09.01','50',100,'  ',1,NULL,NULL),(44,2012,12,'022.03','SSPD.01','IKUSSPD01.01','0.206',91.96,'  ',1,NULL,NULL),(45,2012,12,'022.03','SSPD.01','IKUSSPD01.02','480',92,'  ',1,NULL,NULL),(46,2012,12,'022.03','SSPD.02','IKUSSPD02.01','4.27',25.12,'  ',1,NULL,NULL),(47,2012,12,'022.03','SSPD.02','IKUSSPD02.02','10.38',98.45,'  ',1,NULL,NULL),(48,2012,12,'022.03','SSPD.03','IKUSSPD03.01','5234',108.22,'  ',1,NULL,NULL),(49,2012,12,'022.03','SSPD.03','IKUSSPD03.02','1',50,'  ',1,NULL,NULL),(50,2012,12,'022.03','SSPD.04','IKUSSPD04.01','95.82',95.82,'  ',1,NULL,NULL),(51,2012,12,'022.03','SSPD.04','IKUSSPD04.02','69',100,'  ',1,NULL,NULL),(52,2012,12,'022.03','SSPD.05','IKUSSPD05.01','3',100,'  ',1,NULL,NULL),(53,2012,12,'022.03','SSPD.05','IKUSSPD05.02','205',298.55,'  ',1,NULL,NULL),(54,2012,12,'022.03','SSPD.05','IKUSSPD05.03','24',85.71,'  ',1,NULL,NULL),(55,2012,12,'022.03','SSPD.05','IKUSSPD05.04','14',100,'  ',1,NULL,NULL),(56,2012,12,'022.03','SSPD.05','IKUSSPD05.05','15',100,'  ',1,NULL,NULL),(57,2012,12,'022.03','SSPD.06','IKUSSPD06.01','169',100,'  ',1,NULL,NULL),(58,2012,12,'022.03','SSPD.06','IKUSSPD06.02','2335',100,'  ',1,NULL,NULL),(59,2012,12,'022.03','SSPD.06','IKUSSPD06.03','135',100,'  ',1,NULL,NULL),(60,2012,12,'022.03','SSPD.06','IKUSSPD06.04','42',89,'  ',1,NULL,NULL),(61,2012,12,'022.03','SSPD.07','IKUSSPD07.01','61400028',111.87,'  ',1,NULL,NULL),(62,2012,12,'022.03','SSPD.07','IKUSSPD07.02','13767975',201.81,'  ',1,NULL,NULL),(63,2012,12,'022.03','SSPD.07','IKUSSPD07.03','5524875',100,'  ',1,NULL,NULL),(64,2012,12,'022.03','SSPD.07','IKUSSPD07.04','3276851',100,'  ',1,NULL,NULL),(65,2012,12,'022.03','SSPD.07','IKUSSPD07.07','543061239',100,'  ',1,NULL,NULL),(66,2012,12,'022.03','SSPD.08','IKUSSPD08.01','59',88,'  ',1,NULL,NULL),(67,2012,12,'022.03','SSPD.08','IKUSSPD08.02','63',90,'  ',1,NULL,NULL),(68,2012,12,'022.03','SSPD.08','IKUSSPD08.03','88.19',88.19,'  ',1,NULL,NULL),(69,2012,12,'022.03','SSPD.08','IKUSSPD08.04','92.62',215,'  ',1,NULL,NULL),(70,2012,12,'022.03','SSPD.09','IKUSSPD09.01','83.07',98.89,'  ',1,NULL,NULL),(71,2012,12,'022.03','SSPD.09','IKUSSPD09.02','90.55',98.22,'  ',1,NULL,NULL),(72,2012,12,'022.03','SSPD.09','IKUSSPD09.03','9347923692208',142.17,'  ',1,NULL,NULL),(73,2012,12,'022.03','SSPD.10','IKUSSPD10.01','100',100,'  ',1,NULL,NULL),(74,2012,12,'022.03','SSPD.10','IKUSSPD10.02','202',100,'  ',1,NULL,NULL),(75,2012,12,'022.03','SSPD.11','IKUSSPD11.01','4',100,'  ',1,NULL,NULL),(76,2012,12,'022.03','SSPD.12','IKUSSPD12.01','22',129,'  ',1,NULL,NULL),(77,2012,12,'022.04','SSPL.01','IKUSSPL01.01','24',129.17,'  ',1,NULL,NULL),(78,2012,12,'022.04','SSPL.01','IKUSSPL01.02','66',72.73,'  ',1,NULL,NULL),(79,2012,12,'022.04','SSPL.02','IKUSSPL02.01','9298',130.11,'  ',1,NULL,NULL),(80,2012,12,'022.04','SSPL.03','IKUSSPL03.01','80',100,'  ',1,NULL,NULL),(81,2012,12,'022.04','SSPL.03','IKUSSPL03.02','386',98.22,'  ',1,NULL,NULL),(82,2012,12,'022.04','SSPL.04','IKUSSPL04.01','6061571',120.56,'  ',1,NULL,NULL),(83,2012,12,'022.04','SSPL.04','IKUSSPL04.02','634000',100.66,'  ',1,NULL,NULL),(84,2012,12,'022.04','SSPL.04','IKUSSPL04.03','351985284',107.54,'  ',1,NULL,NULL),(85,2012,12,'022.04','SSPL.04','IKUSSPL04.04','98.9',100.05,'  ',1,NULL,NULL),(86,2012,12,'022.04','SSPL.04','IKUSSPL04.05','59851000',100.59,'  ',1,NULL,NULL),(87,2012,12,'022.04','SSPL.04','IKUSSPL04.06','11.8',118,'  ',1,NULL,NULL),(88,2012,12,'022.04','SSPL.05','IKUSSPL05.01','0',0,'  ',1,NULL,NULL),(89,2012,12,'022.04','SSPL.06','IKUSSPL06.01','36',75,'  ',1,NULL,NULL),(90,2012,12,'022.04','SSPL.06','IKUSSPL06.02','36',75,'  ',1,NULL,NULL),(91,2012,12,'022.04','SSPL.06','IKUSSPL06.03','15',31.25,'  ',1,NULL,NULL),(92,2012,12,'022.04','SSPL.07','IKUSSPL07.01','2',100,'  ',1,NULL,NULL),(93,2012,12,'022.04','SSPL.08','IKUSSPL08.01','60',100,'  ',1,NULL,NULL),(94,2012,12,'022.04','SSPL.08','IKUSSPL08.02','120',100,'  ',1,NULL,NULL),(95,2012,12,'022.04','SSPL.08','IKUSSPL08.03','59',98.33,'  ',1,NULL,NULL),(96,2012,12,'022.04','SSPL.08','IKUSSPL08.04','367',100,'  ',1,NULL,NULL),(97,2012,12,'022.04','SSPL.08','IKUSSPL08.05','60',100,'  ',1,NULL,NULL),(98,2012,12,'022.04','SSPL.08','IKUSSPL08.06','120',100,'  ',1,NULL,NULL),(99,2012,12,'022.04','SSPL.08','IKUSSPL08.07','0',0,'  ',1,NULL,NULL),(100,2012,12,'022.04','SSPL.08','IKUSSPL08.08','0',0,'  ',1,NULL,NULL),(101,2012,12,'022.04','SSPL.08','IKUSSPL08.09','0',0,'  ',1,NULL,NULL),(102,2012,12,'022.04','SSPL.09','IKUSSPL09.01','78',100,'  ',1,NULL,NULL),(103,2012,12,'022.04','SSPL.09','IKUSSPL09.02','620559000000',187.21,'  ',1,NULL,NULL),(104,2012,12,'022.04','SSPL.09','IKUSSPL09.03','9993260000000',86.52,'  ',1,NULL,NULL),(105,2012,12,'022.04','SSPL.09','IKUSSPL09.04','25241600000000',94.61,'  ',1,NULL,NULL),(106,2012,12,'022.04','SSPL.10','IKUSSPL10.01','11',100,'  ',1,NULL,NULL),(107,2012,12,'022.04','SSPL.11','IKUSSPL11.01','0.102',20.59,'  ',1,NULL,NULL),(108,2012,12,'022.04','SSPL.12','IKUSSPL12.01','6',100,'  ',1,NULL,NULL),(109,2012,12,'022.04','SSPL.12','IKUSSPL12.02','972',95.2,'  ',1,NULL,NULL),(110,2012,12,'022.04','SSPL.12','IKUSSPL12.03','1332',87.23,'  ',1,NULL,NULL),(111,2012,12,'022.04','SSPL.12','IKUSSPL12.04','107',79.85,'  ',1,NULL,NULL),(112,2012,12,'022.04','SSPL.12','IKUSSPL12.05','205',80.33,'  ',1,NULL,NULL),(113,2012,12,'022.05','SSPU.01','IKUSSPU01.01','5.56',121.13,'  ',1,NULL,NULL),(114,2012,12,'022.05','SSPU.01','IKUSSPU01.02','9',183.93,'  ',1,NULL,NULL),(115,2012,12,'022.05','SSPU.02','IKUSSPU02.01','6',133.3,'  ',1,NULL,NULL),(116,2012,12,'022.05','SSPU.03','IKUSSPU03.01','76.87',100.8,'  ',1,NULL,NULL),(117,2012,12,'022.05','SSPU.04','IKUSSPU04.01','130',98.48,'  ',1,NULL,NULL),(118,2012,12,'022.05','SSPU.04','IKUSSPU04.02','159792',58.22,'  ',1,NULL,NULL),(119,2012,12,'022.05','SSPU.04','IKUSSPU04.03','127',98.45,'  ',1,NULL,NULL),(120,2012,12,'022.05','SSPU.05','IKUSSPU05.01','159',138.26,'  ',1,NULL,NULL),(121,2012,12,'022.05','SSPU.05','IKUSSPU05.02','81357603',105.36,'  ',1,NULL,NULL),(122,2012,12,'022.05','SSPU.05','IKUSSPU05.03','662238',60.42,'  ',1,NULL,NULL),(123,2012,12,'022.05','SSPU.06','IKUSSPU06.01','1042',101.66,'  ',1,NULL,NULL),(124,2012,12,'022.05','SSPU.06','IKUSSPU06.02','16',106.67,'  ',1,NULL,NULL),(125,2012,12,'022.05','SSPU.07','IKUSSPU07.01','659',100,'  ',1,NULL,NULL),(126,2012,12,'022.05','SSPU.07','IKUSSPU07.02','58175',103.15,'  ',1,NULL,NULL),(127,2012,12,'022.05','SSPU.08','IKUSSPU08.01','9',90,'  ',1,NULL,NULL),(128,2012,12,'022.05','SSPU.09','IKUSSPU09.01','36',120,'  ',1,NULL,NULL),(129,2012,12,'022.05','SSPU.10','IKUSSPU10.01','83.36',99.7,'  ',1,NULL,NULL),(130,2012,12,'022.05','SSPU.10','IKUSSPU10.02','87.59',101.85,'  ',1,NULL,NULL),(131,2012,12,'022.05','SSPU.10','IKUSSPU10.03','36122371519324',122.85,'  ',1,NULL,NULL),(132,2012,12,'022.05','SSPU.11','IKUSSPU11.01','15',100,'  ',1,NULL,NULL),(133,2012,12,'022.05','SSPU.12','IKUSSPU12.01','3758484',100.2,'  ',1,NULL,NULL),(134,2012,12,'022.05','SSPU.12','IKUSSPU12.02','56331.33',85,'  ',1,NULL,NULL),(135,2012,12,'022.08','SSKA.01','IKUSSKA01.01','31',96.67,'  ',1,NULL,NULL),(136,2012,12,'022.08','SSKA.01','IKUSSKA01.02','75.6',95.77,'  ',1,NULL,NULL),(137,2012,12,'022.08','SSKA.02','IKUSSKA02.01','44.64',88.4,'  ',1,NULL,NULL),(138,2012,12,'022.08','SSKA.03','IKUSSKA03.01','3307',118.27,'  ',1,NULL,NULL),(139,2012,12,'022.08','SSKA.03','IKUSSKA03.02','5',29.41,'  ',1,NULL,NULL),(140,2012,12,'022.08','SSKA.04','IKUSSKA04.01','168',113.51,'  ',1,NULL,NULL),(141,2012,12,'022.08','SSKA.04','IKUSSKA04.02','69',109.52,'  ',1,NULL,NULL),(142,2012,12,'022.08','SSKA.05','IKUSSKA05.01','225.93',59.78,'  ',1,NULL,NULL),(143,2012,12,'022.08','SSKA.05','IKUSSKA05.02','0.39',7.09,'  ',1,NULL,NULL),(144,2012,12,'022.08','SSKA.05','IKUSSKA05.03','0.17',2.06,'  ',1,NULL,NULL),(145,2012,12,'022.08','SSKA.06','IKUSSKA06.01','85',85.86,'  ',1,NULL,NULL),(146,2012,12,'022.08','SSKA.06','IKUSSKA06.02','132746437',58.12,'  ',1,NULL,NULL),(147,2012,12,'022.08','SSKA.06','IKUSSKA06.03','22079119',75.31,'  ',1,NULL,NULL),(148,2012,12,'022.08','SSKA.07','IKUSSKA07.01','70',100,'  ',1,NULL,NULL),(149,2012,12,'022.08','SSKA.07','IKUSSKA07.02','82.17',102.19,'  ',1,NULL,NULL),(150,2012,12,'022.08','SSKA.08','IKUSSKA08.01','89.39',117.56,'  ',1,NULL,NULL),(151,2012,12,'022.08','SSKA.08','IKUSSKA08.02','81.7',107.5,'  ',1,NULL,NULL),(152,2012,12,'022.08','SSKA.08','IKUSSKA08.03','1990',331.67,'  ',1,NULL,NULL),(153,2012,12,'022.08','SSKA.09','IKUSSKA09.01','5',71.43,'  ',1,NULL,NULL),(154,2012,12,'022.08','SSKA.10','IKUSSKA10.01','44',115.79,'  ',1,NULL,NULL),(155,2012,12,'022.08','SSKA.11','IKUSSKA11.01','1',100,'  ',1,NULL,NULL),(156,2012,12,'022.11','SSPP.01','IKUSSPP01.01','45',107.14,'  ',1,NULL,NULL),(157,2012,12,'022.11','SSPP.01','IKUSSPP01.02','112',70.89,'  ',1,NULL,NULL),(158,2012,12,'022.11','SSPP.02','IKUSSPP02.01','243',65.68,'  ',1,NULL,NULL),(159,2012,12,'022.12','SSSDM.01','IKUSSSDM01.01','175793',111.05,'  ',1,NULL,NULL),(160,2012,12,'022.12','SSSDM.02','IKUSSSDM02.01','162364',108.81,'  ',1,NULL,NULL),(161,2012,12,'022.12','SSSDM.03','IKUSSSDM03.01','100',106.39,'  ',1,NULL,NULL),(162,2012,12,'022.12','SSSDM.03','IKUSSSDM03.02','17',100,'  ',1,NULL,NULL),(163,2012,12,'022.12','SSSDM.04','IKUSSSDM04.01','30',90.91,'  ',1,NULL,NULL),(164,2012,12,'022.12','SSSDM.04','IKUSSSDM04.02','1',100,'  ',1,NULL,NULL),(165,2012,12,'022.12','SSSDM.04','IKUSSSDM04.03','664',289.96,'  ',1,NULL,NULL),(166,2012,12,'022.12','SSSDM.05','IKUSSSDM05.01','0',0,'  ',1,NULL,NULL),(167,2012,12,'022.12','SSSDM.06','IKUSSSDM06.01','38',950,'  ',1,NULL,NULL),(168,2012,12,'022.12','SSSDM.07','IKUSSSDM07.01','89.5',100,'  ',1,NULL,NULL),(169,2012,12,'022.12','SSSDM.07','IKUSSSDM07.02','86.38',105.12,'  ',1,NULL,NULL),(170,2012,12,'022.12','SSSDM.07','IKUSSSDM07.03','8897224987516',101,'  ',1,NULL,NULL),(171,2012,12,'022.12','SSSDM.08','IKUSSSDM08.01','20',166.67,'  ',1,NULL,NULL),(172,2012,12,'022.12','SSSDM.09','IKUSSSDM09.01','20030',109.81,'  ',1,NULL,NULL),(173,2012,12,'022.12','SSSDM.09','IKUSSSDM09.02','244110.675',93.51,'  ',1,NULL,NULL),(174,2012,12,'022.12','SSSDM.10','IKUSSSDM10.01','2578',88.74,'  ',1,NULL,NULL);
/*!40000 ALTER TABLE `tbl_pengukuran_eselon1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_pengukuran_eselon1_log`
--

DROP TABLE IF EXISTS `tbl_pengukuran_eselon1_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_pengukuran_eselon1_log` (
  `id_pengukuran_e1` int(11) NOT NULL AUTO_INCREMENT,
  `tahun` year(4) DEFAULT NULL,
  `triwulan` int(11) DEFAULT NULL,
  `kode_e1` varchar(10) DEFAULT NULL,
  `kode_sasaran_e1` varchar(20) DEFAULT NULL,
  `kode_iku_e1` varchar(20) DEFAULT NULL,
  `realisasi` varchar(20) DEFAULT NULL,
  `persen` double DEFAULT NULL,
  `opini` varchar(255) DEFAULT NULL,
  `persetujuan` tinyint(4) DEFAULT NULL,
  `log` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_pengukuran_e1`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_pengukuran_eselon1_log`
--

LOCK TABLES `tbl_pengukuran_eselon1_log` WRITE;
/*!40000 ALTER TABLE `tbl_pengukuran_eselon1_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_pengukuran_eselon1_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_pengukuran_eselon2`
--

DROP TABLE IF EXISTS `tbl_pengukuran_eselon2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_pengukuran_eselon2` (
  `id_pengukuran_e2` int(11) NOT NULL AUTO_INCREMENT,
  `tahun` year(4) NOT NULL,
  `triwulan` int(11) NOT NULL,
  `kode_e2` varchar(10) NOT NULL,
  `kode_sasaran_e2` varchar(20) NOT NULL,
  `kode_ikk` varchar(20) NOT NULL,
  `realisasi` varchar(20) NOT NULL,
  `persen` double NOT NULL,
  `opini` varchar(255) NOT NULL,
  `persetujuan` tinyint(4) NOT NULL,
  `log_insert` varchar(50) DEFAULT NULL,
  `log_update` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_pengukuran_e2`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_pengukuran_eselon2`
--

LOCK TABLES `tbl_pengukuran_eselon2` WRITE;
/*!40000 ALTER TABLE `tbl_pengukuran_eselon2` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_pengukuran_eselon2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_pengukuran_eselon2_log`
--

DROP TABLE IF EXISTS `tbl_pengukuran_eselon2_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_pengukuran_eselon2_log` (
  `id_pengukuran_e2` int(11) NOT NULL AUTO_INCREMENT,
  `tahun` year(4) DEFAULT NULL,
  `triwulan` int(11) DEFAULT NULL,
  `kode_e2` varchar(10) DEFAULT NULL,
  `kode_sasaran_e2` varchar(20) DEFAULT NULL,
  `kode_ikk` varchar(20) DEFAULT NULL,
  `realisasi` varchar(20) DEFAULT NULL,
  `persen` double DEFAULT NULL,
  `opini` varchar(255) DEFAULT NULL,
  `persetujuan` tinyint(4) DEFAULT NULL,
  `log` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_pengukuran_e2`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_pengukuran_eselon2_log`
--

LOCK TABLES `tbl_pengukuran_eselon2_log` WRITE;
/*!40000 ALTER TABLE `tbl_pengukuran_eselon2_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_pengukuran_eselon2_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_pengukuran_kl`
--

DROP TABLE IF EXISTS `tbl_pengukuran_kl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_pengukuran_kl` (
  `id_pengukuran_kl` int(11) NOT NULL AUTO_INCREMENT,
  `tahun` year(4) NOT NULL,
  `triwulan` int(11) NOT NULL,
  `kode_kl` varchar(10) NOT NULL,
  `kode_sasaran_kl` varchar(20) NOT NULL,
  `kode_iku_kl` varchar(20) NOT NULL,
  `realisasi` varchar(20) NOT NULL,
  `persen` double NOT NULL,
  `opini` varchar(255) NOT NULL,
  `persetujuan` tinyint(4) NOT NULL,
  `log_insert` varchar(50) DEFAULT NULL,
  `log_update` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_pengukuran_kl`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_pengukuran_kl`
--

LOCK TABLES `tbl_pengukuran_kl` WRITE;
/*!40000 ALTER TABLE `tbl_pengukuran_kl` DISABLE KEYS */;
INSERT INTO `tbl_pengukuran_kl` VALUES (1,2012,12,'022','SSKP.01','IKUSSKP01.01','5356',91.73,'  ',1,NULL,NULL),(2,2012,12,'022','SSKP.02','IKUSSKP02.01','6',133.33,'  ',1,NULL,NULL),(3,2012,12,'022','SSKP.03','IKUSSKP03.01','72.24',99.29,'  ',1,NULL,NULL),(4,2012,12,'022','SSKP.04','IKUSSKP04.01','13619',124.02,'  ',1,NULL,NULL),(5,2012,12,'022','SSKP.04','IKUSSKP04.02','13',40.63,'  ',1,NULL,NULL),(6,2012,12,'022','SSKP.05','IKUSSKP05.01','583',100.69,'  ',1,NULL,NULL),(7,2012,12,'022','SSKP.06','IKUSSKP06.01','1.15',76.67,'  ',1,NULL,NULL),(8,2012,12,'022','SSKP.07','IKUSSKP07.01','830785753',99.2,'  ',1,NULL,NULL),(9,2012,12,'022','SSKP.07','IKUSSKP07.02','374726641',89.8,'  ',1,NULL,NULL),(10,2012,12,'022','SSKP.08','IKUSSKP08.01','3',150,'  ',1,NULL,NULL),(11,2012,12,'022','SSKP.09','IKUSSKP09.01','B',133.33,'  ',1,NULL,NULL),(12,2012,12,'022','SSKP.09','IKUSSKP09.02','WDP',80,'  ',1,NULL,NULL),(13,2012,12,'022','SSKP.09','IKUSSKP09.03','162761231073098',130.45,'  ',1,NULL,NULL),(14,2012,12,'022','SSKP.10','IKUSSKP10.01','58175',103.15,'  ',1,NULL,NULL),(15,2012,12,'022','SSKP.10','IKUSSKP10.02','3637',161.72,'  ',1,NULL,NULL),(16,2012,12,'022','SSKP.10','IKUSSKP10.03','162364',108.81,'  ',1,NULL,NULL),(17,2012,12,'022','SSKP.11','IKUSSKP11.01','65',118.18,'  ',1,NULL,NULL),(18,2012,12,'022','SSKP.12','IKUSSKP12.01','3758.48',100.2,'  ',1,NULL,NULL),(19,2012,12,'022','SSKP.12','IKUSSKP12.02','88691.33',100.98,'  ',1,NULL,NULL),(20,2012,12,'022','SSKP.13','IKUSSKP13.01','2946',96.53,'  ',1,NULL,NULL),(21,2012,12,'022','SSKP.13','IKUSSKP13.02','53',100,'  ',1,NULL,NULL);
/*!40000 ALTER TABLE `tbl_pengukuran_kl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_pengukuran_kl_log`
--

DROP TABLE IF EXISTS `tbl_pengukuran_kl_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_pengukuran_kl_log` (
  `id_pengukuran_kl` int(11) NOT NULL AUTO_INCREMENT,
  `tahun` year(4) DEFAULT NULL,
  `triwulan` int(11) DEFAULT NULL,
  `kode_kl` varchar(10) DEFAULT NULL,
  `kode_sasaran_kl` varchar(20) DEFAULT NULL,
  `kode_iku_kl` varchar(20) DEFAULT NULL,
  `realisasi` varchar(20) DEFAULT NULL,
  `persen` double DEFAULT NULL,
  `opini` varchar(255) DEFAULT NULL,
  `persetujuan` tinyint(4) DEFAULT NULL,
  `log` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_pengukuran_kl`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_pengukuran_kl_log`
--

LOCK TABLES `tbl_pengukuran_kl_log` WRITE;
/*!40000 ALTER TABLE `tbl_pengukuran_kl_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_pengukuran_kl_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_pk_eselon1`
--

DROP TABLE IF EXISTS `tbl_pk_eselon1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_pk_eselon1` (
  `id_pk_e1` int(11) NOT NULL AUTO_INCREMENT,
  `tahun` year(4) NOT NULL,
  `kode_e1` varchar(10) NOT NULL,
  `kode_sasaran_e1` varchar(20) NOT NULL,
  `kode_iku_e1` varchar(20) NOT NULL,
  `target` varchar(20) NOT NULL,
  `penetapan` varchar(20) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `log_insert` varchar(50) DEFAULT NULL,
  `log_update` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_pk_e1`),
  KEY `FK_tbl_pk_eselon1` (`kode_e1`),
  KEY `FK_tbl_pk_eselon1_sasaran` (`kode_sasaran_e1`),
  KEY `FK_tbl_pk_eselon1_iku` (`kode_iku_e1`),
  CONSTRAINT `tbl_pk_eselon1_ibfk_1` FOREIGN KEY (`kode_e1`) REFERENCES `tbl_eselon1` (`kode_e1`) ON UPDATE CASCADE,
  CONSTRAINT `tbl_pk_eselon1_ibfk_2` FOREIGN KEY (`kode_sasaran_e1`) REFERENCES `tbl_sasaran_eselon1` (`kode_sasaran_e1`) ON UPDATE CASCADE,
  CONSTRAINT `tbl_pk_eselon1_ibfk_3` FOREIGN KEY (`kode_iku_e1`) REFERENCES `tbl_iku_eselon1` (`kode_iku_e1`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=351 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_pk_eselon1`
--

LOCK TABLES `tbl_pk_eselon1` WRITE;
/*!40000 ALTER TABLE `tbl_pk_eselon1` DISABLE KEYS */;
INSERT INTO `tbl_pk_eselon1` VALUES (1,2012,'022.01','SSSJ.01','IKUSSSJ01.01','CC','CC',1,NULL,NULL),(2,2012,'022.01','SSSJ.01','IKUSSSJ01.02','AA','B',1,NULL,NULL),(3,2012,'022.01','SSSJ.02','IKUSSSJ02.01','80','80',1,NULL,NULL),(4,2012,'022.01','SSSJ.03','IKUSSSJ03.01','60','60',1,NULL,NULL),(5,2012,'022.01','SSSJ.03','IKUSSSJ03.02','216','216',1,NULL,NULL),(6,2012,'022.01','SSSJ.04','IKUSSSJ04.01','4','22',1,NULL,NULL),(7,2012,'022.01','SSSJ.05','IKUSSSJ05.01','10750000000','10750000000',1,NULL,NULL),(8,2012,'022.01','SSSJ.05','IKUSSSJ05.02','70','100',1,NULL,NULL),(9,2012,'022.01','SSSJ.06','IKUSSSJ06.01','240','279',1,NULL,NULL),(10,2012,'022.01','SSSJ.06','IKUSSSJ06.02','1','7',1,NULL,NULL),(11,2012,'022.01','SSSJ.06','IKUSSSJ06.03','4','11',1,NULL,NULL),(12,2012,'022.01','SSSJ.07','IKUSSSJ07.01','7','9',1,NULL,NULL),(13,2012,'022.01','SSSJ.07','IKUSSSJ07.02','100','100',1,NULL,NULL),(14,2012,'022.01','SSSJ.08','IKUSSSJ08.01','WTP','WTP',1,NULL,NULL),(15,2012,'022.01','SSSJ.08','IKUSSSJ08.02','1056550582414','1389857384000',1,NULL,NULL),(16,2012,'022.01','SSSJ.08','IKUSSSJ08.03','100','100',1,NULL,NULL),(17,2012,'022.01','SSSJ.09','IKUSSSJ09.01','55','55',1,NULL,NULL),(18,2012,'022.01','SSSJ.09','IKUSSSJ09.02','10','10',1,NULL,NULL),(19,2012,'022.01','SSSJ.10','IKUSSSJ10.01','100','100',1,NULL,NULL),(20,2012,'022.01','SSSJ.10','IKUSSSJ10.02','40','40',1,NULL,NULL),(21,2012,'022.01','SSSJ.11','IKUSSSJ11.01','22','22',1,NULL,NULL),(22,2012,'022.01','SSSJ.11','IKUSSSJ11.02','3','3',1,NULL,NULL),(23,2012,'022.01','SSSJ.11','IKUSSSJ11.03','118','118',1,NULL,NULL),(24,2012,'022.01','SSSJ.11','IKUSSSJ11.04','4','4',1,NULL,NULL),(25,2012,'022.01','SSSJ.12','IKUSSSJ12.01','62.5','40',1,NULL,NULL),(26,2012,'022.01','SSSJ.12','IKUSSSJ12.02','25','40',1,NULL,NULL),(27,2012,'022.01','SSSJ.13','IKUSSSJ13.01','25','40',1,NULL,NULL),(28,2012,'022.01','SSSJ.14','IKUSSSJ14.01','136','136',1,NULL,NULL),(29,2012,'022.01','SSSJ.14','IKUSSSJ14.02','252','252',1,NULL,NULL),(30,2012,'022.02','SSIJ.01','IKUSSIJ01.01','0.12','0.12',1,NULL,NULL),(31,2012,'022.02','SSIJ.01','IKUSSIJ01.02','0','0',1,NULL,NULL),(32,2012,'022.02','SSIJ.02','IKUSSIJ02.01','70','70',1,NULL,NULL),(33,2012,'022.02','SSIJ.03','IKUSSIJ03.01','10','10',1,NULL,NULL),(34,2012,'022.02','SSIJ.04','IKUSSIJ04.01','82','82',1,NULL,NULL),(35,2012,'022.02','SSIJ.05','IKUSSIJ05.01','50','50',1,NULL,NULL),(36,2012,'022.02','SSIJ.05','IKUSSIJ05.02','90','90',1,NULL,NULL),(37,2012,'022.02','SSIJ.06','IKUSSIJ06.01','9','9',1,NULL,NULL),(38,2012,'022.02','SSIJ.07','IKUSSIJ07.01','90','90',1,NULL,NULL),(39,2012,'022.02','SSIJ.07','IKUSSIJ07.02','0.85','0.85',1,NULL,NULL),(40,2012,'022.02','SSIJ.07','IKUSSIJ07.03','82','82',1,NULL,NULL),(41,2012,'022.02','SSIJ.08','IKUSSIJ08.01','30','30',1,NULL,NULL),(42,2012,'022.02','SSIJ.08','IKUSSIJ08.02','160','160',1,NULL,NULL),(43,2012,'022.02','SSIJ.09','IKUSSIJ09.01','50','50',1,NULL,NULL),(44,2012,'022.03','SSPD.01','IKUSSPD01.01','0.244','0.244',1,NULL,NULL),(45,2012,'022.03','SSPD.01','IKUSSPD01.02','522','522',1,NULL,NULL),(46,2012,'022.03','SSPD.02','IKUSSPD02.01','17','17',1,NULL,NULL),(47,2012,'022.03','SSPD.02','IKUSSPD02.02','11','11',1,NULL,NULL),(48,2012,'022.03','SSPD.03','IKUSSPD03.01','4836','4836',1,NULL,NULL),(49,2012,'022.03','SSPD.03','IKUSSPD03.02','2','2',1,NULL,NULL),(50,2012,'022.03','SSPD.04','IKUSSPD04.01','100','100',1,NULL,NULL),(51,2012,'022.03','SSPD.04','IKUSSPD04.02','69','69',1,NULL,NULL),(52,2012,'022.03','SSPD.05','IKUSSPD05.01','3','3',1,NULL,NULL),(53,2012,'022.03','SSPD.05','IKUSSPD05.02','96','96',1,NULL,NULL),(54,2012,'022.03','SSPD.05','IKUSSPD05.03','578','28',1,NULL,NULL),(55,2012,'022.03','SSPD.05','IKUSSPD05.04','14','14',1,NULL,NULL),(56,2012,'022.03','SSPD.05','IKUSSPD05.05','15','15',1,NULL,NULL),(57,2012,'022.03','SSPD.06','IKUSSPD06.01','169','169',1,NULL,NULL),(58,2012,'022.03','SSPD.06','IKUSSPD06.02','2335','2335',1,NULL,NULL),(59,2012,'022.03','SSPD.06','IKUSSPD06.03','135','135',1,NULL,NULL),(60,2012,'022.03','SSPD.06','IKUSSPD06.04','47','47',1,NULL,NULL),(61,2012,'022.03','SSPD.07','IKUSSPD07.01','54882727','54882727',1,NULL,NULL),(62,2012,'022.03','SSPD.07','IKUSSPD07.02','6822202','6822202',1,NULL,NULL),(63,2012,'022.03','SSPD.07','IKUSSPD07.03','5524875','5524875',1,NULL,NULL),(64,2012,'022.03','SSPD.07','IKUSSPD07.04','3276851','3276851',1,NULL,NULL),(65,2012,'022.03','SSPD.07','IKUSSPD07.07','543061239','543061239',1,NULL,NULL),(66,2012,'022.03','SSPD.08','IKUSSPD08.01','0','67',1,NULL,NULL),(67,2012,'022.03','SSPD.08','IKUSSPD08.02','0','70',1,NULL,NULL),(68,2012,'022.03','SSPD.08','IKUSSPD08.03','1','100',1,NULL,NULL),(69,2012,'022.03','SSPD.08','IKUSSPD08.04','43.02','43.02',1,NULL,NULL),(70,2012,'022.03','SSPD.09','IKUSSPD09.01','84','84',1,NULL,NULL),(71,2012,'022.03','SSPD.09','IKUSSPD09.02','92.19','92.19',1,NULL,NULL),(72,2012,'022.03','SSPD.09','IKUSSPD09.03','6575057868084','6575057868084',1,NULL,NULL),(73,2012,'022.03','SSPD.10','IKUSSPD10.01','100','100',1,NULL,NULL),(74,2012,'022.03','SSPD.10','IKUSSPD10.02','202','202',1,NULL,NULL),(75,2012,'022.03','SSPD.11','IKUSSPD11.01','4','4',1,NULL,NULL),(76,2012,'022.03','SSPD.12','IKUSSPD12.01','17','17',1,NULL,NULL),(77,2012,'022.04','SSPL.01','IKUSSPL01.01','31','31',1,NULL,NULL),(78,2012,'022.04','SSPL.01','IKUSSPL01.02','48','48',1,NULL,NULL),(79,2012,'022.04','SSPL.02','IKUSSPL02.01','7146','7146',1,NULL,NULL),(80,2012,'022.04','SSPL.03','IKUSSPL03.01','80','80',1,NULL,NULL),(81,2012,'022.04','SSPL.03','IKUSSPL03.02','393','393',1,NULL,NULL),(82,2012,'022.04','SSPL.04','IKUSSPL04.01','5027658','5027658',1,NULL,NULL),(83,2012,'022.04','SSPL.04','IKUSSPL04.02','629847','629847',1,NULL,NULL),(84,2012,'022.04','SSPL.04','IKUSSPL04.03','327300000','327300000',1,NULL,NULL),(85,2012,'022.04','SSPL.04','IKUSSPL04.04','98.85','98.85',1,NULL,NULL),(86,2012,'022.04','SSPL.04','IKUSSPL04.05','59599000','59599000',1,NULL,NULL),(87,2012,'022.04','SSPL.04','IKUSSPL04.06','10','10',1,NULL,NULL),(88,2012,'022.04','SSPL.05','IKUSSPL05.01','30','30',1,NULL,NULL),(89,2012,'022.04','SSPL.06','IKUSSPL06.01','48','48',1,NULL,NULL),(90,2012,'022.04','SSPL.06','IKUSSPL06.02','48','48',1,NULL,NULL),(91,2012,'022.04','SSPL.06','IKUSSPL06.03','48','48',1,NULL,NULL),(92,2012,'022.04','SSPL.07','IKUSSPL07.01','2','2',1,NULL,NULL),(93,2012,'022.04','SSPL.08','IKUSSPL08.01','60','60',1,NULL,NULL),(94,2012,'022.04','SSPL.08','IKUSSPL08.02','120','120',1,NULL,NULL),(95,2012,'022.04','SSPL.08','IKUSSPL08.03','60','60',1,NULL,NULL),(96,2012,'022.04','SSPL.08','IKUSSPL08.04','367','367',1,NULL,NULL),(97,2012,'022.04','SSPL.08','IKUSSPL08.05','60','60',1,NULL,NULL),(98,2012,'022.04','SSPL.08','IKUSSPL08.06','120','120',1,NULL,NULL),(99,2012,'022.04','SSPL.08','IKUSSPL08.07','0','0',1,NULL,NULL),(100,2012,'022.04','SSPL.08','IKUSSPL08.08','0','0',1,NULL,NULL),(101,2012,'022.04','SSPL.08','IKUSSPL08.09','0','0',1,NULL,NULL),(102,2012,'022.04','SSPL.09','IKUSSPL09.01','78','78',1,NULL,NULL),(103,2012,'022.04','SSPL.09','IKUSSPL09.02','331485001206','331485001206',1,NULL,NULL),(104,2012,'022.04','SSPL.09','IKUSSPL09.03','11550550774000','11550550774000',1,NULL,NULL),(105,2012,'022.04','SSPL.09','IKUSSPL09.04','26680195570824','26680195570824',1,NULL,NULL),(106,2012,'022.04','SSPL.10','IKUSSPL10.01','11','11',1,NULL,NULL),(107,2012,'022.04','SSPL.11','IKUSSPL11.01','0.4853','0.4853',1,NULL,NULL),(108,2012,'022.04','SSPL.12','IKUSSPL12.01','6','6',1,NULL,NULL),(109,2012,'022.04','SSPL.12','IKUSSPL12.02','1021','1021',1,NULL,NULL),(110,2012,'022.04','SSPL.12','IKUSSPL12.03','1527','1527',1,NULL,NULL),(111,2012,'022.04','SSPL.12','IKUSSPL12.04','134','134',1,NULL,NULL),(112,2012,'022.04','SSPL.12','IKUSSPL12.05','245','245',1,NULL,NULL),(113,2012,'022.05','SSPU.01','IKUSSPU01.01','7.05','7.05',1,NULL,NULL),(114,2012,'022.05','SSPU.01','IKUSSPU01.02','56','56',1,NULL,NULL),(115,2012,'022.05','SSPU.02','IKUSSPU02.01','9','9',1,NULL,NULL),(116,2012,'022.05','SSPU.03','IKUSSPU03.01','76.26','76.26',1,NULL,NULL),(117,2012,'022.05','SSPU.04','IKUSSPU04.01','130','132',1,NULL,NULL),(118,2012,'022.05','SSPU.04','IKUSSPU04.02','274456','274456',1,NULL,NULL),(119,2012,'022.05','SSPU.04','IKUSSPU04.03','127','129',1,NULL,NULL),(120,2012,'022.05','SSPU.05','IKUSSPU05.01','115','115',1,NULL,NULL),(121,2012,'022.05','SSPU.05','IKUSSPU05.02','77221559','77221559',1,NULL,NULL),(122,2012,'022.05','SSPU.05','IKUSSPU05.03','1096024','1096024',1,NULL,NULL),(123,2012,'022.05','SSPU.06','IKUSSPU06.01','1025','1025',1,NULL,NULL),(124,2012,'022.05','SSPU.06','IKUSSPU06.02','15','15',1,NULL,NULL),(125,2012,'022.05','SSPU.07','IKUSSPU07.01','659','659',1,NULL,NULL),(126,2012,'022.05','SSPU.07','IKUSSPU07.02','56396','56396',1,NULL,NULL),(127,2012,'022.05','SSPU.08','IKUSSPU08.01','10','10',1,NULL,NULL),(128,2012,'022.05','SSPU.09','IKUSSPU09.01','30','30',1,NULL,NULL),(129,2012,'022.05','SSPU.10','IKUSSPU10.01','83.61','83.61',1,NULL,NULL),(130,2012,'022.05','SSPU.10','IKUSSPU10.02','86','86',1,NULL,NULL),(131,2012,'022.05','SSPU.10','IKUSSPU10.03','29402885109165','29402885109165',1,NULL,NULL),(132,2012,'022.05','SSPU.11','IKUSSPU11.01','15','15',1,NULL,NULL),(133,2012,'022.05','SSPU.12','IKUSSPU12.01','3751009','3751009',1,NULL,NULL),(134,2012,'022.05','SSPU.12','IKUSSPU12.02','66272.15','66272.15',1,NULL,NULL),(135,2012,'022.08','SSKA.01','IKUSSKA01.01','30','30',1,NULL,NULL),(136,2012,'022.08','SSKA.02','IKUSSKA02.01','78.94','78.94',1,NULL,NULL),(137,2012,'022.08','SSKA.02','IKUSSKA02.02','40','40',1,NULL,NULL),(138,2012,'022.08','SSKA.03','IKUSSKA03.01','2568','2568',1,NULL,NULL),(139,2012,'022.08','SSKA.03','IKUSSKA03.02','17','17',1,NULL,NULL),(140,2012,'022.08','SSKA.04','IKUSSKA04.01','148','148',1,NULL,NULL),(141,2012,'022.08','SSKA.04','IKUSSKA04.02','63','63',1,NULL,NULL),(142,2012,'022.08','SSKA.04','IKUSSKA04.03','377.95','377.95',1,NULL,NULL),(143,2012,'022.08','SSKA.05','IKUSSKA05.01','5.57','5.5',1,NULL,NULL),(144,2012,'022.08','SSKA.05','IKUSSKA05.02','8.26','8.26',1,NULL,NULL),(145,2012,'022.08','SSKA.06','IKUSSKA06.01','99','99',1,NULL,NULL),(146,2012,'022.08','SSKA.06','IKUSSKA06.02','228400000','228400000',1,NULL,NULL),(147,2012,'022.08','SSKA.06','IKUSSKA06.03','29318000','29318000',1,NULL,NULL),(148,2012,'022.08','SSKA.07','IKUSSKA07.01','70','70',1,NULL,NULL),(149,2012,'022.08','SSKA.08','IKUSSKA08.01','82.99','80.41',1,NULL,NULL),(150,2012,'022.08','SSKA.08','IKUSSKA08.02','76.04','76.04',1,NULL,NULL),(151,2012,'022.08','SSKA.08','IKUSSKA08.03','76','76',1,NULL,NULL),(152,2012,'022.08','SSKA.09','IKUSSKA09.01','600','600',1,NULL,NULL),(153,2012,'022.08','SSKA.10','IKUSSKA10.01','10','7',1,NULL,NULL),(154,2012,'022.08','SSKA.11','IKUSSKA11.01','38','38',1,NULL,NULL),(155,2012,'022.08','SSKA.11','IKUSSKA11.02','1','1',1,NULL,NULL),(156,2012,'022.11','SSPP.01','IKUSSPP01.01','42','42',1,NULL,NULL),(157,2012,'022.11','SSPP.01','IKUSSPP01.02','158','158',1,NULL,NULL),(158,2012,'022.11','SSPP.02','IKUSSPP02.01','370','370',1,NULL,NULL),(159,2012,'022.12','SSSDM.01','IKUSSSDM01.01','162746','158305',1,NULL,NULL),(160,2012,'022.12','SSSDM.02','IKUSSSDM02.01','163533','149216',1,NULL,NULL),(161,2012,'022.12','SSSDM.03','IKUSSSDM03.01','103','94',1,NULL,NULL),(162,2012,'022.12','SSSDM.03','IKUSSSDM03.02','32','17',1,NULL,NULL),(163,2012,'022.12','SSSDM.04','IKUSSSDM04.01','23','33',1,NULL,NULL),(164,2012,'022.12','SSSDM.04','IKUSSSDM04.02','22','1',1,NULL,NULL),(165,2012,'022.12','SSSDM.04','IKUSSSDM04.03','32','229',1,NULL,NULL),(166,2012,'022.12','SSSDM.05','IKUSSSDM05.01','0','1',1,NULL,NULL),(167,2012,'022.12','SSSDM.06','IKUSSSDM06.01','10','4',1,NULL,NULL),(168,2012,'022.12','SSSDM.07','IKUSSSDM07.01','92','89.5',1,NULL,NULL),(169,2012,'022.12','SSSDM.07','IKUSSSDM07.02','90.54','82.17',1,NULL,NULL),(170,2012,'022.12','SSSDM.07','IKUSSSDM07.03','9112599346193','8814551692643',1,NULL,NULL),(171,2012,'022.12','SSSDM.08','IKUSSSDM08.01','19','12',1,NULL,NULL),(172,2012,'022.12','SSSDM.09','IKUSSSDM09.01','14133','18241',1,NULL,NULL),(173,2012,'022.12','SSSDM.09','IKUSSSDM09.02','270509','261062',1,NULL,NULL),(174,2012,'022.12','SSSDM.10','IKUSSSDM10.01','2905','2905',1,NULL,NULL),(175,2013,'022.01','SSSJ.01','IKUSSSJ01.01','B','B',1,NULL,NULL),(176,2013,'022.01','SSSJ.01','IKUSSSJ01.02','AA','AA',1,NULL,NULL),(177,2013,'022.01','SSSJ.02','IKUSSSJ02.01','90','90',1,NULL,NULL),(178,2013,'022.01','SSSJ.03','IKUSSSJ03.01','67','67',1,NULL,NULL),(179,2013,'022.01','SSSJ.03','IKUSSSJ03.02','220','220',1,NULL,NULL),(180,2013,'022.01','SSSJ.04','IKUSSSJ04.01','4','20',1,NULL,NULL),(181,2013,'022.01','SSSJ.05','IKUSSSJ05.01','9675000000','9675000000',1,NULL,NULL),(182,2013,'022.01','SSSJ.05','IKUSSSJ05.02','80','100',1,NULL,NULL),(183,2013,'022.01','SSSJ.06','IKUSSSJ06.01','270','434',1,NULL,NULL),(184,2013,'022.01','SSSJ.06','IKUSSSJ06.02','1','1',1,NULL,NULL),(185,2013,'022.01','SSSJ.06','IKUSSSJ06.03','10','6',1,NULL,NULL),(186,2013,'022.01','SSSJ.07','IKUSSSJ07.01','7','7',1,NULL,NULL),(187,2013,'022.01','SSSJ.07','IKUSSSJ07.02','100','100',1,NULL,NULL),(188,2013,'022.01','SSSJ.08','IKUSSSJ08.01','WTP','WTP',1,NULL,NULL),(189,2013,'022.01','SSSJ.08','IKUSSSJ08.02','1088247100000','5983352230000',1,NULL,NULL),(190,2013,'022.01','SSSJ.08','IKUSSSJ08.03','100','100',1,NULL,NULL),(191,2013,'022.01','SSSJ.09','IKUSSSJ09.01','85','200',1,NULL,NULL),(192,2013,'022.01','SSSJ.09','IKUSSSJ09.02','10','10',1,NULL,NULL),(193,2013,'022.01','SSSJ.10','IKUSSSJ10.01','125','125',1,NULL,NULL),(194,2013,'022.01','SSSJ.10','IKUSSSJ10.02','60','60',1,NULL,NULL),(195,2013,'022.01','SSSJ.11','IKUSSSJ11.01','22','22',1,NULL,NULL),(196,2013,'022.01','SSSJ.11','IKUSSSJ11.02','3','3',1,NULL,NULL),(197,2013,'022.01','SSSJ.11','IKUSSSJ11.03','0','0',1,NULL,NULL),(198,2013,'022.01','SSSJ.11','IKUSSSJ11.04','5','5',1,NULL,NULL),(199,2013,'022.01','SSSJ.12','IKUSSSJ12.01','100','45',1,NULL,NULL),(200,2013,'022.01','SSSJ.12','IKUSSSJ12.02','100','45',1,NULL,NULL),(201,2013,'022.01','SSSJ.13','IKUSSSJ13.01','45','45',1,NULL,NULL),(202,2013,'022.01','SSSJ.14','IKUSSSJ14.01','103','165',1,NULL,NULL),(203,2013,'022.01','SSSJ.14','IKUSSSJ14.02','250','282',1,NULL,NULL),(204,2013,'022.02','SSIJ.01','IKUSSIJ01.01','0.09','0.09',1,NULL,NULL),(205,2013,'022.02','SSIJ.01','IKUSSIJ01.02','3','3',1,NULL,NULL),(206,2013,'022.02','SSIJ.02','IKUSSIJ02.01','73','73',1,NULL,NULL),(207,2013,'022.02','SSIJ.03','IKUSSIJ03.01','25','25',1,NULL,NULL),(208,2013,'022.02','SSIJ.04','IKUSSIJ04.01','85','85',1,NULL,NULL),(209,2013,'022.02','SSIJ.05','IKUSSIJ05.01','60','60',1,NULL,NULL),(210,2013,'022.02','SSIJ.05','IKUSSIJ05.02','90','90',1,NULL,NULL),(211,2013,'022.02','SSIJ.06','IKUSSIJ06.01','13','13',1,NULL,NULL),(212,2013,'022.02','SSIJ.07','IKUSSIJ07.01','93','93',1,NULL,NULL),(213,2013,'022.02','SSIJ.07','IKUSSIJ07.02','0.85','0.85',1,NULL,NULL),(214,2013,'022.02','SSIJ.07','IKUSSIJ07.03','87','87',1,NULL,NULL),(215,2013,'022.02','SSIJ.08','IKUSSIJ08.01','40','40',1,NULL,NULL),(216,2013,'022.02','SSIJ.08','IKUSSIJ08.02','170','170',1,NULL,NULL),(217,2013,'022.02','SSIJ.09','IKUSSIJ09.01','75','75',1,NULL,NULL),(218,2013,'022.03','SSPD.01','IKUSSPD01.01','1.67','1.39',1,NULL,NULL),(219,2013,'022.03','SSPD.01','IKUSSPD01.02','3900','3238',1,NULL,NULL),(220,2013,'022.03','SSPD.02','IKUSSPD02.01','17','17',1,NULL,NULL),(221,2013,'022.03','SSPD.02','IKUSSPD02.02','11','11',1,NULL,NULL),(222,2013,'022.03','SSPD.03','IKUSSPD03.01','4856','4856',1,NULL,NULL),(223,2013,'022.03','SSPD.03','IKUSSPD03.02','1','0',1,NULL,NULL),(224,2013,'022.03','SSPD.04','IKUSSPD04.01','13.48','100',1,NULL,NULL),(225,2013,'022.03','SSPD.04','IKUSSPD04.02','73','74',1,NULL,NULL),(226,2013,'022.03','SSPD.05','IKUSSPD05.01','3','3',1,NULL,NULL),(227,2013,'022.03','SSPD.05','IKUSSPD05.02','180','205',1,NULL,NULL),(228,2013,'022.03','SSPD.05','IKUSSPD05.03','600','26',1,NULL,NULL),(229,2013,'022.03','SSPD.05','IKUSSPD05.04','16','15',1,NULL,NULL),(230,2013,'022.03','SSPD.05','IKUSSPD05.05','16','16',1,NULL,NULL),(231,2013,'022.03','SSPD.06','IKUSSPD06.01','186','188',1,NULL,NULL),(232,2013,'022.03','SSPD.06','IKUSSPD06.02','2405','2343',1,NULL,NULL),(233,2013,'022.03','SSPD.06','IKUSSPD06.03','163','163',1,NULL,NULL),(234,2013,'022.03','SSPD.06','IKUSSPD06.04','49','49',1,NULL,NULL),(235,2013,'022.03','SSPD.07','IKUSSPD07.01','57213250','55000000',1,NULL,NULL),(236,2013,'022.03','SSPD.07','IKUSSPD07.02','7035055','7000000',1,NULL,NULL),(237,2013,'022.03','SSPD.07','IKUSSPD07.03','6221563','6221563',1,NULL,NULL),(238,2013,'022.03','SSPD.07','IKUSSPD07.04','3300000','3300000',1,NULL,NULL),(239,2013,'022.03','SSPD.07','IKUSSPD07.05','','',1,NULL,NULL),(240,2013,'022.03','SSPD.07','IKUSSPD07.06','','',1,NULL,NULL),(241,2013,'022.03','SSPD.07','IKUSSPD07.07','597367362','657104099',1,NULL,NULL),(242,2013,'022.03','SSPD.08','IKUSSPD08.01','0','71',1,NULL,NULL),(243,2013,'022.03','SSPD.08','IKUSSPD08.02','0','74',1,NULL,NULL),(244,2013,'022.03','SSPD.08','IKUSSPD08.03','1','100',1,NULL,NULL),(245,2013,'022.03','SSPD.08','IKUSSPD08.04','43.1','100',1,NULL,NULL),(246,2013,'022.03','SSPD.09','IKUSSPD09.01','85','85',1,NULL,NULL),(247,2013,'022.03','SSPD.09','IKUSSPD09.02','92.5','92.5',1,NULL,NULL),(248,2013,'022.03','SSPD.09','IKUSSPD09.03','6.927','11527',1,NULL,NULL),(249,2013,'022.03','SSPD.10','IKUSSPD10.01','200','100',1,NULL,NULL),(250,2013,'022.03','SSPD.10','IKUSSPD10.02','302','302',1,NULL,NULL),(251,2013,'022.03','SSPD.11','IKUSSPD11.01','3','3',1,NULL,NULL),(252,2013,'022.03','SSPD.12','IKUSSPD12.01','14','15',1,NULL,NULL),(253,2013,'022.04','SSPL.01','IKUSSPL01.01','37','31',1,NULL,NULL),(254,2013,'022.04','SSPL.01','IKUSSPL01.02','21','48',1,NULL,NULL),(255,2013,'022.04','SSPL.02','IKUSSPL02.01','7.85','7850',1,NULL,NULL),(256,2013,'022.04','SSPL.03','IKUSSPL03.01','89','80',1,NULL,NULL),(257,2013,'022.04','SSPL.03','IKUSSPL03.02','528','386',1,NULL,NULL),(258,2013,'022.04','SSPL.04','IKUSSPL04.01','5027658','6660000',1,NULL,NULL),(259,2013,'022.04','SSPL.04','IKUSSPL04.02','629847','634000',1,NULL,NULL),(260,2013,'022.04','SSPL.04','IKUSSPL04.03','316480000','341000000',1,NULL,NULL),(261,2013,'022.04','SSPL.04','IKUSSPL04.04','98.82','98.1',1,NULL,NULL),(262,2013,'022.04','SSPL.04','IKUSSPL04.05','55180000','63200000',1,NULL,NULL),(263,2013,'022.04','SSPL.04','IKUSSPL04.06','9.5','10.33',1,NULL,NULL),(264,2013,'022.04','SSPL.05','IKUSSPL05.01','60','60',1,NULL,NULL),(265,2013,'022.04','SSPL.06','IKUSSPL06.01','48','48',1,NULL,NULL),(266,2013,'022.04','SSPL.06','IKUSSPL06.02','48','48',1,NULL,NULL),(267,2013,'022.04','SSPL.06','IKUSSPL06.03','48','48',1,NULL,NULL),(268,2013,'022.04','SSPL.07','IKUSSPL07.01','3','2',1,NULL,NULL),(269,2013,'022.04','SSPL.08','IKUSSPL08.01','60','60',1,NULL,NULL),(270,2013,'022.04','SSPL.08','IKUSSPL08.02','120','120',1,NULL,NULL),(271,2013,'022.04','SSPL.08','IKUSSPL08.03','60','427',1,NULL,NULL),(272,2013,'022.04','SSPL.08','IKUSSPL08.04','60','367',1,NULL,NULL),(273,2013,'022.04','SSPL.08','IKUSSPL08.05','60','60',1,NULL,NULL),(274,2013,'022.04','SSPL.08','IKUSSPL08.06','120','120',1,NULL,NULL),(275,2013,'022.04','SSPL.08','IKUSSPL08.07','60','60',1,NULL,NULL),(276,2013,'022.04','SSPL.08','IKUSSPL08.08','20','20',1,NULL,NULL),(277,2013,'022.04','SSPL.08','IKUSSPL08.09','20','20',1,NULL,NULL),(278,2013,'022.04','SSPL.09','IKUSSPL09.01','80','82',1,NULL,NULL),(279,2013,'022.04','SSPL.09','IKUSSPL09.02','309000000000','309026100000',1,NULL,NULL),(280,2013,'022.04','SSPL.09','IKUSSPL09.03','9600000000000','9610273494000',1,NULL,NULL),(281,2013,'022.04','SSPL.09','IKUSSPL09.04','33100000000000','33110421564824',1,NULL,NULL),(282,2013,'022.04','SSPL.10','IKUSSPL10.01','7','8',1,NULL,NULL),(283,2013,'022.04','SSPL.11','IKUSSPL11.01','1.6122','0.5252',1,NULL,NULL),(284,2013,'022.04','SSPL.12','IKUSSPL12.01','12','12',1,NULL,NULL),(285,2013,'022.04','SSPL.12','IKUSSPL12.02','1123','1123',1,NULL,NULL),(286,2013,'022.04','SSPL.12','IKUSSPL12.03','1679','1679',1,NULL,NULL),(287,2013,'022.04','SSPL.12','IKUSSPL12.04','152','152',1,NULL,NULL),(288,2013,'022.04','SSPL.12','IKUSSPL12.05','1679','270',1,NULL,NULL),(289,2013,'022.05','SSPU.01','IKUSSPU01.01','5.88','5.88',1,NULL,NULL),(290,2013,'022.05','SSPU.01','IKUSSPU01.02','54','54',1,NULL,NULL),(291,2013,'022.05','SSPU.02','IKUSSPU02.01','8','8',1,NULL,NULL),(292,2013,'022.05','SSPU.03','IKUSSPU03.01','79.52','79.52',1,NULL,NULL),(293,2013,'022.05','SSPU.04','IKUSSPU04.01','138','138',1,NULL,NULL),(294,2013,'022.05','SSPU.04','IKUSSPU04.02','288179','288179',1,NULL,NULL),(295,2013,'022.05','SSPU.04','IKUSSPU04.03','130','130',1,NULL,NULL),(296,2013,'022.05','SSPU.05','IKUSSPU05.01','148','148',1,NULL,NULL),(297,2013,'022.05','SSPU.05','IKUSSPU05.02','88804793','88804793',1,NULL,NULL),(298,2013,'022.05','SSPU.05','IKUSSPU05.03','1260428','1260428',1,NULL,NULL),(299,2013,'022.05','SSPU.06','IKUSSPU06.01','1200','1200',1,NULL,NULL),(300,2013,'022.05','SSPU.06','IKUSSPU06.02','15','15',1,NULL,NULL),(301,2013,'022.05','SSPU.07','IKUSSPU07.01','703','703',1,NULL,NULL),(302,2013,'022.05','SSPU.07','IKUSSPU07.02','65433','65433',1,NULL,NULL),(303,2013,'022.05','SSPU.08','IKUSSPU08.01','10','10',1,NULL,NULL),(304,2013,'022.05','SSPU.09','IKUSSPU09.01','25','25',1,NULL,NULL),(305,2013,'022.05','SSPU.10','IKUSSPU10.01','84.61','84.61',1,NULL,NULL),(306,2013,'022.05','SSPU.10','IKUSSPU10.02','87','87',1,NULL,NULL),(307,2013,'022.05','SSPU.10','IKUSSPU10.03','33368327452365','33368327452365',1,NULL,NULL),(308,2013,'022.05','SSPU.11','IKUSSPU11.01','20','20',1,NULL,NULL),(309,2013,'022.05','SSPU.12','IKUSSPU12.01','4164021','4164021',1,NULL,NULL),(310,2013,'022.05','SSPU.12','IKUSSPU12.02','134618.81','134618.81',1,NULL,NULL),(311,2013,'022.08','SSKA.01','IKUSSKA01.01','6.12','0.5',1,NULL,NULL),(312,2013,'022.08','SSKA.02','IKUSSKA02.01','8.4','0.19',1,NULL,NULL),(313,2013,'022.08','SSKA.02','IKUSSKA02.02','27','27',1,NULL,NULL),(314,2013,'022.08','SSKA.03','IKUSSKA03.01','79.33','79.33',1,NULL,NULL),(315,2013,'022.08','SSKA.03','IKUSSKA03.02','40','40',1,NULL,NULL),(316,2013,'022.08','SSKA.04','IKUSSKA04.01','19','41.48',1,NULL,NULL),(317,2013,'022.08','SSKA.04','IKUSSKA04.02','1','1',1,NULL,NULL),(318,2013,'022.08','SSKA.04','IKUSSKA04.03','149','149',1,NULL,NULL),(319,2013,'022.08','SSKA.05','IKUSSKA05.01','63','63',1,NULL,NULL),(320,2013,'022.08','SSKA.05','IKUSSKA05.02','663','583.98',1,NULL,NULL),(321,2013,'022.08','SSKA.06','IKUSSKA06.01','32','17',1,NULL,NULL),(322,2013,'022.08','SSKA.06','IKUSSKA06.02','264500000','264500000',1,NULL,NULL),(323,2013,'022.08','SSKA.06','IKUSSKA06.03','37594000','37594000',1,NULL,NULL),(324,2013,'022.08','SSKA.07','IKUSSKA07.01','2023','2023',1,NULL,NULL),(325,2013,'022.08','SSKA.08','IKUSSKA08.01','15','24',1,NULL,NULL),(326,2013,'022.08','SSKA.08','IKUSSKA08.02','83.92','83.29',1,NULL,NULL),(327,2013,'022.08','SSKA.08','IKUSSKA08.03','83.65','83.65',1,NULL,NULL),(328,2013,'022.08','SSKA.09','IKUSSKA09.01','79.8','90',1,NULL,NULL),(329,2013,'022.08','SSKA.10','IKUSSKA10.01','900','4500',1,NULL,NULL),(330,2013,'022.08','SSKA.11','IKUSSKA11.01','1','21',1,NULL,NULL),(331,2013,'022.08','SSKA.11','IKUSSKA11.02','9','10',1,NULL,NULL),(332,2013,'022.11','SSPP.01','IKUSSPP01.01','47','47',1,NULL,NULL),(333,2013,'022.11','SSPP.01','IKUSSPP01.02','258','163',1,NULL,NULL),(334,2013,'022.11','SSPP.02','IKUSSPP02.01','4','3',1,NULL,NULL),(335,2013,'022.12','SSSDM.01','IKUSSSDM01.01','179541','171861',1,NULL,NULL),(336,2013,'022.12','SSSDM.02','IKUSSSDM02.01','177725','167102',1,NULL,NULL),(337,2013,'022.12','SSSDM.03','IKUSSSDM03.01','92','16',1,NULL,NULL),(338,2013,'022.12','SSSDM.03','IKUSSSDM03.02','32','43',1,NULL,NULL),(339,2013,'022.12','SSSDM.04','IKUSSSDM04.01','40','15',1,NULL,NULL),(340,2013,'022.12','SSSDM.04','IKUSSSDM04.02','23','7',1,NULL,NULL),(341,2013,'022.12','SSSDM.04','IKUSSSDM04.03','70','80',1,NULL,NULL),(342,2013,'022.12','SSSDM.05','IKUSSSDM05.01','2','2',1,NULL,NULL),(343,2013,'022.12','SSSDM.06','IKUSSSDM06.01','15','21',1,NULL,NULL),(344,2013,'022.12','SSSDM.07','IKUSSSDM07.01','94','94.09',1,NULL,NULL),(345,2013,'022.12','SSSDM.07','IKUSSSDM07.02','92','92',1,NULL,NULL),(346,2013,'022.12','SSSDM.07','IKUSSSDM07.03','8814550000000','10163972093749',1,NULL,NULL),(347,2013,'022.12','SSSDM.08','IKUSSSDM08.01','25','20',1,NULL,NULL),(348,2013,'022.12','SSSDM.09','IKUSSSDM09.01','15270','5919',1,NULL,NULL),(349,2013,'022.12','SSSDM.09','IKUSSSDM09.02','855276','685346',1,NULL,NULL),(350,2013,'022.12','SSSDM.10','IKUSSSDM10.01','2905','2518',1,NULL,NULL);
/*!40000 ALTER TABLE `tbl_pk_eselon1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_pk_eselon1_log`
--

DROP TABLE IF EXISTS `tbl_pk_eselon1_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_pk_eselon1_log` (
  `id_pk_e1` int(11) NOT NULL AUTO_INCREMENT,
  `tahun` year(4) DEFAULT NULL,
  `kode_e1` varchar(10) DEFAULT NULL,
  `kode_sasaran_e1` varchar(20) DEFAULT NULL,
  `kode_iku_e1` varchar(20) DEFAULT NULL,
  `target` varchar(20) DEFAULT NULL,
  `penetapan` varchar(20) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `log` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_pk_e1`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_pk_eselon1_log`
--

LOCK TABLES `tbl_pk_eselon1_log` WRITE;
/*!40000 ALTER TABLE `tbl_pk_eselon1_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_pk_eselon1_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_pk_eselon2`
--

DROP TABLE IF EXISTS `tbl_pk_eselon2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_pk_eselon2` (
  `id_pk_e2` int(11) NOT NULL AUTO_INCREMENT,
  `kode_e2` varchar(10) DEFAULT NULL,
  `tahun` year(4) NOT NULL,
  `kode_sasaran_e2` varchar(20) NOT NULL,
  `kode_ikk` varchar(20) NOT NULL,
  `target` varchar(20) NOT NULL,
  `penetapan` varchar(20) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `log_insert` varchar(50) DEFAULT NULL,
  `log_update` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_pk_e2`),
  KEY `FK_tbl_pk_eselon2_sasaran` (`kode_sasaran_e2`),
  KEY `FK_tbl_pk_eselon2_ikk` (`kode_ikk`),
  KEY `FK_tbl_pk_eselon2_e2` (`kode_e2`),
  CONSTRAINT `tbl_pk_eselon2_ibfk_4` FOREIGN KEY (`kode_sasaran_e2`) REFERENCES `tbl_sasaran_eselon2` (`kode_sasaran_e2`) ON UPDATE CASCADE,
  CONSTRAINT `tbl_pk_eselon2_ibfk_5` FOREIGN KEY (`kode_ikk`) REFERENCES `tbl_ikk` (`kode_ikk`) ON UPDATE CASCADE,
  CONSTRAINT `tbl_pk_eselon2_ibfk_6` FOREIGN KEY (`kode_e2`) REFERENCES `tbl_eselon2` (`kode_e2`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_pk_eselon2`
--

LOCK TABLES `tbl_pk_eselon2` WRITE;
/*!40000 ALTER TABLE `tbl_pk_eselon2` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_pk_eselon2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_pk_eselon2_log`
--

DROP TABLE IF EXISTS `tbl_pk_eselon2_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_pk_eselon2_log` (
  `id_pk_e2` int(11) NOT NULL AUTO_INCREMENT,
  `kode_e2` varchar(10) DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `kode_sasaran_e2` varchar(20) DEFAULT NULL,
  `kode_ikk` varchar(20) DEFAULT NULL,
  `target` varchar(20) DEFAULT NULL,
  `penetapan` varchar(20) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `log` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_pk_e2`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_pk_eselon2_log`
--

LOCK TABLES `tbl_pk_eselon2_log` WRITE;
/*!40000 ALTER TABLE `tbl_pk_eselon2_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_pk_eselon2_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_pk_kl`
--

DROP TABLE IF EXISTS `tbl_pk_kl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_pk_kl` (
  `id_pk_kl` int(11) NOT NULL AUTO_INCREMENT,
  `tahun` year(4) NOT NULL,
  `kode_kl` varchar(10) NOT NULL,
  `kode_sasaran_kl` varchar(20) NOT NULL,
  `kode_iku_kl` varchar(20) NOT NULL,
  `target` varchar(20) NOT NULL,
  `penetapan` varchar(20) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `log_insert` varchar(50) DEFAULT NULL,
  `log_update` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_pk_kl`),
  KEY `FK_tbl_pk_kl` (`kode_kl`),
  KEY `FK_tbl_pk_kl_sasaran` (`kode_sasaran_kl`),
  KEY `FK_tbl_pk_kl_iku` (`kode_iku_kl`),
  CONSTRAINT `tbl_pk_kl_ibfk_1` FOREIGN KEY (`kode_kl`) REFERENCES `tbl_kl` (`kode_kl`) ON UPDATE CASCADE,
  CONSTRAINT `tbl_pk_kl_ibfk_2` FOREIGN KEY (`kode_sasaran_kl`) REFERENCES `tbl_sasaran_kl` (`kode_sasaran_kl`) ON UPDATE CASCADE,
  CONSTRAINT `tbl_pk_kl_ibfk_3` FOREIGN KEY (`kode_iku_kl`) REFERENCES `tbl_iku_kl` (`kode_iku_kl`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_pk_kl`
--

LOCK TABLES `tbl_pk_kl` WRITE;
/*!40000 ALTER TABLE `tbl_pk_kl` DISABLE KEYS */;
INSERT INTO `tbl_pk_kl` VALUES (1,2012,'022','SSKP.01','IKUSSKP01.01','5233','5003',1,NULL,NULL),(2,2012,'022','SSKP.02','IKUSSKP02.01','9','9',1,NULL,NULL),(3,2012,'022','SSKP.03','IKUSSKP03.01','71.73','71.73',1,NULL,NULL),(4,2012,'022','SSKP.04','IKUSSKP04.01','5225','10981',1,NULL,NULL),(5,2012,'022','SSKP.04','IKUSSKP04.02','32','32',1,NULL,NULL),(6,2012,'022','SSKP.05','IKUSSKP05.01','564','579',1,NULL,NULL),(7,2012,'022','SSKP.06','IKUSSKP06.01','3.4','1.5',1,NULL,NULL),(8,2012,'022','SSKP.07','IKUSSKP07.01','840803197','837526346',1,NULL,NULL),(9,2012,'022','SSKP.07','IKUSSKP07.02','452122699.5','417313024',1,NULL,NULL),(10,2012,'022','SSKP.08','IKUSSKP08.01','2','2',1,NULL,NULL),(11,2012,'022','SSKP.09','IKUSSKP09.01','CC','CC',1,NULL,NULL),(12,2012,'022','SSKP.09','IKUSSKP09.02','WTP','WTP',1,NULL,NULL),(13,2012,'022','SSKP.09','IKUSSKP09.03','124772341185388','124772341185388',1,NULL,NULL),(14,2012,'022','SSKP.10','IKUSSKP10.01','56396','56396',1,NULL,NULL),(15,2012,'022','SSKP.10','IKUSSKP10.02','6168','2249',1,NULL,NULL),(16,2012,'022','SSKP.10','IKUSSKP10.03','163533','149216',1,NULL,NULL),(17,2012,'022','SSKP.11','IKUSSKP11.01','55','55',1,NULL,NULL),(18,2012,'022','SSKP.12','IKUSSKP12.01','51372.9','3751.01',1,NULL,NULL),(19,2012,'022','SSKP.12','IKUSSKP12.02','120.2','89571.33',1,NULL,NULL),(20,2012,'022','SSKP.13','IKUSSKP13.01','4884','3052',1,NULL,NULL),(21,2012,'022','SSKP.13','IKUSSKP13.02','53','53',1,NULL,NULL),(22,2013,'022','SSKP.01','IKUSSKP01.01','5022','4962',1,NULL,NULL),(23,2013,'022','SSKP.02','IKUSSKP02.01','8','8',1,NULL,NULL),(24,2013,'022','SSKP.03','IKUSSKP03.01','86.28','86.28',1,NULL,NULL),(25,2013,'022','SSKP.04','IKUSSKP04.01','25263','25263',1,NULL,NULL),(26,2013,'022','SSKP.04','IKUSSKP04.02','198','198',1,NULL,NULL),(27,2013,'022','SSKP.05','IKUSSKP05.01','632','632',1,NULL,NULL),(28,2013,'022','SSKP.06','IKUSSKP06.01','1.8','1.8',1,NULL,NULL),(29,2013,'022','SSKP.07','IKUSSKP07.01','1078924455','1078924455',1,NULL,NULL),(30,2013,'022','SSKP.07','IKUSSKP07.02','443054428','443054428',1,NULL,NULL),(31,2013,'022','SSKP.08','IKUSSKP08.01','3','3',1,NULL,NULL),(32,2013,'022','SSKP.09','IKUSSKP09.01','B','B',1,NULL,NULL),(33,2013,'022','SSKP.09','IKUSSKP09.02','WTP','WTP',1,NULL,NULL),(34,2013,'022','SSKP.09','IKUSSKP09.03','184153616755146','184153616755146',1,NULL,NULL),(35,2013,'022','SSKP.10','IKUSSKP10.01','65443','65443',1,NULL,NULL),(36,2013,'022','SSKP.10','IKUSSKP10.02','6919','6919',1,NULL,NULL),(37,2013,'022','SSKP.10','IKUSSKP10.03','177725','177725',1,NULL,NULL),(38,2013,'022','SSKP.11','IKUSSKP11.01','200','200',1,NULL,NULL),(39,2013,'022','SSKP.12','IKUSSKP12.01','51659.1','51659.1',1,NULL,NULL),(40,2013,'022','SSKP.12','IKUSSKP12.02','121','121',1,NULL,NULL),(41,2013,'022','SSKP.13','IKUSSKP13.01','5413','5413',1,NULL,NULL),(42,2013,'022','SSKP.13','IKUSSKP13.02','67','67',1,NULL,NULL);
/*!40000 ALTER TABLE `tbl_pk_kl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_pk_kl_log`
--

DROP TABLE IF EXISTS `tbl_pk_kl_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_pk_kl_log` (
  `id_pk_kl` int(11) NOT NULL AUTO_INCREMENT,
  `tahun` year(4) DEFAULT NULL,
  `kode_kl` varchar(10) DEFAULT NULL,
  `kode_sasaran_kl` varchar(20) DEFAULT NULL,
  `kode_iku_kl` varchar(20) DEFAULT NULL,
  `target` varchar(20) DEFAULT NULL,
  `penetapan` varchar(20) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `log` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_pk_kl`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_pk_kl_log`
--

LOCK TABLES `tbl_pk_kl_log` WRITE;
/*!40000 ALTER TABLE `tbl_pk_kl_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_pk_kl_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_prefix`
--

DROP TABLE IF EXISTS `tbl_prefix`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_prefix` (
  `kode_e1` varchar(10) NOT NULL DEFAULT '',
  `kode_e2` varchar(10) NOT NULL DEFAULT '',
  `deskripsi` varchar(50) DEFAULT NULL,
  `prefix` varchar(10) DEFAULT NULL,
  `prefix_iku` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`kode_e1`,`kode_e2`),
  UNIQUE KEY `prefix_unique` (`prefix`),
  UNIQUE KEY `prefix_iku_unique` (`prefix_iku`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_prefix`
--

LOCK TABLES `tbl_prefix` WRITE;
/*!40000 ALTER TABLE `tbl_prefix` DISABLE KEYS */;
INSERT INTO `tbl_prefix` VALUES ('022.01','','Sekretariat Jenderal Kementerian Perhubungan','SJKP',NULL),('022.02','','Inspektorat Jenderal Kementerian Perhubungan','O',NULL),('022.03','','Direktorat Jenderal Perhubungan Darat',NULL,NULL),('022.04','','Direktorat Jenderal Perhubungan Laut',NULL,NULL),('022.05','','Direktorat Jenderal Perhubungan Udara',NULL,NULL),('022.08','','Direktorat Jenderal Perkeretaapian',NULL,NULL),('022.11','','Badan Penelitian dan Pengembangan Perhubungan',NULL,NULL),('022.12','','Badan Pengembangan Sumber Daya Manusia Perhubungan',NULL,NULL),('022.01','022.01.01','Biro Perencanaan','BP',NULL),('022.01','022.01.02','Biro Kepegawaian dan Organisasi','BKO',NULL),('022.01','022.01.03','Biro Keuangan dan Perlengkapan','BKP',NULL),('022.01','022.01.04','Biro Hukum dan Kerjasama Luar Negeri',NULL,NULL),('022.01','022.01.05','Biro Umum',NULL,NULL),('022.01','022.01.06','Pusat Komunikasi Publik',NULL,NULL),('022.01','022.01.07','Pusat Kajian Kemitraan dan Pelayanan Jasa Transpor',NULL,NULL),('022.01','022.01.08','Mahkamah Pelayaran',NULL,NULL),('022.01','022.01.09','Pusat Data dan Informasi',NULL,NULL),('022.01','022.01.10','Komite Nasional Keselamatan Transportasi',NULL,NULL),('022.02','022.02.01','Sekretariat Inspektorat Jenderal',NULL,NULL),('022.02','022.02.02','Inspektorat I',NULL,NULL),('022.02','022.02.03','Inspektorat II',NULL,NULL),('022.02','022.02.04','Inspektorat III',NULL,NULL),('022.02','022.02.05','Inspektorat IV',NULL,NULL),('022.02','022.02.06','Inspektorat V',NULL,NULL),('022.03','022.03.01','Sekretariat Direktorat Jenderal Perhubungan Darat',NULL,NULL),('022.03','022.03.02','Direktorat Lalu Lintas dan Angkutan Jalan',NULL,NULL),('022.03','022.03.03','Direktorat Lalu Lintas dan Angkutan Sungai, Danau ',NULL,NULL),('022.03','022.03.04','Direktorat Bina Sistem Transportasi Perkotaan',NULL,NULL),('022.03','022.03.05','Direktorat Keselamatan Transportasi Darat',NULL,NULL),('022.04','022.04.01','Sekretariat Direktorat Jenderal Perhubungan Laut',NULL,NULL),('022.04','022.04.02','Direktorat Lalu Lintas dan Angkutan Laut',NULL,NULL),('022.04','022.04.03','Direktorat Pelabuhan dan Pengerukan',NULL,NULL),('022.04','022.04.04','Direktorat Perkapalan dan Kepelautan',NULL,NULL),('022.04','022.04.05','Direktorat Kenavigasian',NULL,NULL),('022.04','022.04.06','Direktorat Kesatuan Penjagaan Laut dan Pantai',NULL,NULL),('022.05','022.05.01','Sekretariat Direktorat Jenderal Perhubungan Udara',NULL,NULL),('022.05','022.05.02','Direktorat Angkutan Udara',NULL,NULL),('022.05','022.05.03','Direktorat Bandar Udara',NULL,NULL),('022.05','022.05.04','Direktorat Keamanan Penerbangan',NULL,NULL),('022.05','022.05.05','Direktorat Navigasi Penerbangan',NULL,NULL),('022.05','022.05.06','Direktorat Kelaikan Udara dan Pengoperasian Pesawa',NULL,NULL),('022.08','022.08.01','Sekretariat Direktorat Jenderal Perkeretaapian',NULL,NULL),('022.08','022.08.02','Direktorat Lalu Lintas dan Angkutan Kereta Api',NULL,NULL),('022.08','022.08.03','Direktorat Prasarana Perkeretaapian',NULL,NULL),('022.08','022.08.04','Direktorat Sarana Perkeretaapian',NULL,NULL),('022.08','022.08.05','Direktorat Keselamatan Perkeretaapian',NULL,NULL),('022.11','022.11.01','Sekretariat Badan Penelitian dan Pengembangan Perh',NULL,NULL),('022.11','022.11.02','Pusat Penelitian dan Pengembangan Manajemen Transp',NULL,NULL),('022.11','022.11.03','Pusat Penelitian dan Pengembangan Perhubungan Dara',NULL,NULL),('022.11','022.11.04','Pusat Penelitian dan Pengembangan Perhubungan Laut',NULL,NULL),('022.11','022.11.05','Pusat Penelitian dan Pengembangan Perhubungan Udar',NULL,NULL),('022.12','022.12.01','Sekretariat Badan Pengembangan Sumber Daya Manusia',NULL,NULL),('022.12','022.12.02','Pusat Pengembangan Sumber Daya Manusia Perhubungan',NULL,NULL),('022.12','022.12.03','Pusat Pengembangan Sumber Daya Manusia Perhubungan',NULL,NULL),('022.12','022.12.04','Pusat Pengembangan Sumber Daya Manusia Perhubungan',NULL,NULL),('022.12','022.12.05','Pusat Pengembangan Sumber Daya Manusia Aparatur Pe',NULL,NULL);
/*!40000 ALTER TABLE `tbl_prefix` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_program_kl`
--

DROP TABLE IF EXISTS `tbl_program_kl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_program_kl` (
  `id_program_kl` int(11) NOT NULL AUTO_INCREMENT,
  `tahun` year(4) NOT NULL,
  `kode_program` varchar(20) NOT NULL,
  `nama_program` varchar(200) DEFAULT NULL,
  `total` bigint(20) NOT NULL,
  `kode_e1` varchar(10) NOT NULL,
  `log_insert` varchar(50) DEFAULT NULL,
  `log_update` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_program_kl`),
  KEY `FK_tbl_program_kl_e1` (`kode_e1`),
  CONSTRAINT `tbl_program_kl_ibfk_1` FOREIGN KEY (`kode_e1`) REFERENCES `tbl_eselon1` (`kode_e1`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_program_kl`
--

LOCK TABLES `tbl_program_kl` WRITE;
/*!40000 ALTER TABLE `tbl_program_kl` DISABLE KEYS */;
INSERT INTO `tbl_program_kl` VALUES (1,2012,'022.01.01','Dukungan Manajemen dan Pelaksanaan Tugas Teknis Lainnya Kementerian Perhubungan',462851552000,'022.01',NULL,NULL),(2,2012,'022.02.03','Pengawasan dan Peningkatan Akuntabilitas Aparatur Kementerian Perhubungan',69099045000,'022.02',NULL,NULL),(3,2012,'022.03.06','Pengelolaan dan Penyelenggaraan Transportasi Darat',2859805219000,'022.03',NULL,NULL),(4,2012,'022.04.08','Pengelolaan dan Penyelenggaraan Transportasi Laut',11550550774000,'022.04',NULL,NULL),(5,2012,'022.05.09','Pengelolaan dan Penyelenggaraan Transportasi Udara',6898259870000,'022.05',NULL,NULL),(6,2012,'022.08.07','Pengelolaan dan Penyelenggaraan Transportasi Perkeretaapian',8270151147000,'022.08',NULL,NULL),(7,2012,'022.11.04','Penelitian dan Pengembangan Kementerian Perhubungan',194878759000,'022.11',NULL,NULL),(8,2012,'022.12.05','Pengembangan Sumber Daya Manusia Perhubungan',2600142715000,'022.12',NULL,NULL),(9,2013,'022.01.01','Dukungan Manajemen dan Pelaksanaan Tugas Teknis Lainnya Kementerian Perhubungan',559065026000,'022.01',NULL,NULL),(10,2013,'022.02.03','Pengawasan dan Peningkatan Akuntabilitas Aparatur Kementerian Perhubungan',86996703000,'022.02',NULL,NULL),(11,2013,'022.03.06','Pengelolaan dan Penyelenggaraan Transportasi Darat',2850371834000,'022.03',NULL,NULL),(12,2013,'022.04.08','Pengelolaan dan Penyelenggaraan Transportasi Laut',12598300000000,'022.04',NULL,NULL),(13,2013,'022.05.09','Pengelolaan dan Penyelenggaraan Transportasi Udara',6888761696000,'022.05',NULL,NULL),(14,2013,'022.08.07','Pengelolaan dan Penyelenggaraan Transportasi Perkeretaapian',9372030000000,'022.08',NULL,NULL),(15,2013,'022.11.04','Penelitian dan Pengembangan Kementerian Perhubungan',234349200000,'022.11',NULL,NULL),(16,2013,'022.12.05','Pengembangan Sumber Daya Manusia Perhubungan',2992532368000,'022.12',NULL,NULL);
/*!40000 ALTER TABLE `tbl_program_kl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_rkt_eselon1`
--

DROP TABLE IF EXISTS `tbl_rkt_eselon1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_rkt_eselon1` (
  `id_rkt_e1` int(11) NOT NULL AUTO_INCREMENT,
  `tahun` year(4) NOT NULL,
  `kode_e1` varchar(10) NOT NULL,
  `kode_sasaran_e1` varchar(20) NOT NULL,
  `kode_iku_e1` varchar(20) NOT NULL,
  `target` varchar(20) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `log_insert` varchar(50) DEFAULT NULL,
  `log_update` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_rkt_e1`),
  KEY `FK_tbl_rkt_eselon1_e1` (`kode_e1`),
  KEY `FK_tbl_rkt_eselon1_sasaran` (`kode_sasaran_e1`),
  KEY `FK_tbl_rkt_eselon1_iku` (`kode_iku_e1`),
  CONSTRAINT `tbl_rkt_eselon1_ibfk_1` FOREIGN KEY (`kode_e1`) REFERENCES `tbl_eselon1` (`kode_e1`) ON UPDATE CASCADE,
  CONSTRAINT `tbl_rkt_eselon1_ibfk_2` FOREIGN KEY (`kode_sasaran_e1`) REFERENCES `tbl_sasaran_eselon1` (`kode_sasaran_e1`) ON UPDATE CASCADE,
  CONSTRAINT `tbl_rkt_eselon1_ibfk_3` FOREIGN KEY (`kode_iku_e1`) REFERENCES `tbl_iku_eselon1` (`kode_iku_e1`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=351 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_rkt_eselon1`
--

LOCK TABLES `tbl_rkt_eselon1` WRITE;
/*!40000 ALTER TABLE `tbl_rkt_eselon1` DISABLE KEYS */;
INSERT INTO `tbl_rkt_eselon1` VALUES (1,2012,'022.01','SSSJ.01','IKUSSSJ01.01','CC',1,NULL,NULL),(2,2012,'022.01','SSSJ.01','IKUSSSJ01.02','AA',1,NULL,NULL),(3,2012,'022.01','SSSJ.02','IKUSSSJ02.01','80',1,NULL,NULL),(4,2012,'022.01','SSSJ.03','IKUSSSJ03.01','60',1,NULL,NULL),(5,2012,'022.01','SSSJ.03','IKUSSSJ03.02','216',1,NULL,NULL),(6,2012,'022.01','SSSJ.04','IKUSSSJ04.01','4',1,NULL,NULL),(7,2012,'022.01','SSSJ.05','IKUSSSJ05.01','10750000000',1,NULL,NULL),(8,2012,'022.01','SSSJ.05','IKUSSSJ05.02','70',1,NULL,NULL),(9,2012,'022.01','SSSJ.06','IKUSSSJ06.01','240',1,NULL,NULL),(10,2012,'022.01','SSSJ.06','IKUSSSJ06.02','1',1,NULL,NULL),(11,2012,'022.01','SSSJ.06','IKUSSSJ06.03','4',1,NULL,NULL),(12,2012,'022.01','SSSJ.07','IKUSSSJ07.01','7',1,NULL,NULL),(13,2012,'022.01','SSSJ.07','IKUSSSJ07.02','100',1,NULL,NULL),(14,2012,'022.01','SSSJ.08','IKUSSSJ08.01','WTP',1,NULL,NULL),(15,2012,'022.01','SSSJ.08','IKUSSSJ08.02','1056550582414',1,NULL,NULL),(16,2012,'022.01','SSSJ.08','IKUSSSJ08.03','100',1,NULL,NULL),(17,2012,'022.01','SSSJ.09','IKUSSSJ09.01','55',1,NULL,NULL),(18,2012,'022.01','SSSJ.09','IKUSSSJ09.02','10',1,NULL,NULL),(19,2012,'022.01','SSSJ.10','IKUSSSJ10.01','100',1,NULL,NULL),(20,2012,'022.01','SSSJ.10','IKUSSSJ10.02','40',1,NULL,NULL),(21,2012,'022.01','SSSJ.11','IKUSSSJ11.01','22',1,NULL,NULL),(22,2012,'022.01','SSSJ.11','IKUSSSJ11.02','3',1,NULL,NULL),(23,2012,'022.01','SSSJ.11','IKUSSSJ11.03','118',1,NULL,NULL),(24,2012,'022.01','SSSJ.11','IKUSSSJ11.04','4',1,NULL,NULL),(25,2012,'022.01','SSSJ.12','IKUSSSJ12.01','62.5',1,NULL,NULL),(26,2012,'022.01','SSSJ.12','IKUSSSJ12.02','25',1,NULL,NULL),(27,2012,'022.01','SSSJ.13','IKUSSSJ13.01','25',1,NULL,NULL),(28,2012,'022.01','SSSJ.14','IKUSSSJ14.01','136',1,NULL,NULL),(29,2012,'022.01','SSSJ.14','IKUSSSJ14.02','252',1,NULL,NULL),(30,2012,'022.02','SSIJ.01','IKUSSIJ01.01','0.09',1,NULL,NULL),(31,2012,'022.02','SSIJ.01','IKUSSIJ01.02','3',1,NULL,NULL),(32,2012,'022.02','SSIJ.02','IKUSSIJ02.01','73',1,NULL,NULL),(33,2012,'022.02','SSIJ.03','IKUSSIJ03.01','25',1,NULL,NULL),(34,2012,'022.02','SSIJ.04','IKUSSIJ04.01','85',1,NULL,NULL),(35,2012,'022.02','SSIJ.05','IKUSSIJ05.01','60',1,NULL,NULL),(36,2012,'022.02','SSIJ.05','IKUSSIJ05.02','90',1,NULL,NULL),(37,2012,'022.02','SSIJ.06','IKUSSIJ06.01','13',1,NULL,NULL),(38,2012,'022.02','SSIJ.07','IKUSSIJ07.01','93',1,NULL,NULL),(39,2012,'022.02','SSIJ.07','IKUSSIJ07.02','0.85',1,NULL,NULL),(40,2012,'022.02','SSIJ.07','IKUSSIJ07.03','87',1,NULL,NULL),(41,2012,'022.02','SSIJ.08','IKUSSIJ08.01','40',1,NULL,NULL),(42,2012,'022.02','SSIJ.08','IKUSSIJ08.02','170',1,NULL,NULL),(43,2012,'022.02','SSIJ.09','IKUSSIJ09.01','75',1,NULL,NULL),(44,2012,'022.03','SSPD.01','IKUSSPD01.01','0.244',1,NULL,NULL),(45,2012,'022.03','SSPD.01','IKUSSPD01.02','522',1,NULL,NULL),(46,2012,'022.03','SSPD.02','IKUSSPD02.01','17',1,NULL,NULL),(47,2012,'022.03','SSPD.02','IKUSSPD02.02','11',1,NULL,NULL),(48,2012,'022.03','SSPD.03','IKUSSPD03.01','4836',1,NULL,NULL),(49,2012,'022.03','SSPD.03','IKUSSPD03.02','2',1,NULL,NULL),(50,2012,'022.03','SSPD.04','IKUSSPD04.01','100',1,NULL,NULL),(51,2012,'022.03','SSPD.04','IKUSSPD04.02','69',1,NULL,NULL),(52,2012,'022.03','SSPD.05','IKUSSPD05.01','3',1,NULL,NULL),(53,2012,'022.03','SSPD.05','IKUSSPD05.02','96',1,NULL,NULL),(54,2012,'022.03','SSPD.05','IKUSSPD05.03','578',1,NULL,NULL),(55,2012,'022.03','SSPD.05','IKUSSPD05.04','14',1,NULL,NULL),(56,2012,'022.03','SSPD.05','IKUSSPD05.05','15',1,NULL,NULL),(57,2012,'022.03','SSPD.06','IKUSSPD06.01','169',1,NULL,NULL),(58,2012,'022.03','SSPD.06','IKUSSPD06.02','2335',1,NULL,NULL),(59,2012,'022.03','SSPD.06','IKUSSPD06.03','135',1,NULL,NULL),(60,2012,'022.03','SSPD.06','IKUSSPD06.04','47',1,NULL,NULL),(61,2012,'022.03','SSPD.07','IKUSSPD07.01','54882727',1,NULL,NULL),(62,2012,'022.03','SSPD.07','IKUSSPD07.02','6822202',1,NULL,NULL),(63,2012,'022.03','SSPD.07','IKUSSPD07.03','5524875',1,NULL,NULL),(64,2012,'022.03','SSPD.07','IKUSSPD07.04','3276851',1,NULL,NULL),(65,2012,'022.03','SSPD.07','IKUSSPD07.07','543061239',1,NULL,NULL),(66,2012,'022.03','SSPD.08','IKUSSPD08.01','0',1,NULL,NULL),(67,2012,'022.03','SSPD.08','IKUSSPD08.02','0',1,NULL,NULL),(68,2012,'022.03','SSPD.08','IKUSSPD08.03','1',1,NULL,NULL),(69,2012,'022.03','SSPD.08','IKUSSPD08.04','43.02',1,NULL,NULL),(70,2012,'022.03','SSPD.09','IKUSSPD09.01','84',1,NULL,NULL),(71,2012,'022.03','SSPD.09','IKUSSPD09.02','92.19',1,NULL,NULL),(72,2012,'022.03','SSPD.09','IKUSSPD09.03','6.57506E+12',1,NULL,NULL),(73,2012,'022.03','SSPD.10','IKUSSPD10.01','100',1,NULL,NULL),(74,2012,'022.03','SSPD.10','IKUSSPD10.02','202',1,NULL,NULL),(75,2012,'022.03','SSPD.11','IKUSSPD11.01','4',1,NULL,NULL),(76,2012,'022.03','SSPD.12','IKUSSPD12.01','17',1,NULL,NULL),(77,2012,'022.04','SSPL.01','IKUSSPL01.01','31',1,NULL,NULL),(78,2012,'022.04','SSPL.01','IKUSSPL01.02','48',1,NULL,NULL),(79,2012,'022.04','SSPL.02','IKUSSPL02.01','7146',1,NULL,NULL),(80,2012,'022.04','SSPL.03','IKUSSPL03.01','80',1,NULL,NULL),(81,2012,'022.04','SSPL.03','IKUSSPL03.02','393',1,NULL,NULL),(82,2012,'022.04','SSPL.04','IKUSSPL04.01','5027658',1,NULL,NULL),(83,2012,'022.04','SSPL.04','IKUSSPL04.02','629847',1,NULL,NULL),(84,2012,'022.04','SSPL.04','IKUSSPL04.03','327300000',1,NULL,NULL),(85,2012,'022.04','SSPL.04','IKUSSPL04.04','98.85',1,NULL,NULL),(86,2012,'022.04','SSPL.04','IKUSSPL04.05','59599000',1,NULL,NULL),(87,2012,'022.04','SSPL.04','IKUSSPL04.06','10',1,NULL,NULL),(88,2012,'022.04','SSPL.05','IKUSSPL05.01','30',1,NULL,NULL),(89,2012,'022.04','SSPL.06','IKUSSPL06.01','48',1,NULL,NULL),(90,2012,'022.04','SSPL.06','IKUSSPL06.02','48',1,NULL,NULL),(91,2012,'022.04','SSPL.06','IKUSSPL06.03','48',1,NULL,NULL),(92,2012,'022.04','SSPL.07','IKUSSPL07.01','2',1,NULL,NULL),(93,2012,'022.04','SSPL.08','IKUSSPL08.01','60',1,NULL,NULL),(94,2012,'022.04','SSPL.08','IKUSSPL08.02','120',1,NULL,NULL),(95,2012,'022.04','SSPL.08','IKUSSPL08.03','60',1,NULL,NULL),(96,2012,'022.04','SSPL.08','IKUSSPL08.04','367',1,NULL,NULL),(97,2012,'022.04','SSPL.08','IKUSSPL08.05','60',1,NULL,NULL),(98,2012,'022.04','SSPL.08','IKUSSPL08.06','120',1,NULL,NULL),(99,2012,'022.04','SSPL.08','IKUSSPL08.07','0',1,NULL,NULL),(100,2012,'022.04','SSPL.08','IKUSSPL08.08','0',1,NULL,NULL),(101,2012,'022.04','SSPL.08','IKUSSPL08.09','0',1,NULL,NULL),(102,2012,'022.04','SSPL.09','IKUSSPL09.01','78',1,NULL,NULL),(103,2012,'022.04','SSPL.09','IKUSSPL09.02','331485001206',1,NULL,NULL),(104,2012,'022.04','SSPL.09','IKUSSPL09.03','11550550774000',1,NULL,NULL),(105,2012,'022.04','SSPL.09','IKUSSPL09.04','26680195570824',1,NULL,NULL),(106,2012,'022.04','SSPL.10','IKUSSPL10.01','11',1,NULL,NULL),(107,2012,'022.04','SSPL.11','IKUSSPL11.01','0.4853',1,NULL,NULL),(108,2012,'022.04','SSPL.12','IKUSSPL12.01','6',1,NULL,NULL),(109,2012,'022.04','SSPL.12','IKUSSPL12.02','1021',1,NULL,NULL),(110,2012,'022.04','SSPL.12','IKUSSPL12.03','1527',1,NULL,NULL),(111,2012,'022.04','SSPL.12','IKUSSPL12.04','134',1,NULL,NULL),(112,2012,'022.04','SSPL.12','IKUSSPL12.05','245',1,NULL,NULL),(113,2012,'022.05','SSPU.01','IKUSSPU01.01','7.05',1,NULL,NULL),(114,2012,'022.05','SSPU.01','IKUSSPU01.02','56',1,NULL,NULL),(115,2012,'022.05','SSPU.02','IKUSSPU02.01','9',1,NULL,NULL),(116,2012,'022.05','SSPU.03','IKUSSPU03.01','76.26',1,NULL,NULL),(117,2012,'022.05','SSPU.04','IKUSSPU04.01','130',1,NULL,NULL),(118,2012,'022.05','SSPU.04','IKUSSPU04.02','274456',1,NULL,NULL),(119,2012,'022.05','SSPU.04','IKUSSPU04.03','127',1,NULL,NULL),(120,2012,'022.05','SSPU.05','IKUSSPU05.01','115',1,NULL,NULL),(121,2012,'022.05','SSPU.05','IKUSSPU05.02','77221559',1,NULL,NULL),(122,2012,'022.05','SSPU.05','IKUSSPU05.03','1096024',1,NULL,NULL),(123,2012,'022.05','SSPU.06','IKUSSPU06.01','1025',1,NULL,NULL),(124,2012,'022.05','SSPU.06','IKUSSPU06.02','15',1,NULL,NULL),(125,2012,'022.05','SSPU.07','IKUSSPU07.01','659',1,NULL,NULL),(126,2012,'022.05','SSPU.07','IKUSSPU07.02','56396',1,NULL,NULL),(127,2012,'022.05','SSPU.08','IKUSSPU08.01','10',1,NULL,NULL),(128,2012,'022.05','SSPU.09','IKUSSPU09.01','30',1,NULL,NULL),(129,2012,'022.05','SSPU.10','IKUSSPU10.01','83.61',1,NULL,NULL),(130,2012,'022.05','SSPU.10','IKUSSPU10.02','86',1,NULL,NULL),(131,2012,'022.05','SSPU.10','IKUSSPU10.03','29402885109165',1,NULL,NULL),(132,2012,'022.05','SSPU.11','IKUSSPU11.01','15',1,NULL,NULL),(133,2012,'022.05','SSPU.12','IKUSSPU12.01','3751009',1,NULL,NULL),(134,2012,'022.05','SSPU.12','IKUSSPU12.02','66272.15',1,NULL,NULL),(135,2012,'022.08','SSKA.01','IKUSSKA01.01','30',1,NULL,NULL),(136,2012,'022.08','SSKA.02','IKUSSKA02.01','78.94',1,NULL,NULL),(137,2012,'022.08','SSKA.02','IKUSSKA02.02','40',1,NULL,NULL),(138,2012,'022.08','SSKA.03','IKUSSKA03.01','2568',1,NULL,NULL),(139,2012,'022.08','SSKA.03','IKUSSKA03.02','17',1,NULL,NULL),(140,2012,'022.08','SSKA.04','IKUSSKA04.01','148',1,NULL,NULL),(141,2012,'022.08','SSKA.04','IKUSSKA04.02','63',1,NULL,NULL),(142,2012,'022.08','SSKA.04','IKUSSKA04.03','377.95',1,NULL,NULL),(143,2012,'022.08','SSKA.05','IKUSSKA05.01','5.57',1,NULL,NULL),(144,2012,'022.08','SSKA.05','IKUSSKA05.02','8.26',1,NULL,NULL),(145,2012,'022.08','SSKA.06','IKUSSKA06.01','99',1,NULL,NULL),(146,2012,'022.08','SSKA.06','IKUSSKA06.02','228400000',1,NULL,NULL),(147,2012,'022.08','SSKA.06','IKUSSKA06.03','29318000',1,NULL,NULL),(148,2012,'022.08','SSKA.07','IKUSSKA07.01','70',1,NULL,NULL),(149,2012,'022.08','SSKA.08','IKUSSKA08.01','82.99',1,NULL,NULL),(150,2012,'022.08','SSKA.08','IKUSSKA08.02','76.04',1,NULL,NULL),(151,2012,'022.08','SSKA.08','IKUSSKA08.03','76',1,NULL,NULL),(152,2012,'022.08','SSKA.09','IKUSSKA09.01','600',1,NULL,NULL),(153,2012,'022.08','SSKA.10','IKUSSKA10.01','10',1,NULL,NULL),(154,2012,'022.08','SSKA.11','IKUSSKA11.01','38',1,NULL,NULL),(155,2012,'022.08','SSKA.11','IKUSSKA11.02','1',1,NULL,NULL),(156,2012,'022.11','SSPP.01','IKUSSPP01.01','42',1,NULL,NULL),(157,2012,'022.11','SSPP.01','IKUSSPP01.02','158',1,NULL,NULL),(158,2012,'022.11','SSPP.02','IKUSSPP02.01','370',1,NULL,NULL),(159,2012,'022.12','SSSDM.01','IKUSSSDM01.01','162746',1,NULL,NULL),(160,2012,'022.12','SSSDM.02','IKUSSSDM02.01','163533',1,NULL,NULL),(161,2012,'022.12','SSSDM.03','IKUSSSDM03.01','103',1,NULL,NULL),(162,2012,'022.12','SSSDM.03','IKUSSSDM03.02','32',1,NULL,NULL),(163,2012,'022.12','SSSDM.04','IKUSSSDM04.01','23',1,NULL,NULL),(164,2012,'022.12','SSSDM.04','IKUSSSDM04.02','22',1,NULL,NULL),(165,2012,'022.12','SSSDM.04','IKUSSSDM04.03','32',1,NULL,NULL),(166,2012,'022.12','SSSDM.05','IKUSSSDM05.01','0',1,NULL,NULL),(167,2012,'022.12','SSSDM.06','IKUSSSDM06.01','10',1,NULL,NULL),(168,2012,'022.12','SSSDM.07','IKUSSSDM07.01','92',1,NULL,NULL),(169,2012,'022.12','SSSDM.07','IKUSSSDM07.02','90.54',1,NULL,NULL),(170,2012,'022.12','SSSDM.07','IKUSSSDM07.03','9112599346193',1,NULL,NULL),(171,2012,'022.12','SSSDM.08','IKUSSSDM08.01','19',1,NULL,NULL),(172,2012,'022.12','SSSDM.09','IKUSSSDM09.01','14133',1,NULL,NULL),(173,2012,'022.12','SSSDM.09','IKUSSSDM09.02','270509',1,NULL,NULL),(174,2012,'022.12','SSSDM.10','IKUSSSDM10.01','2905',1,NULL,NULL),(175,2013,'022.01','SSSJ.01','IKUSSSJ01.01','B',1,NULL,NULL),(176,2013,'022.01','SSSJ.01','IKUSSSJ01.02','AA',1,NULL,NULL),(177,2013,'022.01','SSSJ.02','IKUSSSJ02.01','90',1,NULL,NULL),(178,2013,'022.01','SSSJ.03','IKUSSSJ03.01','67',1,NULL,NULL),(179,2013,'022.01','SSSJ.03','IKUSSSJ03.02','220',1,NULL,NULL),(180,2013,'022.01','SSSJ.04','IKUSSSJ04.01','4',1,NULL,NULL),(181,2013,'022.01','SSSJ.05','IKUSSSJ05.01','9675000000',1,NULL,NULL),(182,2013,'022.01','SSSJ.05','IKUSSSJ05.02','80',1,NULL,NULL),(183,2013,'022.01','SSSJ.06','IKUSSSJ06.01','270',1,NULL,NULL),(184,2013,'022.01','SSSJ.06','IKUSSSJ06.02','1',1,NULL,NULL),(185,2013,'022.01','SSSJ.06','IKUSSSJ06.03','10',1,NULL,NULL),(186,2013,'022.01','SSSJ.07','IKUSSSJ07.01','7',1,NULL,NULL),(187,2013,'022.01','SSSJ.07','IKUSSSJ07.02','100',1,NULL,NULL),(188,2013,'022.01','SSSJ.08','IKUSSSJ08.01','WTP',1,NULL,NULL),(189,2013,'022.01','SSSJ.08','IKUSSSJ08.02','1088247100000',1,NULL,NULL),(190,2013,'022.01','SSSJ.08','IKUSSSJ08.03','100',1,NULL,NULL),(191,2013,'022.01','SSSJ.09','IKUSSSJ09.01','85',1,NULL,NULL),(192,2013,'022.01','SSSJ.09','IKUSSSJ09.02','10',1,NULL,NULL),(193,2013,'022.01','SSSJ.10','IKUSSSJ10.01','125',1,NULL,NULL),(194,2013,'022.01','SSSJ.10','IKUSSSJ10.02','60',1,NULL,NULL),(195,2013,'022.01','SSSJ.11','IKUSSSJ11.01','22',1,NULL,NULL),(196,2013,'022.01','SSSJ.11','IKUSSSJ11.02','3',1,NULL,NULL),(197,2013,'022.01','SSSJ.11','IKUSSSJ11.03','0',1,NULL,NULL),(198,2013,'022.01','SSSJ.11','IKUSSSJ11.04','5',1,NULL,NULL),(199,2013,'022.01','SSSJ.12','IKUSSSJ12.01','100',1,NULL,NULL),(200,2013,'022.01','SSSJ.12','IKUSSSJ12.02','100',1,NULL,NULL),(201,2013,'022.01','SSSJ.13','IKUSSSJ13.01','45',1,NULL,NULL),(202,2013,'022.01','SSSJ.14','IKUSSSJ14.01','103',1,NULL,NULL),(203,2013,'022.01','SSSJ.14','IKUSSSJ14.02','250',1,NULL,NULL),(204,2013,'022.02','SSIJ.01','IKUSSIJ01.01','0.09',1,NULL,NULL),(205,2013,'022.02','SSIJ.01','IKUSSIJ01.02','3',1,NULL,NULL),(206,2013,'022.02','SSIJ.02','IKUSSIJ02.01','73',1,NULL,NULL),(207,2013,'022.02','SSIJ.03','IKUSSIJ03.01','25',1,NULL,NULL),(208,2013,'022.02','SSIJ.04','IKUSSIJ04.01','85',1,NULL,NULL),(209,2013,'022.02','SSIJ.05','IKUSSIJ05.01','60',1,NULL,NULL),(210,2013,'022.02','SSIJ.05','IKUSSIJ05.02','90',1,NULL,NULL),(211,2013,'022.02','SSIJ.06','IKUSSIJ06.01','13',1,NULL,NULL),(212,2013,'022.02','SSIJ.07','IKUSSIJ07.01','93',1,NULL,NULL),(213,2013,'022.02','SSIJ.07','IKUSSIJ07.02','0.85',1,NULL,NULL),(214,2013,'022.02','SSIJ.07','IKUSSIJ07.03','87',1,NULL,NULL),(215,2013,'022.02','SSIJ.08','IKUSSIJ08.01','40',1,NULL,NULL),(216,2013,'022.02','SSIJ.08','IKUSSIJ08.02','170',1,NULL,NULL),(217,2013,'022.02','SSIJ.09','IKUSSIJ09.01','75',1,NULL,NULL),(218,2013,'022.03','SSPD.01','IKUSSPD01.01','1.39',1,NULL,NULL),(219,2013,'022.03','SSPD.01','IKUSSPD01.02','3238',1,NULL,NULL),(220,2013,'022.03','SSPD.02','IKUSSPD02.01','17',1,NULL,NULL),(221,2013,'022.03','SSPD.02','IKUSSPD02.02','11',1,NULL,NULL),(222,2013,'022.03','SSPD.03','IKUSSPD03.01','4856',1,NULL,NULL),(223,2013,'022.03','SSPD.03','IKUSSPD03.02','0',1,NULL,NULL),(224,2013,'022.03','SSPD.04','IKUSSPD04.01','100',1,NULL,NULL),(225,2013,'022.03','SSPD.04','IKUSSPD04.02','74',1,NULL,NULL),(226,2013,'022.03','SSPD.05','IKUSSPD05.01','3',1,NULL,NULL),(227,2013,'022.03','SSPD.05','IKUSSPD05.02','205',1,NULL,NULL),(228,2013,'022.03','SSPD.05','IKUSSPD05.03','26',1,NULL,NULL),(229,2013,'022.03','SSPD.05','IKUSSPD05.04','15',1,NULL,NULL),(230,2013,'022.03','SSPD.05','IKUSSPD05.05','16',1,NULL,NULL),(231,2013,'022.03','SSPD.06','IKUSSPD06.01','188',1,NULL,NULL),(232,2013,'022.03','SSPD.06','IKUSSPD06.02','2343',1,NULL,NULL),(233,2013,'022.03','SSPD.06','IKUSSPD06.03','163',1,NULL,NULL),(234,2013,'022.03','SSPD.06','IKUSSPD06.04','49',1,NULL,NULL),(235,2013,'022.03','SSPD.07','IKUSSPD07.01','55000000',1,NULL,NULL),(236,2013,'022.03','SSPD.07','IKUSSPD07.02','7000000',1,NULL,NULL),(237,2013,'022.03','SSPD.07','IKUSSPD07.03','6221563',1,NULL,NULL),(238,2013,'022.03','SSPD.07','IKUSSPD07.04','3300000',1,NULL,NULL),(239,2013,'022.03','SSPD.07','IKUSSPD07.05','1837703',1,NULL,NULL),(240,2013,'022.03','SSPD.07','IKUSSPD07.06','264167',1,NULL,NULL),(241,2013,'022.03','SSPD.07','IKUSSPD07.07','657104099',1,NULL,NULL),(242,2013,'022.03','SSPD.08','IKUSSPD08.01','71',1,NULL,NULL),(243,2013,'022.03','SSPD.08','IKUSSPD08.02','74',1,NULL,NULL),(244,2013,'022.03','SSPD.08','IKUSSPD08.03','100',1,NULL,NULL),(245,2013,'022.03','SSPD.08','IKUSSPD08.04','100',1,NULL,NULL),(246,2013,'022.03','SSPD.09','IKUSSPD09.01','85',1,NULL,NULL),(247,2013,'022.03','SSPD.09','IKUSSPD09.02','92.5',1,NULL,NULL),(248,2013,'022.03','SSPD.09','IKUSSPD09.03','11527543414208',1,NULL,NULL),(249,2013,'022.03','SSPD.10','IKUSSPD10.01','200',1,NULL,NULL),(250,2013,'022.03','SSPD.10','IKUSSPD10.02','302',1,NULL,NULL),(251,2013,'022.03','SSPD.11','IKUSSPD11.01','3',1,NULL,NULL),(252,2013,'022.03','SSPD.12','IKUSSPD12.01','15',1,NULL,NULL),(253,2013,'022.04','SSPL.01','IKUSSPL01.01','37',1,NULL,NULL),(254,2013,'022.04','SSPL.01','IKUSSPL01.02','21',1,NULL,NULL),(255,2013,'022.04','SSPL.02','IKUSSPL02.01','7.85',1,NULL,NULL),(256,2013,'022.04','SSPL.03','IKUSSPL03.01','89',1,NULL,NULL),(257,2013,'022.04','SSPL.03','IKUSSPL03.02','528',1,NULL,NULL),(258,2013,'022.04','SSPL.04','IKUSSPL04.01','5027658',1,NULL,NULL),(259,2013,'022.04','SSPL.04','IKUSSPL04.02','629847',1,NULL,NULL),(260,2013,'022.04','SSPL.04','IKUSSPL04.03','316480000',1,NULL,NULL),(261,2013,'022.04','SSPL.04','IKUSSPL04.04','98.82',1,NULL,NULL),(262,2013,'022.04','SSPL.04','IKUSSPL04.05','55180000',1,NULL,NULL),(263,2013,'022.04','SSPL.04','IKUSSPL04.06','9.5',1,NULL,NULL),(264,2013,'022.04','SSPL.05','IKUSSPL05.01','60',1,NULL,NULL),(265,2013,'022.04','SSPL.06','IKUSSPL06.01','48',1,NULL,NULL),(266,2013,'022.04','SSPL.06','IKUSSPL06.02','48',1,NULL,NULL),(267,2013,'022.04','SSPL.06','IKUSSPL06.03','48',1,NULL,NULL),(268,2013,'022.04','SSPL.07','IKUSSPL07.01','3',1,NULL,NULL),(269,2013,'022.04','SSPL.08','IKUSSPL08.01','60',1,NULL,NULL),(270,2013,'022.04','SSPL.08','IKUSSPL08.02','120',1,NULL,NULL),(271,2013,'022.04','SSPL.08','IKUSSPL08.03','60',1,NULL,NULL),(272,2013,'022.04','SSPL.08','IKUSSPL08.04','60',1,NULL,NULL),(273,2013,'022.04','SSPL.08','IKUSSPL08.05','60',1,NULL,NULL),(274,2013,'022.04','SSPL.08','IKUSSPL08.06','120',1,NULL,NULL),(275,2013,'022.04','SSPL.08','IKUSSPL08.07','60',1,NULL,NULL),(276,2013,'022.04','SSPL.08','IKUSSPL08.08','20',1,NULL,NULL),(277,2013,'022.04','SSPL.08','IKUSSPL08.09','20',1,NULL,NULL),(278,2013,'022.04','SSPL.09','IKUSSPL09.01','80',1,NULL,NULL),(279,2013,'022.04','SSPL.09','IKUSSPL09.02','309000000000',1,NULL,NULL),(280,2013,'022.04','SSPL.09','IKUSSPL09.03','9600000000000',1,NULL,NULL),(281,2013,'022.04','SSPL.09','IKUSSPL09.04','33100000000000',1,NULL,NULL),(282,2013,'022.04','SSPL.10','IKUSSPL10.01','7',1,NULL,NULL),(283,2013,'022.04','SSPL.11','IKUSSPL11.01','1.6122',1,NULL,NULL),(284,2013,'022.04','SSPL.12','IKUSSPL12.01','12',1,NULL,NULL),(285,2013,'022.04','SSPL.12','IKUSSPL12.02','1123',1,NULL,NULL),(286,2013,'022.04','SSPL.12','IKUSSPL12.03','1679',1,NULL,NULL),(287,2013,'022.04','SSPL.12','IKUSSPL12.04','152',1,NULL,NULL),(288,2013,'022.04','SSPL.12','IKUSSPL12.05','1679',1,NULL,NULL),(289,2013,'022.05','SSPU.01','IKUSSPU01.01','5.88',1,NULL,NULL),(290,2013,'022.05','SSPU.01','IKUSSPU01.02','54',1,NULL,NULL),(291,2013,'022.05','SSPU.02','IKUSSPU02.01','8',1,NULL,NULL),(292,2013,'022.05','SSPU.03','IKUSSPU03.01','79.52',1,NULL,NULL),(293,2013,'022.05','SSPU.04','IKUSSPU04.01','138',1,NULL,NULL),(294,2013,'022.05','SSPU.04','IKUSSPU04.02','288179',1,NULL,NULL),(295,2013,'022.05','SSPU.04','IKUSSPU04.03','130',1,NULL,NULL),(296,2013,'022.05','SSPU.05','IKUSSPU05.01','148',1,NULL,NULL),(297,2013,'022.05','SSPU.05','IKUSSPU05.02','88804793',1,NULL,NULL),(298,2013,'022.05','SSPU.05','IKUSSPU05.03','1260428',1,NULL,NULL),(299,2013,'022.05','SSPU.06','IKUSSPU06.01','1200',1,NULL,NULL),(300,2013,'022.05','SSPU.06','IKUSSPU06.02','15',1,NULL,NULL),(301,2013,'022.05','SSPU.07','IKUSSPU07.01','703',1,NULL,NULL),(302,2013,'022.05','SSPU.07','IKUSSPU07.02','65433',1,NULL,NULL),(303,2013,'022.05','SSPU.08','IKUSSPU08.01','10',1,NULL,NULL),(304,2013,'022.05','SSPU.09','IKUSSPU09.01','25',1,NULL,NULL),(305,2013,'022.05','SSPU.10','IKUSSPU10.01','84.61',1,NULL,NULL),(306,2013,'022.05','SSPU.10','IKUSSPU10.02','87',1,NULL,NULL),(307,2013,'022.05','SSPU.10','IKUSSPU10.03','33368327452365',1,NULL,NULL),(308,2013,'022.05','SSPU.11','IKUSSPU11.01','20',1,NULL,NULL),(309,2013,'022.05','SSPU.12','IKUSSPU12.01','4164021',1,NULL,NULL),(310,2013,'022.05','SSPU.12','IKUSSPU12.02','134618.81',1,NULL,NULL),(311,2013,'022.08','SSKA.01','IKUSSKA01.01','27',1,NULL,NULL),(312,2013,'022.08','SSKA.02','IKUSSKA02.01','79.33',1,NULL,NULL),(313,2013,'022.08','SSKA.02','IKUSSKA02.02','40',1,NULL,NULL),(314,2013,'022.08','SSKA.03','IKUSSKA03.01','2023',1,NULL,NULL),(315,2013,'022.08','SSKA.03','IKUSSKA03.02','15',1,NULL,NULL),(316,2013,'022.08','SSKA.04','IKUSSKA04.01','149',1,NULL,NULL),(317,2013,'022.08','SSKA.04','IKUSSKA04.02','63',1,NULL,NULL),(318,2013,'022.08','SSKA.04','IKUSSKA04.03','663',1,NULL,NULL),(319,2013,'022.08','SSKA.05','IKUSSKA05.01','6.12',1,NULL,NULL),(320,2013,'022.08','SSKA.05','IKUSSKA05.02','8.4',1,NULL,NULL),(321,2013,'022.08','SSKA.06','IKUSSKA06.01','32',1,NULL,NULL),(322,2013,'022.08','SSKA.06','IKUSSKA06.02','264500000',1,NULL,NULL),(323,2013,'022.08','SSKA.06','IKUSSKA06.03','37594000',1,NULL,NULL),(324,2013,'022.08','SSKA.07','IKUSSKA07.01','21',1,NULL,NULL),(325,2013,'022.08','SSKA.08','IKUSSKA08.01','83.92',1,NULL,NULL),(326,2013,'022.08','SSKA.08','IKUSSKA08.02','83.65',1,NULL,NULL),(327,2013,'022.08','SSKA.08','IKUSSKA08.03','79.8',1,NULL,NULL),(328,2013,'022.08','SSKA.09','IKUSSKA09.01','900',1,NULL,NULL),(329,2013,'022.08','SSKA.10','IKUSSKA10.01','9',1,NULL,NULL),(330,2013,'022.08','SSKA.11','IKUSSKA11.01','19',1,NULL,NULL),(331,2013,'022.08','SSKA.11','IKUSSKA11.02','1',1,NULL,NULL),(332,2013,'022.11','SSPP.01','IKUSSPP01.01','47',1,NULL,NULL),(333,2013,'022.11','SSPP.01','IKUSSPP01.02','258',1,NULL,NULL),(334,2013,'022.11','SSPP.02','IKUSSPP02.01','4',1,NULL,NULL),(335,2013,'022.12','SSSDM.01','IKUSSSDM01.01','179541',1,NULL,NULL),(336,2013,'022.12','SSSDM.02','IKUSSSDM02.01','177725',1,NULL,NULL),(337,2013,'022.12','SSSDM.03','IKUSSSDM03.01','92',1,NULL,NULL),(338,2013,'022.12','SSSDM.03','IKUSSSDM03.02','32',1,NULL,NULL),(339,2013,'022.12','SSSDM.04','IKUSSSDM04.01','40',1,NULL,NULL),(340,2013,'022.12','SSSDM.04','IKUSSSDM04.02','23',1,NULL,NULL),(341,2013,'022.12','SSSDM.04','IKUSSSDM04.03','70',1,NULL,NULL),(342,2013,'022.12','SSSDM.05','IKUSSSDM05.01','2',1,NULL,NULL),(343,2013,'022.12','SSSDM.06','IKUSSSDM06.01','15',1,NULL,NULL),(344,2013,'022.12','SSSDM.07','IKUSSSDM07.01','94',1,NULL,NULL),(345,2013,'022.12','SSSDM.07','IKUSSSDM07.02','92',1,NULL,NULL),(346,2013,'022.12','SSSDM.07','IKUSSSDM07.03','8814550000000',1,NULL,NULL),(347,2013,'022.12','SSSDM.08','IKUSSSDM08.01','25',1,NULL,NULL),(348,2013,'022.12','SSSDM.09','IKUSSSDM09.01','15270',1,NULL,NULL),(349,2013,'022.12','SSSDM.09','IKUSSSDM09.02','855276',1,NULL,NULL),(350,2013,'022.12','SSSDM.10','IKUSSSDM10.01','2905',1,NULL,NULL);
/*!40000 ALTER TABLE `tbl_rkt_eselon1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_rkt_eselon1_log`
--

DROP TABLE IF EXISTS `tbl_rkt_eselon1_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_rkt_eselon1_log` (
  `id_rkt_e1` int(11) NOT NULL AUTO_INCREMENT,
  `tahun` year(4) DEFAULT NULL,
  `kode_e1` varchar(10) DEFAULT NULL,
  `kode_sasaran_e1` varchar(20) DEFAULT NULL,
  `kode_iku_e1` varchar(20) DEFAULT NULL,
  `target` varchar(20) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `log` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_rkt_e1`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_rkt_eselon1_log`
--

LOCK TABLES `tbl_rkt_eselon1_log` WRITE;
/*!40000 ALTER TABLE `tbl_rkt_eselon1_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_rkt_eselon1_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_rkt_eselon2`
--

DROP TABLE IF EXISTS `tbl_rkt_eselon2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_rkt_eselon2` (
  `id_rkt_e2` int(11) NOT NULL AUTO_INCREMENT,
  `kode_e2` varchar(10) NOT NULL,
  `tahun` year(4) NOT NULL,
  `kode_sasaran_e2` varchar(20) NOT NULL,
  `kode_ikk` varchar(20) NOT NULL,
  `target` varchar(20) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `log_insert` varchar(50) DEFAULT NULL,
  `log_update` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_rkt_e2`),
  KEY `FK_tbl_rkt_eselon2_sasaran` (`kode_sasaran_e2`),
  KEY `FK_tbl_rkt_eselon2_ikk` (`kode_ikk`),
  KEY `FK_tbl_rkt_eselon2_e2` (`kode_e2`),
  CONSTRAINT `tbl_rkt_eselon2_ibfk_4` FOREIGN KEY (`kode_sasaran_e2`) REFERENCES `tbl_sasaran_eselon2` (`kode_sasaran_e2`) ON UPDATE CASCADE,
  CONSTRAINT `tbl_rkt_eselon2_ibfk_5` FOREIGN KEY (`kode_ikk`) REFERENCES `tbl_ikk` (`kode_ikk`) ON UPDATE CASCADE,
  CONSTRAINT `tbl_rkt_eselon2_ibfk_6` FOREIGN KEY (`kode_e2`) REFERENCES `tbl_eselon2` (`kode_e2`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_rkt_eselon2`
--

LOCK TABLES `tbl_rkt_eselon2` WRITE;
/*!40000 ALTER TABLE `tbl_rkt_eselon2` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_rkt_eselon2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_rkt_eselon2_log`
--

DROP TABLE IF EXISTS `tbl_rkt_eselon2_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_rkt_eselon2_log` (
  `id_rkt_e2` int(11) NOT NULL AUTO_INCREMENT,
  `kode_e2` varchar(10) DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `kode_sasaran_e2` varchar(20) DEFAULT NULL,
  `kode_ikk` varchar(20) DEFAULT NULL,
  `target` varchar(20) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `log` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_rkt_e2`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_rkt_eselon2_log`
--

LOCK TABLES `tbl_rkt_eselon2_log` WRITE;
/*!40000 ALTER TABLE `tbl_rkt_eselon2_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_rkt_eselon2_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_rkt_kl`
--

DROP TABLE IF EXISTS `tbl_rkt_kl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_rkt_kl` (
  `id_rkt_kl` int(11) NOT NULL AUTO_INCREMENT,
  `tahun` year(4) NOT NULL,
  `kode_kl` varchar(10) NOT NULL,
  `kode_sasaran_kl` varchar(20) NOT NULL,
  `kode_iku_kl` varchar(20) NOT NULL,
  `target` varchar(20) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `log_insert` varchar(50) DEFAULT NULL,
  `log_update` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_rkt_kl`),
  KEY `FK_tbl_rkt_kl` (`kode_kl`),
  KEY `FK_tbl_rkt_kl_sasaran` (`kode_sasaran_kl`),
  KEY `FK_tbl_rkt_kl_iku` (`kode_iku_kl`),
  CONSTRAINT `tbl_rkt_kl_ibfk_1` FOREIGN KEY (`kode_kl`) REFERENCES `tbl_kl` (`kode_kl`) ON UPDATE CASCADE,
  CONSTRAINT `tbl_rkt_kl_ibfk_2` FOREIGN KEY (`kode_sasaran_kl`) REFERENCES `tbl_sasaran_kl` (`kode_sasaran_kl`) ON UPDATE CASCADE,
  CONSTRAINT `tbl_rkt_kl_ibfk_3` FOREIGN KEY (`kode_iku_kl`) REFERENCES `tbl_iku_kl` (`kode_iku_kl`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_rkt_kl`
--

LOCK TABLES `tbl_rkt_kl` WRITE;
/*!40000 ALTER TABLE `tbl_rkt_kl` DISABLE KEYS */;
INSERT INTO `tbl_rkt_kl` VALUES (1,2012,'022','SSKP.01','IKUSSKP01.01','5233',1,NULL,NULL),(2,2012,'022','SSKP.02','IKUSSKP02.01','9',1,NULL,NULL),(3,2012,'022','SSKP.03','IKUSSKP03.01','71.73',1,NULL,NULL),(4,2012,'022','SSKP.04','IKUSSKP04.01','5225',1,NULL,NULL),(5,2012,'022','SSKP.04','IKUSSKP04.02','32',1,NULL,NULL),(6,2012,'022','SSKP.05','IKUSSKP05.01','564',1,NULL,NULL),(7,2012,'022','SSKP.06','IKUSSKP06.01','3.4',1,NULL,NULL),(8,2012,'022','SSKP.07','IKUSSKP07.01','840803197',1,NULL,NULL),(9,2012,'022','SSKP.07','IKUSSKP07.02','452122699.5',1,NULL,NULL),(10,2012,'022','SSKP.08','IKUSSKP08.01','2',1,NULL,NULL),(11,2012,'022','SSKP.09','IKUSSKP09.01','CC',1,NULL,NULL),(12,2012,'022','SSKP.09','IKUSSKP09.02','WTP',1,NULL,NULL),(13,2012,'022','SSKP.09','IKUSSKP09.03','124772341185388',1,NULL,NULL),(14,2012,'022','SSKP.10','IKUSSKP10.01','56396',1,NULL,NULL),(15,2012,'022','SSKP.10','IKUSSKP10.02','6168',1,NULL,NULL),(16,2012,'022','SSKP.10','IKUSSKP10.03','163533',1,NULL,NULL),(17,2012,'022','SSKP.11','IKUSSKP11.01','55',1,NULL,NULL),(18,2012,'022','SSKP.12','IKUSSKP12.01','51372.9',1,NULL,NULL),(19,2012,'022','SSKP.12','IKUSSKP12.02','120.2',1,NULL,NULL),(20,2012,'022','SSKP.13','IKUSSKP13.01','4884',1,NULL,NULL),(21,2012,'022','SSKP.13','IKUSSKP13.02','53',1,NULL,NULL),(22,2013,'022','SSKP.01','IKUSSKP01.01','5022',1,NULL,NULL),(23,2013,'022','SSKP.02','IKUSSKP02.01','8',1,NULL,NULL),(24,2013,'022','SSKP.03','IKUSSKP03.01','86.28',1,NULL,NULL),(25,2013,'022','SSKP.04','IKUSSKP04.01','25263',1,NULL,NULL),(26,2013,'022','SSKP.04','IKUSSKP04.02','198',1,NULL,NULL),(27,2013,'022','SSKP.05','IKUSSKP05.01','632',1,NULL,NULL),(28,2013,'022','SSKP.06','IKUSSKP06.01','1.8',1,NULL,NULL),(29,2013,'022','SSKP.07','IKUSSKP07.01','1078924455',1,NULL,NULL),(30,2013,'022','SSKP.07','IKUSSKP07.02','443054428',1,NULL,NULL),(31,2013,'022','SSKP.08','IKUSSKP08.01','3',1,NULL,NULL),(32,2013,'022','SSKP.09','IKUSSKP09.01','B',1,NULL,NULL),(33,2013,'022','SSKP.09','IKUSSKP09.02','WTP',1,NULL,NULL),(34,2013,'022','SSKP.09','IKUSSKP09.03','184153616755146',1,NULL,NULL),(35,2013,'022','SSKP.10','IKUSSKP10.01','65443',1,NULL,NULL),(36,2013,'022','SSKP.10','IKUSSKP10.02','6919',1,NULL,NULL),(37,2013,'022','SSKP.10','IKUSSKP10.03','177725',1,NULL,NULL),(38,2013,'022','SSKP.11','IKUSSKP11.01','200',1,NULL,NULL),(39,2013,'022','SSKP.12','IKUSSKP12.01','51659.1',1,NULL,NULL),(40,2013,'022','SSKP.12','IKUSSKP12.02','121',1,NULL,NULL),(41,2013,'022','SSKP.13','IKUSSKP13.01','5413',1,NULL,NULL),(42,2013,'022','SSKP.13','IKUSSKP13.02','67',1,NULL,NULL);
/*!40000 ALTER TABLE `tbl_rkt_kl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_rkt_kl_log`
--

DROP TABLE IF EXISTS `tbl_rkt_kl_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_rkt_kl_log` (
  `id_rkt_kl` int(11) NOT NULL AUTO_INCREMENT,
  `tahun` year(4) DEFAULT NULL,
  `kode_kl` varchar(10) DEFAULT NULL,
  `kode_sasaran_kl` varchar(20) DEFAULT NULL,
  `kode_iku_kl` varchar(20) DEFAULT NULL,
  `target` varchar(20) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `log` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_rkt_kl`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_rkt_kl_log`
--

LOCK TABLES `tbl_rkt_kl_log` WRITE;
/*!40000 ALTER TABLE `tbl_rkt_kl_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_rkt_kl_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_sasaran_eselon1`
--

DROP TABLE IF EXISTS `tbl_sasaran_eselon1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_sasaran_eselon1` (
  `tahun` year(4) NOT NULL,
  `kode_e1` varchar(10) NOT NULL,
  `kode_sasaran_e1` varchar(20) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `kode_sasaran_kl` varchar(20) DEFAULT NULL,
  `log_insert` varchar(50) DEFAULT NULL,
  `log_update` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`kode_sasaran_e1`,`tahun`),
  KEY `FK_tbl_sasaran_eselon1` (`kode_e1`),
  KEY `FK_tbl_sasaran_eselon1_sasarankl` (`kode_sasaran_kl`),
  CONSTRAINT `tbl_sasaran_eselon1_ibfk_1` FOREIGN KEY (`kode_e1`) REFERENCES `tbl_eselon1` (`kode_e1`) ON UPDATE CASCADE,
  CONSTRAINT `tbl_sasaran_eselon1_ibfk_2` FOREIGN KEY (`kode_sasaran_kl`) REFERENCES `tbl_sasaran_kl` (`kode_sasaran_kl`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_sasaran_eselon1`
--

LOCK TABLES `tbl_sasaran_eselon1` WRITE;
/*!40000 ALTER TABLE `tbl_sasaran_eselon1` DISABLE KEYS */;
INSERT INTO `tbl_sasaran_eselon1` VALUES (2012,'022.02','SSIJ.01','Terwujudnya aparatur perhubungan yang bersih dari Korupsi, Kolusi dan Nepotisme (KKN)','SSKP.10',NULL,NULL),(2013,'022.02','SSIJ.01','Terwujudnya aparatur perhubungan yang bersih dari Korupsi, Kolusi dan Nepotisme (KKN)','SSKP.10',NULL,NULL),(2012,'022.02','SSIJ.02','Peningkatan efektivitas tindak lanjut hasil pengawasan',NULL,NULL,NULL),(2013,'022.02','SSIJ.02','Peningkatan efektivitas tindak lanjut hasil pengawasan',NULL,NULL,NULL),(2012,'022.02','SSIJ.03','Peningkatan penerapan Sistem Pengendalian Intern',NULL,NULL,NULL),(2013,'022.02','SSIJ.03','Peningkatan penerapan Sistem Pengendalian Intern',NULL,NULL,NULL),(2012,'022.02','SSIJ.04','Peningkatan Akuntabilitas Kinerja Aparatur Perhubungan','SSKP.09',NULL,NULL),(2013,'022.02','SSIJ.04','Peningkatan Akuntabilitas Kinerja Aparatur Perhubungan','SSKP.09',NULL,NULL),(2012,'022.02','SSIJ.05','Peningkatan kualitas dan peran APIP',NULL,NULL,NULL),(2013,'022.02','SSIJ.05','Peningkatan kualitas dan peran APIP',NULL,NULL,NULL),(2012,'022.02','SSIJ.06','Peningkatan efektivitas pelaksanaan pengawasan',NULL,NULL,NULL),(2013,'022.02','SSIJ.06','Peningkatan efektivitas pelaksanaan pengawasan',NULL,NULL,NULL),(2012,'022.02','SSIJ.07','Peningkatan efektifitas, efisiensi dan akuntabilitas program dan kegiatan Inspektorat Jenderal','SSKP.09',NULL,NULL),(2013,'022.02','SSIJ.07','Peningkatan efektifitas, efisiensi dan akuntabilitas program dan kegiatan Inspektorat Jenderal','SSKP.09',NULL,NULL),(2012,'022.02','SSIJ.08','Peningkatan kualitas dan kompetensi SDM Pengawasan','SSKP.10',NULL,NULL),(2013,'022.02','SSIJ.08','Peningkatan kualitas dan kompetensi SDM Pengawasan','SSKP.10',NULL,NULL),(2012,'022.02','SSIJ.09','Peningkatan pemanfaatan Teknologi Informasi dan Komunikasi','SSKP.07',NULL,NULL),(2013,'022.02','SSIJ.09','Peningkatan pemanfaatan Teknologi Informasi dan Komunikasi','SSKP.07',NULL,NULL),(2012,'022.08','SSKA.01','Meningkatnya keselamatan pengoperasian perkeretaapian','SSKP.01',NULL,NULL),(2013,'022.08','SSKA.01','Meningkatnya keselamatan pengoperasian perkeretaapian','SSKP.01',NULL,NULL),(2012,'022.08','SSKA.02','Meningkatnya keandalan pengoperasian perkeretaapian',NULL,NULL,NULL),(2013,'022.08','SSKA.02','Meningkatnya keandalan pengoperasian perkeretaapian',NULL,NULL,NULL),(2012,'022.08','SSKA.03','Meningkatnya kelaikan sarana dan prasarana perkeretaapian dalam upaya meningkatkan keselamatan','SSKP.07',NULL,NULL),(2013,'022.08','SSKA.03','Meningkatnya kelaikan sarana dan prasarana perkeretaapian dalam upaya meningkatkan keselamatan','SSKP.07',NULL,NULL),(2012,'022.08','SSKA.04','Meningkatnya aksesibilitas masyarakat terhadap pelayanan angkutan kereta api','SSKP.05',NULL,NULL),(2013,'022.08','SSKA.04','Meningkatnya aksesibilitas masyarakat terhadap pelayanan angkutan kereta api','SSKP.05',NULL,NULL),(2012,'022.08','SSKA.05','Peningkatan manfaat pengoperasian perkeretaapian terhadap ekonomi dari pengurangan biaya transportasi angkutan barang dan penumpang','SSKP.06',NULL,NULL),(2013,'022.08','SSKA.05','Peningkatan manfaat pengoperasian perkeretaapian terhadap ekonomi dari pengurangan biaya transportasi angkutan barang dan penumpang','SSKP.06',NULL,NULL),(2012,'022.08','SSKA.06','Meningkatnya kapasitas pelayanan angkutan perkeretaapian','SSKP.03',NULL,NULL),(2013,'022.08','SSKA.06','Meningkatnya kapasitas pelayanan angkutan perkeretaapian','SSKP.03',NULL,NULL),(2012,'022.08','SSKA.07','Melanjutkan restrukturisasi kelembagaan di bidang perkeretaapian dalam mengupayakan multioperator','SSKP.11',NULL,NULL),(2013,'022.08','SSKA.07','Melanjutkan restrukturisasi kelembagaan di bidang perkeretaapian dalam mengupayakan multioperator','SSKP.11',NULL,NULL),(2012,'022.08','SSKA.08','Meningkatnya optimalisasi pengelolaan akuntabilitas kinerja, anggaran dan BMN Direktorat Jenderal Perkeretaapian','SSKP.09',NULL,NULL),(2013,'022.08','SSKA.08','Meningkatnya optimalisasi pengelolaan akuntabilitas kinerja, anggaran dan BMN Direktorat Jenderal Perkeretaapian','SSKP.09',NULL,NULL),(2012,'022.08','SSKA.09','Peningkatan jumlah dan kualitas SDM perkeretaapian yang bersertifikat dalam upaya meningkatkan keselamatan dan keandalan pelayanan KA','SSKP.10',NULL,NULL),(2013,'022.08','SSKA.09','Peningkatan jumlah dan kualitas SDM perkeretaapian yang bersertifikat dalam upaya meningkatkan keselamatan dan keandalan pelayanan KA','SSKP.10',NULL,NULL),(2012,'022.08','SSKA.10','Melanjutkan reformasi regulasi di bidang perkeretaapian','SSKP.11',NULL,NULL),(2013,'022.08','SSKA.10','Melanjutkan reformasi regulasi di bidang perkeretaapian','SSKP.11',NULL,NULL),(2012,'022.08','SSKA.11','Meningkatkan pengembangan teknologi perkeretaapian yang efisien dan ramah lingkungan sebagai antisipasi terhadap perubahan iklim','SSKP.13',NULL,NULL),(2013,'022.08','SSKA.11','Meningkatkan pengembangan teknologi perkeretaapian yang efisien dan ramah lingkungan sebagai antisipasi terhadap perubahan iklim','SSKP.13',NULL,NULL),(2012,'022.03','SSPD.01','Menurunnya dampak sub sektor transportasi darat terhadap lingkungan melalui pengurangan konsumsi energi tak tergantikan dan emisi gas buang','SSKP.12',NULL,NULL),(2013,'022.03','SSPD.01','Menurunnya dampak sub sektor transportasi darat terhadap lingkungan melalui pengurangan konsumsi energi tak tergantikan dan emisi gas buang','SSKP.12',NULL,NULL),(2012,'022.03','SSPD.02','Meningkatnya manfaat sub-sektor transportasi darat terhadap ekonomi melalui peningkatan/pembangunan sarana dan prasarana','SSKP.06',NULL,NULL),(2013,'022.03','SSPD.02','Meningkatnya manfaat sub-sektor transportasi darat terhadap ekonomi melalui peningkatan/pembangunan sarana dan prasarana','SSKP.06',NULL,NULL),(2012,'022.03','SSPD.03','Meningkatnya keselamatan transportasi darat','SSKP.01',NULL,NULL),(2013,'022.03','SSPD.03','Meningkatnya keselamatan transportasi darat','SSKP.01',NULL,NULL),(2012,'022.03','SSPD.04','Meningkatnya pelayanan transportasi darat sesuai SPM','SSKP.03',NULL,NULL),(2013,'022.03','SSPD.04','Meningkatnya pelayanan transportasi darat sesuai SPM','SSKP.03',NULL,NULL),(2012,'022.03','SSPD.05','Peningkatan penggunaan teknologi yang efisien dan ramah lingkungan di bidang transportasi darat','SSKP.13',NULL,NULL),(2013,'022.03','SSPD.05','Peningkatan penggunaan teknologi yang efisien dan ramah lingkungan di bidang transportasi darat','SSKP.13',NULL,NULL),(2012,'022.03','SSPD.06','Meningkatnya aksesibilitas masyarakat terhadap pelayanan sarana dan prasarana transportasi darat','SSKP.05',NULL,NULL),(2013,'022.03','SSPD.06','Meningkatnya aksesibilitas masyarakat terhadap pelayanan sarana dan prasarana transportasi darat','SSKP.05',NULL,NULL),(2012,'022.03','SSPD.07','Meningkatnya kapasitas sarana dan prasarana transportasi darat','SSKP.07',NULL,NULL),(2013,'022.03','SSPD.07','Meningkatnya kapasitas sarana dan prasarana transportasi darat','SSKP.07',NULL,NULL),(2012,'022.03','SSPD.08','Meningkatnya pemenuhan standar teknis dan standar operasional sarana dan prasarana transportasi darat','SSKP.04',NULL,NULL),(2013,'022.03','SSPD.08','Meningkatnya pemenuhan standar teknis dan standar operasional sarana dan prasarana transportasi darat','SSKP.04',NULL,NULL),(2012,'022.03','SSPD.09','Meningkatnya optimalisasi pengelolaan akuntabilitas kinerja, anggaran dan BMN Ditjen Perhubungan Darat','SSKP.09',NULL,NULL),(2013,'022.03','SSPD.09','Meningkatnya optimalisasi pengelolaan akuntabilitas kinerja, anggaran dan BMN Ditjen Perhubungan Darat','SSKP.09',NULL,NULL),(2012,'022.03','SSPD.10','Peningkatan kualitas SDM','SSKP.10',NULL,NULL),(2013,'022.03','SSPD.10','Peningkatan kualitas SDM','SSKP.10',NULL,NULL),(2012,'022.03','SSPD.11','Melanjutkan restrukturisasi kelembagaan di sub sektor transportasi darat','SSKP.11',NULL,NULL),(2013,'022.03','SSPD.11','Melanjutkan restrukturisasi kelembagaan di sub sektor transportasi darat','SSKP.11',NULL,NULL),(2012,'022.03','SSPD.12','Melanjutkan reformasi regulasi','SSKP.11',NULL,NULL),(2013,'022.03','SSPD.12','Melanjutkan reformasi regulasi','SSKP.11',NULL,NULL),(2012,'022.04','SSPL.01','Meningkatnya keselamatan pelayaran transportasi laut','SSKP.01',NULL,NULL),(2013,'022.04','SSPL.01','Meningkatnya keselamatan pelayaran transportasi laut','SSKP.01',NULL,NULL),(2012,'022.04','SSPL.02','Meningkatnya pemenuhan standar teknis dan standar operasional sarana dan prasarana transportasi laut','SSKP.04',NULL,NULL),(2013,'022.04','SSPL.02','Meningkatnya pemenuhan standar teknis dan standar operasional sarana dan prasarana transportasi laut','SSKP.04',NULL,NULL),(2012,'022.04','SSPL.03','Meningkatnya aksesibiltas masyarakat terhadap pelayanan sarana dan prasarana transportasi laut','SSKP.05',NULL,NULL),(2013,'022.04','SSPL.03','Meningkatnya aksesibiltas masyarakat terhadap pelayanan sarana dan prasarana transportasi laut','SSKP.05',NULL,NULL),(2012,'022.04','SSPL.04','Meningkatnya kapasitas pelayanan transportasi laut nasional','SSKP.03',NULL,NULL),(2013,'022.04','SSPL.04','Meningkatnya kapasitas pelayanan transportasi laut nasional','SSKP.03',NULL,NULL),(2012,'022.04','SSPL.05','Meningkatnya manfaat sub sektor transportasi laut terhadap ekonomi melalui pengurangan biaya transportasi penumpang dan barang','SSKP.06',NULL,NULL),(2013,'022.04','SSPL.05','Meningkatnya manfaat sub sektor transportasi laut terhadap ekonomi melalui pengurangan biaya transportasi penumpang dan barang','SSKP.06',NULL,NULL),(2012,'022.04','SSPL.06','Meningkatnya pelayanan pelayaran transportasi laut','SSKP.03',NULL,NULL),(2013,'022.04','SSPL.06','Meningkatnya pelayanan pelayaran transportasi laut','SSKP.03',NULL,NULL),(2012,'022.04','SSPL.07','Melanjutkan restrukturisasi kelembagaan di sub sektor transportasi laut ','SSKP.11',NULL,NULL),(2013,'022.04','SSPL.07','Melanjutkan restrukturisasi kelembagaan di sub sektor transportasi laut ','SSKP.11',NULL,NULL),(2012,'022.04','SSPL.08','Meningkatnya kualitas SDM di Sektor Transportasi Laut','SSKP.10',NULL,NULL),(2013,'022.04','SSPL.08','Meningkatnya kualitas SDM di Sektor Transportasi Laut','SSKP.10',NULL,NULL),(2012,'022.04','SSPL.09','Meningkatnya optimalisasi pengelolaan akuntabilitas kinerja, anggaran dan BMN Direktorat Jenderal Perhubungan Laut','SSKP.09',NULL,NULL),(2013,'022.04','SSPL.09','Meningkatnya optimalisasi pengelolaan akuntabilitas kinerja, anggaran dan BMN Direktorat Jenderal Perhubungan Laut','SSKP.09',NULL,NULL),(2012,'022.04','SSPL.10','Menurunnya dampak sub sektor transportasi laut terhadap lingkungan melalui pengurangan emisi gas buang','SSKP.12',NULL,NULL),(2013,'022.04','SSPL.10','Menurunnya dampak sub sektor transportasi laut terhadap lingkungan melalui pengurangan emisi gas buang','SSKP.12',NULL,NULL),(2012,'022.04','SSPL.11','Meningkatnya pelayanan dalam rangka perlindungan lingkungan maritim di bidang transportasi laut','SSKP.03',NULL,NULL),(2013,'022.04','SSPL.11','Meningkatnya pelayanan dalam rangka perlindungan lingkungan maritim di bidang transportasi laut','SSKP.03',NULL,NULL),(2012,'022.04','SSPL.12','Penataan peraturan perundang-undangan dan melanjutkan reformasi regulasi di bidang transportasi laut','SSKP.11',NULL,NULL),(2013,'022.04','SSPL.12','Penataan peraturan perundang-undangan dan melanjutkan reformasi regulasi di bidang transportasi laut','SSKP.11',NULL,NULL),(2012,'022.11','SSPP.01','Peningkatan kualitas penelitian dan pengembangan bidang perhubungan',NULL,NULL,NULL),(2013,'022.11','SSPP.01','Peningkatan kualitas penelitian dan pengembangan bidang perhubungan',NULL,NULL,NULL),(2012,'022.11','SSPP.02','Peningkatan kuantitas penelitian dan pengembangan bidang perhubungan',NULL,NULL,NULL),(2013,'022.11','SSPP.02','Peningkatan kuantitas penelitian dan pengembangan bidang perhubungan',NULL,NULL,NULL),(2012,'022.05','SSPU.01','Meningkatnya keselamatan jasa transportasi udara','SSKP.01',NULL,NULL),(2013,'022.05','SSPU.01','Meningkatnya keselamatan jasa transportasi udara','SSKP.01',NULL,NULL),(2012,'022.05','SSPU.02','Meningkatnya keamanan jasa transportasi udara','SSKP.02',NULL,NULL),(2013,'022.05','SSPU.02','Meningkatnya keamanan jasa transportasi udara','SSKP.02',NULL,NULL),(2012,'022.05','SSPU.03','Meningkatnya pelayanan jasa transportasi udara','SSKP.03',NULL,NULL),(2013,'022.05','SSPU.03','Meningkatnya pelayanan jasa transportasi udara','SSKP.03',NULL,NULL),(2012,'022.05','SSPU.04','Meningkatnya aksesibilitas pelayanan jasa transportasi udara dan konektivitas antar wilayah','SSKP.05',NULL,NULL),(2013,'022.05','SSPU.04','Meningkatnya aksesibilitas pelayanan jasa transportasi udara dan konektivitas antar wilayah','SSKP.05',NULL,NULL),(2012,'022.05','SSPU.05','Meningkatnya kapasitas sarana dan prasarana transportasi udara sesuai ketentuan sehingga dapat memberikan dukungan bagi perekonomian nasional yang berkelanjutan (sustainable growth)','SSKP.07',NULL,NULL),(2013,'022.05','SSPU.05','Meningkatnya kapasitas sarana dan prasarana transportasi udara sesuai ketentuan sehingga dapat memberikan dukungan bagi perekonomian nasional yang berkelanjutan (sustainable growth)','SSKP.07',NULL,NULL),(2012,'022.05','SSPU.06','Meningkatnya pemenuhan standar teknis dan standar operasional sarana dan prasarana transportasi udara','SSKP.04',NULL,NULL),(2013,'022.05','SSPU.06','Meningkatnya pemenuhan standar teknis dan standar operasional sarana dan prasarana transportasi udara','SSKP.04',NULL,NULL),(2012,'022.05','SSPU.07','Peningkatan kualitas SDM','SSKP.10',NULL,NULL),(2013,'022.05','SSPU.07','Peningkatan kualitas SDM','SSKP.10',NULL,NULL),(2012,'022.05','SSPU.08','Melanjutkan restrukturisasi kelembagaan','SSKP.11',NULL,NULL),(2013,'022.05','SSPU.08','Melanjutkan restrukturisasi kelembagaan','SSKP.11',NULL,NULL),(2012,'022.05','SSPU.09','Melanjutkan reformasi regulasi','SSKP.11',NULL,NULL),(2013,'022.05','SSPU.09','Melanjutkan reformasi regulasi','SSKP.11',NULL,NULL),(2012,'022.05','SSPU.10','Meningkatnya optimalisasi pengelolaan akuntabilitas kinerja, anggaran dan BMN Direktorat Jenderal Perhubungan Udara','SSKP.09',NULL,NULL),(2013,'022.05','SSPU.10','Meningkatnya optimalisasi pengelolaan akuntabilitas kinerja, anggaran dan BMN Direktorat Jenderal Perhubungan Udara','SSKP.09',NULL,NULL),(2012,'022.05','SSPU.11','Meningkatkan pengembangan teknologi transportasi udara yang efisien dan ramah lingkungan sebagai antisipasi terhadap perubahan iklim','SSKP.13',NULL,NULL),(2013,'022.05','SSPU.11','Meningkatkan pengembangan teknologi transportasi udara yang efisien dan ramah lingkungan sebagai antisipasi terhadap perubahan iklim','SSKP.13',NULL,NULL),(2012,'022.05','SSPU.12','Menurunnya dampak transportasi udara terhadap lingkungan melalui pengurangan konsumsi energi tak terbarukan dan emisi gas buang','SSKP.12',NULL,NULL),(2013,'022.05','SSPU.12','Menurunnya dampak transportasi udara terhadap lingkungan melalui pengurangan konsumsi energi tak terbarukan dan emisi gas buang','SSKP.12',NULL,NULL),(2012,'022.12','SSSDM.01','Terwujudnya peserta Diklat Transportasi yang berpotensi tinggi yang didukung fisik dan jasmani yang prima','SSKP.10',NULL,NULL),(2013,'022.12','SSSDM.01','Terwujudnya peserta Diklat Transportasi yang berpotensi tinggi yang didukung fisik dan jasmani yang prima','SSKP.10',NULL,NULL),(2012,'022.12','SSSDM.02','Terwujudnya lulusan Diklat Transportasi yang prima, profesional dan beretika','SSKP.10',NULL,NULL),(2013,'022.12','SSSDM.02','Terwujudnya lulusan Diklat Transportasi yang prima, profesional dan beretika','SSKP.10',NULL,NULL),(2012,'022.12','SSSDM.03','Terwujudnya sistem dan metoda penyelenggaraan Diklat Transportasi yang berbasis teknologi informasi',NULL,NULL,NULL),(2013,'022.12','SSSDM.03','Terwujudnya sistem dan metoda penyelenggaraan Diklat Transportasi yang berbasis teknologi informasi',NULL,NULL,NULL),(2012,'022.12','SSSDM.04','Terwujudnya kurikulum dan silabi Diklat Transportasi yang berbasis kompetensi (harmonization, compliance and demand fullfillment curriculum) dan sesuai dengan perkembangan IPTEK',NULL,NULL,NULL),(2013,'022.12','SSSDM.04','Terwujudnya kurikulum dan silabi Diklat Transportasi yang berbasis kompetensi (harmonization, compliance and demand fullfillment curriculum) dan sesuai dengan perkembangan IPTEK',NULL,NULL,NULL),(2012,'022.12','SSSDM.05','Terwujudnya lembaga Diklat Transportasi yang mandiri dan profesional, transparan dan akuntabel yang diarahkan untuk menjadi Badan Layanan Umum (BLU)',NULL,NULL,NULL),(2013,'022.12','SSSDM.05','Terwujudnya lembaga Diklat Transportasi yang mandiri dan profesional, transparan dan akuntabel yang diarahkan untuk menjadi Badan Layanan Umum (BLU)',NULL,NULL,NULL),(2012,'022.12','SSSDM.06','Terwujudnya kerjasama dan kemitraan yang baik dalam rangka mewujudkan kemandirian dan profesionalisme lembaga diklat, international recognition serta Public Private Partnership',NULL,NULL,NULL),(2013,'022.12','SSSDM.06','Terwujudnya kerjasama dan kemitraan yang baik dalam rangka mewujudkan kemandirian dan profesionalisme lembaga diklat, international recognition serta Public Private Partnership',NULL,NULL,NULL),(2012,'022.12','SSSDM.07','Meningkatnya optimalisasi pengelolaan akuntabilitas kinerja, anggaran dan BMN BPSDM Perhubungan','SSKP.09',NULL,NULL),(2013,'022.12','SSSDM.07','Meningkatnya optimalisasi pengelolaan akuntabilitas kinerja, anggaran dan BMN BPSDM Perhubungan','SSKP.09',NULL,NULL),(2012,'022.12','SSSDM.08','Terwujudnya peraturan perundangan dan ketentuan pelaksanaan lainnya di bidang SDM transportasi yang memenuhi ketentuan nasional dan/atau internasional',NULL,NULL,NULL),(2013,'022.12','SSSDM.08','Terwujudnya peraturan perundangan dan ketentuan pelaksanaan lainnya di bidang SDM transportasi yang memenuhi ketentuan nasional dan/atau internasional',NULL,NULL,NULL),(2012,'022.12','SSSDM.09','Terwujudnya sarana dan prasarana Diklat Transportasi berbasis teknologi tinggi/mutakhir yang memenuhi standar nasional dan/atau internasional','SSKP.07',NULL,NULL),(2013,'022.12','SSSDM.09','Terwujudnya sarana dan prasarana Diklat Transportasi berbasis teknologi tinggi/mutakhir yang memenuhi standar nasional dan/atau internasional','SSKP.07',NULL,NULL),(2012,'022.12','SSSDM.10','Tersedianya tenaga kependidikan Diklat Transportasi yang prima, profesional dan beretika','SSKP.10',NULL,NULL),(2013,'022.12','SSSDM.10','Tersedianya tenaga kependidikan Diklat Transportasi yang prima, profesional dan beretika','SSKP.10',NULL,NULL),(2012,'022.01','SSSJ.01','Peningkatan Akuntabilitas Kinerja Sekretariat Jenderal Kementerian Perhubungan melalui tersedianya Dokumen Perencanaan, Pemrograman, Kebijakan Pentarifan, dan Dokumen Analisa dan Evaluasi sebagai acuan dalam penyelenggaraan perhubungan','SSKP.09',NULL,NULL),(2013,'022.01','SSSJ.01','Peningkatan Akuntabilitas Kinerja Sekretariat Jenderal Kementerian Perhubungan melalui tersedianya Dokumen Perencanaan, Pemrograman, Kebijakan Pentarifan, dan Dokumen Analisa dan Evaluasi sebagai acuan dalam penyelenggaraan perhubungan','SSKP.09',NULL,NULL),(2012,'022.01','SSSJ.02','Terwujudnya pelayanan administrasi dalam menunjang tugas',NULL,NULL,NULL),(2013,'022.01','SSSJ.02','Terwujudnya pelayanan administrasi dalam menunjang tugas',NULL,NULL,NULL),(2012,'022.01','SSSJ.03','Terwujudnya komunikasi dan pelayanan informasi sektor transportasi kepada publik yang didukung oleh SDM aparatur perhubungan dengan kompetensi kehumasan untuk meningkatkan citra positif Kementerian Perhubungan',NULL,NULL,NULL),(2013,'022.01','SSSJ.03','Terwujudnya komunikasi dan pelayanan informasi sektor transportasi kepada publik yang didukung oleh SDM aparatur perhubungan dengan kompetensi kehumasan untuk meningkatkan citra positif Kementerian Perhubungan',NULL,NULL,NULL),(2012,'022.01','SSSJ.04','Terwujudnya kerjasama luar negeri baik dalam skala regional maupun global',NULL,NULL,NULL),(2013,'022.01','SSSJ.04','Terwujudnya kerjasama luar negeri baik dalam skala regional maupun global',NULL,NULL,NULL),(2012,'022.01','SSSJ.05','Kecukupan sarana prasarana dalam menunjang pelaksanaan tugas secara efektif dan efisien','SSKP.07',NULL,NULL),(2013,'022.01','SSSJ.05','Kecukupan sarana prasarana dalam menunjang pelaksanaan tugas secara efektif dan efisien','SSKP.07',NULL,NULL),(2012,'022.01','SSSJ.06','Terwujudnya pengelolaan SDM aparatur perhubungan yang berintegritas, netral, capable, profesional, berkinerja tinggi dan sejahtera serta beretika','SSKP.10',NULL,NULL),(2013,'022.01','SSSJ.06','Terwujudnya pengelolaan SDM aparatur perhubungan yang berintegritas, netral, capable, profesional, berkinerja tinggi dan sejahtera serta beretika','SSKP.10',NULL,NULL),(2012,'022.01','SSSJ.07','Terwujudnya organisasi yang tepat fungsi dan tepat sasaran melalui sistem, proses dan tata laksana yang rasional, jelas, efektif, efisien, terukur, dan sesuai dengan visi Reformasi Birokrasi','SSKP.11',NULL,NULL),(2013,'022.01','SSSJ.07','Terwujudnya organisasi yang tepat fungsi dan tepat sasaran melalui sistem, proses dan tata laksana yang rasional, jelas, efektif, efisien, terukur, dan sesuai dengan visi Reformasi Birokrasi','SSKP.11',NULL,NULL),(2012,'022.01','SSSJ.08','Terwujudnya laporan keuangan Kementerian Perhubungan (LRA, Neraca dan CaLK) dengan penilaian opini WTP',NULL,NULL,NULL),(2013,'022.01','SSSJ.08','Terwujudnya laporan keuangan Kementerian Perhubungan (LRA, Neraca dan CaLK) dengan penilaian opini WTP',NULL,NULL,NULL),(2012,'022.01','SSSJ.09','Terwujudnya reformasi kelembagaan dan peraturan perundang-undangan','SSKP.11',NULL,NULL),(2013,'022.01','SSSJ.09','Terwujudnya reformasi kelembagaan dan peraturan perundang-undangan','SSKP.11',NULL,NULL),(2012,'022.01','SSSJ.10','Terwujudnya infrastruktur jaringan TIK untuk layanan data dan informasi perhubungan yang cepat, tepat, akurat dan up-to-date berbasis teknologi informasi','SSKP.07',NULL,NULL),(2013,'022.01','SSSJ.10','Terwujudnya infrastruktur jaringan TIK untuk layanan data dan informasi perhubungan yang cepat, tepat, akurat dan up-to-date berbasis teknologi informasi','SSKP.07',NULL,NULL),(2012,'022.01','SSSJ.11','Terwujudnya rekomendasi hasil kajian kemitraan dan pelayanan jasa serta lingkungan hidup oleh sub sektor',NULL,NULL,NULL),(2013,'022.01','SSSJ.11','Terwujudnya rekomendasi hasil kajian kemitraan dan pelayanan jasa serta lingkungan hidup oleh sub sektor',NULL,NULL,NULL),(2012,'022.01','SSSJ.12','Terselenggaranya persidangan pemerikasaan lanjutan kecelakaan kapal sesuai ketentuan peraturan perundang-undangan',NULL,NULL,NULL),(2013,'022.01','SSSJ.12','Terselenggaranya persidangan pemerikasaan lanjutan kecelakaan kapal sesuai ketentuan peraturan perundang-undangan',NULL,NULL,NULL),(2012,'022.01','SSSJ.13','Tersedianya data dan informasi putusan kecelakaan kapal',NULL,NULL,NULL),(2013,'022.01','SSSJ.13','Tersedianya data dan informasi putusan kecelakaan kapal',NULL,NULL,NULL),(2012,'022.01','SSSJ.14','Terwujudnya pelaksanaan investasi dan penelitian kecelakaan transportasi',NULL,NULL,NULL),(2013,'022.01','SSSJ.14','Terwujudnya pelaksanaan investasi dan penelitian kecelakaan transportasi',NULL,NULL,NULL);
/*!40000 ALTER TABLE `tbl_sasaran_eselon1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_sasaran_eselon1_log`
--

DROP TABLE IF EXISTS `tbl_sasaran_eselon1_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_sasaran_eselon1_log` (
  `tahun` year(4) DEFAULT NULL,
  `kode_e1` varchar(10) DEFAULT NULL,
  `kode_sasaran_e1` varchar(20) DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `kode_sasaran_kl` varchar(20) DEFAULT NULL,
  `log` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_sasaran_eselon1_log`
--

LOCK TABLES `tbl_sasaran_eselon1_log` WRITE;
/*!40000 ALTER TABLE `tbl_sasaran_eselon1_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_sasaran_eselon1_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_sasaran_eselon2`
--

DROP TABLE IF EXISTS `tbl_sasaran_eselon2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_sasaran_eselon2` (
  `tahun` year(4) NOT NULL,
  `kode_e2` varchar(10) NOT NULL,
  `kode_sasaran_e2` varchar(20) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `kode_sasaran_e1` varchar(20) DEFAULT NULL,
  `log_insert` varchar(50) DEFAULT NULL,
  `log_update` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`kode_sasaran_e2`,`tahun`),
  KEY `FK_tbl_sasaran_eselon2` (`kode_e2`),
  KEY `FK_tbl_sasaran_eselon2_sasarane1` (`kode_sasaran_e1`),
  CONSTRAINT `tbl_sasaran_eselon2_ibfk_1` FOREIGN KEY (`kode_e2`) REFERENCES `tbl_eselon2` (`kode_e2`) ON UPDATE CASCADE,
  CONSTRAINT `tbl_sasaran_eselon2_ibfk_2` FOREIGN KEY (`kode_sasaran_e1`) REFERENCES `tbl_sasaran_eselon1` (`kode_sasaran_e1`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_sasaran_eselon2`
--

LOCK TABLES `tbl_sasaran_eselon2` WRITE;
/*!40000 ALTER TABLE `tbl_sasaran_eselon2` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_sasaran_eselon2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_sasaran_eselon2_log`
--

DROP TABLE IF EXISTS `tbl_sasaran_eselon2_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_sasaran_eselon2_log` (
  `tahun` year(4) DEFAULT NULL,
  `kode_e2` varchar(10) DEFAULT NULL,
  `kode_sasaran_e2` varchar(20) DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `kode_sasaran_e1` varchar(20) DEFAULT NULL,
  `log` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_sasaran_eselon2_log`
--

LOCK TABLES `tbl_sasaran_eselon2_log` WRITE;
/*!40000 ALTER TABLE `tbl_sasaran_eselon2_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_sasaran_eselon2_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_sasaran_kl`
--

DROP TABLE IF EXISTS `tbl_sasaran_kl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_sasaran_kl` (
  `tahun` year(4) NOT NULL,
  `kode_kl` varchar(10) NOT NULL,
  `kode_sasaran_kl` varchar(20) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `log_insert` varchar(50) DEFAULT NULL,
  `log_update` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`kode_sasaran_kl`,`tahun`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_sasaran_kl`
--

LOCK TABLES `tbl_sasaran_kl` WRITE;
/*!40000 ALTER TABLE `tbl_sasaran_kl` DISABLE KEYS */;
INSERT INTO `tbl_sasaran_kl` VALUES (2012,'022','SSKP.01','Meningkatnya keselamatan transportasi',NULL,NULL),(2013,'022','SSKP.01','Meningkatnya keselamatan transportasi',NULL,NULL),(2012,'022','SSKP.02','Meningkatnya keamanan transportasi',NULL,NULL),(2013,'022','SSKP.02','Meningkatnya keamanan transportasi',NULL,NULL),(2012,'022','SSKP.03','Meningkatnya pelayanan transportasi',NULL,NULL),(2013,'022','SSKP.03','Meningkatnya pelayanan transportasi',NULL,NULL),(2012,'022','SSKP.04','Meningkatnya pemenuhan standar teknis dan standar operasional sarana dan prasarana trasnportasi',NULL,NULL),(2013,'022','SSKP.04','Meningkatnya pemenuhan standar teknis dan standar operasional sarana dan prasarana trasnportasi',NULL,NULL),(2012,'022','SSKP.05','Meningkatnya aksesibiltas masyarakat terhadap pelayanan sarana dan prasarana transportasi guna mendorong konektivitas antar wilayah',NULL,NULL),(2013,'022','SSKP.05','Meningkatnya aksesibiltas masyarakat terhadap pelayanan sarana dan prasarana transportasi guna mendorong konektivitas antar wilayah',NULL,NULL),(2012,'022','SSKP.06','Meningkatnya manfaat sektor transportasi terhadap pertumbuhan ekonomi',NULL,NULL),(2013,'022','SSKP.06','Meningkatnya manfaat sektor transportasi terhadap pertumbuhan ekonomi',NULL,NULL),(2012,'022','SSKP.07','Meningkatnya kapasitas sarana dan prasarana transportasi untuk mengurangi backlog dan bottleneck kapasitas infrastruktur transportasi',NULL,NULL),(2013,'022','SSKP.07','Meningkatnya kapasitas sarana dan prasarana transportasi untuk mengurangi backlog dan bottleneck kapasitas infrastruktur transportasi',NULL,NULL),(2012,'022','SSKP.08','Meningkatkan peran serta Pemda, BUMN dan swasta dalam penyediaan infrastruktur transportasi ',NULL,NULL),(2013,'022','SSKP.08','Meningkatkan peran serta Pemda, BUMN dan swasta dalam penyediaan infrastruktur transportasi ',NULL,NULL),(2012,'022','SSKP.09','Meningkatnya optimalisasi pengelolaan akuntabilitas kinerja, anggaran dan BMN',NULL,NULL),(2013,'022','SSKP.09','Meningkatnya optimalisasi pengelolaan akuntabilitas kinerja, anggaran dan BMN',NULL,NULL),(2012,'022','SSKP.10','Peningkatan kualitas SDM',NULL,NULL),(2013,'022','SSKP.10','Peningkatan kualitas SDM',NULL,NULL),(2012,'022','SSKP.11','Melanjutkan reformasi regulasi',NULL,NULL),(2013,'022','SSKP.11','Melanjutkan reformasi regulasi',NULL,NULL),(2012,'022','SSKP.12','Menurunnya dampak sektor transportasi terhadap lingkungan',NULL,NULL),(2013,'022','SSKP.12','Menurunnya dampak sektor transportasi terhadap lingkungan',NULL,NULL),(2012,'022','SSKP.13','Meningkatkan pengembangan teknologi transportasi yang efisien dan ramah lingkungan sebagai antisipasi terhadap perubahan iklim',NULL,NULL),(2013,'022','SSKP.13','Meningkatkan pengembangan teknologi transportasi yang efisien dan ramah lingkungan sebagai antisipasi terhadap perubahan iklim',NULL,NULL);
/*!40000 ALTER TABLE `tbl_sasaran_kl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_sasaran_kl_log`
--

DROP TABLE IF EXISTS `tbl_sasaran_kl_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_sasaran_kl_log` (
  `tahun` year(4) DEFAULT NULL,
  `kode_kl` varchar(10) DEFAULT NULL,
  `kode_sasaran_kl` varchar(20) DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `log` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_sasaran_kl_log`
--

LOCK TABLES `tbl_sasaran_kl_log` WRITE;
/*!40000 ALTER TABLE `tbl_sasaran_kl_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_sasaran_kl_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_user`
--

DROP TABLE IF EXISTS `tbl_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_user` (
  `user_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `passwd` varchar(100) DEFAULT NULL,
  `group_id` smallint(6) DEFAULT NULL,
  `app_type` enum('KL','E1','E2') DEFAULT NULL,
  `unit_kerja_e1` varchar(30) DEFAULT NULL,
  `unit_kerja_e2` varchar(30) DEFAULT NULL,
  `level_id` smallint(6) DEFAULT NULL,
  `log_insert` varchar(50) DEFAULT NULL,
  `log_update` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `fk_user_group` (`group_id`),
  CONSTRAINT `tbl_user_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `tbl_group_user` (`group_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_user`
--

LOCK TABLES `tbl_user` WRITE;
/*!40000 ALTER TABLE `tbl_user` DISABLE KEYS */;
INSERT INTO `tbl_user` VALUES (1,'adminkl','Administrator KL','ac8210c537b72dd8e806cc298b0f9ea3',1,'KL',NULL,NULL,2,NULL,NULL),(2,'admine1','Administrator Eselon 1','ac8210c537b72dd8e806cc298b0f9ea3',2,'E1','022.03','-1',2,NULL,NULL),(3,'admine2','Administrator Eselon 2','ac8210c537b72dd8e806cc298b0f9ea3',3,'E2','022.01','022.01.01',2,NULL,NULL),(4,'opkl','Operator KL','ac8210c537b72dd8e806cc298b0f9ea3',1,'KL',NULL,NULL,2,NULL,NULL),(5,'ope1','Operator Eselon 1','ac8210c537b72dd8e806cc298b0f9ea3',2,'E1',NULL,NULL,2,NULL,NULL),(6,'op32','Operator Eselon 2','ac8210c537b72dd8e806cc298b0f9ea3',3,'E2',NULL,NULL,2,NULL,NULL),(7,'hubla','Direktorat Jenderal Perhubungan Laut','ac8210c537b72dd8e806cc298b0f9ea3',2,'E1','022.04','-1',2,NULL,'8;2013-02-01 14:48:56'),(8,'superadmin','Administrator','ac8210c537b72dd8e806cc298b0f9ea3',7,NULL,'-1','-1',1,NULL,NULL),(9,'hubdat','Direktorat Jenderal Perhubungan Darat','ac8210c537b72dd8e806cc298b0f9ea3',2,'E1','022.03','-1',2,NULL,'8;2013-02-01 14:49:11'),(10,'hubud','Direktorat Jenderal Perhubungan Udara','ac8210c537b72dd8e806cc298b0f9ea3',2,'E1','022.05','-1',2,NULL,'8;2013-02-01 14:48:39'),(84,'setjen2','Sekretariat Jenderal Kementerian Perhubungan','ac8210c537b72dd8e806cc298b0f9ea3',2,'E1','022.01','-1',3,NULL,'8;2013-02-01 14:52:56'),(85,'itjen2','Inspektorat Jenderal Kementerian Perhubungan','ac8210c537b72dd8e806cc298b0f9ea3',2,'E1','022.02','-1',3,NULL,'8;2013-02-01 14:52:19'),(86,'hubdat2','Direktorat Jenderal Perhubungan Darat','ac8210c537b72dd8e806cc298b0f9ea3',2,'E1','022.03','-1',3,NULL,'8;2013-02-01 14:51:46'),(89,'ka2','Direktorat Jenderal Perkeretaapian','ac8210c537b72dd8e806cc298b0f9ea3',2,'E1','022.08','-1',3,NULL,'8;2013-02-01 14:52:32'),(90,'balitbang2','Badan Penelitian dan Pengembangan Perhubungan','ac8210c537b72dd8e806cc298b0f9ea3',2,'E1','022.11','-1',3,NULL,'8;2013-02-01 14:50:23'),(91,'bpsdmp2','Badan Pengembangan Sumber Daya Manusia Perhubungan','ac8210c537b72dd8e806cc298b0f9ea3',2,'E1','022.12','-1',3,NULL,'8;2013-02-01 14:50:35'),(92,'setjen','Sekretariat Jenderal Kementerian Perhubungan','ac8210c537b72dd8e806cc298b0f9ea3',2,'E1','022.01','-1',4,NULL,'8;2013-02-01 14:52:45'),(93,'itjen','Inspektorat Jenderal Kementerian Perhubungan','ac8210c537b72dd8e806cc298b0f9ea3',2,'E1','022.02','-1',4,NULL,'8;2013-02-01 14:52:11'),(95,'hubla2','Direktorat Jenderal Perhubungan Laut','ac8210c537b72dd8e806cc298b0f9ea3',2,'E1','022.04','-1',4,NULL,'8;2013-02-01 14:51:54'),(96,'hubud2','Direktorat Jenderal Perhubungan Udara','ac8210c537b72dd8e806cc298b0f9ea3',2,'E1','022.05','-1',4,NULL,'8;2013-02-01 14:52:02'),(97,'ka','Direktorat Jenderal Perkeretaapian','ac8210c537b72dd8e806cc298b0f9ea3',2,'E1','022.08','-1',4,NULL,'8;2013-02-01 14:52:26'),(98,'balitbang','Badan Penelitian dan Pengembangan Perhubungan','ac8210c537b72dd8e806cc298b0f9ea3',2,'E1','022.11','-1',4,NULL,'8;2013-02-01 14:51:31'),(99,'bpsdmp','Badan Pengembangan Sumber Daya Manusia Perhubungan','ac8210c537b72dd8e806cc298b0f9ea3',2,'E1','022.12','-1',4,NULL,'8;2013-02-01 14:51:39'),(100,'guest','Guest','66f7649530c0e3d593a484660804866a',1,'KL','-1','-1',4,'8;2013-06-11 10:40:04','8;2013-06-11 10:45:39');
/*!40000 ALTER TABLE `tbl_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-08-30  9:19:35
