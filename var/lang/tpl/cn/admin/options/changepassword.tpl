<center>
%{if $error}%
<p><strong>%{$error}%</strong></p>
%{/if}%

%{if $uid == $me['id']}%
	<p>You are editing your password</p>
%{else}%
	<p>You are editing password of <strong>%{$user['firstname']|html}% %{$user['name']|html}%</strong></p>
%{/if}%

</center>
<form action="?" method="get" data-ajax="false">
	<input type="hidden" name="back" value="%{$back}%" />
	<input type="hidden" name="uid" value="%{$uid}%" />
	<input type="hidden" name="action" value="mod" />

	<label for="pw" class="ui-hidden-accessible">New password:</label>
	<input type="password" name="new_pass" id="pw" value="" placeholder="New password" />

	<label for="pw" class="ui-hidden-accessible">Confirm password:</label>
	<input type="password" name="confirm_pass" id="pw" value="" placeholder="Confirm password" />
	
	<button type="submit" data-theme="b">Update password</button>
</form>