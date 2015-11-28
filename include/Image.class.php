<?php
//图片上传并加水印
class upimages{
	var $img_max_size = 2000000;			//上传图片大小限制, 单位BYTE
	var $img_save_dir = PRODUCT_IMG_DIR;	//上传文件保存路径
	var $imgtype = array( 'image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png', 'image/bmp');	//允许上传的文件类型列表
	var $img_new_name = ''; //生成的新的图片名称 
	
	var $watermark = 0 ;			//是否附加水印(1为加水印,其他为不加水印)
	var $watermarktype = 2; 		//水印的类型(1为文字,2为图片)
	var $waterposition = 3; 		//水印的位置(1为左上角,2为右上角,3为右下角,4为左下角,5为居中)
	var $waterword = 'Copyright@gzseo.cn'; 		//水印文字
	var $wordcolor = array('255', '102', '0', '100');			//文字颜色
	var $waterimg = '../images/logo.gif';			//水印图片
	var $waterapha = 60;		//水印透明度
	var $waterdistanceframe = 10; //水印与边框的距离
	
	var $previewimg = 0;		//是否生成预览(1为生成,其它不显示)
	var $view_w = 300;		//预览图宽度
	var $view_h = 300;		//预览图高度
	
	var $cutimg	= 0;			//是否生成缩略图(1为生成,其它不生成)
	var $simg_path = THUMB_IMG_DIR;	//缩略图的存放路径
	var $miniimgwidth = 100;			//缩略图宽
	var $miniimgheight = 100;		//缩略图高
	
	var $errmsg = '';		//保存错误信息
	
	function __construct(){
	}
	
	//上传图片***********************************************************************************************
	function upload_img($upimg = array()){
		if(!is_array($upimg)){
			$this->errmsg = '图片参数不完整';
			return false;
		}
		if(!in_array($upimg["type"] , $this->imgtype)){
			$this->errmsg = '图片格式不符!';
			return false;
		}
		if($upimg["size"] > $this->img_max_size){
			$this->errmsg = '图片过大!';
			return false;
		}
		if(!is_uploaded_file($upimg["tmp_name"])){
			$this->errmsg = '只能上传本地网络图片.';
			return false;
		}
		if(!is_dir($this->img_save_dir)){
			if(!mkdir($this->img_save_dir)){
				$this_errmsg = '图片目录创建失败';
			}
		}
		$img_type = strstr($upimg["name"] , '.');
		$this->img_new_name = time().rand().$img_type;
		$img_upload_path = $this->img_save_dir.$this->img_new_name;
		if(file_exists($img_upload_path)){
			$this->errmsg = '图片文件重名,请重试.';
			return false;
		}
		if(!move_uploaded_file($upimg["tmp_name"] , $img_upload_path)){
			$this->errmsg = '上传失败,请重试';
			return false;
		}else{
			if($this->watermark == 1){
				$this->add_water_mark($this->img_new_name);
			}
			
			if($this->cutimg == 1){
				$this->make_small_img($this->img_new_name);
			}
		}
		return $this->img_new_name;
	}
	
	//上传图片集*********************************************************************************************
	function upload_img_muster($upimg_arr = array()){
		$upload_img = array();
		$upload_img_name = $upimg_arr['name'];
		foreach($upload_img_name as $key=>$value){
			if($value!=""){
				$upload_img[$key] = array('name'=>$upimg_arr['name'][$key], 'type'=>$upimg_arr['type'][$key], 'tmp_name'=>$upimg_arr['tmp_name'][$key], 'error'=>$upimg_arr['error'][$key], 'size'=>$upimg_arr['size'][$key]);
			}
		}
		foreach($upload_img as $imgarr){
			
			if(!is_array($imgarr)){
				$this->errmsg = '图集中有图片参数不完整';
				return false;
			}
			if(!in_array($imgarr["type"] , $this->imgtype)){
				$this->errmsg = '图集中有图片格式不符!';
				return false;
			}
			if($imgarr["size"] > $this->img_max_size){
				$this->errmsg = '图集中有图片过大!';
				return false;
			}
			if(!is_uploaded_file($imgarr["tmp_name"])){
				$this->errmsg = '只能上传本地网络图片.';
				return false;
			}
		}

		foreach($upload_img as $imgid=>$imgarr){
			if(!$this->upload_img($imgarr)){
				return false;
			}else{
				$pdimgname[$imgid] = $this->img_new_name; //图片名称
			}
		}
		//print_r($pdimgname);exit;
		return $pdimgname;
		
	}
	
	//添加水印***********************************************************************************************
	function add_water_mark($imgname){
		$img_path = $this->img_save_dir.$imgname;
		
		if(!is_file($img_path)){
			$this->errmsg = '源图片文件丢失';
			return false;
		}else{
			if($src_image = @getimagesize($img_path)){
				$srcimgwidth = $src_image[0];	//源图片宽度
				$srcimgheight = $src_image[1];	//源图片高度
				$bimgtype = $src_image[2];	//源图片格式
			}else{
				$this->errmsg = '源图片文件有误';
				return false;
			}
			
			switch($bimgtype){
				case '1';
					$src_img = imagecreatefromgif($img_path);
					break;
				case '2';
					$src_img = imagecreatefromjpeg($img_path);
					break;
				case '3';
					$src_img = imagecreatefrompng($img_path);
					break;
				case '6';
					$src_img = imagecreatefromwbmp($img_path);
					break;
				default:
					$this->errmsg = '不支持的图片类型格式';
					return false;
					
			}
						
			if($this->watermarktype==1){	//文字水印
				if(empty($this->waterword)){
					$this->errmsg = '水印文字不能空';
					return false;
				}else{
					$fontcolor = ImageColorAllocateAlpha($src_img, $this->wordcolor[0], $this->wordcolor[1], $this->wordcolor[2], $this->wordcolor[3]);
					switch($this->waterposition){
						case '1':
							imagestring($src_img, 5, $this->waterdistanceframe, $this->waterdistanceframe, $this->waterword, $fontcolor);
						break;
						case '2':
							imagestring($src_img, 5, $srcimgwidth-350, $this->waterdistanceframe, $this->waterword, $fontcolor);
						break;
						case '3':
							imagestring($src_img, 5, $srcimgwidth-350, $srcimgheight-30, $this->waterword, $fontcolor);
						break;
						case '4':
							imagestring($src_img, 5, $this->waterdistanceframe, $srcimgheight-30, $this->waterword, $fontcolor);
						break;
						case '5':
							imagestring($src_img, 5, $srcimgwidth/2-100, $srcimgheight/2, $this->waterword, $fontcolor);
						break;
						default:
							$this->errmsg = '添加水印文字失败.';
							return false;
					}
				}
			}elseif($this->watermarktype==2){	//图片水印
				if(!file_exists($this->waterimg)){
					$this->errmsg = '水印图片不存在';
					return false;
				}
				if($wa_img = @getimagesize($this->waterimg)){
					$wa_width = $wa_img[0];		//水印图片宽度
					$wa_height = $wa_img[1];	//水印图片高度
					$wa_type = $wa_img[2];		//水印图片格式
				}else{
					$this->errmsg = '水印图片文件有误';
					return false;
				}
				
				switch($wa_type){
					case '1';	//gif
						$wa_img = imagecreatefromgif($this->waterimg);
						break;
					case '2';	//jpg
						$wa_img = imagecreatefromjpeg($this->waterimg);
						break;
					case '3';	//png
						$wa_img = imagecreatefrompng($this->waterimg);
						break;
					case '6';	//bmp
						$wa_img = imagecreatefromwbmp($this->waterimg);
						break;
					default:
						$this->errmsg = '不支持的水印图片类型格式';
						return false;
					
				}
				
				switch($this->waterposition){	//添加水印图片位置
					case '1':
						$src_wpos = $this->waterdistanceframe;
						$src_hpos = $this->waterdistanceframe;
						imagecopymerge($src_img, $wa_img, $src_wpos , $src_hpos, 0, 0, $wa_width, $wa_height, $this->waterapha);
					break;
					case '2':
						$src_wpos = $srcimgwidth-$wa_width-$this->waterdistanceframe;
						$src_hpos = $this->waterdistanceframe;
						imagecopymerge($src_img, $wa_img, $src_wpos , $src_hpos, 0, 0, $wa_width, $wa_height, $this->waterapha);
					break;
					case '3':
						$src_wpos = $srcimgwidth-$wa_width-$this->waterdistanceframe;
						$src_hpos = $srcimgheight-$wa_height-$this->waterdistanceframe;
						imagecopymerge($src_img, $wa_img, $src_wpos , $src_hpos, 0, 0, $wa_width, $wa_height, $this->waterapha);
					break;
					case '4':
						$src_wpos = $this->waterdistanceframe;
						$src_hpos = $srcimgheight-$wa_height-$this->waterdistanceframe;
						imagecopymerge($src_img, $wa_img, $src_wpos , $src_hpos, 0, 0, $wa_width, $wa_height, $this->waterapha);
					break;
					case '5':
						$src_wpos = ($srcimgwidth-$wa_width)/2;
						$src_hpos = ($srcimgheight-$wa_height)/2;
						imagecopymerge($src_img, $wa_img, $src_wpos , $src_hpos, 0, 0, $wa_width, $wa_height, $this->waterapha);
					break;
					default:
						$this->errmsg = '水印添加失败';
						return false;
				}
			}
			
			//保存添加水印后的图片
			switch($bimgtype){
				case '1';
					imagegif($src_img,$img_path);
					break;
				case '2';
					imagejpeg($src_img,$img_path);
					break;
				case '3';
					imagepng($src_img,$img_path);
					break;
				case '6';
					imagewbmp($src_img,$img_path);
					break;
				default:
					$this->errmsg = '添加水印失败';
					return false;
				
			}
			imagedestroy($src_img);	//释放缓存
		}
		return true;
	}
	
	//生成缩略图片*******************************************************************************************
	function make_small_img($imgname){
		$img_path = $this->img_save_dir.$imgname;
		
		if(!is_file($img_path)){
			$this->errmsg = '源图片文件丢失';
			return false;
		}
		
		if(!is_dir($this->simg_path)){
			if(!mkdir($this->simg_path)){
				$this->errmsg = '缩略图目录创建失败';
				return false;
			}
		}
		
		$sm_path = $this->simg_path.$imgname;
		
		if($src_image = @getimagesize($img_path)){
			$srcimgwidth = $src_image[0];	//源图片宽度
			$srcimgheight = $src_image[1];	//源图片高度
			$bimgtype = $src_image[2];	//源图片格式
		}else{
			$this->errmsg = '源图片文件有误';
			return false;
		}
		
		switch($bimgtype){
			case '1';
				$src_img = imagecreatefromgif($img_path);
				break;
			case '2';
				$src_img = imagecreatefromjpeg($img_path);
				break;
			case '3';
				$src_img = imagecreatefrompng($img_path);
				break;
			case '6';
				$src_img = imagecreatefromwbmp($img_path);
				break;
			default:
				$this->errmsg = '不支持的图片类型格式';
				return false;
				
		}
			
		$mini_balance = $this->miniimgwidth/$this->miniimgheight;
		if($srcimgwidth/$srcimgheight>$mini_balance){
			$miniwidth = $this->miniimgwidth;
			$miniheight = intval($this->miniimgwidth*$srcimgheight/$srcimgwidth);
		}elseif($srcimgwidth/$srcimgheight<$mini_balance){
			$miniwidth = intval($this->miniimgheight*$srcimgwidth/$srcimgheight);
			$miniheight = $this->miniimgheight;
		}else{
			$miniwidth = $this->miniimgwidth;
			$miniheight = $this->miniimgheight;
		}
			
		$smallimg = imagecreatetruecolor($miniwidth, $miniheight);
		imagecopyresampled($smallimg, $src_img, 0, 0, 0, 0, $miniwidth, $miniheight, $srcimgwidth, $srcimgheight);
		
		//保存生成的缩略图片
		switch($bimgtype){
			case '1';
				imagegif($smallimg,$sm_path);
				break;
			case '2';
				imagejpeg($smallimg,$sm_path);
				break;
			case '3';
				imagepng($smallimg,$sm_path);
				break;
			case '6';
				imagewbmp($smallimg,$sm_path);
				break;
			default:
				$this->errmsg = '生成缩略图的过程出现错误。';
				return false;
			
		}
		imagedestroy($smallimg);	//释放缓存
		return true;

	}
	
	//生成预览图片***********************************************************************************************
	function make_preview_img($upimg = array()){
		if(!empty($this->img_new_name)){
			$img_path = $this->img_save_dir.$this->img_new_name;
		}else{
			return false;
		}
		if(!file_exists($img_path)){
			$this->errmsg = '图片文失丢失';
			return false;
		}
		if($bimg = @getimagesize($img_path)){
			$img_w = $bimg[0];	//源图片宽度
			$img_h = $bimg[1];	//源图片高度
		}else{
			$this->errmsg = '源图片文件有误';
			return false;
		}
		if($img_w <= $this->view_w){
			$preview_w = $img_w;
		}else{
			$preview_w = $this->view_w;
		}
		if($img_h <= $this->$view_h){
			$preview_h = $img_h;
		}else{
			$preview_h = $this->view_h;
		}
		
		return "<div style=\"margin:0 auto; text-align:center;\"> <img onclick=\"window.close()\" title=\"点击图片关闭预览窗口\" src=\"".$img_path."\" width=\"".$preview_w."\" height=\"".$preview_h."\" border=\"0\"> </div>";
		
	}
}
?>