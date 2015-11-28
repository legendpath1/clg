<?php
	function check_form($form_arr = array()){
		//保存错误信息
		$err_msg='';
		
		//验证产品名称******************************************************************************
		$pattern['pd_name'] = array('/^[^\'\,\"%\s?<>]{1,40}$/' , '产品名称有误，检查后重试。');
		//验证产品货号
		$pattern['pd_code'] = array('/^[a-z0-9]{6}$/i', '商品编号限定为6个字符。');
		//产品分类
		$pattern['pd_type'] = array('/^[1-9]\d{0,1}$/', '请选择正确的产品分类选项');
		//产品扩展分类
		$pattern['exttype'] = array('/^[1-9]\d{0,1}$/', '请选择正确的产品扩展分类选项');
		//市场价格
		$pattern['marketprice'] = array('/^(\d{1,10}(\.\d{2})?)?$/', '市场价格的正确格式为0.00。');
		//会员价格
		$pattern['memberprice'] = array('/^(\d{1,10}(\.\d{2})?)|-1$/', '会员价格的正确格式为0.00或-1。');
		//促销价格
		$pattern['promoteprice'] = array('/^\d{1,10}(\.\d{2})?$/', '促销价格的正确格式为0.00。');
		//显示版式
		$pattern['show_type'] = array('/^1|2|3|4$/', '显示版式中无此选项。');
		//独立站点名
		$pattern['site_name'] = array('/^[a-zA-Z0-9]{0,10}$/i','独立站点名只能是英文及数字');
		//详细描述 －－－ 正则表达式长度受限
		//$pattern['goods_desc'] = array('/^(.|\n){0,5000}$/', '详细描述限定在5000个有效的字符内。'); 
		//库存量
		$pattern['pd_number'] = array('/^\d{1,3}$/', '库存量只能是有效的数字。');
		//新品
		$pattern['is_new'] = array('/^1?$/', '新品中无此值。');
		//赠品
		$pattern['is_gifts'] = array('/^1?$/', '赠品中无此值。');
		//上架
		$pattern['is_on_sale'] = array('/^1?$/', '上架中无此值。');
		//产品规格
		$pattern['pd_spec'] = array('/^[^\'\,\"%\s?<>]{0,40}$/', '产品规格有误(必须小于40个有效字符)。');
		//大标一
		$pattern['headline_1'] = array('/^[^\'\"%\s?<>]{0,50}$/', '大标一有误(必须小于50个有效字符)。');
		//大标二
		$pattern['headline_2'] = array('/^[^\'\"%\s?<>]{0,50}$/', '大标二有误(必须小于50个有效字符)。');
		//小标
		$pattern['subhead'] = array('/^[^<>]{0,100}$/', '小标题有误(必须小于100个有效字符)。');
		//赠品说明
		$pattern['free_gifts'] = array('/^[^<>]{0,100}$/', '赠品说明有误(必须小于100个有效字符)。');
		//搜索关键字
		//$pattern['seokey'] = array('/^[^\'\"%?<>]{0,250}$/', '产品搜索关键字有误(必须小于250个有效字符)。');
		//产品简述
		//$pattern['content'] = array('/^[^<>]{0,500}$/', '产品简述限定在500个有效字符内。');
		//赠品描述
		//$pattern['jianjie'] = array('/^[^<>]{4,50}$/', '简介描述限定在4-50个有效字符内。');
		
		//通用的********************************************************************************
		//$pattern['title']=array('/^[^\'\,\"%\s?<>]{1,255}$/','标题名称有误，检查后重试。');
		$pattern['url']=array('/^(http:\/\/[A-Za-z0-9_]+\.[A-Za-z0-9]+[\/=\?%\-&_~\^`@\[\]\':+\!]*([^<>\"\"])*){1,100}$/','对不起，您输入的URL地址格式不正确！');
		$pattern['catid']=array('/^[1-9]\d{0,7}|0$/','请选择类别!');
		$pattern['stor']=array('/^[1-9]\d{0,7}|0$/','请输入排列序号!');
		
		//后台添加会员*******************************************************************************************************
		//验证用户名
		// $pattern['username'] = array('/^([A-Za-z]\w{3,15})?$/i' , '您输入的用户名格式不正确！（用户名应该是由4-16英文字母、数字、下划线字符组成。）');
		//验证密码格式
		$pattern['password']  = array('/^([A-Za-z0-9]{6,16})?$/i','密码必须同时包含字母及数字且长度不能小于6！');
		//验证email地址
		$pattern['email'] = array('/^([_a-z0-9-]+(\.[a-z0-9]+)?@[a-z0-9-]+\.[a-z0-9]+(\.[a-z0-9]+)?)?$/i' , '您输入的电子邮箱格式不正确！');
		//验证姓名
		$pattern['full_name'] = array('/^[^\'\,\"%*\s?<>\\/\\\\#-]{2,20}$/' , '您输入的姓名格式不正确！');
		//验证性别
		$pattern['sex']  = array('/^0|1|2$/i','请选择性别！');
		//出生日期
		$pattern['birthday'] = array('/^(\d{4}-\d{2}-\d{2})?$/', '出生日期的正确格式为2008-01-01。');
		//婚姻状况
		$pattern['marriage'] = array('/^0|1|2$/i','请选择婚姻状况！');
		//会员来源
		$pattern['mb_from'] = array('/^[1-9]\d{0,2}$/','请选择会员来源!');
		//会员咨询的产品
		$pattern['pd_id'] = array('/^[1-9]\d{0,7}|0$/','请选择会员咨询的产品!');
		//服务人员
		$pattern['waiter_id'] = array('/^[1-9]\d{0,2}|0$/','请选择服务人员!');

		if(empty($form_arr['mobile'])){
			//验证固定电话号码
			$pattern['phone'] = array('/^(\d{2,4}-\d{7,8}(-\d{1,5})?)|(13\d{9})|(15\d{9})|(189\d{8})$/', '您输入的电话号码格式不正确');
		}elseif(empty($form_arr['phone'])){
			//验证手机号码
			$pattern['mobile'] = array('/^(13\d{9})|(15\d{9})|(189\d{8})$/', '您输入的手机号码格式不正码');
		}else{
			//验证手机号码
			$pattern['mobile'] = array('/^(13\d{9})|(15\d{9})|(189\d{8})$/', '您输入的手机号码格式不正码');
			//验证固定电话号码
			$pattern['phone'] = array('/^(\d{2,4}-\d{7,8}(-\d{1,5})?)|(13\d{9})|(15\d{9})|(189\d{8})$/', '您输入的电话号码格式不正确');
		}
		
		//广告
		$pattern['adv_width'] = array('/^(\d{0,4})$/', '宽度只能为数据');
		$pattern['adv_height'] = array('/^(\d{0,4})$/', '高度只能为数据');
			
		//验证地址
		$pattern['province'] =  array('/^[^\'\,\"%*\s?<>\\/\\\\#]{0,20}$/','请选择所在省');
		$pattern['city'] =  array('/^[^\'\,\"%*\s?<>\\/\\\\#]{0,20}$/','请选择所在城市');
		$pattern['county'] =  array('/^[^\'\,\"%*\s?<>\\/\\\\#]{0,20}$/','请选择所在县');
		$pattern['street'] = array('/^[^\'\,\"%*\s?<>\\/\\\\#]{0,50}$/','您输入的通讯地址不合法！');
		$pattern['zip'] = array('/^(\d{6})?$/', '您输入的邮编不合法!');
		$pattern['remark'] = array('/^[^<>]{0,50}$/', '您输入的备注内容不正确!');
		
		
		//管理员用户名
		/* $pattern['admin_name'] = array('/^[A-Za-z_]\w{3,15}$/i' , '您输入的管理员用户名格式不正确！（用户名应该是由4-16英文字母、数字、下划线字符组成。）'); */
		//验证密码格式
		$pattern['admin_password']  = array('/^[A-Za-z0-9]{6,16}$/i','密码必须同时由字母或数字组成且长度不能小于6！');
		//旧的密码
		$pattern['admin_oldpassword'] = array('/^([A-Za-z0-9]{6,16})?$/i','原始密码错误！');
		//管理员姓名
		$pattern['full_name'] = array('/^[^\'\,\"%*\s?<>\\/\\\\#-]{4,20}$/' , '管理员姓名格式有误，请检查！');
		//管理员手机号码
		$pattern['admin_mobile'] = array('/^((13\d{9})|(15\d{9})|(189\d{8}))?$/', '手机号码有误，请检查!');
		
		//新闻标题
		$pattern['news_title'] = array('/^[^<>]{5,50}$/' , '公告标题限定在5-50个有效字符之间，请检查后重试！');
		//新闻链接
		$pattern['news_url'] = array('/^(http:\/\/[A-Za-z0-9_]+\.[A-Za-z0-9]+[\/=\?%\-&_~\^`@\[\]\':+\!]*([^<>\"\"])*){0,100}$/','对不起，您输入的URL地址格式不正确！');
		//新闻内容
		$pattern['news_content'] = array('/^(.|\n){10,250}$/' , '公告内容限定在10-250个有效字符之间，请检查后重试！');
		//公告内容
		$pattern['notice_content'] = array('/^(.|\n){10,250}$/' , '公告内容限定在10-250个有效字符之间，请检查后重试！');
		
		//友情链接
		//$pattern['link_name'] = array('/^[^\'\,\"%*\s?<>\\/\\\\#]{3,50}$/','对不起，您输入的网站名称不合法，请重新输入。');
		//$pattern['link_url'] = array('/^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~\^`@\[\]\':+\!]*([^<>\"\"])*$/','对不起，您输入的网站地址格式不正确！');
		
		//权限管理
		$pattern['main_sort'] = array('/^\d{1,4}$/', '上级分类值非法！');
		$pattern['new_ps_name_cn'] = array('/^[^\'\,\"%*\s?<>\\/\\\\#-]{4,50}$/', '权限类别中文名有误！');
		$pattern['new_ps_name_en'] = array('/^[^\'\,\"%*\s?<>\\/\\\\#-]{4,50}$/', '权限类别英文名有误！');
		if(!empty($form_arr['power_filename'])){
			$pattern['power_filename'] = array('/^[A-Za-z0-9_]+\.[A-Za-z0-9]+[\/=\?%\-&_~\^`@\[\]\':+\!]*([^<>\"\"])*$/','相关文件名有误！');
		}
		$pattern['ps_is_show'] = array('/^0|1$/','非法的选项值！');
		

		if (!is_array($form_arr))
			return "系统错误：请联系管理员。<br>";
		
		foreach ($form_arr as $key => $value){
			if($key=='goods_desc'){
				if(strlen($value)>50000){
					$err_msg .= '详细描述限定在50000个有效的字符内。<br>';
				}
			}
			if (!empty($pattern[$key][0])){
				if ( !preg_match($pattern[$key][0] , $value) ){
					$err_msg .= $pattern[$key][1].'<br>';
				}
			}
		}
		return $err_msg;
	}
	
	function check_search_form($form_arr = array()){
		//保存错误信息
		$err_msg='';
		
		//订单查询*********************************************************************************************************
		//订单号
		$pattern['order_id'] = array('/^\d{0,8}$/','订单号只能是8位有效数字');
		//下单时间
		$pattern['order_date'] = array('/^(\d{4}-\d{2}-\d{2})?$/', '下单时间的正确格式为2008-01-01。');
		//验证姓名
		$pattern['full_name'] = array('/^[^\'\,\"%*\s?<>\\/\\\\#-]{0,20}$/' , '您输入的收货人姓名格式不正确！');
		//验证email地址
		$pattern['email'] = array('/^([_a-z0-9-]+(\.[a-z0-9]+)?@[a-z0-9-]+\.[a-z0-9]+(\.[a-z0-9]+)?)?$/i' , '您输入的电子邮箱格式不正确！');
		//验证手机号码
		$pattern['mobile'] = array('/^((13\d{9})|((157|158|159|189)\d{8}))?$/', '您输入的手机号码格式不正码');
		//验证固定电话号码
		$pattern['phone'] = array('/^(\d{10,16})?$/', '您输入的电话号码格式不正确');
		//验证地址
		$pattern['province'] =  array('/^[^\'\,\"%*\s?<>\\/\\\\#-]{0,20}$/','请选择所在省');
		$pattern['city'] =  array('/^[^\'\,\"%*\s?<>\\/\\\\#-]{0,20}$/','请选择所在城市');
		$pattern['county'] =  array('/^[^\'\,\"%*?<>\\/\\\\#-]{0,20}$/','请选择所在县');
		$pattern['street'] = array('/^[^\'\,\"%*\s?<>\\/\\\\#-]{0,50}$/','您输入的通讯地址不合法！');
		$pattern['postcode'] = array('/^(\d{0,6})?$/', '您输入的邮编不合法!');

		//配送方式
		$pattern['shipping_id'] = array('/^([^\'\,\"%*\s?<>\\/\\\\#-]{0,20})?$/' , '配送方式中没有这个选项，请检查！');
		//支付方式
		$pattern['pay_way'] = array('/^([^\'\,\"%*\s?<>\\/\\\\#-]{0,20})?$/' , '支付方式中没有这个选项，请检查！');
		//订单状态
		$pattern['order_status'] = array('/^([^\'\,\"%*\s?<>\\/\\\\#-]{0,20})?$/' , '订单状态中没有这个选项，请检查！');
		
		if (!is_array($form_arr))
			return "系统错误：请联系管理员。<br>";
		
		foreach ($form_arr as $key => $value){
			if (!empty($pattern[$key][0])){
				if ( !preg_match($pattern[$key][0] , $value) ){
					$err_msg .= $pattern[$key][1].'<br>';
				}
			}
		}
		return $err_msg;
	}
	
	//job form
	function check_job_form($form_arr = array()){
		$err_msg='';
		//职位名称
		$pattern['job_name'] = array('/^[^\'\,\"%*\s?<>\\/\\\\#-]{2,100}$/','您输入的职位名称不正确！');
		//工作地点
		$pattern['place'] = array('/^[^\'\,\"%*\s?<>\\/\\\\#-]{0,20}$/','您输入的工作地点不正确！');
		//工作性质
		$pattern['nature'] = array('/^1|2|3$/','请选择工作性质！');
		//地址  
		$pattern['address'] = array('/^[^\'\,\"%*\s?<>\\/\\\\#-]{0,100}$/','您输入的公司地址不正确！');
		//邮编 
		$pattern['zip'] = array('/^\d{0,6}$/', '您输入的邮编不合法!');
		//验证email地址
		$pattern['email'] = array('/^([_a-z0-9-]+(\.[a-z0-9]+)?@[a-z0-9-]+\.[a-z0-9]+(\.[a-z0-9]+)?)?$/i' , '您输入的电子邮箱格式不正确！');
		//主要职责
		$pattern['trust'] = array('/^[^<>]{0,500}$/','您输入的主要职责不正确！');
		//任职要求
		$pattern['demand'] = array('/^[^<>]{0,500}$/','您输入的任职要求不正确！');
		
		if (!is_array($form_arr)){
			return "系统错误：请联系管理员。<br>";
		}
		
		foreach ($form_arr as $key => $value){
			if (!empty($pattern[$key][0])){
				if ( !preg_match($pattern[$key][0] , $value) ){
					$err_msg .= $pattern[$key][1].'<br>';
				}
			}
		}
		return $err_msg;
	}
	
	//基本配置验证
	function check_config_form($form_arr = array()){
		$err_msg='';
		
		//站点名称
		$pattern['site_name'] = array('/^[^\'\"%?<>]{0,100}$/', '站点名称必须小于100个有效字符!');
		//站点网址  
		$pattern['site_url'] = array('/^(http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~\^`@\[\]\':+\!]*([^<>\"\"])*)?$/','对不起，您输入的网站地址格式不正确！');
		//服务邮箱  
		$pattern['service_email'] = array('/^([_a-z0-9-]+(\.[a-z0-9]+)?@[a-z0-9-]+\.[a-z0-9]+(\.[a-z0-9]+)?)?$/i' , '您输入的电子邮箱格式不正确！');
		//网站ICP备案号  
		$pattern['site_icp'] = array('/^[^\'\"%?<>]{0,30}$/', '网站ICP备案号格式不正确！');
		//站点Meta关键字  
		$pattern['site_meta_keywords'] = array('/^[^\'\"%?<>]{0,250}$/', 'meta关键字必须小于250个有效字符!');
		//站点Meta描述  
		$pattern['site_meta_desc'] = array('/^[^\'\"%?<>]{0,250}$/', 'meta描述必须小于250个有效字符!');
		//公司名称  
		$pattern['service_company'] = array('/^[^\'\,\"%*\s?<>\\/\\\\#-]{0,100}$/','您输入的公司名称不合法！');
		//地址  
		$pattern['service_address'] = array('/^[^\'\,\"%*\s?<>\\/\\\\#-]{0,100}$/','您输入的通讯地址不合法！');
		//邮编 
		$pattern['service_zip'] = array('/^\d{0,6}$/', '您输入的邮编不合法!');
		//联系电话  
		$pattern['service_phone'] = array('/^(\d{3,4}-\d{7,8}(-\d{1,5})?)?$/', '您输入的联系电话格式不正确');
		//投诉电话  
		$pattern['tousu_phone'] = array('/^(\d{3,4}-\d{7,8}(-\d{1,5})?)?$/', '您输入的联系电话格式不正确');
		//传真号  
		$pattern['service_fax'] = array('/^(\d{3,4}-\d{7,8})?$/', '您输入的传真号格式不正确');
		//400服务电话  
		$pattern['service_phone_400'] = array('/^(400-\d{2,4}-\d{4,5})?$/', '您输入的400服务电话格式不正确');
		//服务QQ号
		$pattern['service_qq'] = array('/^([1-9]\d{5,9})?$/','您输入的QQ号码不正确');
		
		//邮件发送功能设置
		$pattern['email_allow'] = array('/^0|1?$/','是否开启发送邮件功能值非法！');
		$pattern['email_host'] = array('/^[a-zA-Z0-9.]{0,50}$/i','SMTP 服务器填写有误！');
		$pattern['email_port'] = array('/^\d{0,4}?$/','SMTP 端口只能为数字！');
		$pattern['email_from'] = array('/^([_a-z0-9-]+(\.[a-z0-9]+)?@[a-z0-9-]+\.[a-z0-9]+(\.[a-z0-9]+)?)?$/i' , '发件人邮箱格式不正确！');
		$pattern['email_fromname'] = array('/^[^\'\"%?<>]{0,50}$/','发件人名称不正确！');
		$pattern['email_auth'] = array('/^0|1?$/','发送邮件功能是否需要验证的值非法！');
		$pattern['email_user'] = array('/^[^\'\"%?<>]{0,50}?$/','发送邮件功能的验证用户名格式不正确！');
		$pattern['email_psw'] = array('/^[^\'\"%?<>]{0,30}?$/','发送邮件功能的验证密码格式不正确！');
		
		//验证码安全设置
		$pattern['admin_escode'] = array('/^0|1$/','后台登录验证码开关值非法！');
		$pattern['login_escode'] = array('/^0|1$/','会员登录验证码开关值非法！');
		$pattern['register_escode'] = array('/^0|1$/','用户注册验证码开关值非法！');
		
		if (!is_array($form_arr)){
			return "系统错误：请联系管理员。<br>";
		}
		
		foreach ($form_arr as $key => $value){
			if (!empty($pattern[$key][0])){
				if ( !preg_match($pattern[$key][0] , $value) ){
					$err_msg .= $pattern[$key][1].'<br>';
				}
			}
		}
		return $err_msg;
	}
?>
