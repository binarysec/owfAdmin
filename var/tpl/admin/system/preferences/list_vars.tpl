{literal}
<script type="text/javascript">
	function set_edit_var_single(a_description, a_name, a_default, a_value, a_url) {
		var edit_form         = document.getElementById('var_edit_simple');
		var field_description = document.getElementById('var_edit_simple_description');
		var field_name        = document.getElementById('var_edit_simple_name');
		var field_default     = document.getElementById('var_edit_simple_default');
		var field_value       = document.getElementById('var_edit_simple_value');

		edit_form.action            = a_url;
		field_description.value     = a_description;
		field_name.value            = a_name;
		field_default.value         = a_default;
		field_value.value = a_value;
	}
</script>
{/literal}

{$dialogs}

<table class="list">
	<thead>
		<tr>
			<th class="icon"></th>
			<th class="key">Nom</th>
			<th>Description</th>
			<th>Default</th>
			<th>Valeur</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		{foreach $vars as $var}
			<tr class="user">
				<td class="icon">
				<img src="{link '/data/icons/16x16/puce.png'}" alt="[Configurer]" title="Configurer"/>
				</td>
				<td><strong>{$var["variable"]}</strong></td>
				<td>{$var["description"]}</td>
				
				{if $var["type"] == CORE_PREF_NUM}
				<td>{$var["dft"]}</td>
				<td>{$var["value"]}</td>
				{elseif $var["type"] == CORE_PREF_BOOL}
				<td>{$var["dft"]}</td>
				<td>{$var["value"]}</td>
				{elseif $var["type"] == CORE_PREF_VARCHAR}
				<td>{$var["dft"]}</td>
				<td>{$var["value"]}</td>
				{else}
				<td>-</td>
				<td>-</td>
				{/if}
				<td>
					<a onclick="javascript:
						YAHOO.dialog_edit_var_simple.myDialog.show();
						set_edit_var_single(
							'{$var['description']}', 
							'{$var['variable']}', 
							'{$var['dft']}', 
							'{$var['value']}',
							'{$var['edit_url']}')"
						><img src="{link '/data/icons/16x16/edit_info.png'}"
							title="Editer la variable"
							alt="Editer la variable"
						/></a>
	
				</td>
			</tr>
		{/foreach}
	</tbody>
	<tfoot>
		<tr>
			<th colspan="6">Total ({$vars|count})</th>
		</tr>
	</tfoot>
</table>