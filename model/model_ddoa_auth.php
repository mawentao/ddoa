<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
/**
 * 钉钉鉴权控制
 * C::m('#ddoa#ddoa_auth')->get()
 **/
class model_ddoa_auth
{
	private $setting;
	private $http;
	private $cache;

	public function __construct() {
		$this->setting = C::m('#ddoa#ddoa_setting')->get();
		$this->http = C::m('#ddoa#ddoa_http');
		$this->cache = C::m('#ddoa#ddoa_cache');
	}


	/**
	 * 通过企业的CorpId、CorpSecret换取到企业与钉钉进行数据交换用到的access_token
	 **/
	public function getAccessToken()
	{/*{{{*/
		$accessToken = $this->cache->get('corp_access_token');
		if (empty($accessToken) || $accessToken['expires_time']<=time()) {
			$corpid = $this->setting['dd_corp_id'];
			$corpsecret = $this->setting['dd_corp_secret'];
			$response = $this->http->get('/gettoken', array('corpid'=>$corpid, 'corpsecret'=>$corpsecret));
			$this->check($response);
			$accessToken = array (
				'access_token' => $response['access_token'],
				'expires_time' => time() + intval($response['expires_in']) - 60,
			);
			$this->cache->set('corp_access_token',$accessToken);
		}
		//print_r($accessToken);
		return $accessToken['access_token'];
	}/*}}}*/

	/** 
     * 获取JsTicket
     */
    public function getJsTicket($accessToken)
    {/*{{{*/
		$data = $this->cache->get('js_ticket');
		if (empty($data) || $data['expires_time']<=time()) {
            $response = $this->http->get('/get_jsapi_ticket', array('type' => 'jsapi', 'access_token' => $accessToken));
            $this->check($response);
			$data = array (
				'jsticket' => $response['ticket'],
				'expires_time' => time() + intval($response['expires_in']) - 60,
			);
			$this->cache->set('js_ticket',$data);
        }   
//		print_r($data);
        return $data['jsticket'];
    }/*}}}*/

	/**
     * 计算签名
     **/
	public function sign($ticket, $nonceStr, $timeStamp, $url)
    {/*{{{*/
        $plain = 'jsapi_ticket=' . $ticket .
            '&noncestr=' . $nonceStr .
            '&timestamp=' . $timeStamp .
            '&url=' . $url;
        return sha1($plain);
    }/*}}}*/


	/**
     * 获取Js配置
     **/
	public function getJsConfig($href)
    {/*{{{*/
        $corpId = $this->setting['dd_corp_id'];
        $agentId = $this->setting['dd_agent_id'];
        $nonceStr = 'ddoa_x23MxI2';
        $timeStamp = time();
        $url = urldecode($href);
        $corpAccessToken = $this->getAccessToken();
        $ticket = $this->getJsTicket($corpAccessToken);
        $signature = $this->sign($ticket, $nonceStr, $timeStamp, $url);
 
        $config = array(
            'url' => $url,
            'nonceStr' => $nonceStr,
            'agentId' => $agentId,
            'timeStamp' => $timeStamp,
            'corpId' => $corpId,
            'signature' => $signature,
		);
        return $config;
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
