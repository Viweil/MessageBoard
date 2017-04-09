//Check Admin login------------------------------
function CheckAdminLogin()
{
	var check;
	if (!voidNum(document.AdminLogin.VefiryCode.value))
		{
			alert("Please type correct code");
			document.AdminLogin.VerifyCode.focus();
			return false;
			exit;
		}
	return true;
}