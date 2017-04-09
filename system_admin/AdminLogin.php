<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Backend System</title>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/Admin.js"></script>

</head>

<body class="nobg loginPage">

<!-- Main content wrapper -->
<div class="loginWrapper">
    <div class="loginLogo"><img src="images/loginLogo.png" alt="" /></div>
    <div class="widget">
        <div class="title"><img src="images/icons/dark/files.png" alt="" class="titleIcon" /><h6>Admin Login</h6></div>
        <form action="CheckLogin.php" class="form"  method="post" name="AdminLogin" id="AdminLogin" onsubmit="return CheckAdminLogin()">
            <fieldset>
                <div class="formRow">
                    <label for="login">Username:</label>
                    <div class="loginInput"><input type="text" name="Name" id="Name" /></div>
                    <div class="clear"></div>
                </div>
                
                <div class="formRow">
                    <label for="pass">Password:</label>
                    <div class="loginInput"><input type="password" name="Password" id="Password" /></div>
                    <div class="clear"></div>
                </div>
                
           		<div class="loginControl">
                    <label for="code">Code:</label><img src="../Include/VerifyCode.php"/>
                    <div class="loginInput"><input type="text" name="VerifyCode" id="5F1147E8746A5084FA" /></div>
                    <div class="clear"></div>
                </div>
                
                <div class="loginControl">
                    <input type="submit" name="submitLogin" value="Login" class="dredB logMeIn" />
                    <div class="clear"></div>
                </div>
            </fieldset>
        </form>
    </div>
</div>    


</body>
</html>