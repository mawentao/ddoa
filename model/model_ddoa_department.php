<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
/**
 * 钉钉部门模块
 **/
class model_ddoa_department
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
	 * 获取部门列表
	 * $parentDeptId: 父部门ID(1为根部门id)
     * $recursion: 是否递归部门的全部子部门，ISV微应用固定传递false。
     * https://open-doc.dingtalk.com/docs/doc.htm?spm=a219a.7629140.0.0.0RKSOt&treeId=385&articleId=106817&docType=1#s1
	 **/
	public function getList($accessToken,$parentDeptId=1,$recursion=false)
	{/*{{{*/
		$params = array (
			'access_token' => $accessToken,
			'id' => $parentDeptId,
			'fetch_child' => $recursion,
		);
		$response = $this->http->get("/department/list",$params);
		$this->check($response);
        return $response;
	}/*}}}*/

	/**
	 * 获取部门详情
     * https://open-doc.dingtalk.com/docs/doc.htm?spm=a219a.7629140.0.0.UUfTxs&treeId=385&articleId=106817&docType=1#s2
	 **/
	public function get($accessToken,$deptId)
	{/*{{{*/
		$params = array (
			'access_token' => $accessToken,
			'id' => $deptId,
		);
		$response = $this->http->get("/department/get",$params);
		$this->check($response);
        return $response;
	}/*}}}*/

	/**
	 * 查询部门的所有上级父部门路径
	 **/
	public function getListParentDeptsByDept($accessToken,$deptId)
	{/*{{{*/
		$params = array (
			'access_token' => $accessToken,
			'id' => $deptId,
		);
		$response = $this->http->get("/department/list_parent_depts_by_dept",$params);
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
