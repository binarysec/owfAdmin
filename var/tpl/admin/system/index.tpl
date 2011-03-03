<div class="module_index">
	<button onclick="javascript:document.location = '{link '/admin/system/information'}'">
		<img src="{link '/data/icons/48x48/info.png'}"  alt="{@ 'Informations syst&egrave;mes'}"/><br />
		{@ 'Informations syst&egrave;mes'}
	</button>

	<button onclick="javascript:document.location = '{link '/admin/system/preferences'}'">
		<img src="{link '/data/icons/48x48/prefs.png'}" alt="{link '/data/icons/48x48/prefs.png'}"/><br />
		{@ 'Pr&eacute;f&eacute;rences syst&egrave;mes'} ({$nb_pref_groups})
	</button>

	<button onclick="javascript:document.location = '{link '/admin/system/users'}'">
		<img src="{link '/data/icons/48x48/info.png'}" alt="{link '/data/icons/48x48/info.png'}"/><br />
		{@ 'Utilisateurs'} ({$nb_users})
	</button>

	<button onclick="javascript:document.location = '{link '/admin/system/data'}'">
		<img src="{link '/data/icons/48x48/data.png'}" alt="{link '/data/icons/48x48/data.png'}"/><br />
		{@ 'Donn&eacute;es statiques'}
	</button>
</div>

<div class="spacer"></div>
