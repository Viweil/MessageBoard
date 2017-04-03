<?php
	if(isset($_POST["submit"]) && $_POST["submit"] == "login")
	{
		$user = $_POST["username"];
		$psw = $_POST["password"];
		if($user == "" || $psw == "")
		{
			echo "<script>alert("Please input username or password."); history.go(-1);</script>"
		}else{
			mysql_connect("localhost","root","");
			mysql_select_db("db_message");
			$sql = "select Username, Userpwd from tb_user where Username = '$_POST[username]' and Userpwd = '$_POST[password]'";
			$result = mysql_query($sql);
			$num = mysql_num_rows($result);
			if($num)
			{
				$row = mysql_fetch_array($result);  
				echo $row[0];
			}
			else{
				echo "<script>alert('invalid username or password'); history.go(-1);</script>";
			}
		}	
		
	}else{
		echo "<script>alert('unsucessful');history.go(-1);</script>";
	}
	

?>