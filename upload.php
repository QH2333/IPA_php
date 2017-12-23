<?php
header("Content-Type:text-plain;charset:utf-8");//设置文件编码
//echo json_encode(array("response"=>$_POST));
//$name = isset($_POST["myName"])?
$img = $_FILES["myFile"];
$name = $_POST["myName"];
//$img = $_FILES["myFile"];
//$filename = time().substr($_FILES["photo"]["name"], strrpos($_FILES["photo"]["name"],"."));  



//echo json_encode(array("name"=>$name, "img"=>$img["name"]));


//$img = $_FILES["myFile"];//获取到表单过来的文件变量，uploadImg为表单id
//$name = $_POST["myName"];
$img["name"] = iconv("utf-8", "gbk", $img["name"]);
$name = iconv("utf-8", "gbk", $name);
$path = "./".$name;

$errorone = "";
$errortwo = "";
if(isset($name)){
	if(!file_exists($path)){
	
	    mkdir($path, 0777);
		if(!file_exists($path)){
			$errorone.="创建文件夹失败！";
		}
	}
}else {
	$errorone.="获取个人信息失败！";
}
//检测变量是否获取到
if(isset($img)){
	//上传成功$img中的属性error为0，当error>0时则上传失败有一下几种情况
	if($img["error"]>0){
		$errorone.= "上传失败";
		switch($img["error"]){
			case 1: 
			$error.=",大小超过了服务器设置的限制！";
			break;
			case 2: 
			$error.=",文件大小超过了表单设置的限制！";
			break;
			case 3: 
			$error.=",文件只有部分被上传";
			break;
			case 4: 
			$error.=",没有文件被上传";
			break;
			case 6: 
			$error.=",上传文件的临时目录不存在！";
			break;
			case 7: 
			$error.=",写入失败";
			break;
			default: 
			$error.=",未知错误";
			break;
		}
	} else{
//		$type = strrchr($img["name"], ".");//截取文件后缀名
//		if(strtolower($type)==".png"||strtolower($type)==".jpg"||strtolower($type)==".bmp"||strtolower($type)==".gif"){//判断上传的文件是否为图片格式
			move_uploaded_file($img["tmp_name"], $path."/".$img["name"]);//将图片文件移到该目录下
//		}
	}
}
if (file_exists($path."/".$img["name"])){
	echo json_encode(array("result"=>"1"), JSON_UNESCAPED_UNICODE);
} else if($errorone != ""){
	echo json_encode(array("result"=>$errorone), JSON_UNESCAPED_UNICODE);
} else{
	echo json_encode(array("result"=>$errortwo), JSON_UNESCAPED_UNICODE);
}
?>