<?php
    require_once('../antisql.php');



//获取参数
parse_str($_SERVER['QUERY_STRING'], $parseUrl);
//gw_address、gw_port、gw_id是必需参数，缺少不能认证成功.所以过滤
if( !array_key_exists('gw_address', $parseUrl) || !array_key_exists('gw_port', $parseUrl) || !array_key_exists('gw_id', $parseUrl)){
    echo "大哥，你是怎么找到这个页面的？";
    exit;
}

//如果提交了账号密码
if(isset($_POST['username']) && isset($_POST['password'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

   if(inject_check($username) or inject_check($password)){die('Oh! No!请求有攻击性！');}//安全检查


    $config=include('../config.php');   
    $db = new mysqli($config['host'],$config['dbuser'], $config['dbpwd'], $config['dbname']);//连接数据库
    if(mysqli_connect_errno()){
        echo mysqli_connect_error();
        die;
    }

    $db->query("set names 'utf8'");//进入查询
    $result = $db->query("SELECT * FROM user WHERE username='{$username}' AND password='{$password}'");

    if($result && $result->num_rows != 0){

        while($row=$result->fetch_object()){
            $active=$row->active;               //读取激活
        }

    if ($active==0) {                            //没有被激活的话就免谈
        echo ("<script>alert(\"该账户存在但是未被激活，请联系后台管理\")</script>");
        echo "<script language=JavaScript> location.replace(location.href);</script>";
        exit;
    }

        //数据库验证成功
        
        $token = '';
        $pattern="1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ";     //分配token
        for($i=0;$i<32;$i++)
            $token .= $pattern[ rand(0,35) ];
        //把token放到数据库，用于后续验证（auth/index.php）
        $time = time();
        $sql = "UPDATE user SET token='{$token}',logintime='{$time}' WHERE username='{$username}'";
        $db->query($sql);
        $db->close();
        //登陆成功，跳转到路由网管指定的页面.
        $url = "http://{$parseUrl['gw_address']}:{$parseUrl['gw_port']}/wifidog/auth?token={$token}";
        header("Location: ".$url);
    }else{
        //认证失败
        //直接重定向本页 请求变成get
        $url='http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
        header("Location: ".$url);
    }
}else{
    //get请求
    //视图部分
   
    include('login');
}
