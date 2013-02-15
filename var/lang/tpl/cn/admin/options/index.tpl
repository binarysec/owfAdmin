<script type="text/javascript" src="%{link "/data/js/jqm.simpledialog2.js"}%"></script>
<script type="text/javascript">
	function ask_change_lang() {
		$('<div>').simpledialog2({
			mode: 'button',
			headerText: '%{@ "Confirmation"}%',
			headerClose: true,
			buttonPrompt: '<strong>Vous allez être redirrigé vers la page principale. Voulez-vous continuer?</strong>',
			buttons : {
				'OK': {
					click: do_change_lang
				},
				'Cancel': {
					click: function() {},
					icon: "delete",
					theme: "c"
				}
			}
		});
	}
	
	function do_change_lang() {
		$.post(
			"%{link "/admin/options/edit"}%",
			{f: "lang", v: $("#admin-options-lang").val(), u: %{$user["id"]}%},
			function(data, textStatus, jqXHR) {
				$.mobile.changePage(data, {reloadPage: true});
			}
		);
	}
</script><div class="content-secondary">

	<div id="jqm-homeheader">
		<h1 id="jqm-logo"><img src="%{link '/data/admin/images/title_options.png'}%" alt="%{@ 'OWF My Options'}%" /></h1>
		<p>Gestion du compte de %{$user['firstname']}% %{$user['name']}%</p>
	</div>

	<p class="intro">
		<select id="admin-options-lang" data-native-menu="false" data-mini="true" onchange='ask_change_lang();'>
			%{foreach($langs as $lang)}%
				<option value="%{$lang['code']}%" %{if($lang['code']==$user['lang'])}%selected=selected%{/if}%>%{$lang['name']}%</option>
			%{/foreach}%
		</select>
	</p>
	
	<ul data-role="listview" data-inset="true">
		<li class="ui-btn-icon-right ui-li-has-arrow ui-li.ui-corner-top ui-btn-up-a">%{$user['firstname']}% %{$user['name']}% / %{$user['username']}%</li>
		<li class="ui-btn-icon-right ui-li-has-arrow ui-li.ui-corner-top ui-btn-up-a">%{$user['email']}%</li>
		
	%{if isset($perms["session:god"])}%
	<li class="ui-btn-icon-right ui-li-has-arrow ui-li.ui-corner-top ui-btn-up-a">Super administrateur</li>
	%{elseif isset($perms["session:admin"])}%
	<li class="ui-btn-icon-right ui-li-has-arrow ui-li.ui-corner-top ui-btn-up-a">Administrateur</li>
	%{elseif isset($perms["session:ws"])}%
	<li class="ui-btn-icon-right ui-li-has-arrow ui-li.ui-corner-top ui-btn-up-a">Service web</li>
	%{/if}%

	</ul>
	
	%{if($self_edition)}%
	<p>
		<a href="%{link '/session/logout'}%" data-role="button" data-transition="slidedown">%{@ 'Logout'}%</a>
	</p>
	%{/if}%
</div>
<div class="content-primary">
	<ul data-role="listview" data-inset="true">
		%{foreach $aopts as $aopt}%
		<li %{if isset($aopt['icon'])}%data-icon="%{$aopt['icon']}%"%{/if}%>
			<a href="%{$aopt['link']|html}%">
				%{$aopt['text']}%
			</a>
		</li>
		%{/foreach}%
	</ul>
</div>
