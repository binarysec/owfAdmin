{literal}
	<script type="text/javascript">
		function set_form_add_user() {
			document.getElementById('form_add_user').reset();
		}

		function set_form_edit_user(id, email, name, perms) {
			document.getElementById('form_edit_user').reset();
			var field_id               = document.getElementById('form_edit_user_id');
			var field_email            = document.getElementById('form_edit_user_email');
			var field_password         = document.getElementById('form_edit_user_password');
			var field_password_confirm = document.getElementById('form_edit_user_password_confirm');
			var field_name             = document.getElementById('form_edit_user_name');
			var field_perms            = document.getElementById('form_edit_user_perms');

			field_id.value               = id;
			field_email.value            = email;
			field_password.value         = '';
			field_password_confirm.value = '';
			field_name.value             = unescape(name);
			for(perm in perms) {
				if(perms[perm] != null) {
					field_perms.value += perms[perm] + "\n";
				}
			}
		}

		function set_form_delete_user(id, email) {
			var field_id    = document.getElementById('form_delete_user_id');
			var field_email = document.getElementById('form_delete_user_email');

			field_id.value        = id;
			field_email.innerHTML = email;
		}
	</script>
{/literal}

{$scripts}

<div class="table_topnav">
	<div class="table_topnav_left">
		<button onclick="javascript:document.location='{link '/admin'}'">
			<img src="{link '/data/icons/22x22/back.png'}" />
			{@ 'Retourner au panneau d\'administration'}
		</button>
	</div>

	<div class="table_topnav_right">
		<button onclick="javascript:
			set_form_add_user();
			YAHOO.dialog_add_user.myDialog.show();">
			<img src="{link '/data/icons/22x22/add.png'}" />
			{@ 'Ajouter un utilisateur'}
		</button>
	</div>
</div>

<table class="list">
	<thead>
		<tr>
			<th class="icon"></th>
			<th class="key">E-mail</th>
			<th>Nom</th>
			<th>Adresse IP</th>
			<th>Date de cr&eacute;ation</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		{foreach $users as $user}
			<tr class="user{alt ' alt'}">
				<td class="icon">
					{if $user['online']}
						<img src="{link '/data/icons/16x16/online.png'}" alt="[En ligne]" title="En ligne" />
					{else}
						<img src="{link '/data/icons/16x16/offline.png'}" alt="[Hors ligne]" title="Hors ligne" />
					{/if}
				</td>
				<td class="key">{$user['email']}</td>
				<td>{if $user['name']}{$user['name']}{else}-{/if}</td>
				<td>{if $user['from']}{$user['from']}{else}-{/if}</td>
				<td>{$user['create_time']}</td>
				<td class="actions">
					<a onclick="javascript:
						YAHOO.dialog_edit_user.myDialog.show();
						set_form_edit_user(
							'{$user['id']}',
							'{$user['email']}',
							'{$user['_name']|escurl}',
							new Array({foreach $user['perms'] as $perm}'{$perm}',{/foreach}null)
						);"
						><img src="{link '/data/icons/16x16/edit_info.png'}"
							title="&Eacute;diter l'utilisateur"
							alt="&Eacute;diter l'utilisateur"
						/></a>
					<a href="{link '/admin/system/profiles/show/'.$user['id']}"
						><img src="{link '/data/icons/16x16/manage_form.png'}"
							alt="{@ 'Modifier le profil'}"
							title="{@ 'Modifier le profil'}"
						/></a>
					<a onclick="javascript:
						YAHOO.dialog_delete_user.myDialog.show();
						set_form_delete_user('{$user['id']}', '{$user['email']}')"
						><img src="{link '/data/icons/16x16/delete.png'}"
							title="Supprimer l'utilisateur"
							alt="Supprimer l'utilisateur"
						/></a>
				</td>
			</tr>
		{/foreach}
	</tbody>
	<tfoot>
		<tr>
			<th colspan="6">Total ({$users|count})</th>
		</tr>
	</tfoot>
</table>
