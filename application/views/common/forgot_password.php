<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title></title>
</head>
<body>
<table width="100%" height="100%"  cellpadding="2" cellspacing="3">
	<tr>
		<td>Dear <?php echo $user_name ?>,</td>
	</tr>
	<tr>
		<td>You recently requested that your password be sent to for <?php echo base_url(); ?>administrator</td>
	</tr>
	<tr>
		<td>Your Email Id is: <?php echo $email; ?><br><br>
		  Your Password is: <?php echo $password; ?><br><br>
		  Use this together with your user name to log on to the site.</td>
	</tr>
	<tr>
		<td>Thank you</td>
	</tr>
	<tr>
		<td><a href="<?php echo base_url(); ?>administrator"><?php echo $this->config->item('site_name'); ?></a></td>
	</tr>
	<tr>
		<td></td>
	</tr>
</table>
<body>
</body>
</html>
