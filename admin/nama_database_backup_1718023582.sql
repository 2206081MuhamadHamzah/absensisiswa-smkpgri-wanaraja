

CREATE TABLE `_logabsensi` (
  `id_presensi` int(11) NOT NULL AUTO_INCREMENT,
  `id_mengajar` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `tgl_absen` date DEFAULT NULL,
  `ket` enum('H','I','S','T','A','C') NOT NULL,
  `pertemuan_ke` varchar(30) NOT NULL,
  PRIMARY KEY (`id_presensi`)
) ENGINE=InnoDB AUTO_INCREMENT=627 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO _logabsensi VALUES("624","25","30","2024-05-09","I","1");
INSERT INTO _logabsensi VALUES("625","25","31","2024-05-09","H","1");
INSERT INTO _logabsensi VALUES("626","25","32","2024-05-09","H","1");



CREATE TABLE `tb_admin` (
  `id_admin` int(11) NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `aktif` varchar(5) NOT NULL,
  `foto` varchar(225) NOT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO tb_admin VALUES("1","muhamad hamzah","hamzahbaik9@gmail.com","d033e22ae348aeb5660fc2140aec35850c4da997","Y","admin.png");
INSERT INTO tb_admin VALUES("2","muhamad hamzah","hamzahbaik","Hamzahmv20","aktif","");



CREATE TABLE `tb_guru` (
  `id_guru` int(11) NOT NULL AUTO_INCREMENT,
  `nip` varchar(15) NOT NULL,
  `nama_guru` varchar(120) NOT NULL,
  `email` varchar(65) NOT NULL,
  `password` varchar(100) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `status` varchar(5) NOT NULL,
  PRIMARY KEY (`id_guru`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO tb_guru VALUES("10","27","Yati Nurlatifah, S. Kom.","yatinurlatifah1@gmail.com","bc33ea4e26e5e1af1408321416956113a4658763","27.jpg","Y");
INSERT INTO tb_guru VALUES("11","36","Gilang Ahmad Ismail, S.Pd","gilangahmadismail28@gmail.com","fc074d501302eb2b93e2554793fcaf50b3bf7291","36.jpg","Y");



CREATE TABLE `tb_master_mapel` (
  `id_mapel` int(11) NOT NULL AUTO_INCREMENT,
  `kode_mapel` varchar(40) NOT NULL,
  `mapel` varchar(60) NOT NULL,
  PRIMARY KEY (`id_mapel`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO tb_master_mapel VALUES("1","MP-1561560093","Bahasa Indonesia");
INSERT INTO tb_master_mapel VALUES("2","MP-1561560129","Matematika");
INSERT INTO tb_master_mapel VALUES("6","MP-1561872026","Seni Budaya");
INSERT INTO tb_master_mapel VALUES("7","MP-1561872043","Bahasa Inggris");
INSERT INTO tb_master_mapel VALUES("8","MP-1615002340","Ilmu Pengetahuan Alam");
INSERT INTO tb_master_mapel VALUES("9","MP-1698921480","Simulasi Digital");
INSERT INTO tb_master_mapel VALUES("10","MP-1698921528","Pemrograman Dasar");
INSERT INTO tb_master_mapel VALUES("11","MP-1698921549","Pkk Teori");
INSERT INTO tb_master_mapel VALUES("12","MP-1698921567","Desain Multimedia Interaktif");
INSERT INTO tb_master_mapel VALUES("13","MP-1698921594","Pkk Praktek");



CREATE TABLE `tb_mengajar` (
  `id_mengajar` int(11) NOT NULL AUTO_INCREMENT,
  `kode_pelajaran` varchar(30) NOT NULL,
  `hari` varchar(40) NOT NULL,
  `jam_mengajar` varchar(60) NOT NULL,
  `jamke` varchar(11) NOT NULL,
  `id_guru` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `id_mkelas` int(11) NOT NULL,
  `id_semester` int(11) NOT NULL,
  `id_thajaran` int(11) NOT NULL,
  PRIMARY KEY (`id_mengajar`),
  KEY `id_mapel` (`id_mapel`),
  KEY `id_guru` (`id_guru`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO tb_mengajar VALUES("1","MPL-1614670924","Senin","09.00-10.00","1-2","1","1","1","1","2");
INSERT INTO tb_mengajar VALUES("2","MPL-1614674537","Senin","09.00-10.00","1-2","5","1","1","1","2");
INSERT INTO tb_mengajar VALUES("4","MPL-1615004563","Senin","08.00-09.00","1","6","2","3","2","2");
INSERT INTO tb_mengajar VALUES("5","MPL-1616288498","Rabu","09.00-10.00","2","8","7","1","2","2");
INSERT INTO tb_mengajar VALUES("6","MPL-1582242668","Senin","08.00-09.00","1","5","1","1","4","8");
INSERT INTO tb_mengajar VALUES("8","MPL-1698597808","Senin","10.00 - 12.00","2","9","5","5","4","8");
INSERT INTO tb_mengajar VALUES("10","MPL-1698927713","Senin","08.00 - 10.00","2","5","7","0","4","8");
INSERT INTO tb_mengajar VALUES("11","MPL-1698927744","Senin","08.00 - 10.00","2","5","1","5","4","8");
INSERT INTO tb_mengajar VALUES("12","MPL-1698927794","Senin","08.00 - 10.00","2","5","7","5","4","8");
INSERT INTO tb_mengajar VALUES("16","MPL-1699028042","Senin","08.00 - 10.00","1","5","9","0","4","9");
INSERT INTO tb_mengajar VALUES("18","MPL-1699028113","Senin","08.00 - 10.00","1","10","9","0","4","9");
INSERT INTO tb_mengajar VALUES("19","MPL-1699028990","","","","0","0","0","4","9");
INSERT INTO tb_mengajar VALUES("22","MPL-1699733091","Senin","08.00 - 10.00","1","11","12","7","4","9");
INSERT INTO tb_mengajar VALUES("23","MPL-1699736188","Senin","08.00 - 10.00","1","11","12","0","5","9");
INSERT INTO tb_mengajar VALUES("24","MPL-1699796246","Selasa","08.00 - 10.00","1","11","9","7","4","9");
INSERT INTO tb_mengajar VALUES("25","MPL-1715255081","Senin","08.00 - 10.00","1","10","12","5","4","9");



CREATE TABLE `tb_mkelas` (
  `id_mkelas` int(11) NOT NULL AUTO_INCREMENT,
  `kd_kelas` varchar(40) NOT NULL,
  `nama_kelas` varchar(40) NOT NULL,
  PRIMARY KEY (`id_mkelas`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO tb_mkelas VALUES("5","KL-1616673105","X MM 1");
INSERT INTO tb_mkelas VALUES("6","KL-1616673114","X MM 2");
INSERT INTO tb_mkelas VALUES("7","KL-1616673120","XI MM 1");
INSERT INTO tb_mkelas VALUES("8","KL-1698921716","XI MM 2");
INSERT INTO tb_mkelas VALUES("9","KL-1698921736","XII MM 1");
INSERT INTO tb_mkelas VALUES("10","KL-1698921754","XII MM 2");
INSERT INTO tb_mkelas VALUES("11","KL-1698921766","XII MM 2");
INSERT INTO tb_mkelas VALUES("12","KL-1698921926","XII RPL");
INSERT INTO tb_mkelas VALUES("13","KL-1715255473","pemograman web");



CREATE TABLE `tb_semester` (
  `id_semester` int(11) NOT NULL AUTO_INCREMENT,
  `semester` varchar(45) NOT NULL,
  `status` int(10) NOT NULL,
  PRIMARY KEY (`id_semester`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO tb_semester VALUES("4","Ganjil","1");
INSERT INTO tb_semester VALUES("5","Genap","0");



CREATE TABLE `tb_siswa` (
  `id_siswa` int(11) NOT NULL AUTO_INCREMENT,
  `nis` varchar(60) NOT NULL,
  `nama_siswa` varchar(120) NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `jk` varchar(30) NOT NULL,
  `alamat` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `status` varchar(15) NOT NULL,
  `th_angkatan` year(4) NOT NULL,
  `id_mkelas` int(11) NOT NULL,
  PRIMARY KEY (`id_siswa`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO tb_siswa VALUES("30","222310091","Nabila Putri","-","0000-00-00","P","-","ab97c217f5e165be7085363361e7c730f4b81579","logo-removebg-preview.png","1","2022","5");
INSERT INTO tb_siswa VALUES("31","222310092","Naura Ajeng Rukmana","-","0000-00-00","P","-","c4ae58976d346074fe491fd1f02d6508249e6819","logo-removebg-preview.png","1","2022","5");
INSERT INTO tb_siswa VALUES("32","222310093","Novita Sari ","-","0000-00-00","P","-","a924fe1614dd8221d10a74e410181ac690ae8bd9","logo-removebg-preview.png","1","2022","5");
INSERT INTO tb_siswa VALUES("33","222310094","Nurul Sintia","-","0000-00-00","P","-","1144e752e87c7961b3b8ba12c0e790b211f206c1","logo-removebg-preview.png","1","2022","7");
INSERT INTO tb_siswa VALUES("34","222310095","Raisa Febrianti","-","0000-00-00","P","-","368b94a9bb52b960c7a5ecfce53578b5f87bdbcd","logo-removebg-preview.png","1","2022","7");
INSERT INTO tb_siswa VALUES("35","222310096","Ramadhan Sayyid Abdillah","-","0000-00-00","L","-","6682ea49e03d1170a3e141fbb0a75ceca9cf76a2","logo-removebg-preview.png","1","2022","7");
INSERT INTO tb_siswa VALUES("36","222310097","Rifal Rinaldi","-","0000-00-00","L","-","f4649931a3de73086758b49231c7ca044dd9fa9f","logo-removebg-preview.png","1","2022","7");
INSERT INTO tb_siswa VALUES("37","222310098","Rika Amalia Rusdy","-","0000-00-00","P","-","ae66887dbd13523ef305a2f7047beda9ab87ac71","logo-removebg-preview.png","1","2022","7");
INSERT INTO tb_siswa VALUES("38","222310099","Risma Rahmawati","-","0000-00-00","P","-","7831c37ed988539f15c784e4235d638b4b100c27","logo-removebg-preview.png","1","2022","7");
INSERT INTO tb_siswa VALUES("39","222310100","Salwa Salsabila","-","0000-00-00","P","-","6feb6661e8a17fce0ecc8d27e05f360726f29832","logo-removebg-preview.png","1","2022","7");
INSERT INTO tb_siswa VALUES("40","222310101","Sindi Padilah","-","0000-00-00","P","-","2787c85a8d66d952e08230b790a06e3c482a2005","logo-removebg-preview.png","1","2022","7");
INSERT INTO tb_siswa VALUES("41","222310102","TB. Ahmad Taupik Ramdiansyah","-","0000-00-00","L","-","3939ef5c42f7185573a004aeee4e77214fe000ad","logo-removebg-preview.png","1","2022","7");
INSERT INTO tb_siswa VALUES("42","222310103","Tegar Tri Ananda","-","0000-00-00","L","-","4c28043a30674fc099f8d1082841a3079b279639","logo-removebg-preview.png","1","2022","7");
INSERT INTO tb_siswa VALUES("43","232410084","Airin Sri Anispa","-","0000-00-00","P","-","08cee5fa7fc4e7d4739536fa6c48e90d3c41c906","logo-removebg-preview.png","1","2023","6");
INSERT INTO tb_siswa VALUES("44","232410085","Alpin Saputra","-","0000-00-00","L","-","48820145520af0e5908ee5ed7ee8e2b11264a5d4","logo-removebg-preview.png","1","2023","6");
INSERT INTO tb_siswa VALUES("45","222310106","Aditya Alam Ihsan Islami","-","0000-00-00","L","-","16a010f0d4bed1252df14478fad404928f65559d","logo-removebg-preview.png","1","2022","8");
INSERT INTO tb_siswa VALUES("46","222310107","Amelia","-","0000-00-00","P","-","71426aac8c561259d841494914698963a4f5b8cd","logo-removebg-preview.png","1","2022","8");
INSERT INTO tb_siswa VALUES("47","222310108","Asti rahmawati","-","0000-00-00","L","-","d11f4c30a5bcb42c4e6c39a2a8f66e8b8a29e10b","logo-removebg-preview.png","1","2022","8");
INSERT INTO tb_siswa VALUES("48","222310109","Bian Septiansyah","-","0000-00-00","L","-","259baa0a7ca40128628e63f402ca1228501d7a30","logo-removebg-preview.png","1","2022","8");
INSERT INTO tb_siswa VALUES("49","222310110","Clara Agustin","-","0000-00-00","L","-","579526e6140ecce5de6608d1c0fe5662218edf66","logo-removebg-preview.png","1","2023","0");
INSERT INTO tb_siswa VALUES("50","222310110","Clara Agustin","-","0000-00-00","P","-","579526e6140ecce5de6608d1c0fe5662218edf66","logo-removebg-preview.png","1","2022","8");
INSERT INTO tb_siswa VALUES("51","222310111","Desi","-","0000-00-00","P","-","f5a56d84900b9898db3c83e94e2b97c45a9b1498","logo-removebg-preview.png","1","2022","8");
INSERT INTO tb_siswa VALUES("52","222310112","Fitriya Suci Ramadani","-","0000-00-00","P","-","c2b11aaafb11d434ee483023e02c294e26583251","logo-removebg-preview.png","1","2022","8");
INSERT INTO tb_siswa VALUES("53","222310113","Imas Hasyifa","-","0000-00-00","P","-","2bd6a65f7ce2a3193c31a82461c6d7d3bf9ae2fa","logo-removebg-preview.png","1","2022","8");
INSERT INTO tb_siswa VALUES("54","232410086","Aprilia Putri Maharani ","-","0000-00-00","P","-","8551146b934e913feafcb82dd9a07b3da8c9e2e8","logo-removebg-preview.png","1","2023","6");
INSERT INTO tb_siswa VALUES("55","232410087","Ayu Anjani","-","0000-00-00","P","-","6bbb779501879046e41d87031b15907bc8a2f3f1","logo-removebg-preview.png","1","2023","6");
INSERT INTO tb_siswa VALUES("56","232410088","Deni Permana Sidiq","-","0000-00-00","L","-","9ee5d91a3490370172cdf63ed628284d78cf1f1a","logo-removebg-preview.png","1","2023","6");
INSERT INTO tb_siswa VALUES("57","232410089","Devia Oktovian","-","0000-00-00","P","-","f1fb68875a4da67e67f1a77492bb0506773051ee","logo-removebg-preview.png","1","2023","6");
INSERT INTO tb_siswa VALUES("58","232410090","Firzatullah Zahran","-","0000-00-00","P","-","aca44ae984f9e0d51a7974fa25fbcda1504aab25","logo-removebg-preview.png","1","2023","6");
INSERT INTO tb_siswa VALUES("59","232410091","Fuji Agustina","-","0000-00-00","P","-","a4c9fb89639bf7e2a2e6ecaa341578a382e1eb2f","logo-removebg-preview.png","1","2023","6");
INSERT INTO tb_siswa VALUES("60","232410092","Hilman Setiawan","","0000-00-00","L","-","1532690af1f9428524bb288a779fe0b3fd009438","logo-removebg-preview.png","1","2023","6");
INSERT INTO tb_siswa VALUES("61","232410093","Jibril Aridho","","0000-00-00","L","-","8583c857715ce227d8467fdcb0e0dacfcc4d06ef","logo-removebg-preview.png","1","2023","6");
INSERT INTO tb_siswa VALUES("62","232410094","Karisa Faujiah ","-","0000-00-00","P","-","18074459016127c289c96d31951edbceb2c7ba9c","logo-removebg-preview.png","1","2023","6");
INSERT INTO tb_siswa VALUES("63","232410095","Keysa ","-","0000-00-00","P","-","46a148b83208c88e9e461d1778964b0ce1af042b","logo-removebg-preview.png","1","2023","6");
INSERT INTO tb_siswa VALUES("64","232410096","Lhadika Ikhwan Mulya","-","0000-00-00","L","-","690566630d3a0649416c713e7051c6827cecae76","logo-removebg-preview.png","1","2023","6");
INSERT INTO tb_siswa VALUES("65","232410097","Lilis Musannayah","-","0000-00-00","P","-","5e8bcf4d4267dc2470343f50b8872cdbfa2a25da","logo-removebg-preview.png","1","2023","6");
INSERT INTO tb_siswa VALUES("66","232410098","Mira Rahmawati","-","0000-00-00","P","-","7cf81b1d7d83f7bd631cb7373d798e5cadd0acfc","logo-removebg-preview.png","1","2023","6");
INSERT INTO tb_siswa VALUES("67","232410099","Muhammad Aprizal Setiawan ","-","0000-00-00","L","-","a82aeffa960f3bf0bc76c862bfeaea9692ee0e3e","logo-removebg-preview.png","1","2023","6");
INSERT INTO tb_siswa VALUES("68","232410100","Muhammad Husen ","-","0000-00-00","L","-","637a462e1dcdcd1511a79543a10c61efd0a8e45c","logo-removebg-preview.png","1","2023","6");
INSERT INTO tb_siswa VALUES("69","232410101","Neng Winarti","-","0000-00-00","P","-","ec90d6abd5d57d3293a4325aaf5e956d46180572","logo-removebg-preview.png","1","2023","6");
INSERT INTO tb_siswa VALUES("70","232410102","Raga Mulya","-","0000-00-00","L","-","3b1f5b1842d77de6a91a8cd8ca64e4f005b9c2e8","logo-removebg-preview.png","1","2023","6");
INSERT INTO tb_siswa VALUES("71","232410103","Ramdani","-","0000-00-00","L","-","8f0c1798622a0ba50efe4cdb05099dc0856e1c9d","logo-removebg-preview.png","1","2023","6");
INSERT INTO tb_siswa VALUES("72","232410104","Rangga Syah Putra Gunawan","-","0000-00-00","L","-","657e403de7bcb3ac9abe945d7877473b87006274","logo-removebg-preview.png","1","2023","6");
INSERT INTO tb_siswa VALUES("73","232410105","Ridwan Seprian Ramadhan","-","0000-00-00","L","-","ebb61c09d0bb30d4203992ec9b5fa70c06ada886","logo-removebg-preview.png","1","2023","6");
INSERT INTO tb_siswa VALUES("74","232410106","Sahrul Wahyudi","-","0000-00-00","L","-","f5cd6c6e4330d074da6522a2187a40ac510a304b","logo-removebg-preview.png","1","2023","6");
INSERT INTO tb_siswa VALUES("75","232410107","Saluna Haerani","-","0000-00-00","P","-","78c94a2f5ae7d364c6ef036962f56a97558462c0","logo-removebg-preview.png","1","2023","6");
INSERT INTO tb_siswa VALUES("76","232410108","Sifa Nurul Aeni","-","0000-00-00","P","-","28da6f58f465d111559e0547944f6e7d2b94a456","logo-removebg-preview.png","1","2023","6");
INSERT INTO tb_siswa VALUES("77","232410109","Soni Mulyadi Hermawan","-","0000-00-00","L","-","6bab173b15277664a69704e41b3a87937396990b","logo-removebg-preview.png","1","2023","6");
INSERT INTO tb_siswa VALUES("78","232410110","Wildan Mahendra","-","0000-00-00","L","-","717d9d2981e01f1067be05ca4e4293f98e8d6d67","logo-removebg-preview.png","1","2023","6");
INSERT INTO tb_siswa VALUES("79","232410111","Zaki Andika Pratama","-","0000-00-00","L","-","23eb881c4631a3d9e77426f16580bf2345fbc141","logo-removebg-preview.png","1","2023","6");
INSERT INTO tb_siswa VALUES("80","222310104","Adhy Futra Yudhistira","-","0000-00-00","L","-","1b8e82de0d6c712c859268dbe5c550f6ea755af4","logo-removebg-preview.png","1","2022","8");
INSERT INTO tb_siswa VALUES("82","222310105","Aditya Agustian Arifin","-","0000-00-00","L","-","f0adb4d7555ecd9693886ec3268960cd9723c18e","logo-removebg-preview.png","1","2022","8");
INSERT INTO tb_siswa VALUES("83","222310113","Imas Hasyifa","-","0000-00-00","P","-","2bd6a65f7ce2a3193c31a82461c6d7d3bf9ae2fa","logo-removebg-preview.png","1","2022","8");
INSERT INTO tb_siswa VALUES("84","222310114","Indriyani Raisma Yanti","-","0000-00-00","P","-","0bcd9c802d3e9464be4d1d75862ed024a66f1bdf","logo-removebg-preview.png","1","2022","8");
INSERT INTO tb_siswa VALUES("85","222310115","Inggit Agustina","-","0000-00-00","P","-","000bd64b5288345780cc82337f6d5c8ff3f2517f","logo-removebg-preview.png","1","2022","8");
INSERT INTO tb_siswa VALUES("86","222310116","Kiki Muhamad Rizki Fauziah","-","0000-00-00","L","-","2fe832e5080e48e91923b9cdebd4f8e896b92ec4","logo-removebg-preview.png","1","2022","8");
INSERT INTO tb_siswa VALUES("87","222310117","Marsya Amelia","-","0000-00-00","P","-","2e6e9d0024c09c40b4c64876e1bcc0aa244e4dcb","logo-removebg-preview.png","1","2022","8");
INSERT INTO tb_siswa VALUES("88","222310118","Muhamad Reza","-","0000-00-00","L","-","48e387a35fcf9a45d2cb6d7b983f0485d815593c","logo-removebg-preview.png","1","2022","8");
INSERT INTO tb_siswa VALUES("89","222310119","Muhammad Azyra Nursehah","-","0000-00-00","L","-","44b5b8cd57239b2f6021160cf8f4e0840b5a6739","logo-removebg-preview.png","1","2022","8");
INSERT INTO tb_siswa VALUES("90","222310120","Nasya Anggi Fhirliansyah","-","0000-00-00","P","-","8df7237213b04ca72e8d3e545457a3d6b6bf0f10","logo-removebg-preview.png","1","2022","8");
INSERT INTO tb_siswa VALUES("91","222310121","Nurul Aulia Putri","-","0000-00-00","P","-","bae51e866987e22e007ee334a23a62cff3da26c4","logo-removebg-preview.png","1","2022","8");
INSERT INTO tb_siswa VALUES("92","222310122","Rahma Huzaimah","-","0000-00-00","P","-","367f716c4d7fb840909c0a7e679efe86fca9a589","logo-removebg-preview.png","1","2022","8");



CREATE TABLE `tb_thajaran` (
  `id_thajaran` int(11) NOT NULL AUTO_INCREMENT,
  `tahun_ajaran` varchar(30) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_thajaran`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO tb_thajaran VALUES("9","2023/2024","1");

