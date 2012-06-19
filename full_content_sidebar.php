<?php require_once('Connections/conJobsPerak.php'); ?>

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

$maxRows_rsRecentJobs = 10;
$pageNum_rsRecentJobs = 0;
if (isset($_GET['pageNum_rsRecentJobs'])) {
  $pageNum_rsRecentJobs = $_GET['pageNum_rsRecentJobs'];
}
$startRow_rsRecentJobs = $pageNum_rsRecentJobs * $maxRows_rsRecentJobs;

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsRecentJobs = "SELECT * FROM jp_ads WHERE ads_enable_view = 1 ORDER BY ads_id DESC";
$query_limit_rsRecentJobs = sprintf("%s LIMIT %d, %d", $query_rsRecentJobs, $startRow_rsRecentJobs, $maxRows_rsRecentJobs);
$rsRecentJobs = mysql_query($query_limit_rsRecentJobs, $conJobsPerak) or die(mysql_error());
$row_rsRecentJobs = mysql_fetch_assoc($rsRecentJobs);

if (isset($_GET['totalRows_rsRecentJobs'])) {
  $totalRows_rsRecentJobs = $_GET['totalRows_rsRecentJobs'];
} else {
  $all_rsRecentJobs = mysql_query($query_rsRecentJobs);
  $totalRows_rsRecentJobs = mysql_num_rows($all_rsRecentJobs);
}
$totalPages_rsRecentJobs = ceil($totalRows_rsRecentJobs/$maxRows_rsRecentJobs)-1;

$maxRows_rsHiringThisWeek = 10;
$pageNum_rsHiringThisWeek = 0;
if (isset($_GET['pageNum_rsHiringThisWeek'])) {
  $pageNum_rsHiringThisWeek = $_GET['pageNum_rsHiringThisWeek'];
}
$startRow_rsHiringThisWeek = $pageNum_rsHiringThisWeek * $maxRows_rsHiringThisWeek;

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsHiringThisWeek = "SELECT * FROM jp_employer ORDER BY emp_id DESC";
$query_limit_rsHiringThisWeek = sprintf("%s LIMIT %d, %d", $query_rsHiringThisWeek, $startRow_rsHiringThisWeek, $maxRows_rsHiringThisWeek);
$rsHiringThisWeek = mysql_query($query_limit_rsHiringThisWeek, $conJobsPerak) or die(mysql_error());
$row_rsHiringThisWeek = mysql_fetch_assoc($rsHiringThisWeek);

if (isset($_GET['totalRows_rsHiringThisWeek'])) {
  $totalRows_rsHiringThisWeek = $_GET['totalRows_rsHiringThisWeek'];
} else {
  $all_rsHiringThisWeek = mysql_query($query_rsHiringThisWeek);
  $totalRows_rsHiringThisWeek = mysql_num_rows($all_rsHiringThisWeek);
}
$totalPages_rsHiringThisWeek = ceil($totalRows_rsHiringThisWeek/$maxRows_rsHiringThisWeek)-1;
?>
<div class="sidebarBox hide">
<strong>How-to</strong>
<div class="sidebar_howto">
  <ul>
    <li><a href="#">Register</a></li>
    <li><a href="#">Post a Job</a></li>
</ul>
</div><!-- .sidebar_recentjob -->
</div><!-- .sidebarFullBox -->
            

<div class="sidebarBox">
<strong>New Job Openings</strong>
<div class="sidebar_recentjob">
    <ul>
        <?php do { ?>
          <li><a href="jobsAdsDetails.php?jobAdsId=<?php echo $row_rsRecentJobs['ads_id']; ?>"><?php echo $row_rsRecentJobs['ads_title']; ?></a> &middot; <span class="dateSidebar"><?php echo date('d/m/Y',strtotime($row_rsRecentJobs['ads_date_posted'])); ?></span></li>
          <?php } while ($row_rsRecentJobs = mysql_fetch_assoc($rsRecentJobs)); ?>
    </ul>
</div><!-- .sidebar_recentjob -->
</div>


<div class="sidebarBox">
<strong>Companies Hiring This Week</strong>
<div class="sidebar_recentjob">
    <ul>
          <?php do { ?>
            <li><a href="employer.php?emp_id=<?php echo $row_rsHiringThisWeek['emp_id']; ?>&employer=<?php echo $row_rsHiringThisWeek['emp_name']; ?>"><?php echo $row_rsHiringThisWeek['emp_name']; ?></a></li>
            <?php } while ($row_rsHiringThisWeek = mysql_fetch_assoc($rsHiringThisWeek)); ?>
    </ul>
</div><!-- .sidebar_recentjob -->
</div>


<div class="sidebarBox">
<strong>Find us on Facebook</strong>
<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FJobsPerak%2F198616306873628&amp;width=292&amp;height=290&amp;colorscheme=light&amp;show_faces=true&amp;border_color&amp;stream=false&amp;header=true&amp;appId=185462048213496" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:292px; height:290px;" allowTransparency="true"></iframe>
</div><!-- .sidebarBox -->


<div class="sidebarBox hide">
<strong>Advertisement</strong><br />
Facebook | Twitter | RSS
</div><!-- .sidebarBox -->

              
<div class="sidebarBox">
<strong>Get Connected</strong><br />
<table border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td><a href="https://www.facebook.com/pages/Official-Jobs-Perak/291068637611339" target="_blank"><img src="img/fb.png" alt="fb" width="41" height="41" border="0" title="Official Facebook Page"></a></td>
    <td><a href="https://twitter.com/#!/jobs_perak" target="_blank"><img src="img/twitt.png" alt="twitter" width="42" height="41" border="0" title="Official Twitter Account"></a></td>
  </tr>
</table>

</div><!-- .sidebarBox -->
<?php
mysql_free_result($rsRecentJobs);

mysql_free_result($rsHiringThisWeek);
?>
