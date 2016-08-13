<?php
echo '管理员貌似忘了删了这个了诶？不过也没关系的啦。。';
//您好，这里是一个使用说明文档
//本程序目前属于I/O.NET内部调试阶段，不过代码已经开源。
//
//安装要解压到web目录下，然后设置config.php，做连接数据库的配置即可。
//因为本人水平实在太有限了(chinese senior high)所以只能做的很简单。而且没有自动安装页面。
//管理界面不太复杂，或者说功能太少了。只能激活账户和禁用账户。
//管理密码为了安全就没丢在数据库里，直接在php里你可以看见。
//为了找回密码方便所以我用了不安全的明文提交方式并且数据库中密码可见。
//下一个版本我可能会用别的方法前端加js两次base64再md5.找回密码功能我自己设计一下。可能只能修改而不是单纯找回了。
//
// 数据库结构 表:user
//字段 id username password token logintime active qq name activetime
//    id    用户名  密码    令牌    登陆时间  是否激活  qq  名字  激活的时间
//
//可以导入sql_struct.php中的sql语句，快速建立数据库，记得去掉它第一行
//
//目录:
//root 						根
//|
//│  antisql.php 			sql注入过滤
//│  config.php 			数据库配置文件									<---安装时修改
//│  gw_message.php 		获得路由器错误信息文件
//│  index.html 			index文件，防止路径暴露
//│  readme.php 			你在看的,写成php防止有人忘了删然后reamne被别人看
//│  
//│  
//├─admin	 				后台部分
//│  │  admin.php 			管理平台
//│  │  index.php 			index登录调用及验证								<---管理员密码
//│  │  login 				认证视图
//│  │  
//│  ├─css 					视图的css
//│  │      style.css 	
//│  │      
//│  ├─img 					图片总要有
//│  │      arrow.png
//│  │      bg.png
//│  │      
//│  └─scss 				样式,css
//│          style.scss
//│          
//├─auth					wifidog心跳验证		
//│      index.php 			心跳验证，根据token
//│      
//├─login					用户登录
//│  │  help.html 			用户帮助
//│  │  index.php 			用户登录界面和验证程序
//│  │  login 				这个只是视图
//│  │  reg.html 			注册视图
//│  │  reg.php 			注册处理程序
//│  │  
//│  ├─css 					样式，没啥好说的
//│  │      style.css
//│  │      
//│  ├─img
//│  │      arrow.png
//│  │      bg.png
//│  │      
//│  └─scss
//│          style.scss
//│          
//├─ping					路由器pingpong确认，告诉路由器服务器还活着，验证可用
//│      index.php
//│      
//└─portal					登陆后传送
//        index.php
//
//
//整个程序目前还是在测试阶段，目前安全性还是注意到了一些的。所以考虑对外网发布，SQL注入过滤是否足够严格我也不知道。
//以后会跟进开发新的功能，有漏洞也请联系我。谢谢！
//QQ:384673976 			www.littlerest.tk 休止千鹤
//最后，感谢我引用过的代码和折腾中参考过的资料，谢谢各位！
