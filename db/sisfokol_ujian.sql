-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 04, 2017 at 03:50 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sisfokol_ujian`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminx`
--

CREATE TABLE `adminx` (
  `kd` varchar(50) NOT NULL,
  `usernamex` varchar(50) NOT NULL,
  `passwordx` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `adminx`
--

INSERT INTO `adminx` (`kd`, `usernamex`, `passwordx`) VALUES
('e807f1fcf82d132f9bb018ca6738a19f', 'admin', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `kd` varchar(50) NOT NULL,
  `nip` varchar(50) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `usernamex` varchar(50) NOT NULL,
  `passwordx` varchar(50) NOT NULL,
  `postdate` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`kd`, `nip`, `nama`, `usernamex`, `passwordx`, `postdate`) VALUES
('a7dc135983cdba668f4e48be1c04255d', '112233', 'agus muhajir', '112233', 'd0970714757783e6cf17b26fb8e2298f', '2015-01-19 09:14:28'),
('', '333', '333', '333', '310dcbbf4cce62f762a2aaa148d556bd', '2015-04-20 09:39:29'),
('76dffd5ec5b7895d165468f6e4e98840', '1', '122', '1', 'c4ca4238a0b923820dcc509a6f75849b', '2015-01-19 08:46:49');

-- --------------------------------------------------------

--
-- Table structure for table `guru_mapel`
--

CREATE TABLE `guru_mapel` (
  `kd` varchar(50) NOT NULL,
  `kd_tapel` varchar(50) NOT NULL,
  `kd_guru` varchar(50) NOT NULL,
  `kd_mapel` varchar(50) NOT NULL,
  `postdate` datetime NOT NULL,
  `bobot` varchar(5) NOT NULL,
  `jml_menit` varchar(5) NOT NULL,
  `kd_kelas` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `guru_mapel`
--

INSERT INTO `guru_mapel` (`kd`, `kd_tapel`, `kd_guru`, `kd_mapel`, `postdate`, `bobot`, `jml_menit`, `kd_kelas`) VALUES
('826b88275434ceed95ef4c025ce4f6a7', '77e727aa0c8f3b220b103c3b0052fc92', '76dffd5ec5b7895d165468f6e4e98840', '656ace4f1630fb5b435bbfbede513682', '2015-01-19 09:17:58', '6', '2', '589b1adc5e89b88f904a0a46b2668717'),
('f10d09708f655896229bad523eb6b6ca', '77e727aa0c8f3b220b103c3b0052fc92', '76dffd5ec5b7895d165468f6e4e98840', '656ace4f1630fb5b435bbfbede513682', '2015-01-19 09:18:04', '3', '3', '524f77015dbf643d547f48f06a56542a'),
('72fa08fb02aa511271f129734adb3f0f', '77e727aa0c8f3b220b103c3b0052fc92', '76dffd5ec5b7895d165468f6e4e98840', '5aea929f2aac79035ea52b16c9593620', '2015-04-20 09:36:30', '', '', '34179e4ecbb1a05d5a0e163de8c9e54c');

-- --------------------------------------------------------

--
-- Table structure for table `login_log`
--

CREATE TABLE `login_log` (
  `kd` varchar(50) NOT NULL,
  `kd_tapel` varchar(50) NOT NULL,
  `kd_login` varchar(50) NOT NULL,
  `url_inputan` varchar(255) NOT NULL,
  `postdate` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_log`
--

INSERT INTO `login_log` (`kd`, `kd_tapel`, `kd_login`, `url_inputan`, `postdate`) VALUES
('9b20f5b2a1ecc14383585dd0bb4751f3', '3e51bc44ebc2e59849fa0e2ff8d3ed12', 'e807f1fcf82d132f9bb018ca6738a19f', 'Login Administrator : admin', '2014-11-16 09:37:36'),
('301f18cdbfcde2b25afdbb8cbcd4b026', '3e51bc44ebc2e59849fa0e2ff8d3ed12', 'e807f1fcf82d132f9bb018ca6738a19f', 'Login Administrator : admin', '2014-11-16 09:41:41'),
('14536a024f3be9ccf0a1c6d3554150eb', '3e51bc44ebc2e59849fa0e2ff8d3ed12', 'e807f1fcf82d132f9bb018ca6738a19f', '[Administrator] ==> Data Pelajaran Ujian Tertulis/Online [EDIT DATA]', '2014-11-16 10:01:41'),
('24c05b0f89ed15c89d8eb29de4970067', '3e51bc44ebc2e59849fa0e2ff8d3ed12', 'e807f1fcf82d132f9bb018ca6738a19f', '[Administrator] ==> Data Pelajaran Ujian Tertulis/Online [EDIT DATA]', '2014-11-16 10:01:46'),
('d6992715fd632175d7d7ce94fc4a7bf9', '3e51bc44ebc2e59849fa0e2ff8d3ed12', 'e807f1fcf82d132f9bb018ca6738a19f', '[Administrator] ==> Data Pelajaran Ujian Tertulis/Online [EDIT DATA]', '2014-11-16 10:01:49'),
('75a5c9a0fc3cb9846076bdbaa0270538', '3e51bc44ebc2e59849fa0e2ff8d3ed12', 'e807f1fcf82d132f9bb018ca6738a19f', '[Administrator] ==> Data Pelajaran Ujian Tertulis/Online [EDIT DATA]', '2014-11-16 10:01:53'),
('e48130e98866ea57d817eabea55bd517', '3e51bc44ebc2e59849fa0e2ff8d3ed12', '856504b9a9f9442a868328e2640c93c3', 'Login SISWA : 1', '2014-11-16 11:32:38'),
('c245a249cc3b78a73db0ce827b94603e', '3e51bc44ebc2e59849fa0e2ff8d3ed12', '856504b9a9f9442a868328e2640c93c3', 'Login SISWA : 1', '2014-11-16 11:35:01'),
('6498aa50fd774da125d152431c9fbadf', '3e51bc44ebc2e59849fa0e2ff8d3ed12', '856504b9a9f9442a868328e2640c93c3', '[SISWA : .1] ==> Ganti Password [EDIT DATA]', '2014-11-16 11:36:52'),
('e1219455e0c16d302324a729c6813474', '3e51bc44ebc2e59849fa0e2ff8d3ed12', '37b6b945496af16dc9b9d8cb3a594afd', 'Login SISWA : 2', '2014-11-16 11:47:42'),
('d7ee95be6812e19f230543859a3b7707', '3e51bc44ebc2e59849fa0e2ff8d3ed12', 'e807f1fcf82d132f9bb018ca6738a19f', 'Login Administrator : admin', '2014-11-16 11:48:25'),
('4113fbcdd9c9802dde2e6b2ebf329bee', '3e51bc44ebc2e59849fa0e2ff8d3ed12', '856504b9a9f9442a868328e2640c93c3', 'Login SISWA : 1', '2014-11-16 11:49:00'),
('2e0e3703c31f2da876c0eaab7face3f0', '3e51bc44ebc2e59849fa0e2ff8d3ed12', 'e807f1fcf82d132f9bb018ca6738a19f', 'Login Administrator : admin', '2014-12-01 01:32:35'),
('0cb464b49d14acadab0a75b88227ab5f', '3e51bc44ebc2e59849fa0e2ff8d3ed12', 'e807f1fcf82d132f9bb018ca6738a19f', 'Login Administrator : admin', '2015-01-19 05:03:39'),
('55371aa5d109b8baa74540d5fcdbf4d8', '3e51bc44ebc2e59849fa0e2ff8d3ed12', 'e807f1fcf82d132f9bb018ca6738a19f', 'Login Administrator : admin', '2015-01-19 08:33:55'),
('badd9605104efe2a84ca92fb87cfa226', '', '76dffd5ec5b7895d165468f6e4e98840', 'Login GURU : 1', '2015-01-19 10:01:16'),
('839b7aee2e55299b8ba95a4c9448371a', '3e51bc44ebc2e59849fa0e2ff8d3ed12', 'c1b81872d5e0f69a7f1eaea83e2b9daa', 'Login SISWA : 1', '2015-01-19 10:03:48'),
('d590c6c569f4bc8d6554f900c3b46587', '', '76dffd5ec5b7895d165468f6e4e98840', 'Login GURU : 1', '2015-01-19 10:03:58'),
('bb17667cd517f90a317eabd49ee1cd35', '3e51bc44ebc2e59849fa0e2ff8d3ed12', '76dffd5ec5b7895d165468f6e4e98840', '[GURU] ==> Ganti Password [EDIT DATA]', '2015-01-19 10:23:44'),
('563bc17980acd68e0f14c74da3c6b3b2', '3e51bc44ebc2e59849fa0e2ff8d3ed12', '76dffd5ec5b7895d165468f6e4e98840', '[GURU] ==> Ganti Password [EDIT DATA]', '2015-01-19 10:23:52'),
('91dd8b1d668df53b0d2398a33283a373', '', '76dffd5ec5b7895d165468f6e4e98840', 'Login GURU : 1', '2015-01-19 10:24:15'),
('6c09da19247113819d33285efaf68ed5', '3e51bc44ebc2e59849fa0e2ff8d3ed12', '76dffd5ec5b7895d165468f6e4e98840', '[GURU] ==> Ganti Password [EDIT DATA]', '2015-01-19 10:24:21'),
('cd3780d97c1af968d158fd2548c1a35a', '', '76dffd5ec5b7895d165468f6e4e98840', 'Login GURU : 1', '2015-01-19 10:24:33'),
('91633d2adef9427c8a2a4bd0f8df4479', '3e51bc44ebc2e59849fa0e2ff8d3ed12', '76dffd5ec5b7895d165468f6e4e98840', '[GURU] ==> Ganti Password [EDIT DATA]', '2015-01-19 10:25:33'),
('bf844a464bef40bd65a42499f3094f82', '', '76dffd5ec5b7895d165468f6e4e98840', 'Login GURU : 1', '2015-01-19 10:25:41'),
('e034d4c32ce2401017cc78e95502a5af', '3e51bc44ebc2e59849fa0e2ff8d3ed12', '76dffd5ec5b7895d165468f6e4e98840', 'Selamat Datang....  [GURU] [EDIT DATA]', '2015-01-19 10:47:16'),
('ecf72c99b377a87bc19a15ecfb02d129', '3e51bc44ebc2e59849fa0e2ff8d3ed12', '76dffd5ec5b7895d165468f6e4e98840', 'Selamat Datang....  [GURU] [EDIT DATA]', '2015-01-19 10:49:03'),
('08a3eda185ab619ff76a6892a2bb641b', '3e51bc44ebc2e59849fa0e2ff8d3ed12', '76dffd5ec5b7895d165468f6e4e98840', 'Selamat Datang....  [GURU] [EDIT DATA]', '2015-01-19 10:49:26'),
('135d6a95e419a70ce133611b0002af44', '3e51bc44ebc2e59849fa0e2ff8d3ed12', '76dffd5ec5b7895d165468f6e4e98840', 'Selamat Datang....  [GURU] [EDIT DATA]', '2015-01-19 10:54:48'),
('b9472b66837fc650716e0a937b191d93', '3e51bc44ebc2e59849fa0e2ff8d3ed12', '76dffd5ec5b7895d165468f6e4e98840', 'Selamat Datang....  [GURU] [EDIT DATA]', '2015-01-19 11:17:24'),
('fdd6ed704083680c3bc2b93f9dda83bf', '3e51bc44ebc2e59849fa0e2ff8d3ed12', '76dffd5ec5b7895d165468f6e4e98840', 'Selamat Datang....  [GURU] [EDIT DATA]', '2015-01-19 11:17:32'),
('4e6f092fc5412fe37181cc9da6bf0c54', '3e51bc44ebc2e59849fa0e2ff8d3ed12', 'e807f1fcf82d132f9bb018ca6738a19f', 'Login Administrator : admin', '2015-01-19 11:17:48'),
('b14fb77949514dc480667f647343d880', '', '76dffd5ec5b7895d165468f6e4e98840', 'Login GURU : 1', '2015-01-19 11:18:13'),
('d030e5b30592315f32ceeedafa926e2d', '3e51bc44ebc2e59849fa0e2ff8d3ed12', '76dffd5ec5b7895d165468f6e4e98840', 'Selamat Datang....  [GURU] [EDIT DATA]', '2015-01-19 11:20:05'),
('bdceddcd854c237576926dd0072fe9f9', '', '76dffd5ec5b7895d165468f6e4e98840', 'Login GURU : 1', '2015-01-19 11:38:34'),
('f7119e52a4b5a401bf990350a05beb8f', '3e51bc44ebc2e59849fa0e2ff8d3ed12', 'e807f1fcf82d132f9bb018ca6738a19f', 'Login Administrator : admin', '2015-01-19 11:40:16'),
('06fb244582f9c98e8b08d07e2588db97', '3e51bc44ebc2e59849fa0e2ff8d3ed12', 'c1b81872d5e0f69a7f1eaea83e2b9daa', 'Login SISWA : 1', '2015-01-19 11:40:33'),
('2d05bcfe49b84a7301f480e227199a32', '', '76dffd5ec5b7895d165468f6e4e98840', 'Login GURU : 1', '2015-01-19 12:09:30'),
('ef70f9496f189cabc8645d95bf28627d', '3e51bc44ebc2e59849fa0e2ff8d3ed12', '76dffd5ec5b7895d165468f6e4e98840', '[GURU] ==> Ganti Password [EDIT DATA]', '2015-01-19 12:09:36'),
('902bc746898174e146f44ae3113af60a', '', '76dffd5ec5b7895d165468f6e4e98840', 'Login GURU : 1', '2015-01-19 12:09:43'),
('f7f358be32b3274b9776c64407f285d2', '3e51bc44ebc2e59849fa0e2ff8d3ed12', 'e807f1fcf82d132f9bb018ca6738a19f', 'Login Administrator : admin', '2015-04-18 10:12:02'),
('8dfa04b785e62403f1e2045522e335be', '', '76dffd5ec5b7895d165468f6e4e98840', 'Login GURU : 1', '2015-04-18 10:12:50'),
('85ead2dfd145c3f3c712183efc687266', '3e51bc44ebc2e59849fa0e2ff8d3ed12', 'c1b81872d5e0f69a7f1eaea83e2b9daa', 'Login SISWA : 1', '2015-04-18 10:13:40'),
('e03b8fb8614dc64a9836a02ce7c7503d', '3e51bc44ebc2e59849fa0e2ff8d3ed12', 'e807f1fcf82d132f9bb018ca6738a19f', 'Login Administrator : admin', '2015-04-20 08:39:42'),
('84436e54504a29259f218f555f4a3ed8', '3e51bc44ebc2e59849fa0e2ff8d3ed12', 'e807f1fcf82d132f9bb018ca6738a19f', 'Login Administrator : admin', '2015-04-20 08:56:26'),
('9ce32c93dda7d8554f4e1181a314ca55', '3e51bc44ebc2e59849fa0e2ff8d3ed12', '76dffd5ec5b7895d165468f6e4e98840', 'Login GURU : 1', '2015-04-20 09:01:08'),
('bca212b142ad814547f97fca7b887df2', '3e51bc44ebc2e59849fa0e2ff8d3ed12', 'c1b81872d5e0f69a7f1eaea83e2b9daa', 'Login SISWA : 1', '2015-04-20 09:11:26'),
('c9d8ec7383d79b22917b6ff16beed13d', '3e51bc44ebc2e59849fa0e2ff8d3ed12', '76dffd5ec5b7895d165468f6e4e98840', 'Login GURU : 1', '2015-04-20 09:12:29'),
('03cf70371e2dfbfe1e1a3efc13e1b624', '3e51bc44ebc2e59849fa0e2ff8d3ed12', '76dffd5ec5b7895d165468f6e4e98840', 'Login GURU : 1', '2015-04-20 09:14:02'),
('279f8fcf566d8998b6115a9034768194', '3e51bc44ebc2e59849fa0e2ff8d3ed12', 'c1b81872d5e0f69a7f1eaea83e2b9daa', 'Login SISWA : 1', '2015-04-20 09:14:27'),
('4b4dfd4e705412276d57c39f2548e2be', '3e51bc44ebc2e59849fa0e2ff8d3ed12', '76dffd5ec5b7895d165468f6e4e98840', 'Login GURU : 1', '2015-04-20 09:18:48'),
('15b84c60378b232ffb357694f7ef0588', '3e51bc44ebc2e59849fa0e2ff8d3ed12', 'c1b81872d5e0f69a7f1eaea83e2b9daa', 'Login SISWA : 1', '2015-04-20 09:20:18'),
('e4e4b79380715e30731b7004f0027b49', '3e51bc44ebc2e59849fa0e2ff8d3ed12', '76dffd5ec5b7895d165468f6e4e98840', 'Login GURU : 1', '2015-04-20 09:21:31'),
('de68edc7d1d7cec550bf8f7f5f341a76', '3e51bc44ebc2e59849fa0e2ff8d3ed12', 'e807f1fcf82d132f9bb018ca6738a19f', 'Login Administrator : admin', '2015-04-20 09:32:24'),
('fb8bec0519793d81986608eba42c0512', '77e727aa0c8f3b220b103c3b0052fc92', 'e807f1fcf82d132f9bb018ca6738a19f', 'Login Administrator : admin', '2015-04-20 09:57:35'),
('a21663ee347205d990abb8db568a255a', '77e727aa0c8f3b220b103c3b0052fc92', '76dffd5ec5b7895d165468f6e4e98840', 'Login GURU : 1', '2015-04-20 10:13:53'),
('20eaff5138ca878b726a090a0d68dac6', '77e727aa0c8f3b220b103c3b0052fc92', 'e807f1fcf82d132f9bb018ca6738a19f', 'Login Administrator : admin', '2015-04-20 11:50:35'),
('38199aa96ae97fa7a46d11c61f0c2042', '77e727aa0c8f3b220b103c3b0052fc92', '76dffd5ec5b7895d165468f6e4e98840', 'Login GURU : 1', '2015-04-20 11:51:03'),
('4413b8533eb52f963bcfe1472a20d348', '77e727aa0c8f3b220b103c3b0052fc92', 'e807f1fcf82d132f9bb018ca6738a19f', 'Login Administrator : admin', '2015-04-20 11:53:04'),
('6dabf210187701652a72c87d1b6cc420', '77e727aa0c8f3b220b103c3b0052fc92', 'e807f1fcf82d132f9bb018ca6738a19f', 'Login Administrator : admin', '2015-04-20 11:53:52'),
('c6e90badffbc86858e0fbf23654ad48b', '77e727aa0c8f3b220b103c3b0052fc92', '76dffd5ec5b7895d165468f6e4e98840', 'Login GURU : 1', '2015-04-20 11:56:34'),
('0ea2baa816d554acee739dcf3e538e42', '77e727aa0c8f3b220b103c3b0052fc92', 'c1b81872d5e0f69a7f1eaea83e2b9daa', 'Login SISWA : 1', '2015-04-20 11:56:54'),
('14ddab81b7583f0441d5fb18f7230731', '77e727aa0c8f3b220b103c3b0052fc92', '76dffd5ec5b7895d165468f6e4e98840', 'Login GURU : 1', '2015-04-20 11:57:17'),
('6478a033a6123da57c3e2fe2a860a53d', '77e727aa0c8f3b220b103c3b0052fc92', '76dffd5ec5b7895d165468f6e4e98840', 'Login GURU : 1', '2015-04-20 11:58:15'),
('85467a0947e39020b3e8af8cccaba799', '77e727aa0c8f3b220b103c3b0052fc92', 'c1b81872d5e0f69a7f1eaea83e2b9daa', 'Login SISWA : 1', '2015-04-20 11:58:35'),
('10d398cf4d852a401359f416561be2a8', '77e727aa0c8f3b220b103c3b0052fc92', '76dffd5ec5b7895d165468f6e4e98840', 'Login GURU : 1', '2015-04-20 11:59:29'),
('0554625793160b9ffc20cdb4f3800b3f', '77e727aa0c8f3b220b103c3b0052fc92', 'e807f1fcf82d132f9bb018ca6738a19f', 'Login Administrator : admin', '2015-04-20 12:04:54'),
('5d141ed46bd07151cb37ffb78d25ffb9', '77e727aa0c8f3b220b103c3b0052fc92', 'e807f1fcf82d132f9bb018ca6738a19f', 'Login Administrator : admin', '2017-05-04 03:38:20'),
('1c15cf2532691dc7e5aa5abc74d6c43b', '77e727aa0c8f3b220b103c3b0052fc92', 'e807f1fcf82d132f9bb018ca6738a19f', 'Login Administrator : admin', '2017-05-04 03:45:22'),
('47e5fd904cf835dba643d91928f5cbd7', '77e727aa0c8f3b220b103c3b0052fc92', '76dffd5ec5b7895d165468f6e4e98840', 'Login GURU : 1', '2017-05-04 03:48:00'),
('ae07f27e4294a621eedac0fd3181204a', '77e727aa0c8f3b220b103c3b0052fc92', '76dffd5ec5b7895d165468f6e4e98840', 'Login GURU : 1', '2017-05-04 03:48:17'),
('de3db048f2fd184671e692dda8e4ab02', '77e727aa0c8f3b220b103c3b0052fc92', 'c1b81872d5e0f69a7f1eaea83e2b9daa', 'Login SISWA : 1', '2017-05-04 03:48:36');

-- --------------------------------------------------------

--
-- Table structure for table `m_kelas`
--

CREATE TABLE `m_kelas` (
  `kd` varchar(50) NOT NULL,
  `no` varchar(50) NOT NULL,
  `kelas` varchar(50) NOT NULL,
  `postdate` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_kelas`
--

INSERT INTO `m_kelas` (`kd`, `no`, `kelas`, `postdate`) VALUES
('589b1adc5e89b88f904a0a46b2668717', '1', 'X TKJ 1', '0000-00-00 00:00:00'),
('79a06de56f756fd248d9ec7a52b27ac2', '1', 'X TKJ 2', '0000-00-00 00:00:00'),
('34179e4ecbb1a05d5a0e163de8c9e54c', '1', 'X TKR 2', '0000-00-00 00:00:00'),
('524f77015dbf643d547f48f06a56542a', '1', 'X TKR 1', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `m_mapel`
--

CREATE TABLE `m_mapel` (
  `kd` varchar(50) NOT NULL,
  `kd_tapel` varchar(50) NOT NULL,
  `kd_kelas` varchar(50) NOT NULL,
  `no` varchar(5) NOT NULL,
  `mapel` varchar(255) NOT NULL,
  `postdate` datetime NOT NULL,
  `kkm` varchar(5) NOT NULL,
  `kd_jenis` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_mapel`
--

INSERT INTO `m_mapel` (`kd`, `kd_tapel`, `kd_kelas`, `no`, `mapel`, `postdate`, `kkm`, `kd_jenis`) VALUES
('656ace4f1630fb5b435bbfbede513682', '77e727aa0c8f3b220b103c3b0052fc92', '589b1adc5e89b88f904a0a46b2668717', '1', 'mapel 1', '2015-01-19 05:53:13', '', 'c4d84ab22d7f50126746dc5e40ce2919'),
('5aea929f2aac79035ea52b16c9593620', '77e727aa0c8f3b220b103c3b0052fc92', '589b1adc5e89b88f904a0a46b2668717', '2', 'mapel 2', '2015-01-19 05:53:16', '', 'c4d84ab22d7f50126746dc5e40ce2919');

-- --------------------------------------------------------

--
-- Table structure for table `m_mapel_jenis`
--

CREATE TABLE `m_mapel_jenis` (
  `kd` varchar(50) NOT NULL,
  `no` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_mapel_jenis`
--

INSERT INTO `m_mapel_jenis` (`kd`, `no`, `nama`) VALUES
('c4d84ab22d7f50126746dc5e40ce2919', '1', 'Adaptif'),
('d163662d32f2f7f0b4c007e2e5140310', '2', 'Normatif'),
('80f49f0024bb8867f7658a3220739e0d', '3', 'Produktif');

-- --------------------------------------------------------

--
-- Table structure for table `m_soal`
--

CREATE TABLE `m_soal` (
  `kd` varchar(50) NOT NULL,
  `kd_guru_mapel` varchar(50) NOT NULL,
  `no` varchar(3) NOT NULL,
  `isi` longtext NOT NULL,
  `kunci` varchar(1) NOT NULL,
  `aktif` enum('true','false') NOT NULL DEFAULT 'false',
  `postdate` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `m_soal`
--

INSERT INTO `m_soal` (`kd`, `kd_guru_mapel`, `no`, `isi`, `kunci`, `aktif`, `postdate`) VALUES
('253fc02525ff24c7c652556c6756e20e', '826b88275434ceed95ef4c025ce4f6a7', '2', 'xkkirixpxkkananxasf gxxxxxxxxxkkirixxgmringxpxkkananx\r\nxkkirixpxkkananxdgxkkirixxgmringxpxkkananx\r\nxkkirixpxkkananx&nbspxkommaxdsxxxxxxxxxxxxxxxxxxxxxxkkirixxgmringxpxkkananx\r\nxkkirixpxkkananxgsdxkkirixxgmringxpxkkananx\r\nxkkirixpxkkananxgxkkirixxgmringxpxkkananx\r\nxkkirixpxkkananxsdgxkkirixxgmringxpxkkananx', 'B', 'true', '2015-04-20 09:10:17'),
('26e7ff089f768fb09cdbae897c0b6072', '826b88275434ceed95ef4c025ce4f6a7', '122', 'xkkirixpxkkananxgsagsagxkkirixxgmringxpxkkananx', 'A', 'true', '2015-01-19 11:15:42'),
('cac6932b872f8832daa384367afcc334', '826b88275434ceed95ef4c025ce4f6a7', '5', 'xkkirixpxkkananx5xkkirixxgmringxpxkkananx', 'C', 'true', '2015-04-20 09:10:33');

-- --------------------------------------------------------

--
-- Table structure for table `m_soal_filebox`
--

CREATE TABLE `m_soal_filebox` (
  `kd` varchar(50) NOT NULL,
  `kd_guru_mapel` varchar(50) NOT NULL,
  `kd_soal` varchar(50) NOT NULL,
  `filex` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `m_tapel`
--

CREATE TABLE `m_tapel` (
  `kd` varchar(50) NOT NULL,
  `tahun1` varchar(4) NOT NULL,
  `tahun2` varchar(4) NOT NULL,
  `status` enum('true','false') NOT NULL DEFAULT 'false'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_tapel`
--

INSERT INTO `m_tapel` (`kd`, `tahun1`, `tahun2`, `status`) VALUES
('77e727aa0c8f3b220b103c3b0052fc92', '2016', '2017', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `kd` varchar(50) NOT NULL,
  `kd_tapel` varchar(50) NOT NULL,
  `nis` varchar(50) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `tmp_lahir` varchar(20) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `alamat` longtext NOT NULL,
  `kelamin` varchar(1) NOT NULL,
  `agama` varchar(50) NOT NULL,
  `telp` varchar(255) NOT NULL,
  `postdate` datetime NOT NULL,
  `usernamex` varchar(50) NOT NULL,
  `passwordx` varchar(50) NOT NULL,
  `ket` varchar(255) NOT NULL,
  `kd_kelas` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`kd`, `kd_tapel`, `nis`, `nama`, `tmp_lahir`, `tgl_lahir`, `alamat`, `kelamin`, `agama`, `telp`, `postdate`, `usernamex`, `passwordx`, `ket`, `kd_kelas`) VALUES
('831868534753e7cbe81ce51b798ea283', '77e727aa0c8f3b220b103c3b0052fc92', '2', 'muhajir', '', '0000-00-00', '', '', '', '', '2015-01-19 09:44:49', '2', 'c81e728d9d4c2f636f067f89cc14862c', '', '589b1adc5e89b88f904a0a46b2668717'),
('c1b81872d5e0f69a7f1eaea83e2b9daa', '77e727aa0c8f3b220b103c3b0052fc92', '1', 'agus', 'x', '2015-01-11', 'o', '', 'Islam', 'u', '2015-01-19 09:44:43', '1', '6c3a9868d5e322add2ffaffe6e000044', 'y', '589b1adc5e89b88f904a0a46b2668717'),
('191956b4aef534e93531919fc90c47a5', '77e727aa0c8f3b220b103c3b0052fc92', '3', 'hajir', '3', '2015-04-20', '3', '', 'Islam', '3', '2015-04-20 08:58:58', '3', 'eccbc87e4b5ce2fe28308fd9f2a7baf3', '3', '589b1adc5e89b88f904a0a46b2668717');

-- --------------------------------------------------------

--
-- Table structure for table `siswa_soal`
--

CREATE TABLE `siswa_soal` (
  `kd` varchar(50) NOT NULL,
  `kd_siswa` varchar(50) NOT NULL,
  `kd_guru_mapel` varchar(50) NOT NULL,
  `kd_soal` varchar(50) NOT NULL,
  `jawab` varchar(1) NOT NULL,
  `postdate` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `siswa_soal`
--

INSERT INTO `siswa_soal` (`kd`, `kd_siswa`, `kd_guru_mapel`, `kd_soal`, `jawab`, `postdate`) VALUES
('9e8de5c977459849b82cf1f418109b62', '856504b9a9f9442a868328e2640c93c3', 'fbdcbdb61e4506f73620edeccc2b82b9', '4f2907fb13e6ea38a224b038e8fba0ef', 'B', '0000-00-00 00:00:00'),
('cf12b7efbb76c11dd5047c952001b07f', 'c1b81872d5e0f69a7f1eaea83e2b9daa', '826b88275434ceed95ef4c025ce4f6a7', '26e7ff089f768fb09cdbae897c0b6072', 'A', '0000-00-00 00:00:00'),
('3bef956eac46588eae822ef6bf377250', 'c1b81872d5e0f69a7f1eaea83e2b9daa', '826b88275434ceed95ef4c025ce4f6a7', 'cac6932b872f8832daa384367afcc334', 'B', '0000-00-00 00:00:00'),
('cae2d7dc2c2e9841d8d6a1e00f38747d', 'c1b81872d5e0f69a7f1eaea83e2b9daa', '826b88275434ceed95ef4c025ce4f6a7', '253fc02525ff24c7c652556c6756e20e', 'A', '0000-00-00 00:00:00'),
('828c378ebe6c4f9940fe7b9a5928817a', 'c1b81872d5e0f69a7f1eaea83e2b9daa', '826b88275434ceed95ef4c025ce4f6a7', '', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `siswa_soal_nilai`
--

CREATE TABLE `siswa_soal_nilai` (
  `kd` varchar(50) NOT NULL,
  `kd_siswa` varchar(50) NOT NULL,
  `kd_guru_mapel` varchar(50) NOT NULL,
  `jml_benar` varchar(3) NOT NULL,
  `jml_salah` varchar(3) NOT NULL,
  `waktu_mulai` datetime NOT NULL,
  `waktu_akhir` datetime NOT NULL,
  `skor` varchar(5) NOT NULL,
  `postdate` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `siswa_soal_nilai`
--

INSERT INTO `siswa_soal_nilai` (`kd`, `kd_siswa`, `kd_guru_mapel`, `jml_benar`, `jml_salah`, `waktu_mulai`, `waktu_akhir`, `skor`, `postdate`) VALUES
('d52f9d3fd697dc48a93aa2fcfcb9f5ee', 'c1b81872d5e0f69a7f1eaea83e2b9daa', '826b88275434ceed95ef4c025ce4f6a7', '1', '2', '2017-05-04 03:48:39', '2017-05-04 03:49:40', '0.25', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `siswa_tertulis`
--

CREATE TABLE `siswa_tertulis` (
  `kd` varchar(50) NOT NULL,
  `kd_siswa` varchar(50) NOT NULL,
  `kd_guru_mapel` varchar(50) NOT NULL,
  `nilai` varchar(5) NOT NULL,
  `postdate` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `siswa_tertulis`
--

INSERT INTO `siswa_tertulis` (`kd`, `kd_siswa`, `kd_guru_mapel`, `nilai`, `postdate`) VALUES
('', 'c1b81872d5e0f69a7f1eaea83e2b9daa', '656ace4f1630fb5b435bbfbede513682', '0', '0000-00-00 00:00:00'),
('', '', '656ace4f1630fb5b435bbfbede513682', '0', '0000-00-00 00:00:00'),
('cb2bc4eb7f17c217fd68b47295e8d626', 'c1b81872d5e0f69a7f1eaea83e2b9daa', '826b88275434ceed95ef4c025ce4f6a7', '1.5', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `m_mapel`
--
ALTER TABLE `m_mapel`
  ADD PRIMARY KEY (`kd`);

--
-- Indexes for table `m_soal`
--
ALTER TABLE `m_soal`
  ADD PRIMARY KEY (`kd`);

--
-- Indexes for table `m_tapel`
--
ALTER TABLE `m_tapel`
  ADD PRIMARY KEY (`kd`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`kd`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
