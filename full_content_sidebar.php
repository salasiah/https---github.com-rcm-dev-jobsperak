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

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsArticleCat = "Select   jp_article.*,   jp_article.art_id As art_id1 From   jp_article Where   arc_published = 1  Order By   RAND() LIMIT 0,5";
$rsArticleCat = mysql_query($query_rsArticleCat, $conJobsPerak) or die(mysql_error());
$row_rsArticleCat = mysql_fetch_assoc($rsArticleCat);
$totalRows_rsArticleCat = mysql_num_rows($rsArticleCat);

$maxRows_rsRoadshowList = 1;
$pageNum_rsRoadshowList = 0;
if (isset($_GET['pageNum_rsRoadshowList'])) {
  $pageNum_rsRoadshowList = $_GET['pageNum_rsRoadshowList'];
}
$startRow_rsRoadshowList = $pageNum_rsRoadshowList * $maxRows_rsRoadshowList;

mysql_select_db($database_conJobsPerak, $conJobsPerak);
$query_rsRoadshowList = "SELECT * FROM jp_roadshow WHERE status = 1 ORDER BY rs_date DESC";
$query_limit_rsRoadshowList = sprintf("%s LIMIT %d, %d", $query_rsRoadshowList, $startRow_rsRoadshowList, $maxRows_rsRoadshowList);
$rsRoadshowList = mysql_query($query_limit_rsRoadshowList, $conJobsPerak) or die(mysql_error());
$row_rsRoadshowList = mysql_fetch_assoc($rsRoadshowList);

if (isset($_GET['totalRows_rsRoadshowList'])) {
  $totalRows_rsRoadshowList = $_GET['totalRows_rsRoadshowList'];
} else {
  $all_rsRoadshowList = mysql_query($query_rsRoadshowList);
  $totalRows_rsRoadshowList = mysql_num_rows($all_rsRoadshowList);
}
$totalPages_rsRoadshowList = ceil($totalRows_rsRoadshowList/$maxRows_rsRoadshowList)-1;
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
<strong class="icon_bookmark">New Job Openings</strong>
<div class="sidebar_recentjob">
<div style="height:190px;">
<marquee behavior="scroll" direction="up" scrollamount="2.5" scrolldelay="2.5" onmouseover="this.stop()" onmouseout="this.start()">
	<div style="height:190px;">
    <ul>
        <?php do { ?>
          <li><a href="jobsAdsDetails.php?jobAdsId=<?php echo $row_rsRecentJobs['ads_id']; ?>"><?php echo ucwords($row_rsRecentJobs['ads_title']); ?></a> &middot; <span class="dateSidebar"><?php echo date('d/m/Y',strtotime($row_rsRecentJobs['ads_date_posted'])); ?></span></li>
          <?php } while ($row_rsRecentJobs = mysql_fetch_assoc($rsRecentJobs)); ?>
          <li><a href="jobsOpeningAll.php">View all Jobs</a></li>
    </ul>
    </div>
    </marquee>
</div>
</div><!-- .sidebar_recentjob -->
</div>


<div class="sidebarBox">
<strong class="icon_favorite">Companies Hiring This Week</strong>
<div class="sidebar_recentjob">
    <ul id="emp_pic">
          <?php do { ?>
            <li>
            <a href="employer.php?emp_id=<?php echo $row_rsHiringThisWeek['emp_id']; ?>&employer=<?php echo $row_rsHiringThisWeek['emp_name']; ?>"><img src="media/employer/img/<?php echo $row_rsHiringThisWeek['emp_pic']; ?>" width="50px" border="0" class="tipFade" title="<?php echo $row_rsHiringThisWeek['emp_name']; ?>" /></a>
            </li>
            <?php } while ($row_rsHiringThisWeek = mysql_fetch_assoc($rsHiringThisWeek)); ?>
            <div style="clear:both"></div>
    </ul>
</div><!-- .sidebar_recentjob -->
</div>

<div class="sidebarBox hide">
<strong class="ic_folder">Articles / Resource Categories</strong>
<div class="sidebar_recentjob">
    <ul>
    	<?php do { ?>
    	  <li><a href="content-details.php?cid=<?php echo $row_rsArticleCat['art_id']; ?>"><?php echo $row_rsArticleCat['art_title']; ?></a></li>
    	  <?php } while ($row_rsArticleCat = mysql_fetch_assoc($rsArticleCat)); ?>
    </ul>
</div><!-- .sidebar_recentjob -->
</div>

<div class="sidebarBox">
<strong>Next Stop Road Show</strong>
<div class="sidebar_recentjob">
    <ul>
      <?php if ($totalRows_rsRoadshowList > 0) { // Show if recordset not empty ?>
  <?php do { ?>
    <li><?php echo $row_rsRoadshowList['rs_name']; ?><br/>
      <em><?php echo $row_rsRoadshowList['rs_date']; ?></em></li>
    <?php } while ($row_rsRoadshowList = mysql_fetch_assoc($rsRoadshowList)); ?>
        <?php } // Show if recordset not empty ?>
        <?php if ($totalRows_rsRoadshowList == 0) { // Show if recordset empty ?>
  <li>No Road Show yet.</li>
  <?php } // Show if recordset empty ?>
    </ul>
</div><!-- .sidebar_recentjob -->
</div>

<br/><br/>
<div class="sidebarBox">
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
<!-- Tipsy -->
  	<script type='text/javascript' src='js/jquery.tipsy.js'></script>
  	<script type='text/javascript'>
	$(document).ready(function(){
		$('.tipFade').tipsy({
				gravity: 's',
				fade: true
			});
	});
    </script>
	<link rel="stylesheet" href="css/tipsy.css" type="text/css" />
<?php
mysql_free_result($rsRecentJobs);

mysql_free_result($rsHiringThisWeek);

mysql_free_result($rsArticleCat);

mysql_free_result($rsRoadshowList);
?>
