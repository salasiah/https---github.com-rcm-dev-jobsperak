<?php require_once('Connections/conJobsPerak.php'); ?>
<?php 
// General
$nationality = mysql_real_escape_string(@$_GET['nationality']);
$dob_month = mysql_real_escape_string(@$_GET['dob_month']);
$dob_year = mysql_real_escape_string(@$_GET['dob_year']);

// SPM
$spm_subject = mysql_real_escape_string(@$_GET['spm_subject']);
$spm_subject_grade = rawurldecode(mysql_real_escape_string(@$_GET['spm_subject_grade']));

// Education
$graduate_year = mysql_real_escape_string(@$_GET['graduate_year']);
$qualification = mysql_real_escape_string(@$_GET['qualification']);
$field_of_study = mysql_real_escape_string(@$_GET['field_of_study']);
$cgpa = mysql_real_escape_string(@$_GET['cgpa']);

// Languae
$language = mysql_real_escape_string(@$_GET['language']);
$lang_spoken = mysql_real_escape_string(@$_GET['lang_spoken']);
$lang_written = mysql_real_escape_string(@$_GET['lang_written']);

// Preferences
$prefer_location = mysql_real_escape_string(@$_GET['prefer_location']);
$industry = mysql_real_escape_string(@$_GET['industry']);
$salary = mysql_real_escape_string(@$_GET['salary']);

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

$currentPage = $_SERVER["PHP_SELF"];

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

$colname_rsEmployerProfile = "-1";
if (isset($_GET['cuid'])) {
  $colname_rsEmployerProfile = $_GET['cuid'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsEmployerProfile = sprintf("SELECT * FROM jp_users WHERE users_id = %s", GetSQLValueString($colname_rsEmployerProfile, "int"));
$rsEmployerProfile = mysql_query($query_rsEmployerProfile, $conJobsPerak) or die(mysql_error());
$row_rsEmployerProfile = mysql_fetch_assoc($rsEmployerProfile);
$totalRows_rsEmployerProfile = mysql_num_rows($rsEmployerProfile);

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsIndustry = "SELECT * FROM jp_industry WHERE industry_parent = 0";
$rsIndustry = mysql_query($query_rsIndustry, $conJobsPerak) or die(mysql_error());
$row_rsIndustry = mysql_fetch_assoc($rsIndustry);
$totalRows_rsIndustry = mysql_num_rows($rsIndustry);

$colname_rsCompanyInfoDetail = "-1";
if (isset($_GET['cuid'])) {
  $colname_rsCompanyInfoDetail = $_GET['cuid'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsCompanyInfoDetail = sprintf("SELECT * FROM jp_employer WHERE users_id_fk = %s", GetSQLValueString($colname_rsCompanyInfoDetail, "int"));
$rsCompanyInfoDetail = mysql_query($query_rsCompanyInfoDetail, $conJobsPerak) or die(mysql_error());
$row_rsCompanyInfoDetail = mysql_fetch_assoc($rsCompanyInfoDetail);
$totalRows_rsCompanyInfoDetail = mysql_num_rows($rsCompanyInfoDetail);

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsLoc = "SELECT * FROM jp_location WHERE location_parent = 0";
$rsLoc = mysql_query($query_rsLoc, $conJobsPerak) or die(mysql_error());
$row_rsLoc = mysql_fetch_assoc($rsLoc);
$totalRows_rsLoc = mysql_num_rows($rsLoc);

//$colname_rsEmployerId = $_SESSION['MM_UserID'];
if (isset($_SESSION['MM_UserID'])) {
  $colname_rsEmployerId = $_SESSION['MM_UserID'];
}
$colname_rsEmployerId = "-1";
if (isset($_GET['emp_id'])) {
  $colname_rsEmployerId = $_GET['emp_id'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsEmployerId = sprintf("SELECT emp_id FROM jp_employer WHERE emp_id = %s", GetSQLValueString($colname_rsEmployerId, "int"));
$rsEmployerId = mysql_query($query_rsEmployerId, $conJobsPerak) or die(mysql_error());
$row_rsEmployerId = mysql_fetch_assoc($rsEmployerId);
$totalRows_rsEmployerId = mysql_num_rows($rsEmployerId);

$maxRows_rsJobSeekerList = 20;
$pageNum_rsJobSeekerList = 0;
if (isset($_GET['pageNum_rsJobSeekerList'])) {
  $pageNum_rsJobSeekerList = $_GET['pageNum_rsJobSeekerList'];
}
$startRow_rsJobSeekerList = $pageNum_rsJobSeekerList * $maxRows_rsJobSeekerList;
mysql_select_db($database_conJobsPerak, $conJobsPerak);

// remove this until
/*---------------------------------------------------------------------------------------*/



/****************************************************************************************
 * GENERAL FILTERING
 ****************************************************************************************/
 
if(@$_GET['submitGeneral'] == "Search")
{
 
// default all 0
if($nationality == 0 && $dob_month == 0 && $dob_year == 0)
{
$query_rsJobSeekerList = "Select   jp_users.*,   jp_jobseeker.*,   jp_users.users_type As users_type1 From   jp_users Inner Join   jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Where   jp_users.user_active = 1 And   jp_users.users_type = 1 
Group By
  jp_jobseeker.users_id_fk";
}

// all three parameter have avalue
if($nationality != 0 && $dob_month != 0 && $dob_year != 0)
{
$query_rsJobSeekerList = "Select
  jp_users.*,
  jp_jobseeker.*,
  jp_users.users_type As users_type1,
  jp_jobseeker.jobseeker_nationality As jobseeker_nationality1,
  jp_jobseeker.jobseeker_dob_m As jobseeker_dob_m1,
  jp_jobseeker.jobseeker_dob_y As jobseeker_dob_y1
From
  jp_users Inner Join
  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk
Where
  jp_users.user_active = 1 And
  jp_users.users_type = 1 And
  jp_jobseeker.jobseeker_nationality = $nationality And
  jp_jobseeker.jobseeker_dob_m = $dob_month And
  jp_jobseeker.jobseeker_dob_y = $dob_year 
Group By
  jp_jobseeker.users_id_fk";
}

// 2 parameter have value nationality and month
if($nationality != 0 && $dob_month != 0 && $dob_year == 0)
{
$query_rsJobSeekerList = "Select
  jp_users.*,
  jp_jobseeker.*,
  jp_users.users_type As users_type1,
  jp_jobseeker.jobseeker_nationality As jobseeker_nationality1,
  jp_jobseeker.jobseeker_dob_m As jobseeker_dob_m1,
  jp_jobseeker.jobseeker_dob_y As jobseeker_dob_y1
From
  jp_users Inner Join
  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk
Where
  jp_users.user_active = 1 And
  jp_users.users_type = 1 And
  jp_jobseeker.jobseeker_nationality = $nationality And
  jp_jobseeker.jobseeker_dob_m = $dob_month 
Group By
  jp_jobseeker.users_id_fk";
}

// 2 parameter nationality and year
if($nationality != 0 && $dob_month == 0 && $dob_year != 0)
{
$query_rsJobSeekerList = "Select
  jp_users.*,
  jp_jobseeker.*,
  jp_users.users_type As users_type1,
  jp_jobseeker.jobseeker_nationality As jobseeker_nationality1,
  jp_jobseeker.jobseeker_dob_m As jobseeker_dob_m1,
  jp_jobseeker.jobseeker_dob_y As jobseeker_dob_y1
From
  jp_users Inner Join
  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk
Where
  jp_users.user_active = 1 And
  jp_users.users_type = 1 And
  jp_jobseeker.jobseeker_nationality = $nationality And
  jp_jobseeker.jobseeker_dob_y = $dob_year 
Group By
  jp_jobseeker.users_id_fk";
}

// 2 parameter month and year
if($nationality == 0 && $dob_month != 0 && $dob_year != 0)
{
$query_rsJobSeekerList = "Select
  jp_users.*,
  jp_jobseeker.*,
  jp_users.users_type As users_type1,
  jp_jobseeker.jobseeker_nationality As jobseeker_nationality1,
  jp_jobseeker.jobseeker_dob_m As jobseeker_dob_m1,
  jp_jobseeker.jobseeker_dob_y As jobseeker_dob_y1
From
  jp_users Inner Join
  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk
Where
  jp_users.user_active = 1 And
  jp_users.users_type = 1 And
  jp_jobseeker.jobseeker_dob_y = $dob_year And
  jp_jobseeker.jobseeker_dob_m = $dob_month 
Group By
  jp_jobseeker.users_id_fk";
}

// 1 only for nationality
if($nationality != 0 && $dob_month == 0 && $dob_year == 0)
{
$query_rsJobSeekerList = "Select
  jp_users.*,
  jp_jobseeker.*,
  jp_users.users_type As users_type1,
  jp_jobseeker.jobseeker_nationality As jobseeker_nationality1,
  jp_jobseeker.jobseeker_dob_m As jobseeker_dob_m1,
  jp_jobseeker.jobseeker_dob_y As jobseeker_dob_y1
From
  jp_users Inner Join
  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk
Where
  jp_users.user_active = 1 And
  jp_users.users_type = 1 And
  jp_jobseeker.jobseeker_nationality = $nationality 
Group By
  jp_jobseeker.users_id_fk";
}

// 1 only for month
if($nationality == 0 && $dob_month != 0 && $dob_year == 0)
{
$query_rsJobSeekerList = "Select
  jp_users.*,
  jp_jobseeker.*,
  jp_users.users_type As users_type1,
  jp_jobseeker.jobseeker_nationality As jobseeker_nationality1,
  jp_jobseeker.jobseeker_dob_m As jobseeker_dob_m1,
  jp_jobseeker.jobseeker_dob_y As jobseeker_dob_y1
From
  jp_users Inner Join
  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk
Where
  jp_users.user_active = 1 And
  jp_users.users_type = 1 And
  jp_jobseeker.jobseeker_dob_m = $dob_month 
Group By
  jp_jobseeker.users_id_fk";
}

// 1 only for year
if($nationality == 0 && $dob_month == 0 && $dob_year != 0)
{
$query_rsJobSeekerList = "Select
  jp_users.*,
  jp_jobseeker.*,
  jp_users.users_type As users_type1,
  jp_jobseeker.jobseeker_nationality As jobseeker_nationality1,
  jp_jobseeker.jobseeker_dob_m As jobseeker_dob_m1,
  jp_jobseeker.jobseeker_dob_y As jobseeker_dob_y1
From
  jp_users Inner Join
  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk
Where
  jp_users.user_active = 1 And
  jp_users.users_type = 1 And
  jp_jobseeker.jobseeker_dob_y = $dob_year
Group By
  jp_jobseeker.users_id_fk";
}

}



/****************************************************************************************
 * SPM FILTERING
 ****************************************************************************************/
 
 if(@$_GET['submitSPM'] == "Search")
 {
 
 if(($spm_subject_grade != 0 || $spm_subject_grade != NULL) && $spm_subject != 0)
 {
	 $query_rsJobSeekerList = "Select
		  jp_users.*,
		  jp_jobseeker.*,
		  jp_users.users_type As users_type1,
		  jp_spm.spm_subject_id_fk,
		  jp_spm.spm_grade
		From
		  jp_users Inner Join
		  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
		  jp_spm On jp_spm.user_id_fk = jp_users.users_id
		Where
		  jp_users.users_type = 1 And
		  jp_users.user_active = 1 And
		  jp_spm.spm_subject_id_fk = $spm_subject And
		  jp_spm.spm_grade = '$spm_subject_grade'  
		Group By
		  jp_spm.spm_grade";
 }
 
  if(($spm_subject_grade == 0 || $spm_subject_grade == NULL) && $spm_subject == 0)
 {
	 $query_rsJobSeekerList = "Select
		  jp_users.*,
		  jp_jobseeker.*,
		  jp_users.users_type As users_type1,
		  jp_spm.spm_subject_id_fk,
		  jp_spm.spm_grade
		From
		  jp_users Inner Join
		  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
		  jp_spm On jp_spm.user_id_fk = jp_users.users_id
		Where
		  jp_users.users_type = 1 And
		  jp_users.user_active = 1 And
		  jp_spm.spm_subject_id_fk = 0 And
		  jp_spm.spm_grade = 0 
		Group By
		  jp_spm.spm_grade";
 }
 
 }
 
 
 /****************************************************************************************
 * LANGUAGE FILTERING
 ****************************************************************************************/
 
if(@$_GET['submitLang'] == "Search")
{
	if($language == 0 && $lang_spoken == 0 && $lang_written == 0)
	 {
		 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_language On jp_language.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_users.user_active = 1 And
			  jp_language.lang_name = 0 And
			  jp_language.lang_written = 0 And
			  jp_language.lang_spoken = 0  
			Group By
			  jp_language.user_id_fk";
	 }
	 
	 if($language != 0 && $lang_spoken != 0 && $lang_written != 0)
	 {
		 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_language On jp_language.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_users.user_active = 1 And
			  jp_language.lang_name = $language And
			  jp_language.lang_written = $lang_written And
			  jp_language.lang_spoken = $lang_spoken  
			Group By
			  jp_language.user_id_fk";
	 }
	 
	 if($language != 0 && $lang_spoken != 0 && $lang_written == 0)
	 {
		 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_language On jp_language.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_users.user_active = 1 And
			  jp_language.lang_name = $language And
			  jp_language.lang_spoken = $lang_spoken  
			Group By
			  jp_language.user_id_fk";
	 }
	 
	 if($language != 0 && $lang_spoken == 0 && $lang_written != 0)
	 {
		 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_language On jp_language.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_users.user_active = 1 And
			  jp_language.lang_name = $language And
			  jp_language.lang_written = $lang_written  
			Group By
			  jp_language.user_id_fk";
	 }
	 
	 if($language != 0 && $lang_spoken == 0 && $lang_written == 0)
	 {
		 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_language On jp_language.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_users.user_active = 1 And
			  jp_language.lang_name = 0  
			Group By
			  jp_language.user_id_fk";
	 }
	 
	 if($language == 0 && $lang_spoken != 0 && $lang_written == 0)
	 {
		 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_language On jp_language.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_users.user_active = 1 And
			  jp_language.lang_spoken = 0  
			Group By
			  jp_language.user_id_fk";
	 }
	 
	 if($language == 0 && $lang_spoken == 0 && $lang_written != 0)
	 {
		 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_language On jp_language.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_users.user_active = 1 And
			  jp_language.lang_written = 0  
			Group By
			  jp_language.user_id_fk";
	 }
	 
	 if($language == 0 && $lang_spoken != 0 && $lang_written != 0)
	 {
		 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_language On jp_language.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_users.user_active = 1 And
			  jp_language.lang_written = 0 And
			  jp_language.lang_spoken = 0 
			Group By
			  jp_language.user_id_fk";
	 }
}
 
 
/****************************************************************************************
 * JOB PREFERENCES FILTERING
 ****************************************************************************************/

if(@$_GET['submitPrefer'] == "Search")
{
	if($prefer_location == 0 && $industry == 0 && $salary == 0)
	 {
		 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1,
			  jp_jobpreferences.jobP_1,
			  jp_jobpreferences.jobP_2,
			  jp_jobpreferences.jobP_salary
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_jobpreferences On jp_jobpreferences.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_users.user_active = 1 And
			  jp_jobpreferences.jobP_1 = 0 And
			  jp_jobpreferences.jobP_2 = 0 And
			  jp_jobpreferences.jobP_salary = 0 
			Group By
			  jp_jobpreferences.user_id_fk";
	 }
	 
	 if($prefer_location != 0 && $industry != 0 && $salary != 0)
	 {
		 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1,
			  jp_jobpreferences.jobP_1,
			  jp_jobpreferences.jobP_2,
			  jp_jobpreferences.jobP_salary
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_jobpreferences On jp_jobpreferences.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_users.user_active = 1 And
			  jp_jobpreferences.jobP_1 = $prefer_location And
			  jp_jobpreferences.jobP_2 = $industry And
			  jp_jobpreferences.jobP_salary <= $salary 
			Group By
			  jp_jobpreferences.user_id_fk";
	 }
	 
	 if($prefer_location != 0 && $industry != 0 && $salary == 0)
	 {
		 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1,
			  jp_jobpreferences.jobP_1,
			  jp_jobpreferences.jobP_2,
			  jp_jobpreferences.jobP_salary
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_jobpreferences On jp_jobpreferences.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_users.user_active = 1 And
			  jp_jobpreferences.jobP_1 = $prefer_location And
			  jp_jobpreferences.jobP_2 = $industry 
			Group By
			  jp_jobpreferences.user_id_fk";
	 }
	 
	 if($prefer_location != 0 && $industry == 0 && $salary != 0)
	 {
		 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1,
			  jp_jobpreferences.jobP_1,
			  jp_jobpreferences.jobP_2,
			  jp_jobpreferences.jobP_salary
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_jobpreferences On jp_jobpreferences.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_users.user_active = 1 And
			  jp_jobpreferences.jobP_1 = $prefer_location And
			  jp_jobpreferences.jobP_salary = $salary 
			Group By
			  jp_jobpreferences.user_id_fk";
	 }
	 
	 if($prefer_location == 0 && $industry != 0 && $salary != 0)
	 {
		 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1,
			  jp_jobpreferences.jobP_1,
			  jp_jobpreferences.jobP_2,
			  jp_jobpreferences.jobP_salary
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_jobpreferences On jp_jobpreferences.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_users.user_active = 1 And
			  jp_jobpreferences.jobP_2 = $industry And
			  jp_jobpreferences.jobP_salary = $salary 
			Group By
			  jp_jobpreferences.user_id_fk";
	 }
	 
	 if($prefer_location != 0 && $industry == 0 && $salary == 0)
	 {
		 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1,
			  jp_jobpreferences.jobP_1,
			  jp_jobpreferences.jobP_2,
			  jp_jobpreferences.jobP_salary
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_jobpreferences On jp_jobpreferences.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_users.user_active = 1 And
			  jp_jobpreferences.jobP_1 = $prefer_location
			Group By
			  jp_jobpreferences.user_id_fk";
	 }
	 
	 if($prefer_location == 0 && $industry != 0 && $salary == 0)
	 {
		 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1,
			  jp_jobpreferences.jobP_1,
			  jp_jobpreferences.jobP_2,
			  jp_jobpreferences.jobP_salary
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_jobpreferences On jp_jobpreferences.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_users.user_active = 1 And
			  jp_jobpreferences.jobP_2 = $industry
			Group By
			  jp_jobpreferences.user_id_fk";
	 }
	 
	 if($prefer_location == 0 && $industry == 0 && $salary != 0)
	 {
		 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1,
			  jp_jobpreferences.jobP_1,
			  jp_jobpreferences.jobP_2,
			  jp_jobpreferences.jobP_salary
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_jobpreferences On jp_jobpreferences.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_users.user_active = 1 And
			  jp_jobpreferences.jobP_salary <= $salary 
			Group By
			  jp_jobpreferences.user_id_fk";
	 }
}
 
 

/****************************************************************************************
 * EDUCATION FILTERING
 ****************************************************************************************/
 
if(@$_GET['submitEdu'] == "Search")
{
	if($graduate_year == 0 && $qualification == 0 && $field_of_study == 0 && $cgpa == 0)
	 {
		 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_education On jp_education.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_education.edu_date_graduate_year = 2011 And
			  jp_education.edu_qualification = 0 And
			  jp_education.edu_fieldStudy = 0 And
			  jp_education.edu_cgpa = 0 And
			  jp_users.user_active = 1 
		 	Group By
  			  jp_education.user_id_fk";
	 }
	 
	 if($graduate_year != 0 && $qualification != 0 && $field_of_study != 0 && $cgpa != 0)
	 {
		 if($cgpa == 3.5)
		 {
			 
			 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_education On jp_education.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_education.edu_date_graduate_year = $graduate_year And
			  jp_education.edu_qualification = $qualification And
			  jp_education.edu_fieldStudy = $field_of_study And
			  jp_education.edu_cgpa >= '$cgpa' And
			  jp_users.user_active = 1 
		 	Group By
  			  jp_education.user_id_fk";
			 
		 }
		 
		 if($cgpa == 3.49)
		 {
			 
			 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_education On jp_education.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_education.edu_date_graduate_year = $graduate_year And
			  jp_education.edu_qualification = $qualification And
			  jp_education.edu_fieldStudy = $field_of_study And
			  jp_education.edu_cgpa < '3.5' And
			  jp_users.user_active = 1 
		 	Group By
  			  jp_education.user_id_fk";
			 
		 }
	 }
	 
	 
	 
	 if($graduate_year != 0 && $qualification != 0 && $field_of_study != 0 && $cgpa == 0)
	 {	 
		 $query_rsJobSeekerList = "Select
		  jp_users.*,
		  jp_jobseeker.*,
		  jp_users.users_type As users_type1
		From
		  jp_users Inner Join
		  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
		  jp_education On jp_education.user_id_fk = jp_users.users_id
		Where
		  jp_users.users_type = 1 And
		  jp_education.edu_date_graduate_year = $graduate_year And
		  jp_education.edu_qualification = $qualification And
		  jp_education.edu_fieldStudy = $field_of_study And
		  jp_users.user_active = 1 
		 	Group By
  			  jp_education.user_id_fk";
	 }
	 
	 
	 
	 if($graduate_year != 0 && $qualification != 0 && $field_of_study == 0 && $cgpa != 0)
	 {
		 if($cgpa == 3.5)
		 {
			 
			 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_education On jp_education.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_education.edu_date_graduate_year = $graduate_year And
			  jp_education.edu_qualification = $qualification And
			  jp_education.edu_cgpa >= '$cgpa' And
			  jp_users.user_active = 1 
		 	Group By
  			  jp_education.user_id_fk";
			 
		 }
		 
		 if($cgpa == 3.49)
		 {
			 
			 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_education On jp_education.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_education.edu_date_graduate_year = $graduate_year And
			  jp_education.edu_qualification = $qualification And
			  jp_education.edu_cgpa < '3.5' And
			  jp_users.user_active = 1 
		 	Group By
  			  jp_education.user_id_fk";
			 
		 }
	 }
	 
	 
	 
	 
	 if($graduate_year != 0 && $qualification == 0 && $field_of_study != 0 && $cgpa != 0)
	 {
		 if($cgpa == 3.5)
		 {
			 
			 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_education On jp_education.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_education.edu_date_graduate_year = $graduate_year And
			  jp_education.edu_fieldStudy = $field_of_study And
			  jp_education.edu_cgpa >= '$cgpa' And
			  jp_users.user_active = 1 
		 	Group By
  			  jp_education.user_id_fk";
			 
		 }
		 
		 if($cgpa == 3.49)
		 {
			 
			 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_education On jp_education.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_education.edu_date_graduate_year = $graduate_year And
			  jp_education.edu_fieldStudy = $field_of_study And
			  jp_education.edu_cgpa < '3.5' And
			  jp_users.user_active = 1 
		 	Group By
  			  jp_education.user_id_fk";
			 
		 }
	 }
	 
	 
	 if($graduate_year == 0 && $qualification != 0 && $field_of_study != 0 && $cgpa != 0)
	 {
		 if($cgpa == 3.5)
		 {
			 
			 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_education On jp_education.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_education.edu_qualification = $qualification And
			  jp_education.edu_fieldStudy = $field_of_study And
			  jp_education.edu_cgpa >= '$cgpa' And
			  jp_users.user_active = 1 
		 	Group By
  			  jp_education.user_id_fk";
			 
		 }
		 
		 if($cgpa == 3.49)
		 {
			 
			 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_education On jp_education.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_education.edu_qualification = $qualification And
			  jp_education.edu_fieldStudy = $field_of_study And
			  jp_education.edu_cgpa < '3.5' And
			  jp_users.user_active = 1 
		 	Group By
  			  jp_education.user_id_fk";
			 
		 }
	 }
	 
	 
	 
	 // 2 params
	 if($graduate_year != 0 && $qualification == 0 && $field_of_study == 0 && $cgpa != 0)
	 {
		 if($cgpa == 3.5)
		 {
			 
			 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_education On jp_education.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_education.edu_date_graduate_year = $graduate_year And
			  jp_education.edu_cgpa >= '$cgpa' And
			  jp_users.user_active = 1 
		 	Group By
  			  jp_education.user_id_fk";
			 
		 }
		 
		 if($cgpa == 3.49)
		 {
			 
			 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_education On jp_education.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_education.edu_date_graduate_year = $graduate_year And
			  jp_education.edu_cgpa < '3.5' And
			  jp_users.user_active = 1 
		 	Group By
  			  jp_education.user_id_fk";
			 
		 }
	 }
	 
	 
	 if($graduate_year != 0 && $qualification == 0 && $field_of_study != 0 && $cgpa == 0)
	 {
			 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_education On jp_education.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_education.edu_date_graduate_year = $graduate_year And
			  jp_education.edu_fieldStudy = $field_of_study And
			  jp_users.user_active = 1 
		 	Group By
  			  jp_education.user_id_fk";
		
	 }
	 
	 if($graduate_year != 0 && $qualification != 0 && $field_of_study == 0 && $cgpa == 0)
	 {
			 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_education On jp_education.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_education.edu_date_graduate_year = $graduate_year And
			  jp_education.edu_qualification = $qualification And
			  jp_users.user_active = 1 
		 	Group By
  			  jp_education.user_id_fk";
			 
	 }
	 
	 
	 
	 if($graduate_year == 0 && $qualification != 0 && $field_of_study == 0 && $cgpa != 0)
	 {
		 if($cgpa == 3.5)
		 {
			 
			 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_education On jp_education.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_education.edu_qualification = $qualification And
			  jp_education.edu_cgpa >= '$cgpa' And
			  jp_users.user_active = 1 
		 	Group By
  			  jp_education.user_id_fk";
			 
		 }
		 
		 if($cgpa == 3.49)
		 {
			 
			 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_education On jp_education.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_education.edu_qualification = $qualification And
			  jp_education.edu_cgpa < '3.5' And
			  jp_users.user_active = 1 
		 	Group By
  			  jp_education.user_id_fk";
			 
		 }
	 }
	 
	 
	 if($graduate_year == 0 && $qualification != 0 && $field_of_study != 0 && $cgpa == 0)
	 {
		 
			 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_education On jp_education.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_education.edu_qualification = $qualification And
			  jp_education.edu_fieldStudy = $field_of_study And
			  jp_users.user_active = 1 
		 	Group By
  			  jp_education.user_id_fk";
		 
	 }
	 
	 
	 if($graduate_year == 0 && $qualification == 0 && $field_of_study != 0 && $cgpa != 0)
	 {
		 if($cgpa == 3.5)
		 {
			 
			 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_education On jp_education.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_education.edu_fieldStudy = $field_of_study And
			  jp_education.edu_cgpa >= '$cgpa' And
			  jp_users.user_active = 1 
		 	Group By
  			  jp_education.user_id_fk";
			 
		 }
		 
		 if($cgpa == 3.49)
		 {
			 
			 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_education On jp_education.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_education.edu_fieldStudy = $field_of_study And
			  jp_education.edu_cgpa < '3.5' And
			  jp_users.user_active = 1
			Group By
			  jp_education.user_id_fk";
			 
		 }
	 }
	 
	 
	 // 1 parameter
	 if($graduate_year == 0 && $qualification == 0 && $field_of_study == 0 && $cgpa != 0)
	 {
		 if($cgpa == 3.5)
		 {
			 
			 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_education On jp_education.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_education.edu_cgpa >= '$cgpa' And
			  jp_users.user_active = 1
		 	Group By
  			  jp_education.user_id_fk";
			 
		 }
		 
		 if($cgpa == 3.49)
		 {
			 
			 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_education On jp_education.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_education.edu_cgpa < '3.5' And
			  jp_users.user_active = 1
			Group By
			  jp_education.user_id_fk";
			 
		 }
	 }
	 
	 
	 if($graduate_year == 0 && $qualification == 0 && $field_of_study != 0 && $cgpa == 0)
	 {

			 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_education On jp_education.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_education.edu_fieldStudy = $field_of_study And
			  jp_users.user_active = 1
		 	Group By
  			  jp_education.user_id_fk";

	 }
	 
	 if($graduate_year == 0 && $qualification != 0 && $field_of_study == 0 && $cgpa == 0)
	 {

			 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_education On jp_education.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_education.edu_qualification = $qualification And
			  jp_users.user_active = 1
		 	Group By
  			  jp_education.user_id_fk";
	
	 }
	 
	 if($graduate_year != 0 && $qualification == 0 && $field_of_study == 0 && $cgpa == 0)
	 {
		 
			 $query_rsJobSeekerList = "Select
			  jp_users.*,
			  jp_jobseeker.*,
			  jp_users.users_type As users_type1
			From
			  jp_users Inner Join
			  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk Inner Join
			  jp_education On jp_education.user_id_fk = jp_users.users_id
			Where
			  jp_users.users_type = 1 And
			  jp_education.edu_date_graduate_year = $graduate_year And
			  jp_users.user_active = 1
		 	Group By
  			  jp_education.user_id_fk";
			 
	 }
}
 

/*---------------------------------------------------------------------------------------*/
// until this to display data binding

$query_limit_rsJobSeekerList = sprintf("%s LIMIT %d, %d", $query_rsJobSeekerList, $startRow_rsJobSeekerList, $maxRows_rsJobSeekerList);


$rsJobSeekerList = mysql_query($query_limit_rsJobSeekerList, $conJobsPerak) or die(mysql_error());
$row_rsJobSeekerList = mysql_fetch_assoc($rsJobSeekerList);

if (isset($_GET['totalRows_rsJobSeekerList'])) {
  $totalRows_rsJobSeekerList = $_GET['totalRows_rsJobSeekerList'];
} else {
  $all_rsJobSeekerList = mysql_query($query_rsJobSeekerList);
  $totalRows_rsJobSeekerList = mysql_num_rows($all_rsJobSeekerList);
}
$totalPages_rsJobSeekerList = ceil($totalRows_rsJobSeekerList/$maxRows_rsJobSeekerList)-1;

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsLocation = "SELECT * FROM jp_location WHERE location_parent = 0";
$rsLocation = mysql_query($query_rsLocation, $conJobsPerak) or die(mysql_error());
$row_rsLocation = mysql_fetch_assoc($rsLocation);
$totalRows_rsLocation = mysql_num_rows($rsLocation);

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsNationality = "SELECT * FROM jp_nationality";
$rsNationality = mysql_query($query_rsNationality, $conJobsPerak) or die(mysql_error());
$row_rsNationality = mysql_fetch_assoc($rsNationality);
$totalRows_rsNationality = mysql_num_rows($rsNationality);

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_spmSubjectList = "SELECT * FROM jp_spm_subject";
$spmSubjectList = mysql_query($query_spmSubjectList, $conJobsPerak) or die(mysql_error());
$row_spmSubjectList = mysql_fetch_assoc($spmSubjectList);
$totalRows_spmSubjectList = mysql_num_rows($spmSubjectList);

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsQualification = "SELECT * FROM jp_edu_lists";
$rsQualification = mysql_query($query_rsQualification, $conJobsPerak) or die(mysql_error());
$row_rsQualification = mysql_fetch_assoc($rsQualification);
$totalRows_rsQualification = mysql_num_rows($rsQualification);

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsFieldList = "SELECT * FROM jp_field_list";
$rsFieldList = mysql_query($query_rsFieldList, $conJobsPerak) or die(mysql_error());
$row_rsFieldList = mysql_fetch_assoc($rsFieldList);
$totalRows_rsFieldList = mysql_num_rows($rsFieldList);

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsMajorList = "SELECT * FROM jp_specialize";
$rsMajorList = mysql_query($query_rsMajorList, $conJobsPerak) or die(mysql_error());
$row_rsMajorList = mysql_fetch_assoc($rsMajorList);
$totalRows_rsMajorList = mysql_num_rows($rsMajorList);

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsLangList = "SELECT * FROM jp_language_list";
$rsLangList = mysql_query($query_rsLangList, $conJobsPerak) or die(mysql_error());
$row_rsLangList = mysql_fetch_assoc($rsLangList);
$totalRows_rsLangList = mysql_num_rows($rsLangList);

$colname_rsFilterNationality = "-1";
if (isset($_GET['nationality'])) {
  $colname_rsFilterNationality = $_GET['nationality'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsFilterNationality = sprintf("SELECT * FROM jp_nationality WHERE national_id = %s", GetSQLValueString($colname_rsFilterNationality, "int"));
$rsFilterNationality = mysql_query($query_rsFilterNationality, $conJobsPerak) or die(mysql_error());
$row_rsFilterNationality = mysql_fetch_assoc($rsFilterNationality);
$totalRows_rsFilterNationality = mysql_num_rows($rsFilterNationality);

$colname_rsFilterSubject = "-1";
if (isset($_GET['spm_subject'])) {
  $colname_rsFilterSubject = $_GET['spm_subject'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsFilterSubject = sprintf("SELECT * FROM jp_spm_subject WHERE subject_id = %s", GetSQLValueString($colname_rsFilterSubject, "int"));
$rsFilterSubject = mysql_query($query_rsFilterSubject, $conJobsPerak) or die(mysql_error());
$row_rsFilterSubject = mysql_fetch_assoc($rsFilterSubject);
$totalRows_rsFilterSubject = mysql_num_rows($rsFilterSubject);

$colname_rsFilterQuali = "-1";
if (isset($_GET['qualification'])) {
  $colname_rsFilterQuali = $_GET['qualification'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsFilterQuali = sprintf("SELECT * FROM jp_edu_lists WHERE edu_id = %s", GetSQLValueString($colname_rsFilterQuali, "int"));
$rsFilterQuali = mysql_query($query_rsFilterQuali, $conJobsPerak) or die(mysql_error());
$row_rsFilterQuali = mysql_fetch_assoc($rsFilterQuali);
$totalRows_rsFilterQuali = mysql_num_rows($rsFilterQuali);

$colname_rsFilterField = "-1";
if (isset($_GET['field_of_study'])) {
  $colname_rsFilterField = $_GET['field_of_study'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsFilterField = sprintf("SELECT * FROM jp_field_list WHERE field_id = %s", GetSQLValueString($colname_rsFilterField, "int"));
$rsFilterField = mysql_query($query_rsFilterField, $conJobsPerak) or die(mysql_error());
$row_rsFilterField = mysql_fetch_assoc($rsFilterField);
$totalRows_rsFilterField = mysql_num_rows($rsFilterField);

$colname_rsFilterLanguage = "-1";
if (isset($_GET['language'])) {
  $colname_rsFilterLanguage = $_GET['language'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsFilterLanguage = sprintf("SELECT * FROM jp_language_list WHERE languList_id = %s", GetSQLValueString($colname_rsFilterLanguage, "int"));
$rsFilterLanguage = mysql_query($query_rsFilterLanguage, $conJobsPerak) or die(mysql_error());
$row_rsFilterLanguage = mysql_fetch_assoc($rsFilterLanguage);
$totalRows_rsFilterLanguage = mysql_num_rows($rsFilterLanguage);

$colname_rsFilterIndustry = "-1";
if (isset($_GET['industry'])) {
  $colname_rsFilterIndustry = $_GET['industry'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsFilterIndustry = sprintf("SELECT * FROM jp_industry WHERE indus_id = %s", GetSQLValueString($colname_rsFilterIndustry, "int"));
$rsFilterIndustry = mysql_query($query_rsFilterIndustry, $conJobsPerak) or die(mysql_error());
$row_rsFilterIndustry = mysql_fetch_assoc($rsFilterIndustry);
$totalRows_rsFilterIndustry = mysql_num_rows($rsFilterIndustry);

$colname_rsFilterLocation = "-1";
if (isset($_GET['prefer_location'])) {
  $colname_rsFilterLocation = $_GET['prefer_location'];
}
mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsFilterLocation = sprintf("SELECT * FROM jp_location WHERE location_id = %s", GetSQLValueString($colname_rsFilterLocation, "int"));
$rsFilterLocation = mysql_query($query_rsFilterLocation, $conJobsPerak) or die(mysql_error());
$row_rsFilterLocation = mysql_fetch_assoc($rsFilterLocation);
$totalRows_rsFilterLocation = mysql_num_rows($rsFilterLocation);

$queryString_rsJobSeekerList = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsJobSeekerList") == false && 
        stristr($param, "totalRows_rsJobSeekerList") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsJobSeekerList = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsJobSeekerList = sprintf("&totalRows_rsJobSeekerList=%d%s", $totalRows_rsJobSeekerList, $queryString_rsJobSeekerList);
?>
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
$MM_authorizedUsers = "2";
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
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<title>Welcome to Jobsperak Portal</title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<link rel="stylesheet" href="css/style.css" type="text/css" media="screen, projection" />
    <script language="javascript" src="js/jquery-1.7.1.min.js"></script>
<style type="text/css">
#wrapper #middle #content .master_details h1 {
	color: #F00;
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

		  <div id="content">
<h2>Employer Profile</h2>
<div class="master_details">
  <p>Welcome <?php echo $_SESSION['MM_Username']; ?> <?php //echo $_SESSION['MM_UserID']; ?> | <a href="<?php echo $logoutAction ?>">Log Out</a></p>
  <?php include("employer_menu.php"); ?><br/> 
<strong>Filtering result on </strong>


<?php

// General
if(@$_GET['submitGeneral'] == "Search")
{
	if($_GET['nationality'] != 0)
	{
		echo "Nationality:";
		echo "<b>[".$row_rsFilterNationality['national_name'];
		echo "]</b> ";
	}
	
	if($_GET['dob_month'] != 0)
	{
		echo " DOB Month:";
		echo "<b>[" . $_GET['dob_month'];
		echo "]</b> ";
	}
	
	if($_GET['dob_year'] != 0)
	{
		echo " DOB Year:";
		echo "<b>[" . $_GET['dob_year'];
		echo "]</b> ";
	}
}

// SPM Language
if(@$_GET['submitSPM'] == "Search")
{
	if($_GET['spm_subject'] != 0)
	{
		echo "Subject:";
		echo "<b>[".$row_rsFilterSubject['subject_name'];
		echo "]</b> ";
	}
	
	if($_GET['spm_subject_grade'] != "")
	{
		echo " Grade:";
		echo "<b>[" . $_GET['spm_subject_grade'];
		echo "]</b> ";
	}
}

// Education
if(@$_GET['submitEdu'] == "Search")
{
	if($_GET['graduate_year'] != 0)
	{
		echo "Year Graduted:";
		echo "<b>[".$_GET['graduate_year'];
		echo "]</b> ";
	}
	
	if($_GET['qualification'] != 0)
	{
		echo " Qualification:";
		echo "<b>[" . $row_rsFilterQuali['edu_name'];
		echo "]</b> ";
	}
	
	if($_GET['field_of_study'] != 0)
	{
		echo " Field of Study:";
		echo "<b>[" . $row_rsFilterField['field_name'];
		echo "]</b> ";
	}
	
	if($_GET['cgpa'] != 0)
	{
		if($_GET['cgpa'] == '3.5')
		{
			echo " CGPA:";
			echo "<b>[3.5 and Above";
			echo "]</b> ";
		}
		
		if($_GET['cgpa'] == '3.49')
		{
			echo " CGPA:";
			echo "<b>[3.49 and below";
			echo "]</b> ";
		}
	}
}


// Language
if(@$_GET['submitLang'] == "Search")
{
	if($_GET['language'] != 0)
	{
		echo "Language:";
		echo "<b>[". $row_rsFilterLanguage['languList_name'];
		echo "]</b> ";
	}
	
	if($_GET['lang_spoken'] != 0)
	{
		echo " Spoken:";
		echo "<b>[" . $_GET['lang_spoken'];
		echo "]</b> ";
	}
	
	if($_GET['lang_written'] != 0)
	{
		echo " Written:";
		echo "<b>[" . $_GET['lang_written'];
		echo "]</b> ";
	}
	
}


// Prefer
if(@$_GET['submitPrefer'] == "Search")
{
	if($_GET['prefer_location'] != 0)
	{
		echo "Preference Location:";
		echo "<b>[". $row_rsFilterLocation['location_name'];
		echo "]</b> ";
	}
	
	if($_GET['industry'] != 0)
	{
		echo " Industry:";
		echo "<b>[" . $row_rsFilterIndustry['indus_name'];
		echo "]</b> ";
	}
	
	if($_GET['salary'] != 0)
	{
		echo " Salary:";
		echo "<b>[RM " . $_GET['salary'];
		echo "]</b> ";
	}
	
}

?>


<br/>
<br/>
<?php if ($totalRows_rsJobSeekerList > 0) { // Show if recordset not empty ?>
<table width="600" border="0" cellpadding="2" cellspacing="2" class="csstable2">
  <tr>
    <th>Name</th>
    <th>Email</th>
    <th>Picture</th>
    <th>Action</th>
  </tr>
  <?php do { ?>
    <tr>
      <td align="left" valign="middle"><?php echo $row_rsJobSeekerList['users_fname']; ?> <?php echo $row_rsJobSeekerList['users_lname']; ?></td>
      <td align="center" valign="middle"><a href="jobSeekerResume.php?js_id=<?php echo $row_rsJobSeekerList['users_id']; ?>"><?php echo $row_rsJobSeekerList['users_email']; ?></a></td>
      <td align="center" valign="middle"><img src="<?php echo $row_rsJobSeekerList['jobseeker_pic']; ?>" width="48"></td>
      <td align="center" valign="middle"><a href="employerApplicationShorlistedDirect.php?candidateID=<?php echo $row_rsJobSeekerList['jobseeker_id']; ?>&employer_id=<?php echo $_SESSION['MM_UserID']; ?>"><img src="img/Document-Write-icon.png" alt="shortlisted" width="16" height="16" border="0" title="Shorlist this Candidate"></a></td>
    </tr>
    <?php } while ($row_rsJobSeekerList = mysql_fetch_assoc($rsJobSeekerList)); ?>
</table>
<? } // Show if recordset not empty ?>
<?php if ($totalRows_rsJobSeekerList > 0) { // Show if recordset not empty ?>
<div class="paginate"><a href="<?php printf("%s?pageNum_rsJobSeekerList=%d%s", $currentPage, 0, $queryString_rsJobSeekerList); ?>">First</a> <a href="<?php printf("%s?pageNum_rsJobSeekerList=%d%s", $currentPage, max(0, $pageNum_rsJobSeekerList - 1), $queryString_rsJobSeekerList); ?>">Previous</a> <a href="<?php printf("%s?pageNum_rsJobSeekerList=%d%s", $currentPage, min($totalPages_rsJobSeekerList, $pageNum_rsJobSeekerList + 1), $queryString_rsJobSeekerList); ?>">Next</a> <a href="<?php printf("%s?pageNum_rsJobSeekerList=%d%s", $currentPage, $totalPages_rsJobSeekerList, $queryString_rsJobSeekerList); ?>">Last</a> | Records <?php echo ($startRow_rsJobSeekerList + 1) ?> to <?php echo min($startRow_rsJobSeekerList + $maxRows_rsJobSeekerList, $totalRows_rsJobSeekerList) ?> of <?php echo $totalRows_rsJobSeekerList ?></div>
<? } // Show if recordset not empty ?>
</div>
<?php if ($totalRows_rsJobSeekerList == 0) { // Show if recordset empty ?>
<p><strong>No Resume with your filtering</strong></p>
<? } // Show if recordset empty ?>
          </div><!-- #content-->
	
		  <aside id="sideRight">
          	  <?php include('full_content_sidebar.php'); ?>
          </aside>
			<!-- aside -->
			<!-- #sideRight -->


	</section><!-- #middle-->

	</div><!-- #wrapper-->

	<footer id="footer">
		<div class="center">
			<?php include("footer.php"); ?>
		</div><!-- .center -->
	</footer><!-- #footer -->



</body>
<script>
$(document).ready(function(){
	
		var generalFilter = $('div#generalFilter');
		var spmFilter = $('div#spmFilter');
		var eduFilter = $('div#eduFilter');
		var langFilter = $('div#langFilter');
		var skillFilter = $('div#skillFilter');
		var preferFilter = $('div#preferFilter');
		
		var filtering = $("input[type='radio']");
		
		filtering.change(function(){
			
			if($(this).val().toString() == 'general')
			{
				generalFilter.show();
				
				spmFilter.hide();
				eduFilter.hide();
				langFilter.hide();
				skillFilter.hide();
				preferFilter.hide();
				//console.log($(this).val());
			}
			
			if($(this).val().toString() == 'spm')
			{
				spmFilter.show();
				
				generalFilter.hide();
				eduFilter.hide();
				langFilter.hide();
				skillFilter.hide();
				preferFilter.hide();
				//console.log($(this).val());
			}
			
			if($(this).val().toString() == 'edu')
			{
				eduFilter.show();
				
				generalFilter.hide();
				spmFilter.hide();
				langFilter.hide();
				skillFilter.hide();
				preferFilter.hide();
				//console.log($(this).val());
			}
			
			if($(this).val().toString() == 'lang')
			{
				langFilter.show();
				
				generalFilter.hide();
				spmFilter.hide();
				eduFilter.hide();
				skillFilter.hide();
				preferFilter.hide();
				//console.log($(this).val());
			}
			
			if($(this).val().toString() == 'skill')
			{
				skillFilter.show();
				
				generalFilter.hide();
				spmFilter.hide();
				eduFilter.hide();
				langFilter.hide();
				preferFilter.hide();
				//console.log($(this).val());
			}
			
			if($(this).val().toString() == 'prefer')
			{
				preferFilter.show();
				
				generalFilter.hide();
				spmFilter.hide();
				eduFilter.hide();
				langFilter.hide();
				skillFilter.hide();
				//console.log($(this).val());
			}
			
		});
		
		/*filtering.change(function(){
			console.log($(this).val());
		});*/
		
});
</script>
</html>
<?php
mysql_free_result($rsEmployerProfile);

mysql_free_result($rsIndustry);

mysql_free_result($rsCompanyInfoDetail);

mysql_free_result($rsLoc);

mysql_free_result($rsEmployerId);

mysql_free_result($rsJobSeekerList);

mysql_free_result($rsLocation);

mysql_free_result($rsNationality);

mysql_free_result($spmSubjectList);

mysql_free_result($rsQualification);

mysql_free_result($rsFieldList);

mysql_free_result($rsMajorList);

mysql_free_result($rsLangList);

mysql_free_result($rsFilterNationality);

mysql_free_result($rsFilterSubject);

mysql_free_result($rsFilterQuali);

mysql_free_result($rsFilterField);

mysql_free_result($rsFilterLanguage);

mysql_free_result($rsFilterIndustry);

mysql_free_result($rsFilterLocation);
?>
