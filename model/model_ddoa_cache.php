<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
/**
 * 缓存
 **/
class model_ddoa_cache
{
	const ddoa_cache_prefix = 'ddoacache_';

	// 存储缓存
	public function set($k,$v)
	{/*{{{*/
		$cachename = self::ddoa_cache_prefix.$k;
		$data = $v;
		savecache($cachename, $data);
	}/*}}}*/

	// 获取缓存
	public function get($k)
	{/*{{{*/
		global $_G;
		$cachename = self::ddoa_cache_prefix.$k;
		if (isset($_G['cache'][$cachename])) {
			return $_G['cache'][$cachename];
		}
		loadcache($cachename, $force=false);
		if (isset($_G['cache'][$cachename])) {
			return $_G['cache'][$cachename];
		} else {
			return null;
		}
	}/*}}}*/

}
// vim600: sw=4 ts=4 fdm=marker syn=php
?>
