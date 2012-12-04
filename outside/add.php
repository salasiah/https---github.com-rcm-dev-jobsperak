<form id="FormName" action="added.php" method="post" name="FormName">
<table width="448" border="0" cellspacing="2" cellpadding="0">

<tr>
<td width="150" align="right"><label for="email">Email</label></td>
<td><input name="email" maxlength="200" type="text" value="<?php echo stripslashes($email) ?>"></td>
</tr>

<tr>
<td width="150" align="right"><label for="f_name">First Name</label></td>
<td><input name="f_name" maxlength="200" type="text" value="<?php echo stripslashes($fxname) ?>"></td>
</tr>

<tr>
<td width="150" align="right"><label for="l_name">Last Name</label></td>
<td><input name="l_name" maxlength="200" type="text" value="<?php echo stripslashes($lxname) ?>"></td>
</tr>

<tr>
<td width="150" align="right"><label for="phone">Phone</label></td>
<td><input name="phone" maxlength="200" type="text" value="<?php echo stripslashes($phone) ?>"></td>
</tr>

<tr>
<td width="150" align="right"><label for="employer_name">Employer Name</label></td>
<td><input name="employer_name" maxlength="200" type="text" value="<?php echo stripslashes($employerxname) ?>"></td>
</tr>

<tr>
<td width="150" align="right"><label for="position">Position</label></td>
<td><input name="position" maxlength="200" type="text" value="<?php echo stripslashes($position) ?>"></td>
</tr>

<tr>
<td width="150" align="right"><label for="start_work">Start Work Date</label></td>
<td><input name="start_work" maxlength="200" type="text" value="<?php echo stripslashes($startxwork) ?>"></td>
</tr>

<tr>
<td colspan="2" align="center"><input name="" type="submit" value="Add"></td>
</tr>

</table>
</form>

<br/>
<br/>
<a href="index.php">View All Entry</a>