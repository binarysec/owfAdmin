<script>
	$(document).delegate('.opendialog', 'click', function() {
		$('<div>').simpledialog2({
		mode: 'blank',
		headerText: 'Some Stuff',
		headerClose: true,
		dialogAllow: true,
		dialogForce: true,
		blankContent : 
			"<ul data-role='listview'><li>Some</li><li>List</li><li>Items</li></ul>" +
			// NOTE: the use of rel="close" causes this button to close the dialog.
			"<a rel='close' data-role='button' href='#'>Close</a>"
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
								<strong>%{$v["variable"]}%</strong>&nbsp;(%{$v["description"]}%) <i>%{$v["value"]}%</i>
							</a>
						</li>
						
					%{/foreach}%
				</ul>
			
		</div>
	%{/foreach}%
	</div>
	
</div>