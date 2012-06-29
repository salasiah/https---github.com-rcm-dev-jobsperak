-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 11, 2012 at 08:21 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rcm_jobsperak`
--

-- --------------------------------------------------------

--
-- Table structure for table `jp_admin`
--

CREATE TABLE IF NOT EXISTS `jp_admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(20) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `admin_lastlogin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `jp_admin`
--

INSERT INTO `jp_admin` (`admin_id`, `admin_name`, `admin_password`, `admin_lastlogin`) VALUES
(2, 'mahfudz', '5f4dcc3b5aa765d61d8327deb882cf99', '2012-06-05 17:10:55'),
(3, 'fikri', '5f4dcc3b5aa765d61d8327deb882cf99', '2012-06-05 17:11:09');

-- --------------------------------------------------------

--
-- Table structure for table `jp_ads`
--

CREATE TABLE IF NOT EXISTS `jp_ads` (
  `ads_id` int(11) NOT NULL AUTO_INCREMENT,
  `ads_title` varchar(50) NOT NULL,
  `ads_details` text NOT NULL,
  `emp_id_fk` int(11) NOT NULL,
  `ads_location` int(11) NOT NULL,
  `ads_salary` varchar(50) NOT NULL,
  `ads_y_exp` int(2) NOT NULL,
  `ads_enable_view` int(1) NOT NULL DEFAULT '0',
  `ads_featured` int(1) DEFAULT '0',
  `ads_date_posted` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ads_date_published` timestamp NULL DEFAULT NULL,
  `ads_date_last_edited` timestamp NULL DEFAULT NULL,
  `ads_date_expired` datetime DEFAULT NULL,
  `ads_industry_id_fk` int(11) NOT NULL,
  PRIMARY KEY (`ads_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `jp_ads`
--

INSERT INTO `jp_ads` (`ads_id`, `ads_title`, `ads_details`, `emp_id_fk`, `ads_location`, `ads_salary`, `ads_y_exp`, `ads_enable_view`, `ads_featured`, `ads_date_posted`, `ads_date_published`, `ads_date_last_edited`, `ads_date_expired`, `ads_industry_id_fk`) VALUES
(1, 'Job satu', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, 1, '1800', 2, 1, NULL, '2012-06-06 15:23:21', '2012-06-07 01:52:00', '2012-06-07 01:52:00', NULL, 5),
(2, 'Manager', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat.', 2, 3, '3200', 1, 1, NULL, '2012-06-06 15:23:53', '2012-06-07 01:52:09', '2012-06-07 01:52:09', NULL, 2),
(3, 'Pemasaran', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit', 3, 3, '5000', 1, 1, NULL, '2012-06-06 15:24:31', '2012-06-07 01:52:18', '2012-06-07 01:52:18', NULL, 4),
(5, 'Administration Staff', 'Supporting Senior Admin Staff and must be computer literate as the work involved e commerce or trading products online.Must be at least a SPM holder and able to converse in English and Malay.Salary will commensurate with experience.\r\nJob Info:\r\nJob Type: Non-Executive\r\nExperience Level: < 1 year | 1-3 years\r\nJob Categories: Admin/Data Entry\r\nApplication Deadline: 22 Jun 2012', 5, 9, '1800', 2, 0, 0, '2012-06-10 19:19:35', NULL, NULL, NULL, 2),
(6, 'Pengawai khidmat pelanggan', 'PENGAWAI KHIDMAT PELANGGAN\r\n\r\nPeluang Kerjaya Sebagai Pengawai Khidmat Pelanggan di syarikat kita Dan Perkhidmatan Yang Ditawarkan kepada Pelanggan berasal di seluruh negeri-negeri di Malaysia termasuk Sabah dan Sarawak .Muhibbah Capital adalah sebuah Agensi Bertauliah dan telah banyak dikurniakan Sijil Perhargaan dan Sijil Kecemerlangan . Kami menawarkan kerjaya sebagai Pengawai Khidmat Pelanggan secara Sepenuh Masa dalam suasan kerja yang positif. \r\n\r\nKami mempunyai 25 kekosongan untuk jawatan Pegawai khidmat Pelanggan dan 10 kekosongan untuk Kerani Admin\r\n\r\nKELAYAKAN.\r\n- Untuk perempuan sahaja\r\n- Minimum SPM\r\n- Berumur 18-35thn\r\n- Bijak berkomunikasi BAHASA MELAYU melalui telefon\r\n- Boleh bekerja tanpa pengawasan\r\n\r\nFAEDAH\r\n$ GAJI RM800-RM1200 (Bergantung kepadaPengalaman Berkerja) + Komisen \r\n$ Elaun kedatangan RM200 sebulan\r\n$ Suasana Kerja Yang Positif .\r\n$ Latihan dan Tunjuk Ajar akan Diberi.\r\n$ Waktu kerja Isnin- Jumaat \r\n$ Peluang naik Pangkat\r\n\r\nSekiranya Berminat sila email resume ke \r\nmuhibbahcapital@gmail.com untuk temuduga\r\nHanya calon yang dipilih akan dihubungi.\r\nJob Info:\r\nSalary: RM 1 000 Monthly\r\nJob Type: Non-Executive\r\nExperience Level: < 1 year\r\nJob Categories: Bank/Finance/Insurance | Customer Svc/Call Centre\r\nApplication Deadline: 31 Jul 2012', 5, 15, '2500', 3, 0, 0, '2012-06-10 19:21:31', NULL, NULL, NULL, 6),
(7, 'Accounts Support Executive', 'We are an established Audio-Visual IT Based Company located in Sunway Damansara designs, build and distribute Audio-Visual IT based products in Malaysia, Singapore, Indonesia, Thailand, Taiwan, Vietnam and China. In Line with expansion, we are seeking qualified personnel to fill the position of: \r\n\r\nAccounts Support Executive\r\n\r\n*Location: Sunway Damansara (Near The Curve)\r\n*Fresh graduates are welcome to apply\r\n\r\nJob Function : \r\n\r\nAssist the Accounts Manager for all accounts & admin related matters\r\nAble to handle A/R & A/P independently\r\nDaily monitoring of aging and follow up on debtors and creditors\r\nEnsure compliance to companyâ€™s policies, procedures and internal control\r\nDay to day office administration matters & superb handling of enquiries\r\nAny ad hoc duties as assigned by Management \r\n\r\nRequirements : \r\n\r\nMale or female age between 20 â€“ 36 yrs with any discipline in accounting, partial or complete. \r\nPreferably with 1-2 years experience\r\nAble to start work immediately is an added advantage \r\nComputer literate & good working attitude\r\nWell organised, multi tasking and able to work under pressure\r\nKnowledge of SQL Accounting will be an added advantage\r\nGood command of English & excellent communication skill\r\n\r\nInterested candidates are advised to submit complete resume together with photo t0o myka_ang@yahoo.com\r\nJob Info:\r\nJob Type: Executive\r\nExperience Level: < 1 year | 1-3 years | 3-5 years\r\nJob Categories: Admin/Data Entry | Accounting/Tax/Audit | Bank/Finance/Insurance\r\nApplication Deadline: 31 Jul 2012', 5, 10, '300', 1, 1, 0, '2012-06-10 19:27:18', '2012-06-10 19:28:21', '2012-06-10 19:28:21', NULL, 6);

-- --------------------------------------------------------

--
-- Table structure for table `jp_application`
--

CREATE TABLE IF NOT EXISTS `jp_application` (
  `app_id` int(11) NOT NULL AUTO_INCREMENT,
  `ads_id_fk` int(11) NOT NULL,
  `js_id_fk` int(11) NOT NULL,
  `ads_app_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`app_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `jp_content`
--

CREATE TABLE IF NOT EXISTS `jp_content` (
  `content_id` int(11) NOT NULL AUTO_INCREMENT,
  `content_body` text NOT NULL,
  `page_id_fk` int(11) NOT NULL,
  `content_author` int(11) NOT NULL,
  `content_published` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`content_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `jp_content`
--

INSERT INTO `jp_content` (`content_id`, `content_body`, `page_id_fk`, `content_author`, `content_published`) VALUES
(1, 'About Us Page', 1, 1, '2012-06-05 17:26:33');

-- --------------------------------------------------------

--
-- Table structure for table `jp_education`
--

CREATE TABLE IF NOT EXISTS `jp_education` (
  `edu_id` int(11) NOT NULL AUTO_INCREMENT,
  `edu_qualification` int(5) NOT NULL,
  `edu_fieldStudy` int(5) NOT NULL,
  `edu_major` varchar(20) NOT NULL,
  `edu_grade` int(5) NOT NULL,
  `edu_cgpa` float DEFAULT NULL,
  `edu_university` varchar(50) NOT NULL,
  `edu_located` int(5) NOT NULL,
  `edu_date_graduate_month` int(2) NOT NULL,
  `edu_date_graduate_year` int(2) NOT NULL,
  `user_id_fk` int(11) NOT NULL,
  PRIMARY KEY (`edu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `jp_education`
--

INSERT INTO `jp_education` (`edu_id`, `edu_qualification`, `edu_fieldStudy`, `edu_major`, `edu_grade`, `edu_cgpa`, `edu_university`, `edu_located`, `edu_date_graduate_month`, `edu_date_graduate_year`, `user_id_fk`) VALUES
(1, 3, 1, 'Multimedia Design', 2, 3.8, 'KPTM Ipoh', 3, 11, 2011, 4),
(2, 2, 1, 'Design', 1, 2.5, 'KIUC', 2, 2, 2010, 4),
(3, 2, 2, 'Multimedia Design', 2, 3.8, 'KPTM Ipoh', 2, 7, 2008, 12),
(4, 2, 2, 'Multimedia Design', 2, 2.5, 'KPTM', 1, 3, 1977, 8);

-- --------------------------------------------------------

--
-- Table structure for table `jp_edu_lists`
--

CREATE TABLE IF NOT EXISTS `jp_edu_lists` (
  `edu_id` int(2) NOT NULL AUTO_INCREMENT,
  `edu_name` varchar(60) NOT NULL,
  PRIMARY KEY (`edu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `jp_edu_lists`
--

INSERT INTO `jp_edu_lists` (`edu_id`, `edu_name`) VALUES
(1, 'Professional Certificate'),
(2, 'Diploma'),
(3, 'Bachelor Degree');

-- --------------------------------------------------------

--
-- Table structure for table `jp_employer`
--

CREATE TABLE IF NOT EXISTS `jp_employer` (
  `emp_id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_name` varchar(50) NOT NULL,
  `emp_desc` text NOT NULL,
  `emp_industry_id_fk` int(2) DEFAULT NULL,
  `emp_address` text NOT NULL,
  `emp_tel` varchar(11) NOT NULL,
  `emp_email` varchar(50) NOT NULL,
  `emp_web` varchar(50) DEFAULT NULL,
  `emp_pic` varchar(255) DEFAULT NULL,
  `emp_featured` int(1) DEFAULT '0',
  `users_id_fk` int(11) NOT NULL,
  PRIMARY KEY (`emp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `jp_employer`
--

INSERT INTO `jp_employer` (`emp_id`, `emp_name`, `emp_desc`, `emp_industry_id_fk`, `emp_address`, `emp_tel`, `emp_email`, `emp_web`, `emp_pic`, `emp_featured`, `users_id_fk`) VALUES
(1, 'Rich Core Media Sdn Bhd', 'Lorem ipsum dolor sit amet', 6, 'Phileo Damansara 2, PJ', '03234567891', 'hello@richcoremedia.com.my', 'www.richcoremedia.com.my', NULL, 1, 1),
(2, 'Innovatis Sdn Bhd', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat.', 2, 'Petaling Jaya', '0323456789', 'info@innovatis.com', 'www.innovatis.com.my', '/media/employer/img/default_employ.png', 1, 2),
(3, 'Amannagappa', 'Lorem ipsum dolor sit amet', 7, 'Petaling Jaya', '0323456789', 'hi@amannagappa.com', 'www.amannagappa.com', '/media/employer/img/default_employ.png', 0, 3),
(4, 'Y Us', 'Software Based', 3, 'TPM', '0323456789', 'info@yus.com.my', 'http://www.yus.com.my', NULL, 0, 10),
(5, 'Sastred One Sdn Bhd', 'Pandan Indah', 4, 'Pandan Indah', '0323456789', 'info@sastredone.com', 'http://www.sastredone.com', NULL, 0, 9);

-- --------------------------------------------------------

--
-- Table structure for table `jp_experience`
--

CREATE TABLE IF NOT EXISTS `jp_experience` (
  `exp_id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id_fk` int(11) NOT NULL,
  `exp_co_name` varchar(30) DEFAULT NULL,
  `industry_id_fk` int(11) NOT NULL,
  `exp_pos_title` varchar(30) DEFAULT NULL,
  `exp_specialize` int(3) DEFAULT NULL,
  `exp_role` varchar(30) DEFAULT NULL,
  `exp_monthlysalary` int(6) NOT NULL,
  `exp_word_desc` varchar(30) NOT NULL,
  `exp_from_to` int(2) NOT NULL,
  `exp_to_m` int(2) DEFAULT NULL,
  `exp_to_y` int(4) DEFAULT NULL,
  `exp_from_to_y` int(4) DEFAULT NULL,
  `exp_pos_level` int(1) NOT NULL,
  PRIMARY KEY (`exp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `jp_experience`
--

INSERT INTO `jp_experience` (`exp_id`, `users_id_fk`, `exp_co_name`, `industry_id_fk`, `exp_pos_title`, `exp_specialize`, `exp_role`, `exp_monthlysalary`, `exp_word_desc`, `exp_from_to`, `exp_to_m`, `exp_to_y`, `exp_from_to_y`, `exp_pos_level`) VALUES
(1, 4, 'Terabytech Berhad', 1, 'Technicion', 1, 'Junior', 500, 'work desc goes here', 12, 12, 2011, 2010, 5),
(2, 4, 'Terabytech Sdn Bhd', 1, 'S Technicion', 1, 'Junior', 5000, 'work desc goes here 2', 12, 1, 2010, 2008, 5),
(3, 4, '7 Eleven', 7, 'Cashier', 2, 'Store Keeper', 1200, 'Packing Store Item', 10, 12, 2011, 2011, 5),
(4, 12, 'KK', 7, 'Technicion', 2, 'Junior', 5000, 'Work', 2, 12, 1996, 1990, 5),
(5, 8, 'Terabytech Berhad', 3, 'S Technicion', 2, 'Store Keeper', 5000, 'asdasdsadsa', 2, 11, 2011, 1977, 4);

-- --------------------------------------------------------

--
-- Table structure for table `jp_field_list`
--

CREATE TABLE IF NOT EXISTS `jp_field_list` (
  `field_id` int(3) NOT NULL AUTO_INCREMENT,
  `field_name` varchar(60) NOT NULL,
  PRIMARY KEY (`field_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `jp_field_list`
--

INSERT INTO `jp_field_list` (`field_id`, `field_name`) VALUES
(1, 'Science'),
(2, 'Art');

-- --------------------------------------------------------

--
-- Table structure for table `jp_grade_list`
--

CREATE TABLE IF NOT EXISTS `jp_grade_list` (
  `grade_id` int(3) NOT NULL AUTO_INCREMENT,
  `grade_name` varchar(60) NOT NULL,
  PRIMARY KEY (`grade_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `jp_grade_list`
--

INSERT INTO `jp_grade_list` (`grade_id`, `grade_name`) VALUES
(1, 'Grade A'),
(2, '1st Class');

-- --------------------------------------------------------

--
-- Table structure for table `jp_industry`
--

CREATE TABLE IF NOT EXISTS `jp_industry` (
  `indus_id` int(11) NOT NULL AUTO_INCREMENT,
  `indus_name` varchar(30) NOT NULL,
  `industry_parent` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`indus_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `jp_industry`
--

INSERT INTO `jp_industry` (`indus_id`, `indus_name`, `industry_parent`) VALUES
(1, 'automotive', 0),
(2, 'Biotech', 0),
(3, 'Business Development', 0),
(4, 'Business Opportunity', 0),
(5, 'Construction', 0),
(6, 'Consultancy', 0),
(7, 'Customer Service', 0),
(8, 'Design', 0),
(9, 'Graphic', 8);

-- --------------------------------------------------------

--
-- Table structure for table `jp_industry_sub`
--

CREATE TABLE IF NOT EXISTS `jp_industry_sub` (
  `sub_indus_id` int(11) NOT NULL DEFAULT '0',
  `sub_indus_name` varchar(30) NOT NULL,
  `parent_indus` int(11) NOT NULL,
  PRIMARY KEY (`sub_indus_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jp_jobpreferences`
--

CREATE TABLE IF NOT EXISTS `jp_jobpreferences` (
  `jobP_id` int(11) NOT NULL AUTO_INCREMENT,
  `jobP_1` int(11) NOT NULL,
  `jobP_2` int(11) NOT NULL,
  `jobP_3` int(11) DEFAULT NULL,
  `jobP_salary` int(11) NOT NULL,
  `user_id_fk` int(11) NOT NULL,
  PRIMARY KEY (`jobP_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `jp_jobpreferences`
--

INSERT INTO `jp_jobpreferences` (`jobP_id`, `jobP_1`, `jobP_2`, `jobP_3`, `jobP_salary`, `user_id_fk`) VALUES
(1, 3, 1, NULL, 2000, 4),
(2, 1, 7, NULL, 2000, 12),
(3, 6, 6, NULL, 1500, 8);

-- --------------------------------------------------------

--
-- Table structure for table `jp_jobseeker`
--

CREATE TABLE IF NOT EXISTS `jp_jobseeker` (
  `jobseeker_id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id_fk` int(11) NOT NULL,
  `jobseeker_tel` varchar(11) NOT NULL,
  `jobseeker_mobile` varchar(11) NOT NULL,
  `jobseeker_address` text NOT NULL,
  `jobseeker_dob_y` int(4) DEFAULT NULL,
  `jobseeker_dob_m` int(2) DEFAULT NULL,
  `jobseeker_dob_d` int(2) DEFAULT NULL,
  `jobseeker_gender` int(11) NOT NULL,
  `jobseeker_nationality` int(11) NOT NULL,
  `jobseeker_moreinfo` text NOT NULL,
  `jobseeker_pic` varchar(255) DEFAULT NULL,
  `jobseeker_last_edited` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`jobseeker_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `jp_jobseeker`
--

INSERT INTO `jp_jobseeker` (`jobseeker_id`, `users_id_fk`, `jobseeker_tel`, `jobseeker_mobile`, `jobseeker_address`, `jobseeker_dob_y`, `jobseeker_dob_m`, `jobseeker_dob_d`, `jobseeker_gender`, `jobseeker_nationality`, `jobseeker_moreinfo`, `jobseeker_pic`, `jobseeker_last_edited`) VALUES
(1, 4, '0323456789', '0123456789', 'Cheras', 1987, 9, 22, 2, 1, 'Additional info goes here', '/media/jobseeker/default_jobseeker.png', '2012-06-06 15:50:13'),
(2, 5, '0323456789', '0123456789', 'Bangsar', 1984, 1, 1, 2, 1, 'Additional info', '/media/jobseeker/default_jobseeker.png', '2012-06-06 15:54:05'),
(3, 8, '0345678912', '0123456789', 'Taman Saujana Jaya, Asam Kumbang\r\nTaiping, Perak Daruk Ridzuan', 1984, 10, 24, 2, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam neque est, ultrices et ultricies ut, mollis vel nunc. Sed et accumsan nisi. Duis suscipit commodo sem ac dapibus. Etiam at sem augue, accumsan dapibus sapien. Donec vitae metus nisl. Vivamus vulputate vestibulum tellus, nec vestibulum felis aliquet sed. Nulla facilisi. Pellentesque enim elit, tempor a vehicula vitae, molestie eget mi. In hac habitasse platea dictumst. Phasellus fringilla, sapien id pellentesque iaculis, augue neque egestas risus, vitae dictum nunc eros consequat nunc. Phasellus adipiscing, arcu ut laoreet consectetur, odio est ultricies erat, vel fermentum quam elit sed est. Donec gravida, massa ac venenatis adipiscing, mauris diam mollis massa, sagittis auctor enim orci vitae nulla. Nunc egestas augue ac lectus condimentum vel tincidunt elit varius.', NULL, NULL),
(4, 12, '0345678912', '0123456789', 'Pahang', 1978, 5, 19, 2, 1, 'More info', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jp_language`
--

CREATE TABLE IF NOT EXISTS `jp_language` (
  `lang_id` int(11) NOT NULL AUTO_INCREMENT,
  `lang_name` int(11) NOT NULL,
  `lang_written` int(11) NOT NULL,
  `lang_spoken` int(11) NOT NULL,
  `user_id_fk` int(11) NOT NULL,
  PRIMARY KEY (`lang_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `jp_language`
--

INSERT INTO `jp_language` (`lang_id`, `lang_name`, `lang_written`, `lang_spoken`, `user_id_fk`) VALUES
(1, 1, 5, 5, 4),
(2, 2, 10, 8, 4),
(3, 2, 10, 10, 12),
(4, 1, 10, 10, 8),
(5, 2, 10, 10, 8);

-- --------------------------------------------------------

--
-- Table structure for table `jp_language_list`
--

CREATE TABLE IF NOT EXISTS `jp_language_list` (
  `languList_id` int(3) NOT NULL AUTO_INCREMENT,
  `languList_name` varchar(60) NOT NULL,
  PRIMARY KEY (`languList_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `jp_language_list`
--

INSERT INTO `jp_language_list` (`languList_id`, `languList_name`) VALUES
(1, 'Bahasa Malaysia'),
(2, 'English');

-- --------------------------------------------------------

--
-- Table structure for table `jp_level`
--

CREATE TABLE IF NOT EXISTS `jp_level` (
  `level_id` int(11) NOT NULL AUTO_INCREMENT,
  `level_position` varchar(30) NOT NULL,
  PRIMARY KEY (`level_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `jp_level`
--

INSERT INTO `jp_level` (`level_id`, `level_position`) VALUES
(1, 'Senior Manager'),
(2, 'Manager'),
(3, 'Senior Executive'),
(4, 'Junior Executive'),
(5, 'Fresh / Entry Level'),
(6, 'Junior Executive');

-- --------------------------------------------------------

--
-- Table structure for table `jp_location`
--

CREATE TABLE IF NOT EXISTS `jp_location` (
  `location_id` int(11) NOT NULL AUTO_INCREMENT,
  `location_name` varchar(30) NOT NULL,
  `location_parent` int(3) DEFAULT '0',
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `jp_location`
--

INSERT INTO `jp_location` (`location_id`, `location_name`, `location_parent`) VALUES
(1, 'johor', 0),
(2, 'melaka', 0),
(3, 'pahang', 0),
(4, 'negeri sembilan', 0),
(5, 'selangor', 0),
(6, 'perak', 0),
(7, 'kedah', 0),
(8, 'kelantan', 0),
(9, 'pulau pinang', 0),
(10, 'kuala lumpur', 0),
(11, 'putrajaya', 0),
(12, 'cyberjaya', 0),
(13, 'perlis', 0),
(14, 'sabah', 0),
(15, 'sarawak', 0),
(16, 'brunei', 0),
(17, 'Ipoh', 6),
(18, 'Taiping', 6);

-- --------------------------------------------------------

--
-- Table structure for table `jp_location_sub`
--

CREATE TABLE IF NOT EXISTS `jp_location_sub` (
  `location_sub_id` int(11) NOT NULL AUTO_INCREMENT,
  `location_sub_name` varchar(30) NOT NULL,
  `location_parent_id_fk` int(11) NOT NULL,
  PRIMARY KEY (`location_sub_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `jp_location_sub`
--

INSERT INTO `jp_location_sub` (`location_sub_id`, `location_sub_name`, `location_parent_id_fk`) VALUES
(1, 'ipoh', 6),
(2, 'taiping', 6);

-- --------------------------------------------------------

--
-- Table structure for table `jp_nationality`
--

CREATE TABLE IF NOT EXISTS `jp_nationality` (
  `national_id` int(11) NOT NULL AUTO_INCREMENT,
  `national_name` varchar(100) NOT NULL,
  PRIMARY KEY (`national_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `jp_nationality`
--

INSERT INTO `jp_nationality` (`national_id`, `national_name`) VALUES
(1, 'Malaysia'),
(2, 'Indonesia'),
(3, 'Singapore');

-- --------------------------------------------------------

--
-- Table structure for table `jp_pages`
--

CREATE TABLE IF NOT EXISTS `jp_pages` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_title` varchar(20) NOT NULL,
  `page_group` int(1) NOT NULL,
  `page_order` int(1) NOT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `jp_pages`
--

INSERT INTO `jp_pages` (`page_id`, `page_title`, `page_group`, `page_order`) VALUES
(1, 'About Us', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `jp_pgroup`
--

CREATE TABLE IF NOT EXISTS `jp_pgroup` (
  `pgroup_id` int(11) NOT NULL AUTO_INCREMENT,
  `pgroup_name` varchar(20) NOT NULL,
  PRIMARY KEY (`pgroup_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `jp_pgroup`
--

INSERT INTO `jp_pgroup` (`pgroup_id`, `pgroup_name`) VALUES
(1, 'topmenu');

-- --------------------------------------------------------

--
-- Table structure for table `jp_references`
--

CREATE TABLE IF NOT EXISTS `jp_references` (
  `ref_id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_name` varchar(30) NOT NULL,
  `ref_relationship` varchar(50) DEFAULT NULL,
  `ref_email` varchar(30) NOT NULL,
  `ref_phone` varchar(11) NOT NULL,
  `ref_pos_title` varchar(30) NOT NULL,
  `ref_comp_name` varchar(30) NOT NULL,
  `user_id_fk` int(11) NOT NULL,
  PRIMARY KEY (`ref_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `jp_references`
--

INSERT INTO `jp_references` (`ref_id`, `ref_name`, `ref_relationship`, `ref_email`, `ref_phone`, `ref_pos_title`, `ref_comp_name`, `user_id_fk`) VALUES
(1, 'Mansor Selamat', 'Friend', 'mansor@yahoo.com', '0123456789', 'CEO', 'Terabyte Technologies Sdn Bhd', 4),
(2, 'Mansor Selamat', 'Friend', 'mansor@yahoo.com', '60132465974', 'CEO', 'Terabyte Technologies Sdn Bhd', 12),
(3, 'Mansor Selamat', '0', 'mansor@yahoo.com', '60132465974', 'CEO', 'Terabyte Technologies Sdn Bhd', 8);

-- --------------------------------------------------------

--
-- Table structure for table `jp_resume`
--

CREATE TABLE IF NOT EXISTS `jp_resume` (
  `resume_id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id_fk` int(11) NOT NULL,
  `resume_title` varchar(30) NOT NULL,
  `resume_type` int(1) NOT NULL,
  `resume_featured` int(1) DEFAULT '0',
  `resume_path` text NOT NULL,
  `resume_upload_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`resume_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `jp_resume`
--

INSERT INTO `jp_resume` (`resume_id`, `users_id_fk`, `resume_title`, `resume_type`, `resume_featured`, `resume_path`, `resume_upload_on`) VALUES
(1, 4, 'My Resume', 1, 1, '/media/resume/myresume.pdf', '2012-06-06 16:00:00'),
(2, 5, 'My Best Resume', 2, 1, '/media/resume/mybestresume.doc', '2012-06-05 16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `jp_skills`
--

CREATE TABLE IF NOT EXISTS `jp_skills` (
  `skills_id` int(11) NOT NULL AUTO_INCREMENT,
  `skills_name` varchar(50) NOT NULL,
  `skills_y_exp` int(1) NOT NULL,
  `skills_proficiency` int(1) NOT NULL,
  `user_id_fk` int(11) NOT NULL,
  PRIMARY KEY (`skills_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `jp_skills`
--

INSERT INTO `jp_skills` (`skills_id`, `skills_name`, `skills_y_exp`, `skills_proficiency`, `user_id_fk`) VALUES
(1, 'Web Design', 4, 10, 4),
(2, 'Programming', 2, 9, 4),
(3, 'PHP', 5, 9, 4),
(4, 'Programming', 4, 10, 12),
(5, 'Programming', 4, 10, 8),
(6, 'Web Design', 5, 10, 8);

-- --------------------------------------------------------

--
-- Table structure for table `jp_specialize`
--

CREATE TABLE IF NOT EXISTS `jp_specialize` (
  `specialize_id` int(11) NOT NULL AUTO_INCREMENT,
  `specialize_name` varchar(60) NOT NULL,
  PRIMARY KEY (`specialize_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `jp_specialize`
--

INSERT INTO `jp_specialize` (`specialize_id`, `specialize_name`) VALUES
(1, 'Education'),
(2, 'IT/Computer - Software');

-- --------------------------------------------------------

--
-- Table structure for table `jp_type`
--

CREATE TABLE IF NOT EXISTS `jp_type` (
  `type_id` int(11) NOT NULL DEFAULT '0',
  `type_name` int(30) NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jp_users`
--

CREATE TABLE IF NOT EXISTS `jp_users` (
  `users_id` int(11) NOT NULL AUTO_INCREMENT,
  `users_email` text NOT NULL,
  `users_pass` varchar(50) NOT NULL,
  `users_register` datetime NOT NULL,
  `users_last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `users_fname` varchar(30) NOT NULL,
  `users_lname` varchar(30) NOT NULL,
  `users_type` int(1) NOT NULL,
  `user_active` int(1) DEFAULT '0',
  PRIMARY KEY (`users_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `jp_users`
--

INSERT INTO `jp_users` (`users_id`, `users_email`, `users_pass`, `users_register`, `users_last_login`, `users_fname`, `users_lname`, `users_type`, `user_active`) VALUES
(1, 'mahfudz@richcoremedia.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2012-06-05 00:00:00', '2012-06-06 15:36:33', 'Muhamad Iqbal', 'Mahmud', 2, 1),
(2, 'hello@innovatis.com.my', '5f4dcc3b5aa765d61d8327deb882cf99', '2012-06-04 00:00:00', '2012-06-06 15:37:26', 'Muhamad', 'Sufyan', 2, 1),
(3, 'dz@amannagappa.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2012-06-04 00:00:00', '2012-06-06 15:38:18', 'Mohd', 'Dzairil', 2, 1),
(4, 'fofodesign@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2012-06-05 00:00:00', '2012-06-06 15:45:23', 'Muhamad', 'Nizam Akbar', 1, 1),
(5, 'alanmacho@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2012-06-01 00:00:00', '2012-06-06 15:53:07', 'Sirajul', 'Fikri', 1, 1),
(8, 'princess.umie@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2012-06-07 23:25:09', '2012-06-07 15:25:09', 'Umi Aiman', 'Abd Halim', 1, 1),
(9, 'satredone@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2012-06-07 23:28:14', '2012-06-07 15:28:14', 'Sastred', 'One', 2, 0),
(10, 'yus@yus.com.my', '5f4dcc3b5aa765d61d8327deb882cf99', '2012-06-07 23:29:42', '2012-06-07 15:29:42', 'Y', 'Us', 2, 0),
(11, 'pj@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2012-06-09 20:45:28', '2012-06-09 12:45:28', 'Fakhrul Hafiz', 'Mohamad', 1, 0),
(12, 'ahmad@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2012-06-10 15:29:36', '2012-06-10 07:29:36', 'Muhamad Ahmad', 'Ramli', 1, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
