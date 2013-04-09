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
				<a href="#owf-admin-variables-open-%{$k}%" data-rel="popup" data-position-to="window" data-transition="pop">
					<small style="font-weight: normal;">
						<strong>%{$v["description"]}%</strong> - <i>%{$v["variable"]}%</i><br/>
						%{if($v["type"] == CORE_PREF_BOOL)}%
							%{@ "Value"}% : <strong>%{if($v["value"])}%On%{else}%Off%{/if}%</strong>
						%{else}%
							%{@ "Value"}% : <strong>%{$v["value"]}%</strong>
						%{/if}%
					</small>
				</a>
				<div id="owf-admin-variables-open-%{$k}%" data-role="popup" data-theme="f" class="ui-corner-all">
					<a href="#" data-rel="back" data-role="button" data-theme="a" data-icon="delete" data-iconpos="notext" class="ui-btn-right">%{@ "Close"}%</a>
					<div data-role="header" data-theme="a" class="ui-corner-top">
						<h1>%{@ "Variable edition"}%</h1>
					</div>
					<div data-role="content" data-theme="b" class="ui-corner-bottom ui-content">
						<form action="%{link '/admin/system/variables/edit'}%">
							<input type="hidden" name="group" value="%{$group}%" />
							<input type="hidden" name="variable" value="%{$v['variable']}%" />
							<h3 class="ui-title">%{@ "Editing variable \"%s\" of group \"%s\"",$v['variable'],$group}%</h3>
							<p>
								%{if($v['type'] == CORE_PREF_BOOL)}%
								<select name='value' data-role='slider'>
									<option value='0'>Off</option>
									<option value='1'%{if($v['value'])}% selected='selected'%{/if}% >On</option>
								</select>
								%{else}%
								<input type="%{if($v['type'] == CORE_PREF_NUM)}%number%{else}%text%{/if}%" name="value" value="%{$v['value']}%" style="text-align: center;" />
								%{/if}%
							</p>
							<center>
								<input type="submit" data-role="button" data-inline="true" data-theme="f" data-transition="flow" value="%{@ 'Submit'}%">
								<a href="#" data-role="button" data-inline="true" data-rel="back">%{@ "Cancel"}%</a>
							</center>
						</form>
					</div>
				</div>
			</li>
			%{/foreach}%
		</ul>
	</div>
	%{/foreach}%
	</div>
	
</div>
