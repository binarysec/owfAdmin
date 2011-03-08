%{css '/data/admin/css/screen.css'}%

%{js '/data/yui/build/utilities/utilities.js'}%
%{js '/data/yui/build/container/container_core-min.js'}% 
%{js '/data/yui/build/menu/menu-min.js'}%

%{js '/data/admin/btn.js'}%

<div id="center1" class="admin_top">

<div align="right">
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="20" height="20" style="background:url('%{link '/data/admin/img/corner_language_left.gif'}%');">&nbsp;</td>
    <td height="20" bgcolor="#A10E09">
%{foreach $langs as $code => $infos}%
	%{if $code != $current_lang_code}%
		<a href="%{link $_URI, $infos['code']}%">
	%{/if}%
		<img src="%{link '/data/admin/img/flags/small/'.$code.'.gif'}%" alt="%{$infos['name']}%" title="%{$infos['name']}%"%{if $code == $current_lang_code}% class="selected"%{/if}% />
	%{if $code != $current_lang_code}%
		</a>
	%{/if}%
%{/foreach}%
    </td>
    <td width="5" height="20" style="background:url('%{link '/data/admin/img/corner_language_right.gif'}%');">&nbsp;</td>
  </tr>
</table>
</div>


<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="5" height="103" rowspan="2" style="background:url('%{link '/data/admin/img/corner_baner_left.gif'}%');">&nbsp;</td>
    <td width="343" rowspan="2"><img src="%{link '/data/admin/img/logo.png'}%" alt="Accueil" width="343" height="103" /></td>
    <td rowspan="2" bgcolor="#A10E09">&nbsp;</td>
    <td width="20" height="80" bgcolor="#A10E09">&nbsp;</td>
    <td width="148" height="80" bgcolor="#A10E09">&nbsp;</td>
    <td width="390" height="80" colspan="4" style="background:url(%{link '/data/admin/img/map.gif'}%) right center no-repeat; background-color: #A10E09;" valign="top" align="right">
	<div class="admin_session_top">
	%{if is_array($user_perm['session:god'])}%
	<img src="%{link '/data/session/t_god.png'}%" alt="%{@ 'Administrateur'}%" title="%{@ 'Administrateur'}%"/>
	%{elseif is_array($user_perm['session:admin'])}%
	<img src="%{link '/data/session/t_admin.png'}%" alt="%{@ 'Administrateur'}%" title="%{@ 'Administrateur'}%"/>
	%{elseif is_array($user_perm['session:simple'])}%
	<img src="%{link '/data/session/t_simple.png'}%" alt="%{@ 'Utilisateur'}%" title="%{@ 'Utilisateur'}%"/>
	%{/if}%
	
	%{@ 'Bienvenue, <strong>%s</strong> (%s)', htmlentities($user['name']), htmlentities($user['email'])}%
	<a href="%{link '/session/logout'}%"> 
	<img border="0" src="%{link '/data/admin/img/session_exit.png'}%" title="%{@ 'Déconnexion'}%" alt="%{@ 'Déconnexion'}%" />
	</a>
	%{$page_topbar}%
	</div>
    </td>

  </tr>
  <tr>
    <td width="20" height="23" style="background:url('%{link '/data/admin/img/corner_menu_left.gif'}%');">&nbsp;</td>
    <td width="610" height="23" colspan="5" bgcolor="#000000">
	<div id="general_menu" class="admin_gen_menu">
	
	%{$navigation}%
	
	</div>
    </td>
  </tr>
  <tr>
    <td height="2" colspan="9" bgcolor="#000000"></td>
  </tr>
</table>


</div>

<div id="center2" class="admin_center">
%{$body}%
</div>

<div id="center3" class="admin_bottom">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="5" height="20" style="background:url('%{link '/data/admin/img/corner_foot_left.gif'}%');"></td>
		<td height="20" bgcolor="#FFFFFF">Copyright <a href="http://binarysec.com" target="_blank">BinarySEC</a> 2006-2011%{$bottom}%</td>
		<td width="5" height="20" style="background:url('%{link '/data/admin/img/corner_foot_right.gif'}%');"></td>
	</tr>
</table>
</div>

%{literal}%
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
%{/literal}%

