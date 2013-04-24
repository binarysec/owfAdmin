<center>
%{if $error}%
<p><strong>%{$error}%</strong></p>
%{/if}%

%{if $uid == $me['id']}%
	<p>Modification de votre mot de passe.</p>
%{else}%
	<p>Modification du mot de passe de <strong>%{$user['firstname']|html}% %{$user['name']|html}%</strong></p>
%{/if}%

</center>
<form action="?" method="get" data-ajax="false">
	<input type="hidden" name="back" value="%{$back}%" />
	<input type="hidden" name="uid" value="%{$uid}%" />
	<input type="hidden" name="action" value="mod" />

	<label for="pw" class="ui-hidden-accessible">Nouveau mot de passe :</label>
	<input type="password" name="new_pass" id="pw" value="" placeholder="Nouveau mot de passe..." />

	<label for="pw" class="ui-hidden-accessible">Confirmation du mot de passe :</label>
	<input type="password" name="confirm_pass" id="pw" value="" placeholder="Confirmez le mot de passe..." />
	
	<button type="submit" data-theme="b">Mettre à jour le mot de passe</button>
</form>