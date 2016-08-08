<?php
session_start();

#require_once(antisql.php);
include('login');

if(@$_SESSION["is_admin"]==1){
	header("Location:admin.php");
}
if(isset($_POST['username']) && isset($_POST['password'])){
    if($_POST['username']=='admin'){									//用户名密码
    	if($_POST['password']=='iOwifipwd'){
    		$_SESSION["is_admin"]=1;
    		echo '<script>alert('Login success')</script>';
    		header("refresh:1;admin.php");
    		
    	}
   }

}