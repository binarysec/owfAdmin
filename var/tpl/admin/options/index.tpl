<div class="content-secondary">

	<div id="jqm-homeheader">
		<h1 id="jqm-logo"><img src="%{link '/data/admin/images/title_options.png'}%" alt="%{@ 'OWF My Options'}%" /></h1>
		<p>Gestion du compte de %{$user['firstname']}% %{$user['name']}%</p>
	</div>

	<p class="intro"></p>
	<ul data-role="listview" data-inset="true">
		<li data-role="list-divider">%{@ "Vos informations"}%</li>
		<li>%{$user['firstname']}% %{$user['name']}%</li>
		<li>Email: %{$user['email']}%</li>
		
	%{if isset($perms["session:god"])}%
	<li>Role: Super administrateur</li>
	%{elseif isset($perms["session:admin"])}%
	<li>Role: Administrateur</li>
	%{elseif isset($perms["session:simple"])}%
	<li>Role: Utilisateur</li>
	%{elseif isset($perms["session:ws"])}%
	<li>Role: Service web</li>
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
