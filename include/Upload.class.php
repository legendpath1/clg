  <?php
  
  class uploadFile {

	var $file_max_size = 50000000;			//上传文件大小限制, 单位BYTE
	var $file_save_dir = FILES_DIR;	//上传文件保存路径
	var $filetype = array( /*'video/x-flv',*/ 'application/x-shockwave-flash');	//允许上传的文件类型列表
	var $file_new_name = ''; //生成的新的图片名称

	var $file_name = '';
	
	var $errmsg = '';		//保存错误信息
	
	function __construct(){
	}
	
	//上传文件***********************************************************************************************
	function upload_file($upfile = array()){
		if(!is_array($upfile)){
			$this->errmsg = '文件参数不完整';
			return false;
		}
		if(!in_array($upfile["type"] , $this->filetype)){
			$this->errmsg = '文件格式不符!';
			return false;
		}
		if($upfile["size"] > $this->file_max_size){
			$this->errmsg = '文件过大!';
			return false;
		}
		if(!is_uploaded_file($upfile["tmp_name"])){
			$this->errmsg = '只能上传本地网络文件.';
			return false;
		}
		if(!is_dir($this->file_save_dir)){
			if(!mkdir($this->file_save_dir)){
				$this_errmsg = '文件目录创建失败';
			}
		}
		$file_type = strstr($upfile["name"] , '.');
		$this->file_new_name = time().rand().$file_type;
		$this->file_name = time().rand();
		$file_upload_path = $this->file_save_dir.$this->file_new_name;
		if(file_exists($file_upload_path)){
			$this->errmsg = '文件重名,请重试.';
			return false;
		}
		if(!move_uploaded_file($upfile["tmp_name"] , $file_upload_path)){
			$this->errmsg = '上传失败,请重试';
			return false;
		}else{
			if($this->watermark == 1){
				$this->add_water_mark($this->file_new_name);
			}
			
			if($this->cutfile == 1){
				$this->make_small_file($this->file_new_name);
			}
		}
		return $this->file_new_name;
	}
	
  }
    ?>
