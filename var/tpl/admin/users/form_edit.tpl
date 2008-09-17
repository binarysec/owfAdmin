<form id="form_edit_user" class="form_dialog" method="POST" action="{link '/admin/users/edit'}">
	<input type="hidden" id="form_edit_user_id" name="id" value="" />
	<table>
		<tr>
			<td><label for="form_edit_user_email">Email <span class="required">(*)</span>&nbsp;:</label></td>
			<td><input type="text" id="form_edit_user_email" name="email" value="" /></td>
		</tr>
		<tr>
			<td><label for="form_edit_user_password">Mot de passe&nbsp;:</label></td>
			<td><input type="password" id="form_edit_user_password" name="password" value="" /></td>
		</tr>
		<tr>
			<td><label for="form_edit_user_password">Mot de passe (confirmation)&nbsp;:</label></td>
			<td><input type="password" id="form_edit_user_password_confirm" name="password_confirm" value="" /></td>
		</tr>
		<tr>
			<td><label for="form_edit_user_name">Nom&nbsp;:</label></td>
			<td><input type="text" id="form_edit_user_name" name="name" value="" /></td>
		</tr>
		<tr>
			<td><label for="form_edit_user_perms">Permissions (s&eacute;par&eacute;es par des virgules)&nbsp;:</label></td>
			<td><textarea id="form_edit_user_perms" name="perms"></textarea></td>
		</tr>
	</table>
</form>
