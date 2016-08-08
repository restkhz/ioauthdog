<?php
require_once('../antisql.php');


if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['repassword']) && isset($_POST['qq']) &&isset($_POST['name'])){  //读变量
	$username 	= 	$_POST['username'];
    $password 	= 	$_POST['password'];
    $repassword = 	$_POST['repassword'];
    $qq			=	$_POST['qq'];
    $name		=	$_POST['name'];


    if($password != $repassword){                                           //检查密码一样
    	echo("<script>alert(\"两次密码输入不一样，请检查\")</script>");
    	echo "<script language=JavaScript>history.go(-1)</script>";
    	exit;
	}	//检查密码是否一样


	if(inject_check($username) or inject_check($password) or inject_check($qq) or inject_check($name) ){die('Oh! No!提交数据有攻击性！');}//安全检查

	
    $config=include('../config.php');   
    $db = new mysqli($config['host'],$config['dbuser'], $config['dbpwd'], $config['dbname']);//连接数据库
    if(mysqli_connect_errno()){
        
        echo mysqli_connect_error();
        die;
    }


    $db->query("set names 'utf8'");//进入查询
    $result = $db->query("SELECT username FROM user WHERE username='{$username}'");


    if($result && $result->num_rows != 0){                  //重复用户名
    	 echo "<script>alert('看来账户已经被注册了，换一个账户名吧'); history.go(-1);</script>";
         $db -> close();
    	 exit; 
    } else {

		$insert_r = $db->query("insert into user(username,password,qq,name)values('{$username}','{$password}','{$qq}','{$name}')");       //成功

    		if ($insert_r) {
    			echo "<script>alert('注册成功了，请耐心等待管理员加你QQ'); history.go(-1);</script>";
                $db -> close();  

    		} else {
    			echo "<script>alert('好尴尬，我们的数据库执行出错了，快点告诉管理员!!!'); history.go(-1);</script>"; 
                $db -> close();;

    		}
    	


    }




}
	