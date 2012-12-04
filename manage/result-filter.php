<?php require_once('Connections/conPerak.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

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
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
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
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
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

$currentPage = $_SERVER["PHP_SELF"];

$colname_rsAdminName = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_rsAdminName = $_SESSION['MM_Username'];
}
mysql_select_db($database_conPerak, $conPerak);
$query_rsAdminName = sprintf("SELECT admin_name FROM jp_admin WHERE admin_name = %s", GetSQLValueString($colname_rsAdminName, "text"));
$rsAdminName = mysql_query($query_rsAdminName, $conPerak) or die(mysql_error());
$row_rsAdminName = mysql_fetch_assoc($rsAdminName);
$totalRows_rsAdminName = mysql_num_rows($rsAdminName);

mysql_select_db($database_conPerak, $conPerak);
$query_rsLanguageList = "SELECT * FROM jp_language_list";
$rsLanguageList = mysql_query($query_rsLanguageList, $conPerak) or die(mysql_error());
$row_rsLanguageList = mysql_fetch_assoc($rsLanguageList);
$totalRows_rsLanguageList = mysql_num_rows($rsLanguageList);

$maxRows_rsResumes = 100;
$pageNum_rsResumes = 0;
if (isset($_GET['pageNum_rsResumes'])) {
  $pageNum_rsResumes = $_GET['pageNum_rsResumes'];
}
$startRow_rsResumes = $pageNum_rsResumes * $maxRows_rsResumes;

mysql_select_db($database_conPerak, $conPerak);
$query_rsResumes = "Select   jp_resume.resume_title,   jp_resume.resume_type,   jp_users.users_email,   jp_users.users_fname,   jp_users.users_lname,   jp_resume.resume_upload_on,   jp_resume.resume_path From   jp_resume Inner Join   jp_users On jp_resume.users_id_fk = jp_users.users_id";
$query_limit_rsResumes = sprintf("%s LIMIT %d, %d", $query_rsResumes, $startRow_rsResumes, $maxRows_rsResumes);
$rsResumes = mysql_query($query_limit_rsResumes, $conPerak) or die(mysql_error());
$row_rsResumes = mysql_fetch_assoc($rsResumes);

if (isset($_GET['totalRows_rsResumes'])) {
  $totalRows_rsResumes = $_GET['totalRows_rsResumes'];
} else {
  $all_rsResumes = mysql_query($query_rsResumes);
  $totalRows_rsResumes = mysql_num_rows($all_rsResumes);
}
$totalPages_rsResumes = ceil($totalRows_rsResumes/$maxRows_rsResumes)-1;

$maxRows_rsJobseekers = 100;
$pageNum_rsJobseekers = 0;
if (isset($_GET['pageNum_rsJobseekers'])) {
  $pageNum_rsJobseekers = $_GET['pageNum_rsJobseekers'];
}
$startRow_rsJobseekers = $pageNum_rsJobseekers * $maxRows_rsJobseekers;

mysql_select_db($database_conPerak, $conPerak);

// start filtering here ===================================================================================================

/**
* URL VAR
*/

$name                    = mysql_real_escape_string(@$_GET['name']);
$email                   = mysql_real_escape_string(@$_GET['email']);
$ic                      = mysql_real_escape_string(@$_GET['ic']);
$employ_status           = mysql_real_escape_string(@$_GET['employ_status']);
$gender                  = mysql_real_escape_string(@$_GET['gender']);
$age                     = mysql_real_escape_string(@$_GET['age']);
$marital_status          = mysql_real_escape_string(@$_GET['marital_status']);
$year_experience         = mysql_real_escape_string(@$_GET['year_experience']);
$position                = mysql_real_escape_string(@$_GET['position']);
$institution             = mysql_real_escape_string(@$_GET['institution']);
$cgpa                    = mysql_real_escape_string(@$_GET['cgpa']);
$language                = mysql_real_escape_string(@$_GET['language']);
$skills                  = mysql_real_escape_string(@$_GET['skills']);
$licences                = mysql_real_escape_string(@$_GET['licences']);
$qualification           = mysql_real_escape_string(@$_GET['qualification']);
$state                   = mysql_real_escape_string(@$_GET['state']);
$distinct                = mysql_real_escape_string(@$_GET['distinct']);
$subdistinct             = mysql_real_escape_string(@$_GET['subdistinct']);
$job_prefer_location     = mysql_real_escape_string(@$_GET['job_prefer_location']);
$job_prefer_industry     = mysql_real_escape_string(@$_GET['job_prefer_industry']);
$job_prefer_salary       = mysql_real_escape_string(@$_GET['job_prefer_salary']);
$disc_test               = mysql_real_escape_string(@$_GET['disc_test']);
$fieldStudy              = mysql_real_escape_string(@$_GET['fieldStudy']);


/*************************************************************************************************************************
 * Single Variable
 *************************************************************************************************************************/

// default
if($name == '' && $email == '' && $ic == '' && $employ_status == 'All' && $gender == 0 && $age == 0 && $marital_status == 0 && $qualification == 'All' && $year_experience == 0 && $position == '' && $institution == '' && $cgpa == 0 && $language == 0 && $skills == '' && $licences == '' && $state == 0 && $distinct == 0 && $subdistinct == 0 && $job_prefer_location == 0 && $job_prefer_industry == 0 && $job_prefer_salary == 0) {

$query_rsJobseekers = "SELECT jp_users.*,
       jp_jobseeker.*,
       jp_users.users_type AS users_type1
FROM jp_users
INNER JOIN jp_jobseeker ON jp_users.users_id = jp_jobseeker.users_id_fk
WHERE jp_users.users_type = 1
  AND jp_users.user_active = 1
GROUP BY jp_jobseeker.users_id_fk";

}


// fname or lname only
if($name != '' && $email == '' && $ic == '' && $employ_status == 'All' && $gender == 0 && $age == 0 && $marital_status == 0 && $qualification == 'All' && $year_experience == 0 && $position == '' && $institution == '' && $cgpa == 0 && $language == 0 && $skills == '' && $licences == '' && $state == 0 && $distinct == 0 && $subdistinct == 0 && $job_prefer_location == 0 && $job_prefer_industry == 0 && $job_prefer_salary == 0) {

$query_rsJobseekers = "SELECT
  jp_users.*,
  jp_jobseeker.*,
  jp_users.users_type As users_type1,
  jp_users.users_fname As users_fname1,
  jp_users.users_lname As users_lname1
From
  jp_users Inner Join
  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk
Where
  jp_users.users_type = 1 And
  jp_users.user_active = 1 And 
  (jp_users.users_fname LIKE '%".$name."%' Or
  jp_users.users_lname LIKE '%".$name."%')";

}


// email only
if($name == '' && $email != '' && $ic == '' && $employ_status == 'All' && $gender == 0 && $age == 0 && $marital_status == 0 && $qualification == 'All' && $year_experience == 0 && $position == '' && $institution == '' && $cgpa == 0 && $language == 0 && $skills == '' && $licences == '' && $state == 0 && $distinct == 0 && $subdistinct == 0 && $job_prefer_location == 0 && $job_prefer_industry == 0 && $job_prefer_salary == 0) {

$query_rsJobseekers = "SELECT
  jp_users.*,
  jp_jobseeker.*,
  jp_users.users_type As users_type1
From
  jp_users Inner Join
  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk
Where
  jp_users.users_type = 1 And
  jp_users.user_active = 1 And
  jp_users.users_email = '".$email."'";

}

// IC only
if($name == '' && $email == '' && $ic != '' && $employ_status == 'All' && $gender == 0 && $age == 0 && $marital_status == 0 && $qualification == 'All' && $year_experience == 0 && $position == '' && $institution == '' && $cgpa == 0 && $language == 0 && $skills == '' && $licences == '' && $state == 0 && $distinct == 0 && $subdistinct == 0 && $job_prefer_location == 0 && $job_prefer_industry == 0 && $job_prefer_salary == 0) {

$query_rsJobseekers = "SELECT
  jp_users.*,
  jp_jobseeker.*,
  jp_users.users_type As users_type1
From
  jp_users Inner Join
  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk
Where
  jp_users.users_type = 1 And
  jp_users.user_active = 1 And
  jp_jobseeker.joobseeker_ic = '".$ic."'";

}

// Employment Status only
if($name == '' && $email == '' && $ic == '' && $employ_status != 'All' && $gender == 0 && $age == 0 && $marital_status == 0 && $qualification == 'All' && $year_experience == 0 && $position == '' && $institution == '' && $cgpa == 0 && $language == 0 && $skills == '' && $licences == '' && $state == 0 && $distinct == 0 && $subdistinct == 0 && $job_prefer_location == 0 && $job_prefer_industry == 0 && $job_prefer_salary == 0) {

$query_rsJobseekers = "SELECT
  jp_users.*,
  jp_jobseeker.*,
  jp_users.users_type As users_type1
From
  jp_users Inner Join
  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk
Where
  jp_users.users_type = 1 And
  jp_users.user_active = 1 And
  jp_jobseeker.employment_status = '".$employ_status."'";

}

// Gender only
if($name == '' && $email == '' && $ic == '' && $employ_status == 'All' && $gender != 0 && $age == 0 && $marital_status == 0 && $qualification == 'All' && $year_experience == 0 && $position == '' && $institution == '' && $cgpa == 0 && $language == 0 && $skills == '' && $licences == '' && $state == 0 && $distinct == 0 && $subdistinct == 0 && $job_prefer_location == 0 && $job_prefer_industry == 0 && $job_prefer_salary == 0) {

$query_rsJobseekers = "SELECT
  jp_users.*,
  jp_jobseeker.*,
  jp_users.users_type As users_type1
From
  jp_users Inner Join
  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk
Where
  jp_users.users_type = 1 And
  jp_users.user_active = 1 And
  jp_jobseeker.jobseeker_gender = '".$gender."'";

}

// age filtering
if($name == '' && $email == '' && $ic == '' && $employ_status == 'All' && $gender == 0 && $age != '' && $marital_status == 0 && $qualification == 'All' && $year_experience == 0 && $position == '' && $institution == '' && $cgpa == 0 && $language == 0 && $skills == '' && $licences == '' && $state == 0 && $distinct == 0 && $subdistinct == 0 && $job_prefer_location == 0 && $job_prefer_industry == 0 && $job_prefer_salary == 0) {

  switch ($age) {
    // 18 - 20
    case 'b20':
      $query_rsJobseekers = "SELECT jp_users.*,
             jp_jobseeker.*,
             jp_jobseeker.jobseeker_dob_y AS jobseeker_dob_y1
      FROM jp_users
      INNER JOIN jp_jobseeker ON jp_jobseeker.users_id_fk = jp_users.users_id
      WHERE jp_jobseeker.jobseeker_dob_y BETWEEN 1992 AND 1994";
      break;

    // 20 - 25
    case 'b25':
      $query_rsJobseekers = "SELECT jp_users.*,
             jp_jobseeker.*,
             jp_jobseeker.jobseeker_dob_y AS jobseeker_dob_y1
      FROM jp_users
      INNER JOIN jp_jobseeker ON jp_jobseeker.users_id_fk = jp_users.users_id
      WHERE jp_jobseeker.jobseeker_dob_y BETWEEN 1987 AND 1992";
      break;

    // 25 - 29
    case 'b29':
      $query_rsJobseekers = "SELECT jp_users.*,
             jp_jobseeker.*,
             jp_jobseeker.jobseeker_dob_y AS jobseeker_dob_y1
      FROM jp_users
      INNER JOIN jp_jobseeker ON jp_jobseeker.users_id_fk = jp_users.users_id
      WHERE jp_jobseeker.jobseeker_dob_y BETWEEN 1983 AND 1987";
      break;

    // 30
    case 'a30':
      $query_rsJobseekers = "SELECT jp_users.*,
             jp_jobseeker.*,
             jp_jobseeker.jobseeker_dob_y AS jobseeker_dob_y1
      FROM jp_users
      INNER JOIN jp_jobseeker ON jp_jobseeker.users_id_fk = jp_users.users_id
      WHERE jp_jobseeker.jobseeker_dob_y <= 1982";
      break;
  }

}


// Marital Status only
if($name == '' && $email == '' && $ic == '' && $employ_status == 'All' && $gender == 0 && $age == 0 && $marital_status != 0 && $qualification == 'All' && $year_experience == 0 && $position == '' && $institution == '' && $cgpa == 0 && $language == 0 && $skills == '' && $licences == '' && $state == 0 && $distinct == 0 && $subdistinct == 0 && $job_prefer_location == 0 && $job_prefer_industry == 0 && $job_prefer_salary == 0) {

$query_rsJobseekers = "SELECT
  jp_users.*,
  jp_jobseeker.*,
  jp_users.users_type As users_type1
From
  jp_users Inner Join
  jp_jobseeker On jp_users.users_id = jp_jobseeker.users_id_fk
Where
  jp_users.users_type = 1 And
  jp_users.user_active = 1 And
  jp_jobseeker.marital_status = '".$marital_status."'";

}

// Qualification only
if($name == '' && $email == '' && $ic == '' && $employ_status == 'All' && $gender == 0 && $age == 0 && $marital_status == 0 && $qualification != 'All' && $year_experience == 0 && $position == '' && $institution == '' && $cgpa == 0 && $language == 0 && $skills == '' && $licences == '' && $state == 0 && $distinct == 0 && $subdistinct == 0 && $job_prefer_location == 0 && $job_prefer_industry == 0 && $job_prefer_salary == 0) {

$query_rsJobseekers = "SELECT
  jp_users.*,
  jp_education.*,
  jp_education.user_id_fk As user_id_fk1,
  jp_jobseeker.jobseeker_tel,
  jp_jobseeker.jobseeker_mobile
From
  jp_users Inner Join
  jp_education On jp_education.user_id_fk = jp_users.users_id Inner Join
  jp_jobseeker On jp_jobseeker.users_id_fk = jp_users.users_id
Where
  jp_users.users_type = 1 And
  jp_education.edu_qualification = $qualification And
  jp_users.user_active = 1
Group By
  jp_education.user_id_fk";

}

// TODO: total year

// Position String only
if($name == '' && $email == '' && $ic == '' && $employ_status == 'All' && $gender == 0 && $age == 0 && $marital_status == 0 && $qualification == 'All' && $year_experience == 0 && $position != '' && $institution == '' && $cgpa == 0 && $language == 0 && $skills == '' && $licences == '' && $state == 0 && $distinct == 0 && $subdistinct == 0 && $job_prefer_location == 0 && $job_prefer_industry == 0 && $job_prefer_salary == 0) {

    $query_rsJobseekers = "SELECT jp_users.*,
       jp_jobseeker.*,
       jp_experience.exp_pos_title,
       jp_experience.exp_role
FROM jp_jobseeker
INNER JOIN jp_users ON jp_jobseeker.users_id_fk = jp_users.users_id
INNER JOIN jp_experience ON jp_experience.users_id_fk = jp_jobseeker.users_id_fk
WHERE jp_experience.exp_pos_title LIKE '%junior%'
  OR jp_experience.exp_role LIKE '%junior%' GROUP BY jp_experience.users_id_fk";

}


    

// Edu::institution
if($name == '' && $email == '' && $ic == '' && $employ_status == 'All' && $gender == 0 && $age == 0 && $marital_status == 0 && $qualification == 'All' && $year_experience == 0 && $position == '' && $institution != '' && $cgpa == 0 && $language == 0 && $skills == '' && $licences == '' && $state == 0 && $distinct == 0 && $subdistinct == 0 && $job_prefer_location == 0 && $job_prefer_industry == 0 && $job_prefer_salary == 0) {

  
  $query_rsJobseekers = "SELECT jp_users.*,
         jp_jobseeker.*
  FROM jp_jobseeker
  INNER JOIN jp_users ON jp_jobseeker.users_id_fk = jp_users.users_id
  INNER JOIN jp_education ON jp_education.user_id_fk = jp_users.users_id
  WHERE jp_education.edu_university LIKE '%".$institution."%' GROUP BY jp_education.user_id_fk";


}

// Edu::CGPA
if($name == '' && $email == '' && $ic == '' && $employ_status == 'All' && $gender == 0 && $age == 0 && $marital_status == 0 && $qualification == 'All' && $year_experience == 0 && $position == '' && $institution == '' && $cgpa != '' && $language == 0 && $skills == '' && $licences == '' && $state == 0 && $distinct == 0 && $subdistinct == 0 && $job_prefer_location == 0 && $job_prefer_industry == 0 && $job_prefer_salary == 0) {

  
  switch ($cgpa) {
    case 'b25':
      $query_rsJobseekers = "SELECT jp_jobseeker.*,
             jp_education.edu_cgpa,
             jp_users.users_fname,
             jp_users.users_lname,
             jp_jobseeker.jobseeker_mobile AS jobseeker_mobile1,
             jp_education.edu_id,
             jp_users.users_email
      FROM jp_users
      INNER JOIN jp_jobseeker ON jp_jobseeker.users_id_fk = jp_users.users_id
      INNER JOIN jp_education ON jp_education.user_id_fk = jp_users.users_id
      WHERE jp_education.edu_cgpa BETWEEN 2.0 AND 2.5
      GROUP BY jp_education.user_id_fk";
      break;
    
    case 'b299':
      $query_rsJobseekers = "SELECT jp_jobseeker.*,
             jp_education.edu_cgpa,
             jp_users.users_fname,
             jp_users.users_lname,
             jp_jobseeker.jobseeker_mobile AS jobseeker_mobile1,
             jp_education.edu_id,
             jp_users.users_email
      FROM jp_users
      INNER JOIN jp_jobseeker ON jp_jobseeker.users_id_fk = jp_users.users_id
      INNER JOIN jp_education ON jp_education.user_id_fk = jp_users.users_id
      WHERE jp_education.edu_cgpa BETWEEN 2.5 AND 3.0 
      GROUP BY jp_education.user_id_fk";
      break;

    case 'b349':
      $query_rsJobseekers = "SELECT jp_jobseeker.*,
             jp_education.edu_cgpa,
             jp_users.users_fname,
             jp_users.users_lname,
             jp_jobseeker.jobseeker_mobile AS jobseeker_mobile1,
             jp_education.edu_id,
             jp_users.users_email
      FROM jp_users
      INNER JOIN jp_jobseeker ON jp_jobseeker.users_id_fk = jp_users.users_id
      INNER JOIN jp_education ON jp_education.user_id_fk = jp_users.users_id
      WHERE jp_education.edu_cgpa BETWEEN 3.0 AND 3.5 
      GROUP BY jp_education.user_id_fk";
      break;

    case '35':
      $query_rsJobseekers = "SELECT jp_jobseeker.*,
             jp_education.edu_cgpa,
             jp_users.users_fname,
             jp_users.users_lname,
             jp_jobseeker.jobseeker_mobile AS jobseeker_mobile1,
             jp_education.edu_id,
             jp_users.users_email
      FROM jp_users
      INNER JOIN jp_jobseeker ON jp_jobseeker.users_id_fk = jp_users.users_id
      INNER JOIN jp_education ON jp_education.user_id_fk = jp_users.users_id
      WHERE jp_education.edu_cgpa BETWEEN 3.5 AND 4.0 
      GROUP BY jp_education.user_id_fk";
      break;
  }


}



// Skill::Language
if($name == '' && $email == '' && $ic == '' && $employ_status == 'All' && $gender == 0 && $age == 0 && $marital_status == 0 && $qualification == 'All' && $year_experience == 0 && $position == '' && $institution == '' && $cgpa == 0 && $language != 0 && $skills == '' && $licences == '' && $state == 0 && $distinct == 0 && $subdistinct == 0 && $job_prefer_location == 0 && $job_prefer_industry == 0 && $job_prefer_salary == 0) {

  
  $query_rsJobseekers = "SELECT jp_users.*,
jp_jobseeker.*,
jp_language.lang_name
FROM jp_jobseeker
INNER JOIN jp_users ON jp_jobseeker.users_id_fk = jp_users.users_id
INNER JOIN jp_language ON jp_language.user_id_fk = jp_users.users_id
WHERE jp_language.lang_name = $language";


}

// Skill::Skill type
if($name == '' && $email == '' && $ic == '' && $employ_status == 'All' && $gender == 0 && $age == 0 && $marital_status == 0 && $qualification == 'All' && $year_experience == 0 && $position == '' && $institution == '' && $cgpa == 0 && $language == 0 && $skills != '' && $licences == '' && $state == 0 && $distinct == 0 && $subdistinct == 0 && $job_prefer_location == 0 && $job_prefer_industry == 0 && $job_prefer_salary == 0) {

  
  $query_rsJobseekers = "SELECT jp_users.*,
       jp_jobseeker.*,
       jp_skills.skills_name
FROM jp_jobseeker
INNER JOIN jp_users ON jp_jobseeker.users_id_fk = jp_users.users_id
INNER JOIN jp_skills ON jp_skills.user_id_fk = jp_users.users_id
WHERE jp_skills.skills_name LIKE '%$skills%'";


}

// Skill::Licences
if($name == '' && $email == '' && $ic == '' && $employ_status == 'All' && $gender == 0 && $age == 0 && $marital_status == 0 && $qualification == 'All' && $year_experience == 0 && $position == '' && $institution == '' && $cgpa == 0 && $language == 0 && $skills == '' && $licences != '' && $state == 0 && $distinct == 0 && $subdistinct == 0 && $job_prefer_location == 0 && $job_prefer_industry == 0 && $job_prefer_salary == 0) {

  
  $query_rsJobseekers = "SELECT jp_users.users_fname,
       jp_users.users_lname,
       jp_licenses.license_type,
       jp_jobseeker.jobseeker_tel,
       jp_jobseeker.jobseeker_mobile,
       jp_users.users_email,
       jp_users.users_id
FROM jp_licenses
INNER JOIN jp_users ON jp_licenses.user_id_fk = jp_users.users_id
INNER JOIN jp_jobseeker ON jp_jobseeker.users_id_fk = jp_users.users_id
WHERE jp_licenses.license_type LIKE '%$licences%'";


}

// Loc::State
if($name == '' && $email == '' && $ic == '' && $employ_status == 'All' && $gender == 0 && $age == 0 && $marital_status == 0 && $qualification == 'All' && $year_experience == 0 && $position == '' && $institution == '' && $cgpa == 0 && $language == 0 && $skills == '' && $licences == '' && $state != 0 && $distinct == 0 && $subdistinct == 0 && $job_prefer_location == 0 && $job_prefer_industry == 0 && $job_prefer_salary == 0) {

  
  $query_rsJobseekers = "SELECT jp_users.*,
       jp_jobseeker.*,
       jp_jobseeker.jobseeker_address_state AS jobseeker_address_state1
FROM jp_users
INNER JOIN jp_jobseeker ON jp_jobseeker.users_id_fk = jp_users.users_id
WHERE jp_jobseeker.jobseeker_address_state = $state";


}

// Loc::District
if($name == '' && $email == '' && $ic == '' && $employ_status == 'All' && $gender == 0 && $age == 0 && $marital_status == 0 && $qualification == 'All' && $year_experience == 0 && $position == '' && $institution == '' && $cgpa == 0 && $language == 0 && $skills == '' && $licences == '' && $state != 0 && $distinct != 0 && $subdistinct == 0 && $job_prefer_location == 0 && $job_prefer_industry == 0 && $job_prefer_salary == 0) {

  
  $query_rsJobseekers = "SELECT jp_users.*,
       jp_jobseeker.*,
       jp_jobseeker.jobseeker_address_state AS jobseeker_address_state1
FROM jp_users
INNER JOIN jp_jobseeker ON jp_jobseeker.users_id_fk = jp_users.users_id
WHERE jp_jobseeker.jobseeker_address_district = $distinct";


}

// Loc::Sub-District
if($name == '' && $email == '' && $ic == '' && $employ_status == 'All' && $gender == 0 && $age == 0 && $marital_status == 0 && $qualification == 'All' && $year_experience == 0 && $position == '' && $institution == '' && $cgpa == 0 && $language == 0 && $skills == '' && $licences == '' && $state != 0 && $distinct != 0 && $subdistinct != 0 && $job_prefer_location == 0 && $job_prefer_industry == 0 && $job_prefer_salary == 0) {

  
  $query_rsJobseekers = "SELECT jp_users.*,
       jp_jobseeker.*,
       jp_jobseeker.jobseeker_address_state AS jobseeker_address_state1
FROM jp_users
INNER JOIN jp_jobseeker ON jp_jobseeker.users_id_fk = jp_users.users_id
WHERE jp_jobseeker.jobseeker_address_subdistrict = $subdistinct";


}

// JobPrefer::Work Location
if($name == '' && $email == '' && $ic == '' && $employ_status == 'All' && $gender == 0 && $age == 0 && $marital_status == 0 && $qualification == 'All' && $year_experience == 0 && $position == '' && $institution == '' && $cgpa == 0 && $language == 0 && $skills == '' && $licences == '' && $state == 0 && $distinct == 0 && $subdistinct == 0 && $job_prefer_location != 0 && $job_prefer_industry == 0 && $job_prefer_salary == 0) {

  
  $query_rsJobseekers = "SELECT jp_users.*,
       jp_jobseeker.*,
       jp_jobpreferences.jobP_1
FROM jp_jobseeker
INNER JOIN jp_users ON jp_jobseeker.users_id_fk = jp_users.users_id
INNER JOIN jp_jobpreferences ON jp_jobpreferences.user_id_fk = jp_users.users_id
WHERE jp_jobpreferences.jobP_1 = $job_prefer_location GROUP BY jp_jobpreferences.user_id_fk";


}

// JobPrefer::Job Industry
if($name == '' && $email == '' && $ic == '' && $employ_status == 'All' && $gender == 0 && $age == 0 && $marital_status == 0 && $qualification == 'All' && $year_experience == 0 && $position == '' && $institution == '' && $cgpa == 0 && $language == 0 && $skills == '' && $licences == '' && $state == 0 && $distinct == 0 && $subdistinct == 0 && $job_prefer_location == 0 && $job_prefer_industry != 0 && $job_prefer_salary == 0) {

  
  $query_rsJobseekers = "SELECT jp_users.*,
       jp_jobseeker.*,
       jp_jobpreferences.jobP_1
FROM jp_jobseeker
INNER JOIN jp_users ON jp_jobseeker.users_id_fk = jp_users.users_id
INNER JOIN jp_jobpreferences ON jp_jobpreferences.user_id_fk = jp_users.users_id
WHERE jp_jobpreferences.jobP_2 = $job_prefer_industry GROUP BY jp_jobpreferences.user_id_fk";


}

// JobPrefer::Expected Salary
if($name == '' && $email == '' && $ic == '' && $employ_status == 'All' && $gender == 0 && $age == 0 && $marital_status == 0 && $qualification == 'All' && $year_experience == 0 && $position == '' && $institution == '' && $cgpa == 0 && $language == 0 && $skills == '' && $licences == '' && $state == 0 && $distinct == 0 && $subdistinct == 0 && $job_prefer_location == 0 && $job_prefer_industry == 0 && $job_prefer_salary != 0) {

  
    switch ($job_prefer_salary) {
      case '1':
        $query_rsJobseekers = "SELECT jp_users.*,
               jp_jobseeker.*,
               jp_jobpreferences.jobP_salary
        FROM jp_users
        INNER JOIN jp_jobseeker ON jp_jobseeker.users_id_fk = jp_users.users_id
        INNER JOIN jp_jobpreferences ON jp_jobpreferences.user_id_fk = jp_users.users_id
        WHERE jp_jobpreferences.jobP_salary <= 1000";
        break;
      
      case '2':
        $query_rsJobseekers = "SELECT jp_users.*,
               jp_jobseeker.*,
               jp_jobpreferences.jobP_salary
        FROM jp_users
        INNER JOIN jp_jobseeker ON jp_jobseeker.users_id_fk = jp_users.users_id
        INNER JOIN jp_jobpreferences ON jp_jobpreferences.user_id_fk = jp_users.users_id
        WHERE jp_jobpreferences.jobP_salary <= 2000";
        break;

      case '3b':
        $query_rsJobseekers = "SELECT jp_users.*,
               jp_jobseeker.*,
               jp_jobpreferences.jobP_salary
        FROM jp_users
        INNER JOIN jp_jobseeker ON jp_jobseeker.users_id_fk = jp_users.users_id
        INNER JOIN jp_jobpreferences ON jp_jobpreferences.user_id_fk = jp_users.users_id
        WHERE jp_jobpreferences.jobP_salary <= 3000";
        break;

      case '3a':
        $query_rsJobseekers = "SELECT jp_users.*,
               jp_jobseeker.*,
               jp_jobpreferences.jobP_salary
        FROM jp_users
        INNER JOIN jp_jobseeker ON jp_jobseeker.users_id_fk = jp_users.users_id
        INNER JOIN jp_jobpreferences ON jp_jobpreferences.user_id_fk = jp_users.users_id
        WHERE jp_jobpreferences.jobP_salary >= 3000";
        break;
    }


}



// DISCtest
if($name == '' && $email == '' && $ic == '' && $employ_status == 'All' && $gender == 0 && $age == 0 && $marital_status == 0 && $qualification == 'All' && $year_experience == 0 && $position == '' && $institution == '' && $cgpa == 0 && $language == 0 && $skills == '' && $licences == '' && $state == 0 && $distinct == 0 && $subdistinct == 0 && $job_prefer_location == 0 && $job_prefer_industry == 0 && $job_prefer_salary == 0 && $disc_test == 'on') {

  
  $query_rsJobseekers = "SELECT
  jp_users.*,
  jp_jobseeker.*,
  jp_jobseeker.jobseeker_dob_y As jobseeker_dob_y1,
  jp_disc_test_result.user_id_fk,
  jp_disc_test_result.d_val,
  jp_disc_test_result.i_val,
  jp_disc_test_result.s_val,
  jp_disc_test_result.c_val
From
  jp_users Inner Join
  jp_jobseeker On jp_jobseeker.users_id_fk = jp_users.users_id Inner Join
  jp_disc_test_result On jp_disc_test_result.user_id_fk = jp_users.users_id";


}

// Field Study
if($fieldStudy != 0) {

  
  $query_rsJobseekers = "SELECT jp_education.edu_major,
       jp_education.edu_fieldStudy,
       jp_users.users_fname,
       jp_users.users_lname,
       jp_users.users_email,
       jp_jobseeker.jobseeker_tel,
       jp_jobseeker.jobseeker_mobile,
       jp_users.users_id
FROM jp_education
INNER JOIN jp_users ON jp_education.user_id_fk = jp_users.users_id
INNER JOIN jp_jobseeker ON jp_jobseeker.users_id_fk = jp_users.users_id
WHERE jp_education.edu_fieldStudy = $fieldStudy
GROUP BY jp_education.user_id_fk";


}




/*************************************************************************************************************************
 * Double Variable :: NAME
 *************************************************************************************************************************/

// TODO: NAME & EMAIL

// TODO: NAME & IC

// TODO: NAME & EMPLOYMENT STATUS

// TODO: NAME & GENDER

// TODO: NAME & AGE

// TODO: NAME & MARITAL STATUS

// TODO: NAME & TOTAL YEAR

// TODO: NAME & POSITION

// TODO: NAME & QUALIFICATION

// TODO: NAME & INSTITUTION

// TODO: NAME & FIELD OF STUDY

// TODO: NAME & CGPA

// TODO: NAME & LANGUAGE

// TODO: NAME & SKILL TYPE

// TODO: NAME & LICENSE

// TODO: NAME & STATE

// TODO: NAME & DISTRICT

// TODO: NAME & SUB-DISTRICT

// TODO: NAME & WORK LOCATION PREFER

// TODO: NAME & JOB INDUSTRY PREFER

// TODO: NAME & EXPECTED SALARY PREFER

// TODO: NAME & DISC TEST


/*************************************************************************************************************************
 * Double Variable :: EMAIL
 *************************************************************************************************************************/

// TODO: EMAIL & IC

// TODO: EMAIL & EMPLOYMENT STATUS

// TODO: EMAIL & GENDER

// TODO: EMAIL & AGE

// TODO: EMAIL & MARITAL STATUS

// TODO: EMAIL & TOTAL YEAR

// TODO: EMAIL & POSITION

// TODO: EMAIL & QUALIFICATION

// TODO: EMAIL & INSTITUTION

// TODO: EMAIL & FIELD OF STUDY

// TODO: EMAIL & CGPA

// TODO: EMAIL & LANGUAGE

// TODO: EMAIL & SKILL TYPE

// TODO: EMAIL & LICENSE

// TODO: EMAIL & STATE

// TODO: EMAIL & DISTRICT

// TODO: EMAIL & SUB-DISTRICT

// TODO: EMAIL & WORK LOCATION PREFER

// TODO: EMAIL & JOB INDUSTRY PREFER

// TODO: EMAIL & EXPECTED SALARY PREFER

// TODO: EMAIL & DISC TEST


/*************************************************************************************************************************
 * Double Variable :: IC
 *************************************************************************************************************************/

// TODO: IC & EMAIL

// TODO: IC & EMPLOYMENT STATUS

// TODO: IC & GENDER

// TODO: IC & AGE

// TODO: IC & MARITAL STATUS

// TODO: IC & TOTAL YEAR

// TODO: IC & POSITION

// TODO: IC & QUALIFICATION

// TODO: IC & INSTITUTION

// TODO: IC & FIELD OF STUDY

// TODO: IC & CGPA

// TODO: IC & LANGUAGE

// TODO: IC & SKILL TYPE

// TODO: IC & LICENSE

// TODO: IC & STATE

// TODO: IC & DISTRICT

// TODO: IC & SUB-DISTRICT

// TODO: IC & WORK LOCATION PREFER

// TODO: IC & JOB INDUSTRY PREFER

// TODO: IC & EXPECTED SALARY PREFER

// TODO: IC & DISC TEST



/*************************************************************************************************************************
 * Double Variable :: EMPLOYMENT STATUS
 *************************************************************************************************************************/


// TODO: EMPLOYMENT STATUS & EMAIL

// TODO: EMPLOYMENT STATUS & IC

// TODO: EMPLOYMENT STATUS & GENDER

// TODO: EMPLOYMENT STATUS & AGE

// TODO: EMPLOYMENT STATUS & MARITAL STATUS

// TODO: EMPLOYMENT STATUS & TOTAL YEAR

// TODO: EMPLOYMENT STATUS & POSITION

// TODO: EMPLOYMENT STATUS & QUALIFICATION

// TODO: EMPLOYMENT STATUS & INSTITUTION

// TODO: EMPLOYMENT STATUS & FIELD OF STUDY

// TODO: EMPLOYMENT STATUS & CGPA

// TODO: EMPLOYMENT STATUS & LANGUAGE

// TODO: EMPLOYMENT STATUS & SKILL TYPE

// TODO: EMPLOYMENT STATUS & LICENSE

// TODO: EMPLOYMENT STATUS & STATE

// TODO: EMPLOYMENT STATUS & DISTRICT

// TODO: EMPLOYMENT STATUS & SUB-DISTRICT

// TODO: EMPLOYMENT STATUS & WORK LOCATION PREFER

// TODO: EMPLOYMENT STATUS & JOB INDUSTRY PREFER

// TODO: EMPLOYMENT STATUS & EXPECTED SALARY PREFER

// TODO: EMPLOYMENT STATUS & DISC TEST


/*************************************************************************************************************************
 * Double Variable :: GENDER
 *************************************************************************************************************************/

// TODO: GENDER & EMAIL

// TODO: GENDER & IC

// TODO: GENDER & EMPLOYMENT STATUS

// TODO: GENDER & GENDER

// TODO: GENDER & AGE

// TODO: GENDER & MARITAL STATUS

// TODO: GENDER & TOTAL YEAR

// TODO: GENDER & POSITION

// TODO: GENDER & QUALIFICATION

// TODO: GENDER & INSTITUTION

// TODO: GENDER & FIELD OF STUDY

// TODO: GENDER & CGPA

// TODO: GENDER & LANGUAGE

// TODO: GENDER & SKILL TYPE

// TODO: GENDER & LICENSE

// TODO: GENDER & STATE

// TODO: GENDER & DISTRICT

// TODO: GENDER & SUB-DISTRICT

// TODO: GENDER & WORK LOCATION PREFER

// TODO: GENDER & JOB INDUSTRY PREFER

// TODO: GENDER & EXPECTED SALARY PREFER

// TODO: GENDER & DISC TEST


/*************************************************************************************************************************
 * Double Variable :: AGE
 *************************************************************************************************************************/

// TODO: AGE & EMAIL

// TODO: AGE & IC

// TODO: AGE & EMPLOYMENT STATUS

// TODO: AGE & GENDER

// TODO: AGE & AGE

// TODO: AGE & MARITAL STATUS

// TODO: AGE & TOTAL YEAR

// TODO: AGE & POSITION

// TODO: AGE & QUALIFICATION

// TODO: AGE & INSTITUTION

// TODO: AGE & FIELD OF STUDY

// TODO: AGE & CGPA

// TODO: AGE & LANGUAGE

// TODO: AGE & SKILL TYPE

// TODO: AGE & LICENSE

// TODO: AGE & STATE

// TODO: AGE & DISTRICT

// TODO: AGE & SUB-DISTRICT

// TODO: AGE & WORK LOCATION PREFER

// TODO: AGE & JOB INDUSTRY PREFER

// TODO: AGE & EXPECTED SALARY PREFER

// TODO: AGE & DISC TEST


/*************************************************************************************************************************
 * Double Variable :: MARITAL STATUS
 *************************************************************************************************************************/

// TODO: MARITAL STATUS & EMAIL

// TODO: MARITAL STATUS & IC

// TODO: MARITAL STATUS & EMPLOYMENT STATUS

// TODO: MARITAL STATUS & GENDER

// TODO: MARITAL STATUS & MARITAL STATUS

// TODO: MARITAL STATUS & MARITAL STATUS

// TODO: MARITAL STATUS & TOTAL YEAR

// TODO: MARITAL STATUS & POSITION

// TODO: MARITAL STATUS & QUALIFICATION

// TODO: MARITAL STATUS & INSTITUTION

// TODO: MARITAL STATUS & FIELD OF STUDY

// TODO: MARITAL STATUS & CGPA

// TODO: MARITAL STATUS & LANGUMARITAL STATUS

// TODO: MARITAL STATUS & SKILL TYPE

// TODO: MARITAL STATUS & LICENSE

// TODO: MARITAL STATUS & STATE

// TODO: MARITAL STATUS & DISTRICT

// TODO: MARITAL STATUS & SUB-DISTRICT

// TODO: MARITAL STATUS & WORK LOCATION PREFER

// TODO: MARITAL STATUS & JOB INDUSTRY PREFER

// TODO: MARITAL STATUS & EXPECTED SALARY PREFER

// TODO: MARITAL STATUS & DISC TEST


/*************************************************************************************************************************
 * Double Variable :: YEAREXP
 *************************************************************************************************************************/

// TODO: YEAREXP & EMAIL

// TODO: YEAREXP & IC

// TODO: YEAREXP & EMPLOYMENT STATUS

// TODO: YEAREXP & GENDER

// TODO: YEAREXP & YEAREXP

// TODO: YEAREXP & MARITAL STATUS

// TODO: YEAREXP & TOTAL YEAR

// TODO: YEAREXP & POSITION

// TODO: YEAREXP & QUALIFICATION

// TODO: YEAREXP & INSTITUTION

// TODO: YEAREXP & FIELD OF STUDY

// TODO: YEAREXP & CGPA

// TODO: YEAREXP & LANGUYEAREXP

// TODO: YEAREXP & SKILL TYPE

// TODO: YEAREXP & LICENSE

// TODO: YEAREXP & STATE

// TODO: YEAREXP & DISTRICT

// TODO: YEAREXP & SUB-DISTRICT

// TODO: YEAREXP & WORK LOCATION PREFER

// TODO: YEAREXP & JOB INDUSTRY PREFER

// TODO: YEAREXP & EXPECTED SALARY PREFER

// TODO: YEAREXP & DISC TEST


/*************************************************************************************************************************
 * Double Variable :: POSITION
 *************************************************************************************************************************/


// TODO: POSITION & EMAIL

// TODO: POSITION & IC

// TODO: POSITION & EMPLOYMENT STATUS

// TODO: POSITION & GENDER

// TODO: POSITION & POSITION

// TODO: POSITION & MARITAL STATUS

// TODO: POSITION & TOTAL YEAR

// TODO: POSITION & POSITION

// TODO: POSITION & QUALIFICATION

// TODO: POSITION & INSTITUTION

// TODO: POSITION & FIELD OF STUDY

// TODO: POSITION & CGPA

// TODO: POSITION & LANGUPOSITION

// TODO: POSITION & SKILL TYPE

// TODO: POSITION & LICENSE

// TODO: POSITION & STATE

// TODO: POSITION & DISTRICT

// TODO: POSITION & SUB-DISTRICT

// TODO: POSITION & WORK LOCATION PREFER

// TODO: POSITION & JOB INDUSTRY PREFER

// TODO: POSITION & EXPECTED SALARY PREFER

// TODO: POSITION & DISC TEST


/*************************************************************************************************************************
 * Double Variable :: QUALIFICATION
 *************************************************************************************************************************/

// TODO: QUALIFICATION & EMAIL

// TODO: QUALIFICATION & IC

// TODO: QUALIFICATION & EMPLOYMENT STATUS

// TODO: QUALIFICATION & GENDER

// TODO: QUALIFICATION & QUALIFICATION

// TODO: QUALIFICATION & MARITAL STATUS

// TODO: QUALIFICATION & TOTAL YEAR

// TODO: QUALIFICATION & POSITION

// TODO: QUALIFICATION & QUALIFICATION

// TODO: QUALIFICATION & INSTITUTION

// QUALIFICATION & FIELD OF STUDY
if($qualification != 'All' && $fieldStudy != 0) {

$query_rsJobseekers = "SELECT
  jp_users.*,
  jp_education.*,
  jp_education.user_id_fk As user_id_fk1,
  jp_jobseeker.jobseeker_tel,
  jp_jobseeker.jobseeker_mobile,
  jp_education.edu_qualification As edu_qualification1,
  jp_education.edu_fieldStudy As edu_fieldStudy1
From
  jp_users Inner Join
  jp_education On jp_education.user_id_fk = jp_users.users_id Inner Join
  jp_jobseeker On jp_jobseeker.users_id_fk = jp_users.users_id
Where
  jp_users.users_type = 1 And
  jp_education.edu_qualification = $qualification And
  jp_users.user_active = 1 And
  jp_education.edu_fieldStudy = $fieldStudy
Group By
  jp_education.user_id_fk";



}

// TODO: QUALIFICATION & CGPA

// TODO: QUALIFICATION & LANGUQUALIFICATION

// TODO: QUALIFICATION & SKILL TYPE

// TODO: QUALIFICATION & LICENSE

// TODO: QUALIFICATION & STATE

// TODO: QUALIFICATION & DISTRICT

// TODO: QUALIFICATION & SUB-DISTRICT

// TODO: QUALIFICATION & WORK LOCATION PREFER

// TODO: QUALIFICATION & JOB INDUSTRY PREFER

// TODO: QUALIFICATION & EXPECTED SALARY PREFER

// TODO: QUALIFICATION & DISC TEST


/*************************************************************************************************************************
 * Double Variable :: INSTITUTION
 *************************************************************************************************************************/

// TODO: INSTITUTION & EMAIL

// TODO: INSTITUTION & IC

// TODO: INSTITUTION & EMPLOYMENT STATUS

// TODO: INSTITUTION & GENDER

// TODO: INSTITUTION & INSTITUTION

// TODO: INSTITUTION & MARITAL STATUS

// TODO: INSTITUTION & TOTAL YEAR

// TODO: INSTITUTION & POSITION

// TODO: INSTITUTION & QUALIFICATION

// TODO: INSTITUTION & INSTITUTION

// TODO: INSTITUTION & FIELD OF STUDY

// TODO: INSTITUTION & CGPA

// TODO: INSTITUTION & LANGUINSTITUTION

// TODO: INSTITUTION & SKILL TYPE

// TODO: INSTITUTION & LICENSE

// TODO: INSTITUTION & STATE

// TODO: INSTITUTION & DISTRICT

// TODO: INSTITUTION & SUB-DISTRICT

// TODO: INSTITUTION & WORK LOCATION PREFER

// TODO: INSTITUTION & JOB INDUSTRY PREFER

// TODO: INSTITUTION & EXPECTED SALARY PREFER

// TODO: INSTITUTION & DISC TEST


/*************************************************************************************************************************
 * Double Variable :: FIELD OF STUDY
 *************************************************************************************************************************/

// TODO: FIELD OF STUDY & EMAIL

// TODO: FIELD OF STUDY & IC

// TODO: FIELD OF STUDY & EMPLOYMENT STATUS

// TODO: FIELD OF STUDY & GENDER

// TODO: FIELD OF STUDY & FIELD OF STUDY

// TODO: FIELD OF STUDY & MARITAL STATUS

// TODO: FIELD OF STUDY & TOTAL YEAR

// TODO: FIELD OF STUDY & POSITION

// TODO: FIELD OF STUDY & QUALIFICATION

// TODO: FIELD OF STUDY & INSTITUTION

// TODO: FIELD OF STUDY & FIELD OF STUDY

// TODO: FIELD OF STUDY & CGPA

// TODO: FIELD OF STUDY & LANGUFIELD OF STUDY

// TODO: FIELD OF STUDY & SKILL TYPE

// TODO: FIELD OF STUDY & LICENSE

// TODO: FIELD OF STUDY & STATE

// TODO: FIELD OF STUDY & DISTRICT

// TODO: FIELD OF STUDY & SUB-DISTRICT

// TODO: FIELD OF STUDY & WORK LOCATION PREFER

// TODO: FIELD OF STUDY & JOB INDUSTRY PREFER

// TODO: FIELD OF STUDY & EXPECTED SALARY PREFER

// TODO: FIELD OF STUDY & DISC TEST


/*************************************************************************************************************************
 * Double Variable :: CGPA
 *************************************************************************************************************************/

// TODO: CGPA & EMAIL

// TODO: CGPA & IC

// TODO: CGPA & EMPLOYMENT STATUS

// TODO: CGPA & GENDER

// TODO: CGPA & CGPA

// TODO: CGPA & MARITAL STATUS

// TODO: CGPA & TOTAL YEAR

// TODO: CGPA & POSITION

// TODO: CGPA & QUALIFICATION

// TODO: CGPA & INSTITUTION

// TODO: CGPA & FIELD OF STUDY

// TODO: CGPA & CGPA

// TODO: CGPA & LANGUCGPA

// TODO: CGPA & SKILL TYPE

// TODO: CGPA & LICENSE

// TODO: CGPA & STATE

// TODO: CGPA & DISTRICT

// TODO: CGPA & SUB-DISTRICT

// TODO: CGPA & WORK LOCATION PREFER

// TODO: CGPA & JOB INDUSTRY PREFER

// TODO: CGPA & EXPECTED SALARY PREFER

// TODO: CGPA & DISC TEST


/*************************************************************************************************************************
 * Double Variable :: LANGUAGE
 *************************************************************************************************************************/


// TODO: LANGUAGE & EMAIL

// TODO: LANGUAGE & IC

// TODO: LANGUAGE & EMPLOYMENT STATUS

// TODO: LANGUAGE & GENDER

// TODO: LANGUAGE & LANGUAGE

// TODO: LANGUAGE & MARITAL STATUS

// TODO: LANGUAGE & TOTAL YEAR

// TODO: LANGUAGE & POSITION

// TODO: LANGUAGE & QUALIFICATION

// TODO: LANGUAGE & INSTITUTION

// TODO: LANGUAGE & FIELD OF STUDY

// TODO: LANGUAGE & CGPA

// TODO: LANGUAGE & LANGULANGUAGE

// TODO: LANGUAGE & SKILL TYPE

// TODO: LANGUAGE & LICENSE

// TODO: LANGUAGE & STATE

// TODO: LANGUAGE & DISTRICT

// TODO: LANGUAGE & SUB-DISTRICT

// TODO: LANGUAGE & WORK LOCATION PREFER

// TODO: LANGUAGE & JOB INDUSTRY PREFER

// TODO: LANGUAGE & EXPECTED SALARY PREFER

// TODO: LANGUAGE & DISC TEST


/*************************************************************************************************************************
 * Double Variable :: SKILL TYPE
 *************************************************************************************************************************/


// TODO: SKILL TYPE & EMAIL

// TODO: SKILL TYPE & IC

// TODO: SKILL TYPE & EMPLOYMENT STATUS

// TODO: SKILL TYPE & GENDER

// TODO: SKILL TYPE & SKILL TYPE

// TODO: SKILL TYPE & MARITAL STATUS

// TODO: SKILL TYPE & TOTAL YEAR

// TODO: SKILL TYPE & POSITION

// TODO: SKILL TYPE & QUALIFICATION

// TODO: SKILL TYPE & INSTITUTION

// TODO: SKILL TYPE & FIELD OF STUDY

// TODO: SKILL TYPE & CGPA

// TODO: SKILL TYPE & LANGUSKILL TYPE

// TODO: SKILL TYPE & SKILL TYPE

// TODO: SKILL TYPE & LICENSE

// TODO: SKILL TYPE & STATE

// TODO: SKILL TYPE & DISTRICT

// TODO: SKILL TYPE & SUB-DISTRICT

// TODO: SKILL TYPE & WORK LOCATION PREFER

// TODO: SKILL TYPE & JOB INDUSTRY PREFER

// TODO: SKILL TYPE & EXPECTED SALARY PREFER

// TODO: SKILL TYPE & DISC TEST


/*************************************************************************************************************************
 * Double Variable :: LICENSES
 *************************************************************************************************************************/

// TODO: LICENCES & EMAIL

// TODO: LICENCES & IC

// TODO: LICENCES & EMPLOYMENT STATUS

// TODO: LICENCES & GENDER

// TODO: LICENCES & LICENCES

// TODO: LICENCES & MARITAL STATUS

// TODO: LICENCES & TOTAL YEAR

// TODO: LICENCES & POSITION

// TODO: LICENCES & QUALIFICATION

// TODO: LICENCES & INSTITUTION

// TODO: LICENCES & FIELD OF STUDY

// TODO: LICENCES & CGPA

// TODO: LICENCES & LANGULICENCES

// TODO: LICENCES & SKILL TYPE

// TODO: LICENCES & LICENSE

// TODO: LICENCES & STATE

// TODO: LICENCES & DISTRICT

// TODO: LICENCES & SUB-DISTRICT

// TODO: LICENCES & WORK LOCATION PREFER

// TODO: LICENCES & JOB INDUSTRY PREFER

// TODO: LICENCES & EXPECTED SALARY PREFER

// TODO: LICENCES & DISC TEST


/*************************************************************************************************************************
 * Double Variable :: STATE
 *************************************************************************************************************************/

// TODO: STATE & EMAIL

// TODO: STATE & IC

// TODO: STATE & EMPLOYMENT STATUS

// TODO: STATE & GENDER

// TODO: STATE & STATE

// TODO: STATE & MARITAL STATUS

// TODO: STATE & TOTAL YEAR

// TODO: STATE & POSITION

// TODO: STATE & QUALIFICATION

// TODO: STATE & INSTITUTION

// TODO: STATE & FIELD OF STUDY

// TODO: STATE & CGPA

// TODO: STATE & LANGUSTATE

// TODO: STATE & SKILL TYPE

// TODO: STATE & LICENSE

// TODO: STATE & STATE

// TODO: STATE & DISTRICT

// TODO: STATE & SUB-DISTRICT

// TODO: STATE & WORK LOCATION PREFER

// TODO: STATE & JOB INDUSTRY PREFER

// TODO: STATE & EXPECTED SALARY PREFER

// TODO: STATE & DISC TEST


/*************************************************************************************************************************
 * Double Variable :: DISTRICT
 *************************************************************************************************************************/

// TODO: DISTRICT & EMAIL

// TODO: DISTRICT & IC

// TODO: DISTRICT & EMPLOYMENT STATUS

// TODO: DISTRICT & GENDER

// TODO: DISTRICT & DISTRICT

// TODO: DISTRICT & MARITAL STATUS

// TODO: DISTRICT & TOTAL YEAR

// TODO: DISTRICT & POSITION

// TODO: DISTRICT & QUALIFICATION

// TODO: DISTRICT & INSTITUTION

// TODO: DISTRICT & FIELD OF STUDY

// TODO: DISTRICT & CGPA

// TODO: DISTRICT & LANGUDISTRICT

// TODO: DISTRICT & SKILL TYPE

// TODO: DISTRICT & LICENSE

// TODO: DISTRICT & STATE

// TODO: DISTRICT & DISTRICT

// TODO: DISTRICT & SUB-DISTRICT

// TODO: DISTRICT & WORK LOCATION PREFER

// TODO: DISTRICT & JOB INDUSTRY PREFER

// TODO: DISTRICT & EXPECTED SALARY PREFER

// TODO: DISTRICT & DISC TEST


/*************************************************************************************************************************
 * Double Variable :: SUBDISTRICT
 *************************************************************************************************************************/

 // TODO: SUBDISTRICT & EMAIL

// TODO: SUBDISTRICT & IC

// TODO: SUBDISTRICT & EMPLOYMENT STATUS

// TODO: SUBDISTRICT & GENDER

// TODO: SUBDISTRICT & SUBDISTRICT

// TODO: SUBDISTRICT & MARITAL STATUS

// TODO: SUBDISTRICT & TOTAL YEAR

// TODO: SUBDISTRICT & POSITION

// TODO: SUBDISTRICT & QUALIFICATION

// TODO: SUBDISTRICT & INSTITUTION

// TODO: SUBDISTRICT & FIELD OF STUDY

// TODO: SUBDISTRICT & CGPA

// TODO: SUBDISTRICT & LANGUSUBDISTRICT

// TODO: SUBDISTRICT & SKILL TYPE

// TODO: SUBDISTRICT & LICENSE

// TODO: SUBDISTRICT & STATE

// TODO: SUBDISTRICT & DISTRICT

// TODO: SUBDISTRICT & SUB-DISTRICT

// TODO: SUBDISTRICT & WORK LOCATION PREFER

// TODO: SUBDISTRICT & JOB INDUSTRY PREFER

// TODO: SUBDISTRICT & EXPECTED SALARY PREFER

// TODO: SUBDISTRICT & DISC TEST


/*************************************************************************************************************************
 * Double Variable :: SUBDISTRICT
 *************************************************************************************************************************/


 // TODO: WORKLOCATIONPREFER & EMAIL

// TODO: WORKLOCATIONPREFER & IC

// TODO: WORKLOCATIONPREFER & EMPLOYMENT STATUS

// TODO: WORKLOCATIONPREFER & GENDER

// TODO: WORKLOCATIONPREFER & WORKLOCATIONPREFER

// TODO: WORKLOCATIONPREFER & MARITAL STATUS

// TODO: WORKLOCATIONPREFER & TOTAL YEAR

// TODO: WORKLOCATIONPREFER & POSITION

// TODO: WORKLOCATIONPREFER & QUALIFICATION

// TODO: WORKLOCATIONPREFER & INSTITUTION

// TODO: WORKLOCATIONPREFER & FIELD OF STUDY

// TODO: WORKLOCATIONPREFER & CGPA

// TODO: WORKLOCATIONPREFER & LANGUWORKLOCATIONPREFER

// TODO: WORKLOCATIONPREFER & SKILL TYPE

// TODO: WORKLOCATIONPREFER & LICENSE

// TODO: WORKLOCATIONPREFER & STATE

// TODO: WORKLOCATIONPREFER & DISTRICT

// TODO: WORKLOCATIONPREFER & SUB-DISTRICT

// TODO: WORKLOCATIONPREFER & WORK LOCATION PREFER

// TODO: WORKLOCATIONPREFER & JOB INDUSTRY PREFER

// TODO: WORKLOCATIONPREFER & EXPECTED SALARY PREFER

// TODO: WORKLOCATIONPREFER & DISC TEST



/*************************************************************************************************************************
 * Double Variable :: JOBINDUSTRYPREFER
 *************************************************************************************************************************/

// TODO: JOBINDUSTRYPREFER & EMAIL

// TODO: JOBINDUSTRYPREFER & IC

// TODO: JOBINDUSTRYPREFER & EMPLOYMENT STATUS

// TODO: JOBINDUSTRYPREFER & GENDER

// TODO: JOBINDUSTRYPREFER & JOBINDUSTRYPREFER

// TODO: JOBINDUSTRYPREFER & MARITAL STATUS

// TODO: JOBINDUSTRYPREFER & TOTAL YEAR

// TODO: JOBINDUSTRYPREFER & POSITION

// TODO: JOBINDUSTRYPREFER & QUALIFICATION

// TODO: JOBINDUSTRYPREFER & INSTITUTION

// TODO: JOBINDUSTRYPREFER & FIELD OF STUDY

// TODO: JOBINDUSTRYPREFER & CGPA

// TODO: JOBINDUSTRYPREFER & LANGUJOBINDUSTRYPREFER

// TODO: JOBINDUSTRYPREFER & SKILL TYPE

// TODO: JOBINDUSTRYPREFER & LICENSE

// TODO: JOBINDUSTRYPREFER & STATE

// TODO: JOBINDUSTRYPREFER & DISTRICT

// TODO: JOBINDUSTRYPREFER & SUB-DISTRICT

// TODO: JOBINDUSTRYPREFER & WORK LOCATION PREFER

// TODO: JOBINDUSTRYPREFER & JOB INDUSTRY PREFER

// TODO: JOBINDUSTRYPREFER & EXPECTED SALARY PREFER

// TODO: JOBINDUSTRYPREFER & DISC TEST



/*************************************************************************************************************************
 * Double Variable :: EXPECTED SALARY
 *************************************************************************************************************************/

// TODO: EXPECTED SALARY & EMAIL

// TODO: EXPECTED SALARY & IC

// TODO: EXPECTED SALARY & EMPLOYMENT STATUS

// TODO: EXPECTED SALARY & GENDER

// TODO: EXPECTED SALARY & EXPECTED SALARY

// TODO: EXPECTED SALARY & MARITAL STATUS

// TODO: EXPECTED SALARY & TOTAL YEAR

// TODO: EXPECTED SALARY & POSITION

// TODO: EXPECTED SALARY & QUALIFICATION

// TODO: EXPECTED SALARY & INSTITUTION

// TODO: EXPECTED SALARY & FIELD OF STUDY

// TODO: EXPECTED SALARY & CGPA

// TODO: EXPECTED SALARY & LANGUEXPECTED SALARY

// TODO: EXPECTED SALARY & SKILL TYPE

// TODO: EXPECTED SALARY & LICENSE

// TODO: EXPECTED SALARY & STATE

// TODO: EXPECTED SALARY & DISTRICT

// TODO: EXPECTED SALARY & SUB-DISTRICT

// TODO: EXPECTED SALARY & WORK LOCATION PREFER

// TODO: EXPECTED SALARY & JOB INDUSTRY PREFER

// TODO: EXPECTED SALARY & EXPECTED SALARY PREFER

// TODO: EXPECTED SALARY & DISC TEST


/*************************************************************************************************************************
 * Double Variable :: DISC TEST
 *************************************************************************************************************************/


// TODO: DISC TEST & EMAIL

// TODO: DISC TEST & IC

// TODO: DISC TEST & EMPLOYMENT STATUS

// TODO: DISC TEST & GENDER

// TODO: DISC TEST & DISC TEST

// TODO: DISC TEST & MARITAL STATUS

// TODO: DISC TEST & TOTAL YEAR

// TODO: DISC TEST & POSITION

// TODO: DISC TEST & QUALIFICATION

// TODO: DISC TEST & INSTITUTION

// TODO: DISC TEST & FIELD OF STUDY

// TODO: DISC TEST & CGPA

// TODO: DISC TEST & LANGUDISC TEST

// TODO: DISC TEST & SKILL TYPE

// TODO: DISC TEST & LICENSE

// TODO: DISC TEST & STATE

// TODO: DISC TEST & DISTRICT

// TODO: DISC TEST & SUB-DISTRICT

// TODO: DISC TEST & WORK LOCATION PREFER

// TODO: DISC TEST & JOB INDUSTRY PREFER

// TODO: DISC TEST & EXPECTED SALARY PREFER

// TODO: DISC TEST & DISC TEST



// ========================================================================================================================

$query_limit_rsJobseekers = sprintf("%s LIMIT %d, %d", $query_rsJobseekers, $startRow_rsJobseekers, $maxRows_rsJobseekers);
$rsJobseekers = mysql_query($query_limit_rsJobseekers, $conPerak) or die(mysql_error());
$row_rsJobseekers = mysql_fetch_assoc($rsJobseekers);

if (isset($_GET['totalRows_rsJobseekers'])) {
  $totalRows_rsJobseekers = $_GET['totalRows_rsJobseekers'];
} else {
  $all_rsJobseekers = mysql_query($query_rsJobseekers);
  $totalRows_rsJobseekers = mysql_num_rows($all_rsJobseekers);
}
$totalPages_rsJobseekers = ceil($totalRows_rsJobseekers/$maxRows_rsJobseekers)-1;

$queryString_rsJobseekers = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsJobseekers") == false && 
        stristr($param, "totalRows_rsJobseekers") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsJobseekers = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsJobseekers = sprintf("&totalRows_rsJobseekers=%d%s", $totalRows_rsJobseekers, $queryString_rsJobseekers);

$queryString_rsResumes = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsResumes") == false && 
        stristr($param, "totalRows_rsResumes") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsResumes = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsResumes = sprintf("&totalRows_rsResumes=%d%s", $totalRows_rsResumes, $queryString_rsResumes);

$maxRows_rsUserLists = 100;
$pageNum_rsUserLists = 0;
if (isset($_GET['pageNum_rsUserLists'])) {
  $pageNum_rsUserLists = $_GET['pageNum_rsUserLists'];
}
$startRow_rsUserLists = $pageNum_rsUserLists * $maxRows_rsUserLists;

mysql_select_db($database_conPerak, $conPerak);
// tweak for filter
$type_of_user = (int) mysql_real_escape_string(@$_GET['type_of_user']);
$activation = (int) mysql_real_escape_string(@$_GET['activation']);
$email = mysql_real_escape_string(@$_GET['email']);

if($email == "" && $type_of_user == '-1' && $activation == '-1'){
  $query_rsUserLists = "SELECT * FROM jp_users";
} elseif($email != "" && $type_of_user == '-1' && $activation == '-1') {
  $query_rsUserLists = "SELECT * FROM jp_users WHERE users_email LIKE '%".$email."%'";
} elseif($email == "" && $type_of_user != '-1' && $activation == '-1') {
  $query_rsUserLists = "SELECT * FROM jp_users WHERE users_type = '".$type_of_user."'";
} elseif($email == "" && $type_of_user == '-1' && $activation != '-1') {
  $query_rsUserLists = "SELECT * FROM jp_users WHERE user_active = ".$activation;
} elseif($email != "" && $type_of_user != '-1' && $activation != '-1') {
  $query_rsUserLists = "SELECT * FROM jp_users WHERE users_email LIKE '%".$email."%' AND users_type = '$type_of_user' AND user_active = '$activation'";
} else {
  $query_rsUserLists = "SELECT * FROM jp_users";
}
// ============================================
$query_limit_rsUserLists = sprintf("%s LIMIT %d, %d", $query_rsUserLists, $startRow_rsUserLists, $maxRows_rsUserLists);
$rsUserLists = mysql_query($query_limit_rsUserLists, $conPerak) or die(mysql_error());
$row_rsUserLists = mysql_fetch_assoc($rsUserLists);

if (isset($_GET['totalRows_rsUserLists'])) {
  $totalRows_rsUserLists = $_GET['totalRows_rsUserLists'];
} else {
  $all_rsUserLists = mysql_query($query_rsUserLists);
  $totalRows_rsUserLists = mysql_num_rows($all_rsUserLists);
}
$totalPages_rsUserLists = ceil($totalRows_rsUserLists/$maxRows_rsUserLists)-1;

$queryString_rsUserLists = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsUserLists") == false && 
        stristr($param, "totalRows_rsUserLists") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsUserLists = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsUserLists = sprintf("&totalRows_rsUserLists=%d%s", $totalRows_rsUserLists, $queryString_rsUserLists);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Jobsperak Management Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>

    <?php include("header.php"); ?>

    <div class="container">

		<div style="text-align:center">
      
      <h1>Hello, <?php echo $row_rsAdminName['admin_name']; ?>! Here the list of all resumes.</h1>
      <p>I was listed all the resumes registered as jobseeker.</p><br/><br/>
      <?php if ($totalRows_rsJobseekers > 0) { // Show if recordset not empty ?>

      <div>
        <form action="exportToExcel.php" method="post" target="_blank" accept-charset="utf-8" class="form-inline">
            <label>Excel filename: <input type="text" name="excelName" value="" id="excelName" placeholder="What filename should be?"></label>
            <input type="submit" name="btnexport" value="Export to Excel" id="btnexport" class="btn btn-success">
            <input type="hidden" name="tableData" id="tableData" value="<?php echo $query_rsJobseekers; ?>">
          </form>  
      </div>

  <table width="100%" border="0" class="table table-hover table-striped">
    <tr>
      <th scope="col">Full Name</th>
      <th scope="col">Email</th>
      <th scope="col">Phone</th>
      <th scope="col">Mobile</th>
      <th scope="col">Resume</th>
      <th scope="col">Action</th>
    </tr>
    <?php do { ?>
      <tr>
        <td><?php echo $row_rsJobseekers['users_fname']; ?> <?php echo $row_rsJobseekers['users_lname']; ?></td>
        <td><?php echo $row_rsJobseekers['users_email']; ?></td>
        <td><?php echo $row_rsJobseekers['jobseeker_tel']; ?></td>
        <td><?php echo $row_rsJobseekers['jobseeker_mobile']; ?></td>
        <td><?php 

            /**
             *
             * Record Set for resume
             * Retrieve via object 
             * 
             */
            $query_resume     = "SELECT jp_resume.resume_path,
                   jp_resume.resume_upload_on,
                   jp_resume.users_id_fk
            FROM jp_resume
            WHERE jp_resume.users_id_fk = ".$row_rsJobseekers['users_id']."
            ORDER BY jp_resume.resume_upload_on DESC LIMIT 1";
            $rs_resume        = mysql_query($query_resume) or die(mysql_error());
            $row_resume       = mysql_fetch_object($rs_resume);
            $totalRows_resume = mysql_num_rows($rs_resume);
            
            if ($totalRows_resume > 0) {
              echo "<span class=\"icon-download\"></span> <a href=\"http://jobsperak.com/v1/media/resume/$row_resume->resume_path\" title=\"Download\">Download</a>";
            } else {
              echo "Not Provided";
            }

        ?></td>
        <td><a href="jobSeekerResume.php?js_id=<?php echo $row_rsJobseekers['users_id']; ?>" title="">View</a></td>
      </tr>
      <?php } while ($row_rsJobseekers = mysql_fetch_assoc($rsJobseekers)); ?>
  </table>
      <br>
      <table border="0">
        <tr>
          <td><?php if ($pageNum_rsJobseekers > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_rsJobseekers=%d%s", $currentPage, 0, $queryString_rsJobseekers); ?>">First</a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_rsJobseekers > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_rsJobseekers=%d%s", $currentPage, max(0, $pageNum_rsJobseekers - 1), $queryString_rsJobseekers); ?>">Previous</a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_rsJobseekers < $totalPages_rsJobseekers) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_rsJobseekers=%d%s", $currentPage, min($totalPages_rsJobseekers, $pageNum_rsJobseekers + 1), $queryString_rsJobseekers); ?>">Next</a>
              <?php } // Show if not last page ?></td>
          <td><?php if ($pageNum_rsJobseekers < $totalPages_rsJobseekers) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_rsJobseekers=%d%s", $currentPage, $totalPages_rsJobseekers, $queryString_rsJobseekers); ?>">Last</a>
              <?php } // Show if not last page ?></td>
        </tr>
      </table>
  <br/>
      Records <?php echo ($startRow_rsJobseekers + 1) ?> to <?php echo min($startRow_rsJobseekers + $maxRows_rsJobseekers, $totalRows_rsJobseekers) ?> of <?php echo $totalRows_rsJobseekers ?>
  <?php } // Show if recordset not empty ?>
<br/>
  <br/>
  <br/>
  <?php if ($totalRows_rsJobseekers == 0) { // Show if recordset empty ?>
    Ohh no! No Result for your queries. So sad.
  <?php } // Show if recordset empty ?>
	  </div>

    </div> <!-- /container -->

	<?php include("footer.php"); ?>
  
  </body>
</html>
<?php
mysql_free_result($rsAdminName);

mysql_free_result($rsLanguageList);

mysql_free_result($rsResumes);

mysql_free_result($rsJobseekers);

mysql_free_result($rsUserLists);
?>