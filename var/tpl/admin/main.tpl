%{css '/data/admin/css/screen.css'}%
%{css '/data/css/jquery-ui-base.css'}%
%{js '/data/js/jquery-1.5.js'}%
%{js '/data/js/jquery-ui-1.8.js'}%
%{js '/data/admin/ddsmoothmenu.js'}%

<script type="text/javascript">



// alert($(".ui-widget").css("background-color"));

ddsmoothmenu.init({
	mainmenuid: "adm_menu", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'adm_menu_top', //class added to menu's outer DIV
	customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
});

$(document).ready(function() {


// 	$(".adm_content_title").addClass("ui-corner-all");



});



</script>

<center>

<table id="adm_top" border="0" cellpadding="2" cellspacing="0" width="800px">

<tr>
	<td>
		<div id="adm_logo">
		Open Web Framework
		</div>
	</td>
	<td align="right">
		<div id="adm_language">
			%{foreach $langs as $code => $infos}%
				%{if $code != $current_lang_code}%
					<a href="%{link $_URI, $infos['code']}%">
				%{/if}%
					<img src="%{link '/data/admin/img/flags/small/'.$code.'.gif'}%" alt="%{$infos['name']}%" title="%{$infos['name']}%"%{if $code == $current_lang_code}% class="selected"%{/if}% />
				%{if $code != $current_lang_code}%
					</a>
				%{/if}%
			%{/foreach}%
		</div>

		<div id="adm_session">
			%{if is_array($user_perm['session:god'])}%
				<img src="%{link '/data/session/t_god.png'}%" alt="%{@ 'Administrateur'}%" title="%{@ 'Administrateur'}%"/>
			%{elseif is_array($user_perm['session:admin'])}%
				<img src="%{link '/data/session/t_admin.png'}%" alt="%{@ 'Administrateur'}%" title="%{@ 'Administrateur'}%"/>
			%{elseif is_array($user_perm['session:simple'])}%
				<img src="%{link '/data/session/t_simple.png'}%" alt="%{@ 'Utilisateur'}%" title="%{@ 'Utilisateur'}%"/>
			%{/if}%

			%{@ 'Bienvenue, <strong>%s</strong> (%s)', htmlentities($user['name']), htmlentities($user['username'])}%
			<a href="%{link '/session/logout'}%"> 
			<img border="0" src="%{link '/data/admin/img/session_exit.png'}%" title="%{@ 'Déconnexion'}%" alt="%{@ 'Déconnexion'}%" />
			</a>
			%{$page_topbar}%
		</div>

	</td>
</tr>
<tr>
	<td colspan="2" class="adm_menu_top">
		<div id="adm_menu">
			%{$navigation}%
		</div>
	</td>
</tr>
<tr>
	<td colspan="2">
		%{$body}%
	</td>
</tr>
<tr>
	<td colspan="2">
		<div id="adm_information">
			Copyright <a href="http://binarysec.com" target="_blank">Open Web Framework</a> 2006-2011%{$bottom}%
		</div>
	</td>
</tr>
</table>

</div>

</center>

