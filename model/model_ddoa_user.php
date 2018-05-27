<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
/**
 * 钉钉用户模块
 **/
class model_ddoa_user
{
	private $setting;
	private $http;
	private $cache;
	private $auth;

	public function __construct() {
		$this->setting = C::m('#ddoa#ddoa_setting')->get();
		$this->http = C::m('#ddoa#ddoa_http');
		$this->cache = C::m('#ddoa#ddoa_cache');
		$this->auth = C::m('#ddoa#ddoa_auth');
	}

	/**
	 * 根据CODE换取用户身份
	 * https://open-doc.dingtalk.com/docs/doc.htm?spm=a219a.7629140.0.0.ZBfprx&treeId=385&articleId=104969&docType=1#s0
	 **/
	public function getUserInfo($accessToken, $code)
	{/*{{{*/
		$params = array (
			'access_token' => $accessToken,
			'code' => $code,
		);
		$response = $this->http->get("/user/getuserinfo",$params);
		$this->check($response);
        return $response;
	}/*}}}*/

	/**
     * 根据unionid获取成员的userid
     * https://open-doc.dingtalk.com/docs/doc.htm?spm=a219a.7629140.0.0.aDYxvh&treeId=385&articleId=106816&docType=1#s8
     **/
	public function getUseridByUnionid($accessToken, $unionid)
	{/*{{{*/
		$params = array (
			'access_token' => $accessToken,
			'unionid' => $unionid,
		);
		$response = $this->http->get("/user/getUseridByUnionid",$params);
		$this->check($response);
        return $response['userid'];
	}/*}}}*/

	/**
     * 获取成员详情
     * https://open-doc.dingtalk.com/docs/doc.htm?spm=a219a.7629140.0.0.ZHno3Z&treeId=385&articleId=106816&docType=1#s0
     **/
	public function getByUserId($accessToken, $userId)
	{/*{{{*/
		$params = array (
			'access_token' => $accessToken,
			'userid' => $userId,
		);
		$response = $this->http->get("/user/get",$params);
		$this->check($response);
        return $response;
	}/*}}}*/


	/**
     * 获取部门成员列表
	 * https://open-doc.dingtalk.com/docs/doc.htm?spm=a219a.7629140.0.0.8OysBE&treeId=385&articleId=106816&docType=1#s6
     **/
	public function getUserList($accessToken,$departmentId,$simple=true) 
	{/*{{{*/
		$params = array (
			'access_token' => $accessToken,
			'department_id' => $departmentId,
		);
		$api = $simple ? '/user/simplelist' : '/user/list';
		$response = $this->http->get($api,$params);
		$this->check($response);
        return $response;
	}/*}}}*/
	


	/**
	 * 获取部门成员
	 * https://open-doc.dingtalk.com/docs/doc.htm?spm=a219a.7629140.0.0.yXC4No&treeId=385&articleId=106816&docType=1#s5
	 **/
	public function simplelist($accessToken,$departmentId) 
	{/*{{{*/
		$params = array (
			'access_token' => $accessToken,
			'department_id' => $departmentId,
		);
		$response = $this->http->get("/user/simplelist",$params);
		$this->check($response);
        return $response;
	}/*}}}*/
	


	private function check($response)
	{/*{{{*/
		if ($response['errcode']!=0) {
			throw new Exception($response['errmsg']);
		}
	}/*}}}*/

}
// vim600: sw=4 ts=4 fdm=marker syn=php
?>
