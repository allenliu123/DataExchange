<html>
<head>
<title>Data Exchange</title>
<meta charset='UTF-8'>
<link href = "https://cdn.bootcss.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" rel ="stylesheet" >
<link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
<!--ajax实现点击显示就显示出上一次提交的文本内容-->
<script type="text/javascript">
    window.onload = function (){
        document.getElementsByTagName('a')[0].onclick= function(){
            var request = new XMLHttpRequest();

            request.open("GET",this.href);
            request.send(null);

            request.onreadystatechange = function () {
                    if(request.readyState == 4) {
                        if(request.status == 200 || request.status == 304){
			document.getElementsByTagName('textarea')[0].value = request.responseText;
                        }
                    }
                }

            return false;
        }
    }
</script>
<style type="text/css">
	label:hover {
		color: #306;
	}
	#all {
		margin-top: 10px;
	}
	.emerge {
		display: none;
	}

</style>
</head>
<body> 
<div class="container">
	<form action="index.php" method="post"  enctype="multipart/form-data">
	<textarea style="width:500px;margin:20px;" name="area" class="form-control" rows="7">
	</textarea>

	&nbsp&nbsp<input type="file" class="btn" name="file">
	<input type="submit" class = "btn btn-outline-success" value="上传" >
	<a href="./content.txt"><button class="btn btn-outline-primary">显示</button></a>

	</form>
<?php
error_reporting(E_ALL ^ E_NOTICE);//不显示错误信息
//upload start
if ($_POST["area"]){
file_put_contents("content.txt",$_POST["area"]);
}

if ($_FILES["file"]){	
	echo "文件 " . $_FILES["file"]["name"] . " 已上传<br>";	
	move_uploaded_file($_FILES["file"]["tmp_name"], "./" . $_FILES["file"]["name"]);
}
//upload end

//delete file start
if($_POST["checkbox"][0]!=""){
	echo "文件 ";
	foreach($_POST["checkbox"] as $filename){
		echo $filename." ";
	}
	echo "已经删除";
	foreach($_POST["checkbox"] as $filename){
		unlink($filename);
	}
}
//delete file end
//list files in current folder
function dir_list($exts = '', $list = array()) {
	$files = glob('*');
	foreach($files as $v) {
		if($v=="index.php"||$v=="content.txt") continue;
		if (!$exts || preg_match("/\.($exts)/i", $v)) {
			$list[] = $v;
		}
	}
	return $list;
}
$array = dir_list();
?>
<h4>文件列表</h4>
<form action="index.php" method="post"  enctype="multipart/form-data">
<div class="emerge">
	<label id="details"></label>
	<input type="submit" class = "btn btn-sm btn-outline-danger" value="删除">
	<a href="#" target="_blank"><input type="button" class="btn btn-sm btn-outline-success" value="打开"></a>
	<a href="#" download><input type="button" class="btn btn-sm btn-outline-success" value="下载"></a>
</div>	
<input type="checkbox" id="all">&nbsp&nbsp<label for="all">全选</label>&nbsp&nbsp

<br>
<?php
foreach($array as $f){
	echo "<input type=\"checkbox\" onclick=\"check(this)\" name=\"checkbox[]\" value=\"".$f."\" id=\"".$f."\">&nbsp&nbsp <i class=\"fa fa-file-text-o\" aria-hidden=\"true\"></i>&nbsp<label for=\"".$f."\">".$f."</label></br>\n"; 
}
?>
<form>
	
</div>
</body>
<script>

var all=document.getElementById('all');

var details=document.getElementById("details");
var count=0;			

//点击全选时，勾选上所有选框
all.onclick=function() {
	var elements=document.forms[1].elements;
	for(i=0;i<elements.length;i++){
    	if(elements[i].type=="checkbox"){
			if(all.checked==true){
		    	elements[i].checked=true;
				count=elements.length-3;
		    }
			else{
				count=0;
		    	elements[i].checked=false;
			}
			
		}		

	}
	details.innerHTML="已选择"+count+"项";
	if(count > 0){
		$('.emerge').fadeIn();
	}
	else{
		$('.emerge').fadeOut();
	}
}
// 每次点击checkbox时，令count++ 
function check(the) {
	var elements=document.forms[1].elements;

	if(the.checked==true){count++;}
	else{count--;elements[0].checked=false;}
	$('a')[1].href="./"+the.value;
	$('a')[2].href="./"+the.value;
	details.innerHTML="已选择"+count+"项";
	if(count > 0){
		$('.emerge').fadeIn();
	}
	else{
		$('.emerge').fadeOut();
	}
allen('a');
}


</script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</html>
