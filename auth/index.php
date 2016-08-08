<?php
//获取url传递过来的参数
require_once("../antisql.php");

parse_str($_SERVER['QUERY_STRING'], $parseUrl);
//需要多少参数用户可自己看
if( !array_key_exists('token', $parseUrl) ){
    //没有token拒绝
    echo "Auth: 0";
    exit;
}

    $config=include('../config.php');   
    $db = new mysqli($config['host'],$config['dbuser'], $config['dbpwd'], $config['dbname']);//连接数据库
$db->query("set names 'utf8'");
$token = $parseUrl['token'];
   if(inject_check($token)){die('Oh! No!');}
$sql = "SELECT * FROM user WHERE token='{$token}'";
$result = $db->query($sql);


while($row=$result->fetch_object()){
	$lastlogin=$row->logintime;
	$time=time()-$lastlogin;
}



if($result && $result->num_rows != 0 && $time < 21600){
    //token匹配，验证通过,注意token的生存周期就在这里。21600，6小时。

    echo "Auth: 1";
    $db->close();
}else{
    echo "Auth: 0";
    $db->close();
    
}
