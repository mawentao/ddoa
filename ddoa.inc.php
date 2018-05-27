<?php
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
require_once dirname(__FILE__)."/class/env.class.php";


try {
	$setting = C::m('#ddoa#ddoa_setting')->get();
	$accessToken = C::m('#ddoa#ddoa_auth')->getAccessToken();

	$message = array (
		'touser' => 'manager7657',
		'toparty' => '1',
		'agentid' => $setting['dd_agent_id'],
		'msgtype' => 'text',
		'text' => array (
			'content' => 'hello world',
		),
	);
	$res = C::m('#ddoa#ddoa_message')->send($accessToken,$message);

die(json_encode($res));


	$departmentId = '1';

	//$res = C::m('#ddoa#ddoa_department')->get($accessToken,$departmentId);
	//$res = C::m('#ddoa#ddoa_department')->getList($accessToken,$departmentId,false);
	//$res = C::m('#ddoa#ddoa_department')->getListParentDeptsByDept($accessToken,$departmentId);

	//$res = C::m('#ddoa#ddoa_user')->simplelist($accessToken,$departmentId);
	//$res = C::m('#ddoa#ddoa_user')->getUserList($accessToken,$departmentId,false);

/*
	$unionid = 'H12AbhXii0Q3GrnrQPNTGCwiEiE';
	$userid = C::m('#ddoa#ddoa_user')->getUseridByUnionid($accessToken,$unionid);

	//$userid = 'manager7657';
	$user = C::m('#ddoa#ddoa_user')->getByUserId($accessToken,$userid);
*/

	die(json_encode($res));

} catch (Exception $e) {
	die($e->getMessage());
}




$jsTicket = C::m('#ddoa#ddoa_auth')->getJsTicket($accessToken);


$href = 'http://139.196.29.35:8008/corp_demo_php/';   //$_GET["href"];

$jsConfig = C::m('#ddoa#ddoa_auth')->getJsConfig($href);

$data = array (
	'accessToken' => $accessToken,
	'jsTicket' => $jsTicket,
);

die(json_encode($jsConfig));

/*
// 登录检查
if(!$_G['uid']){

    //showmessage("to_login", '', array(), array('login' => true));
	$login = ddoa_env::get_siteurl()."/member.php?mod=logging&action=login";
    header("Location: $login");
    exit();
}

// 权限检查
$item = C::t('#ddoa#ddoa_user_audit')->getByUid($_G['uid']);
if (empty($item) || $item['audit_status']!=0) {
	//echo "很抱歉,您没有权限访问此页面,请联系管理员开通权限!";
	//exit();
}
*/
// 设置
$plugin_path = ddoa_env::get_plugin_path();
$filename = basename(__FILE__);
list($controller) = explode('.',$filename);
include template("ddoa:".strtolower($controller));
ddoa_env::getlog()->trace("pv[".$_G['username']."|uid:".$_G['uid']."]");
C::t('#ddoa#ddoa_log')->write("visit ddoa:ddoa");
