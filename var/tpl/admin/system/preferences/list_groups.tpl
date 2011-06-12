<h1><img src="%{link '/data/admin/img/title_pref.png'}%" alt="%{@ 'Preference variables'}%" title="%{@ 'Preference variables'}%" />%{@ 'Preference variables'}%</h1>

%{js '/data/js/jquery-1.5.js'}%
%{js '/data/js/jquery-ui-1.8.js'}%

<script type="text/javascript">
	$(function() {
		$("div.proute").accordion({ 
			active: false, 
			clearStyle: true, 
			collapsible: true, 
			autoHeight: true
		});
		
		$("button.edit_button").button({ 
			icons: {
				primary:'ui-icon-gear'
			}
		});
	
		$("button.edit_button").click(function() { 
			$("#dialog").dialog({
				width: 500,
				modal: true,
				autoOpen: true,
				resizable: false,
				buttons: { 
					OK: function() {
						$("#form_edit_var").submit();
					},
					Cancel: function() {
						$("#dialog").dialog("close");
					}
				}
			});
			return(false);
		});
		
		$("#dialog").hide();
	});
	
	function set_edit_var_single(a_description, a_name, a_default, a_value,a_group) {	
		var field_description = document.getElementById('var_edit_simple_description');
		var field_group = document.getElementById('var_edit_simple_group');
		var field_showname = document.getElementById('var_edit_simple_showname');
		var field_default = document.getElementById('var_edit_simple_default');
		var field_value = document.getElementById('var_edit_simple_value');
		var field_name_hid = document.getElementById('var_edit_simple_name');
		field_description.innerHTML = a_description;
		field_group.value = a_group;
		field_showname.innerHTML = a_name;
		field_name_hid.value = a_name;
		field_default.innerHTML = a_default;
		field_value.value = a_value;
	}
	
</script>


<div id="dialog" title="%{@ 'Edit a variable'}%">
	<form id="form_edit_var" class="form_dialog" method="post" action="%{link '/admin/system/preferences/variables/edit'}%">
		<input type="hidden" id="var_edit_simple_group" name="group" value=""/>
		<input type="hidden" id="var_edit_simple_name" name="name" value=""/>
		<table>
			<tr>
				<td>%{@ 'Nom'}%</td>
				<td><span class="base_text" id="var_edit_simple_showname"></span></td>
			</tr>
			<tr>
				<td>%{@ 'Description'}%</td>
				<td><span class="base_text" id="var_edit_simple_description"></span></td>
			</tr>
			<tr>
				<td>%{@ 'Defaut'}%</td>
				<td><span class="base_text" id="var_edit_simple_default"></span></td>
			</tr>	
			<tr>
				<td><label for="var_edit_simple_value" class="base_text">%{@ 'Valeur'}%&nbsp;:</label></td>
				<td><input type="text" id="var_edit_simple_value" name="value" value="" /></td>
			</tr>
		</table>
	</form>
</div>


		
%{foreach $groups as $group=>$val}%
<div class="proute">
	<h3><a href="#">%{$group}%</a></h3>
	<div id="search_%{$name}%">
	
	%{foreach $val as $k=>$v}%
		<div style="margin-bottom: 2px; padding: 3px;" class="ui-widget ui-widget-content ui-corner-all">
		<table width="100%" border="0" cellpadding="2" cellspacing="0">
			<tr>
				<td>
				<strong>%{$v["description"]}%</strong><br/>
				Variable : <i>%{$v["variable"]}%</i><br/>
				Valeur : %{$v["value"]}%
				</td>

				<td align="right" valign="bottom">
				<button class="edit_button" onclick="
					set_edit_var_single(
						'%{$v['description']}%', 
						'%{$v['variable']}%', 
						'%{$v['dft']}%', 
						'%{$v['value']}%',
						'%{$group}%'
						);">%{@ 'éditer'}%</button>
				</td>

			</tr>
		</table>
		
		</div>
	%{/foreach}%
	</div>
</div>
%{/foreach}%


