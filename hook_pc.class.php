<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
require_once dirname(__FILE__).'/class/env.class.php';

class plugin_ddoa
{
    public function common()
    {
		global $_G;
		// 未开启屏蔽其他页面开关
		$setting = C::m('#ddoa#ddoa_setting')->get();
		if (!$setting['disable_discuz']) return;
		// 登录页面不屏蔽
		if (strpos($_SERVER['PHP_SELF'],"member.php")!==false && isset($_GET['mod']) && $_GET['mod']=="logging") {
			return;
		}
		// 只允许打开以下插件页面
		$enable_pluginids = array(
			'ddoa',
		);
		if (strpos($_SERVER['PHP_SELF'],"plugin.php")!==false && isset($_GET['id']) && in_array($_GET['id'],$enable_pluginids)) {
			return;
		}
		// 启用SEO设置的处理
		$ddoa_url = ddoa_env::get_siteurl()."/plugin.php?id=ddoa";
		if (in_array('plugin',$_G['setting']['rewritestatus'])) {
			$ddoa_url = ddoa_env::get_siteurl()."/ddoa-ddoa.html";
			foreach ($enable_pluginids as $plugin) {
				if (preg_match("/$plugin-[\w]*\.html$/i",$_SERVER['REQUEST_URI'])) {
					return;
				}
			}
		}
		// 跳转到本插件页面
		header("Location: $ddoa_url");
		exit(0);
    }
}

