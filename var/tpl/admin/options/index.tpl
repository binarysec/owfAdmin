<div class="content-secondary">

	<div id="jqm-homeheader">
		<h1 id="jqm-logo"><img src="%{link '/data/admin/images/title_options.png'}%" alt="%{@ 'OWF My Options'}%" /></h1>
		<p>Gestion du compte de %{$user['firstname']}% %{$user['name']}%</p>
	</div>

	<p class="intro"></p>
	<ul data-role="listview" data-inset="true">
		<li class="ui-btn-icon-right ui-li-has-arrow ui-li.ui-corner-top ui-btn-up-a">%{$user['firstname']}% %{$user['name']}%</li>
		<li class="ui-btn-icon-right ui-li-has-arrow ui-li.ui-corner-top ui-btn-up-a">Email: %{$user['email']}%</li>
		
	%{if isset($perms["session:god"])}%
	<li class="ui-btn-icon-right ui-li-has-arrow ui-li.ui-corner-top ui-btn-up-a">Role: Super administrateur</li>
	%{elseif isset($perms["session:admin"])}%
	<li class="ui-btn-icon-right ui-li-has-arrow ui-li.ui-corner-top ui-btn-up-a">Role: Administrateur</li>
	%{elseif isset($perms["session:simple"])}%
	<li class="ui-btn-icon-right ui-li-has-arrow ui-li.ui-corner-top ui-btn-up-a">Role: Utilisateur</li>
	%{elseif isset($perms["session:ws"])}%
	<li class="ui-btn-icon-right ui-li-has-arrow ui-li.ui-corner-top ui-btn-up-a">Role: Service web</li>
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