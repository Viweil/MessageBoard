
<?php
require_once("../Include/Const.php");
require_once("../Include/ConnSiteData.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>backend systems</title>
</head>

<body>

<?php

$Name = GetFromPost("Name");

$Password = md5(GetFromPost("Password"));


$sql = "select * from tb_admin where Name='".$Name."'";

$res=mysql_query($sql);

$rowsfound = mysql_num_rows($res);
$res=mysql_query($sql);
$r=mysql_fetch_assoc($res);
if($rowsfound <= 0){
   echo "<script language=javascript> alert('管理员名称不正确，请重新输入。');location.replace('AdminLogin.php');</script>";
   exit;
}else{
   $Name=$r["Name"];
   $Password= $r["Password"];
   $Status= $r["Status"];
}
if($Password  != $Password){
   echo "<script language=javascript> alert('管理员密码不正确，请重新输入。');location.replace('AdminLogin.php');</script>"; 
   exit;
}

if($_SESSION["VerifyCode"] != $_POST["VerifyCode"]){
	echo "<script language=javascript> alert('您输入验证码错误，请返回重新登录！');location.replace('AdminLogin.php');</script>";
   exit;
}

if(! $Status){
   echo "<script language=javascript> alert('不能登录，此管理员帐号已被锁定。');location.replace('AdminLogin.php');</script>";
   exit;
} 

if($Name == $Name && $Password == $Password){
   $sql="update tb_admin set LastLoginTime='".date('y-m-d h:i:s',time())."',LastLoginIP='".$_SERVER["Remote_Addr"]."' where Name='".Name."'";
   mysql_query($sql);	
   
   $_SESSION["Name"] = $Name;
   $_SESSION["LoginSystem"] = "Succeed";

   //========================================    
   echo "<script language=javascript>this.location.href='index.html';</script>";
   exit;
}
?>
</body>
</html>