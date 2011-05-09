%{js '/data/js/jquery-1.5.js'}%
%{js '/data/js/jquery-ui-1.8.js'}%

<script type="text/javascript">
	$(function() {
	// Change mode button 
	$("button, input:submit, a", ".edit").button({ 
		icons: {
			primary:'ui-icon-gear'
		}
	});
	
	$("a", ".edit").click(function() { 
		
		var sid = document.getElementById('change_mode_sid');
		$("#var_edit_simple_dialog").dialog({
			width: 500,
			modal: true,
			autoOpen: true,
			resizable: false,
			buttons: { 
				OK: function() {
					$("#form_edit_var").submit();
				},
				Cancel: function() {
					$("#var_edit_simple_dialog").dialog("close");
				}
			}
		});
		return(false);	
	});
	
	$("#var_edit_simple_dialog").hide();
});

</script>

<script type="text/javascript">
function display(id){
	var doc=document.getElementById(id);
	if(doc.style.display=="none")
		doc.style.display="";
	else
		doc.style.display="none";
}
function set_edit_var_single(a_description, a_name, a_default, a_value,a_group) {	
		var field_description = document.getElementById('var_edit_simple_description');
		var field_group		  = document.getElementById('var_edit_simple_group');
		var field_showname    = document.getElementById('var_edit_simple_showname');
		var field_default     = document.getElementById('var_edit_simple_default');
		var field_value       = document.getElementById('var_edit_simple_value');
		var field_name_hid    = document.getElementById('var_edit_simple_name');


		field_description.innerHTML		= a_description;
		field_group.value     			= a_group;
		field_showname.innerHTML        = a_name;
		field_name_hid.value	        = a_name;
		field_default.innerHTML         = a_default;
		field_value.value 				= a_value;
		
	}

</script>

<div id="var_edit_simple_dialog">
	<div class="hd">%{@ 'Edition de variable'}%</div>
	<div class="bd">
	<form id="form_edit_var" class="form_dialog" method="post" action="%{link '/admin/system/preferences/vars/edit'}%">
			<div id="edit_var_edition">
				<input type="hidden" id="var_edit_simple_group" name="group" value=""/>
				<input type="hidden" id="var_edit_simple_name" name="name" value=""/>
				<table>
					<tr>
						<td><span class="base_text">%{@ 'Nom'}%&nbsp;:</span></td>
						<td><span class="base_text" id="var_edit_simple_showname"></span></td>
					</tr>
					<tr>
						<td><span class="base_text">%{@ 'Description'}%&nbsp;:</span></td>
						<td><span class="base_text" id="var_edit_simple_description"></span></td>
					</tr>
					<tr>
						<td><span class="base_text">%{@ 'Defaut'}%&nbsp;:</span></td>
						<td><span class="base_text" id="var_edit_simple_default"></span></td>
					</tr>	
					<tr>
						<td><label for="var_edit_simple_value" class="base_text">%{@ 'Valeur'}%&nbsp;:</label></td>
						<td><input type="text" id="var_edit_simple_value" name="value" value="" /></td>
					</tr>				
				</table>
			</div>
		</form>
	</div>
</div>
<ul style="margin:0;padding:20px 25px 20px 20px; list-style-type:none;">
%{foreach $groups as $group=>$val}%
	<li>
		<img src="%{link '/data/icons/16x16/cat_close.png'}%" alt="[Configurer]" title="Configurer"/>
		<span onclick="display('group_%{$group}%');">%{$group}%</span>
		<div id="group_%{$group}%" style="display:none;">
			<table  class="dataset_data_table">			
				<tbody>
					%{foreach $val as $k=>$v}%
						<tr%{alt ' class="alt"'}%>
							<td>%{$v["variable"]}%</td>
							<td>%{$v["description"]}%</td>
							<td>%{$v["value"]}%</td>
							<td><span class="edit"><a onclick="
									set_edit_var_single(
										'%{$v['description']}%', 
										'%{$v['variable']}%', 
										'%{$v['dft']}%', 
										'%{$v['value']}%',
										'%{$group}%'
										);">%{@ 'éditer'}%</a></span></td>

						</tr>
					%{/foreach}%
				</tbody>
			</table>
		</div>
	</li>
%{/foreach}%
</ul>
