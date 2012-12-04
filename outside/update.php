<?php
/// In order to use this script freely
/// you must leave the following copyright
/// information in this file:
/// Copyright 2012 www.turningturnip.co.uk
/// All rights reserved.

include("connect.php");

$id = trim(mysql_real_escape_string($_REQUEST['id']));

$c_Z = mysql_query("SELECT * FROM jp_outside_successful WHERE id = '$id' ");
$r_Z = mysql_fetch_array($c_Z);
extract($r_Z);
?>

<form id="FormName" action="updated.php" method="post" name="FormName">
<table width="448" border="0" cellspacing="2" cellpadding="0">

<tr>
<td width="150" align="right"><label for="email">email</label></td>
<td><input name="email" maxlength="200" type="text" value="<?php echo stripslashes($email) ?>"></td>
</tr>

<tr>
<td width="150" align="right"><label for="f_name">fxname</label></td>
<td><input name="f_name" maxlength="200" type="text" value="<?php echo stripslashes($f_name) ?>"></td>
</tr>

<tr>
<td width="150" align="right"><label for="l_name">lxname</label></td>
<td><input name="l_name" maxlength="200" type="text" value="<?php echo stripslashes($l_name) ?>"></td>
</tr>

<tr>
<td width="150" align="right"><label for="phone">phone</label></td>
<td><input name="phone" maxlength="200" type="text" value="<?php echo stripslashes($phone) ?>"></td>
</tr>

<tr>
<td width="150" align="right"><label for="employer_name">employerxname</label></td>
<td><input name="employer_name" maxlength="200" type="text" value="<?php echo stripslashes($employer_name) ?>"></td>
</tr>

<tr>
<td width="150" align="right"><label for="position">position</label></td>
<td><input name="position" maxlength="200" type="text" value="<?php echo stripslashes($position) ?>"></td>
</tr>

<tr>
<td width="150" align="right"><label for="startxwork">startxwork</label></td>
<td><input name="start_work" maxlength="200" type="text" value="<?php echo stripslashes($start_work) ?>"></td>
</tr>

<tr>
<td colspan="2" align="center"><input name="" type="submit" value="Update"></td>
</tr>

</table>
</form>

<br/>
<br/>
<a href="index.php">View All Entry</a>