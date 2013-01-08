<center>
%{if $error}%
<p><strong>%{$error}%</strong></p>
%{/if}%

%{if $uid == $me['id']}%
	<p>You are editing your specials roles</p>
%{else}%
	<p>You are editing specials roles of <strong>%{$user['firstname']|html}% %{$user['name']|html}%</strong></p>
%{/if}%

<form action="?" method="get" data-ajax="false">
	<input type="hidden" name="back" value="%{$back}%" />
	<input type="hidden" name="uid" value="%{$uid}%" />
	<input type="hidden" name="action" value="mod" />
	
	<ul data-role="listview" data-inset="true">
%{foreach $sp as $spkey => $spval}%
	<li data-role="fieldcontain">
		<label for="flip-%{$spkey}%" data-mini="true" style="width: 75%;">%{$spval[1]}%</label>
		<select name="%{$spkey}%" id="flip-%{$spkey}%" data-role="slider" data-mini="true">
		%{if $spval[0]}%
			<option value="off">Off</option>
			<option value="on" selected>On</option>
		%{else}%
			<option value="off" selected>Off</option>
			<option value="on">On</option>
		%{/if}%
		</select> 
	</li>
%{/foreach}%
	</ul>
	<button type="submit" data-theme="b">Update permissions</button>
</form>
</center>