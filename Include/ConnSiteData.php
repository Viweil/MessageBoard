<?php
error_reporting("E_ALL"); //只显示错误和警告，不显示 注意的错误 //| E_WARNING 
//ini_set('display_errors', '1');  
date_default_timezone_set('PRC');//设置时区
define("web","");
$web="/";
$host="localhost";
$user="root";
$password="";
$dataname="db_message";
$con = mysql_connect($host,$user,$password);

if(!$con){
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />";
	echo "系统错误：数据库连接出错，请检查'系统管理>>站点常量设置',或者/Include/ConnSiteData.php文件!<br>";
   die('数据库连接报错: ' . mysql_error());
}else{
   mysql_select_db($dataname,$con);
   mysql_query("SET NAMES 'utf8'"); 
}

$mysqli = mysqli_connect($host,$user,$password,$dataname);
$mysqli->set_charset("utf8");
define('ROOT_PATH',str_replace('\\','/',realpath(dirname(__FILE__).'/../'))."/");//realpath(dirname(__FILE__).'/../'))最后一个参数就是本文件相对根目录的位置,关键
?>
<?php require_once("Function.php");?>