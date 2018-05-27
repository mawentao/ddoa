<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
/**
 * 插件设置 
 * C::m('#ddoa#ddoa_setting')->get()
 **/
class model_ddoa_setting
{
	// 获取默认配置
    public function getDefault()
    {
		$setting = array (
			// 屏蔽所有discuz页面
			'disable_discuz' => 0,
			// 系统名称
			'page_title' => 'ddoa',
			// 版权信息
			'page_copyright' => 'ddoa.com 2017',

			// 钉钉开发帐号配置
			'dd_oapi_host' => 'https://oapi.dingtalk.com',
			'dd_corp_id' => '',
			'dd_corp_secret' => '',
			'dd_agent_id' => '',   //!< 在创建微应用时分配
		);
		return $setting;
    }

    // 获取配置
	public function get()
	{
		$setting = $this->getDefault();
		global $_G;
		if (isset($_G['setting']['ddoa_config'])){
			$config = unserialize($_G['setting']['ddoa_config']);
			foreach ($setting as $key => &$item) {
				if (isset($config[$key])) $item = $config[$key];
			}
		}
		return $setting;
	}
}
// vim600: sw=4 ts=4 fdm=marker syn=php
?>
