<?php
$targetFolder = '/uploadfile/img/'; // 保存的文件夹
if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
	$fileTypes = array('jpg','jpeg','gif','png'); // 允许上传的类型
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	
	if (in_array(strtolower($fileParts['extension']),$fileTypes)) {
		
		$newname = rtrim($targetPath,'/') . '/cata'. date('YmdHis') . mt_rand(100, 999) . '.' . $fileParts['extension'];//该文件名字
		$newnames=$targetFolder . basename($newname);
		move_uploaded_file($tempFile,iconv("UTF-8","gb2312", $newname));//上传
		echo $newnames ;
		//echo $fileParts;
	} else {
		echo "type is wrong";
	}
}


?>