<?php
	if(isset($_POST["Submit"]) && $_POST['Submit'] == "Register")
	{
		$user = $_POST["username"];
		$psw = $_POST["password"];
		$psw_confirm = $_POST["confirm"];
		if($user == "" || $psw == "" || $psw_confirm == "")
		{
			echo "<script>alert('Please complete the form');history.go(-1);</script>";
		}
		else{
			if($psw == $psw_confirm)
			{
				mysql_connect("localhost","root","");
				mysql_select_db("db_message");
				$sql = "select Username from tb_user where Username = '$_POST[username]'";
				$result = mysql_query($sql);
				$num = mysql_num_rows($result);
				if($num)
				{
					echo "<script>alert('username has been already exist'); history.go(-1);</script>";
				}
				else{
					$sql_insert = "insert into tb_user(Username,Userpwd,Firstname,Lastname,Phone,Email) values('$_POST[username]','$_POST[password]','$_POST[firstname]','$_POST[lastname]','$_POST[phone]','$_POST[email]')";
					$res_insert = mysql_query($sql_insert);
					if($res_insert)
					{
						echo "<script>alert('Congrads, Register Successfully'); window.location.href='login.php';</script>";
						/* $url="login.php";
						Header("Location:$url"); */
					}
					else  
                    {  
                        echo "<script>alert('Unsuccessful, please try again.'); history.go(-1);</script>";  
                    }  
				}
			}
			else{
				echo "<script>alert('Password does not match the confirm password'); history.go(-1);</script>";  
			}
		}
	}else  
    {  
        echo "<script>alert('Fail to submit'); history.go(-1);</script>";  
    }

?>












