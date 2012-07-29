<div class="content-secondary">
	<div id="jqm-homeheader">
		<h1 id="jqm-logo"><img src="%{link '/data/admin/images/title_information.png'}%" alt="%{@ 'OWF System information'}%" /></h1>
		<p>%{@ 'Informations système'}%</p>
	</div>

	<p class="intro">%{@ 'OWF Engine version'}%: <strong>%{$version}%</strong></p>
	
	<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="f">
		<li data-role="list-divider">Systèmes</li>
		<li><u>%{@ "Operating system"}%</u> : %{$os}%</li>
		<li><u>%{@ "Architecture"}%</u> : %{$machine}%</li>
		<li><u>%{@ "Serveur WEB"}%</u> : %{$server}%</li>
		<li><u>%{@ "Version de PHP"}%</u> : %{$php}%</li>
		<li><u>%{@ "Version de Zend"}%</u> : %{$zend}%</li>
		<li><u>%{@ "Pilote de base de données"}%</u> : %{$db}%</li>
		<li><u>%{@ "Pilote de cache"}%</u> : %{$cache}%</li>
	</ul>
	
</div>

<div class="content-primary">
	<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b">
		<li data-role="list-divider">%{@ "Information sur les modules chargés"}%</li>
		%{foreach $modules as $k => $v}%
		<li>
			<h3>%{$v[3]}%</h3>
			<p><strong>%{$v[1]}%/%{$v[5]}%</strong></p>
			<p>%{$v[0]}%</u></p>
		</li>
		%{/foreach}%
		
		%{if $partners_c > 0}%
		<li data-role="list-divider">%{@ 'Partners'}%</li>

		%{foreach $partners as $v}%
		
		<li>
			<img src="%{$v['img']}%" alt="%{$v['name']}%" />
			<h1>%{$v["name"]}%</h1>
		</li>
		%{/foreach}%

		%{/if}%

	</ul>
</div>

