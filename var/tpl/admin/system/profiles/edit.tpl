<form method="post" action="{link '/admin/system/profiles/edit/'.$user['id']}">

<h2>Information personnelles&nbsp;:</h2>
<table>
	<tr>
		<td style="width: 200px; font-weight: bold;">Adresse email&nbsp;:</td>
		<td>{$user['email']}</td>
	</tr>
	<tr>
		<td style="width: 200px; font-weight: bold;"><label for="form_user_name">Pr&eacute;nom / Nom&nbsp;:</label></td>
		<td><input id="form_user_name" type="text" name="name" value="{$user['name']}" /></td>
	</tr>
	<tr>
		<td style="width: 200px; font-weight: bold;"><label for="form_user_password">Mot de passe&nbsp;:</label></td>
		<td><input id="form_user_password" name="password" type="password" value="" /></td>
	</tr>
	<tr>
		<td style="width: 200px; font-weight: bold;"><label for="form_user_password2">Mot de passe (confirmation)&nbsp;:</label></td>
		<td><input id="form_user_password2" name="password2" type="password" value="" /></td>
	</tr>
</table>

{foreach $profiles as $profile}
<h2 style="margin-top: 20px;">{$profile['description']|b64_dcode}&nbsp;:</h2>
{$profile['form']}
{/foreach}
<br />

<button onclick="javascript:this.submit();'">
<img src="{link '/data/icons/22x22/save.png'}" />
Enregistrer les modifications
</button>

</form>
