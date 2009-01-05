<div class="table_topnav">
	<div class="table_topnav_left">
		<button onclick="javascript:document.location='{link '/admin'}';">
			<img src="{link '/data/icons/22x22/back.png'}" />
			{@ 'Retourner au panneau d\'administration'}
		</button>
	</div>
</div>

<h1>{@ "Informations sur le système"}</h1>

<table class="list">

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

<br/>

<h1>{@ "Information sur les modules chargés"}</h1>

<table class="list">

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