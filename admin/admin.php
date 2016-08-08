<?php
require_once('../antisql.php');
session_start();

if(!isset($_SESSION['is_admin']) && $_SESSION['is_admin'] != 1 ){	//无登陆禁止访问
	header('Location:index.php');
	exit;
}

$config=include('../config.php');   
$db = new mysqli($config['host'],$config['dbuser'], $config['dbpwd'], $config['dbname']);//连接数据库	

if (isset($_POST['act']) && isset($_POST['username'])) {
	
	if (inject_check($_POST['username'])) {die('管理员大哥不要注入……');}

	$username=$_POST['username'];
	if ($_POST['act']=='Active:yes') {
		$time=(string)date("Y-m-d H:i:s");
		$sql = "UPDATE user SET active='1' WHERE username='{$username}'";
		$db->query($sql);
		$sql = "UPDATE user SET activetime='{$time}' WHERE username='{$username}'";
		$db->query($sql);
		echo "<script language=JavaScript> location.replace(location.href);</script>";
	}		

	if ($_POST['act']=='Active:no') {
		$sql = "UPDATE user SET active='0' WHERE username='{$username}'";
		$db->query($sql);
		echo "<script language=JavaScript> location.replace(location.href);</script>";
	}

} 

?>



<html>
<head>
<meta http-equiv="content-type"content="text/html charset=utf-8">

</head>
<title>用户管理</title>
<body bgcolor="black">



<?php

echo '<h1 align=\'center\'><font color="#33FF00">用户管理</font></h1>';
//
$result = $db->query("SELECT * FROM user");


echo '<table border=\'1px\' bordercolor=\'green\' align=\'center\' >';
echo '<tr  style="color:red;"><th>&nbsp;&nbsp;Username&nbsp;&nbsp;</th><th>&nbsp;&nbsp;p4ssw0rd&nbsp;&nbsp;</th><th>&nbsp;Active&nbsp;</th><th>&nbsp;&nbsp;&nbsp;QQ&nbsp;&nbsp;&nbsp;</th><th>&nbsp;&nbsp;Name&nbsp;&nbsp;</th><th>&nbsp;&nbsp;ActiveTime&nbsp;&nbsp;</th></tr>';


while($row=$result->fetch_object()){

echo"<tr style=\"color:#33FF00;\"><td>$row->username</td><td>$row->password</td><td>$row->active</td><td>$row->qq</td><td>$row->name</td><td>$row->activetime</td></tr>";

}


echo "</table>";

?>



<br/><br/>
<form id="form1" name="form1" method="post" action="" align='center'>
    <input type="text" name="username" />
    <input type="submit" name="act" value="Active:yes" />
    <input type="submit" name="act" value="Active:no" />
</form>

</body>