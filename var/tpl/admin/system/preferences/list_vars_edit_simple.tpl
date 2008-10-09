<form id="var_edit_simple" name="var[form]" class="form_dialog" method="POST" action="{link '/admin/system/users/edit'}">
	<input type="hidden" id="form_edit_user_id" name="id" value="" />
	<table>
		<tr>
			<td><label for="var_edit_simple_description">Description :</label></td>
			<td><input type="text" id="var_edit_simple_description" name="var[description]" value="" disabled="true" /></td>
		</tr>
		<tr>
			<td><label for="var_edit_simple_name">Nom de la variable :</label></td>
			<td><input type="text" id="var_edit_simple_name" name="var[name]" value="" disabled="true" /></td>
		</tr>
		<tr>
			<td><label for="var_edit_simple_default">Valeur par default :</label></td>
			<td><input type="text" id="var_edit_simple_default" name="var[default]" value="" disabled="true" /></td>
		</tr>
		<tr>
			<td><label for="var_edit_simple_value">Valeur modifiable :</label></td>
			<td><input type="text" id="var_edit_simple_value" name="var[value]" value="" /></td>
		</tr>
	</table>
</form>