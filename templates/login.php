<?php require('../lib.php'); ?>
<?php token(); ?>


<!DOCTYPE html>
<html lang="en">
<head>
  	<meta http-equiv="Content-Type" content="text/html charset=utf-8" />
  	<title>Epic Blog</title>
	<link rel="stylesheet" href="/assets/default.css" type="text/css"/>
</head>
	<body>
		<h1>Blog</h1>
		<h2>Login page</h2>
		<div class="form">
			<form name"auth" action="../index.php" method="POST" class="form_login">
				<table>
				<tr>
					<td>User:</td>
					<td><input type="text" name="login"</td></tr>
				<tr>
					<td>Password:</td>
					<td><input type="password" name="password"/></td></tr>
					<tr><td></td><td><input type="submit" name="signin" value="Sign In"/>
					<input type="submit" name="register" value="Register"/></td>
				</tr>
				</table>
				<input type="hidden" name="token" value="<?=$token ?>">
			</form>
		</div>
	</body>
</html>
<?php
if (isset($_POST['signin']))
{
login();
}