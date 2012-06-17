-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 25, 2012 at 12:56 PM
-- Server version: 5.0.95
-- PHP Version: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `richcore_sb`
--

-- --------------------------------------------------------

--
-- Table structure for table `mj_area`
--

CREATE TABLE IF NOT EXISTS `mj_area` (
  `area_id` int(10) NOT NULL auto_increment,
  `area_name` varchar(30) NOT NULL,
  PRIMARY KEY  (`area_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mj_com_info`
--

CREATE TABLE IF NOT EXISTS `mj_com_info` (
  `ci_id` int(10) NOT NULL auto_increment,
  `ci_addrs` varchar(255) NOT NULL,
  `ci_about` varchar(255) NOT NULL,
  `ci_desc` varchar(255) NOT NULL,
  `ci_general` varchar(255) NOT NULL,
  `ci_email` varchar(70) NOT NULL,
  `ci_phone` varchar(10) NOT NULL,
  `ci_fax` varchar(10) NOT NULL,
  `ci_website` varchar(30) NOT NULL,
  `ci_sector_id` int(2) NOT NULL,
  `ci_services_id` int(2) NOT NULL,
  `ci_area_id` int(2) NOT NULL,
  `ci_state_id` int(2) NOT NULL,
  `ci_country_id` int(2) NOT NULL,
  PRIMARY KEY  (`ci_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mj_conum_relation`
--

CREATE TABLE IF NOT EXISTS `mj_conum_relation` (
  `conum_id` int(10) NOT NULL auto_increment,
  `comnum_number` varchar(20) NOT NULL,
  `conum_com_id_fk` int(10) NOT NULL,
  PRIMARY KEY  (`conum_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mj_country`
--

CREATE TABLE IF NOT EXISTS `mj_country` (
  `country_id` int(10) NOT NULL auto_increment,
  `country_name` varchar(30) NOT NULL,
  PRIMARY KEY  (`country_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `mj_country`
--

INSERT INTO `mj_country` (`country_id`, `country_name`) VALUES
(1, 'Malaysia');

-- --------------------------------------------------------

--
-- Table structure for table `mj_director_ic`
--

CREATE TABLE IF NOT EXISTS `mj_director_ic` (
  `directoric_id` int(11) NOT NULL auto_increment,
  `director_id_fk` int(11) NOT NULL,
  `director_com_id_fk` int(11) NOT NULL,
  `director_valid_ic` int(11) NOT NULL,
  PRIMARY KEY  (`directoric_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mj_fund_category`
--

CREATE TABLE IF NOT EXISTS `mj_fund_category` (
  `fund_cat_id` int(10) NOT NULL auto_increment,
  `fund_cat_name` varchar(70) NOT NULL,
  PRIMARY KEY  (`fund_cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `mj_fund_category`
--

INSERT INTO `mj_fund_category` (`fund_cat_id`, `fund_cat_name`) VALUES
(1, 'design'),
(2, 'education'),
(3, 'application');

-- --------------------------------------------------------

--
-- Table structure for table `mj_fund_comment`
--

CREATE TABLE IF NOT EXISTS `mj_fund_comment` (
  `fund_comment_id` int(10) NOT NULL auto_increment,
  `fund_usr_id_fk` int(10) NOT NULL,
  `fund_post_id_fk` int(10) NOT NULL,
  `fund_comment_body` varchar(255) NOT NULL,
  `fund_comment_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`fund_comment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `mj_fund_comment`
--

INSERT INTO `mj_fund_comment` (`fund_comment_id`, `fund_usr_id_fk`, `fund_post_id_fk`, `fund_comment_body`, `fund_comment_date`) VALUES
(1, 1, 3, 'This is cool man!', '2012-02-07 20:56:47'),
(2, 2, 1, '4 Days to go! Yahooo!', '2012-02-16 07:23:52'),
(3, 14, 1, 'over budget :P', '2012-03-09 22:15:11'),
(4, 27, 7, 'Wow 2M?', '2012-03-14 14:45:18'),
(5, 1, 7, 'Yes :P', '2012-03-14 16:10:19');

-- --------------------------------------------------------

--
-- Table structure for table `mj_fund_media`
--

CREATE TABLE IF NOT EXISTS `mj_fund_media` (
  `mfm_id` int(11) NOT NULL auto_increment,
  `mfm_path` text NOT NULL,
  `mfm_id_fk` int(11) NOT NULL,
  `mfm_type` int(11) NOT NULL,
  PRIMARY KEY  (`mfm_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `mj_fund_media`
--

INSERT INTO `mj_fund_media` (`mfm_id`, `mfm_path`, `mfm_id_fk`, `mfm_type`) VALUES
(8, 'uploads/project/lbos.png', 7, 1),
(9, 'uploads/project/fb_home.png', 7, 1),
(10, 'uploads/project/badge.png', 7, 1),
(11, 'uploads/project/606-black.jpg', 1, 1),
(12, 'uploads/project/606-silver.jpg', 1, 1),
(13, 'uploads/project/606-yellow.jpg', 1, 1),
(14, 'uploads/project/test-x-dot.mp4', 1, 2),
(15, 'uploads/project/Jellyfish.jpg', 2, 1),
(16, 'uploads/project/Koala.jpg', 2, 1),
(17, 'uploads/project/Penguins.jpg', 2, 1),
(18, 'uploads/project/test_Wildlife.mp4', 2, 2),
(21, 'uploads/project/dinotitan.jpg', 9, 1),
(22, 'uploads/project/dinotitan.jpg', 9, 1),
(23, 'uploads/project/Nemesis-Prime-Henkei-Transformers-Custom.jpg', 9, 1),
(24, 'uploads/project/1279150878_b6cf2467b0.jpg', 9, 1),
(25, 'uploads/project/photo-full.jpg', 10, 1),
(26, 'uploads/project/photo-full-1.jpg', 11, 1),
(27, 'uploads/project/trio2.jpg', 12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `mj_fund_pledged`
--

CREATE TABLE IF NOT EXISTS `mj_fund_pledged` (
  `fund_pledged_id` int(10) NOT NULL auto_increment,
  `fund_usr_id_fk` int(10) NOT NULL,
  `fund_post_id_fk` int(10) NOT NULL,
  `fund_money` int(255) NOT NULL,
  PRIMARY KEY  (`fund_pledged_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `mj_fund_pledged`
--

INSERT INTO `mj_fund_pledged` (`fund_pledged_id`, `fund_usr_id_fk`, `fund_post_id_fk`, `fund_money`) VALUES
(1, 2, 1, 5000),
(4, 3, 2, 7500),
(5, 3, 1, 5000),
(6, 1, 3, 10000),
(7, 2, 3, 10000),
(8, 2, 1, 5000),
(11, 14, 1, 21000);

-- --------------------------------------------------------

--
-- Table structure for table `mj_fund_post`
--

CREATE TABLE IF NOT EXISTS `mj_fund_post` (
  `fund_post_id` int(10) NOT NULL auto_increment,
  `fund_usr_id_fk` int(10) NOT NULL,
  `fund_cat_id_fk` int(10) NOT NULL,
  `fund_post_title` varchar(70) NOT NULL,
  `fund_post_short_brief` text NOT NULL,
  `fund_post_business_model` text NOT NULL,
  `fund_post_customer_market` text NOT NULL,
  `fund_post_accesstiming` text NOT NULL,
  `fund_post_economic_trends` text NOT NULL,
  `fund_post_tech_dev_inno` text NOT NULL,
  `fund_post_ip_regulation` text NOT NULL,
  `fund_post_industry_future` text NOT NULL,
  `fund_post_idea_development` text NOT NULL,
  `fund_post_project_budget` text NOT NULL,
  `fund_post_funding_miles` text NOT NULL,
  `fund_post_image` text NOT NULL,
  `fund_post_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `fund_post_ended` text NOT NULL,
  `fund_post_video` text NOT NULL,
  `fund_post_ratup` int(10) default NULL,
  `fund_post_ratdown` int(10) default NULL,
  `fund_view` int(11) default NULL,
  `fund_post_published` int(2) default NULL,
  `fund_post_success` int(1) default NULL,
  `fund_post_failed` int(1) default NULL,
  PRIMARY KEY  (`fund_post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `mj_fund_post`
--

INSERT INTO `mj_fund_post` (`fund_post_id`, `fund_usr_id_fk`, `fund_cat_id_fk`, `fund_post_title`, `fund_post_short_brief`, `fund_post_business_model`, `fund_post_customer_market`, `fund_post_accesstiming`, `fund_post_economic_trends`, `fund_post_tech_dev_inno`, `fund_post_ip_regulation`, `fund_post_industry_future`, `fund_post_idea_development`, `fund_post_project_budget`, `fund_post_funding_miles`, `fund_post_image`, `fund_post_date`, `fund_post_ended`, `fund_post_video`, `fund_post_ratup`, `fund_post_ratdown`, `fund_view`, `fund_post_published`, `fund_post_success`, `fund_post_failed`) VALUES
(1, 1, 1, 'Helmet', 'On this site, you will find online tools to perform common string manipulations such as reversing a string.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc tristique molestie elit quis pulvinar. Proin porta congue nulla non feugiat. Fusce ut velit sapien, vel molestie diam. Sed interdum ligula eget erat ornare molestie.', 'Customer', 'Market', 'Economic', 'Technology', 'IP', 'Future Plans', 'Idea Development', '20000', 'Cash Flow', 'uploads/project/1-February-6-2012-12-59-48-am-2_MG_4330.jpg', '2012-03-14 13:58:31', '2012-02-20 0:59:48', 'uploads/project/1-February-6-2012-12-59-48-am-x-dot.mp4', 0, 1, 34, 1, 1, 0),
(2, 1, 2, 'Wild Life Descovery', 'On this site, you will find online tools to perform common string manipulations such as reversing a string.', 'Curabitur aliquam mi id tellus volutpat eget mollis dolor consequat. In mollis, diam id rhoncus ornare, orci dui posuere justo, a lobortis ligula mi at orci. Nulla nec eleifend tellus. Nam mattis mattis eros, non lacinia orci dictum ac. Nulla in purus mauris.', 'Customer', 'Mrket', 'Economic', 'Technology', 'IP', 'Future Plans', 'Idea Development', '30000', 'Cash Flow Break Down', 'uploads/project/1-February-6-2012-1-25-25-am-wildlife.jpg', '2012-03-13 01:27:11', '2012-02-20 1:25:25', 'uploads/project/1-February-6-2012-1-25-25-am-Wildlife.mp4', 1, 1, 40, 1, 0, 1),
(3, 3, 1, 'Motion Graphics Reel', 'Motion graphics are graphics that use video footage and/or animation technology to create the illusion of motion or rotation, graphics are usually combined with audio for use in multimedia projects. Motion graphics are usually displayed via electronic media technology, but may be displayed via manual powered technology (e.g. thaumatrope, phenakistoscope, stroboscope, zoetrope, praxinoscope, flip book) as well. The term is useful for distinguishing still graphics from graphics with a transforming appearance over time without over-specifying the form.', 'Motion graphics extend beyond the most commonly used methods of frame-by-frame footage and animation. Computers are capable of calculating and randomizing changes in imagery to create the illusion of motion and transformation. Computer animations can use less information space (computer memory) by automatically tweening, a process of rendering the key changes of an image at a specified or calculated time. These key poses or frames are commonly referred to as keyframes. Adobe Flash uses computer animation tweening as well as frame-by-frame animation and video.', 'Customer Market', 'Market Access & Timing', 'Economic Trends', 'Technology', 'IP', 'Future PLans', 'Idea Develpoment', '40000', 'Cash Flow', 'uploads/project/3-February-6-2012-6-30-26-pm-jv.jpg', '2012-03-13 01:30:20', '2012-02-20 18:30:26', 'uploads/project/3-February-6-2012-6-30-26-pm-Motion Graphics Reel - Evan Larimore.mp4', 1, 0, 38, 1, 0, 0),
(7, 1, 3, 'asd update and update long agains title', 'asdasd update and update long title again', 'asdasdas update', 'dasdas update', 'asdasd update', 'asdasd update', 'asdasd update', 'adasd update', 'adasda update', 'asdasd update', '2000000', 'adasd update', 'uploads/project/lbos.png', '2012-03-14 15:04:15', '2012-03-19 2:02:47', 'NULL', 1, 0, 88, 1, 0, 0),
(9, 1, 1, 'Sample Project Transformers', 'Sample Project Transformers', 'Sample Project Transformers', 'Sample Project Transformers', 'Sample Project Transformers', 'Sample Project Transformers', 'Sample Project Transformers', 'Sample Project Transformers', 'Sample Project Transformers', 'Sample Project Transformers', '2000', 'Sample Project Transformers 1\r\nSample Project Transformers 2', 'uploads/project/Nemesis-Prime-Henkei-Transformers-Custom.jpg', '2012-03-28 04:28:52', '2012-04-11 6:28:52', 'NULL', 0, 0, 2, 1, 0, 0),
(10, 2, 1, 'A Cautionary Tail', 'A Cautionary Tail is an animated short film starring Cate Blanchett, David Wenham and Barry Otto. Directed by Simon Rippingale, the film is based on a children''s story by writer Erica Harrison.\r\n\r\nThrough a collage of 3D animated characters and hand-made miniature sets, we follow the story of a girl born with a tail that expresses her emotions. A dark, funny fable about learning to treasure the things that make us unique, the film is animated by world-class CGI artists and features an original score by Michael Yezerski, composer for the Academy Award-winning short, The Lost Thing.\r\n\r\nEveryone working on A Cautionary Tail has sacrificed something to make this film possible, but we need to raise funds to finish the animation. We''ve managed to raise enough money to make a trailer, which you can view on our website. Now we''re hoping you''ll get involved to help us finish the 13-minute film.\r\n\r\nOur goal of $40,000 will fund animation production. Additional funding will enable us to go into lighting and compositing so we can finish the film. To show our gratitude, the first 1,000 supporters to donate will have their names added to our limited-edition poster, which will be available for download online.\r\n\r\nFor more information and a sneak preview behind the scenes, check out our video. From everyone working on A Cautionary Tail, thanks for your support.', '3D Animation', 'Childrens and adults that want to have fun and enjoy their movie', 'In two weeks time as the animation will be published world wide on this May.', 'Movie watchers', '3D animation that adapt high animation and rendering skills ', 'All rights are reserved by our company', 'The 3D animation is trending right now. So there will be no problem on marketing this product. ', 'The quality and rendering skill are as par of Disney Pixar.', '15000', 'Animator - RM2000\nRenderer - RM3000\nTools and Application - RM10000', 'uploads/project/photo-full.jpg', '2012-04-24 13:15:33', '2012-05-08 9:15:33', 'NULL', 0, 0, 0, 1, 0, 0),
(11, 2, 1, 'Removable Vinyl Floor Tiles', 'acet Collection is the newest material exploration by Process + Content, bringing vinyl to the floor, in a interactive + customizable tiling system, featuring bold, geometric designs. Fools Gold, is the first color combination of the Facet Collection, the 3 diamond shaped tiles come in matte white, matte black + mirrored gold. The diamonds are precision cut to meet seamlessly with the sides of each of the 3 shapes. The application of the thin tiles to the floor is meant to delineate space, riffing off of inlayed wood + tile, of classically designed + constructed buildings. They add color + pattern, in a clean + graphic way, with modern design + an undertone of whimsy.', 'Tiling', 'As a designer, exploring mediums + applications is an investment of hours. Arriving at a final process + resolved product is financially costly. Up to this point, I have cut my product by hand, which is labor intensive + leaves room for error. Kickstarter would finance three dies to be made, improving accuracy, shortening production time + ultimatley lowering costs.', 'In 1 month time', 'New age of floor tiling', 'Vinyl', 'Small quantities of Facet will only be available on Kickstarter. The semi + full sets are shown below the projected retail price. So buying now, saves later.', 'Preorder #s will serve as a small market test for retail buyers. Product shots will serve as a marketing tool. Precisely cut samples will be able to be sent out to retailers.', 'When applied, natural wear will occur, leaving your unique imprint on the product + space. Traffic volume + exposure to the elements (specifically water) will dictate much of the lifespan. A clean surface will give Facet the best start. You can expect Facet to \\', '4000', 'Production of 3 Custom dies Purchasing entire rolls of vinyl material Product packaging - recycled cardboard sleeves Hand silkscreening the cardboard sleeves Grouping + sealing tile series for interior packaging Shipping costs + materials Kickstarter + Amazon processing fees Product shots', 'uploads/project/photo-full-1.jpg', '2012-04-24 13:30:26', '2012-05-08 9:30:26', 'NULL', 0, 0, 0, 1, 0, 0),
(12, 2, 1, 'Pebble E-Paper Watch for iPhone and Android', 'Pebble is the first watch built for the 21st century. It\\''s infinitely customizable, with beautiful downloadable watchfaces and useful internet-connected apps. Pebble connects to iPhone and Android smartphones using Bluetooth, alerting you with a silent vibration to incoming calls, emails and messages. While designing Pebble, we strove to create a minimalist yet fashionable product that seamlessly blends into everyday life.', 'Technology', 'Anyone that is interested with the latst technology', 'Pebble can change instantly, thanks to its brilliant, outdoor-readable electronic-paper (e-paper) display. We\\''ve designed tons of watchfaces already, with more coming every day. Choose your favourite watchfaces using Pebble\\''s iPhone or Android app. Then as the day progresses, effortlessly switch to the one that matches your mood, activity or outfit.', 'The integration of watch with smart phone technology', 'Smartphone technology on your wrist', 'All rights are reserved', 'Everyone will have better watch with smarter technology on the go', 'Pebble connects by Bluetooth to your iPhone or Android device. Setting up Pebble is as easy as downloading the Pebble app onto your phone. All software updates are wirelessly transmitted to your Pebble.\r\n\r\nCompatibility\r\n\r\niPhone 3GS, 4, 4S running iOS 5 or any iPod Touch with iOS 5.\r\n\r\nAndroid devices running OS 2.3 and up. Works great with Android 4.0 (Ice Cream Sandwich)!\r\n\r\nUnfortunately Pebble does not work with Blackberry, Windows Phone 7, or Palm phones at this time.', '100000', '$99 - Early Bird: 200 Black watches available. $115 - One Black Pebble. $125 - One Color Pebble. $220 - Two Black Pebbles. $235 - Prototype Pebble for early app development + one Color Pebble. $240 - Two Color Pebbles. $550 - Five Color Pebbles. $1000 - Ten Color Pebbles. $1,250 - Custom watchface + five Color Pebbles.', 'uploads/project/trio2.jpg', '2012-04-24 13:41:19', '2012-05-08 9:41:19', 'NULL', 0, 0, 0, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `mj_idea_category`
--

CREATE TABLE IF NOT EXISTS `mj_idea_category` (
  `id_cat_id` int(10) NOT NULL auto_increment,
  `id_cat_name` varchar(30) NOT NULL,
  PRIMARY KEY  (`id_cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `mj_idea_category`
--

INSERT INTO `mj_idea_category` (`id_cat_id`, `id_cat_name`) VALUES
(1, 'kitchen'),
(2, 'toys'),
(3, 'home decor'),
(4, 'lawn & garden'),
(5, 'electronics'),
(6, 'organization'),
(7, 'fitness'),
(8, 'accessories'),
(9, 'pets'),
(10, 'other');

-- --------------------------------------------------------

--
-- Table structure for table `mj_idea_comment`
--

CREATE TABLE IF NOT EXISTS `mj_idea_comment` (
  `id_comment_id` int(10) NOT NULL auto_increment,
  `id_usr_id_fk` int(10) NOT NULL,
  `id_comment_body` varchar(250) NOT NULL,
  `id_comment_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `id_post_id_fk` int(10) NOT NULL,
  PRIMARY KEY  (`id_comment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `mj_idea_comment`
--

INSERT INTO `mj_idea_comment` (`id_comment_id`, `id_usr_id_fk`, `id_comment_body`, `id_comment_date`, `id_post_id_fk`) VALUES
(1, 1, 'Nice Idea', '2012-02-07 19:59:11', 5),
(2, 1, 'We should make this!', '2012-02-07 20:00:56', 4),
(3, 1, 'Smart!', '2012-02-07 20:10:09', 2),
(4, 1, 'Look good!', '2012-02-07 20:10:27', 1),
(5, 2, 'Yeah. how bout the price?', '2012-02-16 07:21:22', 2),
(6, 2, 'this price about RM5rat', '2012-02-16 07:22:33', 1),
(7, 2, 'When?', '2012-02-26 12:34:26', 4),
(8, 24, 'i place for 500. is it ok?', '2012-02-27 03:21:53', 2),
(9, 1, 'Ok. kat mana nk dpt ni?', '2012-02-27 08:56:06', 2),
(10, 14, 'nice idea!', '2012-03-09 22:11:47', 4);

-- --------------------------------------------------------

--
-- Table structure for table `mj_idea_media`
--

CREATE TABLE IF NOT EXISTS `mj_idea_media` (
  `mim_id` int(11) NOT NULL auto_increment,
  `mim_path` text NOT NULL,
  `mi_id_fk` int(11) NOT NULL,
  `mim_type` int(11) NOT NULL,
  PRIMARY KEY  (`mim_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=82 ;

--
-- Dumping data for table `mj_idea_media`
--

INSERT INTO `mj_idea_media` (`mim_id`, `mim_path`, `mi_id_fk`, `mim_type`) VALUES
(54, 'uploads/ideas/idea3gsmartphones_231749218317_640x360.jpg', 27, 1),
(55, 'uploads/ideas/creative-idea-the-library-bookshelf.jpg', 28, 1),
(56, 'uploads/ideas/Axel-Schaefer-Creative-Idea-588x352.jpg', 28, 1),
(57, 'uploads/ideas/Wildlife.mp4', 28, 2),
(59, 'uploads/ideas/Anonymous_Flag.png', 3, 1),
(60, 'uploads/ideas/lbos.png', 3, 1),
(61, 'uploads/ideas/perakniaga.jpg', 3, 1),
(62, 'uploads/ideas/anon.jpg', 2, 1),
(64, 'uploads/ideas/DSC_0039 copy.jpg', 1, 1),
(65, 'uploads/ideas/hanger.jpg', 1, 1),
(66, 'uploads/ideas/bumerang-trouser-hanger__42332_PE137009_S4.jpg', 1, 1),
(67, 'uploads/ideas/campus-of-the-future-main_IdnGE_5784.jpg', 29, 1),
(68, 'uploads/ideas/campus-of-the-future-main_IdnGE_5784.jpg', 29, 1),
(69, 'uploads/ideas/Top-Design-View-Bright-Idea-Concept-Kitchen-Design-Luxury-Future.jpg', 29, 1),
(70, 'uploads/ideas/food1.jpg', 30, 1),
(71, 'uploads/ideas/food1.jpg', 30, 1),
(72, 'uploads/ideas/defq_new_title.jpg', 15, 1),
(73, 'uploads/ideas/defq_new_title.jpg', 15, 1),
(74, 'uploads/ideas/pLEVI1-9054701_outfitmain_t330x400.jpg', 30, 1),
(75, 'uploads/ideas/pLEVI1-9054701_outfitmain_t330x400.jpg', 30, 1),
(76, 'uploads/ideas/Justin Regan Phone Case.png', 31, 1),
(77, 'uploads/ideas/Justin Regan Phone Case.png', 31, 1),
(78, 'uploads/ideas/trio2.jpg', 31, 1),
(79, 'uploads/ideas/Justin Regan Phone Case.png', 31, 1),
(80, 'uploads/ideas/perfect party gift.jpg', 32, 1),
(81, 'uploads/ideas/ice drops for your drinks.jpg', 32, 1);

-- --------------------------------------------------------

--
-- Table structure for table `mj_idea_post`
--

CREATE TABLE IF NOT EXISTS `mj_idea_post` (
  `id_post_id` int(10) NOT NULL auto_increment,
  `id_title` varchar(255) NOT NULL,
  `id_usr_id_fk` int(10) NOT NULL,
  `id_dateposted` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `id_pictures` text NOT NULL,
  `id_cat_id_fk` int(10) NOT NULL,
  `id_cur_problem` varchar(255) NOT NULL,
  `id_cur_solution` varchar(255) NOT NULL,
  `id_desc` text NOT NULL,
  `id_trget_cust` varchar(255) NOT NULL,
  `id_features` text NOT NULL,
  `id_smlar_product` text NOT NULL,
  `id_rat_up` int(10) default NULL,
  `id_rat_down` int(10) default NULL,
  `idea_view` int(11) default NULL,
  `id_post_published` int(2) default NULL,
  `id_featured` int(1) default NULL,
  PRIMARY KEY  (`id_post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `mj_idea_post`
--

INSERT INTO `mj_idea_post` (`id_post_id`, `id_title`, `id_usr_id_fk`, `id_dateposted`, `id_pictures`, `id_cat_id_fk`, `id_cur_problem`, `id_cur_solution`, `id_desc`, `id_trget_cust`, `id_features`, `id_smlar_product`, `id_rat_up`, `id_rat_down`, `idea_view`, `id_post_published`, `id_featured`) VALUES
(1, 'Hanger', 1, '2012-03-11 10:05:50', 'uploads/ideas/1-January-27-2012-3-15-18-pm-hanger.jpg', 1, 'Problem', 'Solution', 'Desc', 'Public', 'Features', 'Similar Product', 2, 1, 21, 1, 0),
(2, 'Cool Bottles', 1, '2012-03-13 01:27:44', 'uploads/ideas/1-January-27-2012-3-20-44-pm-bottle.jpg', 1, 'Problem\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aut', 'SOlution\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis au', 'Description\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Market\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute', 'Features\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Product\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 4, 1, 9, 1, 0),
(3, 'Relaxing Chair', 1, '2012-03-13 01:27:57', 'uploads/ideas/1-January-27-2012-3-21-45-pm-chair.jpg', 3, 'Problem\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute ', 'Solution\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute', 'Desc\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Market\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute i', 'Features\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Similar Product\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, 0, 43, 1, 0),
(4, 'Creative Zip', 1, '2012-03-13 01:29:45', 'uploads/ideas/1-January-27-2012-3-22-39-pm-zip.jpg', 7, 'Problem\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\nconsequat. Duis aute ', 'Solution\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\nconsequat. Duis aute', 'Description\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'MArket\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\nconsequat. Duis aute i', 'Features\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Similar Product\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 13, 0, 14, 1, 0),
(5, 'Wrist Band', 1, '2012-03-14 16:06:21', 'uploads/ideas/1-January-27-2012-3-23-26-pm-band.jpg', 7, 'Problem\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute ', 'Solution\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute', 'Desc\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Market\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute i', 'Features\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Product\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 0, 1, 21, 1, 0),
(15, 'new title', 1, '2012-03-11 10:05:50', 'uploads/ideas/defq_new_title.jpg', 1, '<p>new solution</p>', '<p>new solution</p>', '<p>new desc</p>', '<p>new market</p>', '<p>new features</p>', '<p>new smilar product</p>', 0, 0, 0, 1, 0),
(27, 'asdaaaa', 1, '2012-03-11 10:05:50', 'uploads/ideas/idea3gsmartphones_231749218317_640x360.jpg', 1, '<p>asdasda</p>', '<p>asdasda</p>', '<p>asd</p>', '<p>a</p>', '<p>asdasd</p>', '<p>HTC, Android</p>', 0, 0, 0, 1, 0),
(28, 'Creative Chair Wooden', 1, '2012-03-14 15:46:27', 'uploads/ideas/Axel-Schaefer-Creative-Idea-588x352.jpg', 1, 'cip', 'cis', 'cid description', 'citm', 'cif', 'cisp', 0, 0, 23, 1, 0),
(29, 'Future Phone', 27, '2012-03-26 03:12:57', 'uploads/ideas/campus-of-the-future-main_IdnGE_5784.jpg', 10, '<p>The Solution Lack</p>', '<p>The Solution Lack</p>', '<p>Future Phone</p>', '<p>Public World market</p>', '<p>The Features</p>', '<p>iPhone</p>', 0, 0, 2, 1, 0),
(30, 'asdasd', 27, '2012-03-29 05:22:19', 'uploads/ideas/pLEVI1-9054701_outfitmain_t330x400.jpg', 8, '<p>asdasd</p>', '<p>asdasd</p>', '<p>asdasd</p>', '<p>asdasd</p>', '<p>asdasd</p>', '<p>asdasd</p>', 0, 0, 4, 1, 0),
(31, 'Mobile Phone Case for landscape video shooting. Convert your Mobile Phone into a handy camcorder!', 2, '2012-04-24 13:50:53', 'uploads/ideas/Justin Regan Phone Case.png', 1, 'For some time now I''ve noticed people shooting video on their mobile phones. The issue I''ve noticed is the that most shoot the video in a ''portrait'' orientation. The biggest issue with this is when/if they chose to watch the video on a tv then it''s not id', 'The \\''solution\\'' I have discovered would be a case with built in, fold out handle. The handle would make it easy and stable for \\''standard landscape\\'' filming.\r\n\r\nThis product could be made out of moulded plastic and may or may not require an incorporated', 'Convert your phone into a camcorder by using our innovation that will help you shoot video without shaky hands', 'Anyone with a mobile phone', 'No need to carry attachments', 'None', 0, 0, 3, 1, 0),
(32, 'How cool is that? Ice drops keep your drinks cold with crushed ice inside! No melting ice cubes, always find your glass - perfect party gift', 2, '2012-04-24 13:59:23', 'uploads/ideas/perfect party gift.jpg', 1, 'You got the perfect cocktail in your hand, but the ice cubes dilute the taste after a while. Of course you could use the funny plastic cubes that don\\''t melt, but it\\''s a bit awkward have them swimming in your drink and honestly: who has enough of them in', 'Ice Drops stick to the bottom of your glass, you refill them with crushed ice as often as you need. No melting ice in your drink, no concerns about water quality. Looks cool and helps you recognize your glas', 'Keep your drinks cool', 'From consumers to product manfacturers', 'Fits into every glass\r\n\r\nRefill with crushed ice as often as you need\r\n\r\nNo melting ice in your drink\r\n\r\nNo concerns about water quality\r\n\r\nAlways recognize your glass\r\n\r\nPerfect gift', 'Ice cubes - dilute the taste of your drink after a while\r\n\r\nPlastic ice cubes - you need new cold cubes for every drink', 0, 0, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `mj_idea_price`
--

CREATE TABLE IF NOT EXISTS `mj_idea_price` (
  `ip_id` int(11) NOT NULL auto_increment,
  `usr_id_fk` int(11) NOT NULL,
  `mrket_post_id_fk` int(11) NOT NULL,
  `ip_price` int(7) NOT NULL,
  `ip_date_posted` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`ip_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `mj_idea_price`
--

INSERT INTO `mj_idea_price` (`ip_id`, `usr_id_fk`, `mrket_post_id_fk`, `ip_price`, `ip_date_posted`) VALUES
(2, 1, 5, 200, '2012-02-26 12:13:34'),
(3, 1, 5, 250, '2012-02-26 12:19:29'),
(4, 1, 5, 240, '2012-02-26 12:20:39'),
(5, 2, 5, 199, '2012-02-26 12:22:15'),
(6, 2, 5, 180, '2012-02-26 12:23:15'),
(7, 2, 3, 2000, '2012-02-26 12:23:46'),
(8, 2, 3, 1999, '2012-02-26 12:24:14'),
(9, 2, 4, 200, '2012-02-26 12:34:08'),
(10, 24, 2, 500, '2012-02-27 03:21:18'),
(11, 14, 4, 2000, '2012-03-09 22:11:37');

-- --------------------------------------------------------

--
-- Table structure for table `mj_learn_article`
--

CREATE TABLE IF NOT EXISTS `mj_learn_article` (
  `la_id` int(10) NOT NULL auto_increment,
  `la_title` varchar(50) NOT NULL,
  `la_body` text NOT NULL,
  `la_visual` text,
  `la_dateposted` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `la_article_by` int(10) NOT NULL,
  `la_rat_up` int(10) default NULL,
  `la_rat_down` int(10) default NULL,
  `la_cat_id_fk` int(10) NOT NULL,
  `la_featured` int(1) default NULL,
  `la_published` int(1) default NULL,
  PRIMARY KEY  (`la_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `mj_learn_article`
--

INSERT INTO `mj_learn_article` (`la_id`, `la_title`, `la_body`, `la_visual`, `la_dateposted`, `la_article_by`, `la_rat_up`, `la_rat_down`, `la_cat_id_fk`, `la_featured`, `la_published`) VALUES
(1, 'Writing Business Requirement Documents', 'Writing a business requirement documents is known to entail a lot of consideration.\r\n<p>But if there is the two-way communication between you and your people, you will surely be able to realize your goals in your projects.\r\nBusiness requirement documents indeed have a lot of uses from the past even until now. Commonly, it has been widely used specifically when it comes to project planning. But nowadays, such documents are used for the development of enterprise software, database as well as websites.</p>\r\n \r\n<p>In writing a business requirements document, one must make sure that he/she must have a preemptive knowledge when it comes to the goals of the project before actually writing it. Of course, this can be fully realized when people are able to have a careful attention to the information that will make the project to be completed</p>\r\n\r\n<p>The first thing that one must do is to have a discovery meeting. Such meeting must include people like stakeholders (customer service representatives, sales force, etc), end users as well as the management. <blockquote>What you must talk about in the meeting are the desired results that you would like attain. Moreover, it would also help if you can do some interviews with these people and get details that you can use for the benefit of the company.</blockquote></p>\r\n\r\n<p>After having your meeting, you can now make a draft or your business requirement documents and pass it over with all the people who attended your meeting. It is best that all of you are able to review all the things written on it. Take comments given by these people as changes that will be for the betterment of the business requirement documents.</p>\r\n\r\n<p>For the most part, there will be revisions that must be given proper attention. After all comments have been given by the people who attended your meeting, collate it over and do the necessary revisions. Moving forward, you can now re-circulate it to people whom are important for the full realization of the projects’ goal with the help of the business requirement documents.\r\nIt is a good way that you start writing your business requirement documents with the help of a template. There are standard templates that you can use so that during the meeting, you will be able to address all the things that must be included in your meeting. This will serve as a roadmap in making you achieve your goals.</p> \r\n \r\n<p>Moreover, it is important that you give particularity when it comes to the continuous updates that will surely come. By doing so, you are avoiding and at the same time protecting yourself from the blames if there are cases where the goals of the projects are not met.</p>', 'uploads/article/cover1.jpg', '2012-01-26 16:00:00', 1, 7, 2, 1, 0, 1),
(2, 'How to Start a Mid Night Club', 'If you look into today''s night life then you can easily comprehend the young generations are more into brew pubs, night clubs, dance clubs and swing clubs. Young couples also don''t want to stay behind, they are also seen more in mid night clubs. Opening a night club is a potential business to think about and invest.\r\nLas Vegas night clubs are classic examples that show there is money in nightlife. The best nightclubs and bars have raised a number of successful entrepreneurs who have cashed in on man’s natural love for night life.\r\nIf you have been thinking to start a new business that you can consider fun and enjoyable, you might want to invest on a bar night club . Starting and running a nightclub, however, is not as easy as it seems. It takes a great deal of preparation and some know-how to establish a successful nightclub business. Here are some things that you have to know before starting a nightclub business:\r\nGet to know what appeals to your clients\r\nAmong the best things that you can do to guarantee success to your local bar is to make sure you are providing the right services like live entertainment and drinks to your clients and the best means to do this is to know what appeals to your clients. Know their tastes and their preferences. The night club industry is an ever evolving business. Pub hoppers of today may not have the same preference for entertainment, food and drinks that night clubbers of the yesteryears wanted. Knowing the current tastes and general favorites of your prospective clients will allow you to make plans for a night club and bar that reflects and expresses the personality and tastes of your clients.\r\nGive your clients reasons to be in your nightclub\r\nIf there are a number of nightclubs in the area, how will you make people go to your nightclub? You can actually make people go to your nightclub by providing them with reasons and intentions to be in your nightclub. You can do this by making people feel special or privileged. While not being necessarily a teen nightclub, for example, you can provide teenagers special discounts during Fridays or you can make your nightclub a dance club or karaoke bar on special days to cater to people who like to dance and sing. It will also be a good idea to establish fixed days of the week to cater to the interests and preferences of different personalities so your guests will know when it is best for them to visit your nightclub.\r\nA nightclub business can be a fun way for you to cash in on people’s love for nightlife. You can be as successful as many nightclub entrepreneurs if you get to know what appeals to your clients and when you give your clients reasons to be in your nightclub.', 'uploads/article/cover2.jpg', '2012-01-26 18:16:27', 1, 11, 0, 1, 0, 1),
(3, 'How to Write Business Thank You Notes to Customers', 'Sending a business thank-you letter to customers is a way of giving your whole-hearted appreciation. This type of business letter show that you have given importance to the client and this result to the improvement of customer restrain.\r\nBusiness thank-you notes is one of the strategies that help your company to gain more customers. Here are some tips on how to write a business thank-you note letter.\r\nThe use of business thank you notes to customers has been neglected by most companies. One effective way in order to get better the customer retention and the effective vocal advertising is through taking the effort and time to write thank-you letters to the customers. Although writing a thank-you letter to the customer can be a time consuming process, it is a very ideal to show your appreciation and to be appreciated by the clients. Preferably, the owner of starting business must be the one who need to write and send a thank-you letter in whole appreciation and sincerity is completely associated with the business. However, writing a thank-you letter is not just like a simple friendly letter. You need to think it about some important things to produce effective thank-you letter to the clients.\r\n \r\nChoose the Right Format\r\n \r\nSelect the right format for the thank-you letter. Since you are using it for your business, it should be written in formal way. Of course, you need to search for business letter format and style. There are various information about business letters on internet, so it won’t difficult for you to find the formal style for the letter. Business letters today are usually printed, but you can show your sincerity and effort if the thank-you letter is personalized and hand written. You should also include a small-thank you card which can be bought in bulk. \r\n \r\nAvoid Using Sale Tone\r\n \r\nDon’t use the sale tone in the note. Although your customer has already ordered or bought a product from you, you should still avoid more sale tone in the note. This could possibly bring a bad impression from the customer. He or she might think feel that you are forcing him or her to buy another product from your company. This is an annoyance for most customers. So, you have stick to your intention by appreciating the customer about his or her loyalty and nothing else. \r\n \r\nMake the Card Special\r\n \r\nFirst impression is very important. In order to feel your appreciation from the card, you have to personalize it. You should begin with the client’s name and then put the date when she or he was in your company. For example, “Dear James, we are glad you have visited our company.” This allows the clients to be ware that he or she is not just unknown person while walking through your door. \r\n \r\nExpress Your Appreciation to the Client\r\n \r\nMake sure you show your sincerity through the use of art of words. Thank the customer with your all heart for his or her purchase and allow him or her to know what you appreciated about. If possible, insert tag lines like ”we are hoping to see you again”. This is a tactic to let them feel their importance as a part of your company. Then, send the letter with an actual stamp.', 'uploads/article/cover3.jpg', '2012-01-26 18:20:20', 1, 1, 1, 1, 0, 1),
(4, 'Tips to Make Your Own Logo', 'A logo is an integral part of a business regardless of its size. It gives identification to the company and shows the future of the company in the business world.\r\nTherefore, it is important to know how to draw your own logo that says all about your business.\r\nStarting a new business needs big amount of money but there are possible ways to cut the costs. Designing a business logo is significant thus it adds cost of starting a business. However, if you have skills in designing you can save money by making and designing your own logo. All you have to do is follow some steps in designing a great logo.\r\n \r\nChoosing Software\r\n \r\nCreating a logo can be both simple and complicated. This means that it depends on the preference of the business owner. Likewise, there are many tools that you can use in designing a logo. In this sense, choosing the right software should be considered. One of the photo editing software that you can use is the Adobe Photoshop.\r\n \r\nCreate Readable Logo\r\n \r\nWhen creating a logo for your business make sure that it is not complicated and readable. That is why you should think for elements that you can use in making simple logos. You can choose to add images or just the name of your company. If you want just to include only the company name in the logo you can use Adobe Photoshop. While using the Adobe Photoshop you can have the chance to choose the fonts that you prefer. On the other hand, you can also look for websites that offer free fonts and download it in your computer.\r\n \r\nAfter choosing the font that suits your company name the next step is to decide whether you will add image to the logo. Just like the fonts you can also download free images from the web. As much as possible choose image that is relevant to the product and services that your company offer. \r\n \r\nMoreover, if you do not want the logo that you personally made, you can opt to browse from different websites and generate your own logo. On the other hand, you can also decide to hire a professional designer who can create your company logo. Keep in mind that hiring professional designer is expensive but you can expect for an attractive logo design.\r\n \r\nIn the same manner, if you want your logo to be made in professional manner it will be a contributing factor for the success of your business. It is not enough just to provide quality products and services because it is also significant to have attractive company logo that will be easily recognized by your customers. IN this way, you can ensure that your customer will not forget your company as well as your products and services.', 'uploads/article/cover4.jpg', '2012-01-26 18:25:16', 1, 0, 0, 1, 0, 1),
(5, 'Tips on Complaining About an Accountant', 'Even though accountants are respected in the world of professions, there are some people who are unfortunate as they come across with a charlatan.\r\nAnd if by chance that they will be unfortunate in such case, there are some ways that they can use in forwarding complaints with regards to their accountant.\r\nIn a corporate setting, the services that are offered by a chartered accountant can never be done away. They are the ones who can help you in coming up with the best decisions when it comes to financial matters. More so, they are big contributors when it comes to decisions that will assure that your business is on the right track. But despite the expertise derived from rigorous trainings as well as examinations, chartered accountants can also make mistake. And with such, there are some misunderstandings between an accountant and their clients.\r\nRising Conflicts Leading to Complaints\r\nThe main reason why there is the surge of complaints between an accountant and their clients is basically rooted in the lack of communication between two parties. Even though there is the possibility of the two parties talking things over, there will always be a time wherein problems are so serious that two parties will be needing mediators, like the Institute of Chartered Accountants, to make sure that complaints will be given proper attention and mediation as well as resolution will be given.\r\nHaving your Complaint/s Heard\r\nIf by chance that you have a complaint that should be heard, you must make sure that you make it heard. It is best advised that you talk first to the accountant as you both discuss the issue or problem. It will be faster also if you will address your concern to the accountancy firm’s senior partner. On the other hand, you can also have the help of the Institute that will later on give you a complaint form. Before sending back the complaint form to the Institute, make sure that you have included all necessary documentation as well as correspondence needed from you.\r\nAfter the phase of you sending all the relevant pieces of information regarding your complaint, the Institute will then acknowledge the receipt of your complaint. Next, they will forward it to an assessor will review your complaint and see to it if what further actions can be taken.\r\nIn the review process of an assessor, he/she will look into the potentiality of disciplinary or liability actions to the accountant and how can it be dealt with. On the other hand, if the assessor deems that your complaint can still be settled without the use of any disciplinary action, then conciliation will be given. In such cases, the Institute of Chartered Accountants will be there along the way to make sure that you are in the right track.', 'uploads/article/cover5.jpg', '2012-01-26 18:26:58', 1, 0, 0, 1, 0, 1),
(6, 'Ways to Become a Forensic Loan Auditor', 'Forensic loan auditor is now becoming an in-demand occupation these days. It actually tackles all the issues regarding the mortgage loans and other related matter. If you love numbers and law then this job is right for you.\r\nIn any type of venture, it is very important that you have the right tool and method to be successful. Read on further to know how to become a successful forensic loan auditor.\r\nWhy Forensic Loan Auditor?\r\n \r\nIf you love working with banks and laws, forensic loan auditor is perhaps the job suited for you. As a forensic loan auditor, it is your task to determine or investigate the errors or downright violations in laws involving loans. If you love to analyze and explore then this field is right for you. The best thing about this job is you can actually practice your skills and ability at the same time help people who are facing great problem about loans.\r\n \r\nOverview of this Job\r\n \r\nThe current debacle or issues that involve predatory lending is growing not just in the U.S. but also in other places, which requires the need to have a people or expert that will investigate and explore it. Individuals who don’t have enough knowledge about the loan laws and are about to have their assets and other properties for foreclosure need the assistance of a forensic loan auditor. If this is not resolved, these people will have to stay homeless. If there’s a forensic loan auditor, it is more likely that this will be barred, if it is proven that the loan is unenforceable, the owner will surely benefit. In order for the auditor to determine this, he or she needs to review the mortgage contract. By reviewing the contract, the auditor can tell if the bank or financial institution has the basis of getting the property legally. \r\n \r\nHow to Start?\r\n \r\nIn order for you to start with this job of course, it is very significant if you can get a certain certification or short crash course about this field. Even if you love banking and laws, if is still recommendable if you have the right knowledge. Maybe you can consult the nearest universities or colleges near your area if they offer similar training or programs. During this training, you will be able to learn the important laws about loans and what is legal and what is not. When you enter a program, make sure that it is supported by the government. After your course, you can now start your new profession.\r\n \r\nYou can start as a freelance forensic loan auditor but for starters, it is ideal way on joining a group of forensic loan auditors or employed on a firm. This helps you to get the clients because the clients will be the one that will look for you.', 'uploads/article/cover6.png', '2012-01-26 18:27:36', 1, 0, 0, 1, 0, 1),
(7, 'How to Become a Sales Agent', 'If you want to become a sales agent, this is your chance. A lot of companies these days are no longer maintaining their own sales force and are relying greatly on sales agents like you.\r\nThis is the perfect time to file applications to the reputable companies out there. If you want, you can even use the internet as a tool to sell various kinds of products and services by having your own website.\r\nThe Job Description of a Sales Agent\r\nAs a sales agent, you have a chance to earn unlimited income. In fact, if you become a full time sales agent, you can enjoy the financial security that comes with it. Almost every individual wants to be his/her own boss and this is possible if you become a sales agent. There are no educational requirements required although you can be at an advantage if you finish a marketing related course in college. You will need to pick a company that offers an attractive incentive or commission program. Some companies even offer their sales agents with dental and medical benefits.\r\nTrainings are usually provided by companies once you pass their application process. Well of course, the requirements may vary from one company to another so you need to determine the qualifications first before you file an application. You should choose the company well and pick one that offers continuous support for sales agents like you. Ongoing programs and workshops should be provided by the company to help you in keeping up with the latest trends in the market. The needs of people vary so it would be best to team up with a company that offers a wide range of services and products. That way, you can offer the right products/services to the right clients.\r\nOther Info for Becoming a Sales Agent\r\nSo far, becoming a sales agent is the cheapest and simplest method. In today’s modern market, a lot of companies no longer want a massive sales force because it’s too costly. These companies are now turning to sales agents because it the most effective way to circulate their product in the online and offline market and less costly too. The sales agents are given a certain percentage for every product sold to customers. If you’re not ready to take the plunge, you can start by becoming a part timer. Start surfing the internet now and look for companies offering business opportunities to sales agents.\r\nSince there are no stringent requirements to become a sales agent, you can easily qualify especially if you possess the skills of a good sales agent. You should be smart, a good communicator, confident, and knowledgeable so that you can easily convince clients to get your products or services of the company that you represent. If you are hard working, you can earn more. Choose the best schedule during the day so that you can have more output. Apply as a sales agent now and start making a lot of money.', 'uploads/article/cover7.jpg', '2012-01-26 18:28:24', 1, 0, 0, 1, 0, 1),
(8, 'How to Start a T-shirt Company', 'As far as the fashion industry is concerned, t-shirts are the most common fashion output that people are used of wearing.\r\nThey find it comfortable and very trendy at the same time.\r\nSetting up your T-shirt Company\r\nThe first thing you should do is to make sure that you have the essential tools and equipment needed in setting up your t-shirt venture. You should have lots of sewing machines. These machines will be the ones that will produce your t-shirt. Of course along with it, there should be t-shirt designers. They will be the ones who will make your t-shirt designs. They are the ones who will give you the idea on what type of t-shirt you will be producing in the industry. T-shirts are almost the same with every single type of t-shirt. The only difference is the type of cloth you used and the designs printed on shirt itself.\r\nNext, you should secure the entire license needed in starting your business venture. They are important because in this world, without a license you are always considered to be operating a business in an illegal way. You do have laws and you should follow those laws to avoid problems. Include your tax ID and other tax related responsibilities in your check list. These are the most essential requisite to make your business in line with the licensed business companies and be legal. Another thing, you should find a good source and supplier. Suppliers for your employees and suppliers for the raw materials you will be using in your company.\r\nDesigning and Selling T-shirts\r\nIn designing t-shirts, you will need the help of a fashion consultant or you might want to hire your very own designer. Having your own designer will definitely be an edge for your company. You will be saving lots of money from it and you will be working closely with them. With your designer, you may come up with t-shirt prints that are very unique and trendy. Most people today are very trendy when it comes to choosing their kind of shirts. They do not just buy a plain shirt. They buy those shirts that have a print on it that would make other people notice them. It is essential in designing shirt prints to take into consideration the attitude and persona of the market group you are going to deal with. For example, if you are targeting the young group of buyers, then maybe you can think of prints that are colourful, feisty, and jolly. You may also think of those cute and trendy prints for them because the young generation of today have already their own kind of fashion statements.\r\nYou may use iron-on transfers to make your t-shirt printing faster and more efficient. Through this, you will no longer hire too many workers in your company because you will need just enough of them to do the job. You will be cost cutting through this since the economy today is very unstable. When you already made your designs and you already had them printed or transferred to the shirt, then you’re ready for business.', 'uploads/article/cover8.jpg', '2012-01-26 18:29:15', 1, 0, 0, 1, 0, 1),
(9, 'How to Start a Woodworking Business', 'Use your woodworking skills and start a lucrative business. The woodworking business is an enjoyable way to make money. This article also offers tips on starting and running a woodworking business.\r\nThe woodworking business is ideal for people who love doing handcrafted woodwork for a hobby.\r\nThere are a lot of highly marketable products nowadays that make use of woodworking techniques. Furniture is a fine example and hand made wooden toys too is becoming a market favorite.\r\nIf you are looking for business opportunities and you possess woodworking skills and talent, then I suggest you explore this industry.\r\nStarting a woodworking business can be simple as long as you are armed with sufficient knowledge. Here are some pointers that may guide you as you embark on starting your own woodworking company.\r\nFirst, figure out what kind of items you want to specialize in i.e. home décor, furniture, toys, etc. The supplies and equipment you invest on will rely primarily on the products you plan to produce.\r\nSecond, look for a good supplier for your wood and equipment needs. Make sure the supplier you choose will give you the best value for money deal. Naturally, you know better than procure sub-standard materials. Doing so will vastly affect the quality of your products and quality is one of the selling points in this business. Typically, you will need to buy clamps, a square, saws, tape measure, hammers, hand drills, and chisels.\r\nThird, look for a space where you can work. If your operation is a small one, your garage or home workshop will do just fine. However, if you plan to launch a big business, then you will need to rent space where you and your craftsmen can manufacture your merchandise. The additional cost for rent and utilities should be computed and used as a consideration when making your price scheme.\r\nFourth, identify your target market and develop a promotional campaign tailor-fit to suit them. There are a lot of ways you can advertise your merchandise. You can post adverts in the internet, or on local bulletin boards, on trade magazines etc. The key is to establish your business in the arena and introduce your name to the market.\r\nFifth, look for a plausible sales channel. A website is a good option because it enables you to reach a wider market. If possible, equip your website with e-commerce capability. Aside from this, you can also participate in trade shows, arts & crafts fairs, and flea markets and so on.\r\nSixth, expound, explore, and discover. Take a look at the trends. Take a look at your competition. Make it a point that your products are better than theirs are. Don’t hamper your creativity and imagination. The best way to establish a niche market is to develop product designs that are uniquely yours. Remember to have these designs copyrighted so nobody else can use them.\r\nSeventh, in manufacturing your products, make sure you and your workers adhere to safety rules. You will be using sharp tools like knives and chisels so to avoid accidents and mishaps, always practice caution.\r\nEight, put your customers first, always. The success of a business doesn’t only depend on the number of customers you entice to your store. What matters is the number of customers you retain. Keep them coming back by giving them the royal treatment.', 'uploads/article/cover9.jpg', '2012-01-26 18:29:54', 1, 0, 0, 4, 0, 1),
(10, 'Tips on Closing a Sale Effectively', 'If you are personally marketing the business and the products you have for your customers, it is important that you are aware of the proper ways on how to close a sale effectively.\r\nBecause of having an idea with the right tactics and tips required, this will lead to the efficiency and productivity of the business.\r\nWhen your aim is to personally advertise the business and the services you have for your customers, it is important that you know the possible ways on how to close the deal. This article will provide you with the most effective tips you can consider. \r\n \r\nSell the Aces of the Products\r\n \r\nOnce you are selling your products and services and you are eager to close the deal with your customer, it is important that you sell the advantages. Keep in mind that what usually disappoints the customers in some deals is when the marketer will open about the disadvantages of the products. Keep in mind that your customer is looking for a superb product, so it will be a major turn off to hear some of the negative sides of the stuffs you are offering. To effectively close the deal, talk more of the benefits of using the product. \r\n \r\nPut Yourself on the Customers’ Shoes\r\n \r\nIf you will put yourself in the shoes of your customers, you can effectively close a deal. Being a customer, you will have lots of doubts and queries about the product you want to purchase. Try to ask yourself if you are the actual customer. By this way, you will know how to tackle the queries of your client and to effectively market the product you are offering as well. So when the same question is asked by your client in the future, you know what to say. \r\n \r\nIdentifying Goals\r\n \r\nDetermining your goals is also among the best ways for you to effectively close a sale. Keep in mind that sales is different from the actual conversation you do with your friends and the people around you. By identifying the exact goal why you need to do effective marketing conversation, you can device the right tone of discussion. Additionally, identify if you are inclined to get a broad net or a higher number of people. By doing this, you will be able what to go about and to tackle the discussion with your client. \r\n \r\nMaking Customers Feel Special\r\n \r\nAs you talk to your customer, make sure that you will make them feel they are special to you. Because of the feeling that they are special to your business, they will somehow be convinced to purchase the product you are offering. The use of the right tone and words also affects the special feeling experienced by your customers. If you will ask for some pieces of advice from your possible customers, they will also tell you the same thing.', 'uploads/article/cover10.jpg', '2012-01-26 18:38:08', 1, 1, 0, 1, 0, 1),
(11, 'Types of Viral Marketing', 'When you plan to establish a business, selling your products or service could be one of your first considerations. Definitely, selling products or services is a great challenge for you especially if you don’t have enough knowledge about marketing. Using the types of viral marketing could be the best way to have an effective marketing.\r\nThe viral marketing can be used by vocal or network effects from the innovation of internet. Viral marketing can also be used through video clips, text messages, and other interactive processes.\r\nWhen you buy a product of a particular establishment and you are satisfied with product, you usually recommend it to your friend and other people who also appreciate the product. And when you give your recommendation, they grab or avail the item. Usually, you express your satisfaction through telling your relatives or friends about the benefits you got from the items or service. Some of them will actually try the same item that you have recommended. This is the viral marketing strategies in which you could successfully advertise the item or service by word-of-mouth without using money on it. This is the process of viral marketing. It is said that it is an advertising strategy that attracts people to pass on selling message to friends and relatives. \r\n \r\nIdea of Viral Marketing\r\n \r\nThe idea of viral marketing of passing along the selling message has been started for a long now. Steve Jurvetson, a business capitalist was the first man who was recognized to use viral marketing to illustrate Hotmail’s selling practice. This practice was designed to use an advertisement of itself on message which is expressed using the service. When a receiver gets attracted and press the ad icon, it will open to hotmail’s site for you to sign up. This process will go on and on and develop is the same to cycle business marketing. From this moment, viral marketing has been developed into different types.\r\n \r\nIncentivised Viral Marketing\r\n \r\nIncentivised viral is the first type of marketing strategy that is used by most businesses in which they offered rewards or incentives when they refer somebody or to recruit to the company. This process becomes more effective when they referred person who intentionally want to get the reward. \r\n \r\nPass-along Strategy\r\n \r\nThis strategy is the most common type of viral marketing. It uses internet wherein the selling process takes on websites. The innovation asks the users to tell-a- friend about the service or products. Most companies use this strategy since it offers a convenient way of marketing. However, the drawback of this strategy is there is a risk of the message being recognized as a spam. The purpose of the spam is to repeatedly remind the users about the service or products being offered. \r\n \r\nBuzz Marketing\r\n \r\nThis strategy is being used in the entertainment world. Controversies is the best example of this strategy since it boost the interest of people such as involving stars of the commercial that not yet released. Buzz marketing aid the business to get the attention of the public people.', 'uploads/article/cover11.jpg', '2012-02-10 03:54:28', 1, 0, 0, 1, 0, 1),
(14, 'Lorem', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras rhoncus urna ut lectus lacinia lacinia. Ut et justo nec nulla aliquam consectetur at quis risus. Phasellus non sem ut nisi lacinia tincidunt. Sed laoreet volutpat lorem eu viverra. Morbi molestie fringilla lorem, quis auctor sapien malesuada nec. Donec tortor lacus, placerat ac sodales vel, fermentum ac lorem. Quisque eu condimentum leo. Vestibulum sodales porttitor turpis id porta. Curabitur condimentum porttitor eleifend. Donec pretium purus faucibus sem suscipit quis auctor magna feugiat. Praesent quis orci in neque iaculis consectetur. Sed eleifend vehicula pulvinar.\r\n\r\nAenean consequat tempor lacus eleifend aliquet. Pellentesque feugiat purus nec purus eleifend ac gravida urna cursus. Phasellus ac est eu tortor imperdiet pharetra. In fringilla, eros at luctus fringilla, quam nulla rutrum arcu, vel commodo lectus magna ut sem. Duis tempus dapibus neque sit amet interdum. Aenean sit amet lacus risus, posuere scelerisque lectus. Duis vitae orci commodo eros sollicitudin dictum ut nec nulla. Nullam sed leo massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Pellentesque in nisi vitae libero mollis dictum. Praesent vestibulum sem eget purus sagittis porta. Mauris orci massa, euismod nec gravida non, blandit vel justo. Duis nec lacus convallis est dictum fringilla ac ut felis. Donec imperdiet ultricies mauris, in placerat orci aliquet nec. Donec ultrices, justo a placerat pellentesque, nisi mi hendrerit dolor, nec fermentum sem purus at massa. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae', 'uploads/article/bookcover2.jpg', '2012-03-29 06:35:08', 1, 0, 0, 4, 0, 1),
(15, 'Lorem Standard', '<h3>The standard Lorem Ipsum passage, used since the 1500s</h3>\r\n<p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>\r\n<h3>Section 1.10.32 of "de Finibus Bonorum et Malorum", written by Cicero in 45 BC</h3>\r\n<p>"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?"</p>\r\n<h3>1914 translation by H. Rackham</h3>\r\n<p>"But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?"</p>', 'uploads/article/cover-page1.png', '2012-03-30 04:06:38', 1, 0, 0, 4, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `mj_learn_article_category`
--

CREATE TABLE IF NOT EXISTS `mj_learn_article_category` (
  `la_cat_id` int(10) NOT NULL auto_increment,
  `la_cat_name` varchar(70) NOT NULL,
  PRIMARY KEY  (`la_cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `mj_learn_article_category`
--

INSERT INTO `mj_learn_article_category` (`la_cat_id`, `la_cat_name`) VALUES
(1, 'small business'),
(2, 'Retail Store Ideas'),
(3, 'Free Business Ideas'),
(4, 'How to');

-- --------------------------------------------------------

--
-- Table structure for table `mj_learn_comment`
--

CREATE TABLE IF NOT EXISTS `mj_learn_comment` (
  `la_comment_id` int(10) NOT NULL auto_increment,
  `la_usr_id_fk` int(10) NOT NULL,
  `la_comment_body` varchar(250) NOT NULL,
  `la_comment_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `la_id_fk` int(10) NOT NULL,
  PRIMARY KEY  (`la_comment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `mj_learn_comment`
--

INSERT INTO `mj_learn_comment` (`la_comment_id`, `la_usr_id_fk`, `la_comment_body`, `la_comment_date`, `la_id_fk`) VALUES
(2, 1, 'Nice post!', '2012-02-07 09:58:49', 1),
(3, 1, 'This is nice!', '2012-02-07 10:02:20', 2),
(4, 1, 'Yes! sure this is nice post!', '2012-02-07 10:03:38', 1),
(5, 1, 'Another comment..', '2012-02-07 10:08:17', 1),
(6, 1, 'Why...', '2012-02-07 10:09:04', 1),
(7, 1, 'yes! why why...', '2012-02-07 10:09:15', 1),
(8, 1, 'is it true?', '2012-02-07 10:10:38', 1),
(9, 1, 'Finally...', '2012-02-07 10:11:20', 1),
(10, 1, 'Thanks!', '2012-02-07 10:14:20', 3),
(11, 2, 'Sure. we can start business now!', '2012-02-16 07:26:48', 2),
(12, 2, 'Yeah!', '2012-02-16 07:27:41', 3),
(13, 0, 'Thanks for the article', '2012-02-26 23:53:36', 4),
(14, 0, 'this is nice!', '2012-02-27 08:30:18', 8),
(15, 0, 'zzzzzzz', '2012-02-27 08:30:43', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mj_market_category`
--

CREATE TABLE IF NOT EXISTS `mj_market_category` (
  `mrket_cat_id` int(10) NOT NULL auto_increment,
  `mrket_cat_name` varchar(70) NOT NULL,
  PRIMARY KEY  (`mrket_cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `mj_market_category`
--

INSERT INTO `mj_market_category` (`mrket_cat_id`, `mrket_cat_name`) VALUES
(1, 'Electronic'),
(2, 'Vehicles'),
(3, 'Cars'),
(4, 'Motorcycles'),
(5, 'Car Accessories & Parts'),
(6, 'Other Vehicles'),
(7, 'Apartments'),
(8, 'Houses'),
(9, 'Land'),
(10, 'Rooms'),
(11, 'Mobile Phones'),
(12, 'Tablet & Gadgets'),
(13, 'Computers & Laptops'),
(14, 'Watches'),
(15, 'Clothes'),
(16, 'Collectibles'),
(17, 'Office Equipment'),
(18, 'Jobs'),
(19, 'Services');

-- --------------------------------------------------------

--
-- Table structure for table `mj_market_media`
--

CREATE TABLE IF NOT EXISTS `mj_market_media` (
  `mmm_id` int(11) NOT NULL auto_increment,
  `mmm_path` text NOT NULL,
  `mmm_mp_id_fk` int(11) NOT NULL,
  PRIMARY KEY  (`mmm_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `mj_market_media`
--

INSERT INTO `mj_market_media` (`mmm_id`, `mmm_path`, `mmm_mp_id_fk`) VALUES
(3, 'uploads/market/19653391091296664915.png', 14),
(5, 'uploads/market/car.jpg', 2),
(6, 'uploads/market/398399_214997518594931_79362180_n.jpg', 14),
(8, 'uploads/market/perakniaga.jpg', 16),
(9, 'uploads/market/606-black.jpg', 16),
(10, 'uploads/market/606-blue.jpg', 16),
(11, 'uploads/market/606-pink.jpg', 16),
(12, 'uploads/market/606-rainbow.jpg', 16),
(13, 'uploads/market/606-silver.jpg', 16),
(14, 'uploads/market/606-yellow.jpg', 16),
(15, 'uploads/market/sony.jpg', 17),
(16, 'uploads/market/psp-phone.jpg', 17),
(17, 'uploads/market/nokia-5800-xpressmusic-2.jpg', 18),
(18, 'uploads/market/imac.png', 19),
(19, 'uploads/market/apple-imac-2010.jpg', 19);

-- --------------------------------------------------------

--
-- Table structure for table `mj_market_post`
--

CREATE TABLE IF NOT EXISTS `mj_market_post` (
  `mrket_post_id` int(10) NOT NULL auto_increment,
  `mrket_usr_id_fk` int(10) NOT NULL,
  `mrket_post_title` varchar(40) NOT NULL,
  `mrket_post_body` text NOT NULL,
  `mrket_post_picture` text NOT NULL,
  `market_dateposted` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `market_mms_id_fk` int(11) default NULL,
  `mrket_cat_id_fk` int(10) NOT NULL,
  `mrket_state_id_fk` int(10) NOT NULL,
  `mrket_post_published` int(2) default NULL,
  `mrket_rat_up` int(2) default NULL,
  `mrket_rat_down` int(2) default NULL,
  `market_view` int(11) default NULL,
  `mrket_price` int(7) NOT NULL,
  `market_featured` int(1) default NULL,
  PRIMARY KEY  (`mrket_post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `mj_market_post`
--

INSERT INTO `mj_market_post` (`mrket_post_id`, `mrket_usr_id_fk`, `mrket_post_title`, `mrket_post_body`, `mrket_post_picture`, `market_dateposted`, `market_mms_id_fk`, `mrket_cat_id_fk`, `mrket_state_id_fk`, `mrket_post_published`, `mrket_rat_up`, `mrket_rat_down`, `market_view`, `mrket_price`, `market_featured`) VALUES
(1, 1, 'Product 1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris erat libero, blandit vitae lobortis sed, convallis sed libero. Curabitur sapien massa, mattis et scelerisque aliquam, laoreet eu enim. Nulla facilisi. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam quis orci placerat mauris dictum ullamcorper. Vestibulum facilisis adipiscing congue. Etiam accumsan pretium nibh sit amet vehicula. ', 'uploads/market/1-February-3-2012-4-09-13-pm-68.jpg', '2012-03-20 08:19:24', NULL, 13, 1, 1, NULL, NULL, 13, 1200, 0),
(2, 1, 'Product 2', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris erat libero, blandit vitae lobortis sed, convallis sed libero. Curabitur sapien massa, mattis et scelerisque aliquam, laoreet eu enim. Nulla facilisi. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam quis orci placerat mauris dictum ullamcorper. Vestibulum facilisis adipiscing congue. Etiam accumsan pretium nibh sit amet vehicula. ', 'uploads/market/1-February-3-2012-4-10-08-pm-108.jpg', '2012-03-21 04:54:29', NULL, 1, 1, 1, NULL, NULL, 32, 8000, 0),
(3, 1, 'Product 3', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris erat libero, blandit vitae lobortis sed, convallis sed libero. Curabitur sapien massa, mattis et scelerisque aliquam, laoreet eu enim. Nulla facilisi. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam quis orci placerat mauris dictum ullamcorper. Vestibulum facilisis adipiscing congue. Etiam accumsan pretium nibh sit amet vehicula. ', 'uploads/market/1-February-3-2012-4-10-28-pm-25420_D40_right.png', '2012-03-20 09:30:37', 4, 12, 1, 1, NULL, NULL, 22, 2300, 0),
(4, 1, 'Product 4', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris erat libero, blandit vitae lobortis sed, convallis sed libero. Curabitur sapien massa, mattis et scelerisque aliquam, laoreet eu enim. Nulla facilisi. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam quis orci placerat mauris dictum ullamcorper. Vestibulum facilisis adipiscing congue. Etiam accumsan pretium nibh sit amet vehicula. ', 'uploads/market/1-February-3-2012-4-10-52-pm-Dell_XPS_M1330_PRODUCT_RED-.jpg', '2012-03-20 08:19:24', NULL, 13, 1, 1, NULL, NULL, 14, 200, 0),
(5, 1, 'product 5', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris erat libero, blandit vitae lobortis sed, convallis sed libero. Curabitur sapien massa, mattis et scelerisque aliquam, laoreet eu enim. Nulla facilisi. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam quis orci placerat mauris dictum ullamcorper. Vestibulum facilisis adipiscing congue. Etiam accumsan pretium nibh sit amet vehicula. Kasut', 'uploads/market/1-February-3-2012-4-11-12-pm-huf-converse-product-red-skidgrip-1.jpg', '2012-03-20 08:19:24', NULL, 1, 1, 1, NULL, NULL, 10, 1600, 0),
(6, 1, 'product 6', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris erat libero, blandit vitae lobortis sed, convallis sed libero. Curabitur sapien massa, mattis et scelerisque aliquam, laoreet eu enim. Nulla facilisi. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam quis orci placerat mauris dictum ullamcorper. Vestibulum facilisis adipiscing congue. Etiam accumsan pretium nibh sit amet vehicula. ', 'uploads/market/1-February-3-2012-4-11-38-pm-product-red-ipod-mock2.gif', '2012-03-20 08:19:24', NULL, 1, 1, 1, NULL, NULL, 10, 4100, 0),
(7, 1, 'Product 7', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris erat libero, blandit vitae lobortis sed, convallis sed libero. Curabitur sapien massa, mattis et scelerisque aliquam, laoreet eu enim. Nulla facilisi. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam quis orci placerat mauris dictum ullamcorper. Vestibulum facilisis adipiscing congue. Etiam accumsan pretium nibh sit amet vehicula. Macbook Pro', 'uploads/market/1-February-3-2012-4-12-15-pm-software_box_and_all_cd.jpg', '2012-03-21 04:54:24', 5, 1, 1, 1, NULL, NULL, 28, 600, 0),
(8, 1, 'House Leasing', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis congue risus sit amet quam condimentum a luctus sem porta. Aliquam risus sem, dapibus eu bibendum vel, facilisis vel sapien. In sed est nulla, tempor elementum libero. Sed scelerisque consectetur commodo. Suspendisse at felis metus, sed vulputate dui. ', 'uploads/market/1-February-3-2012-6-27-48-pm-bungalow-athyma-villa-2-phase-10a-perspective.jpg', '2012-03-20 08:19:24', NULL, 1, 2, 1, 0, 0, 21, 2500000, 0),
(9, 1, 'Wedding', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis congue risus sit amet quam condimentum a luctus sem porta. Aliquam risus sem, dapibus eu bibendum vel, facilisis vel sapien. In sed est nulla, tempor elementum libero. Sed scelerisque consectetur commodo. Suspendisse at felis metus, sed vulputate dui. ', 'uploads/market/1-February-3-2012-6-28-13-pm-K-Tornado Productions Wedding Services.jpg', '2012-03-20 09:00:29', NULL, 2, 3, 1, 0, 0, 10, 500, 0),
(10, 1, 'For Sale', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis congue risus sit amet quam condimentum a luctus sem porta. Aliquam risus sem, dapibus eu bibendum vel, facilisis vel sapien. In sed est nulla, tempor elementum libero. Sed scelerisque consectetur commodo. Suspendisse at felis metus, sed vulputate dui. ', 'uploads/market/1-February-3-2012-6-28-41-pm-house.jpg', '2012-03-20 09:30:17', NULL, 1, 1, 1, 0, 0, 28, 210000, 0),
(14, 1, 'Product 123 Like New Very CHeap URGENT', '1223Desc4444444', 'uploads/market/398399_214997518594931_79362180_n.jpg', '2012-03-21 06:25:15', 4, 1, 1, 1, 0, 0, 165, 4444, 0),
(16, 27, 'Komputer Riba', '<p>Test Description komputer riba</p>', 'uploads/market/606-pink.jpg', '2012-03-26 01:58:03', NULL, 1, 1, 1, 0, 0, NULL, 1430, 0),
(17, 27, 'Sony Ericsson', '<p>Sony Ericsson</p>', 'uploads/market/sony.jpg', '2012-03-26 02:52:11', NULL, 11, 3, 1, 0, 0, NULL, 500, 0),
(18, 27, 'Nokia Music', '<p>Nokia Music Playable</p>', 'uploads/market/nokia-5800-xpressmusic-2.jpg', '2012-03-26 03:07:13', NULL, 11, 1, 1, 0, 0, NULL, 1200, 0),
(19, 27, 'iMac 27', '<p>iMac 27 Inch Multimedia</p>', 'uploads/market/apple-imac-2010.jpg', '2012-03-26 03:09:43', NULL, 13, 1, 1, 0, 0, NULL, 3400, 0);

-- --------------------------------------------------------

--
-- Table structure for table `mj_market_review`
--

CREATE TABLE IF NOT EXISTS `mj_market_review` (
  `mr_id` int(11) NOT NULL auto_increment,
  `mr_usr_id_fk` int(11) NOT NULL,
  `mr_reviewbody` varchar(255) NOT NULL,
  `mr_mpost_id_fk` int(11) NOT NULL,
  `mr_date_submited` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`mr_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `mj_market_review`
--

INSERT INTO `mj_market_review` (`mr_id`, `mr_usr_id_fk`, `mr_reviewbody`, `mr_mpost_id_fk`, `mr_date_submited`) VALUES
(1, 1, 'Very nice....', 8, '2012-02-24 15:18:17'),
(3, 1, 'how much can we offer this?', 8, '2012-02-25 09:28:06'),
(4, 1, 'OEM license?', 1, '2012-02-25 18:36:17'),
(5, 1, 'Kit set?', 3, '2012-02-25 18:36:42'),
(6, 1, 'looks like converse!', 5, '2012-02-26 06:34:17'),
(7, 1, 'Which area for this one?', 10, '2012-02-26 06:35:01'),
(8, 1, 'its old school!!!', 2, '2012-03-05 11:50:10'),
(9, 14, 'Dato Keramat', 10, '2012-03-09 22:10:49');

-- --------------------------------------------------------

--
-- Table structure for table `mj_market_store`
--

CREATE TABLE IF NOT EXISTS `mj_market_store` (
  `mms_id` int(10) NOT NULL auto_increment,
  `mms_name` text NOT NULL,
  `mms_usr_id_fk` int(10) NOT NULL,
  `mms_view` int(10) default NULL,
  PRIMARY KEY  (`mms_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `mj_market_store`
--

INSERT INTO `mj_market_store` (`mms_id`, `mms_name`, `mms_usr_id_fk`, `mms_view`) VALUES
(3, 'My Food Online Store', 24, 0),
(4, 'My Gadget Online Store', 1, 49),
(5, 'My Fruit Online Store', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mj_media`
--

CREATE TABLE IF NOT EXISTS `mj_media` (
  `med_id` int(10) NOT NULL auto_increment,
  `med_name` varchar(20) NOT NULL,
  `med_type` varchar(20) NOT NULL,
  `med_url` text NOT NULL,
  `med_time` timestamp NULL default NULL,
  `usr_id_fk` int(10) NOT NULL,
  `com_id_fk` int(10) NOT NULL,
  `ma_id_fk` int(10) default NULL,
  PRIMARY KEY  (`med_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mj_media_album`
--

CREATE TABLE IF NOT EXISTS `mj_media_album` (
  `ma_id` int(10) NOT NULL auto_increment,
  `ma_name` varchar(70) NOT NULL,
  `com_id_fk` int(10) default NULL,
  PRIMARY KEY  (`ma_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mj_message`
--

CREATE TABLE IF NOT EXISTS `mj_message` (
  `msg_id` int(10) NOT NULL auto_increment,
  `msg_thread_id` int(11) NOT NULL,
  `msg_to` int(10) NOT NULL,
  `msg_by_usr_id_fk` int(10) NOT NULL,
  `msg_body` text NOT NULL,
  `msg_status` int(2) NOT NULL,
  `msg_recieved_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`msg_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=82 ;

--
-- Dumping data for table `mj_message`
--

INSERT INTO `mj_message` (`msg_id`, `msg_thread_id`, `msg_to`, `msg_by_usr_id_fk`, `msg_body`, `msg_status`, `msg_recieved_date`) VALUES
(18, 3, 2, 1, 'Hello.', 0, '2012-02-14 03:59:22'),
(19, 4, 24, 1, 'test', 0, '2012-02-14 05:01:02'),
(20, 5, 3, 1, 'Hello!', 0, '2012-02-14 08:27:21'),
(21, 3, 1, 2, 'Hello to', 0, '2012-02-16 02:21:00'),
(22, 3, 1, 1, 'Where are you de?', 0, '2012-02-16 02:35:35'),
(23, 3, 1, 2, 'PWCT. Lai2..', 0, '2012-02-16 03:02:04'),
(24, 3, 1, 1, 'COming Later...', 0, '2012-02-16 03:04:08'),
(25, 3, 1, 2, 'okey dude', 0, '2012-02-16 03:08:18'),
(26, 3, 1, 2, 'dont forget to bring your laptop ya', 0, '2012-02-16 03:18:47'),
(27, 3, 2, 1, 'okey. see u there about 15 minutes. gud luck!', 0, '2012-02-16 03:20:54'),
(28, 3, 1, 2, 'make it faster dude!', 0, '2012-02-16 03:23:26'),
(29, 3, 1, 2, 'live streaming now! yahoooo', 0, '2012-02-16 03:23:53'),
(30, 3, 1, 2, 'watch me at youtube!\nhahahahahaha', 0, '2012-02-16 03:24:29'),
(31, 3, 2, 1, 'hahahahahaha', 0, '2012-02-16 03:25:03'),
(32, 3, 2, 1, 'check this! our future project', 0, '2012-02-16 03:28:19'),
(33, 6, 22, 1, 'Chech This project!', 0, '2012-02-16 03:53:33'),
(35, 5, 1, 3, 'Yes bro!', 0, '2012-02-16 04:21:13'),
(36, 6, 22, 1, 'Are you there?', 0, '2012-02-16 05:33:01'),
(37, 6, 1, 22, 'Yes. Iam here. :P Whattsupp dude?', 0, '2012-02-16 05:33:57'),
(38, 7, 3, 2, 'Lai2!', 0, '2012-02-16 05:37:56'),
(39, 7, 2, 3, 'mana?', 0, '2012-02-16 05:40:05'),
(40, 8, 23, 1, 'This friday are you free?', 0, '2012-02-16 05:44:04'),
(41, 8, 1, 23, 'Yes. why?', 0, '2012-02-16 06:02:10'),
(42, 9, 2, 23, 'hahaha done!', 0, '2012-02-16 06:55:51'),
(43, 7, 3, 2, 'PWTC', 0, '2012-02-16 06:56:21'),
(44, 9, 23, 2, 'Yes!', 0, '2012-02-16 06:56:36'),
(45, 8, 23, 1, 'Nothing ;-)', 0, '2012-02-17 07:30:52'),
(46, 6, 22, 1, 'nothing... :P', 0, '2012-02-24 11:50:02'),
(47, 4, 1, 24, 'joined. :)', 0, '2012-02-27 03:09:55'),
(48, 0, 0, 0, 'hahahaha', 0, '2012-02-27 08:27:51'),
(49, 0, 0, 0, 'lalala', 0, '2012-02-27 08:28:06'),
(50, 0, 0, 0, 'ok', 0, '2012-02-28 14:31:54'),
(51, 4, 24, 1, 'haha', 0, '2012-02-28 14:34:35'),
(52, 4, 24, 1, 'we got meeting?', 0, '2012-02-28 14:35:48'),
(53, 5, 3, 1, 'where u now?', 0, '2012-02-28 14:36:53'),
(54, 10, 25, 25, 'Woi!', 0, '2012-02-29 08:48:16'),
(55, 11, 14, 14, 'helloo....', 0, '2012-02-29 08:57:58'),
(56, 12, 14, 1, 'Heloooo agains. :)', 0, '2012-02-29 09:01:28'),
(57, 12, 1, 14, 'Yes. im here :P', 0, '2012-02-29 09:02:26'),
(58, 12, 14, 1, ':P', 0, '2012-02-29 09:43:11'),
(59, 8, 23, 1, 'lalalala', 0, '2012-03-03 12:29:54'),
(60, 6, 22, 1, 'lol', 0, '2012-03-03 20:40:20'),
(61, 13, 23, 25, 'Change your profile picture please! :P', 0, '2012-03-07 04:38:12'),
(62, 14, 14, 2, 'Testing', 0, '2012-03-09 08:10:15'),
(63, 15, 24, 2, 'tesing message dz...', 0, '2012-03-09 08:11:27'),
(64, 16, 23, 2, 'nokia cheapest one!', 0, '2012-03-09 08:13:12'),
(65, 17, 22, 2, 'are u okey?', 0, '2012-03-09 08:13:43'),
(66, 18, 14, 1, 'message back!', 0, '2012-03-09 22:07:27'),
(67, 12, 14, 1, 'you got it?', 0, '2012-03-10 14:22:45'),
(68, 12, 1, 14, 'yes. i got it! how bout tmrow?', 0, '2012-03-10 14:42:54'),
(69, 12, 14, 1, 'yeah.', 0, '2012-03-10 14:43:44'),
(70, 4, 24, 1, 'zzzzzzz...', 0, '2012-03-10 14:44:45'),
(71, 19, 1, 27, 'hye :P', 0, '2012-03-11 00:11:17'),
(73, 21, 1, 27, 'we make profit share', 0, '2012-03-14 15:22:54'),
(74, 21, 27, 1, 'which profit share?', 0, '2012-03-14 15:23:58'),
(75, 21, 1, 27, 'your project asd', 0, '2012-03-14 15:24:36'),
(76, 21, 1, 27, 'hello..', 0, '2012-03-15 18:29:06'),
(77, 21, 27, 1, 'hello back', 0, '2012-03-16 01:52:29'),
(78, 21, 1, 27, 'hello agains :P', 0, '2012-03-16 01:54:30'),
(79, 22, 3, 27, 'hello mat', 0, '2012-03-16 01:56:41'),
(80, 22, 27, 3, 'yes hello.', 0, '2012-03-16 01:56:59'),
(81, 22, 3, 27, 'hello......', 0, '2012-03-16 01:58:50');

-- --------------------------------------------------------

--
-- Table structure for table `mj_message_thread`
--

CREATE TABLE IF NOT EXISTS `mj_message_thread` (
  `mt_id` int(11) NOT NULL auto_increment,
  `mt_received` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`mt_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `mj_message_thread`
--

INSERT INTO `mj_message_thread` (`mt_id`, `mt_received`) VALUES
(3, '2012-02-14 03:59:22'),
(4, '2012-02-14 05:01:02'),
(5, '2012-02-14 08:27:21'),
(6, '2012-02-16 03:53:33'),
(7, '2012-02-16 05:37:56'),
(8, '2012-02-16 05:44:04'),
(9, '2012-02-16 06:55:51'),
(10, '2012-02-29 08:48:16'),
(11, '2012-02-29 08:57:58'),
(12, '2012-02-29 09:01:28'),
(13, '2012-03-07 04:38:12'),
(14, '2012-03-09 08:10:15'),
(15, '2012-03-09 08:11:27'),
(16, '2012-03-09 08:13:12'),
(17, '2012-03-09 08:13:43'),
(18, '2012-03-09 22:07:27'),
(19, '2012-03-11 00:11:17'),
(20, '2012-03-14 15:21:09'),
(21, '2012-03-14 15:22:54'),
(22, '2012-03-16 01:56:41');

-- --------------------------------------------------------

--
-- Table structure for table `mj_network`
--

CREATE TABLE IF NOT EXISTS `mj_network` (
  `mn_id` int(11) NOT NULL auto_increment,
  `mn_name` varchar(100) NOT NULL,
  `mn_desc` text,
  `mn_date_created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `mn_published` int(11) NOT NULL,
  `mn_created_by` int(11) NOT NULL,
  PRIMARY KEY  (`mn_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=58 ;

--
-- Dumping data for table `mj_network`
--

INSERT INTO `mj_network` (`mn_id`, `mn_name`, `mn_desc`, `mn_date_created`, `mn_published`, `mn_created_by`) VALUES
(17, 'Cili', NULL, '2012-02-09 16:09:52', 1, 1),
(19, 'Cyber Cafe', NULL, '2012-02-09 16:55:06', 1, 3),
(20, 'Ikan Keli', NULL, '2012-02-10 04:37:08', 1, 3),
(21, 'Getah Bikam', NULL, '2012-02-13 11:15:52', 1, 1),
(22, 'Remote Control Room', NULL, '2012-02-13 11:19:18', 1, 1),
(23, 'Snooker Table Bundle', NULL, '2012-02-13 11:24:37', 1, 3),
(24, 'Cheap Office Config', NULL, '2012-02-13 11:25:57', 1, 3),
(25, 'Lets go', NULL, '2012-02-13 12:26:56', 1, 1),
(26, 'Android', NULL, '2012-02-13 12:32:51', 1, 1),
(27, 'Business Listing', NULL, '2012-02-14 01:18:58', 1, 1),
(28, 'Insurance', NULL, '2012-02-14 04:56:38', 1, 24),
(29, 'Business Intelligent', NULL, '2012-02-14 11:01:00', 1, 2),
(30, 'Apple Fan', NULL, '2012-02-22 14:33:57', 1, 1),
(36, 'Dell Alienware', NULL, '2012-02-22 14:39:25', 1, 1),
(37, 'iOS', NULL, '2012-02-22 14:42:29', 1, 1),
(38, 'Alfa', NULL, '2012-02-22 14:48:20', 1, 1),
(39, 'Ice Cream', NULL, '2012-02-22 14:51:38', 1, 2),
(40, 'Samsung', NULL, '2012-02-22 14:56:31', 1, 2),
(41, 'Toshiba Network', NULL, '2012-02-22 15:07:19', 1, 2),
(42, 'NEC Group', NULL, '2012-02-22 15:17:55', 1, 2),
(43, 'Makeup Artists', NULL, '2012-02-23 12:01:23', 1, 14),
(44, 'Al-Islam Medical Centre', NULL, '2012-02-26 08:08:16', 1, 1),
(45, 'Family Business', 'Desciription new family business here', '2012-02-26 08:12:07', 1, 1),
(46, 'AtoZ', NULL, '2012-02-26 08:13:04', 1, 1),
(47, 'Perodoa MyVi', NULL, '2012-02-26 08:41:21', 1, 1),
(48, 'Innovatis', NULL, '2012-02-27 08:22:51', 1, 1),
(49, 'CS group', NULL, '2012-02-28 14:52:21', 1, 1),
(50, 'Beginner Haruan', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam imperdiet adipiscing turpis sed fringilla. Curabitur et metus nulla. Fusce pellentesque egestas lorem, sed tristique diam bibendum ac. Praesent rhoncus fermentum odio, non euismod tortor facilisis vitae. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nullam pulvinar tincidunt felis, eu faucibus orci dapibus nec. Fusce auctor mollis tempor. Ut magna massa, sagittis sit amet porta vitae, vulputate nec nibh. Sed consectetur imperdiet lacus sed bibendum. Nulla facilisi. Mauris hendrerit placerat augue posuere consequat. Pellentesque scelerisque mi a nisl pulvinar a laoreet tortor vulputate.', '2012-02-28 17:03:42', 1, 25),
(51, 'Testing Group', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\n			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\n			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\n			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\n			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\n			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2012-03-09 03:31:31', 1, 1),
(52, 'Dell Group', '', '2012-03-09 08:52:09', 1, 2),
(53, 'Teh Boh Group', '', '2012-03-09 08:53:50', 1, 2),
(54, 'Kobis Bunga Solution', '', '2012-03-09 08:55:19', 1, 2),
(55, 'Ikan Keli Kulim', 'Kulim, Kedah.', '2012-03-09 17:30:12', 1, 1),
(56, 'New group', '', '2012-03-09 19:40:03', 1, 1),
(57, 'Money', 'alway money fo life!', '2012-03-09 19:55:55', 1, 25);

-- --------------------------------------------------------

--
-- Table structure for table `mj_network_comment`
--

CREATE TABLE IF NOT EXISTS `mj_network_comment` (
  `nc_id` int(11) NOT NULL auto_increment,
  `nc_wall_id_fk` int(11) NOT NULL,
  `nc_body` text NOT NULL,
  `nc_comment_by` int(11) NOT NULL,
  `nc_date_posted` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`nc_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=104 ;

--
-- Dumping data for table `mj_network_comment`
--

INSERT INTO `mj_network_comment` (`nc_id`, `nc_wall_id_fk`, `nc_body`, `nc_comment_by`, `nc_date_posted`) VALUES
(2, 20, 'Jom2..', 1, '2012-02-13 23:15:00'),
(3, 7, 'Testing...', 1, '2012-02-14 01:09:16'),
(4, 6, 'Yes. of course!', 1, '2012-02-14 01:11:07'),
(5, 5, 'which shop ya?', 1, '2012-02-14 01:12:52'),
(6, 2, 'Details please', 1, '2012-02-14 01:17:47'),
(7, 1, 'i will invite all my friends to join this network. Cheer', 1, '2012-02-14 01:18:25'),
(8, 5, 'Near Dataran Ipoh. :-)', 22, '2012-02-14 01:22:31'),
(9, 2, 'Check your inbox. already PMed you. :)', 2, '2012-02-14 01:46:43'),
(10, 22, 'ok join', 24, '2012-02-14 05:00:07'),
(11, 22, 'jom', 1, '2012-02-14 05:01:50'),
(12, 23, 'i like', 1, '2012-02-14 05:02:02'),
(13, 22, 'Apa yg menarik ni?', 2, '2012-02-16 05:36:11'),
(14, 23, 'i lilke too!', 2, '2012-02-16 05:36:50'),
(15, 7, 'It just work! :P', 2, '2012-02-16 07:19:04'),
(24, 7, 'yeah', 1, '2012-02-16 15:03:49'),
(26, 7, 'where?', 2, '2012-02-22 15:17:07'),
(27, 1, 'agains...it does not work anymore...', 2, '2012-02-22 15:17:35'),
(28, 31, 'be the first la!', 2, '2012-02-22 15:19:51'),
(29, 33, 'Yahooo!', 2, '2012-02-23 02:02:15'),
(30, 30, 'we have a bug here...', 2, '2012-02-23 02:03:05'),
(31, 6, 'hahahahaha', 2, '2012-02-23 03:27:58'),
(32, 1, 'which one....?', 14, '2012-02-23 12:03:58'),
(33, 15, '..........', 1, '2012-02-24 11:49:42'),
(34, 20, 'lol.....', 1, '2012-02-26 08:00:21'),
(35, 42, 'developer....', 1, '2012-02-26 08:16:23'),
(36, 42, '............', 1, '2012-02-28 14:39:18'),
(37, 42, 'lalalalal', 1, '2012-03-08 11:36:10'),
(38, 7, 'Pizza Lai...', 1, '2012-03-08 11:43:35'),
(39, 38, 'lol', 1, '2012-03-08 11:45:14'),
(40, 15, 'zzzzzzzzzzzzzzzzzzzzzzzzz', 1, '2012-03-08 11:47:19'),
(41, 19, 'lalalalala', 1, '2012-03-08 11:49:02'),
(42, 54, 'hohohohohoho', 1, '2012-03-09 04:09:23'),
(43, 49, 'hahahah apa merepek ni', 2, '2012-03-09 09:19:36'),
(44, 7, 'when?', 2, '2012-03-09 09:22:53'),
(45, 1, 'PLV maybe?', 2, '2012-03-09 09:23:12'),
(46, 5, 'i forgot the things', 2, '2012-03-09 09:26:28'),
(47, 49, 'mmg merepek pn', 1, '2012-03-09 19:22:00'),
(48, 7, 'tomorrow bai', 1, '2012-03-09 19:22:15'),
(49, 1, 'hahaha', 1, '2012-03-09 19:22:29'),
(50, 6, 'generate profit!', 1, '2012-03-09 19:23:17'),
(51, 34, 'hellooo...', 1, '2012-03-09 19:23:27'),
(52, 58, 'testing', 1, '2012-03-09 19:38:13'),
(53, 59, '.............', 1, '2012-03-09 19:43:28'),
(54, 59, 'zzzzzzzzzzzz', 1, '2012-03-09 19:43:35'),
(55, 59, 'zzzzzz', 1, '2012-03-09 19:43:41'),
(56, 59, 'zzzzzzzzzz', 1, '2012-03-09 19:43:47'),
(57, 59, 'aaaaaaaaa', 1, '2012-03-09 19:43:56'),
(58, 64, 'zzzzzzzz', 25, '2012-03-09 19:58:25'),
(59, 63, 'zzzz', 25, '2012-03-09 20:08:18'),
(60, 62, 'aaaaaa', 25, '2012-03-09 20:10:09'),
(61, 62, 'sssssssssssss', 25, '2012-03-09 20:10:16'),
(62, 62, 'sssssssssssss', 25, '2012-03-09 20:10:22'),
(63, 62, 'is it okey?', 25, '2012-03-09 20:10:40'),
(64, 62, 'i think so...', 25, '2012-03-09 20:10:49'),
(65, 62, 'yeahh....!', 25, '2012-03-09 20:10:53'),
(66, 62, 'yahoooo!', 25, '2012-03-09 20:10:57'),
(67, 63, 'and always!', 25, '2012-03-09 20:11:04'),
(68, 63, 'yahoooo!', 25, '2012-03-09 20:11:08'),
(69, 63, 'ye peee!', 25, '2012-03-09 20:11:13'),
(70, 69, '1 more thing', 25, '2012-03-09 20:11:41'),
(71, 69, 'and more thing', 25, '2012-03-09 20:11:49'),
(72, 70, 'zzzzzzzzzzzzz', 25, '2012-03-09 20:25:30'),
(73, 70, 'ssssssssssss', 25, '2012-03-09 20:25:34'),
(74, 70, 'ddddddddddddddddd', 25, '2012-03-09 20:25:37'),
(75, 70, 'wwwwwwwwwwwwwww', 25, '2012-03-09 20:25:40'),
(76, 70, 'wwwwwwwwwwwwwwwwwwwwwwwwwwwd', 25, '2012-03-09 20:25:44'),
(77, 70, 'wwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwww', 25, '2012-03-09 20:25:49'),
(78, 71, 'zzzzzzzzzzzzz', 25, '2012-03-09 20:36:21'),
(79, 76, 'zzzzzzzzzzz', 25, '2012-03-09 21:08:07'),
(80, 76, 'ssssssssss', 25, '2012-03-09 21:08:09'),
(81, 76, 'wwwwwwwww', 25, '2012-03-09 21:08:11'),
(82, 76, 'ddddddddd', 25, '2012-03-09 21:08:13'),
(83, 76, 'w', 25, '2012-03-09 21:08:16'),
(84, 76, 'd', 25, '2012-03-09 21:08:17'),
(85, 76, 'a', 25, '2012-03-09 21:08:19'),
(86, 76, 'u', 25, '2012-03-09 21:08:22'),
(87, 78, 'jom', 25, '2012-03-09 21:10:34'),
(88, 79, 'hurm...........', 25, '2012-03-09 21:18:23'),
(89, 79, 'try again', 25, '2012-03-09 21:19:26'),
(90, 81, 'when....', 25, '2012-03-09 21:27:02'),
(91, 82, 'au', 25, '2012-03-09 21:43:46'),
(92, 82, 'yo man', 25, '2012-03-09 21:43:50'),
(93, 83, 'zzz', 25, '2012-03-09 21:43:56'),
(94, 83, ':P', 25, '2012-03-09 21:43:59'),
(95, 83, 'hahahhaa', 25, '2012-03-09 21:44:03'),
(96, 85, 'agains', 25, '2012-03-09 21:45:14'),
(97, 59, 'lululul', 1, '2012-03-13 01:39:48'),
(98, 59, 'hahahahaha', 27, '2012-03-14 18:31:01'),
(99, 89, 'hahaha', 27, '2012-03-14 18:31:34'),
(100, 90, 'testing', 27, '2012-03-15 18:35:38'),
(101, 59, 'testing', 27, '2012-03-15 18:35:48'),
(102, 57, 'lalalalalal', 1, '2012-03-22 16:16:52'),
(103, 57, 'lulululu', 27, '2012-03-22 16:18:06');

-- --------------------------------------------------------

--
-- Table structure for table `mj_network_relation`
--

CREATE TABLE IF NOT EXISTS `mj_network_relation` (
  `mnr_id` int(11) NOT NULL auto_increment,
  `usr_id_fk` int(11) NOT NULL,
  `mn_id_fk` int(11) NOT NULL,
  `mnr_status` int(11) NOT NULL,
  PRIMARY KEY  (`mnr_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=74 ;

--
-- Dumping data for table `mj_network_relation`
--

INSERT INTO `mj_network_relation` (`mnr_id`, `usr_id_fk`, `mn_id_fk`, `mnr_status`) VALUES
(1, 1, 17, 1),
(2, 3, 19, 1),
(3, 2, 19, 1),
(4, 1, 19, 1),
(5, 22, 19, 1),
(6, 3, 20, 1),
(7, 1, 21, 1),
(8, 1, 22, 1),
(9, 3, 23, 1),
(10, 3, 24, 1),
(11, 1, 25, 1),
(12, 1, 26, 1),
(13, 1, 20, 1),
(14, 1, 27, 1),
(15, 24, 28, 1),
(16, 1, 28, 1),
(17, 2, 29, 1),
(18, 2, 28, 1),
(19, 24, 19, 1),
(20, 23, 19, 1),
(21, 14, 19, 1),
(22, 3, 29, 1),
(23, 1, 30, 1),
(24, 1, 31, 1),
(25, 1, 32, 1),
(26, 1, 33, 1),
(27, 1, 34, 1),
(28, 1, 35, 1),
(29, 1, 36, 1),
(30, 1, 37, 1),
(31, 1, 38, 1),
(32, 2, 39, 1),
(33, 2, 40, 1),
(34, 2, 41, 1),
(35, 2, 42, 1),
(36, 14, 43, 1),
(37, 1, 44, 1),
(38, 1, 45, 1),
(39, 1, 46, 1),
(40, 1, 47, 1),
(41, 1, 48, 1),
(42, 1, 49, 1),
(43, 25, 50, 1),
(44, 1, 50, 1),
(45, 1, 51, 1),
(46, 2, 52, 1),
(47, 2, 53, 1),
(48, 2, 54, 1),
(50, 25, 50, 0),
(51, 1, 55, 1),
(54, 25, 55, 0),
(63, 2, 55, 0),
(64, 23, 55, 0),
(65, 24, 55, 0),
(66, 3, 55, 0),
(67, 25, 19, 0),
(68, 1, 56, 1),
(69, 25, 57, 1),
(70, 23, 28, 0),
(72, 27, 56, 1),
(73, 27, 45, 1);

-- --------------------------------------------------------

--
-- Table structure for table `mj_network_wall`
--

CREATE TABLE IF NOT EXISTS `mj_network_wall` (
  `nw_id` int(11) NOT NULL auto_increment,
  `nw_ntwrk_group_id_fk` int(11) NOT NULL,
  `nw_post_title` text NOT NULL,
  `nw_posted_by` int(11) NOT NULL,
  `nw_date_posted` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`nw_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=93 ;

--
-- Dumping data for table `mj_network_wall`
--

INSERT INTO `mj_network_wall` (`nw_id`, `nw_ntwrk_group_id_fk`, `nw_post_title`, `nw_posted_by`, `nw_date_posted`) VALUES
(1, 19, 'Welcome to Cyber Cafe Network.. We discuss any question about Cyber Cafe here', 3, '2012-02-12 08:18:22'),
(2, 19, 'Cyber cafer for sale. contact me', 2, '2012-02-12 12:37:09'),
(3, 19, 'Nice to know this network', 1, '2012-02-12 16:03:41'),
(4, 17, 'Welcome!', 1, '2012-02-12 16:05:33'),
(5, 19, 'Go to lowyat, and level 2 shop. very cheap to get the equipment.', 22, '2012-02-12 16:08:02'),
(6, 19, 'They should know how to operate cyber cafe', 22, '2012-02-12 16:13:12'),
(7, 19, 'Ding!~', 3, '2012-02-13 12:17:45'),
(8, 22, 'Hello', 1, '2012-02-13 12:20:56'),
(9, 22, 'World', 1, '2012-02-13 12:22:13'),
(10, 22, 'Lets begin', 1, '2012-02-13 12:22:52'),
(11, 21, 'Bundle Sale. Strategies', 1, '2012-02-13 12:24:45'),
(12, 21, 'Buy new book how to manage your firm', 1, '2012-02-13 12:25:09'),
(13, 21, 'Hello world!', 1, '2012-02-13 12:25:38'),
(14, 21, 'World Hello!', 1, '2012-02-13 12:26:04'),
(15, 21, 'testing', 1, '2012-02-13 12:31:07'),
(16, 21, 'Agains', 1, '2012-02-13 12:31:21'),
(17, 21, 'And again.', 1, '2012-02-13 12:32:02'),
(18, 21, 'Lagi sekali', 1, '2012-02-13 12:32:17'),
(19, 26, 'Lets discuss Andorid here!', 1, '2012-02-13 18:22:53'),
(20, 20, 'Jom business Ikan Keli', 3, '2012-02-13 22:31:13'),
(21, 27, 'Share with us what your got', 1, '2012-02-14 01:19:15'),
(22, 28, 'insurance kereta baik punya', 24, '2012-02-14 04:59:58'),
(23, 28, 'life insurance world!!', 1, '2012-02-14 05:01:44'),
(24, 29, 'Now everyone can fly!', 2, '2012-02-16 07:20:52'),
(30, 41, 'TOshiba!', 2, '2012-02-22 15:15:14'),
(31, 42, 'We will able to access here :)', 2, '2012-02-22 15:18:11'),
(32, 40, 'Samsung Note', 2, '2012-02-22 16:36:29'),
(33, 39, 'Ice Cream Candy', 2, '2012-02-23 02:01:59'),
(34, 19, 'helloo....', 2, '2012-02-23 03:27:23'),
(35, 43, 'so cheap..', 14, '2012-02-23 12:02:26'),
(36, 37, 'Lets training!', 1, '2012-02-24 11:47:17'),
(37, 21, 'dan lagi...', 1, '2012-02-26 07:59:10'),
(38, 17, 'zzzzz', 1, '2012-02-26 08:01:06'),
(39, 27, 'any ideas?', 1, '2012-02-26 08:02:53'),
(40, 44, 'Very nice...', 1, '2012-02-26 08:08:44'),
(41, 46, 'Superb!', 1, '2012-02-26 08:13:14'),
(42, 30, 'Developer Release...', 1, '2012-02-26 08:15:48'),
(43, 47, 'orange?', 1, '2012-02-26 08:41:36'),
(44, 47, 'orange?', 1, '2012-02-26 08:43:16'),
(45, 47, 'lalalalala', 1, '2012-02-26 08:43:51'),
(46, 38, 'Alfa..', 1, '2012-02-27 08:22:26'),
(47, 47, 'hahaha sala la...', 1, '2012-02-28 14:38:38'),
(48, 48, 'our partner', 1, '2012-02-28 14:39:28'),
(49, 19, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam imperdiet adipiscing turpis sed fringilla. Curabitur et metus nulla. Fusce pellentesque egestas lorem, sed tristique diam bibendum ac. Praesent rhoncus fermentum odio, non euismod tortor facilisis vitae. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nullam pulvinar tincidunt felis, eu faucibus orci dapibus nec. Fusce auctor mollis tempor. Ut magna massa, sagittis sit amet porta vitae, vulputate nec nibh. Sed consectetur imperdiet lacus sed bibendum. Nulla facilisi. Mauris hendrerit placerat augue posuere consequat. Pellentesque scelerisque mi a nisl pulvinar a laoreet tortor vulputate.', 1, '2012-02-28 16:07:53'),
(50, 50, 'Haruan Berapa sekarang 1kg?', 1, '2012-02-29 11:47:47'),
(51, 20, 'Balakong ada port. Interested?', 1, '2012-03-08 11:39:20'),
(52, 47, 'yuhuuuuu', 1, '2012-03-08 11:45:38'),
(53, 37, 'New Season', 1, '2012-03-08 11:48:48'),
(54, 50, 'lalalalalalallaa', 1, '2012-03-09 04:08:54'),
(55, 19, 'Bundle sale at Leisure Mall!', 1, '2012-03-09 19:23:50'),
(56, 30, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, '2012-03-09 19:35:25'),
(57, 45, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, '2012-03-09 19:36:37'),
(58, 51, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, '2012-03-09 19:37:57'),
(59, 56, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, '2012-03-09 19:43:03'),
(60, 50, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 25, '2012-03-09 19:48:08'),
(61, 50, 'lululululu', 25, '2012-03-09 19:49:53'),
(62, 57, 'money for life!', 25, '2012-03-09 19:56:17'),
(63, 57, 'agains....', 25, '2012-03-09 19:57:36'),
(64, 57, 'lets try agains!', 25, '2012-03-09 19:58:16'),
(65, 57, 'again', 25, '2012-03-09 19:59:20'),
(66, 57, 'n again', 25, '2012-03-09 20:01:23'),
(67, 57, 'n agains', 25, '2012-03-09 20:01:51'),
(68, 57, 'zzzzz', 25, '2012-03-09 20:05:57'),
(69, 57, 'haiz...', 25, '2012-03-09 20:06:47'),
(70, 57, 'try...', 25, '2012-03-09 20:14:21'),
(71, 57, 'agains...', 25, '2012-03-09 20:36:11'),
(72, 57, 'try agains', 25, '2012-03-09 20:51:33'),
(73, 57, 'lai lai', 25, '2012-03-09 20:54:58'),
(74, 57, 'hmmm', 25, '2012-03-09 21:01:25'),
(75, 57, 'ngantok sudah....', 25, '2012-03-09 21:04:41'),
(76, 57, 'tdo jom...', 25, '2012-03-09 21:06:18'),
(77, 57, 'jom', 25, '2012-03-09 21:08:42'),
(78, 57, 'ok?', 25, '2012-03-09 21:09:29'),
(79, 57, 'wait....', 25, '2012-03-09 21:17:53'),
(80, 57, 'and try agains', 25, '2012-03-09 21:19:41'),
(81, 57, 'agains', 25, '2012-03-09 21:23:50'),
(82, 57, 'ssssssss', 25, '2012-03-09 21:27:10'),
(83, 57, 'wwwwwwwwww', 25, '2012-03-09 21:28:42'),
(84, 57, 'aw', 25, '2012-03-09 21:38:32'),
(85, 57, 'testing', 25, '2012-03-09 21:44:11'),
(86, 57, 'okey', 25, '2012-03-09 21:45:18'),
(87, 57, 'and agains', 25, '2012-03-09 21:48:09'),
(88, 50, 'testing', 25, '2012-03-09 21:51:41'),
(89, 56, 'lalalalala', 1, '2012-03-13 01:39:40'),
(90, 56, 'lol', 27, '2012-03-15 18:35:11'),
(91, 56, 'testing', 27, '2012-03-15 18:35:31'),
(92, 45, 'Any news?', 27, '2012-03-22 16:17:59');

-- --------------------------------------------------------

--
-- Table structure for table `mj_notification`
--

CREATE TABLE IF NOT EXISTS `mj_notification` (
  `noti_id` int(10) NOT NULL auto_increment,
  `noti_type_id_fk` int(10) NOT NULL,
  `mj_type_id_id_fk` int(11) default NULL,
  `mj_group_id_fk` int(11) default NULL,
  `noti_to_usr_id` int(2) default NULL,
  `noti_request_usr_id_fk` int(10) NOT NULL,
  `noti_datetime` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `noti_status` int(2) NOT NULL,
  PRIMARY KEY  (`noti_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=106 ;

--
-- Dumping data for table `mj_notification`
--

INSERT INTO `mj_notification` (`noti_id`, `noti_type_id_fk`, `mj_type_id_id_fk`, `mj_group_id_fk`, `noti_to_usr_id`, `noti_request_usr_id_fk`, `noti_datetime`, `noti_status`) VALUES
(18, 1, 0, NULL, 2, 1, '2012-02-16 23:24:43', 0),
(19, 1, 0, NULL, 24, 1, '2012-02-16 23:24:43', 0),
(20, 1, 0, NULL, 3, 1, '2012-02-16 23:24:43', 0),
(21, 1, 0, NULL, 1, 2, '2012-02-16 23:24:43', 0),
(22, 1, 0, NULL, 2, 1, '2012-02-16 23:24:43', 0),
(23, 1, 0, NULL, 1, 2, '2012-02-16 23:24:43', 0),
(24, 1, 0, NULL, 2, 1, '2012-02-16 23:24:43', 0),
(25, 1, 0, NULL, 1, 2, '2012-02-16 23:24:43', 0),
(26, 1, 0, NULL, 1, 2, '2012-02-16 23:24:43', 0),
(27, 1, 0, NULL, 2, 1, '2012-02-16 23:24:43', 0),
(28, 1, 0, NULL, 1, 2, '2012-02-16 23:24:43', 0),
(29, 1, 0, NULL, 1, 2, '2012-02-16 23:24:43', 0),
(30, 1, 0, NULL, 1, 2, '2012-02-16 23:24:43', 0),
(31, 1, 0, NULL, 2, 1, '2012-02-16 23:24:43', 0),
(32, 1, 0, NULL, 2, 1, '2012-02-16 23:24:43', 0),
(33, 1, 0, NULL, 22, 1, '2012-02-16 23:24:43', 0),
(34, 1, 0, NULL, 1, 3, '2012-02-16 23:24:43', 0),
(35, 1, 0, NULL, 22, 1, '2012-02-16 23:24:43', 0),
(36, 1, 0, NULL, 1, 22, '2012-02-16 23:24:43', 0),
(37, 1, 0, NULL, 3, 2, '2012-02-16 23:24:43', 0),
(38, 1, 0, NULL, 2, 3, '2012-02-16 23:24:43', 0),
(39, 1, 40, NULL, 23, 1, '2012-02-16 06:01:58', 0),
(40, 1, NULL, NULL, 1, 23, '2012-02-16 23:24:43', 0),
(41, 1, NULL, NULL, 2, 23, '2012-02-16 23:24:43', 0),
(42, 1, NULL, NULL, 3, 2, '2012-02-16 23:24:43', 0),
(43, 1, NULL, NULL, 23, 2, '2012-02-16 23:31:34', 0),
(44, 1, NULL, NULL, 23, 1, '2012-03-13 01:50:47', 0),
(45, 1, NULL, NULL, 22, 1, '2012-02-24 11:50:03', 1),
(46, 1, NULL, NULL, 1, 24, '2012-03-11 09:40:07', 0),
(47, 1, NULL, NULL, 0, 0, '2012-03-28 11:31:35', 0),
(48, 1, NULL, NULL, 0, 0, '2012-03-28 11:31:35', 0),
(49, 1, NULL, NULL, 0, 0, '2012-03-28 11:31:35', 0),
(50, 1, NULL, NULL, 24, 1, '2012-03-16 12:25:45', 0),
(51, 1, NULL, NULL, 24, 1, '2012-03-16 12:25:45', 0),
(52, 1, NULL, NULL, 3, 1, '2012-03-13 10:34:19', 0),
(53, 1, 54, NULL, 25, 25, '2012-02-29 10:55:16', 0),
(54, 1, 55, NULL, 14, 14, '2012-02-29 09:02:08', 0),
(55, 1, 56, NULL, 14, 1, '2012-02-29 09:02:05', 0),
(56, 1, NULL, NULL, 1, 14, '2012-03-11 09:40:07', 0),
(57, 1, NULL, NULL, 14, 1, '2012-02-29 09:43:11', 1),
(58, 1, NULL, NULL, 23, 1, '2012-03-13 01:50:47', 0),
(59, 1, NULL, NULL, 22, 1, '2012-03-03 20:40:20', 1),
(60, 1, 61, NULL, 23, 25, '2012-03-13 01:50:47', 0),
(61, 1, 62, NULL, 14, 2, '2012-03-09 08:10:15', 1),
(62, 1, 63, NULL, 24, 2, '2012-03-16 12:25:45', 0),
(63, 1, 64, NULL, 23, 2, '2012-03-13 01:50:47', 0),
(64, 1, 65, NULL, 22, 2, '2012-03-09 08:13:43', 1),
(65, 6, 0, NULL, 25, 2, '2012-03-09 12:09:29', 0),
(66, 6, 0, NULL, 25, 2, '2012-03-09 12:23:21', 1),
(67, 6, 0, NULL, 25, 1, '2012-03-09 17:34:36', 1),
(68, 6, 0, NULL, 24, 1, '2012-03-16 12:25:45', 0),
(69, 6, 0, NULL, 25, 1, '2012-03-09 17:43:11', 1),
(70, 6, 0, NULL, 3, 1, '2012-03-13 10:34:19', 0),
(71, 6, 0, NULL, 23, 1, '2012-03-13 01:50:47', 0),
(72, 6, 0, NULL, 23, 1, '2012-03-13 01:50:47', 0),
(73, 6, 0, NULL, 2, 1, '2012-03-14 17:51:35', 0),
(74, 6, 0, NULL, 24, 1, '2012-03-16 12:25:45', 0),
(75, 6, 0, NULL, 24, 1, '2012-03-16 12:25:45', 0),
(76, 6, 0, NULL, 24, 1, '2012-03-16 12:25:45', 0),
(77, 6, 0, NULL, 2, 1, '2012-03-14 17:51:35', 0),
(78, 6, 0, NULL, 2, 1, '2012-03-14 17:51:35', 0),
(79, 6, 0, NULL, 23, 1, '2012-03-13 01:50:47', 0),
(80, 6, 0, NULL, 24, 1, '2012-03-16 12:25:45', 0),
(81, 6, 0, NULL, 3, 1, '2012-03-13 10:34:19', 0),
(82, 6, 0, NULL, 25, 1, '2012-03-09 19:22:47', 1),
(83, 1, 66, NULL, 14, 1, '2012-03-10 14:42:03', 0),
(84, 1, NULL, NULL, 14, 1, '2012-03-10 14:22:45', 1),
(85, 1, NULL, NULL, 1, 14, '2012-03-11 09:40:07', 0),
(86, 1, NULL, NULL, 14, 1, '2012-03-10 14:43:44', 1),
(87, 1, NULL, NULL, 24, 1, '2012-03-16 12:25:45', 0),
(88, 1, 71, NULL, 1, 27, '2012-03-11 00:28:00', 0),
(89, 6, 0, NULL, 23, 1, '2012-03-13 01:50:47', 0),
(90, 7, NULL, NULL, 27, 1, '2012-03-13 10:23:32', 0),
(91, 7, NULL, NULL, 27, 3, '2012-03-13 10:36:21', 0),
(92, 1, 72, NULL, 0, 0, '2012-03-28 11:31:35', 0),
(93, 1, 73, NULL, 1, 27, '2012-03-14 15:23:28', 0),
(94, 1, NULL, NULL, 27, 1, '2012-03-14 15:24:16', 0),
(95, 1, NULL, NULL, 1, 27, '2012-03-14 15:30:43', 0),
(96, 7, NULL, NULL, 27, 2, '2012-03-14 17:53:36', 0),
(98, 6, NULL, 56, 27, 1, '2012-03-14 18:05:51', 0),
(99, 1, NULL, NULL, 1, 27, '2012-03-16 01:52:12', 0),
(100, 1, NULL, NULL, 27, 1, '2012-03-16 01:57:14', 0),
(101, 1, NULL, NULL, 1, 27, '2012-03-20 03:29:56', 0),
(102, 1, 79, NULL, 3, 27, '2012-03-16 01:56:55', 0),
(103, 1, NULL, NULL, 27, 3, '2012-03-16 01:57:14', 0),
(104, 1, NULL, NULL, 3, 27, '2012-03-20 08:57:15', 0),
(105, 6, NULL, 45, 27, 1, '2012-03-22 16:17:22', 0);

-- --------------------------------------------------------

--
-- Table structure for table `mj_notification_type`
--

CREATE TABLE IF NOT EXISTS `mj_notification_type` (
  `noti_type_id` int(11) NOT NULL auto_increment,
  `noti_type_name` varchar(20) NOT NULL,
  PRIMARY KEY  (`noti_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `mj_notification_type`
--

INSERT INTO `mj_notification_type` (`noti_type_id`, `noti_type_name`) VALUES
(1, 'message'),
(2, 'idea'),
(3, 'market'),
(4, 'review'),
(5, 'commet'),
(6, 'group'),
(7, 'friend');

-- --------------------------------------------------------

--
-- Table structure for table `mj_nw_comment`
--

CREATE TABLE IF NOT EXISTS `mj_nw_comment` (
  `nwc_id` int(11) NOT NULL auto_increment,
  `nwc_body` text NOT NULL,
  `nwc_usr_id_fk` int(11) NOT NULL,
  `nwc_n_id_fk` int(11) NOT NULL,
  `nwc_posted` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`nwc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mj_pages`
--

CREATE TABLE IF NOT EXISTS `mj_pages` (
  `page_id` int(11) NOT NULL auto_increment,
  `page_title` varchar(200) NOT NULL,
  `page_content` text NOT NULL,
  `page_type` varchar(50) NOT NULL,
  PRIMARY KEY  (`page_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `mj_pages`
--

INSERT INTO `mj_pages` (`page_id`, `page_title`, `page_content`, `page_type`) VALUES
(1, 'Help and Support', '<p><strong>Get started</strong></p>\r\n<p><strong></strong>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n<p><strong><br /></strong></p>\r\n<p><strong>Learn more</strong></p>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n<p><strong><br /></strong></p>\r\n<p><strong>Fix a problem</strong></p>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>FAQs</strong></p>\r\n<ol>\r\n<li>Question 1</li>\r\n<li>Question 2</li>\r\n<li>Question 3</li>\r\n</ol>\r\n<p>&nbsp;</p>\r\n<p><strong>Need personal assistance?&nbsp;</strong></p>\r\n<p>Mojo offers paid phone support for US$39 per incident as well as other customized support options. Call 0324556799.</p>\r\n<p><br /><strong>Didn\\''t find what you were looking for?</strong></p>\r\n<p><span>Create a&nbsp;</span><a title=\\"support ticket\\" href=\\"../helpnsupport.php\\">support ticket</a><span>&nbsp;and our friendly support team will do their best to respond within 48 hours.</span></p>', 'Top'),
(2, 'Advertise with us', '<p><strong><span style=\\"font-size: xx-large;\\">Why advertise with us?</span></strong></p>', 'bottom'),
(3, 'How to submit a new post', '<p><span style=\\"font-size: x-large;\\"><strong>Idea Section</strong></span></p>\r\n<p><strong>Click Idea Section</strong><br /><strong>Click New Idea</strong><br /><strong>Fill up the form</strong><br /><strong>Click Preview before submit</strong><br /><strong>Click Submit &amp; Upload visual/image</strong><br /><strong>Done!</strong><br /><strong>Edit images/video</strong><br /><strong>Set Default Cover</strong></p>\r\n<p><strong><br /></strong></p>\r\n<p><span style=\\"font-size: x-large;\\"><strong>Project Section</strong></span></p>\r\n<p><strong>Click Idea Section</strong><br /><strong>Click New Idea</strong><br /><strong>Fill up the form</strong><br /><strong>Click Preview before submit</strong><br /><strong>Click Submit &amp; Upload visual / image</strong><br /><strong>Done!</strong><br /><strong>Edit images / video</strong><br /><strong>Set Default Cover</strong></p>\r\n<p><span><strong><br /></strong></span></p>\r\n<p><span style=\\"font-size: x-large;\\"><strong>Market Section</strong></span></p>\r\n<p><strong>Click Idea Section</strong><br /><strong>Click New Idea</strong><br /><strong>Fill up the form</strong><br /><strong>Click Preview before submit</strong><br /><strong>Click Submit &amp; Upload visual / image</strong><br /><strong>Done!</strong><br /><strong>Edit images / video</strong><br /><strong>Set Default Cover</strong></p>\r\n<p><strong><br /></strong></p>\r\n<p><strong><br /></strong></p>', 'Listing'),
(4, 'Submission Process', '<p><span style=\\"font-size: large;\\"><strong>Submission Process of each section</strong></span></p>', 'Listing');

-- --------------------------------------------------------

--
-- Table structure for table `mj_sector`
--

CREATE TABLE IF NOT EXISTS `mj_sector` (
  `sec_id` int(10) NOT NULL auto_increment,
  `sec_name` varchar(30) NOT NULL,
  PRIMARY KEY  (`sec_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `mj_sector`
--

INSERT INTO `mj_sector` (`sec_id`, `sec_name`) VALUES
(1, 'Information Technology'),
(2, 'Agriculture');

-- --------------------------------------------------------

--
-- Table structure for table `mj_services`
--

CREATE TABLE IF NOT EXISTS `mj_services` (
  `services_id` int(10) NOT NULL auto_increment,
  `services_name` varchar(30) NOT NULL,
  `sector_id_fk` int(11) default NULL,
  PRIMARY KEY  (`services_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `mj_services`
--

INSERT INTO `mj_services` (`services_id`, `services_name`, `sector_id_fk`) VALUES
(1, 'Software Development', 1),
(2, 'Farming', 2),
(3, 'Poultry Farming', 2);

-- --------------------------------------------------------

--
-- Table structure for table `mj_state`
--

CREATE TABLE IF NOT EXISTS `mj_state` (
  `state_id` int(10) NOT NULL auto_increment,
  `state_name` varchar(30) NOT NULL,
  PRIMARY KEY  (`state_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `mj_state`
--

INSERT INTO `mj_state` (`state_id`, `state_name`) VALUES
(1, 'selangor'),
(2, 'kuala lumpur'),
(3, 'perak');

-- --------------------------------------------------------

--
-- Table structure for table `mj_status`
--

CREATE TABLE IF NOT EXISTS `mj_status` (
  `status_id` int(10) NOT NULL auto_increment,
  `status_usr_id_fk` int(10) NOT NULL,
  `status_body` text NOT NULL,
  `status_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

--
-- Dumping data for table `mj_status`
--

INSERT INTO `mj_status` (`status_id`, `status_usr_id_fk`, `status_body`, `status_date`) VALUES
(4, 1, 'Finally. yahooo!', '2012-02-23 08:47:46'),
(5, 2, 'Qlik is better! lets do it now!!', '2012-02-23 08:48:29'),
(6, 3, 'we need more time!!!!!!!!!!!!!!!!', '2012-02-23 08:49:37'),
(7, 23, 'Im new here. can someone teach me?', '2012-02-23 08:50:29'),
(8, 22, 'any search engine developer here?', '2012-02-23 08:51:08'),
(9, 22, 'i need more resources. can some one support me?', '2012-02-23 08:51:28'),
(10, 22, 'hello there?', '2012-02-23 08:51:34'),
(11, 24, 'join our group now!', '2012-02-23 08:52:42'),
(12, 24, 'Innovatis network stream here. follow us now!', '2012-02-23 08:53:07'),
(13, 14, 'any secretary company here?', '2012-02-23 08:55:10'),
(14, 1, 'there have many bug to fix it....', '2012-02-23 09:41:34'),
(15, 1, 'zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz..........................................................................................................................................................................................', '2012-02-23 09:58:05'),
(16, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras eget arcu ut ante imperdiet semper. Suspendisse non lacus leo. Phasellus dignissim lacinia ipsum, nec condimentum erat ullamcorper ac. Etiam urna purus, sollicitudin ut adipiscing pharetra, mol', '2012-02-23 09:59:30'),
(17, 3, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras eget arcu ut ante imperdiet semper. Suspendisse non lacus leo. Phasellus dignissim lacinia ipsum, nec condimentum erat ullamcorper ac. Etiam urna purus, sollicitudin ut adipiscing pharetra, molestie id ipsum. Curabitur semper, mi ac commodo dictum, dui enim bibendum est, quis bibendum dolor purus nec mi. Suspendisse in libero diam. Nullam convallis luctus magna, quis cursus enim auctor eget.', '2012-02-23 10:00:47'),
(18, 3, 'Feeding some url http://www.lipsum.com/feed/html', '2012-02-23 10:01:34'),
(19, 14, 'zzzzzzzzzz....', '2012-02-23 12:00:18'),
(20, 1, 'it friday!', '2012-02-24 02:37:22'),
(21, 1, 'Jom jumaat!', '2012-02-24 04:57:44'),
(22, 1, 'lalalalalalala', '2012-02-24 04:58:16'),
(23, 1, 'time is running out!', '2012-02-24 04:58:51'),
(24, 2, 'its monday... :)', '2012-02-26 23:50:22'),
(25, 25, 'Im new!', '2012-02-28 05:28:27'),
(26, 25, 'Working now on MOJO Social Business! :P', '2012-02-28 05:47:47'),
(27, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin eu malesuada eros. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum placerat vehicula nulla in porttitor. Mauris eu quam purus. Ut sem elit, congue in sodales sit amet, tempus sit amet nibh. Vestibulum elit nibh, tempus eget placerat ac, porta et dui. Praesent euismod felis id est aliquet dictum bibendum lorem aliquam. Pellentesque rutrum, metus id tristique tristique, libero nisi consequat nunc, et fermentum lectus purus feugiat lacus. Ut viverra vehicula enim id sagittis', '2012-03-01 07:35:46'),
(28, 1, 'working on new interface now...', '2012-03-03 12:27:36'),
(29, 1, 'lalalalalala', '2012-03-03 12:27:51'),
(30, 1, 'having work now!', '2012-03-03 19:16:05'),
(31, 1, 'Let go dinner! Yeah', '2012-03-06 11:59:29'),
(32, 25, 'lalalalala', '2012-03-07 04:37:13'),
(33, 23, '@mahfudz where u now?', '2012-03-07 04:39:37'),
(34, 1, 'New look and feel! Yeah', '2012-03-07 11:42:28'),
(35, 3, 'Reseller Chili Melaka Contact us now!', '2012-03-07 11:44:26'),
(36, 2, 'looks better now!', '2012-03-07 15:48:37'),
(37, 1, 'Hello!', '2012-03-07 16:48:11'),
(38, 1, 'Flying Hanger 2 is so cool! Vote this product guys! http://localhost/v1/idea-details.php?id=1', '2012-03-07 17:05:46'),
(39, 2, 'Time! We should release beta version now.', '2012-03-09 08:38:00'),
(40, 25, 'jom solat and tido! yahoo', '2012-03-09 22:05:01'),
(41, 14, 'Im changing rite now! :)', '2012-03-09 22:09:28'),
(42, 1, 'Selesai sudah...yahoooo!', '2012-03-10 14:10:42'),
(43, 25, 'testing', '2012-03-10 16:29:34'),
(44, 27, 'Im new here!', '2012-03-10 16:43:23'),
(45, 1, '98% up to RC01', '2012-03-13 01:47:56'),
(46, 3, 'Welcome Alya!', '2012-03-14 17:41:42'),
(47, 27, 'I Got your timeline!', '2012-03-14 17:45:22'),
(48, 27, 'got another timeline! :P', '2012-03-14 17:50:36'),
(49, 1, 'i got too! :P', '2012-03-14 17:53:17'),
(50, 27, 'Lets tdo!', '2012-03-14 18:22:25'),
(51, 27, 'Agains..', '2012-03-14 18:24:40'),
(52, 27, 'agains...........', '2012-03-14 18:26:12'),
(53, 27, 'Testing agains', '2012-03-15 18:31:18'),
(54, 1, 'Beta version is out! please feel free to make a survey after you explore our site :)', '2012-03-16 12:22:46'),
(55, 1, 'Currently running now!', '2012-03-20 09:58:56');

-- --------------------------------------------------------

--
-- Table structure for table `mj_tours`
--

CREATE TABLE IF NOT EXISTS `mj_tours` (
  `tours_id` int(11) NOT NULL auto_increment,
  `tours_usr_id_fk` int(11) NOT NULL,
  `tours_section` int(1) NOT NULL,
  `tours_status` int(1) NOT NULL,
  PRIMARY KEY  (`tours_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `mj_tours`
--

INSERT INTO `mj_tours` (`tours_id`, `tours_usr_id_fk`, `tours_section`, `tours_status`) VALUES
(25, 1, 5, 0),
(24, 1, 4, 0),
(26, 1, 3, 0),
(27, 1, 2, 0),
(29, 1, 1, 0),
(30, 3, 5, 0),
(31, 3, 4, 0),
(32, 3, 3, 0),
(33, 3, 2, 0),
(34, 3, 1, 0),
(35, 0, 1, 0),
(36, 0, 3, 0),
(37, 2, 5, 0),
(38, 2, 4, 0),
(39, 2, 3, 0),
(40, 0, 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `mj_users`
--

CREATE TABLE IF NOT EXISTS `mj_users` (
  `usr_id` int(20) NOT NULL auto_increment,
  `usr_name` text NOT NULL,
  `usr_pwd` text NOT NULL,
  `usr_email` text NOT NULL,
  `user_pic` text,
  `usr_lvl` int(1) default NULL,
  `usr_acct_status` int(1) default NULL,
  `usr_cnfm_key` text,
  `usr_cnfrm_datetime` timestamp NULL default CURRENT_TIMESTAMP,
  `usr_last_login` text,
  `usr_workat` text,
  `usr_tel` text,
  `usr_general_info` text,
  `usr_core_activity` text,
  `usr_rating` int(11) default NULL,
  `mj_sector_fk` int(11) default NULL,
  `mj_services_fk` int(11) default NULL,
  `mj_state_fk` int(11) default NULL,
  `mj_country_id_fk` int(11) default NULL,
  PRIMARY KEY  (`usr_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `mj_users`
--

INSERT INTO `mj_users` (`usr_id`, `usr_name`, `usr_pwd`, `usr_email`, `user_pic`, `usr_lvl`, `usr_acct_status`, `usr_cnfm_key`, `usr_cnfrm_datetime`, `usr_last_login`, `usr_workat`, `usr_tel`, `usr_general_info`, `usr_core_activity`, `usr_rating`, `mj_sector_fk`, `mj_services_fk`, `mj_state_fk`, `mj_country_id_fk`) VALUES
(1, 'Mahfudz', '5f4dcc3b5aa765d61d8327deb882cf99', 'mahfudz@richcoremedia.com', 'uploads/avatar/fuz.jpg', 1, 1, NULL, '2012-01-20 12:04:18', '2012-04-3 4:07:29:pm', 'Entreprenuer', '0132465974', 'FInally, im become master!', 'Describe your core activity', 0, 1, 1, 1, 1),
(2, 'Fikri', '5f4dcc3b5aa765d61d8327deb882cf99', 'fikri.zainul@richcoremedia.com', 'uploads/avatar/fik.jpg', 0, 1, NULL, '2012-01-22 15:39:58', '2012-04-24 10:04:24:pm', 'Entreprenuer', '0132465974', 'FInally, im become master!', 'Describe your core activity', 0, 1, 1, 1, 1),
(3, 'Mat', '5f4dcc3b5aa765d61d8327deb882cf99', 'mat@richcoremedia.com', 'uploads/avatar/mat.jpg', 0, 1, NULL, '2012-02-06 04:45:31', '2012-04-3 4:08:18:pm', 'Entreprenuer', '0132465974', 'FInally, im become master!', 'Describe your core activity', 2, 2, 2, 3, 1),
(14, 'Ina Lucy', '5f4dcc3b5aa765d61d8327deb882cf99', 'umi@richcoremedia.com', 'uploads/avatar/161640_100000570330166_429534806_n.jpg', 0, 1, 'E5rxsLJR', '2012-02-09 05:01:39', '2012-03-10 10:43:06:pm', 'Entreprenuer', '0132465974', 'FInally, im become master!', 'Describe your core activity', 0, 1, 1, 1, 1),
(22, 'Fadzil', '5f4dcc3b5aa765d61d8327deb882cf99', 'fadzil@richcoremedia.com', 'uploads/avatar/padil.jpg', 0, 1, '2N6j9dFw', '2012-02-09 05:53:42', '2012-02-23 4:51:41:pm', 'Entreprenuer', '0132465974', 'FInally, im become master!', 'Describe your core activity', 0, 1, 1, 2, 1),
(23, 'Amirul', '5f4dcc3b5aa765d61d8327deb882cf99', 'amirul@gmail.com', 'uploads/avatar/372630_767273921_1616362642_n.jpg', 0, 1, 'QcnU7GwC', '2012-02-12 04:59:03', '2012-03-13 6:34:08:pm', 'Entreprenuer', '0132465974', 'FInally, im become master!', 'Describe your core activity', 0, 1, 1, 2, 1),
(24, 'dzairil', '5f4dcc3b5aa765d61d8327deb882cf99', 'dzairilimran@gmail.com', 'uploads/avatar/275957_1048190217_553472205_n.jpg', 0, 1, '3cw8xHUW', '2012-02-14 04:50:49', '2012-03-27 3:22:08:pm', 'Entreprenuer', '0', '0', 'Describe your core activity', 0, 1, 1, 2, 1),
(25, 'Ajib Afro', '5f4dcc3b5aa765d61d8327deb882cf99', 'razif@richcoremedia.com', 'uploads/avatar/41458_739312855_816469570_n.jpg', 0, 1, '5RuFhMoN', '2012-02-27 05:21:12', '2012-03-11 12:30:34:am', 'Entreprenuer', 'NULL', 'NULL', 'Describe your core activity', 0, 2, 2, 3, 1),
(26, 'Rafizi Hashim', '5f4dcc3b5aa765d61d8327deb882cf99', 'rafizi@gmail.com', 'uploads/avatar/49258_100000547742215_561071969_n.jpg', 0, 1, 'kU170P9F', '2012-02-27 05:28:00', '2012-03-7 12:30:29:pm', 'Entreprenuer', '012897362', 'Aku pembekal ikan keli di sg.petani', 'Describe your core activity', 0, 2, 3, 3, 1),
(27, 'Alya', '5f4dcc3b5aa765d61d8327deb882cf99', 'alya@gmail.com', 'uploads/avatar/2011-12-22_160604.png', 0, 1, 'iAT8Vcrt', '2012-03-10 16:31:40', '2012-03-30 11:47:33:am', 'Entreprenuer', '0', '0', 'Describe your core activity', 3, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `mj_usr_com_relation`
--

CREATE TABLE IF NOT EXISTS `mj_usr_com_relation` (
  `usrcomrelation_id` int(10) NOT NULL auto_increment,
  `usrcomrelation_usr_id_fk` int(10) NOT NULL,
  `com_id_fk` int(10) NOT NULL,
  PRIMARY KEY  (`usrcomrelation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mj_usr_network`
--

CREATE TABLE IF NOT EXISTS `mj_usr_network` (
  `usr_network_id` int(10) NOT NULL auto_increment,
  `usr_network_usr_id_fk` int(10) NOT NULL,
  `usr_network_friend_usr_id_fk` int(10) NOT NULL,
  `usr_network_approved` int(10) NOT NULL,
  PRIMARY KEY  (`usr_network_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;

--
-- Dumping data for table `mj_usr_network`
--

INSERT INTO `mj_usr_network` (`usr_network_id`, `usr_network_usr_id_fk`, `usr_network_friend_usr_id_fk`, `usr_network_approved`) VALUES
(1, 1, 2, 0),
(2, 2, 1, 0),
(3, 3, 1, 0),
(4, 3, 2, 0),
(5, 3, 14, 0),
(7, 3, 22, 0),
(8, 1, 23, 0),
(9, 24, 1, 0),
(11, 1, 3, 0),
(13, 2, 2, 0),
(14, 23, 1, 0),
(15, 22, 3, 0),
(16, 2, 3, 0),
(17, 23, 23, 1),
(19, 23, 2, 0),
(20, 2, 23, 0),
(21, 23, 3, 0),
(22, 3, 23, 0),
(23, 23, 14, 0),
(24, 14, 23, 0),
(25, 2, 22, 0),
(26, 22, 2, 0),
(27, 1, 24, 0),
(28, 2, 24, 0),
(29, 24, 2, 0),
(30, 2, 14, 0),
(31, 14, 2, 0),
(32, 1, 1, 0),
(33, 3, 3, 0),
(34, 14, 14, 0),
(35, 24, 3, 0),
(36, 3, 24, 0),
(37, 25, 25, 0),
(38, 26, 26, 0),
(40, 1, 25, 0),
(41, 25, 1, 0),
(42, 25, 24, 0),
(43, 24, 25, 0),
(44, 25, 2, 0),
(45, 2, 25, 0),
(46, 25, 14, 0),
(47, 14, 25, 0),
(48, 27, 27, 0),
(53, 1, 27, 0),
(54, 27, 1, 0),
(55, 3, 27, 0),
(56, 27, 3, 0),
(57, 2, 27, 0),
(58, 27, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `_company`
--

CREATE TABLE IF NOT EXISTS `_company` (
  `comp_id` int(11) NOT NULL auto_increment,
  `comp_pic` text,
  `comp_name` text NOT NULL,
  `comp_desc` text,
  `comp_co_num` text NOT NULL,
  `mj_sector_fk` int(11) default NULL,
  `mj_services_fk` int(11) default NULL,
  `mj_state_fk` int(11) default NULL,
  `is_founder` int(11) default NULL,
  `ispublished` int(11) default NULL,
  `isfeatured` int(11) default NULL,
  PRIMARY KEY  (`comp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `_company`
--

INSERT INTO `_company` (`comp_id`, `comp_pic`, `comp_name`, `comp_desc`, `comp_co_num`, `mj_sector_fk`, `mj_services_fk`, `mj_state_fk`, `is_founder`, `ispublished`, `isfeatured`) VALUES
(1, 'uploads/founder/founders.png', 'Rich Core Media', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tincidunt, nibh id hendrerit egestas, nisi dui auctor mi, quis tincidunt tellus risus nec neque. Nullam semper justo quis libero vulputate malesuada luctus sem volutpat. Nullam diam nibh, venenatis quis elementum a, tempus eget augue. Donec ultricies purus quis velit scelerisque interdum auctor elit hendrerit. Nunc dictum porta aliquet. Aenean viverra turpis quis elit venenatis mollis. Vestibulum rhoncus lobortis lacus at suscipit. Mauris sit amet fermentum enim. Integer nec erat quis nisi sollicitudin lobortis vitae eu mauris.', '001988694-U', 1, 1, 1, 1, 0, NULL),
(2, 'uploads/founder/founders.png', 'Sastred One Sdn Bhd', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tincidunt, nibh id hendrerit egestas, nisi dui auctor mi, quis tincidunt tellus risus nec neque. Nullam semper justo quis libero vulputate malesuada luctus sem volutpat. Nullam diam nibh, venenatis quis elementum a, tempus eget augue. Donec ultricies purus quis velit scelerisque interdum auctor elit hendrerit. Nunc dictum porta aliquet. Aenean viverra turpis quis elit venenatis mollis. Vestibulum rhoncus lobortis lacus at suscipit. Mauris sit amet fermentum enim. Integer nec erat quis nisi sollicitudin lobortis vitae eu mauris.', '112233-X', 1, 1, 1, 1, 1, NULL),
(3, 'uploads/founder/founders.png', 'Innovatis Sdn Bhd', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tincidunt, nibh id hendrerit egestas, nisi dui auctor mi, quis tincidunt tellus risus nec neque. Nullam semper justo quis libero vulputate malesuada luctus sem volutpat. Nullam diam nibh, venenatis quis elementum a, tempus eget augue. Donec ultricies purus quis velit scelerisque interdum auctor elit hendrerit. Nunc dictum porta aliquet. Aenean viverra turpis quis elit venenatis mollis. Vestibulum rhoncus lobortis lacus at suscipit. Mauris sit amet fermentum enim. Integer nec erat quis nisi sollicitudin lobortis vitae eu mauris.', '223344-X', 1, 1, 1, 1, 1, 1),
(4, 'uploads/founder/founders.png', 'company a', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tincidunt, nibh id hendrerit egestas, nisi dui auctor mi, quis tincidunt tellus risus nec neque. Nullam semper justo quis libero vulputate malesuada luctus sem volutpat. Nullam diam nibh, venenatis quis elementum a, tempus eget augue. Donec ultricies purus quis velit scelerisque interdum auctor elit hendrerit. Nunc dictum porta aliquet. Aenean viverra turpis quis elit venenatis mollis. Vestibulum rhoncus lobortis lacus at suscipit. Mauris sit amet fermentum enim. Integer nec erat quis nisi sollicitudin lobortis vitae eu mauris.', '12324122', 1, 1, 1, 1, 1, NULL),
(5, 'uploads/founder/bsn.png', 'Bank Simpanan Nasional', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tincidunt, nibh id hendrerit egestas, nisi dui auctor mi, quis tincidunt tellus risus nec neque. Nullam semper justo quis libero vulputate malesuada luctus sem volutpat. Nullam diam nibh, venenatis quis elementum a, tempus eget augue. Donec ultricies purus quis velit scelerisque interdum auctor elit hendrerit. Nunc dictum porta aliquet. Aenean viverra turpis quis elit venenatis mollis. Vestibulum rhoncus lobortis lacus at suscipit. Mauris sit amet fermentum enim. Integer nec erat quis nisi sollicitudin lobortis vitae eu mauris.', 'asdasd1212', 2, 2, 2, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `_company_director`
--

CREATE TABLE IF NOT EXISTS `_company_director` (
  `_cd_id` int(11) NOT NULL auto_increment,
  `_cd_name` varchar(25) NOT NULL,
  `_cd_ic` text NOT NULL,
  `_comp_id_fk` int(11) default NULL,
  PRIMARY KEY  (`_cd_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `_company_director`
--

INSERT INTO `_company_director` (`_cd_id`, `_cd_name`, `_cd_ic`, `_comp_id_fk`) VALUES
(2, 'Muhamad Mahfudz Idris', '870922435553', 1),
(3, 'Muhamad Mahfudz Idris', '870922435553', 2),
(4, 'Azamin', '791112145807', 3);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
