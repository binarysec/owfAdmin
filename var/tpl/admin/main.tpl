{css '/data/admin/css/screen.css'}
{css '/data/admin/css/new_v2.css'}


{js '/data/yui/build/utilities/utilities.js'}
{js '/data/yui/build/container/container_core-min.js'} 
{js '/data/yui/build/menu/menu-min.js'}

{js '/data/admin/btn.js'}

<div id="admin_top" class="admin_top">
<table cellpadding="0" cellspacing="0">
	<tr>
	<td>
		<div id="logo">
			<a href="/"><img src="{link '/data/admin/img/logo.png'}" alt="Accueil" width="100" height="30" /></a>
		</div>
	</td>
	<td>
		<div id="general_menu" class="admin_gen_menu">		
			{$navigation}	
		</div>
	</td>
	<td>
		<div id="lang_menu">
			{foreach $langs as $code => $infos}
				{if $code != $current_lang_code}
					<a href="{link $_URI, $infos['code']}" alt="{$infos['name']}">
				{/if}
					<img src="{link '/data/admin/img/flags/small/'.$code.'.gif'}" alt="{$infos['name']}" title="{$infos['name']}"{if $code == $current_lang_code} class="selected"{/if} />
				{if $code != $current_lang_code}
					</a>
				{/if}
			{/foreach}
		</div>
	</td>
	</tr>
</table>
{@ '<strong>%s</strong>', htmlentities($user['name'])}

</div>

<div id="admin_center" class="admin_center">
{$body}
</div>

<div id="admin_bottom" class="admin_bottom">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="5" height="20" background="{link '/data/admin/img/corner_foot_left.gif'}"></td>
		<td height="20" bgcolor="#FFFFFF">Copyright <a href="http://binarysec.com" target="_blank">BinarySEC</a> 2006-2009{$bottom}</td>
		<td width="5" height="20" background="{link '/data/admin/img/corner_foot_right.gif'}"></td>
	</tr>
</table>
</div>

{literal}
<script type="text/javascript">
(function() {
	var Dom = YAHOO.util.Dom;
	var Event = YAHOO.util.Event;

	var initTopMenu = function() {
		var oMenuBar = new YAHOO.widget.MenuBar("general_menu", { 
			autosubmenudisplay: true, 
			hidedelay: 750, 
			lazyload: true,
			effect: { 
				effect: YAHOO.widget.ContainerEffect.FADE,
				duration: 0.25
			} 
		});
		oMenuBar.render();
	};
	
	YAHOO.util.Event.onContentReady("general_menu", initTopMenu);
})();

</script>
{/literal}

