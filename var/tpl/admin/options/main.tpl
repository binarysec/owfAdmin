%{css '/data/admin/css/jqm-docs.css'}%
%{css '/data/admin/css/admin.css'}%
%{css '/data/css/jquery.mobile.min.css'}%
%{js '/data/js/jquery-1.7.js'}%
%{js '/data/js/jquery.mobile.min.js'}%

<div %{foreach $divs as $k => $v}%%{$k}%="%{$v}%" %{/foreach}%> 
	<div data-role="header" data-theme="a" data-position="fixed">
		<a href="%{$backlink[0]|html}%" data-icon="back" data-iconpos="notext" data-direction="reverse">Back</a>
		<h1>%{$title}%</h1>
	</div>
	
	<div data-role="content">
	%{$body}%
	</div>

	%{if $footer_bool}%
	<div data-role="footer" class="footer-docs" data-theme="c">
		%{$footer}%
	</div>
	%{/if}%
</div>