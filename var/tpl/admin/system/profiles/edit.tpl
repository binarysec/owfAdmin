<div class="table_topnav">
	<div class="table_topnav_left">
		<button onclick="javascript:document.location='{link '/admin/system/users/list'}';">
			<img src="{link '/data/icons/22x22/back.png'}" />
			{@ 'Retourner à la liste des utilisateurs'}
		</button>
	</div>
</div>

<form method="post" action="{link '/admin/system/profiles/edit/'.$user['id']}">

{foreach $profiles as $profile}
<h2 class="accordiontitle">{$profile['description']|b64_dcode}</h2>
{$profile['form']}
{/foreach}
<br />

<button onclick="javascript:this.submit();'">
<img src="{link '/data/icons/22x22/save.png'}" />
Enregistrer les modifications
</button>

</form>
