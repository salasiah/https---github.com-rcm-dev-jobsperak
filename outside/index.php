<html>
<head>
<title>Jobsperak Entry form for outside applicant</title>
</head>
<style>
body, table {
font-family: "Verdana";
font-size:12px;
color:#333333;
}
</style>
<body>
<h1 id="top">Entry form for outside applicant</h1>
<a href="add.php">Add entry</a><br>
<br>

<?php
/// In order to use this script freely
/// you must leave the following copyright
/// information in this file:
/// Copyright 2012 www.turningturnip.co.uk
/// All rights reserved.

include("connect.php");

$result = mysql_query("SELECT * FROM jp_outside_successful ");
$num = mysql_num_rows ($result);
mysql_close();


if($num == 0){
echo "Nothing Found. Click add entry to add applicant";
} else {


echo '<table border="1" cellpadding="2" cellspacing="2">';

echo '<th>Email</th>';
echo '<th>First Name</th>';
echo '<th>Last Name</th>';
echo '<th>Employer Name</th>';
echo '<th>Phone</th>';
echo '<th>Position</th>';
echo '<th>Start Work</th>';

//echo '<th>Update</th>';
//echo '<th>Delete</th>';

while($row = mysql_fetch_object($result)){
echo '<tr>';

echo '<td>'.$row->email.'</td>';
echo '<td>'.$row->f_name.'</td>';
echo '<td>'.$row->l_name.'</td>';
echo '<td>'.$row->phone.'</td>';
echo '<td>'.$row->employer_name.'</td>';
echo '<td>'.$row->position.'</td>';
echo '<td>'.$row->start_work.'</td>';
//echo '<td><a href="update.php?id='.$row->id.'">Update</a></td>';
//echo '<td><a href="delete.php?id='.$row->id.'">Delete</a></td>';

echo '</tr>';
}

echo '</table>';

}


?>
<div style="text-align:right">
<a href="#top">Top</a>
</div>
</body>
</html>