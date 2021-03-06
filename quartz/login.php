<?php
	/*
	This file is part of CLPPhotoSite.

	CLPPhotoSite is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	CLPPhotoSite is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
	*/ 

	if(!isset($_SERVER['HTTPS']) && $_SERVER['REMOTE_ADDR'] != '127.0.0.1')
	{
//		header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME']);
//		exit;
	}
	include('includes.php');
	$messageStackError = '&nbsp;';
	if(isset($_GET['action']) && $_GET['action'] == 'process' && isset($_POST['username']) && isset($_POST['password']))
	{
		$res = mysql_query("SELECT * FROM administrators WHERE admin_name = '" . mysql_real_escape_string($_POST["username"]) . "' AND admin_pass = '" . crypt(mysql_real_escape_string($_POST["password"]), '$2a$77clmclpsalt22clmclpsalt') . "'");
		
		$login_results = mysql_fetch_assoc($res);
		
		if($login_results !== false)
		{
			create_session($login_results);
			header('Location: index.php');
			exit;
		}
	}
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html dir="ltr" lang="en">
<head>
<style>
body {
	margin:50px 0px; padding:0px;
	text-align:center;
	background-color:#eee;
	}
.Content {
	width:330px;
	margin:0px auto;
	text-align:left;
	padding:15px;
	background-color:#fff;
	-webkit-box-shadow: 0px 0px 3px 3px #ccc;
	-moz-box-shadow: 0px 0px 3px 3px #ccc;
	box-shadow: 0px 0px 3px 3px #ccc;
	vertical-align: middle;
    display: inline-block; 
	}
.messageStackError{
	text-align:center;
	font-family: Verdana, Arial, Sans-serif;
	font-size: 12px;
	color:#FF0000;
}
.input {
	padding:5px;
	height:26px;
	border:1px solid #999;
	color:#CCC;
}
span { 
    height: 90%;
    vertical-align: middle;
    display: inline-block;
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="robots" content="noindex,nofollow">
<title>Gallery Admin Tool</title>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="document.getElementById('username').focus();">
<table class="Content" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td align="center" colspan="2"><a href="index.php"><img src="../images/logo.png" width="300" border="0" alt="" title=""></a></td>
	</tr>
	<tr>
		<td align="center">
			<table width="100%" cellspacing="0" cellpadding="2" border="0">
				<tr>
					<td class="messageStackError">
						<?php echo $messageStackError; ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
			<form name="login" action="login.php?action=process" method="post">
				<table border="0" width="100%" cellspacing="0" cellpadding="10" >
					<tr>
						<td align="center" class="infoBoxContent"><input class="input" type="text" value="Username" name="username" id="username" size="35"onblur="if (this.value == '') {this.value = 'Username'; this.style.color = '#ccc';}" onfocus="if (this.value == 'Username') {this.value = ''; this.style.color = '#000';}" /></td>
					</tr>
					<tr>
						<td align="center" class="infoBoxContent"><input class="input" type="password" value="password" name="password" id="password" size="35" onblur="if (this.value == '') {this.value = 'password'; this.style.color = '#ccc';}" onfocus="if (this.value == 'password') {this.value = ''; this.style.color = '#000';}" onkeypress="this.style.color='#000';" /></td>
					</tr>
					<tr>
						<td align="center" class="infoBoxContent">
							<input type="submit" value="Login&nbsp;&gt;" />
						</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
</table>
<span></span>
<br>
<br>
</body>
</html>