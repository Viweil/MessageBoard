<?php
$conn=mysql_connect("localhost","root","")or die("fail:".mysql_error());  
mysql_select_db("db_message",$conn);

if($conn){
	echo "successful!";
}
?>