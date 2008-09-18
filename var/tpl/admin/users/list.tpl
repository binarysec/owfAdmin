{literal}
	<script type="text/javascript">
		function set_form_add_user() {
			document.getElementById('form_add_user').reset();
		}

		function set_form_edit_user(id, email, name, perms) {
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
			field_perms.value            = perms;
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

<table class="list">
	<thead>
		<tr>
			<th class="icon"></th>
			<th class="key">E-mail</th>
			<th>Nom</th>
			<th>Date de cr&eacute;ation</th>
			<th>Permissions</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		{foreach $users as $user}
			<tr class="user">
				<td class="icon">
					{if $user['online']}
						<img src="{link '/data/admin/img/icons/16x16/online.png'}" alt="[En ligne]" title="En ligne" />
					{else}
						<img src="{link '/data/admin/img/icons/16x16/offline.png'}" alt="[Hors ligne]" title="Hors ligne" />
					{/if}
				</td>
				<td class="key"><a>{$user['email']}</a></td>
				<td>{$user['name']}</td>
				<td>cr&eacute;&eacute; le {$user['create_time']}</td>
				<td>{$user['perms']}</td>
				<td class="actions">
					<a><img src="{link '/data/cms/img/icons/16x16/view.png'}"
						title="Voir l'utilisateur"
						alt="Voir l'utilisateur" /></a>
					<a onclick="javascript:
						YAHOO.dialog_edit_user.myDialog.show();
						set_form_edit_user('{$user['id']}', '{$user['email']}', '{$user['_name']|escurl}', '{$user['perms']}');"
						><img src="{link '/data/cms/img/icons/16x16/edit.png'}"
							title="&Eacute;diter l'utilisateur"
							alt="&Eacute;diter l'utilisateur"
						/></a>
					<a onclick="javascript:
						YAHOO.dialog_delete_user.myDialog.show();
						set_form_delete_user('{$user['id']}', '{$user['email']}')"
						><img src="{link '/data/cms/img/icons/16x16/delete.png'}"
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

<div class="table_views">
	<img src="{link '/data/admin/img/icons/16x16/add_user.png'}"
		alt="Cr&eacute;er un nouvel utilisateur"
		title="Cr&eacute;er un nouvel utilisateur" />
	<a onclick="javascript:
		YAHOO.dialog_add_user.myDialog.show();
		set_form_add_user();"
		>Ajouter un nouvel utilisateur</a>
</div>
