{css '/data/admin/css/screen.css'}

{css '/data/yui/build/reset-fonts-grids/reset-fonts-grids.css'}
{css '/data/yui/build/menu/assets/skins/sam/menu.css'}
{css '/data/yui/build/layout/assets/skins/sam/layout.css'}

{js '/data/yui/build/utilities/utilities.js'}
{js '/data/yui/build/container/container_core-min.js'} 
{js '/data/yui/build/menu/menu-min.js'}

{js '/data/admin/btn.js'}

<div id="center" class="admin_top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="337" align="left" background="{link '/data/admin/img/back_red.png'}">
				<a href="{link '/admin'}"><img src="{link '/data/admin/img/logo.png'}"></a>
			</td>
		
			<td align="right" valign="top" background="{link '/data/admin/img/back_red.png'}">
			</td>
	
			<td width="100%" align="right" valign="bottom" background="{link '/data/admin/img/back_red.png'}">
				<img src="{link '/data/admin/img/left_bottom_banner_rounded.png'}" width="14" height="8">
			</td>
		</tr>
	</table>
	
	<!-- Header Menu -->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
		<tr>
		<td>
		<table width="100%"  border="0" cellspacing="0" cellpadding="0">
			<tr>
			<td width="9">
				<img src="{link '/data/admin/img/menu/back_01.png'}">
			</td>
			<td align="left" background="{link '/data/admin/img/menu/back_02.png'}">
				<div id="general_menu" class="yuimenubar yuimenubarnav">
				
				{$navigation}
				
				</div>
				
			</td>
			<td width="9">
				<img src="{link '/data/admin/img/menu/back_03.png'}">
			</td>
			</tr>
		</table>
		</td>
		</tr>
	</table>

</div>

<div id="center" class="admin_center">
{$body}
</div>

<div id="bottom">Copyright <a href="http://binarysec.com" target="_blank">BinarySEC</a> 2009{$bottom}</div>

{literal}
<script>
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

