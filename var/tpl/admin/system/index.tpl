<div class="module_index">
	<button onclick="javascript:document.location = '%{link '/admin/system/information'}%'">
		<img src="%{link '/data/admin/img/info.png'}%"  alt="%{@ 'Informations syst&egrave;mes'}%"/><br />
		%{@ 'Informations syst&egrave;mes'}%
	</button>

	<button onclick="javascript:document.location = '%{link '/admin/system/preferences'}%'">
		<img src="%{link '/data/admin/img/prefs.png'}%" alt="%{link '/data/admin/img/prefs.png'}%"/><br />
		%{@ 'Pr&eacute;f&eacute;rences syst&egrave;mes'}% (%{$nb_pref_groups}%)
	</button>

	%{if $perm_manage_users}%
	<button onclick="javascript:document.location = '%{link '/admin/system/session/users'}%'">
		<img src="%{link '/data/admin/img/info.png'}%" alt="%{link '/data/admin/img/info.png'}%"/><br />
		%{@ 'Utilisateurs'}% (%{$nb_users}%)
	</button>
	%{/if}%

	<button onclick="javascript:document.location = '%{link '/admin/system/data'}%'">
		<img src="%{link '/data/admin/img/data.png'}%" alt="%{link '/data/admin/img/data.png'}%"/><br />
		%{@ 'Donn&eacute;es statiques'}%
	</button>
</div>

<div class="spacer"></div>
