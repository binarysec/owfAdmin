<table class="list">
	<thead>
		<tr>
			<th class="icon"></th>
			<th class="key">Nom</th>
			<th>Description</th>
			<th>Adresse IP</th>
<!-- 			<th>Date de cr&eacute;ation</th> -->
<!-- 			<th>Actions</th> -->
		</tr>
	</thead>
	<tbody>
		{foreach $groups as $group}
			<tr class="user">
				<td class="icon">
				<img src="{link '/data/admin/img/icons/16x16/cat_close.png'}" alt="[Configurer]" title="Configurer"/>
				</td>
				<td><a href="{$group[1]}"><strong>{$group[0]->name}</strong></a></td>
				<td>{$group[0]->description}</td>
				<td>{$group[0]->create_time}</td>
			</tr>
		{/foreach}
	</tbody>
	<tfoot>
		<tr>
			<th colspan="6">Total ({$groups|count})</th>
		</tr>
	</tfoot>
</table>