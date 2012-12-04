<?php require_once('Connections/conJobsPerak.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  $_SESSION['MM_UserID'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
  unset($_SESSION['MM_UserID']);
	
  $logoutGoTo = "login.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "1";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "sessionGateway.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO jp_licenses (license_id, license_type, user_id_fk) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['edu_id'], "int"),
                       GetSQLValueString($_POST['license_type'], "text"),
                       GetSQLValueString($_POST['user_id_fk'], "int"));

  mysql_select_db($database_conJobsPerak, $conJobsPerak);
  $Result1 = mysql_query($insertSQL, $conJobsPerak) or die(mysql_error());

  $insertGoTo = "jobSeekerMyResume.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsEduList = "SELECT * FROM jp_edu_lists";
$rsEduList = mysql_query($query_rsEduList, $conJobsPerak) or die(mysql_error());
$row_rsEduList = mysql_fetch_assoc($rsEduList);
$totalRows_rsEduList = mysql_num_rows($rsEduList);

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsFieldList = "SELECT * FROM jp_field_list";
$rsFieldList = mysql_query($query_rsFieldList, $conJobsPerak) or die(mysql_error());
$row_rsFieldList = mysql_fetch_assoc($rsFieldList);
$totalRows_rsFieldList = mysql_num_rows($rsFieldList);

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsGradeList = "SELECT * FROM jp_grade_list";
$rsGradeList = mysql_query($query_rsGradeList, $conJobsPerak) or die(mysql_error());
$row_rsGradeList = mysql_fetch_assoc($rsGradeList);
$totalRows_rsGradeList = mysql_num_rows($rsGradeList);

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsLocatedList = "SELECT * FROM jp_nationality";
$rsLocatedList = mysql_query($query_rsLocatedList, $conJobsPerak) or die(mysql_error());
$row_rsLocatedList = mysql_fetch_assoc($rsLocatedList);
$totalRows_rsLocatedList = mysql_num_rows($rsLocatedList);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<title>Welcome to Jobsperak Portal</title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<link rel="stylesheet" href="css/style.css" type="text/css" media="screen, projection" />
  <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>

  <style type="text/css" media="screen">
    table#discTable {
      border:1px solid #E6E6E6;
    }
    table#discTable tr:hover {
      background:#E6E6E6;
    }
  </style>
</head>

<body>



	<header id="header">

		<div class="center">
			<div class="left"> <a href="index.php"><img src="img/logo.png" width="260" height="80" alt="JobsPerak Logo" longdesc="index.php"></a>
			</div>

			<div class="right">
            	<?php if (!isset($_SESSION['MM_Username'])) { ?>
					<a href="login.php" title="Login">Login</a> &nbsp;|&nbsp;
                	<a href="registerJobSeeker.php" title="Register JobSeeker">
                    Register JobSeeker</a>
				<?php } else { ?>
                	<strong>Hi, <?php echo $_SESSION['MM_Username']; ?></strong> 
                    &middot; <a href="sessionGateway.php">My Dashboard</a> &middot; (<a href="<?php echo $logoutAction ?>">Log Out</a>)
<?php }?>
    		</div>
			<div class="clear"></div>
		</div><!-- .center -->
		
		<?php include("main_menu.php"); ?>
	</header><!-- #header-->

	<div id="wrapper">
	
	<section id="middle">

		<div id="container" class="full">
		  <div id="content_full">
<h2>Update</h2>
<div class="master_details">
  <p>Welcome <?php echo $_SESSION['MM_Username']; ?> <?php //echo $_SESSION['MM_UserID']; ?> | <a href="<?php echo $logoutAction ?>">Log Out</a></p>
  
  <div class="master_details boxcenter" style="width:1000px">
	<h3>New DISC Personal Test &middot; <a href="jobSeekerMyResume.php?email=<?php echo $_SESSION['MM_Username']; ?>" title="Cancel">Cancel</a></h3><br/>
    <p>

<table border="1" cellpadding="2" cellspacing="2" style="border-collapse:collapse;" width="980px" id="discTable">
    <tbody>
        <tr>
            <td width="127" rowspan="2" valign="top">
                <p align="center">
                    <strong><em>Personaliti saya lebih kepada...</em></strong>
                </p>
            </td>
            <td width="139" valign="top">
                <p>
                    Mengarah dan memberi arahan.
                </p>
            </td>
            <td width="116" valign="top">
                <p>
                    Bercampur gaul dan penuh perasaan.
                </p>
            </td>
            <td width="127" valign="top">
                <p>
                    Lembut dan tidak formal.
                </p>
            </td>
            <td width="131" valign="top">
                <p>
                    Tepat dan tidak mengarut ( cakap kosong ).
                </p>
            </td>
        </tr>
        <tr>
            <td width="139" valign="top"><select name="row1col1" id="row1col1">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select></td>
            <td width="116" valign="top">
            <select name="row1col2" id="row1col2">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
          </select></td>
            <td width="127" valign="top">
            <select name="row1col3" id="row1col3">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
          </td>
            <td width="131" valign="top">
            <select name="row1col4" id="row1col4">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
          </td>
        </tr>
        <tr>
            <td width="127" rowspan="2" valign="top">
                <p>
                    <strong><em>Saya memilih suasana dimana saya boleh...</em></strong>
                </p>
            </td>
            <td width="139" valign="top">
                <p>
                    Membuat keputusan, menetapkan matlamat dan melihat keputusan.
                </p>
            </td>
            <td width="116" valign="top">
                <p>
                    Kreatif, peramah dan pandai memujuk orang.
                </p>
            </td>
            <td width="127" valign="top">
                <p>
                    Melaksanakan tugas berulang kali, bekerja didalam satu kumpulan dan menetap di suatu lokasi.
                </p>
            </td>
            <td width="131" valign="top">
                <p>
                    Mengumpul data dan butiran mengikut prosedur dan kualiti bermutu tinggi.
                </p>
            </td>
        </tr>
        <tr>
            <td width="139" valign="top">
            <select name="row2col1" id="row2col1">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="116" valign="top">
            <select name="row2col2" id="row2col2">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="127" valign="top">
            <select name="row2col3" id="row2col3">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="131" valign="top"><select name="row2col4" id="row2col4">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
        </tr>
        <tr>
            <td width="127" rowspan="2" valign="top">
                <p>
                    <strong><em>Saya memilih suasana bekerja seperti...</em></strong>
                </p>
            </td>
            <td width="139" valign="top">
                <p>
                    Berorientasikan keputusan / hasil.
                </p>
            </td>
            <td width="116" valign="top">
                <p>
                    Berorientasikan orang.
                </p>
            </td>
            <td width="127" valign="top">
                <p>
                    Berorentasikan proses / kumpulan.
                </p>
            </td>
            <td width="131" valign="top">
                <p>
                    Berorientasikan butiran.
                </p>
            </td>
        </tr>
       <tr>
            <td width="139" valign="top">
            <select name="row3col1" id="row3col1">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="116" valign="top">
            <select name="row3col2" id="row3col2">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="127" valign="top">
            <select name="row3col3" id="row3col3">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="131" valign="top">
            <select name="row3col4" id="row3col4">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
        </tr>
        <tr>
            <td width="127" rowspan="2" valign="top">
                <p>
                    <strong><em>Persekitaran tempat bekerja yang sesuai bagi saya adalah....</em></strong>
                </p>
            </td>
            <td width="139" valign="top">
                <p>
                    Menjadi seorang pekerja yang berdikari.
                </p>
            </td>
            <td width="116" valign="top">
                <p>
                    Berkerja dengan orang.
                </p>
            </td>
            <td width="127" valign="top">
                <p>
                    Berkerja secara berkumpulan.
                </p>
            </td>
            <td width="131" valign="top">
                <p>
                    Bekerja sendiri tanpa gangguan.
                </p>
            </td>
        </tr>
        <tr>
            <td width="139" valign="top">
            <select name="row4col1" id="row4col1">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="116" valign="top">
            <select name="row4col2" id="row4col2">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="127" valign="top">
            <select name="row4col3" id="row4col3">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="131" valign="top">
            <select name="row4col4" id="row4col4">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
        </tr>
        <tr>
            <td width="127" rowspan="2" valign="top">
                <p>
                    <strong><em>Dalam profesion, saya ingin...</em></strong>
                </p>
            </td>
            <td width="139" valign="top">
                <p>
                    Menguruskan orang lain.
                </p>
            </td>
            <td width="116" valign="top">
                <p>
                    Memotivasikan orang lain.
                </p>
            </td>
            <td width="127" valign="top">
                <p>
                    Mengikut arahan rutin / harian.
                </p>
            </td>
            <td width="131" valign="top">
                <p>
                    Mengumpul butiran dan fakta.
                </p>
            </td>
        </tr>
        <tr>
            <td width="139" valign="top">
            <select name="row5col1" id="row5col1">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="116" valign="top">
            <select name="row5col2" id="row5col2">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="127" valign="top">
            <select name="row5col3" id="row5col3">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="131" valign="top">
            <select name="row5col4" id="row5col4">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
        </tr>
        <tr>
            <td width="127" rowspan="2" valign="top">
                <p>
                    <strong><em>Saya cenderung untuk menjadi...</em></strong>
                </p>
            </td>
            <td width="139" valign="top">
                <p>
                    Memberi arahan kepada orang lain.
                </p>
            </td>
            <td width="116" valign="top">
                <p>
                    Mempengaruhi orang lain.
                </p>
            </td>
            <td width="127" valign="top">
                <p>
                    Menerima orang lain.
                </p>
            </td>
            <td width="131" valign="top">
                <p>
                    Menilai orang lain.
                </p>
            </td>
        </tr>
        <tr>
            <td width="139" valign="top">
            <select name="row6col1" id="row6col1">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="116" valign="top">
            <select name="row6col2" id="row6col2">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="127" valign="top">
            <select name="row6col3" id="row6col3">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="131" valign="top">
            <select name="row6col4" id="row6col4">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
        </tr>
        <tr>
            <td width="127" rowspan="2" valign="top">
                <p>
                    <strong><em>Saya suka bercerita dengan orang lain tentang...</em></strong>
                </p>
            </td>
            <td width="139" valign="top">
                <p>
                    Tentang pencapaian saya.
                </p>
            </td>
            <td width="116" valign="top">
                <p>
                    Tentang diri saya dan orang lain.
                </p>
            </td>
            <td width="127" valign="top">
                <p>
                    Tentang keluarga dan rakan-rakan.
                </p>
            </td>
            <td width="131" valign="top">
                <p>
                    Tentang perkara lain, sistem dan organisasi.
                </p>
            </td>
        </tr>
        <tr>
            <td width="139" valign="top">
            <select name="row7col1" id="row7col1">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="116" valign="top">
            <select name="row7col2" id="row7col2">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="127" valign="top">
            <select name="row7col3" id="row7col3">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="131" valign="top">
            <select name="row7col4" id="row7col4">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
        </tr>
        <tr>
            <td width="127" rowspan="2" valign="top">
                <p>
                    <strong><em>Apabila membuat keputusan saya menjurus kepada...</em></strong>
                </p>
            </td>
            <td width="139" valign="top">
                <p>
                    Cepat atau mendadak.
                </p>
            </td>
            <td width="116" valign="top">
                <p>
                    Melakukan apa yang biasa dilakukan dan yang telah dilakukan sebelum ini.
                </p>
            </td>
            <td width="127" valign="top">
                <p>
                    Mengkaji situasi dan sentiasa berhati-hati.
                </p>
            </td>
            <td width="131" valign="top">
                <p>
                    Mengumpul maklumat dan menetapkan objektif.
                </p>
            </td>
        </tr>
        <tr>
            <td width="139" valign="top">
            <select name="row8col1" id="row8col1">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="116" valign="top"><select name="row8col2" id="row8col2">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="127" valign="top">
            <select name="row8col3" id="row8col3">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="131" valign="top">
            <select name="row8col4" id="row8col4">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
        </tr>
        <tr>
            <td width="127" rowspan="2" valign="top">
                <p>
                    <strong><em>Saya mampu...</em></strong>
                </p>
            </td>
            <td width="139" valign="top">
                <p>
                    Membuat keputusan dan menerima perubahan.
                </p>
            </td>
            <td width="116" valign="top">
                <p>
                    Memujuk dan menyakinkan orang lain.
                </p>
            </td>
            <td width="127" valign="top">
                <p>
                    Menangani masalah di bawah tekanan.
                </p>
            </td>
            <td width="131" valign="top">
                <p>
                    Menganalisis maklumat.
                </p>
            </td>
        </tr>
        <tr>
            <td width="139" valign="top">
            <select name="row9col1" id="row9col1">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="116" valign="top">
            <select name="row9col2" id="row9col2">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="127" valign="top">
            <select name="row9col3" id="row9col3">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="131" valign="top">
            <select name="row9col4" id="row9col4">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
        </tr>
        <tr>
            <td width="127" rowspan="2" valign="top">
                <p>
                    <strong><em>Naluri saya bersifat...</em></strong>
                </p>
            </td>
            <td width="139" valign="top">
                <p>
                    Pemimpin.
                </p>
            </td>
            <td width="116" valign="top">
                <p>
                    Berkomunikasi.
                </p>
            </td>
            <td width="127" valign="top">
                <p>
                    Berkumpulan.
                </p>
            </td>
            <td width="131" valign="top">
                <p>
                    Penganjur.
                </p>
            </td>
        </tr>
        <tr>
            <td width="139" valign="top">
            <select name="row10col1" id="row10col1">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="116" valign="top">
            <select name="row10col2" id="row10col2">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="127" valign="top">
            <select name="row10col3" id="row10col3">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="131" valign="top">
            <select name="row10col4" id="row10col4">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
        </tr>
        <tr>
            <td width="127" valign="top">
                <p>
                    <strong><em>Saya boleh berfungsi dengan baik apabila...</em></strong>
                </p>
            </td>
            <td width="139" valign="top">
                <p>
                    Menjalankan tanggungjawab dengan penuh amanah
                </p>
            </td>
            <td width="116" valign="top">
                <p>
                    Berinteraksi dengan orang yang kreatif.
                </p>
            </td>
            <td width="127" valign="top">
                <p>
                    Bersabar dan melambatkan proses.
                </p>
            </td>
            <td width="131" valign="top">
                <p>
                    Menganalisa fakta dan butiran.
                </p>
            </td>
        </tr>
        <tr>
            <td width="127" valign="top">
                <p>
                    <strong><em></em></strong>
                </p>
            </td>
            <td width="139" valign="top"><select name="row11col1" id="row11col1">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="116" valign="top"><select name="row11col2" id="row11col2">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="127" valign="top"><select name="row11col3" id="row11col3">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="131" valign="top"><select name="row11col4" id="row11col4">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
        </tr>
        <tr>
            <td width="127" rowspan="2" valign="top">
                <p>
                    <strong><em>Saya mahu aktiviti saya menjadi...</em></strong>
                </p>
            </td>
            <td width="139" valign="top">
                <p>
                    Bebas dari kerja terperinci yang berlebihan.
                </p>
            </td>
            <td width="116" valign="top">
                <p>
                    Mesra dan optimis.
                </p>
            </td>
            <td width="127" valign="top">
                <p>
                    Rutin dan cekap.
                </p>
            </td>
            <td width="131" valign="top">
                <p>
                    Tugas dan butiran terperinci.
                </p>
            </td>
        </tr>
        <tr>
            <td width="139" valign="top">
            <select name="row12col1" id="row12col1">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="116" valign="top">
            <select name="row12col2" id="row12col2">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="127" valign="top">
            <select name="row12col3" id="row12col3">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="131" valign="top">
            <select name="row12col4" id="row12col4">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
        </tr>
        <tr>
            <td width="127" rowspan="2" valign="top">
                <p>
                    <strong><em>Tugas ideal saya harus melibatkan..</em></strong>
                </p>
            </td>
            <td width="139" valign="top">
                <p>
                    Berani, bertindak agresif.
                </p>
            </td>
            <td width="116" valign="top">
                <p>
                    Berkomunikasi dengan orang.
                </p>
            </td>
            <td width="127" valign="top">
                <p>
                    Kerja rutin / harian.
                </p>
            </td>
            <td width="131" valign="top">
                <p>
                    Tugas dan butiran terperinci.
                </p>
            </td>
        </tr>
        <tr>
            <td width="139" valign="top">
            <select name="row13col1" id="row13col1">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="116" valign="top">
            <select name="row13col2" id="row13col2">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="127" valign="top">
            <select name="row13col3" id="row13col3">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="131" valign="top">
            <select name="row13col4" id="row13col4">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
        </tr>
        <tr>
            <td width="127" rowspan="2" valign="top">
                <p>
                    <strong><em>Secara keseluruhan saya harus digambarkan sebagai...</em></strong>
                </p>
            </td>
            <td width="139" valign="top">
                <p>
                    Berwibawa, berwawasan dan berinovatif.
                </p>
            </td>
            <td width="116" valign="top">
                <p>
                    Kreatif, bergaya, mesra dan boleh bergaul.
                </p>
            </td>
            <td width="127" valign="top">
                <p>
                    Boleh bergantung, , setia, sabar dan stabil.
                </p>
            </td>
            <td width="131" valign="top">
                <p>
                    Teliti, tepat dan konsisten.
                </p>
            </td>
        </tr>
        <tr>
            <td width="139" valign="top">
            <select name="row14col1" id="row14col1">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="116" valign="top">
            <select name="row14col2" id="row14col2">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="127" valign="top">
            <select name="row14col2" id="row14col3">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="131" valign="top">
            <select name="row14col4" id="row14col4">
              <option value="0">Choose</option>

              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
        </tr>
        <tr>
            <td width="127" rowspan="2" valign="top">
                <p>
                    <strong><em>Perbualan saya mengenai...</em></strong>
                </p>
            </td>
            <td width="139" valign="top">
                <p>
                    Mendapatkan maklumat secara terperinci
                </p>
            </td>
            <td width="116" valign="top">
                <p>
                    Memotivasikan orang lain dan membuat pendamaian
                </p>
            </td>
            <td width="127" valign="top">
                <p>
                    Membantu dan mendengar masalah orang lain.
                </p>
            </td>
            <td width="131" valign="top">
                <p>
                    Menjadi konservatif dan rendah diri.
                </p>
            </td>
        </tr>
        <tr>
            <td width="139" valign="top">
            <select name="row15col1" id="row15col1">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="116" valign="top">
            <select name="row15col2" id="row15col2">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="127" valign="top">
            <select name="row15col3" id="row15col3">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="131" valign="top">
            <select name="row15col4" id="row15col4">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
        </tr>
        <tr>
            <td width="127" valign="top">
                <p>
                    <strong><em></em></strong>
                </p>
            </td>
            <td width="139" valign="top">
                <p>
                    Saya agak bimbang dengan perubahan dan memilih untuk tetap dengan kerja yang dilakukan.
                </p>
            </td>
            <td width="116" valign="top">
                <p>
                    Saya menilai seseorang dan situasi berdasarkan emosi.
                </p>
            </td>
            <td width="127" valign="top">
                <p>
                    Saya suka situasi yang menguji kebolehan dan kekuatan saya tanpa menyekat kebebasan peribadi.
                </p>
            </td>
            <td width="131" valign="top">
                <p>
                    Saya suka mengabungkan orang dan idea dalam mencapai keseimbangan dan keharmonian.
                </p>
            </td>
        </tr>
        <tr>
            <td width="127" valign="top">
                <p>
                    <strong><em></em></strong>
                </p>
            </td>
            <td width="139" valign="top"><select name="row16col1" id="row16col1">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="116" valign="top"><select name="row16col2" id="row16col2">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="127" valign="top"><select name="row16col3" id="row16col3">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="131" valign="top"><select name="row16col4" id="row16col4">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
        </tr>
        <tr>
            <td width="127" valign="top">
                <p>
                    <strong><em></em></strong>
                </p>
            </td>
            <td width="139" valign="top">
                <p>
                    Saya menunjukkan kesetiaan yang kuat terhadap prinsip dan konsep yang saya percayai.
                </p>
            </td>
            <td width="116" valign="top">
                <p>
                    Saya anggap kehendak, keperluan dan kepentingan orang lain sangat penting.
                </p>
            </td>
            <td width="127" valign="top">
                <p>
                    Saya memilih untuk mengenakan pengaruh ke atas situasi dan suasana yang mana saya meletakan diri saya ditempat tersebut.
                </p>
            </td>
            <td width="131" valign="top">
                <p>
                    Saya cuba untuk tidak menghakimi seseorang , saya akan berusaha untuk berfikiran terbuka tanpa hilang pertimbangan.
                </p>
            </td>
        </tr>
        <tr>
            <td width="127" valign="top">
                <p>
                    <strong><em></em></strong>
                </p>
            </td>
            <td width="139" valign="top"><select name="row17col1" id="row17col1">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="116" valign="top"><select name="row17col2" id="row17col2">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="127" valign="top"><select name="row17col3" id="row17col3">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="131" valign="top"><select name="row17col4" id="row17col4">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
        </tr>
        <tr>
            <td width="127" valign="top">
                <p>
                    <strong><em></em></strong>
                </p>
            </td>
            <td width="139" valign="top">
                <p>
                    Akhlak, integriti dan kejujuran adalah sangat penting bagi saya.
                </p>
            </td>
            <td width="116" valign="top">
                <p>
                    Saya melakukan pendekatan kepada orang lain secara terbuka dan tanpa ancaman.
                </p>
            </td>
            <td width="127" valign="top">
                <p>
                    Saya menetapkan keutamaan saya sendiri tanpa dipengaruhi oleh orang lain atau yang lain.
                </p>
            </td>
            <td width="131" valign="top">
                <p>
                    Saya cuba membuat kata-kata saya menjadi kenyataan dan mewakili suara saya.
                </p>
            </td>
        </tr>
        <tr>
            <td width="127" valign="top">
                <p>
                    <strong><em></em></strong>
                </p>
            </td>
            <td width="139" valign="top"><select name="row18col1" id="row18col1">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="116" valign="top"><select name="row18col2" id="row18col2">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="127" valign="top"><select name="row18col3" id="row18col3">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="131" valign="top"><select name="row18col4" id="row18col4">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
        </tr>
        <tr>
            <td width="127" valign="top">
                <p>
                    <strong><em></em></strong>
                </p>
            </td>
            <td width="139" valign="top">
                <p>
                    Saya percaya jika kita tidak tegas untuk sesuatu , kita akan jatuh disebabkan sesuatu.
                </p>
            </td>
            <td width="116" valign="top">
                <p>
                    Saya selalu memberikan usaha yang terbaik untuk memenuhi kepuasan sendiri.
                </p>
            </td>
            <td width="127" valign="top">
                <p>
                    Saya mempunyai kekuatan dalaman untuk mendapatkan pengiktirafan dan kesejahteraan dengan cara saya sendiri.
                </p>
            </td>
            <td width="131" valign="top">
                <p>
                    Saya mempunyai dorongan dalaman yang kuat untuk kebajikan orang lain, kadang-kadang merugikan diri saya sendirir.
                </p>
            </td>
        </tr>
        <tr>
            <td width="127" valign="top">
                <p>
                    <strong><em></em></strong>
                </p>
            </td>
            <td width="139" valign="top"><select name="row19col1" id="row19col1">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="116" valign="top"><select name="row19col2" id="row19col2">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="127" valign="top"><select name="row19col3" id="row19col3">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="131" valign="top"><select name="row19col4" id="row19col4">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
        </tr>
        <tr>
            <td width="127" valign="top">
                <p>
                    <strong><em></em></strong>
                </p>
            </td>
            <td width="139" valign="top">
                <p>
                    Saya meletakkan keutamaan saya untuk memenuhi tarikh akhir dan berpegang pada janji. Kata-kata saya adalah janji saya.
                </p>
            </td>
            <td width="116" valign="top">
                <p>
                    Saya mahu orang lain gembira dengan keprihatinan saya terhadap mereka.
                </p>
            </td>
            <td width="127" valign="top">
                <p>
                    Saya melihat sesuatu cara tertentu dan berusaha untuk menjadikan matlamat saya.
                </p>
            </td>
            <td width="131" valign="top">
                <p>
                    Saya berpegang kepada apa yang saya percaya tetapi saya cuba untuk mengekalkan fleksibility dalam usaha untuk mencapai keharmonian.
                </p>
            </td>
        </tr>
        <tr>
            <td width="127" valign="top">
                <p>
                    <strong><em></em></strong>
                </p>
            </td>
            <td width="139" valign="top"><select name="row20col1" id="row20col1">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="116" valign="top"><select name="row20col2" id="row20col2">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
          </select></td>
            <td width="127" valign="top"><select name="row20col3" id="row20col3">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="131" valign="top"><select name="row20col4" id="row20col4">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
        </tr>
        <tr>
            <td width="127" valign="top">
                <p>
                    <strong><em></em></strong>
                </p>
            </td>
            <td width="139" valign="top">
                <p>
                    Saya menggunakan situasi dan masalah dan bukannya emosi.
                </p>
            </td>
            <td width="116" valign="top">
                <p>
                    Saya cuba untuk manjalinkan hubungan dengan orang lain dengan mengambil tahu tentang pandangan dan perasaan mereka.
                </p>
            </td>
            <td width="127" valign="top">
                <p>
                    Saya mudah mengenal pasti peluang yang memberikan kebaikan kepada saya dan bergerak pantas untuk mengambil kesempatan terhadap mereka.
                </p>
            </td>
            <td width="131" valign="top">
                <p>
                    Saya melihat setiap orang dan benda dari sudut positif.
                </p>
            </td>
        </tr>
        <tr>
            <td width="127" valign="top">
                <p>
                    <strong><em></em></strong>
                </p>
            </td>
            <td width="139" valign="top"><select name="row21col1" id="row21col1">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="116" valign="top"><select name="row21col2" id="row21col2">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="127" valign="top"><select name="row21col3" id="row21col3">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="131" valign="top"><select name="row21col4" id="row21col4">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
        </tr>
        <tr>
            <td width="127" valign="top">
                <p>
                    <strong><em></em></strong>
                </p>
            </td>
            <td width="139" valign="top">
                <p>
                    Adalah penting untuk membina dan mengekalkan hubungan. Mempunyai reputasi yang baik adalah penting bagi saya.
                </p>
            </td>
            <td width="116" valign="top">
                <p>
                    Saya mempunyai perasaan yang kuat untuk berlaku adil, tetapi saya tidak suka situasi yang menyekat ekspresi diri saya.
                </p>
            </td>
            <td width="127" valign="top">
                <p>
                    Saya cepat dalam mencari penyelesaian yang kreatif untuk memenuhi objektif saya.
                </p>
            </td>
            <td width="131" valign="top">
                <p>
                    Saya rasa boleh mencapai dan mengunakan pengalaman dalam kehidupan saya.
                </p>
            </td>
        </tr>
        <tr>
            <td width="127" valign="top">
                <p>
                    <strong><em></em></strong>
                </p>
            </td>
            <td width="139" valign="top"><select name="row22col1" id="row22col1">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="116" valign="top"><select name="row22col2" id="row22col2">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="127" valign="top"><select name="row22col3" id="row22col3">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="131" valign="top"><select name="row22col4" id="row22col4">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
        </tr>
        <tr>
            <td width="127" valign="top">
                <p>
                    <strong><em></em></strong>
                </p>
            </td>
            <td width="139" valign="top">
                <p>
                    Saya mengekalkan kesetiaan dengan memutuskan untuk menyesuaikan diri saya dengan idea, organisasi dan proses.
                </p>
            </td>
            <td width="116" valign="top">
                <p>
                    Saya akan mengetepikan keinginan peribadi untuk mengekalkan keharmonian sekiranya ianya mencapai matlamat saya.
                </p>
            </td>
            <td width="127" valign="top">
                <p>
                    Saya akan berusaha untuk mencapai matlamat yang dapat meningkatkan kepuasan diri saya.
                </p>
            </td>
            <td width="131" valign="top">
                <p>
                    Saya suka berkongsi dan mengabungkan idea orang lain untuk meningkatkan produktiviti.
                </p>
            </td>
        </tr>
        <tr>
            <td width="127" valign="top">
                <p>
                    <strong><em></em></strong>
                </p>
            </td>
            <td width="139" valign="top"><select name="row23col1" id="row23col1">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="116" valign="top"><select name="row23col2" id="row23col2">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="127" valign="top"><select name="row23col3" id="row23col3">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="131" valign="top"><select name="row23col4" id="row23col4">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
        </tr>
        <tr>
            <td width="127" valign="top">
                <p>
                    <strong><em></em></strong>
                </p>
            </td>
            <td width="139" valign="top">
                <p>
                    Saya ingin mencapai matlamat, melihat perkara melaluinya, mengikut peraturan dan sumbangan saya dihargai.
                </p>
            </td>
            <td width="116" valign="top">
                <p>
                    Saya inginkan situasi yang konsisten yang membolehkan saya merasa tenang.
                </p>
            </td>
            <td width="127" valign="top">
                <p>
                    Kebanyakkan anda membuat dalam situasi. “Hidup anda hanya sekali”.
                </p>
            </td>
            <td width="131" valign="top">
                <p>
                    Saya memberikan respon kepada orang lain, dan mereka memberi reaksi yang baik kepada saya. Saya melayani setiap orang dengan penuh hormat.
                </p>
            </td>
        </tr>
        <tr>
            <td width="127" valign="top">
                <p>
                    <strong><em></em></strong>
                </p>
            </td>
            <td width="139" valign="top"><select name="row24col1" id="row24col1">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="116" valign="top"><select name="row24col2" id="row24col2">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="127" valign="top"><select name="row24col3" id="row24col3">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="131" valign="top"><select name="row24col4" id="row24col4">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
        </tr>
        <tr>
            <td width="127" valign="top">
                <p>
                    <strong><em></em></strong>
                </p>
            </td>
            <td width="139" valign="top">
                <p>
                    Saya suka kepada perkara yang tetap dan stabil serta tidak berubah. Saya tidak suka kepada kejutan.
                </p>
            </td>
            <td width="116" valign="top">
                <p>
                    Saya suka kepada perkara yang harmoni untuk mencapai kepuasan diri.
                </p>
            </td>
            <td width="127" valign="top">
                <p>
                    Saya suka menguji prestasi saya terhadap orang lain dalam membina tahap kerja saya. Saya juga ingin menetapkan tahap saya sendiri.
                </p>
            </td>
            <td width="131" valign="top">
                <p>
                    Saya seronok menjalankan tugas dan berkongsi pencapaian saya dengan yang orang lain.
                </p>
            </td>
        </tr>
        <tr>
            <td width="127" valign="top">
                <p>
                    <strong><em></em></strong>
                </p>
            </td>
            <td width="139" valign="top"><select name="row25col1" id="row25col1">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="116" valign="top"><select name="row25col2" id="row25col2">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="127" valign="top"><select name="row25col3" id="row25col3">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="131" valign="top"><select name="row25col4" id="row25col4">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
        </tr>
        <tr>
            <td width="127" valign="top">
                <p>
                    <strong><em></em></strong>
                </p>
            </td>
            <td width="139" valign="top">
                <p>
                    Saya perlukan ruang dan kemudahan untuk memudahkan saya bekerja.
                </p>
            </td>
            <td width="116" valign="top">
                <p>
                    Saya boleh bekerja dengan baik didalam persekitaran yang tidak teratur.
                </p>
            </td>
            <td width="127" valign="top">
                <p>
                    Saya lebih suka persekitaran yang logik dan sistematik.
                </p>
            </td>
            <td width="131" valign="top">
                <p>
                    Saya suka persekitaran yang memberi inspirasi yang kreatif.
                </p>
            </td>
        </tr>
        <tr>
            <td width="127" valign="top">
                <p>
                    <strong><em></em></strong>
                </p>
            </td>
            <td width="139" valign="top"><select name="row26col1" id="row26col1">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="116" valign="top"><select name="row26col2" id="row26col2">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="127" valign="top"><select name="row26col3" id="row26col3">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="131" valign="top"><select name="row26col4" id="row26col4">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
        </tr>
        <tr>
            <td width="127" valign="top">
                <p>
                    <strong><em></em></strong>
                </p>
            </td>
            <td width="139" valign="top">
                <p>
                    Saya boleh bekerja dengan baik apabila saya boleh berkerjasama dengan orang yang boleh diharapkan.
                </p>
            </td>
            <td width="116" valign="top">
                <p>
                    Saya boleh bekerja dengan baik apabila saya boleh mengekalkan hubungan yang baik dan mesra dengan orang.
                </p>
            </td>
            <td width="127" valign="top">
                <p>
                    Saya boleh memberikan yang terbaik bersama dengan orang yang mempunyai matlamat.
                </p>
            </td>
            <td width="131" valign="top">
                <p>
                    Saya boleh memberikan yang terbaik kepada orang yang boleh menerima perubahan.
                </p>
            </td>
        </tr>
        <tr>
            <td width="127" valign="top">
                <p>
                    <strong><em></em></strong>
                </p>
            </td>
            <td width="139" valign="top"><select name="row27col1" id="row27col1">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="116" valign="top"><select name="row27col2" id="row27col2">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="127" valign="top"><select name="row27col3" id="row27col3">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="131" valign="top"><select name="row27col4" id="row27col4">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
        </tr>
        <tr>
            <td width="127" valign="top">
                <p>
                    <strong><em></em></strong>
                </p>
            </td>
            <td width="139" valign="top">
                <p>
                    Saya belajar mengikut arahan dalam setiap tatakerja.
                </p>
            </td>
            <td width="116" valign="top">
                <p>
                    Saya belajar apabila saya percaya saya boleh membuat sesuatu lain dari yang lain.
                </p>
            </td>
            <td width="127" valign="top">
                <p>
                    Saya belajar lebih banyak dengan membaca, mendengar dan melihat daripada melakukannya.
                </p>
            </td>
            <td width="131" valign="top">
                <p>
                    Saya belajar lebih baik melalui pengalaman yang sebenar.
                </p>
            </td>
        </tr>
        <tr>
            <td width="127" valign="top">
                <p>
                    <strong><em></em></strong>
                </p>
            </td>
            <td width="139" valign="top"><select name="row28col1" id="row28col1">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="116" valign="top"><select name="row28col2" id="row28col2">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="127" valign="top"><select name="row28col3" id="row28col3">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="131" valign="top"><select name="row28col4" id="row28col4">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
        </tr>
        <tr>
            <td width="127" valign="top">
                <p>
                    <strong><em></em></strong>
                </p>
            </td>
            <td width="139" valign="top">
                <p>
                    Saya yakin boleh membuat sesuatu kerja sebelum membuat keputusan.
                </p>
            </td>
            <td width="116" valign="top">
                <p>
                    Saya memerlukan pendapat orang lain sebelum saya membuat keputusan.
                </p>
            </td>
            <td width="127" valign="top">
                <p>
                    Saya perlu mengumpulkan banyak maklumat sebelum membuat keputusan.
                </p>
            </td>
            <td width="131" valign="top">
                <p>
                    Saya hanya berminat dalam melakukan sesuatu yang saya tahu dan penting untuk diketahui.
                </p>
            </td>
        </tr>
        <tr>
            <td width="127" valign="top">
                <p>
                    <strong><em></em></strong>
                </p>
            </td>
            <td width="139" valign="top"><select name="row29col1" id="row29col1">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="116" valign="top"><select name="row29col2" id="row29col2">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="127" valign="top"><select name="row29col3" id="row29col3">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="131" valign="top"><select name="row29col4" id="row29col4">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
        </tr>
        <tr>
            <td width="127" valign="top">
                <p>
                    <strong><em></em></strong>
                </p>
            </td>
            <td width="139" valign="top">
                <p>
                    Saya seronok melakukan rutin harian yang selalu saya lakukan.
                </p>
            </td>
            <td width="116" valign="top">
                <p>
                    Saya suka berkerja dengan seseorang untuk menyiapkan sesuatu tugas.
                </p>
            </td>
            <td width="127" valign="top">
                <p>
                    Saya seronok mempunyai masa yang cukup untuk melakukan dan menyiapkan kerja.
                </p>
            </td>
            <td width="131" valign="top">
                <p>
                    Saya suka melakukan pelbagai cara / kaedah untuk menyelesaikan sesuatu masalah.
                </p>
            </td>
        </tr>
        <tr>
            <td width="127" valign="top">
                <p>
                    <strong><em></em></strong>
                </p>
            </td>
            <td width="139" valign="top"><select name="row30col1" id="row30col1">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="116" valign="top"><select name="row30col2" id="row30col2">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="127" valign="top"><select name="row30col3" id="row30col3">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="131" valign="top"><select name="row30col4" id="row30col4">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
        </tr>
        <tr>
            <td width="127" valign="top">
                <p>
                    <strong><em></em></strong>
                </p>
            </td>
            <td width="139" valign="top">
                <p>
                    Saya tertekan melakukan terlalu banyak kerja dan tidak tahu untuk bermula dari mana.
                </p>
            </td>
            <td width="116" valign="top">
                <p>
                    Saya tertekan dengan orang lain yang mendesak saya untuk menjadi lebih teratur.
                </p>
            </td>
            <td width="127" valign="top">
                <p>
                    Saya tertekan dengan tarikh akhir tugas yang diperlukan dengan kadar segera.
                </p>
            </td>
            <td width="131" valign="top">
                <p>
                    Saya tertekan dengan jadual yang padat, rutin dan halangan yang ada.
                </p>
            </td>
        </tr>
        <tr>
            <td width="127" valign="top">
                <p>
                    <strong><em></em></strong>
                </p>
            </td>
            <td width="139" valign="top"><select name="row31col1" id="row31col1">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
          </select></td>
            <td width="116" valign="top"><select name="row31col2" id="row31col2">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="127" valign="top"><select name="row31col3" id="row31col3">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="131" valign="top"><select name="row31col4" id="row31col4">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
        </tr>
        <tr>
            <td width="127" valign="top">
                <p>
                    <strong><em></em></strong>
                </p>
            </td>
            <td width="139" valign="top">
                <p>
                    Saya amat menghargai ganjaran bagi kerja yang dilakukan.
                </p>
            </td>
            <td width="116" valign="top">
                <p>
                    Saya amat menghargai orang yang amat berharga kepada orang lain.
                </p>
            </td>
            <td width="127" valign="top">
                <p>
                    Saya amat menghargai kerja yang berkualiti tinggi.
                </p>
            </td>
            <td width="131" valign="top">
                <p>
                    Saya amat menghargai kebebasan saya untuk memilih kerja atau projek.
                </p>
            </td>
        </tr>
        <tr>
            <td width="127" valign="top">
                <p>
                    <strong><em></em></strong>
                </p>
            </td>
            <td width="139" valign="top"><select name="row32col1" id="row32col1">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="116" valign="top"><select name="row32col2" id="row32col2">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="127" valign="top"><select name="row32col3" id="row32col3">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
            <td width="131" valign="top"><select name="row32col4" id="row32col4">
              <option value="0">Choose</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
            </td>
        </tr>
        <tr>
          <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
          <td><input type="button" name="getresult" id="getresult" value="Get Result">
          </td>
          <td><strong>D :</strong> <span id="allCol1"></span></td>
          <td><strong>I :</strong> <span id="allCol2"></span></td>
          <td><strong>S :</strong> <span id="allCol3"></span></td>
          <td><strong>C :</strong> <span id="allCol4"></span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="4" valign="center" align="center">
            <form action="#" method="post" accept-charset="utf-8" id="discForm">
              <input type="submit" name="newDiscTest_submitResult" id="newDiscTest_submitResult" value="Save Result" style="display:none">
              <input type="hidden" name="val1" id="val1" value="">
              <input type="hidden" name="val2" id="val2" value="">
              <input type="hidden" name="val3" id="val3" value="">
              <input type="hidden" name="val4" id="val4" value="">
              <input type="hidden" name="current_user_id" id="current_user_id" value="<?php echo $_SESSION['MM_UserID']; ?>">
            </form>
          </td>
        </tr>
    </tbody>
</table>

    </p>

    <p></p>

    <p></p>
    <p></p>
    <p></p>
    <p></p>


  </div>
</div>

          </div><!-- #content-->
	
		  <aside id="sideRight" class="hide">
          	  <div class="sidebarBox">
              	<strong>How-to</strong>
            	<div class="sidebar_howto">
                	<ul>
                    	<li><a href="#">Register</a></li>
                        <li><a href="#">Post a Job</a></li>
                    </ul>
	            </div><!-- .sidebar_recentjob -->
              </div><!-- .sidebarBox -->
              
			  <div class="sidebarBox hide">
              	<strong>Recent Jobs</strong>
            	<div class="sidebar_recentjob">
                	<ul>
                      <li><a></a></li>
                    </ul>
	            </div><!-- .sidebar_recentjob -->
              </div><!-- .sidebarBox -->
              
              <div class="sidebarBox hide">
           	  <strong>Jobs Posted under </strong>
              	<ul>
                  <li><a></a></li>
                </ul>
              </div><!-- .sidebarBox -->
              
              <div class="sidebarBox hide">
           	  <strong>Get Connected</strong><br />
              	Facebook | Twitter | RSS
              </div><!-- .sidebarBox -->
            </aside>
			<!-- aside -->
			<!-- #sideRight -->

		</div><!-- #container-->
		

	</section><!-- #middle-->

	</div><!-- #wrapper-->

	<footer id="footer">
		<div class="center">
			<?php include("footer.php"); ?>
		</div><!-- .center -->
	</footer><!-- #footer -->


  <script type="text/javascript">

  $(document).ready(function(){


  for (var def = 1; def < 33; def++) {
    for (var cdef = 1; cdef < 5; cdef++) {
      $('select#row'+def+'col'+cdef ).css('background', '#FFC4C4');
    };
  };


  // function select change action
  function selectColorColumnAction(rowNum){

    // generate action change for all columns
    for (var e = 1; e < 5; e++) {

      // generate single++ column action change
      $('select#row'+rowNum+'col'+e).live('change', function(){

        // generate col1 to col4 action
        for (var i = 1; i < 5; i++) {

          // if select equal 0 set red
          if ($('select#row'+rowNum+'col'+i).val() == 0) {
            $('select#row'+rowNum+'col'+i).css('background', '#FF6262');
          } else {
            $('select#row'+rowNum+'col'+i).css('background', '#8CF06A');
          }

        };

      });

    };

  }


  // function selection
  // =======================================
  function rowcolumnselection(rowNumber) {

    // ============================================= MAIN COLUMN 1 ================================================
    $('select#row'+rowNumber+'col1').live('change', function(){

      var rc1Value = $('select#row'+rowNumber+'col1').val();


      // ========================================== EMPAT ====================================
      // ========================================== EMPAT ====================================
      // ========================================== EMPAT ====================================
      // ========================================== EMPAT ====================================
      if (rc1Value == '4') {

        $('select#row'+rowNumber+'col2 option[value="'+rc1Value+'"]').remove();
        $('select#row'+rowNumber+'col3 option[value="'+rc1Value+'"]').remove();
        $('select#row'+rowNumber+'col4 option[value="'+rc1Value+'"]').remove();


        $('select#row'+rowNumber+'col1 option[value="3"]').remove();
        $('select#row'+rowNumber+'col1 option[value="2"]').remove();
        $('select#row'+rowNumber+'col1 option[value="1"]').remove();



        // ============ SELECT COL2 =============================
        // ============ SELECT COL2 =============================
        // ============ SELECT COL2 =============================
        // ============ SELECT COL2 =============================
        $('select#row'+rowNumber+'col2').live('change', function(){

          var rc2Value = $('select#row'+rowNumber+'col2').val();


          if (rc2Value == '3' && rc1Value == '4') {

            $('select#row'+rowNumber+'col3 option[value="'+rc2Value+'"]').remove();
            $('select#row'+rowNumber+'col4 option[value="'+rc2Value+'"]').remove();


            // remove
            $('select#row'+rowNumber+'col2 option[value="4"]').remove();
            $('select#row'+rowNumber+'col2 option[value="2"]').remove();
            $('select#row'+rowNumber+'col2 option[value="1"]').remove();

          };

          if (rc2Value == '2' && rc1Value == '4') {

            $('select#row'+rowNumber+'col3 option[value="'+rc2Value+'"]').remove();
            $('select#row'+rowNumber+'col4 option[value="'+rc2Value+'"]').remove();


            // remove
            $('select#row'+rowNumber+'col2 option[value="4"]').remove();
            $('select#row'+rowNumber+'col2 option[value="3"]').remove();
            $('select#row'+rowNumber+'col2 option[value="1"]').remove();

          };

          if (rc2Value == '1' && rc1Value == '4') {

            $('select#row'+rowNumber+'col3 option[value="'+rc2Value+'"]').remove();
            $('select#row'+rowNumber+'col4 option[value="'+rc2Value+'"]').remove();


            // remove
            $('select#row'+rowNumber+'col2 option[value="4"]').remove();
            $('select#row'+rowNumber+'col2 option[value="3"]').remove();
            $('select#row'+rowNumber+'col2 option[value="2"]').remove();
          };

        });



        // ============ SELECT COL3 =============================
        // ============ SELECT COL3 =============================
        // ============ SELECT COL3 =============================
        // ============ SELECT COL3 =============================
        $('select#row'+rowNumber+'col3').live('change', function(){

          var rc3Value = $('select#row'+rowNumber+'col3').val();

          if (rc3Value == '2' && rc1Value == '4') {

            $('select#row'+rowNumber+'col4 option[value="'+rc3Value+'"]').remove();


            // remove
            $('select#row'+rowNumber+'col3 option[value="4"]').remove();
            $('select#row'+rowNumber+'col3 option[value="3"]').remove();
            $('select#row'+rowNumber+'col3 option[value="1"]').remove();

          };

          if (rc3Value == '1' && rc1Value == '4') {

            $('select#row'+rowNumber+'col4 option[value="'+rc3Value+'"]').remove();


            // remove
            $('select#row'+rowNumber+'col3 option[value="4"]').remove();
            $('select#row'+rowNumber+'col3 option[value="3"]').remove();
            $('select#row'+rowNumber+'col3 option[value="2"]').remove();

          };

          if (rc3Value == '3' && rc1Value == '4') {

            $('select#row'+rowNumber+'col4 option[value="'+rc3Value+'"]').remove();


            // remove
            $('select#row'+rowNumber+'col3 option[value="4"]').remove();
            $('select#row'+rowNumber+'col3 option[value="2"]').remove();
            $('select#row'+rowNumber+'col3 option[value="1"]').remove();
          };

        });

      };





      // ========================================== TIGA ====================================
      // ========================================== TIGA ====================================
      // ========================================== TIGA ====================================
      // ========================================== TIGA ====================================
      if (rc1Value == '3') {

        $('select#row'+rowNumber+'col2 option[value="'+rc1Value+'"]').remove();
        $('select#row'+rowNumber+'col3 option[value="'+rc1Value+'"]').remove();
        $('select#row'+rowNumber+'col4 option[value="'+rc1Value+'"]').remove();


        $('select#row'+rowNumber+'col1 option[value="4"]').remove();
        $('select#row'+rowNumber+'col1 option[value="2"]').remove();
        $('select#row'+rowNumber+'col1 option[value="1"]').remove();



        // ============ SELECT COL2 =============================
        // ============ SELECT COL2 =============================
        // ============ SELECT COL2 =============================
        // ============ SELECT COL2 =============================
        $('select#row'+rowNumber+'col2').live('change', function(){

          var rc2Value = $('select#row'+rowNumber+'col2').val();


          if (rc2Value == '4' && rc1Value == '3') {

            $('select#row'+rowNumber+'col3 option[value="'+rc2Value+'"]').remove();
            $('select#row'+rowNumber+'col4 option[value="'+rc2Value+'"]').remove();


            // remove
            $('select#row'+rowNumber+'col2 option[value="3"]').remove();
            $('select#row'+rowNumber+'col2 option[value="2"]').remove();
            $('select#row'+rowNumber+'col2 option[value="1"]').remove();

          };

          if (rc2Value == '2' && rc1Value == '3') {

            $('select#row'+rowNumber+'col3 option[value="'+rc2Value+'"]').remove();
            $('select#row'+rowNumber+'col4 option[value="'+rc2Value+'"]').remove();


            // remove
            $('select#row'+rowNumber+'col2 option[value="4"]').remove();
            $('select#row'+rowNumber+'col2 option[value="3"]').remove();
            $('select#row'+rowNumber+'col2 option[value="1"]').remove();

          };

          if (rc2Value == '1' && rc1Value == '3') {

            $('select#row'+rowNumber+'col3 option[value="'+rc2Value+'"]').remove();
            $('select#row'+rowNumber+'col4 option[value="'+rc2Value+'"]').remove();


            // remove
            $('select#row'+rowNumber+'col2 option[value="4"]').remove();
            $('select#row'+rowNumber+'col2 option[value="3"]').remove();
            $('select#row'+rowNumber+'col2 option[value="2"]').remove();
          };

        });



        // ============ SELECT COL3 =============================
        // ============ SELECT COL3 =============================
        // ============ SELECT COL3 =============================
        // ============ SELECT COL3 =============================
        $('select#row'+rowNumber+'col3').live('change', function(){

          var rc3Value = $('select#row'+rowNumber+'col3').val();

          if (rc3Value == '2' && rc1Value == '3') {

            $('select#row'+rowNumber+'col4 option[value="'+rc3Value+'"]').remove();


            // remove
            $('select#row'+rowNumber+'col3 option[value="4"]').remove();
            $('select#row'+rowNumber+'col3 option[value="3"]').remove();
            $('select#row'+rowNumber+'col3 option[value="1"]').remove();

          };

          if (rc3Value == '1' && rc1Value == '3') {

            $('select#row'+rowNumber+'col4 option[value="'+rc3Value+'"]').remove();


            // remove
            $('select#row'+rowNumber+'col3 option[value="4"]').remove();
            $('select#row'+rowNumber+'col3 option[value="3"]').remove();
            $('select#row'+rowNumber+'col3 option[value="2"]').remove();

          };

          if (rc3Value == '4' && rc1Value == '3') {

            $('select#row'+rowNumber+'col4 option[value="'+rc3Value+'"]').remove();


            // remove
            $('select#row'+rowNumber+'col3 option[value="3"]').remove();
            $('select#row'+rowNumber+'col3 option[value="2"]').remove();
            $('select#row'+rowNumber+'col3 option[value="1"]').remove();
          };

        });

      };



      // ========================================== DUA ====================================
      // ========================================== DUA ====================================
      // ========================================== DUA ====================================
      // ========================================== DUA ====================================
      if (rc1Value == '2') {

        $('select#row'+rowNumber+'col2 option[value="'+rc1Value+'"]').remove();
        $('select#row'+rowNumber+'col3 option[value="'+rc1Value+'"]').remove();
        $('select#row'+rowNumber+'col4 option[value="'+rc1Value+'"]').remove();


        $('select#row'+rowNumber+'col1 option[value="4"]').remove();
        $('select#row'+rowNumber+'col1 option[value="3"]').remove();
        $('select#row'+rowNumber+'col1 option[value="1"]').remove();



        // ============ SELECT COL2 =============================
        // ============ SELECT COL2 =============================
        // ============ SELECT COL2 =============================
        // ============ SELECT COL2 =============================
        $('select#row'+rowNumber+'col2').live('change', function(){

          var rc2Value = $('select#row'+rowNumber+'col2').val();


          if (rc2Value == '4' && rc1Value == '2') {

            $('select#row'+rowNumber+'col3 option[value="'+rc2Value+'"]').remove();
            $('select#row'+rowNumber+'col4 option[value="'+rc2Value+'"]').remove();


            // remove
            $('select#row'+rowNumber+'col2 option[value="3"]').remove();
            $('select#row'+rowNumber+'col2 option[value="2"]').remove();
            $('select#row'+rowNumber+'col2 option[value="1"]').remove();

          };

          if (rc2Value == '3' && rc1Value == '2') {

            $('select#row'+rowNumber+'col3 option[value="'+rc2Value+'"]').remove();
            $('select#row'+rowNumber+'col4 option[value="'+rc2Value+'"]').remove();


            // remove
            $('select#row'+rowNumber+'col2 option[value="4"]').remove();
            $('select#row'+rowNumber+'col2 option[value="2"]').remove();
            $('select#row'+rowNumber+'col2 option[value="1"]').remove();

          };

          if (rc2Value == '1' && rc1Value == '2') {

            $('select#row'+rowNumber+'col3 option[value="'+rc2Value+'"]').remove();
            $('select#row'+rowNumber+'col4 option[value="'+rc2Value+'"]').remove();


            // remove
            $('select#row'+rowNumber+'col2 option[value="4"]').remove();
            $('select#row'+rowNumber+'col2 option[value="3"]').remove();
            $('select#row'+rowNumber+'col2 option[value="2"]').remove();
          };

        });



        // ============ SELECT COL3 =============================
        // ============ SELECT COL3 =============================
        // ============ SELECT COL3 =============================
        // ============ SELECT COL3 =============================
        $('select#row'+rowNumber+'col3').live('change', function(){

          var rc3Value = $('select#row'+rowNumber+'col3').val();

          if (rc3Value == '3' && rc1Value == '2') {

            $('select#row'+rowNumber+'col4 option[value="'+rc3Value+'"]').remove();


            // remove
            $('select#row'+rowNumber+'col3 option[value="4"]').remove();
            $('select#row'+rowNumber+'col3 option[value="2"]').remove();
            $('select#row'+rowNumber+'col3 option[value="1"]').remove();

          };

          if (rc3Value == '1' && rc1Value == '2') {

            $('select#row'+rowNumber+'col4 option[value="'+rc3Value+'"]').remove();


            // remove
            $('select#row'+rowNumber+'col3 option[value="4"]').remove();
            $('select#row'+rowNumber+'col3 option[value="3"]').remove();
            $('select#row'+rowNumber+'col3 option[value="2"]').remove();

          };

          if (rc3Value == '4' && rc1Value == '2') {

            $('select#row'+rowNumber+'col4 option[value="'+rc3Value+'"]').remove();


            // remove
            $('select#row'+rowNumber+'col3 option[value="3"]').remove();
            $('select#row'+rowNumber+'col3 option[value="2"]').remove();
            $('select#row'+rowNumber+'col3 option[value="1"]').remove();
          };

        });

      };




      // ========================================== SATU ====================================
      // ========================================== SATU ====================================
      // ========================================== SATU ====================================
      // ========================================== SATU ====================================
      if (rc1Value == '1') {

        $('select#row'+rowNumber+'col2 option[value="'+rc1Value+'"]').remove();
        $('select#row'+rowNumber+'col3 option[value="'+rc1Value+'"]').remove();
        $('select#row'+rowNumber+'col4 option[value="'+rc1Value+'"]').remove();


        $('select#row'+rowNumber+'col1 option[value="4"]').remove();
        $('select#row'+rowNumber+'col1 option[value="3"]').remove();
        $('select#row'+rowNumber+'col1 option[value="2"]').remove();



        // ============ SELECT COL2 =============================
        // ============ SELECT COL2 =============================
        // ============ SELECT COL2 =============================
        // ============ SELECT COL2 =============================
        $('select#row'+rowNumber+'col2').live('change', function(){

          var rc2Value = $('select#row'+rowNumber+'col2').val();


          if (rc2Value == '4' && rc1Value == '1') {

            $('select#row'+rowNumber+'col3 option[value="'+rc2Value+'"]').remove();
            $('select#row'+rowNumber+'col4 option[value="'+rc2Value+'"]').remove();


            // remove
            $('select#row'+rowNumber+'col2 option[value="3"]').remove();
            $('select#row'+rowNumber+'col2 option[value="2"]').remove();
            $('select#row'+rowNumber+'col2 option[value="1"]').remove();

          };

          if (rc2Value == '3' && rc1Value == '1') {

            $('select#row'+rowNumber+'col3 option[value="'+rc2Value+'"]').remove();
            $('select#row'+rowNumber+'col4 option[value="'+rc2Value+'"]').remove();


            // remove
            $('select#row'+rowNumber+'col2 option[value="4"]').remove();
            $('select#row'+rowNumber+'col2 option[value="2"]').remove();
            $('select#row'+rowNumber+'col2 option[value="1"]').remove();

          };

          if (rc2Value == '2' && rc1Value == '1') {

            $('select#row'+rowNumber+'col3 option[value="'+rc2Value+'"]').remove();
            $('select#row'+rowNumber+'col4 option[value="'+rc2Value+'"]').remove();


            // remove
            $('select#row'+rowNumber+'col2 option[value="4"]').remove();
            $('select#row'+rowNumber+'col2 option[value="3"]').remove();
            $('select#row'+rowNumber+'col2 option[value="1"]').remove();
          };

        });



        // ============ SELECT COL3 =============================
        // ============ SELECT COL3 =============================
        // ============ SELECT COL3 =============================
        // ============ SELECT COL3 =============================
        $('select#row'+rowNumber+'col3').live('change', function(){

          var rc3Value = $('select#row'+rowNumber+'col3').val();

          if (rc3Value == '3' && rc1Value == '1') {

            $('select#row'+rowNumber+'col4 option[value="'+rc3Value+'"]').remove();


            // remove
            $('select#row'+rowNumber+'col3 option[value="4"]').remove();
            $('select#row'+rowNumber+'col3 option[value="2"]').remove();
            $('select#row'+rowNumber+'col3 option[value="1"]').remove();

          };

          if (rc3Value == '2' && rc1Value == '1') {

            $('select#row'+rowNumber+'col4 option[value="'+rc3Value+'"]').remove();


            // remove
            $('select#row'+rowNumber+'col3 option[value="4"]').remove();
            $('select#row'+rowNumber+'col3 option[value="3"]').remove();
            $('select#row'+rowNumber+'col3 option[value="1"]').remove();

          };

          if (rc3Value == '4' && rc1Value == '1') {

            $('select#row'+rowNumber+'col4 option[value="'+rc3Value+'"]').remove();


            // remove
            $('select#row'+rowNumber+'col3 option[value="3"]').remove();
            $('select#row'+rowNumber+'col3 option[value="2"]').remove();
            $('select#row'+rowNumber+'col3 option[value="1"]').remove();
          };

        });

      };



      // ========================================== RESET ====================================
      // ========================================== RESET ====================================
      // ========================================== RESET ====================================
      // ========================================== RESET ====================================

      if (rc1Value == '0') {

        $('select#row'+rowNumber+'col1').html('<option value="0">Choose</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option>');
        $('select#row'+rowNumber+'col2').html('<option value="0">Choose</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option>');
        $('select#row'+rowNumber+'col3').html('<option value="0">Choose</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option>');
        $('select#row'+rowNumber+'col4').html('<option value="0">Choose</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option>');
      };

    });

  }




  // function sum all row at column 
  // =======================================
  function sumAllCol(columnNumber) {


    var row1  = parseInt($('select#row1col'+columnNumber).val());
    var row2  = parseInt($('select#row2col'+columnNumber).val());
    var row3  = parseInt($('select#row3col'+columnNumber).val());
    var row4  = parseInt($('select#row4col'+columnNumber).val());
    var row5  = parseInt($('select#row5col'+columnNumber).val());

    var row6  = parseInt($('select#row6col'+columnNumber).val());
    var row7  = parseInt($('select#row7col'+columnNumber).val());
    var row8  = parseInt($('select#row8col'+columnNumber).val());
    var row9  = parseInt($('select#row9col'+columnNumber).val());
    var row10 = parseInt($('select#row10col'+columnNumber).val());

    var row11  = parseInt($('select#row11col'+columnNumber).val());
    var row12  = parseInt($('select#row12col'+columnNumber).val());
    var row13  = parseInt($('select#row13col'+columnNumber).val());
    var row14  = parseInt($('select#row14col'+columnNumber).val());
    var row15  = parseInt($('select#row15col'+columnNumber).val());

    var row16  = parseInt($('select#row16col'+columnNumber).val());
    var row17  = parseInt($('select#row17col'+columnNumber).val());
    var row18  = parseInt($('select#row18col'+columnNumber).val());
    var row19  = parseInt($('select#row19col'+columnNumber).val());
    var row20 = parseInt($('select#row20col'+columnNumber).val());

    var row21  = parseInt($('select#row21col'+columnNumber).val());
    var row22  = parseInt($('select#row22col'+columnNumber).val());
    var row23  = parseInt($('select#row23col'+columnNumber).val());
    var row24  = parseInt($('select#row24col'+columnNumber).val());
    var row25  = parseInt($('select#row25col'+columnNumber).val());

    var row26  = parseInt($('select#row26col'+columnNumber).val());
    var row27  = parseInt($('select#row27col'+columnNumber).val());
    var row28  = parseInt($('select#row28col'+columnNumber).val());
    var row29  = parseInt($('select#row29col'+columnNumber).val());
    var row30 = parseInt($('select#row30col'+columnNumber).val());

    var row31  = parseInt($('select#row31col'+columnNumber).val());
    var row32  = parseInt($('select#row32col'+columnNumber).val());


    var result = (row1+row2+row3+row4+row5+row6+row7+row8+row9+row10+row11+row12+row13+row14+row15+row16+row17+row18+row19+row20+row21+row22+row23+row24+row25+row26+row27+row28+row29+row30+row31+row32);



    return result;

  }




  // generate row column select action change
  // =========================================
  for (var rowAction = 1; rowAction < 33; rowAction++) {
    selectColorColumnAction(rowAction);
  };





  // generate selection question
  // =======================================
  for (var i = 1; i < 33; i++) {

    rowcolumnselection(i);

  };












  // generate result
  // =======================================
  $('input#getresult').live('click', function() {


    for (var i = 1; i < 5; i++) {
      $('span#allCol'+i).text(sumAllCol(i));
      $('input#val'+i).val(sumAllCol(i));
      console.log(sumAllCol(i));
    };

    $('input#newDiscTest_submitResult').show();

  });








  // save disc result
  // ==========================================
  $('input#newDiscTest_submitResult').live('click', function(){

    var data = $('form#discForm').serialize();

    var answer = confirm("Are you sure want to save this result?");
    if (answer) {
      $.ajax({
        data : data,
        url : "newDiscTest_submitResult.php",
        type: "post",

        success:function(html){
          console.log(html);
          $('input#newDiscTest_submitResult').val('Result Saved!').delay(2000).hide('slow');
        }

      });
    } else {
      return false;
    }

    return false;

  });


  });

</script>

</body>
</html>
<?php
mysql_free_result($rsEduList);

mysql_free_result($rsFieldList);

mysql_free_result($rsGradeList);

mysql_free_result($rsLocatedList);
?>
