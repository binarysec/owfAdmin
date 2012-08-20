%{css '/data/admin/css/jqm-docs.css'}%
%{css '/data/admin/css/admin.css'}%
%{css '/data/css/jquery.mobile.min.css'}%
%{css '/data/css/jqm.simpledialog.css'}%
%{js '/data/js/jquery-1.7.js'}%
%{js '/data/js/jquery.mobile.min.js'}%
%{js '/data/js/jqm.simpledialog2.js'}%

<div %{foreach $divs as $k => $v}%%{$k}%="%{$v}%" %{/foreach}%> 
	%{if $header_bool}%
		%{$header}%
	%{/if}%
	
	<div data-role="content">
	%{$body}%
	</div>

	%{if $footer_bool}%
	<div data-role="footer" class="footer-docs" data-theme="c">
		%{$footer}%
	</div>
	%{/if}%
</div>