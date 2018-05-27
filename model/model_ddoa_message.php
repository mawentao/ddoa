<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
/**
 * 钉钉消息模块
 **/
class model_ddoa_message
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
	 * 发送消息
	 * $message的结构见如下API接口说明
     * https://open-doc.dingtalk.com/docs/doc.htm?spm=a219a.7629140.0.0.NSnDxc&treeId=374&articleId=104973&docType=1#s2
	 **/
	public function send($accessToken,$message=array())
	{/*{{{*/
		$params = array (
			'access_token' => $accessToken,
		);
		$response = $this->http->post("/message/send",$params,$message);
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
