<script>
	$(document).delegate('.opendialog', 'click', function() {
		var	variable = $(this).children(".core-pref-variable").val(),
			group = $(this).children(".core-pref-group").val(),
			value = $(this).children(".core-pref-value").val();
		
		$('<div>').simpledialog2({
			mode: 'blank',
			headerText: 'Edition of variable',
			headerClose: false,
			dialogAllow: true,
			dialogForce: true,
			blankContent : 
				"<p><center><form action='%{link "/admin/system/variables/edit"}%'>" +
					"<input type='hidden' name='variable' value='" + variable + "' />" +
					"<input type='hidden' name='group' value='" + group + "' />" +
					"Editing variable \"" + variable + "\" of group \""  + group + "\" : " +
					"<label><input style='text-align: center;' type='text' name='value' value='" + value + "' /></label>" +
					"<input type='submit' data-role='button' value='%{@ "Submit"}%' />" +
					"<a rel='close' data-role='button' href='#'>Close</a>" +
				"</form></center></p>"
		})
	})
</script>

<div class="content-secondary">
	<div id="jqm-homeheader">
		<h1 id="jqm-logo"><img src="%{link '/data/admin/images/title_pref.png'}%" alt="%{@ 'OWF SMTP'}%" /></h1>
		<p>%{@ 'Configuration des variables'}%</p>
	</div>

	<p class="intro">%{@ 'Vous pouvez configurer ici toutes les variables de votre application <strong>OWF</strong>.'}%</p>
</div>

<div class="content-primary">
	
	<div data-role="collapsible-set">
	%{foreach $groups as $group => $val}%
	<div data-role="collapsible" data-theme="b">
		<h3>%{$group}%</h3>
		<ul data-role="listview">
			%{foreach $val as $k=>$v}%
			<li data-role="fieldcontain">
				<a href="#" class="opendialog">
					<input class="core-pref-variable" type="hidden" value="%{$v['variable']}%" />
					<input class="core-pref-group" type="hidden" value="%{$group}%" />
					<input class="core-pref-value" type="hidden" value="%{$v['value']}%" />
					%{@ "Variable"}% : <strong>%{$v["variable"]}%</strong><br/>
					%{@ "Description"}% : (%{$v["description"]}%)<br/>
					%{@ "Value"}% : <i>%{$v["value"]}%</i>
				</a>
			</li>
			%{/foreach}%
		</ul>
	</div>
	%{/foreach}%
	</div>
	
</div>