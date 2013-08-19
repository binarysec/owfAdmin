%{css '/data/admin/css/jqm-docs.css'}%
%{css '/data/admin/css/admin.css'}%
%{css '/data/css/jqm-datebox.min.css'}%
%{css '/data/css/jquery.mobile.min.css'}%
%{js '/data/admin/js/admin.js'}%
%{js '/data/js/jquery-1.7.js'}%
%{js '/data/js/jquery.mobile.min.js'}%
%{js '/data/js/jqm-datebox.comp.calbox.min.js'}%

<div %{foreach $divs as $k => $v}%%{$k}%="%{$v}%" %{/foreach}%> 
	%{if $header_bool}%
		%{$header}%
	%{/if}%
	
	<div id="owf-admin-infobar-%{$seed}%" class="owf-admin-infobar ui-bar ui-bar-e"></div>
	
	<div data-role="content">
	%{$body}%
	</div>

	%{if $footer_bool}%
	<div data-role="footer" class="footer-docs" data-theme="c">
		%{$footer}%
	</div>
	%{/if}%
	
	%{foreach($panels as $id => $panel)}%
		<div data-role="panel" id="owf-panel-%{$id}%" %{foreach($panel["opts"] as $optkey => $opt)}%%{$optkey}%="%{$opt}%" %{/foreach}%>
			%{$panel["html"]}%
		</div>
	%{/foreach}%
</div>
