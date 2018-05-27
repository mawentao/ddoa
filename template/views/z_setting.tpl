<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title></title>
  <link rel="stylesheet" href="<%plugin_path%>/template/libs/mwt/4.0/mwt.min.css" type="text/css">
  <link rel="stylesheet" href="<%plugin_path%>/template/views/misadmin.css" type="text/css">
  <script src="<%plugin_path%>/template/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="<%plugin_path%>/template/libs/mwt/4.0/mwt.min.js"></script>
  <%js_script%>
  <script>
    var jq=jQuery.noConflict();
    jq(document).ready(function($) {
        jQuery("input[name=disable_discuz][value="+v.disable_discuz+"]").attr("checked",true);
        jQuery('#page_title').val(v.page_title);
        jQuery('#page_copyright').val(v.page_copyright);

		var segs = [
			'dd_oapi_host','dd_corp_id','dd_corp_secret','dd_agent_id'
		];
		for (var i=0;i<segs.length;++i) {
			var k = segs[i];
			jQuery('#'+k).val(v[k]);
		}
    });
  </script>
</head>
<body>
  <form method="post" action="admin.php?action=plugins&operation=config&identifier=ddoa&pmod=z_setting">
  <!-- 使用提示 -->
  <table class="tb tb2">
    <tr><th colspan="15" class="partition">使用提示</th></tr>
    <tr><td class="tipsblock" s="1">
      <ul id="lis">
        <li>系统地址：<a href="<%siteurl%>/plugin.php?id=ddoa" target="_blank"><%siteurl%>/plugin.php?id=ddoa</a></li>
      </ul>
    </td></tr>
  </table>
  <!-- 全局设置 -->
  <table class="tb tb2">
    <tr><th colspan="15" class="partition">全局设置</th></tr>
    <tr>
      <td width='90'>屏蔽discuz：</td>
      <td width='300'>
	    <label><input name="disable_discuz" type="radio" value="1"> 是</label>
        &nbsp;&nbsp;
	    <label><input name="disable_discuz" type="radio" value="0"> 否</label>
      </td>
      <td class='tips2'>选'是'所有discuz页面都将跳转到插件页面</td>
    </tr>
	<tr>
	  <td>页面标题：</td>
      <td><input type="text" id="page_title" name="page_title" class="txt" style="width:96%"></td>
	  <td class='tips2'>系统名称</td>
	</tr>
	<tr>
	  <td>版权信息：</td>
      <td><input type="text" id="page_copyright" name="page_copyright" class="txt" style="width:96%"></td>
	  <td class='tips2'>版权信息</td>
	</tr>
    <tr><th colspan="15" class="partition">钉钉开发帐号设置</th></tr>
	<tr>
	  <td>OAPI_HOST：</td>
      <td><input type="text" id="dd_oapi_host" name="dd_oapi_host" class="txt" style="width:96%"></td>
	  <td class='tips2'>钉钉API地址 <a href="https://open-doc.dingtalk.com/docs/doc.htm?spm=0.0.0.0.NBNfMx&treeId=385&articleId=104981&docType=1" target="_blank">钉钉服务端开发文档</a></td>
	</tr>
	<tr>
	  <td>CorpId：</td>
      <td><input type="text" id="dd_corp_id" name="dd_corp_id" class="txt" style="width:96%"></td>
	  <td class='tips2'>CorpID是企业在钉钉中的标识，每个企业拥有一个唯一的CorpID</td>
	</tr>
	<tr>
	  <td>CorpSecret：</td>
      <td><input type="text" id="dd_corp_secret" name="dd_corp_secret" class="txt" style="width:96%"></td>
	  <td class='tips2'><a href="http://open-dev.dingtalk.com/#/corpAuthInfo-corp" target="_blank">如何获取CorpId和CorpSecret</a></td>
	</tr>
	<tr>
	  <td>AgentId：</td>
      <td><input type="text" id="dd_agent_id" name="dd_agent_id" class="txt" style="width:96%"></td>
	  <td class='tips2'>企业微应用id <a href="https://oa.dingtalk.com/index.htm#/microApp/microAppList" target="_blank">微应用列表</a></td>
	</tr>
    <tr>
      <td colspan="3">
		<input type="hidden" id="reset" name="reset" value="0"/>
        <input type="submit" id='subbtn' class='btn' value="保存设置"/>
        &nbsp;&nbsp;
		<input type="submit" class='btn' onclick="jQuery('#reset').val(1);" value="恢复默认设置"/>
      </td>
    </tr>
  </table>
  </form>
</body>
</html>
