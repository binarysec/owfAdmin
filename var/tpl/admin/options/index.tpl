<div class="content-secondary">

	<div id="jqm-homeheader">
		<h1 id="jqm-logo"><img src="%{link '/data/admin/images/title_options.png'}%" alt="%{@ 'OWF My Options'}%" /></h1>
		<p>Gestion du compte de %{$user['firstname']}% %{$user['name']}%</p>
	</div>

	<p class="intro">
		<select tabindex="-1" name="select-choice-1" id="select-choice-custom" data-native-menu="false" data-mini="true">
			<option value="standard">Langue Française</option>
			<option value="rush">English Language</option>
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

	
</div>
<div class="content-primary">
	<ul data-role="listview" data-inset="true">
		%{foreach $aopts as $aopt}%
		<li %{if $aopt['icon']}%data-icon="%{$aopt['icon']}%"%{/if}%>
			<a href="%{$aopt['link']|html}%">
				%{$aopt['text']}%
			</a>
		</li>
		%{/foreach}%
	</ul>
</div>
