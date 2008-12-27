<form method="post" action="{link '/admin/system/profiles/edit/'.$user['id']}">

<h2>Information personnelles :</h2>
<table>
	<tr>
		<td>
		Nom/prénom : 
		</td>
		<td>
		<input type="text" value=""/>
		</td>
	</tr>
	
	<tr>
		<td>
		Adresse email :
		</td>
		<td>
		<input type="text" value=""/>
		</td>
	</tr>
</table>

<h2>Changer le mot de passe :</h2>
<table>
	<tr>
		<td>
		Entrer le mot de passe #1 :
		</td>
		<td>
		<input type="pass1" value=""/>
		</td>
	</tr>
	
	<tr>
		<td>
		Entrer le mot de passe #2 :
		</td>
		<td>
		<input type="pass2" value=""/>
		</td>
	</tr>
</table>

<h2>Données porté :</h2>
{foreach $profiles as $profile}
<h3>{$profile['description']|b64_dcode}</h3>
{$profile['form']}
{/foreach}
<br />

<button onclick="javascript:this.submit();'">
<img src="{link '/data/icons/22x22/save.png'}" />
Enregistrer les modifications
</button>

</form>
