%{css '/data/yui/build/button/assets/skins/sam/button.css'}%
%{css '/data/yui/build/container/assets/skins/sam/container.css'}%

%{js '/data/yui/build/yahoo-dom-event/yahoo-dom-event.js'}%
%{js '/data/yui/build/connection/connection-min.js'}%
%{js '/data/yui/build/element/element-min.js'}%
%{js '/data/yui/build/button/button-min.js'}%
%{js '/data/yui/build/dragdrop/dragdrop-min.js'}%
%{js '/data/yui/build/container/container-min.js'}%

%{literal}%
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

	YAHOO.namespace("dialog_edit_var");
	function init_edit_var() {
	
		var handleSubmit = function() {	
			this.submit();			
		};
		var handleCancel = function() {
			this.cancel();
		};

		YAHOO.dialog_edit_var.myDialog = new YAHOO.widget.Dialog(
			"var_edit_simple", {
				fixedcenter : true,
				visible : false,
				constraintoviewport : true,
				buttons : [
					%{text:"Modifier", handler:handleSubmit, isDefault:true}%,
					%{text:"Annuler", handler:handleCancel}%
				],
				postmethod : "form"		}
		);
	
		YAHOO.dialog_edit_var.myDialog.validate = function() {
				return true;
		};

		YAHOO.dialog_edit_var.myDialog.render();
	}
	YAHOO.util.Event.onDOMReady(init_edit_var);

</script>
%{/literal}%
<div id="var_edit_simple">
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
				<thead>
					<tr>
						<th>%{@ 'Nom'}%</th>
						<th>%{@ 'Description'}%</th>
						<th>%{@ 'Default'}%</th>
						<th>%{@ 'Valeur'}%</th>
						<th></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th colspan="3">Total (%{$groups|count}%)</th>
					</tr>
				</tfoot>			
				<tbody>
					%{foreach $val as $k=>$v}%
						<tr%{alt ' class="alt"'}%>
							<td>%{$v["variable"]}%</td>
							<td>%{$v["description"]}%</td>
							<td>%{$v["dft"]}%</td>
							<td>%{$v["value"]}%</td>
							<td><a class="btn two" onclick="
									YAHOO.dialog_edit_var.myDialog.show();
									set_edit_var_single(
										'%{$v['description']}%', 
										'%{$v['variable']}%', 
										'%{$v['dft']}%', 
										'%{$v['value']}%',
										'%{$group}%'
										);">%{@ 'éditer'}%</a></td>

						</tr>
					%{/foreach}%
				</tbody>
			</table>
		</div>
	</li>
%{/foreach}%
</ul>
