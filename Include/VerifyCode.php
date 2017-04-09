<?php
error_reporting(0);
session_start();
//生成验证码图片
Header("Content-type: image/png");
$im = imagecreatetruecolor(44,18);//创建图像，指明宽高
$back = ImageColorAllocate($im, 245,245,245);//为指定图像分配着色，RGB
imagefill($im,0,0,$back); // 在 image 图像的坐标 x ，y （图像左上角为 0, 0）处用 color 颜色执行区域填充（即与 x, y 点颜色相同且相邻的点都会被填充）。


srand((double)microtime()*1000000);//生成随机数种子
//生成4位数字
for($i=0;$i<4;$i++){
	$font = ImageColorAllocate($im, rand(100,255),rand(0,100),rand(100,255));
	$authnum=rand(1,9);
	$vcodes.=$authnum;
	Imagestring($im, 5, 2+$i*10, 1, $authnum, $font);
}

for($i=0;$i<100;$i++) //加入干扰象素
{
	$randcolor = ImageColorallocate($im,rand(0,255),rand(0,255),rand(0,255));
	Imagesetpixel($im, rand()%70 , rand()%30 , $randcolor);//画一个单一像素，一个点
}
ImagePNG($im);
ImageDestroy($im);

$_SESSION['VerifyCode'] = $vcodes;

?>