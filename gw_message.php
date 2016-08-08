<?php
    $message = null;
    if(isset($_GET["message"])){
        $message = $_GET["message"];
    }
    echo '从路由节点返回错误信息：'.$message;
?>