<?php
function dbBitToBool($dbbit){
	$tem=ord($dbbit);
	if($tem==48){
		return false;
	}
	if($tem==49){
		return true;
	}
	return (bool)$tem;
}
//暂无图片处理
function imgNoExistSolve($image,$replaceImg){
	if(trim($image) ==''){
		return $replaceImg;
	}else{
		if(!file_exists($image)){
			return $replaceImg;
		}else{
			return $image;
		}
	}
}

//读取
function query($sql){
	$q=mysql_query($sql) or die("error".mysql_error());
	return $q;
}
//删除 更新
function execute($sql){
	$q=mysql_query($sql) or die("error".mysql_error());
}
//返回列表
function fetch($result){
	$f=mysql_fetch_array($result);
	return $f;
}
//判断是否有记录
function isrecord($res){
	$n = mysql_num_rows($res);
	if($n>0){
		return true;
	}else{
		return false;
	}
}
//返回一条记录true,false
function tf($sql){
	$q=mysql_query($sql) or die("error".mysql_error());
	$n=mysql_num_rows($q);
	if($n>0){
		return true;
	}else{
		return false;
	}
}
//信息判断，返回上一页。
//$msg 信息显示

function gotos($msg){
	echo "<script language=javascript>alert('$msg');</script>";
	echo "<script language=javascript>history.go(-1);</script>";
	exit;
}
//信息判断，返回指定页
//$msg 信息显示
//url  跳转地址
function gotourl($msg,$url){
	echo "<script language=javascript>alert('$msg');</script>";
	echo "<script language=javascript>this.location.href='$url';</script>";
}
function gourl($url){
	echo "<script language=javascript>this.location.href='$url';</script>";
	exit;
}
/*
 *截取字符串，参数说明：字符串，截取长度，是否带省略号(...)
 */
function g_substr($str, $len = 12, $dot = true) {
	$i = 0; //$i起始截取位置，默认为0，中文utf-8，每次增加3，gbk,每次增加2 英文每次增加1
	$l = 0; //$l的值随着截取自增加  中文增加2 英文增加1，这样就成了1个中文对2个英文的截取模式
	$c = 0; //$c的值截取增加  中文utf-8增加3，gbk增加2 英文增加1
	$a = array();
	while ($l < $len) {          //$l<$len就继续
		$t = substr($str, $i, 1);   //截取字符串 判断$t的ascii ord()转换为ascii编码
		if (ord($t) >= 224) {        //大于224 中文utf-8 一个汉字3个占字符
			$c = 3;
			$t = substr($str, $i, $c);  //截取时，从起始位置往后截取3个字符
			$l += 2;
		} elseif (ord($t) >= 192) {  //大于192 中文gbk 一个汉字2个占字符
			$c = 2;
			$t = substr($str, $i, $c);  //截取时，从起始位置往后截取2个字符
			$l += 2;
		} else {
			$c = 1;
			$l++;
		}
		// $t = substr($str, $i, $c);
		$i += $c;           //起始位置变更，中文utf-8 增3，中文gbk 增2 英文 增1
		if ($l > $len) break;
		$a[] = $t;          //赋值给数组
	}
	$re = implode('', $a);      //转化为字符串
	if (substr($str, $i, 1) !== false) {    //判断$len长度后是否还有字符
		array_pop($a);          //删除数组的最后一位 适用于中文utf-8和gbk
		($c == 1) and array_pop($a);    //判断是否为英文 是英文的话在删除最后一位
		$re = implode('', $a);      //转换为字符串
		$dot and $re .= '...';
	}
	return $re;
}

//中文字符串截取
//用法 cutout(变量，长度)
//$Append是否添加。。。
function cutout($String,$Length,$Append = false){
	if (strlen($String)<=$Length){
		return $String;
	}
	else{
		$I = 0;
		while ($I < $Length) {
			$StringTMP = substr($String,$I,1);
			if ( ord($StringTMP) >=224 ) {
				$StringTMP = substr($String,$I,3);
				$I = $I + 3;
			}
			elseif( ord($StringTMP) >=192 ) {
				$StringTMP = substr($String,$I,2);
				$I = $I + 2;
			}
			else {
				$I = $I + 1;
			}
			$StringLast[] = $StringTMP;
		}
		$StringLast = implode("",$StringLast);
		if($Append) {
			$StringLast .= "...";
		}
		return $StringLast;
	}
}
//获取IP地址
function getip(){
	if(!empty($_SERVER["HTTP_CLIENT_IP"]))
		$cip = $_SERVER["HTTP_CLIENT_IP"];
		else if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
			$cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
			else if(!empty($_SERVER["REMOTE_ADDR"]))
				$cip = $_SERVER["REMOTE_ADDR"];
				else
					$cip = "无法获取！";
					return $cip;
}
//过滤函数，SQL数据过滤特殊字符
function sqlfilter(){
}
//非法字符限制
function limit($str){
}
//加水印函数
function imageWaterMark($groundImage,$waterPos=0,$waterImage="",$waterText="",$fontSize=12,$textColor="#CCCCCC", $fontfile='./arial.ttf',$xOffset=0,$yOffset=0)
{
	$isWaterImage = FALSE;
	//读取[du qu]水印文件[wen jian]
	if(!emptyempty($waterImage) && file_exists($waterImage)) {
		$isWaterImage = TRUE;
		$water_info = getImagesize($waterImage);
		$water_w     = $water_info[0];//取得水印图片的宽
		$water_h     = $water_info[1];//取得水印图片的高
		
		switch($water_info[2])   {    //取得水印图片的格式
			case 1:$water_im = imagecreatefromgif($waterImage);break;
			case 2:$water_im = imagecreatefromjpeg($waterImage);break;
			case 3:$water_im = imagecreatefrompng($waterImage);break;
			default:return 1;
		}
	}
	
	//读取[du qu]背景图片
	if(!emptyempty($groundImage) && file_exists($groundImage)) {
		$ground_info = getImagesize($groundImage);
		$ground_w     = $ground_info[0];//取得背景图片的宽
		$ground_h     = $ground_info[1];//取得背景图片的高
		
		switch($ground_info[2]) {    //取得背景图片的格式
			case 1:$ground_im = imagecreatefromgif($groundImage);break;
			case 2:$ground_im = imagecreatefromjpeg($groundImage);break;
			case 3:$ground_im = imagecreatefrompng($groundImage);break;
			default:return 1;
		}
	} else {
		return 2;
	}
	
	//水印位置[wei zhi]
	if($isWaterImage) { //图片水印
		$w = $water_w;
		$h = $water_h;
		$label = "图片的";
	} else {
		//文字[wen zi]水印
		if(!file_exists($fontfile))return 4;
		$temp = imagettfbbox($fontSize,0,$fontfile,$waterText);//取得使用 TrueType 字体[zi ti]的文本[wen ben]的范围[fan wei]
		$w = $temp[2] - $temp[6];
		$h = $temp[3] - $temp[7];
		unset($temp);
	}
	if( ($ground_w < $w) || ($ground_h < $h) ) {
		return 3;
	}
	switch($waterPos) {
		case 0://随机
			$posX = rand(0,($ground_w - $w));
			$posY = rand(0,($ground_h - $h));
			break;
		case 1://1为顶端居左
			$posX = 0;
			$posY = 0;
			break;
		case 2://2为顶端居中
			$posX = ($ground_w - $w) / 2;
			$posY = 0;
			break;
		case 3://3为顶端居右
			$posX = $ground_w - $w;
			$posY = 0;
			break;
		case 4://4为中部居左
			$posX = 0;
			$posY = ($ground_h - $h) / 2;
			break;
		case 5://5为中部居中
			$posX = ($ground_w - $w) / 2;
			$posY = ($ground_h - $h) / 2;
			break;
		case 6://6为中部居右
			$posX = $ground_w - $w;
			$posY = ($ground_h - $h) / 2;
			break;
		case 7://7为底端居左
			$posX = 0;
			$posY = $ground_h - $h;
			break;
		case 8://8为底端居中
			$posX = ($ground_w - $w) / 2;
			$posY = $ground_h - $h;
			break;
		case 9://9为底端居右
			$posX = $ground_w - $w;
			$posY = $ground_h - $h;
			break;
		default://随机
			$posX = rand(0,($ground_w - $w));
			$posY = rand(0,($ground_h - $h));
			break;
	}
	
	//设定图像[tu xiang]的混色模式[mo shi]
	imagealphablending($ground_im, true);
	
	if($isWaterImage) { //图片水印
		imagecopy($ground_im, $water_im, $posX + $xOffset, $posY + $yOffset, 0, 0, $water_w,$water_h);//拷贝[kao bei]水印到目标[mu biao]文件[wen jian]
	} else {//文字[wen zi]水印
		if( !emptyempty($textColor) && (strlen($textColor)==7) ) {
			$R = hexdec(substr($textColor,1,2));
			$G = hexdec(substr($textColor,3,2));
			$B = hexdec(substr($textColor,5));
		} else {
			return 5;
		}
		imagettftext ( $ground_im, $fontSize, 0, $posX + $xOffset, $posY + $h + $yOffset, imagecolorallocate($ground_im, $R, $G, $B), $fontfile, $waterText);
	}
	
	//生成水印后的图片
	@unlink($groundImage);
	switch($ground_info[2]) {//取得背景图片的格式
		case 1:imagegif($ground_im,$groundImage);break;
		case 2:imagejpeg($ground_im,$groundImage);break;
		case 3:imagepng($ground_im,$groundImage);break;
		default: return 6;
	}
	
	//释放[shi fang]内存[nei cun]
	if(isset($water_info)) unset($water_info);
	if(isset($water_im)) imagedestroy($water_im);
	unset($ground_info);
	imagedestroy($ground_im);
	//
	return 0;
}
//根据请求来获得文件名
function filenamebyrequest(){
	$dir_file = $_SERVER['SCRIPT_NAME'];
	$filename = basename($dir_file);
	return $filename;
}
#==================================
//使用 Get 的方式取得一个值
//$parameter_name是参数名
//$default_value是默认值，即未定义该参数时则使用该值，可为空
#==================================
function GetFromGet($parameter_name, $default_value="", $data_type=""){
	$result = (isset($_GET[$parameter_name]) ? Strip($_GET[$parameter_name]) : $default_value);
	return CheckDataType($result, $default_value, $data_type);
}
#==================================
//使用 Post 的方式取得一个值
//$parameter_name是参数名
//$default_value是默认值，即未定义该参数时则使用该值，可为空
#==================================
function GetFromPost($parameter_name, $default_value = "", $data_type=""){
	$result = (isset($_POST[$parameter_name]) ? Strip($_POST[$parameter_name]) : $default_value);
	return CheckDataType($result, $default_value, $data_type);
}
#==================================
//检查字符串的合法性
#==================================
function Strip($value){
	//if(get_magic_quotes_gpc() != 0){
	if(is_array($value)){
		foreach($value as $key=>$val){$value[$key] = stripslashes($val);}
	}else{
		$value = stripslashes($value);
	}
	//}
	return $value;
}
#==================================
//检查数据类型的合法性
#==================================
function CheckDataType($value, $default_value='', $data_type='text'){
	$result=$value;
	if($data_type=='number'){
		if(!is_numeric($result))$result=$default_value;
	}elseif($data_type=='date'){
		if(!IsDate($result))$result=$default_value;
	}elseif($data_type=='time'){
		if(!IsTime($result))$result=$default_value;
	}else{
		$result=str_replace("'","",$result);
	}
	return $result;
}
#==================================
#判断是否日期
#返回 true 则是日期，返回 false 则不是日期
#==================================
function IsDate($date) {
	$dateArr = explode("-", $date);
	if (is_numeric($dateArr[0]) && is_numeric($dateArr[1]) && is_numeric($dateArr[2])) {
		return checkdate($dateArr[1],$dateArr[2],$dateArr[0]);
	}
	return false;
}
#==================================
#判断是否时间
#返回 true 则是时间，返回 false 则不是时间
#==================================
function IsTime($time) {
	$timeArr = explode(":", $time);
	if (is_numeric($timeArr[0]) && is_numeric($timeArr[1]) && is_numeric($timeArr[2])) {
		if (($timeArr[0] >= 0 && $timeArr[0] <= 23) && ($timeArr[1] >= 0 && $timeArr[1] <= 59) && ($timeArr[2] >= 0 && $timeArr[2] <= 59))
			return true;
			else
				return false;
	}
	return false;
}

//判断是否由字母 数字 下划线组成
function u($str){
	if(ereg("^[0-9a-zA-Z\_]*$",$str))
		return true;
		else
			return false;
}
#==================================
#计算两个日期之间的间隔数目
#返回整数
#$interval: s:秒; i:分; h:时; d:天;
#==================================
function DateDiff($interval, $datefrom, $dateto, $using_timestamps = false) {
	
	/*
	 $interval can be:
	 yyyy - Number of full years
	 q - Number of full quarters
	 m - Number of full months
	 y - Difference between day numbers
	 (eg 1st Jan 2004 is "1", the first day. 2nd Feb 2003 is "33". The datediff is "-32".)
	 d - Number of full days
	 w - Number of full weekdays
	 ww - Number of full weeks
	 h - Number of full hours
	 n - Number of full minutes
	 s - Number of full seconds (default)
	 */
	
	if (!$using_timestamps) {
		$datefrom = strtotime($datefrom, 0);
		$dateto = strtotime($dateto, 0);
	}
	$difference = $dateto - $datefrom; // Difference in seconds
	
	switch($interval) {
		
		case 'yyyy': // Number of full years
			
			$years_difference = floor($difference / 31536000);
			if (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom), date("j", $datefrom), date("Y", $datefrom)+$years_difference) > $dateto) {
				$years_difference--;
			}
			if (mktime(date("H", $dateto), date("i", $dateto), date("s", $dateto), date("n", $dateto), date("j", $dateto), date("Y", $dateto)-($years_difference+1)) > $datefrom) {
				$years_difference++;
			}
			$datediff = $years_difference;
			break;
			
		case "q": // Number of full quarters
			
			$quarters_difference = floor($difference / 8035200);
			while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($quarters_difference*3), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
				$months_difference++;
			}
			$quarters_difference--;
			$datediff = $quarters_difference;
			break;
			
		case "m": // Number of full months
			
			$months_difference = floor($difference / 2678400);
			while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
				$months_difference++;
			}
			$months_difference--;
			$datediff = $months_difference;
			break;
			
		case 'y': // Difference between day numbers
			
			$datediff = date("z", $dateto) - date("z", $datefrom);
			break;
			
		case "d": // Number of full days
			
			$datediff = floor($difference / 86400);
			break;
			
		case "w": // Number of full weekdays
			
			$days_difference = floor($difference / 86400);
			$weeks_difference = floor($days_difference / 7); // Complete weeks
			$first_day = date("w", $datefrom);
			$days_remainder = floor($days_difference % 7);
			$odd_days = $first_day + $days_remainder; // Do we have a Saturday or Sunday in the remainder?
			if ($odd_days > 7) { // Sunday
				$days_remainder--;
			}
			if ($odd_days > 6) { // Saturday
				$days_remainder--;
			}
			$datediff = ($weeks_difference * 5) + $days_remainder;
			break;
			
		case "ww": // Number of full weeks
			
			$datediff = floor($difference / 604800);
			break;
			
		case "h": // Number of full hours
			
			$datediff = floor($difference / 3600);
			break;
			
		case "n": // Number of full minutes
			
			$datediff = floor($difference / 60);
			break;
			
		default: // Number of full seconds (default)
			
			$datediff = $difference;
			break;
	}
	
	return $datediff;
	
}

//导航栏目函数
function nav($parent_id){
	$sql="select * from categories where parent_id=1 and categories_type=2 order by categories_id asc";
	$res=mysql_query($sql);
	while($r=mysql_fetch_array($res)){
		echo "<a href='".$r['categories_url']."' style='font-size:14px; font-weight:bloder'>".$r['categories_name']."&nbsp;&nbsp;|</a>";
	}
}
//首页左侧子目录函数
function left_categries($parent_id){
	$sql="select * from categories where categories_type=3 and parent_id=".$parent_id." order by categories_order desc,categories_id  asc limit 0,22";
	$res=mysql_query($sql);
	while($r=mysql_fetch_array($res)){
		echo "<li><a href='sjml.php' target=_blank>".$r['categories_name']."</a></li>";
	}
}
?>
<?php
function nohtml($str){ 		
	return RemoveHTML($str); 	
} 

function RemoveHTML($str){     
  //return strip_tags($str);
    $str = trim($str); //清除字符串两边的空格
    $str = strip_tags($str); //利用php自带的函数清除html格式。保留P标签
	$str = str_replace("&nbsp;","",$str); 
    $str = preg_replace("/\t/","",$str); //使用正则表达式匹配需要替换的内容，如：空格，换行，并将替换为空。
    $str = preg_replace("/\r\n/","",$str);
    $str = preg_replace("/\r/","",$str);
    $str = preg_replace("/\n/","",$str);
    $str = preg_replace("/ /","",$str);
    $str = preg_replace("/  /","",$str);  //匹配html中的空格	
    return trim($str); //返回字符串
}

//解决中文使用substr乱码问题
function getstr($string, $length, $encoding  = 'utf-8') {
 	    $string = trim($string);
 	  
 	    if($length && strlen($string) > $length) {
 	        //截断字符
 	        $wordscut = '';
 	        if(strtolower($encoding) == 'utf-8') {
 	            //utf8编码
 	            $n = 0;
 	            $tn = 0;
 	            $noc = 0;
 	            while ($n < strlen($string)) {
 	                $t = ord($string[$n]);
 	                if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
 	                    $tn = 1;
 	                    $n++;
	                    $noc++;
 	                } elseif(194 <= $t && $t <= 223) {
 	                    $tn = 2;
 	                    $n += 2;
 	                    $noc += 2;
 	                } elseif(224 <= $t && $t < 239) {
 	                    $tn = 3;
 	                    $n += 3;
 	                    $noc += 2;
 	                } elseif(240 <= $t && $t <= 247) {
 	                    $tn = 4;
 	                    $n += 4;
 	                    $noc += 2;
 	                } elseif(248 <= $t && $t <= 251) {
 	                    $tn = 5;
 	                    $n += 5;
 	                    $noc += 2;
 	                } elseif($t == 252 || $t == 253) {
 	                    $tn = 6;
 	                    $n += 6;
 	                    $noc += 2;
 	                } else {
 	                    $n++;
 	                }
 	                if ($noc >= $length) {
 	                    break;
 	                }
 	            }
 	            if ($noc > $length) {
 	                $n -= $tn;
 	            }
	            $wordscut = substr($string, 0, $n);
	        } else {
	            for($i = 0; $i < $length - 1; $i++) {
	                if(ord($string[$i]) > 127) {
	                    $wordscut .= $string[$i].$string[$i + 1];
	                    $i++;
	                } else {
                    $wordscut .= $string[$i];
                }
            }
        }
        $string = $wordscut;
    }
    return trim($string);
}

//function StrLen($str){
//	return $str; //找个，可以区分中英文的
//}

function StrLeft($str,$strLen){
	return $str;
}
function StrReplace($Str){//表单存入替换字符  
    $Str=str_replace(" ","&nbsp;",$Str); //"&nbsp;"
    $Str=str_replace(chr(13),"&lt;br&gt;",$Str);//"<br>"
    $Str=str_replace("<","&lt;",$Str);// "&lt;"
    $Str=str_replace(">","&gt;",$Str);// "&gt;"
	$Str = str_replace("'","",$Str);	
  return $Str;
}
//
//function ReStrReplace(Str)'写入表单替换字符
//  if Str="" or isnull(Str) then 
//    ReStrReplace=""
//    exit function 
//  else
//    ReStrReplace=replace(Str,"&nbsp;"," ") '"&nbsp;"
//    ReStrReplace=replace(ReStrReplace,"<br>",chr(13))'"<br>"
//    ReStrReplace=replace(ReStrReplace,"&lt;br&gt;",chr(13))'"<br>"
//    ReStrReplace=replace(ReStrReplace,"&lt;","<")' "&lt;"
//    ReStrReplace=replace(ReStrReplace,"&gt;",">")' "&gt;"
//  end if
//}
//
//function HtmlStrReplace(Str)'写入Html网页替换字符
//  if Str="" or isnull(Str) then 
//    HtmlStrReplace=""
//    exit function 
//  else
//    HtmlStrReplace=replace(Str,"&lt;br&gt;","<br>")'"<br>"
//  end if
//}
//
//function ViewNoRight(GroupID,Exclusive)
//  dim rs,sql,GroupLevel
//  set rs = server.createobject("adodb.recordset")
//  sql="select GroupLevel from nwebcn_memgroup where GroupID='"&GroupID&"'"
//  rs.open sql,conn,1,1
//  GroupLevel=rs("GroupLevel")
//  rs.close
//  set rs=nothing
//  ViewNoRight=true
//  if $_SESSION["GroupLevel")="" then $_SESSION["GroupLevel")=0
//  select case Exclusive
//    case ">="
//      if not $_SESSION["GroupLevel") >= GroupLevel then
//	    ViewNoRight=false
//	  end if
//    case "="
//      if not $_SESSION["GroupLevel") = GroupLevel then
//	    ViewNoRight=false
//      end if
//  end select
//}
//
//function GetUrl()
//  GetUrl="http://"&Request.ServerVariables("SERVER_NAME")&Request.ServerVariables("URL")
//  If Request.ServerVariables("QUERY_STRING")<>"" Then GetURL=GetUrl&"?"& Request.ServerVariables("QUERY_STRING")
//}
//
function HtmlSmallPic($GroupID,$PicPath,$Exclusive){
  $rtnval= $PicPath;
   $GroupLevel = "";
  $sql="select GroupLevel from nwebcn_memgroup where GroupID='".$GroupID."'";
  //echo $sql;
  $res=query($sql);
  $r = fetch($res);
  $GroupLevel = $r["GroupLevel"];
 // 释放内存
   mysql_free_result($res);  
  if($_SESSION["GroupLevel"] == ""){ $_SESSION["GroupLevel"]=0;}
  switch($Exclusive){
    case ">=":	
      if(!($_SESSION["GroupLevel"] >= $GroupLevel)){$rtnval = "../Images/nopic.gif";}//无权查看
	  break;
    case "=":
      if(! ($_SESSION["GroupLevel"] == $GroupLevel)){ $rtnval = "../Images/nopic.gif";}
  	break;
  }
  if(trim($rtnval) == ""){$rtnval ="../Images/nopic.gif";}
  return $rtnval;
}

function is_valid_email($email)
{
    if(eregi("^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email)){     
            return true;
    }else{
        return false;
	}
}

function IsValidMemName($memname)
{
    $rtnval = true;;

    if (!(3 <= strlen($memname) && strlen($memname) <= 16)) {
        $rtnval = false;
    }else {
        for ($i = 0; $i < strlen($memname); $i++) {
            $c = substr($memname, $i, 1);			
            if (strpos("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-", $c) <= 0 &&  (intval($c) < 0)){
                $rtnval = false;
                break;
     	       }
		}	   
    }    
    return $rtnval;
}

function IsValidEmail($email){
  $rtnval = false;
   $pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
   $rtnval = preg_match($pattern,$email);   
  return $rtnval;
}
//
//'================================================
//'函数名：FormatDate
//'作　用：格式化日期
//'参　数：DateAndTime            (原日期和时间)
//'       Format                 (新日期格式)
//'返回值：格式化后的日期
//'================================================
//function FormatDate(DateAndTime, Format)
//  On Error Resume Next
//  Dim yy,y, m, d, h, mi, s, strDateTime
//  FormatDate = DateAndTime
//  If Not IsNumeric(Format) Then Exit function
//  If Not IsDate(DateAndTime) Then Exit function
//  yy = CStr(Year(DateAndTime))
//  y = Mid(CStr(Year(DateAndTime)),3)
//  m = CStr(Month(DateAndTime))
//  If Len(m) = 1 Then m = "0" & m
//  d = CStr(Day(DateAndTime))
//  If Len(d) = 1 Then d = "0" & d
//  h = CStr(Hour(DateAndTime))
//  If Len(h) = 1 Then h = "0" & h
//  mi = CStr(Minute(DateAndTime))
//  If Len(mi) = 1 Then mi = "0" & mi
//  s = CStr(Second(DateAndTime))
//  If Len(s) = 1 Then s = "0" & s
//   
//  Select Case Format
//  Case "1"
//    strDateTime = y & "-" & m & "-" & d & " " & h & ":" & mi & ":" & s
//  Case "2"
//    strDateTime = yy & m & d & h & mi & s
//    '返回12位 直到秒 的时间字符串
//  Case "3"
//    strDateTime = yy & m & d & h & mi    
//    '返回12位 直到分 的时间字符串
//  Case "4"
//    strDateTime = yy & "年" & m & "月" & d & "日"
//  Case "5"
//    strDateTime = m & "-" & d
//  Case "6"
//    strDateTime = m & "/" & d
//  Case "7"
//    strDateTime = m & "月" & d & "日"
//  Case "8"
//    strDateTime = y & "年" & m & "月"
//  Case "9"
//    strDateTime = y & "-" & m
//  Case "10"
//    strDateTime = y & "/" & m
//  Case "11"
//    strDateTime = y & "-" & m & "-" & d
//  Case "12"
//    strDateTime = y & "/" & m & "/" & d
//  Case "13"
//    strDateTime = yy & "." & m & "." & d
//  Case "14"
//    strDateTime = yy & "-" & m & "-" & d
//  Case "15"
//    strDateTime = m & "-" & d & "&nbsp;" & h & ":" & mi
//    '返回12位 直到分 的时间字符串
//  Case Else
//    strDateTime = DateAndTime
//  End Select
//  FormatDate = strDateTime
//}
//
//function WriteMsg(Message)
//  response.write "<div align=""center"">" &_
//                 "  <div style=""width:500px; padding:1px; border:1px solid #f00;"">" &_
//                 "    <div style=""background:#f00; line-height:24px; font-family:Arial; font-size:16px; color:#fff; font-weight:bold;"">" &_
//                 "      MESSAGE" &_
//                 "    </div>" &_
//                 "   <div style=""padding:4px 0; text-align:left; background:#fff; font-family:宋体; line-height:20px; font-size:13px;"">" &_
//                       Message &_
//                 "    </div>" &_
//                 "  </div>" &_
//                 "  <div style=""padding:8px;"">" &_
//                 "    <a href=""javascript:history.back(-1)""><img src=""../Images/arrow_97.gif"" border=""0"" /></a>" &_
//                 "  </div>" &_
//				 "</div>"
//}

//'======================加载类别选择=====所使用函数========来源于 SelectSort.asp=================
function switchTableUseTagName($TableUseTagName){
	$rtnval = "";
  switch($TableUseTagName){
   
	case "Products":
	  $rtnval = "nwebcn_productsort";
	  break;
	case "News":
	  $rtnval = "nwebcn_newssort";
	  break;
	case "Download":
	  $rtnval = "NwebCn_DownSort";
	  break;
	  
	case "Others":
	  $rtnval = "NwebCn_OthersSort";
	  break;
	case "tradesort":
	case "colorsort":
	case "onlinesort":
	   $rtnval = "nwebcn_productothersort";
	  break;
  } 
  return $rtnval;
}
//
function ListSort($id,$DatafromTable){
  $sql="Select * From ".$DatafromTable." where ParentID=".$id." order by id asc"; 
  $res = mysql_query($sql);	   
  if(!isrecord($res)){
    echo ("暂无分类!"); 
   return;
  }	
  $i=1;
  echo ("<table border='0' cellspacing='0' cellpadding='0'>");
  $ChildCount = 0;
  while($r=mysql_fetch_array($res)){
 
	if(((int)trim($r["ID"])) >= 1){
        $get_rows_sql = "select * from ".$DatafromTable." where ParentID=".$r["ID"]; 		
       $ChildCount_r = mysql_query($get_rows_sql) or die(mysql_error());
	   $ChildCount = mysql_num_rows($ChildCount_r);
	   // 释放内存
    	mysql_free_result($ChildCount_r); 
	}

	 if($ChildCount == 0){
	  if( $i == $rowsfound){
	    $FolderType="SortFileEnd";
	  }else{
	    $FolderType="SortFile";
	  }
	  $FolderName = $r["SortName"];
	  $onMouseUp = "";
    }else{
	   if( $i == $rowsfound){
	 	$FolderType="SortEndFolderClose";
		$ListType="SortEndListline";
		$onMouseUp="EndSortChange('a".$r["ID"]."','b".$r["ID"]."');";
	  }else{
		$FolderType="SortFolderClose";
		$ListType="SortListline";
		$onMouseUp="SortChange('a".$r["ID"]."','b".$r["ID"]."');";
	  }
	  $FolderName= $r["SortName"];
    }
    echo ("<tr>");
    echo("<td nowrap id='b".$r["ID"]."' class='".$FolderType."' onMouseUp=".$onMouseUp."></td><td nowrap>".$FolderName."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;")	;
   echo("<a class=\"addSortValToInput\" addSortNameVal=\"".SortText($r["ID"],$DatafromTable)."\" addSortIdVal=\"".$r["ID"]."\" addSortPathVal=\"".$r["SortPath"]."\" style=\"cursor:pointer;\"><font color='#ff6600'>选择</font></a>");
    echo("</td></tr>");
    if($ChildCount > 0){
 ?>
      <tr id="a<?php echo $r["ID"]; ?>" style="display:yes"><td class="<?php echo $ListType; ?>" nowrap></td><td ><?php ListSort($r["ID"],$DatafromTable); ?></td></tr>
<?php 
    }
    $i = $i+1;
  }
  echo("</table>");  
  // 释放内存
	mysql_free_result($res); 
}

//生成所属类别--------------------------
function SortText($ID,$DatafromTable){
	$rtnval = "";
  	$sql="Select * From ".$DatafromTable." where ID=".$ID;
	//echo $sql ."这个是两个参数的，最后删除我";
	$res=mysql_query($sql);
	while($r=mysql_fetch_array($res)){		
		$rtnval=  $r["SortName"];
	}
	// 释放内存
	mysql_free_result($res); 	
  return $rtnval;
}

 function clientIP(){   
  $cIP = getenv('REMOTE_ADDR');   
  $cIP1 = getenv('HTTP_X_FORWARDED_FOR');   
  $cIP2 = getenv('HTTP_CLIENT_IP');   
  $cIP1 ? $cIP = $cIP1 : null;   
  $cIP2 ? $cIP = $cIP2 : null;   
  return $cIP;   
 }   
 function serverIP(){   
  return gethostbyname($_SERVER["SERVER_NAME"]);   
 } 
//当前页面文件名 
function cur_page_filename(){ 
  $dir_file = $_SERVER['SCRIPT_NAME']; 
  $filename = basename($dir_file);
  return $filename;
} 
//会员存在
function memberExistById($ID){
	$rtnval=false;
	if($ID >=1){
		$MemNameCount=0;
		$sql="select MemName from NwebCn_Members where ID='" .$ID. "'";	
		
		$res=query($sql);
		$MemNameCount= mysql_num_rows($res);
		if($MemNameCount == 1){
			$rtnval=true;
		}
		// 释放内存
		 mysql_free_result($res);
	}
	return $rtnval;
}
?>