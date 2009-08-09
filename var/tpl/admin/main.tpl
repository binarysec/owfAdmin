{css '/data/admin/css/screen.css'}

{css '/data/yui/build/reset-fonts-grids/reset-fonts-grids.css'}
{css '/data/yui/build/menu/assets/skins/sam/menu.css'}
{css '/data/yui/build/resize/assets/skins/sam/resize.css'}
{css '/data/yui/build/layout/assets/skins/sam/layout.css'}

{js '/data/yui/build/utilities/utilities.js'}
{js '/data/yui/build/container/container_core-min.js'} 
{js '/data/yui/build/menu/menu-min.js'}

{js '/data/admin/btn.js'}

<div id="top" class="admin_top">
	<img src="{link '/data/logo.png'}"/>
	<center>
	<div id="general_menu" class="yuimenubar yuimenubarnav">
	
	{$navigation}
	
	</div>
	
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

