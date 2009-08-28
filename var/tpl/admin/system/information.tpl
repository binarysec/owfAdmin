<h1><img src="{link '/data/admin/img/title_info_system.png'}"/>{@ "Informations sur le système"}</h1>

<div class="admin_content">

<table class="dataset_data_table">

<tr{alt ' class="alt"'}">
<td>{@ "Version WF"}</td>
<td>{$version}</td>
</tr>

<tr{alt ' class="alt"'}">
<td>{@ "Operating system"}</td>
<td>{$os}</td>
</tr>

<tr{alt ' class="alt"'}">
<td>{@ "Architecture"}</td>
<td>{$machine}</td>
</tr>

<tr{alt ' class="alt"'}">
<td>{@ "Serveur WEB"}</td>
<td>{$server}</td>
</tr>

<tr{alt ' class="alt"'}">
<td>{@ "Version de PHP"}</td>
<td>{$php}</td>
</tr>

<tr{alt ' class="alt"'}">
<td>{@ "Version de Zend"}</td>
<td>{$zend}</td>
</tr>

<tr{alt ' class="alt"'}">
<td>{@ "Pilote de base de données"}</td>
<td>{$db}</td>
</tr>

<tr{alt ' class="alt"'}">
<td>{@ "Pilote de cache"}</td>
<td>{$cache}</td>
</tr>

</table>

</div>

<br/>

<h1><img src="{link '/data/admin/img/title_info_modules.png'}"/>{@ "Information sur les modules chargés"}</h1>

<div class="admin_content">

<table class="dataset_data_table">

<thead>
<tr>
<th>{@ "Id"}</th>
<th>{@ "Description"}</th>
<th>{@ "Version"}</th>
<th>{@ "Path"}</th>
</tr>
</thead>
{foreach $modules as $k => $v}
<tr{alt ' class="alt"'}">
<td><strong>{$v[1]}</strong></td>
<td>{$v[3]}</td>
<td>{$v[5]}</td>
<td>{$v[0]}</td>
</tr>
{/foreach}
</tr>

</table>

</div>