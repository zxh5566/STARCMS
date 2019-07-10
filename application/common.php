<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

// 设置异常错误报错级别，关闭notice错误
error_reporting(E_ALL ^ E_NOTICE);
use phpmailer\PHPMailer;
use think\Db;
use util\Auth;
use app\admin\model\Config as ConfigModel;

/**
 * curl访问
 * @author rainfer <81818832@qq.com>
 * @param  string $url
 * @param string $type
 * @param boolean $data
 * @param string $err_msg
 * @param int $timeout
 * @param array $cert_info
 * @return string
 */
function go_curl($url, $type, $data = false, &$err_msg = null, $timeout = 20, $cert_info = array())
{
	$type = strtoupper($type);
    if ($type == 'GET' && is_array($data)) {
        $data = http_build_query($data);
    }
    $option = array();
    if ( $type == 'POST' ) {
        $option[CURLOPT_POST] = 1;
    }
    if ($data) {
        if ($type == 'POST') {
            $option[CURLOPT_POSTFIELDS] = $data;
        } elseif ($type == 'GET') {
            $url = strpos($url, '?') !== false ? $url.'&'.$data :  $url.'?'.$data;
        }
    }
    $option[CURLOPT_URL]            = $url;
    $option[CURLOPT_FOLLOWLOCATION] = TRUE;
    $option[CURLOPT_MAXREDIRS]      = 4;
    $option[CURLOPT_RETURNTRANSFER] = TRUE;
    $option[CURLOPT_TIMEOUT]        = $timeout;
    //设置证书信息
    if(!empty($cert_info) && !empty($cert_info['cert_file'])) {
        $option[CURLOPT_SSLCERT]       = $cert_info['cert_file'];
        $option[CURLOPT_SSLCERTPASSWD] = $cert_info['cert_pass'];
        $option[CURLOPT_SSLCERTTYPE]   = $cert_info['cert_type'];
    }
    //设置CA
    if(!empty($cert_info['ca_file'])) {
        // 对认证证书来源的检查，0表示阻止对证书的合法性的检查。1需要设置CURLOPT_CAINFO
        $option[CURLOPT_SSL_VERIFYPEER] = 1;
        $option[CURLOPT_CAINFO] = $cert_info['ca_file'];
    } else {
        // 对认证证书来源的检查，0表示阻止对证书的合法性的检查。1需要设置CURLOPT_CAINFO
        $option[CURLOPT_SSL_VERIFYPEER] = 0;
    }
    $ch = curl_init();
    curl_setopt_array($ch, $option);
    $response = curl_exec($ch);
    $curl_no  = curl_errno($ch);
    $curl_err = curl_error($ch);
    curl_close($ch);
    // error_log
    if($curl_no > 0) {
        if($err_msg !== null) {
            $err_msg = '('.$curl_no.')'.$curl_err;
        }
    }
    return $response;
}

/**
 * 发送邮件 //sendMail("1045746362@qq.com", "发邮件测试", "phpmailer测试");
 * @author rainfer <81818832@qq.com>
 * @param string $to 收件人邮箱
 * @param string $title 标题
 * @param string $content 内容
 * @return array
 */
function sendMail($to, $title, $content)
{
    $mail = new PHPMailer(); //实例化
	$mails = array();
	$mails = Db::name('options')->where('id',1)->value('option_val');
	if($mails){
		$mails = json_decode($mails,true);
	}
	//是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
	//$mail->SMTPDebug = 1;
	// 设置PHPMailer使用SMTP服务器发送Email
	$mail->IsSMTP();
	$mail->Mailer='smtp';
	$mail->IsHTML(true);
	// 设置邮件的字符编码，若不指定，则为'UTF-8'
	$mail->CharSet='UTF-8';
	// 添加收件人地址，可以多次使用来添加多个收件人
	$mail->AddAddress($to);
	// 设置邮件正文
	$mail->Body=$content;
	// 设置邮件头的From字段。
	$mail->From=$mails['email_name'];
	// 设置发件人名字
	$mail->FromName=$mails['email_rename'];
	// 设置邮件标题
	$mail->Subject=$title;
	//$mail->SMTPAuth=true;
	// 设置SMTP服务器。
	$mail->Host=$mails['email_smtpname'];
	//by Rainfer
	// 设置SMTPSecure。
	$mail->SMTPSecure=$mails['email_smtpsecure'];
	// 设置SMTP服务器端口。
	$mail->Port=$mails['email_port'];
	// 设置为"需要验证"
	$mail->SMTPAuth=true;
	// 设置用户名和密码sgwmuevljkmvbcci。
	$mail->Username=$mails['email_emname'];
	$mail->Password=$mails['email_pwd'];
	// 发送邮件。
	if(!$mail->Send()) {
		$mailerror=$mail->ErrorInfo;
		return array("error"=>1,"message"=>$mailerror);
	}else{
		return array("error"=>0,"message"=>"success");
	}
}
// 自定义success助手函数
function success($msg = '成功', $url = '')
{
    $data['status'] = 200;
    $data['msg'] = $msg;
    $data['url'] = $url;
    return json($data);
}
// 自定义successIframe助手函数
function successIframe($msg = '成功', $url = '')
{
    $data['status'] = 201;
    $data['msg'] = $msg;
    return json($data);
}
// 自定义error助手函数
function error($msg = '失败', $url = '')
{
    $data['status'] = 202;
    $data['msg'] = $msg;
    $data['url'] = $url;
    return json($data);
}
// 判断权限
function checkAuth() {
    if(!in_array(session('uid'), explode(',',config('auth_superadmin')))){
        $auth = new Auth();
        $rule = strtolower(request()->module().'/'.request()->controller().'/'.request()->action());
        return $auth->check($rule, session('uid'));
    }else{
        return true;
    }
}
/**
 * [table_exists 检测数据表是否存在]
 * @param  string $tablename [表名，不含前缀]
 * @return [bool]            [存在返回true，不存在返回false]
 */
function table_exists($tablename='')
{
    //获取所有数据表名
    $tables = array();
    $data = Db::query('SHOW TABLES');
    foreach ($data as $value) {
        $tables[] = $value['Tables_in_'.config('database.database')];
    }
    //获取表前缀
    $dbPrefix = config('database.prefix');
    //当前的表名
    $tablename=$dbPrefix.$tablename;
    if(in_array($tablename,$tables)){
        return true; //存在
    }else {
        return false; //不存在
    }
}

/**
 * [field_exists 检测数据表字段是否存在]
 * @param  string $tablename [表名，不含前缀]
 * @param  string $field [字段名]
 * @return [bool]            [存在返回true，不存在返回false]
 */
function field_exists($tablename='', $field='')
{
    //获取表前缀
    $dbPrefix = config('database.prefix');
    //先判断数据表是否存在
    if(table_exists($tablename)){
        $fieldArray = Db::query("Describe `{$dbPrefix}{$tablename}` `{$field}` ;");
        if(is_array($fieldArray[0])){
            return true; //存在
        }else {
            return false; //不存在
        }
    }else {
        return false;  //不存在
    }
}

// 根据分类ID获取相应分类信息
function getCatInfoById($id=0, $field=''){
    if($field == ''){
        //获取单条数据
        return Db::name('category')->where('id',$id)->find();
    }else{
        //获取某个字段
        return Db::name('category')->where('id',$id)->value($field);
    }
}

// 根据分类ID获取相应模型信息
function getModInfoById($id=0, $field=''){
    //模型ID、
    $modelId = getCatInfoById($id, 'modelid');
    if($field == ''){
        //获取单条数据
        return Db::name('models')->where('id',$modelId)->find();
    }else{
        //获取某个字段
        return Db::name('models')->where('id',$modelId)->value($field);
    }
}


//生成列表页
function createCategory($tablename,$catid){
    $count = Db::name($tablename)->where('catid', $catid)->count();
	if($count){
		$configlist = ConfigModel::column('varname,value');
		$pagenums = $configlist['pnums'];
		$num = ceil($count/$pagenums); //进一取整函数
		for($i = 1; $i<$num+1; $i++){
			$visitUrl = 'category/id/'.$catid.'?page='.$i;
			$createName = 'category_'.$catid.'_'.$i.'.shtml';
			createHtml($visitUrl, $createName, true, $catid);
		}
	}else{
		$visitUrl = 'category/id/'.$catid;
		$createName = 'category_'.$catid.'_1.shtml';
		createHtml($visitUrl, $createName);
	}
}

//生成详情页
function createInfo($id,$catid){
    $visitUrl = 'info/id/'.$id.'/catid/'.$catid;
    $createName = 'show_'.$catid.'_'.$id.'.shtml';
    createHtml($visitUrl, $createName);
}

//生成静态页面
function createHtml($visitUrl, $createName, $hasPage = false, $catid = 0){
	    $domain = "http://" . input('server.HTTP_HOST');
        $url = $domain . '/index.php/index/index/' . $visitUrl; //动态页面地址
		$fn = ROOT_PATH . 'public/html/' . $createName; //生成文件名
        $content = getFile($url);
		$regex = '/index\.php\/index\/index\/info\/catid\/(\d+)\/id\/(\d+)\.html/iU';
		$replacement = 'public/html/show_$1_$2.shtml';
		$content = preg_replace($regex,$replacement,$content);
		$regex = '/index\.php\/index\/index\/category\/id\/(\d+)\.html/iU';
		$replacement = 'public/html/category_$1_1.shtml';
		$content = preg_replace($regex,$replacement,$content);

        $fs = fopen($fn, 'w');
        fwrite($fs, $content);
    }
	
function getFile($url=''){
	$ch = curl_init();
	$timeout = 10; // set to zero for no timeout
	curl_setopt ($ch, CURLOPT_URL,$url);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$str = curl_exec($ch);
	return $str;
}