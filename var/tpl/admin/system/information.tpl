<h1><img src="%{link '/data/admin/img/title_info_system.png'}%" alt="%{@ "Informations sur le système"}%" title="%{@ "Informations sur le système"}%"/>%{@ "Informations sur le système"}%</h1>


<table class="dataset_data_table">

<tr>
<td>%{@ "Version WF"}%</td>
<td>%{$version}%</td>
</tr>

<tr>
<td>%{@ "Operating system"}%</td>
<td>%{$os}%</td>
</tr>

<tr>
<td>%{@ "Architecture"}%</td>
<td>%{$machine}%</td>
</tr>

<tr>
<td>%{@ "Serveur WEB"}%</td>
<td>%{$server}%</td>
</tr>

<tr>
<td>%{@ "Version de PHP"}%</td>
<td>%{$php}%</td>
</tr>

<tr>
<td>%{@ "Version de Zend"}%</td>
<td>%{$zend}%</td>
</tr>

<tr>
<td>%{@ "Pilote de base de données"}%</td>
<td>%{$db}%</td>
</tr>

<tr>
<td>%{@ "Pilote de cache"}%</td>
<td>%{$cache}%</td>
</tr>

</table>


<br/>

%{if $partners_c > 0}%

<h1><img src="%{link '/data/admin/img/title_info_partners.png'}%" alt="%{@ 'Partners'}%" title="%{@ 'Partners'}%"/>%{@ "Partners"}%</h1>


%{foreach $partners as $v}%
<table>
<tr>
	<td align="center"><strong>%{$v["name"]}%</strong></td>
</tr>
<tr>
	<td><a href="%{$v['url']}%" target="_blank"><img src="%{$v['img']}%" alt="%{$v['name']}%" /></a></td>
</tr>
</table>
%{/foreach}%

%{/if}%

<h1><img src="%{link '/data/admin/img/title_info_modules.png'}%" alt="%{@ "Information sur les modules chargés"}%" title="%{@ "Information sur les modules chargés"}%"/>%{@ "Information sur les modules chargés"}%</h1>

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
			<tr>
			<td><strong>%{$v[1]}%</strong></td>
			<td>%{$v[3]}%</td>
			<td>%{$v[5]}%</td>
			<td>%{$v[0]}%</td>
			</tr>
		%{/foreach}%
	</tbody>
</table>


