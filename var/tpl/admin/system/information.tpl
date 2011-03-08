<h1><img src="%{link '/data/admin/img/title_info_system.png'}%" alt="%{@ "Informations sur le système"}%" title="%{@ "Informations sur le système"}%" />%{@ "Informations sur le système"}%</h1>

<div class="admin_content">

<table class="dataset_data_table">

<tr%{alt ' class="alt"'}%>
<td>%{@ "Version WF"}%</td>
<td>%{$version}%</td>
</tr>

<tr%{alt ' class="alt"'}%>
<td>%{@ "Operating system"}%</td>
<td>%{$os}%</td>
</tr>

<tr%{alt ' class="alt"'}%>
<td>%{@ "Architecture"}%</td>
<td>%{$machine}%</td>
</tr>

<tr%{alt ' class="alt"'}%>
<td>%{@ "Serveur WEB"}%</td>
<td>%{$server}%</td>
</tr>

<tr%{alt ' class="alt"'}%>
<td>%{@ "Version de PHP"}%</td>
<td>%{$php}%</td>
</tr>

<tr%{alt ' class="alt"'}%>
<td>%{@ "Version de Zend"}%</td>
<td>%{$zend}%</td>
</tr>

<tr%{alt ' class="alt"'}%>
<td>%{@ "Pilote de base de données"}%</td>
<td>%{$db}%</td>
</tr>

<tr%{alt ' class="alt"'}%>
<td>%{@ "Pilote de cache"}%</td>
<td>%{$cache}%</td>
</tr>

</table>

</div>

<br/>

%{if $partners_c > 0}%
<h1><img src="%{link '/data/admin/img/title_info_partners.png'}%" alt="%{@ 'Partners'}%" title="%{@ 'Partners'}%"/>%{@ "Partners"}%</h1>

<div class="admin_content">

%{foreach $partners as $v}%
<table>
<tr>
	<td align="center"><strong>%{$v["name"]}%</strong></td>
</tr>
<tr>
	<td><a href="%{$v['url']}%" target="_blank"><img src="%{$v['img']}%"/></a></td>
</tr>
</table>
%{/foreach}%

</div>

<br/>
%{/if}%

<h1><img src="%{link '/data/admin/img/title_info_modules.png'}%" alt="%{@ "Information sur les modules chargés"}%" title="%{@ "Information sur les modules chargés"}%"/>%{@ "Information sur les modules chargés"}%</h1>

<div class="admin_content">

<table class="dataset_data_table">
	<thead>
		<tr>
			<th>%{@ "Id"}%</th>
			<th>%{@ "Description"}%</th>
			<th>%{@ "Version"}%</th>
			<th>%{@ "Path"}%</th>
		</tr>
	</thead>
	<tbody>
		%{foreach $modules as $k => $v}%
			<tr%{alt ' class="alt"'}%>
			<td><strong>%{$v[1]}%</strong></td>
			<td>%{$v[3]}%</td>
			<td>%{$v[5]}%</td>
			<td>%{$v[0]}%</td>
			</tr>
		%{/foreach}%
	</tbody>
</table>

</div>
