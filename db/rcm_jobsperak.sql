-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 15, 2012 at 10:32 AM
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `jp_ads`
--

INSERT INTO `jp_ads` (`ads_id`, `ads_title`, `ads_details`, `emp_id_fk`, `ads_location`, `ads_salary`, `ads_y_exp`, `ads_enable_view`, `ads_featured`, `ads_date_posted`, `ads_date_published`, `ads_date_last_edited`, `ads_date_expired`, `ads_industry_id_fk`) VALUES
(1, 'Job satu', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, 1, '1800', 2, 1, NULL, '2012-06-06 15:23:21', '2012-06-07 01:52:00', '2012-06-07 01:52:00', NULL, 5),
(2, 'Manager', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat.', 2, 3, '3200', 1, 1, NULL, '2012-06-06 15:23:53', '2012-06-07 01:52:09', '2012-06-07 01:52:09', NULL, 2),
(3, 'Pemasaran', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit', 3, 3, '5000', 1, 1, NULL, '2012-06-06 15:24:31', '2012-06-07 01:52:18', '2012-06-07 01:52:18', NULL, 4),
(5, 'Administration Staff', 'Supporting Senior Admin Staff and must be computer literate as the work involved e commerce or trading products online.Must be at least a SPM holder and able to converse in English and Malay.Salary will commensurate with experience.\r\nJob Info:\r\nJob Type: Non-Executive\r\nExperience Level: < 1 year | 1-3 years\r\nJob Categories: Admin/Data Entry\r\nApplication Deadline: 22 Jun 2012', 5, 9, '1800', 2, 0, 0, '2012-06-10 19:19:35', NULL, NULL, NULL, 2),
(6, 'Pengawai khidmat pelanggan', 'PENGAWAI KHIDMAT PELANGGAN\r\n\r\nPeluang Kerjaya Sebagai Pengawai Khidmat Pelanggan di syarikat kita Dan Perkhidmatan Yang Ditawarkan kepada Pelanggan berasal di seluruh negeri-negeri di Malaysia termasuk Sabah dan Sarawak .Muhibbah Capital adalah sebuah Agensi Bertauliah dan telah banyak dikurniakan Sijil Perhargaan dan Sijil Kecemerlangan . Kami menawarkan kerjaya sebagai Pengawai Khidmat Pelanggan secara Sepenuh Masa dalam suasan kerja yang positif. \r\n\r\nKami mempunyai 25 kekosongan untuk jawatan Pegawai khidmat Pelanggan dan 10 kekosongan untuk Kerani Admin\r\n\r\nKELAYAKAN.\r\n- Untuk perempuan sahaja\r\n- Minimum SPM\r\n- Berumur 18-35thn\r\n- Bijak berkomunikasi BAHASA MELAYU melalui telefon\r\n- Boleh bekerja tanpa pengawasan\r\n\r\nFAEDAH\r\n$ GAJI RM800-RM1200 (Bergantung kepadaPengalaman Berkerja) + Komisen \r\n$ Elaun kedatangan RM200 sebulan\r\n$ Suasana Kerja Yang Positif .\r\n$ Latihan dan Tunjuk Ajar akan Diberi.\r\n$ Waktu kerja Isnin- Jumaat \r\n$ Peluang naik Pangkat\r\n\r\nSekiranya Berminat sila email resume ke \r\nmuhibbahcapital@gmail.com untuk temuduga\r\nHanya calon yang dipilih akan dihubungi.\r\nJob Info:\r\nSalary: RM 1 000 Monthly\r\nJob Type: Non-Executive\r\nExperience Level: < 1 year\r\nJob Categories: Bank/Finance/Insurance | Customer Svc/Call Centre\r\nApplication Deadline: 31 Jul 2012', 5, 15, '2500', 3, 0, 0, '2012-06-10 19:21:31', NULL, NULL, NULL, 6),
(7, 'Accounts Support Executive', 'We are an established Audio-Visual IT Based Company located in Sunway Damansara designs, build and distribute Audio-Visual IT based products in Malaysia, Singapore, Indonesia, Thailand, Taiwan, Vietnam and China. In Line with expansion, we are seeking qualified personnel to fill the position of: \r\n\r\nAccounts Support Executive\r\n\r\n*Location: Sunway Damansara (Near The Curve)\r\n*Fresh graduates are welcome to apply\r\n\r\nJob Function : \r\n\r\nAssist the Accounts Manager for all accounts & admin related matters\r\nAble to handle A/R & A/P independently\r\nDaily monitoring of aging and follow up on debtors and creditors\r\nEnsure compliance to companyâ€™s policies, procedures and internal control\r\nDay to day office administration matters & superb handling of enquiries\r\nAny ad hoc duties as assigned by Management \r\n\r\nRequirements : \r\n\r\nMale or female age between 20 â€“ 36 yrs with any discipline in accounting, partial or complete. \r\nPreferably with 1-2 years experience\r\nAble to start work immediately is an added advantage \r\nComputer literate & good working attitude\r\nWell organised, multi tasking and able to work under pressure\r\nKnowledge of SQL Accounting will be an added advantage\r\nGood command of English & excellent communication skill\r\n\r\nInterested candidates are advised to submit complete resume together with photo t0o myka_ang@yahoo.com\r\nJob Info:\r\nJob Type: Executive\r\nExperience Level: < 1 year | 1-3 years | 3-5 years\r\nJob Categories: Admin/Data Entry | Accounting/Tax/Audit | Bank/Finance/Insurance\r\nApplication Deadline: 31 Jul 2012', 5, 10, '300', 1, 1, 0, '2012-06-10 19:27:18', '2012-06-10 19:28:21', '2012-06-10 19:28:21', NULL, 6),
(8, 'Test job ads title', 'content job descriptions', 1, 14, '1800', 4, 1, 0, '2012-06-12 15:44:00', NULL, NULL, NULL, 18),
(9, 'Business Analyst', '<p><span style="color: #414042; font-family: Arial; font-size: x-small;"><span>Responsibilities:</span></span></p>\r\n<ul>\r\n<span style="color: #414042; font-family: Arial; font-size: x-small;">\r\n<li>Understanding business process management and business requirements of the customers and translating them to specific software requirements.</li>\r\n<li>Making sure that the solution recommended is commercial yet competitive.</li>\r\n<li>Documenting and analyzing the required information and data.</li>\r\n<li>Understanding the technical designs as well as the specifications.</li>\r\n<li>Effectively communicating with internal teams and external clients to deliver functional requirements like GUI, screen and interface designs.</li>\r\n<li>Acting as an interface between business units, technology teams and support teams</li>\r\n<li>Communicates effectively with clients to identify needs and evaluate alternative business solutions with project management</li>\r\n<li>Develops functional specifications and system design specifications for client engagements</li>\r\n<li>Communicates needed changes to development team</li>\r\n<li>Manages client expectations effectively</li>\r\n</span> \r\n</ul>\r\n<p>&nbsp;</p>\r\n<p><span style="color: #414042; font-family: Arial; font-size: x-small;">&nbsp;</span></p>\r\n<p><span style="color: #414042; font-family: Arial; font-size: x-small;"><strong><span>Requirements:</span></strong></span></p>\r\n<ul>\r\n<span style="color: #414042; font-family: Arial; font-size: x-small;">\r\n<li>Candidate must possess at least a Diploma, Advanced/Higher/Graduate Diploma, Master''s Degree, Engineering (Computer/Telecommunication), Computer Science/Information Technology, Science &amp; Technology, Commerce, Finance/Accountancy/Banking or equivalent.</li>\r\n<li>Required language(s): English</li>\r\n<li>At least 3 year(s) of working experience in the related field is required for this position.</li>\r\n<li>Preferably Senior Executives specializing in IT/Computer - Software or equivalent.</li>\r\n<li>Graduates with Banking Experience/ B.Tech or MCA with MBA</li>\r\n<li>Sound domain knowledge and experience in the BFSI Industry (Retail Banking, Commercial Banking, Wealth Management, Billing and Pricing systems)</li>\r\n<li>Must have experience in preparing solution proposals and functional requirements in consultation with clients and partners</li>\r\n<li>Must have experience in preparing functional test cases</li>\r\n<li>Must have project experience in functional testing of banking applications</li>\r\n<li>Implementation Experience in Banking Systems is desirable&nbsp;</li>\r\n<li>Exposure to Pricing and Billing requirements in Financial Institutions is desirable.</li>\r\n<li>Must have excellent documentation and communication skills</li>\r\n<li>Should be pro-active and have a strong desire to learn</li>\r\n<li>4 Full-Time position(s) available.</li>\r\n</span> \r\n</ul>\r\n<p><strong><br /></strong></p>', 1, 6, '4000', 4, 1, 0, '2012-06-12 18:07:38', NULL, NULL, NULL, 14);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `jp_application`
--

INSERT INTO `jp_application` (`app_id`, `ads_id_fk`, `js_id_fk`, `ads_app_date`) VALUES
(1, 7, 1, '2012-06-12 07:35:44'),
(2, 1, 3, '2012-06-12 11:29:37'),
(3, 3, 3, '2012-06-12 11:30:23'),
(4, 2, 3, '2012-06-12 11:30:26'),
(5, 3, 1, '2012-06-12 11:43:46'),
(6, 2, 1, '2012-06-12 11:44:21'),
(7, 1, 1, '2012-06-12 11:44:24'),
(8, 7, 6, '2012-06-12 15:18:11'),
(9, 8, 1, '2012-06-12 16:19:00'),
(12, 9, 6, '2012-06-13 04:10:28');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `jp_education`
--

INSERT INTO `jp_education` (`edu_id`, `edu_qualification`, `edu_fieldStudy`, `edu_major`, `edu_grade`, `edu_cgpa`, `edu_university`, `edu_located`, `edu_date_graduate_month`, `edu_date_graduate_year`, `user_id_fk`) VALUES
(1, 3, 1, 'Multimedia Design', 2, 3.8, 'KPTM Ipoh', 3, 11, 2011, 4),
(2, 2, 1, 'Design', 1, 2.5, 'KIUC', 2, 2, 2010, 4),
(3, 2, 2, 'Multimedia Design', 2, 3.8, 'KPTM Ipoh', 2, 7, 2008, 12),
(4, 2, 2, 'Multimedia Design', 2, 2.5, 'KPTM', 1, 3, 1977, 8),
(5, 5, 6, 'Multimedia Design', 3, 3.1, 'KPTM Ipoh', 127, 12, 2009, 16);

-- --------------------------------------------------------

--
-- Table structure for table `jp_edu_lists`
--

CREATE TABLE IF NOT EXISTS `jp_edu_lists` (
  `edu_id` int(2) NOT NULL AUTO_INCREMENT,
  `edu_name` varchar(60) NOT NULL,
  PRIMARY KEY (`edu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `jp_edu_lists`
--

INSERT INTO `jp_edu_lists` (`edu_id`, `edu_name`) VALUES
(1, 'Primary/Secondary School/SPM/''0'' Level'),
(2, 'Higher Secondary/STPM/''A'' Level/Pre-U'),
(3, 'Professional Certificate'),
(4, 'Diploma'),
(5, 'Advanced/Higher/Graduate Diploma'),
(6, 'Bachelor''s Degree'),
(7, 'Post Graduate Diploma'),
(8, 'Professional Degree'),
(9, 'Master''s Degree'),
(10, 'Doctorate (PhD)');

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
(1, 'Rich Core Media Sdn Bhd', 'Lorem ipsum dolor sit amet', 6, 'Phileo Damansara 2, PJ', '03234567891', 'hello@richcoremedia.com.my', 'www.richcoremedia.com.my', 'June-13-2012-10-24-am-rcm.png', 1, 1),
(2, 'Innovatis Sdn Bhd', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat.', 2, 'Petaling Jaya', '0323456789', 'info@innovatis.com', 'www.innovatis.com.my', 'default_employ.png', 1, 2),
(3, 'Amannagappa', 'Lorem ipsum dolor sit amet', 7, 'Petaling Jaya', '0323456789', 'hi@amannagappa.com', 'www.amannagappa.com', 'default_employ.png', 0, 3),
(4, 'Y Us', 'Software Based', 3, 'TPM', '0323456789', 'info@yus.com.my', 'http://www.yus.com.my', 'default_employ.png', 0, 10),
(5, 'Sastred One Sdn Bhd', 'Pandan Indah', 4, 'Pandan Indah', '0323456789', 'info@sastredone.com', 'http://www.sastredone.com', 'default_employ.png', 0, 9);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `jp_experience`
--

INSERT INTO `jp_experience` (`exp_id`, `users_id_fk`, `exp_co_name`, `industry_id_fk`, `exp_pos_title`, `exp_specialize`, `exp_role`, `exp_monthlysalary`, `exp_word_desc`, `exp_from_to`, `exp_to_m`, `exp_to_y`, `exp_from_to_y`, `exp_pos_level`) VALUES
(1, 4, 'Terabytech Berhad', 1, 'Technicion', 1, 'Junior', 500, 'work desc goes here', 12, 12, 2011, 2010, 5),
(2, 4, 'Terabytech Sdn Bhd', 1, 'S Technicion', 1, 'Junior', 5000, 'work desc goes here 2', 12, 1, 2010, 2008, 5),
(3, 4, '7 Eleven', 7, 'Cashier', 2, 'Store Keeper', 1200, 'Packing Store Item', 10, 12, 2011, 2011, 5),
(4, 12, 'KK', 7, 'Technicion', 2, 'Junior', 5000, 'Work', 2, 12, 1996, 1990, 5),
(5, 8, 'Terabytech Berhad', 3, 'S Technicion', 2, 'Store Keeper', 5000, 'asdasdsadsa', 2, 11, 2011, 1977, 4),
(6, 15, 'AMN', 96, 'Executive', 36, 'Network Executive', 3000, 'Maintain network and database ', 3, 8, 2010, 2004, 4),
(7, 16, 'Terabytech Berhad', 2, 'Technicion', 19, 'Store Keeper', 5000, 'work', 3, 5, 2011, 2008, 2);

-- --------------------------------------------------------

--
-- Table structure for table `jp_field_list`
--

CREATE TABLE IF NOT EXISTS `jp_field_list` (
  `field_id` int(3) NOT NULL AUTO_INCREMENT,
  `field_name` varchar(60) NOT NULL,
  PRIMARY KEY (`field_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=72 ;

--
-- Dumping data for table `jp_field_list`
--

INSERT INTO `jp_field_list` (`field_id`, `field_name`) VALUES
(1, 'Advertising/Media'),
(2, 'Agriculture/Aquaculture/Forestry'),
(3, 'Airline Operation/Airport Management'),
(4, 'Architecture'),
(5, 'Art/Design/Creative Multimedia'),
(6, 'Biology'),
(7, 'Biotechnology'),
(8, 'Business Studies/Administration/Management'),
(9, 'Chemistry'),
(10, 'Commerce'),
(11, 'Computer Science/Information Technology'),
(12, 'Dentistry'),
(13, 'Economics'),
(14, 'Jurnalism'),
(15, 'Education/Training/Learning'),
(16, 'Engineering (Aviation/Aeronautics/Astronautics)'),
(17, 'Engineering (Bioengineering/Biomedical)'),
(18, 'Engineering (Chemical)'),
(19, 'Engineering (Civil)'),
(20, 'Engineering (Computer/Telecommunication)'),
(21, 'Engineering (Electrical/Electronic)'),
(22, 'Engineering (Environmental/Health/Safety)'),
(23, 'Engineering (Industrial)'),
(24, 'Engineering (Marine)'),
(25, 'Engineering (Material Science)'),
(26, 'Engineering (Mechanical)'),
(27, 'Engineering (Mechatronic/Electromechanical)'),
(28, 'Engineering (Metal Fabrication/Tool & Die/Welding)'),
(29, 'Engineering (Mining/Mineral)'),
(30, 'Engineering (Others)'),
(31, 'Engineering (Petroleum/Oil/Gas)'),
(32, 'Finance/Accountancy/Banking'),
(33, 'Food & Beverages Services Management'),
(34, 'Food Technology/Nutrition/Dietetics'),
(35, 'Geographical Science'),
(36, 'Geology/Geophysics'),
(37, 'History'),
(38, 'Hospitality/Tourism/Hotel Management'),
(39, 'Human Resource Management'),
(40, 'Humanities/Liberal Arts'),
(41, 'Logistic/Transportation'),
(42, 'Law'),
(43, 'Library Management'),
(44, 'Linguistics/Languages'),
(45, 'Mass Communications'),
(46, 'Mathematics'),
(47, 'Medical Science'),
(48, 'Medicine'),
(49, 'Maritime Studies'),
(50, 'Marketing'),
(51, 'Music/Performing Art Studies'),
(52, 'Nursing'),
(53, 'Optometry'),
(54, 'Personal Services'),
(55, 'Pharmacy/Pharmacology'),
(56, 'Philosophy'),
(57, 'Physical Therapy/Physiotherapy'),
(58, 'Physics'),
(59, 'Political Science'),
(60, 'Property Development/Real Estate Management'),
(61, 'Protective Services & Management'),
(62, 'Psychology'),
(63, 'Quantity Survey'),
(64, 'Science & Technology'),
(65, 'Secreterial'),
(66, 'Social Science/Sociology'),
(67, 'Sport Science & Management'),
(68, 'Textile/Fashion Design'),
(69, 'Urban Studies/Town Planning'),
(70, 'Veterinary'),
(71, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `jp_grade_list`
--

CREATE TABLE IF NOT EXISTS `jp_grade_list` (
  `grade_id` int(3) NOT NULL AUTO_INCREMENT,
  `grade_name` varchar(60) NOT NULL,
  PRIMARY KEY (`grade_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `jp_grade_list`
--

INSERT INTO `jp_grade_list` (`grade_id`, `grade_name`) VALUES
(1, 'Grade A'),
(2, 'Grade B'),
(3, 'Grade C'),
(4, 'Grade D'),
(5, '1st Class'),
(6, '2nd Class Upper'),
(7, '2nd Class Lower'),
(8, '3rd Class'),
(9, 'CGPA/Percentage'),
(10, 'Pass/Non-gradable'),
(11, 'Fail'),
(12, 'Incomplete'),
(13, 'On-going');

-- --------------------------------------------------------

--
-- Table structure for table `jp_industry`
--

CREATE TABLE IF NOT EXISTS `jp_industry` (
  `indus_id` int(11) NOT NULL AUTO_INCREMENT,
  `indus_name` varchar(60) NOT NULL,
  `industry_parent` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`indus_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=126 ;

--
-- Dumping data for table `jp_industry`
--

INSERT INTO `jp_industry` (`indus_id`, `indus_name`, `industry_parent`) VALUES
(1, 'Accounting/Audit/Tax Services', 0),
(2, 'Advertising/Marketing/Promotion/PR', 0),
(3, 'Aerospace/Aviation/Airline', 0),
(4, 'Agricultural/Plantation/Poultry/Fisheries', 0),
(5, 'Apparel', 0),
(6, 'Architectural Services/Interior Designing', 0),
(7, 'Arts/Design/Fashion', 0),
(8, 'Automobile/Automotive Ancillary/Vehicle', 0),
(9, 'Banking/Financial Services', 0),
(10, 'Biotechnology/Pharmaceutical/Clinical Research', 0),
(11, 'Call Center/IT-Enabled Services/BPO', 0),
(12, 'Chemical/Fertilizers/Pesticides', 0),
(13, 'Computer/Information Technology (Hardware)', 0),
(14, 'Computer/Information Technology (Software)', 0),
(15, 'Construction/Building/Engineering', 0),
(16, 'Consulting (Business & Management)', 0),
(17, 'Consulting (IT, Science, Engineering & Technical)', 0),
(18, 'Consumer Products/FMCG', 0),
(19, 'Education', 0),
(20, 'Electrical & Electronics', 0),
(21, 'Entertainment/Media', 0),
(22, 'Environment/Health/Safety', 0),
(23, 'Exhibitions/Event Management/MICE', 0),
(24, 'Food & Beverage/Catering/Restaurant', 0),
(25, 'Gems/Jewellery', 0),
(26, 'General & Wholesale Trading', 0),
(27, 'Government/Defense', 0),
(28, 'Grooming/Beauty/Fitness', 0),
(29, 'Healthcare/Medical', 0),
(30, 'Heavy Industrial/Machinery/Equipment', 0),
(31, 'Hotel/Hospitality', 0),
(32, 'Human Resource Management/Consulting', 0),
(33, 'Insurance', 0),
(34, 'Journalism', 0),
(35, 'Law/Legal', 0),
(36, 'Library/Museum', 0),
(37, 'Manufacturing/Production', 0),
(38, 'Marine/Aquaculture', 0),
(39, 'Mining', 0),
(40, 'Non-Profit Organisation/Social Services/NGO', 0),
(41, 'Oil/Gas/Petroleum', 0),
(42, 'Polymer/Plastic/Rubber/Tyres', 0),
(43, 'Printing/Publishing', 0),
(44, 'Property/Real Estate', 0),
(45, 'R&D', 0),
(46, 'Repair & Maintenance Services', 0),
(47, 'Retail/Merchandise', 0),
(48, 'Science & Technology', 0),
(49, 'Security/Law Enforcement', 0),
(50, 'Semiconductor/Wafer Fabrication', 0),
(51, 'Sports', 0),
(52, 'Stockbroking/Securities', 0),
(53, 'Telecommunication', 0),
(54, 'Textiles/Garment', 0),
(55, 'Tobacco', 0),
(56, 'Transportation/Logistics', 0),
(57, 'Travel/Tourism', 0),
(58, 'Utilities/Power', 0),
(59, 'Wood/Fibre/Paper', 0),
(60, 'Others', 0),
(61, 'Actuarial Science/Statistics', 0),
(62, 'Advertising/Media Planning', 0),
(63, 'Agriculture/Forestry/Fisheries', 0),
(64, 'Architecture/Interior Design', 0),
(65, 'Arts/Creative/Graphics Design', 0),
(66, 'Aviation/Aircraft Management', 0),
(67, 'Banking/Financial Services', 0),
(68, 'Biotechnology', 0),
(69, 'Chemistry', 0),
(70, 'Clerical/Administrative Support', 0),
(71, 'Corporate Strategy/Top Management', 0),
(72, 'Customer Service', 0),
(73, 'Education', 0),
(74, 'Engineering (Chemical)', 0),
(75, 'Engineering (Civil/Construction/Structural)', 0),
(76, 'Engineering (Electrical)', 0),
(77, 'Engineering (Electronics/Communication)', 0),
(78, 'Engineering (Environmental/Health/Safety)', 0),
(79, 'Engineering (Industrial)', 0),
(80, 'Engineering (Mechanical/Automative)', 0),
(81, 'Engineering (Oil/Gas)', 0),
(82, 'Engineering (Others)', 0),
(83, 'Entertainment/Performing Arts', 0),
(84, 'Finance (Audit/Taxation)', 0),
(85, 'Finance (Corporate Finance/Investment/Merchant Banking', 0),
(86, 'Finance (General/Cost Accounting)', 0),
(87, 'Food Technology/Nutritionist', 0),
(88, 'Food/Beverage/Restaurant Service', 0),
(89, 'General Work (Housekeeper/Driver/Dispatch/Messenger/etc)', 0),
(90, 'Geology/Geophysics', 0),
(91, 'Healthcare (Doctor/Diagnosis)', 0),
(92, 'Healthcare (Nurse/Medical Support & Assistant)', 0),
(93, 'Healthcare (Pharmacy)', 0),
(94, 'Hotel Management/Tourism Services', 0),
(95, 'Human Resources', 0),
(96, 'IT/Computer (Hardware)', 0),
(97, 'IT/Computer (Network/System/Database Admin)', 0),
(98, 'IT/Computer (Software)', 0),
(99, 'Journalist/Editor', 0),
(100, 'Law/Legal Services', 0),
(101, 'Logistics/Supply Chain', 0),
(102, 'Maintenance/Repair (Facilities & Machinery)', 0),
(103, 'Manufacturing/Production Operations', 0),
(104, 'Marketing/Business Development', 0),
(105, 'Merchandising', 0),
(106, 'Personal Care/Beauty/Fitness Service', 0),
(107, 'Process Design & Control/Instrumentation', 0),
(108, 'Property/Real Estate', 0),
(109, 'Public Relations/Communications', 0),
(110, 'Publishing/Printing', 0),
(111, 'Purchasing/Inventory/Material & Warehouse Management', 0),
(112, 'Quality Control/Assurance', 0),
(113, 'Quantity Surveying', 0),
(114, 'Sales (Corporate)', 0),
(115, 'Sales (Engineering/Technical/IT)', 0),
(116, 'Sales (Financial Services-Insurance/Unit Trust/etc)', 0),
(117, 'Sales (Retail/General)', 0),
(118, 'Sales (Telesales/Telemarketing)', 0),
(119, 'Science & Technology/Laboratory', 0),
(120, 'Secretarial/Executive & Personal Assistant', 0),
(121, 'Security/Armed Forces/Protective Services', 0),
(122, 'Social & Counselling Services', 0),
(123, 'Technical & Helpdesk Support', 0),
(124, 'Training & Development', 0),
(125, 'Others', 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `jp_jobpreferences`
--

INSERT INTO `jp_jobpreferences` (`jobP_id`, `jobP_1`, `jobP_2`, `jobP_3`, `jobP_salary`, `user_id_fk`) VALUES
(1, 3, 1, NULL, 2000, 4),
(2, 1, 7, NULL, 2000, 12),
(3, 6, 6, NULL, 1500, 8),
(4, 3, 5, NULL, 2000, 5),
(5, 6, 7, NULL, 2000, 16);

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
  `jobseeker_pic` text,
  `jobseeker_last_edited` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`jobseeker_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `jp_jobseeker`
--

INSERT INTO `jp_jobseeker` (`jobseeker_id`, `users_id_fk`, `jobseeker_tel`, `jobseeker_mobile`, `jobseeker_address`, `jobseeker_dob_y`, `jobseeker_dob_m`, `jobseeker_dob_d`, `jobseeker_gender`, `jobseeker_nationality`, `jobseeker_moreinfo`, `jobseeker_pic`, `jobseeker_last_edited`) VALUES
(1, 4, '0323456789', '0123456789', 'Cheras', 1987, 9, 22, 2, 1, 'Additional info goes here', 'media/jobseeker/June-13-2012-10-40-am-20120612010631passport-copy_140_180.jpg', '2012-06-06 15:50:13'),
(2, 5, '0323456789', '0123456789', 'Bangsar', 1984, 1, 1, 2, 1, 'Additional info', 'media/jobseeker/default_jobseeker.png', '2012-06-06 15:54:05'),
(3, 8, '0345678912', '0123456789', 'Taman Saujana Jaya, Asam Kumbang\r\nTaiping, Perak Daruk Ridzuan', 1984, 10, 24, 2, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam neque est, ultrices et ultricies ut, mollis vel nunc. Sed et accumsan nisi. Duis suscipit commodo sem ac dapibus. Etiam at sem augue, accumsan dapibus sapien. Donec vitae metus nisl. Vivamus vulputate vestibulum tellus, nec vestibulum felis aliquet sed. Nulla facilisi. Pellentesque enim elit, tempor a vehicula vitae, molestie eget mi. In hac habitasse platea dictumst. Phasellus fringilla, sapien id pellentesque iaculis, augue neque egestas risus, vitae dictum nunc eros consequat nunc. Phasellus adipiscing, arcu ut laoreet consectetur, odio est ultricies erat, vel fermentum quam elit sed est. Donec gravida, massa ac venenatis adipiscing, mauris diam mollis massa, sagittis auctor enim orci vitae nulla. Nunc egestas augue ac lectus condimentum vel tincidunt elit varius.', 'media/jobseeker/default_jobseeker.png', NULL),
(4, 12, '0345678912', '0123456789', 'Pahang', 1978, 5, 19, 2, 1, 'More info', 'media/jobseeker/default_jobseeker.png', NULL),
(5, 15, '0327709988', '0123424796', '12a', 1979, 6, 12, 2, 127, 'aa', 'media/jobseeker/default_jobseeker.png', NULL),
(6, 16, '0345678912', '0123424796', 'adress', 1986, 2, 19, 2, 127, 'more info', 'media/jobseeker/default_jobseeker.png', NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `jp_language`
--

INSERT INTO `jp_language` (`lang_id`, `lang_name`, `lang_written`, `lang_spoken`, `user_id_fk`) VALUES
(1, 1, 5, 5, 4),
(2, 2, 10, 8, 4),
(3, 2, 10, 10, 12),
(4, 1, 10, 10, 8),
(5, 2, 10, 10, 8),
(6, 3, 10, 10, 16);

-- --------------------------------------------------------

--
-- Table structure for table `jp_language_list`
--

CREATE TABLE IF NOT EXISTS `jp_language_list` (
  `languList_id` int(3) NOT NULL AUTO_INCREMENT,
  `languList_name` varchar(60) NOT NULL,
  PRIMARY KEY (`languList_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `jp_language_list`
--

INSERT INTO `jp_language_list` (`languList_id`, `languList_name`) VALUES
(1, 'Arabic'),
(2, 'Bahasa Indonesia'),
(3, 'Bahasa Malaysia'),
(4, 'Bengali'),
(5, 'Chinese'),
(6, 'Dutch'),
(7, 'English'),
(8, 'Filipino'),
(9, 'French'),
(10, 'German'),
(11, 'Hindi'),
(12, 'Italian'),
(13, 'Japanese'),
(14, 'Korean'),
(15, 'Portuguese'),
(16, 'Russian'),
(17, 'Spanish'),
(18, 'Tamil'),
(19, 'Thai'),
(20, 'Vietnam'),
(21, 'Others');

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
(5, 'Fresh/Entry Level'),
(6, 'Non-Executive');

-- --------------------------------------------------------

--
-- Table structure for table `jp_location`
--

CREATE TABLE IF NOT EXISTS `jp_location` (
  `location_id` int(11) NOT NULL AUTO_INCREMENT,
  `location_name` varchar(30) NOT NULL,
  `location_parent` int(3) DEFAULT '0',
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=313 ;

--
-- Dumping data for table `jp_location`
--

INSERT INTO `jp_location` (`location_id`, `location_name`, `location_parent`) VALUES
(1, 'Perlis', 0),
(2, 'Kedah', 0),
(3, 'Penang', 0),
(4, 'Perak', 0),
(5, 'Selangor', 0),
(6, 'Kuala Lumpur', 0),
(7, 'Negeri Sembilan', 0),
(8, 'Malacca', 0),
(9, 'Johor', 0),
(10, 'Pahang', 0),
(11, 'Terengganu', 0),
(12, 'Kelantan', 0),
(13, 'Sabah', 0),
(14, 'Sarawak', 0),
(15, 'Arau', 1),
(16, 'Kangar', 1),
(17, 'Padang Besar', 1),
(18, 'Baling', 2),
(19, 'Bandar Baharu', 2),
(20, 'Kota Setar', 2),
(21, 'Kuala Muda', 2),
(22, 'Kuala Pegang', 2),
(23, 'Kubang Pasu', 2),
(24, 'Kulim', 2),
(25, 'Langkawi', 2),
(26, 'Padang Terap', 2),
(27, 'Pendang', 2),
(28, 'Pokok Sena', 2),
(29, 'Sik', 2),
(30, 'Yan', 2),
(31, 'Air Itam', 3),
(32, 'Bagan Jermal', 3),
(33, 'Balik Pulau', 3),
(34, 'Bandar Baru Air Itam', 3),
(35, 'Batu Feringgi', 3),
(36, 'Batu Maung', 3),
(37, 'Batu Lanchang', 3),
(38, 'Bayan Baru', 3),
(39, 'Bayan Lepas', 3),
(40, 'Gelugor', 3),
(41, 'George Town', 3),
(42, 'Gertak Sanggul', 3),
(43, 'Green Lane', 3),
(44, 'Gurney Drive', 3),
(45, 'Tanjung Tokong', 3),
(46, 'Jelutong', 3),
(47, 'Mount Erskine', 3),
(48, 'Pantai Acheh', 3),
(49, 'Paya Terubong', 3),
(50, 'Pulau Tikus', 3),
(51, 'Pulau Betong', 3),
(52, 'Relau', 3),
(53, 'Sungai Ara', 3),
(54, 'Sungai Dua', 3),
(55, 'Sungai Nibong', 3),
(56, 'Sungai Pinang', 3),
(57, 'Tanjung Bungah', 3),
(58, 'Tanjung Tokong', 3),
(59, 'Teluk Bahang', 3),
(60, 'Teluk Kumbar', 3),
(61, 'Alma', 3),
(62, 'Bagan Ajam', 3),
(63, 'Bagan Luar', 3),
(64, 'Batu Kawan', 3),
(65, 'Bukit Mertajam', 3),
(66, 'Bukit Minyak', 3),
(67, 'Bukit Tambun', 3),
(68, 'Butterworth', 3),
(69, 'Ceruk Tok Kun', 3),
(70, 'Jawi', 3),
(71, 'Juru', 3),
(72, 'Kepala Batas', 3),
(73, 'Mak Mandin', 3),
(74, 'Nibong Tebal', 3),
(75, 'Permatang Pauh', 3),
(76, 'Perai', 3),
(77, 'Seberang Jaya', 3),
(78, 'Simpang Ampat', 3),
(79, 'Sungai Bakap', 3),
(80, 'Bukit Tambun', 3),
(81, 'Penaga', 3),
(82, 'Permatang Tinggi', 3),
(83, 'Alor Pongsu', 4),
(84, 'Ayer Tawar', 4),
(85, 'Bagan Datoh', 4),
(86, 'Bagan Serai', 4),
(87, 'Bagan Sungai Burong', 4),
(88, 'Banir', 4),
(89, 'Batak Rabit', 4),
(90, 'Batu Gajah', 4),
(91, 'Behrang', 4),
(92, 'Bercham', 4),
(93, 'Beruas', 4),
(94, 'Bidor', 4),
(95, 'Bikam', 4),
(96, 'Bota', 4),
(97, 'Bukit Gantang', 4),
(98, 'Bukit Merah', 4),
(99, 'Changkat Jering', 4),
(100, 'Changkat Keruing', 4),
(101, 'Chemor', 4),
(102, 'Chenderiang', 4),
(103, 'Chenderong Balai', 4),
(104, 'Chikus', 4),
(105, 'Damar Laut', 4),
(106, 'Gerik', 4),
(107, 'Gopeng', 4),
(108, 'Gua Tempurung', 4),
(109, 'Hutan Melintang', 4),
(110, 'Jelapang', 4),
(111, 'Jenderata', 4),
(112, 'Jerlun', 4),
(113, 'Kamunting', 4),
(114, 'Kampar', 4),
(115, 'Kampung Gajah', 4),
(116, 'Karai', 4),
(117, 'Kota Baharu', 4),
(118, 'Kota Setia', 4),
(119, 'Kuala Kangsar', 4),
(120, 'Kuala Kurau', 4),
(121, 'Kuala Sepetang', 4),
(122, 'Langkap', 4),
(123, 'Lekir', 4),
(124, 'Lenggong', 4),
(125, 'Lumut', 4),
(126, 'Manjoi', 4),
(127, 'Malim Nawar', 4),
(128, 'Mambang Di Awan', 4),
(129, 'Manong', 4),
(130, 'Menglembu', 4),
(131, 'Padang Rengas', 4),
(132, 'Pantai Remis', 4),
(133, 'Parit', 4),
(134, 'Parit Buntar', 4),
(135, 'Pasir Salak', 4),
(136, 'Pekan Gurney', 4),
(137, 'Pengkalan Hulu (Kroh)', 4),
(138, 'Proton City', 4),
(139, 'Selama', 4),
(140, 'Semanggol', 4),
(141, 'Seri Iskandar', 4),
(142, 'Seri Manjung', 4),
(143, 'Simpang Tiga', 4),
(144, 'Sitiawan', 4),
(145, 'Slim', 4),
(146, 'Slim River', 4),
(147, 'Sungai Siput', 4),
(148, 'Sungkai', 4),
(149, 'Taiping', 4),
(150, 'Tambun', 4),
(151, 'Tanjung Belanja', 4),
(152, 'Tanjung Malim', 4),
(153, 'Tanjung Piandang', 4),
(154, 'Tanjung Rambutan', 4),
(155, 'Tanjung Tualang', 4),
(156, 'Tapah', 4),
(157, 'Tapah Road', 4),
(158, 'Teluk Batik', 4),
(159, 'Teluk Intan', 4),
(160, 'Teluk Rubiah', 4),
(161, 'Temoh', 4),
(162, 'Temoh Station', 4),
(163, 'Trolak', 4),
(164, 'Terong', 4),
(165, 'Teronoh', 4),
(166, 'Ulu Bernam', 4),
(167, 'Pulau Pangkor', 4),
(172, 'Kuang', 5),
(173, 'Rawang', 5),
(174, 'Taman Templer', 5),
(175, 'Batu Caves', 5),
(176, 'Gombak Setia', 5),
(177, 'Hulu Kelang', 5),
(178, 'Bukit Antarabangsa', 5),
(179, 'Lembah Jaya', 5),
(180, 'Paya Jaras', 5),
(181, 'Selayang', 5),
(182, 'Gombak', 5),
(183, 'Ampang', 5),
(184, 'Subang', 5),
(185, 'Pandan', 5),
(186, 'Hulu Langat', 5),
(187, 'Serdang', 5),
(188, 'Lembah Jaya', 5),
(189, 'Chempaka', 5),
(190, 'Teratai', 5),
(191, 'Dusun Tua', 5),
(192, 'Semenyih', 5),
(193, 'Kajang', 5),
(194, 'Bangi', 5),
(195, 'Balakong', 5),
(196, 'Hulu Selangor', 5),
(197, 'Klang', 5),
(198, 'Kuala Langat', 5),
(199, 'Sepang', 5),
(200, 'Sijangkang', 5),
(201, 'Teluk Datuk', 5),
(202, 'Morib', 5),
(203, 'Tanjong Sepat', 5),
(204, 'Dengkil', 5),
(205, 'Tanjong Karang', 5),
(206, 'Kuala Selangor', 5),
(207, 'Sungai Burong', 5),
(208, 'Permatang', 5),
(209, 'Bukit Melawati', 5),
(210, 'Ijok', 5),
(211, 'Jeram', 5),
(212, 'Sabak Bernam', 5),
(213, 'Sungai Besar', 5),
(214, 'Sungai Air Tawar', 5),
(215, 'Sabak', 5),
(216, 'Sungai Panjang', 5),
(217, 'Sekinchan', 5),
(218, 'Tanjung Sepat', 5),
(219, 'Sungai Pelek', 5),
(221, 'Kuala Lumpur', 6),
(222, 'Labuan', 6),
(223, 'Putrajaya', 6),
(224, 'Seremban', 7),
(225, 'Rasah', 7),
(226, 'Rasah Jaya', 7),
(227, 'Rahang', 7),
(228, 'Mambau', 7),
(229, 'Senawang', 7),
(230, 'Temiang', 7),
(231, 'Lobak', 7),
(232, 'Paroi', 7),
(233, 'Bukit Chedang', 7),
(234, 'Bukit Blossom', 7),
(235, 'Seremban 2', 7),
(236, 'Ampangan', 7),
(237, 'Oakland', 7),
(238, 'Bukit Kapayang', 7),
(239, 'Kemayan', 7),
(240, 'Sikamat', 7),
(241, 'Nilai', 7),
(242, 'Bandar Baru Nilai', 7),
(243, 'Rantau', 7),
(244, 'Mantin', 7),
(245, 'Sungai Gadut', 7),
(246, 'Labu', 7),
(247, 'Lenggeng', 7),
(248, 'Taman Seremban Jaya', 7),
(249, 'Bandar Seremban Selatan', 7),
(250, 'Taman Tuanku Jaafar', 7),
(251, 'Rasah Kemayan', 7),
(252, 'Pantai', 7),
(253, 'Pantai', 7),
(254, 'Ulu Beranang', 7),
(255, 'Pajam', 7),
(256, 'Port Dickson', 7),
(257, 'Rembau', 7),
(258, 'Jelebu', 7),
(259, 'Kuala Pilah', 7),
(260, 'Jempol', 7),
(261, 'Tampin', 7),
(262, 'Central Malacca', 8),
(263, 'Alor Gajah', 8),
(264, 'Jasin', 8),
(265, 'Johor Bahru', 9),
(266, 'Batu Pahat', 9),
(267, 'Rengit', 9),
(268, 'Yong Peng', 9),
(269, 'Semerah', 9),
(270, 'Parit Sulong', 9),
(271, 'Sri Gading', 9),
(272, 'Parit Raja', 9),
(273, 'Ayer Hitam', 9),
(274, 'Senggarang', 9),
(275, 'Tongkang Pechah', 9),
(276, 'Muar', 9),
(277, 'Pagoh', 9),
(278, 'Parit Jawa', 9),
(279, 'Sungai Balang', 9),
(280, 'Bukit Kepong', 9),
(281, 'Bukit Pasir', 9),
(282, 'Panchor', 9),
(283, 'Lenga', 9),
(284, 'Kluang', 9),
(285, 'Kota Tinggi', 9),
(286, 'Segamat', 9),
(287, 'Bandar Putra', 9),
(288, 'Labis', 9),
(289, 'Jementah', 9),
(290, 'Buloh Kasap', 9),
(291, 'Chaah', 9),
(292, 'Bekok', 9),
(293, 'Batu Anam', 9),
(294, 'Pogoh', 9),
(295, 'Pekan Air Panas', 9),
(296, 'Gemas Baharu', 9),
(297, 'Sungai Karas', 9),
(298, 'Kampung Tengah', 9),
(299, 'Pontian', 9),
(300, 'Mersing', 9),
(301, 'Kulaijaya', 9),
(302, 'Kulai', 9),
(303, 'Ayer Bemban', 9),
(304, 'Bukit Batu', 9),
(305, 'Kangkar Pulai', 9),
(306, 'Kelapa Sawit', 9),
(307, 'Saleng', 9),
(308, 'Sedenak', 9),
(309, 'Seelong', 9),
(310, 'Senai', 9),
(311, 'Ledang', 9),
(312, 'Ipoh', 4);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=240 ;

--
-- Dumping data for table `jp_nationality`
--

INSERT INTO `jp_nationality` (`national_id`, `national_name`) VALUES
(1, 'Afghanistan'),
(2, 'Albania'),
(3, 'Algeria'),
(4, 'American Samoa'),
(5, 'Andorra'),
(6, 'Angola'),
(7, 'Anguilla'),
(8, 'Antarctica'),
(9, 'Antigua and Barbuda'),
(10, 'Argentina'),
(11, 'Armenia'),
(12, 'Aruba'),
(13, 'Australia'),
(14, 'Austria'),
(15, 'Azerbaijan'),
(16, 'Bahamas'),
(17, 'Bahrain'),
(18, 'Bangladesh'),
(19, 'Barbados'),
(20, 'Belarus'),
(21, 'Belgium'),
(22, 'Belize'),
(23, 'Benin'),
(24, 'Bermuda'),
(25, 'Bhutan'),
(26, 'Bolivia'),
(27, 'Bosnia Herzegovina'),
(28, 'Botswana'),
(29, 'Bouvet Island'),
(30, 'Brazil'),
(31, 'British Indian Ocean Territory'),
(32, 'Brunei Darussalam'),
(33, 'Bulgaria'),
(34, 'Burkina Faso'),
(35, 'Burundi'),
(36, 'Cambodia'),
(37, 'Cameroon'),
(38, 'Canada'),
(39, 'Cape Verde'),
(40, 'Cayman Islands'),
(41, 'Central African Republic'),
(42, 'Chad'),
(43, 'Chile'),
(44, 'China'),
(45, 'Christmas Island'),
(46, 'Cocos (Keeling) Islands'),
(47, 'Colombia'),
(48, 'Comoros'),
(49, 'Congo'),
(50, 'Cook Islands'),
(51, 'Costa Rica'),
(52, 'Cote D''ivoire'),
(53, 'Croatia'),
(54, 'Cuba'),
(55, 'Cyprus'),
(56, 'Czech Republic'),
(57, 'Denmark'),
(58, 'Djibouti'),
(59, 'Dominica'),
(60, 'Dominican Republic'),
(61, 'East Timor'),
(62, 'Ecuador'),
(63, 'Egypt'),
(64, 'El Savador'),
(65, 'Equatorial Guinea'),
(66, 'Eritrea'),
(67, 'Estonia'),
(68, 'Ethiopia'),
(69, 'Falkland Islands (Malvinas)'),
(70, 'Faroe Islands'),
(71, 'Fiji'),
(72, 'Finland'),
(73, 'France'),
(74, 'French Guiana'),
(75, 'French Polynesia'),
(76, 'French Southern Territories'),
(77, 'Gabon'),
(78, 'Gambia'),
(79, 'Georgia'),
(80, 'Germany'),
(81, 'Ghana'),
(82, 'Gibraltar'),
(83, 'Greece'),
(84, 'Greenland'),
(85, 'Grenada'),
(86, 'Guadeloupe'),
(87, 'Guam'),
(88, 'Guatemala'),
(89, 'Guinea'),
(90, 'Guinea-Bissau'),
(91, 'Guyana'),
(92, 'Haiti'),
(93, 'Heard and Mc Donald Islands'),
(94, 'Honduras'),
(95, 'Hong Kong'),
(96, 'Hungary'),
(97, 'Iceland'),
(98, 'India'),
(99, 'Indonesia'),
(100, 'Iran'),
(101, 'Iraq'),
(102, 'Ireland'),
(103, 'Italy'),
(104, 'Jamaica'),
(105, 'Japan'),
(106, 'Jordan'),
(107, 'Kazakhstan'),
(108, 'Kenya'),
(109, 'Kiribati'),
(110, 'Korea (North)'),
(111, 'Korea (South)'),
(112, 'Kuwait'),
(113, 'Kyrgyzstan'),
(114, 'Laos'),
(115, 'Latvia'),
(116, 'Lebanon'),
(117, 'Lesotho'),
(118, 'Liberia'),
(119, 'Libyan Arab Jamahiriya'),
(120, 'Liechtenstein'),
(121, 'Lithuania'),
(122, 'Luxembourg'),
(123, 'Macau'),
(124, 'Macedonia'),
(125, 'Madagascar'),
(126, 'Malawi'),
(127, 'Malaysia'),
(128, 'Maldives'),
(129, 'Mali'),
(130, 'Malta'),
(131, 'Marshall Islands'),
(132, 'Martinique'),
(133, 'Mauritania'),
(134, 'Mauritius'),
(135, 'Mayotte'),
(136, 'Mexico'),
(137, 'Micronesia'),
(138, 'Monaco'),
(139, 'Mongolia'),
(140, 'Montserrat'),
(141, 'Morocco'),
(142, 'Mozambique'),
(143, 'Myanmar'),
(144, 'Nambia'),
(145, 'Nauru'),
(146, 'Nepal'),
(147, 'Netherlands'),
(148, 'Netherlands Antilles'),
(149, 'New Caledonia'),
(150, 'New Zealand'),
(151, 'Nicaragua'),
(152, 'Niger'),
(153, 'Nigeria'),
(154, 'Niue'),
(155, 'Norfolk Island'),
(156, 'Northern Mariana Islands'),
(157, 'Norway'),
(158, 'Oman'),
(159, 'Others'),
(160, 'Pakistan'),
(161, 'Palau'),
(162, 'Palestinian Territory'),
(163, 'Panama'),
(164, 'Papua New Guinea'),
(165, 'Paraguay'),
(166, 'Peru'),
(167, 'Philippines'),
(168, 'Pitcairn'),
(169, 'Poland'),
(170, 'Portugal'),
(171, 'Puerto Rico'),
(172, 'Qatar'),
(173, 'Republic Of Moldova'),
(174, 'Reunion'),
(175, 'Romania'),
(176, 'Russia'),
(177, 'Rwanda'),
(178, 'Saint Kitts And Nevis'),
(179, 'Saint Lucia'),
(180, 'Saint Vincent And The Grenadines'),
(181, 'Samoa'),
(182, 'San Marino'),
(183, 'Sao Tome And Principe'),
(184, 'Saudi Arabia'),
(185, 'Senegal'),
(186, 'Seychelles'),
(187, 'Sierra Leone'),
(188, 'Singapore'),
(189, 'Slovakia'),
(190, 'Slovenia'),
(191, 'Solomon Islands'),
(192, 'Somalia'),
(193, 'South Africa'),
(194, 'South Georgia And South Sandwich Islands'),
(195, 'Spain'),
(196, 'Sri Lanka'),
(197, 'St. Helena'),
(198, 'St. Pierre And Miquelon'),
(199, 'Sudan'),
(200, 'Suriname'),
(201, 'Svalbard And Jan Mayen Islands'),
(202, 'Swaziland'),
(203, 'Sweden'),
(204, 'Switzerland'),
(205, 'Syrian Arab Republic'),
(206, 'Taiwan'),
(207, 'Tajikistan'),
(208, 'Tanzania'),
(209, 'Thailand'),
(210, 'TOGO'),
(211, 'Tokelau'),
(212, 'Tonga'),
(213, 'Trinidad And Tobago'),
(214, 'Tunisia'),
(215, 'Turkey'),
(216, 'Turkmenistan'),
(217, 'Turks And Caicos Islands'),
(218, 'Tuvalu'),
(219, 'Uganda'),
(220, 'Ukraine'),
(221, 'United Arab Emirates'),
(222, 'United Kingdom'),
(223, 'United States'),
(224, 'United States Minor Outlying Islands'),
(225, 'Uruguay'),
(226, 'Uzbekistan'),
(227, 'Vanuatu'),
(228, 'Vatican City State'),
(229, 'Venezuela'),
(230, 'Vietnam'),
(231, 'Virgin Islands (British)'),
(232, 'Virgin Islands (U.S.)'),
(233, 'Wallis And Futuna Islands'),
(234, 'Western Sahara'),
(235, 'Yemen'),
(236, 'Yugoslavia'),
(237, 'Zaire'),
(238, 'Zambia'),
(239, 'Zimbabwe');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `jp_references`
--

INSERT INTO `jp_references` (`ref_id`, `ref_name`, `ref_relationship`, `ref_email`, `ref_phone`, `ref_pos_title`, `ref_comp_name`, `user_id_fk`) VALUES
(1, 'Mansor Selamat', 'Friend', 'mansor@yahoo.com', '0123456789', 'CEO', 'Terabyte Technologies Sdn Bhd', 4),
(2, 'Mansor Selamat', 'Friend', 'mansor@yahoo.com', '60132465974', 'CEO', 'Terabyte Technologies Sdn Bhd', 12),
(3, 'Mansor Selamat', '0', 'mansor@yahoo.com', '60132465974', 'CEO', 'Terabyte Technologies Sdn Bhd', 8),
(4, 'Mansor Selamat', '0', 'mansor@yahoo.com', '0123456789', 'CEO', 'Terabyte Technologies Sdn Bhd', 16);

-- --------------------------------------------------------

--
-- Table structure for table `jp_resume`
--

CREATE TABLE IF NOT EXISTS `jp_resume` (
  `resume_id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id_fk` int(11) NOT NULL,
  `resume_title` varchar(30) NOT NULL,
  `resume_type` varchar(20) DEFAULT NULL,
  `resume_featured` int(1) DEFAULT '0',
  `resume_path` text NOT NULL,
  `resume_upload_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`resume_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `jp_resume`
--

INSERT INTO `jp_resume` (`resume_id`, `users_id_fk`, `resume_title`, `resume_type`, `resume_featured`, `resume_path`, `resume_upload_on`) VALUES
(6, 8, 'My Resume Test', 'text/plain', NULL, 'June-12-2012-12-32-pm-muhamad-mahfudz-resume.txt', '2012-06-12 10:32:44'),
(7, 5, 'Alan Resume', 'application/pdf', NULL, 'June-12-2012-12-36-pm-alanmacho-Resume.pdf', '2012-06-12 10:36:22'),
(8, 4, 'Fofo Design Resume', 'application/vnd.open', NULL, 'June-12-2012-12-37-pm-Mahfudz-Resume.docx', '2012-06-12 10:37:09'),
(9, 15, 'my resume', 'application/octet-st', NULL, 'June-12-2012-2-30-pm-rcm_jobsperak.sql', '2012-06-12 12:30:45'),
(10, 16, 'My Resume', 'application/pdf', NULL, 'June-12-2012-4-54-pm-Pay-TNB-Bills.pdf', '2012-06-12 14:54:17');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `jp_skills`
--

INSERT INTO `jp_skills` (`skills_id`, `skills_name`, `skills_y_exp`, `skills_proficiency`, `user_id_fk`) VALUES
(1, 'Web Design', 4, 10, 4),
(2, 'Programming', 2, 9, 4),
(3, 'PHP', 5, 9, 4),
(4, 'Programming', 4, 10, 12),
(5, 'Programming', 4, 10, 8),
(6, 'Web Design', 5, 10, 8),
(7, 'Programming', 4, 10, 16);

-- --------------------------------------------------------

--
-- Table structure for table `jp_specialize`
--

CREATE TABLE IF NOT EXISTS `jp_specialize` (
  `specialize_id` int(11) NOT NULL AUTO_INCREMENT,
  `specialize_name` varchar(60) NOT NULL,
  PRIMARY KEY (`specialize_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=66 ;

--
-- Dumping data for table `jp_specialize`
--

INSERT INTO `jp_specialize` (`specialize_id`, `specialize_name`) VALUES
(1, 'Actuarial Science/Statistics'),
(2, 'Advertising/Media Planning'),
(3, 'Agriculture/Forestry/Fisheries'),
(4, 'Architecture/Interior Design'),
(5, 'Arts/Creative/Graphics Design'),
(6, 'Aviation/Aircraft Maintenance'),
(7, 'Banking/Financial Services'),
(8, 'Biotechnology'),
(9, 'Chemistry'),
(10, 'Clerical/Administrative Support'),
(11, 'Corporate Strategy/Top Management'),
(12, 'Customer Service'),
(13, 'Education'),
(14, 'Engineering (Chemical)'),
(15, 'Engineering (Civil/Construction/Structural)'),
(16, 'Engineering (Electrical)'),
(17, 'Engineering (Electronics/Communication)'),
(18, 'Engineering (Environmental/Health/Safety)'),
(19, 'Engineering (Industrial)'),
(20, 'Engineering (Mechanical/Automotive)'),
(21, 'Engineering (Oil/Gas)'),
(22, 'Engineering (Others)'),
(23, 'Entertainment/Performing Arts'),
(24, 'Finance (Audit/Taxation)'),
(25, 'Finance (Corporate Finance/Investment/Merchant Banking)'),
(26, 'Finance (General/Cost Accounting)'),
(27, 'Food Technology/Nutritionist'),
(28, 'Food/Beverage/Restaurant Service'),
(29, 'General Work (Housekeeper/Driver/Dispatch/etc)'),
(30, 'Geology/Geophysics'),
(31, 'Healthcare (Doctor/Diagnosis)'),
(32, 'Healthcare (Nurse/Medical Support & Assistant)'),
(33, 'Healthcare (Pharmacy)'),
(34, 'Hotel Management/Tourism Services'),
(35, 'Human Resources'),
(36, 'IT/Computer (Hardware)'),
(37, 'IT/Computer (Network/System/Database Admin)'),
(38, 'IT/Computer (Software)'),
(39, 'Journalist/Editor'),
(40, 'Law/Legal Services'),
(41, 'Logistics/Supply Chain'),
(42, 'Maintenance/Repair (Facilities & Machinery)'),
(43, 'Manufacturing/Production Operations'),
(44, 'Marketing/Business Development'),
(45, 'Merchandising'),
(46, 'Personal Care/Beauty/Fitness Service'),
(47, 'Process Design & Control/Instrumentation'),
(48, 'Property/Real Estate'),
(49, 'Public Relations/Communications'),
(50, 'Publishing/Printing'),
(51, 'Purchasing/Inventory/Material & Warehouse Management'),
(52, 'Quality Control/Assurance'),
(53, 'Quality Surveying'),
(54, 'Sales (Corporate)'),
(55, 'Sales (Engineering/Technical/IT)'),
(56, 'Sales (Financial Services-Insurance/Unit Trust/etc)'),
(57, 'Sales (Retail/General)'),
(58, 'Sales (Telesales/Telemarketing)'),
(59, 'Science & Technology/Laboratory'),
(60, 'Secretarial/Executive & Personal Assistant'),
(61, 'Security/Armed Forces/Protective Services'),
(62, 'Social & Counseling Service'),
(63, 'Technical & Helpdesk Support'),
(64, 'Training & Development'),
(65, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `jp_spm`
--

CREATE TABLE IF NOT EXISTS `jp_spm` (
  `spm_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id_fk` int(11) NOT NULL,
  `spm_subject_id_fk` int(11) NOT NULL,
  `spm_grade` varchar(11) NOT NULL,
  PRIMARY KEY (`spm_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `jp_spm`
--

INSERT INTO `jp_spm` (`spm_id`, `user_id_fk`, `spm_subject_id_fk`, `spm_grade`) VALUES
(1, 4, 1, 'B+'),
(2, 4, 2, 'A'),
(3, 4, 3, 'B+'),
(4, 4, 19, 'G'),
(5, 4, 76, 'A+'),
(6, 4, 60, 'A+'),
(7, 8, 1, 'A+'),
(8, 8, 2, 'B+'),
(9, 8, 7, 'B+'),
(10, 16, 3, 'A+'),
(11, 16, 1, 'B+'),
(12, 18, 1, 'A+');

-- --------------------------------------------------------

--
-- Table structure for table `jp_spm_subject`
--

CREATE TABLE IF NOT EXISTS `jp_spm_subject` (
  `subject_id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_name` varchar(100) NOT NULL,
  PRIMARY KEY (`subject_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=118 ;

--
-- Dumping data for table `jp_spm_subject`
--

INSERT INTO `jp_spm_subject` (`subject_id`, `subject_name`) VALUES
(1, 'Bahasa Melayu'),
(2, 'Bahasa Inggeris'),
(3, 'Pendidikan Islam'),
(4, 'Pendidikan Moral'),
(5, 'Sejarah'),
(6, 'Mathematics'),
(7, 'Science'),
(8, 'Pendidikan Seni Visual'),
(9, 'Pendidikan Muzik'),
(10, 'Pengetahuan Sains Sukan'),
(11, 'Information and Communications Technology'),
(12, 'Fundamentals of Programming'),
(13, 'Programming and Development Tools'),
(14, 'Aplikasi Komputer Dalam Perniagaan'),
(15, 'Teknologi Pejabat Perniagaan'),
(16, 'Literature in English'),
(17, 'Kesusasteraan Melayu'),
(18, 'Bahasa Arab Tinggi'),
(19, 'Bahasa Cina'),
(20, 'Bahasa Tamil'),
(21, 'English for Science and Technology'),
(22, 'Bahasa Iban'),
(23, 'Bahasa Arab Komunikasi'),
(24, 'Kesusasteraan Cina'),
(25, 'Kesusasteraan Tamil'),
(26, 'Bahasa Perancis'),
(27, 'Bahasa Punjabi'),
(28, 'Sains Pertanian'),
(29, 'Pengajian Agroteknologi'),
(30, 'Ekonomi Rumah Tangga'),
(31, 'Engineering Drawing'),
(32, 'Pengajian Kejuruteraan Mekanikal'),
(33, 'Pengajian Kejuruteraan Awam'),
(34, 'Pengajian Kejuruteraan Elektrik dan Elektronik'),
(35, 'Rekacipta'),
(36, 'Engineering Technology'),
(37, 'Pengurusan Makanan'),
(38, 'Pola Pakaian'),
(39, 'Pembinaan Domestik'),
(40, 'Membuat Perabot'),
(41, 'Kerja Paip Domestik'),
(42, 'Pendawaian Domestik'),
(43, 'Kimpalan Arka dan Gas'),
(44, 'Menservis Automobil'),
(45, 'Menservis Motosikal'),
(46, 'Menservis Peralatan Penyejukan dan Penyaman Udara'),
(47, 'Menservis Peralatan Elektrik Domestik'),
(48, 'Rekaan dan Jahitan Pakaian'),
(49, 'Katering dan Penyajian'),
(50, 'Pemprosesan Makanan'),
(51, 'Penjagaan Muka dan Dandanan Rambut'),
(52, 'Asuhan dan Pendidikan Awal Kanak-Kanak'),
(53, 'Gerontologi Asas dan Perkhidmatan Geriatrik'),
(54, 'Landskap dan Nurseri'),
(55, 'Akuakultur dan Haiwan Rekreasi'),
(56, 'Tanaman Makanan'),
(57, 'Seni Reka Tanda'),
(58, 'Hiasan Dalaman Asas'),
(59, 'Produksi Multimedia'),
(60, 'Grafik Berkomputer'),
(61, 'Membuat Pakaian'),
(62, 'Menservis TV'),
(63, 'Roti dan Masakan Yis'),
(64, 'Patisserie'),
(65, 'Persolekan'),
(66, 'Dandanan Rambut'),
(67, 'Pengajian Perkembangan Kanak-Kanak'),
(68, 'Perkhidmatan Awal Kanak-Kanak'),
(69, 'Penyediaan Masakan Barat dan Timur'),
(70, 'Penyajian Makanan dan Minuman'),
(71, 'Teknologi Bengkel Mesin'),
(72, 'Kerja Menggegas'),
(73, 'Kerja Melarik'),
(74, 'Lukisan Geometri dan Mesin'),
(75, 'Teknologi Binaan Bangunan'),
(76, 'Kerja Kayu'),
(77, 'Kerja Bata'),
(78, 'Lukisan Geometri dan Pembinaan Bangunan'),
(79, 'Teknologi Elektrik'),
(80, 'Pemasangan Elektrik'),
(81, 'Kawalan Elektrik'),
(82, 'Lukisan Geometri dan Elektrik'),
(83, 'Teknologi Elektronik'),
(84, 'Menservis Radio'),
(85, 'Lukisan Geometri dan Elektronik'),
(86, 'Teknologi Kimpalan dan Fabrikasi Logam'),
(87, 'Kerja Kimpalan Arka'),
(88, 'Kerja Kimpalan Gas'),
(89, 'Lukisan Geometri dan Fabrikasi Logam'),
(90, 'Teknologi Automotif'),
(91, 'Auto Asas'),
(92, 'Kerja Elektrik dan Diesel'),
(93, 'Lukisan Geometri dan Automotif'),
(94, 'Teknologi Penyejukan dan Penyaman Udara'),
(95, 'Memasang dan Menservis Penyejuk dan Penyaman Udara'),
(96, 'Lukisan Geometri dan Penyaman Udara'),
(97, 'Pengeluaran Tanaman'),
(98, 'Pengeluaran Ternakan'),
(99, 'Hortikultur Hiasan dan Landskap'),
(100, 'Kejenteraan Ladang'),
(101, 'Kejenteraan Ladang'),
(102, 'Additional Mathematics'),
(103, 'Physics'),
(104, 'Chemistry'),
(105, 'Biology'),
(106, 'Additional Science'),
(107, 'Applied Science'),
(108, 'Geografi'),
(109, 'Pengajian Keusahawanan'),
(110, 'Perdagangan'),
(111, 'Prinsip Perakaunan'),
(112, 'Ekonomi Asas'),
(113, 'Tasawwur Islam'),
(114, 'Pendidikan Al-Quran dan As-Sunnah'),
(115, 'Pendidikan Syariah Islamiah'),
(116, 'Perakaunan Perniagaan'),
(117, 'Bible Knowledge');

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
  `user_active` int(1) DEFAULT '1',
  PRIMARY KEY (`users_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

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
(9, 'satredone@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2012-06-07 23:28:14', '2012-06-07 15:28:14', 'Sastred', 'One', 2, 1),
(10, 'yus@yus.com.my', '5f4dcc3b5aa765d61d8327deb882cf99', '2012-06-07 23:29:42', '2012-06-07 15:29:42', 'Y', 'Us', 2, 0),
(11, 'pj@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2012-06-09 20:45:28', '2012-06-09 12:45:28', 'Fakhrul Hafiz', 'Mohamad', 1, 1),
(12, 'ahmad@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2012-06-10 15:29:36', '2012-06-10 07:29:36', 'Muhamad Ahmad', 'Ramli', 1, 1),
(13, 'munir@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2012-06-12 18:45:31', '2012-06-12 10:45:31', 'ahmad', 'munir', 1, 1),
(14, 'dz@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2012-06-12 18:54:42', '2012-06-12 10:54:42', 'mohd', 'dz', 1, 1),
(15, 'dzairilimran@gmail.com', '3a43dde3ec60e7af8aadbd048cb5b535', '2012-06-12 20:24:46', '2012-06-12 12:24:46', 'Dzairil', 'Imran', 1, 1),
(16, 'user01@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2012-06-12 22:52:43', '2012-06-12 14:52:43', 'mr', 'user', 1, 1),
(17, 'user02@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2012-06-12 23:09:18', '2012-06-12 15:09:18', 'mohd', 'user02', 1, 1),
(18, 'user03@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', '2012-06-15 15:44:34', '2012-06-15 07:44:34', 'Muhamad', 'Ahmad', 1, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
