<script>
	$(document).delegate('.core-pref-opendialog', 'click', function() {
		var	variable = $(this).children(".core-pref-variable").val(),
			group = $(this).children(".core-pref-group").val(),
			value = $(this).children(".core-pref-value").val(),
			pref_type = $(this).children(".core-pref-type").val(),
			type = "text",
			input = '';
		
		if(pref_type == %{const CORE_PREF_NUM}%)
			type = "number"
		
		if(	pref_type == %{const CORE_PREF_NUM}% ||
			pref_type == %{const CORE_PREF_VARCHAR}% ||
			pref_type == %{const CORE_PREF_DATA}% ||
			pref_type == %{const CORE_PREF_HIDDEN}%
			)
			input = "<input style='text-align: center;' type='" + type + "' name='value' value='" + value + "' />";
		else if(pref_type == %{const CORE_PREF_BOOL}%)
			input =	"<select name='value' data-role='slider'>" +
						"<option value='0'>Off</option>" +
						"<option value='1'" + (value ? " selected" : "") + ">On</option>" +
					"</select>";
		
		$('<div>').simpledialog2({
			mode: 'blank',
			headerText: 'Edition of variable',
			headerClose: true,
			dialogAllow: true,
			dialogForce: false,
			width: "500px",
			height: "350px",
			blankContent : 
				"<p><center style='padding: 10px;'><form action='%{link '/admin/system/variables/edit'}%'>" +
					"<input type='hidden' name='variable' value='" + variable + "' />" +
					"<input type='hidden' name='group' value='" + group + "' />" +
					"Editing variable \"" + variable + "\" of group \""  + group + "\" : <br/>" +
					"<label>" + input + "</label>" +
					"<input type='submit' data-role='button' value='%{@ 'Submit'}%' />" +
					"<a rel='close' data-role='button' href='#'>Close</a>" +
				"</form></center></p>"
		})
	});
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
	<div data-role="collapsible">
		<h3>%{$group}%</h3>
		<ul data-role="listview">
			%{foreach $val as $k=>$v}%
			<li data-role="fieldcontain">
				<a href="#" class="core-pref-opendialog">
					<input class="core-pref-variable" type="hidden" value="%{$v['variable']}%" />
					<input class="core-pref-group" type="hidden" value="%{$group}%" />
					<input class="core-pref-value" type="hidden" value="%{$v['value']}%" />
					<input class="core-pref-type" type="hidden" value="%{$v['type']}%" />
					<p>
					<strong>%{$v["description"]}%</strong> - <i>%{$v["variable"]}%</i><br/>
					%{if($v["type"] == CORE_PREF_BOOL)}%
						%{@ "Value"}% : <strong>%{if($v["value"])}%On%{else}%Off%{/if}%</strong>
					%{else}%
						%{@ "Value"}% : <strong>%{$v["value"]}%</strong>
					%{/if}%
					</p>
				</a>
			</li>
			%{/foreach}%
		</ul>
	</div>
	%{/foreach}%
	</div>
	
</div>
