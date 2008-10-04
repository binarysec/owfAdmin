<h1>{@ "Information sur le système"}</h1>

<table class="list">

<tr>
<td>{@ "Version WF"}</td>
<td>{$version}</td>
</tr>

<tr>
<td>{@ "Operating system"}</td>
<td>{$os}</td>
</tr>

<tr>
<td>{@ "Architecture"}</td>
<td>{$machine}</td>

</tr>
<tr>
<td>{@ "Serveur WEB"}</td>
<td>{$server}</td>
</tr>

<tr>
<td>{@ "Version de PHP"}</td>
<td>{$php}</td>
</tr>

<tr>
<td>{@ "Version de Zend"}</td>
<td>{$zend}</td>
</tr>

<tr>
<td>{@ "Pilote de base de données"}</td>
<td>{$db}</td>
</tr>

<tr>
<td>{@ "Pilote de cache"}</td>
<td>{$cache}</td>
</tr>

</table>

<br/>

<h1>{@ "Information sur les modules chargé"}</h1>

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
<tr>
<td><strong>{$v[1]}</strong></td>
<td>{$v[3]}</td>
<td>{$v[5]}</td>
<td>{$v[0]}</td>
</tr>
{/foreach}
</tr>

</table>