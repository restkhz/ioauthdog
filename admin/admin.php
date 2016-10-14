<?php
//It's impossiable to inject again cause I use PDO.
$config=include('../config.php');
$dbh = new PDO("mysql:host=" . $config['host'] . ";dbname=" . $config['dbname'] , $config['dbuser'], $config['dbpwd']); //初始化一个PDO对象
$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
session_start();

if(!isset($_SESSION['is_admin']) && $_SESSION['is_admin'] != 1 ){	//无登陆禁止访问
	header('Location:index.php');
	exit;
}
if (isset($_POST['username']) && isset($_POST['act'])){
	$username = $_POST['username'];
	$isactive = $_POST['act'];//"$dbms:host=$host;dbname=$dbName";
	try {
		
		if($isactive == "Active:yes"){
			$time = (string)date("Y-m-d H:i:s");
			$stmt = $dbh->prepare("UPDATE user SET active=1 , activetime=:time WHERE username=:username");
			$stmt->bindParam(':time', $time, PDO::PARAM_STR);
			$stmt->bindParam(':username', $username, PDO::PARAM_STR);
			$stmt->execute();
		}else if($isactive == "Active:no"){
			$stmt = $dbh->prepare("UPDATE user SET active=0 WHERE username=:username");
			$stmt->bindParam(':username', $username, PDO::PARAM_STR);
			$stmt->execute();
		}
	} catch (PDOException $e) {
		die ("Error!: " . $e->getMessage() . "<br/>");
	}
}

?>

<!doctype html>
<html>
<head>
	<meta http-equiv="content-type"content="text/html charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="http://cdn.bootcss.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
	<script src="http://cdn.bootcss.com/jquery/1.8.3/jquery.min.js"></script>
	<script src="http://cdn.bootcss.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
	<style>
		th, td {
			width: 100px;
			text-align: center;
		}
	</style>
</head>
<title>后台 - ioauthdog</title>
<body style="position: relative;">
	
<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="#">Administration</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li><a href="#">User</a></li>
	      <li><a href="#">Nodes</a></li>
              <li><a href="#">About</a></li>
            </ul>
          </div>
        </div>
      </div>
</div>
	

<div class="panel panel-default" style="position: absolute;left: 20px;right: 20px;top: 20px;">
    <div class="panel-body">
	欢迎进入后台！
<?php

echo '<h1 align=\'center\'><font>用户管理</font></h1>';

$dbh->query("set names 'utf8'");

echo '<table class="table table-bordered">';
echo '<tr><th>Username</th><th>p4ssw0rd</th><th>Active</th><th>QQ</th><th>Name</th><th>ActiveTime</th><th>Opreate</th></tr>';
$sql="SELECT * FROM user";
foreach ($dbh->query($sql) as $row) {
	echo"<tr><td>". $row['username'] . "</td><td>" . $row['password'] . "</td><td>" . $row['active'] . "</td><td>" . $row['qq'] . "</td><td>" . $row['name'] . "</td><td>" . $row['activetime'] . "</td><td>";
?>
<form method="post" action="admin.php">
	<input type="hidden" name="username" value="<?php echo $row['username'] ?>" />
	<input type="hidden" name="act" value="<?php echo ($row['active'] == 0) ? "Active:yes" : "Active:no"; ?>" />
	<input type="submit" class="btn btn-primary" value="<?php echo ($row['active'] == 0) ? "Active" : "Deactive"; ?>" />
</form>
<?php
	echo "</td></tr>";
}
echo "</table>";

$dbh = null;

?>
    </div>
</div>
</body>
