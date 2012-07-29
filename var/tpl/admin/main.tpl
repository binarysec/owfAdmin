%{css '/data/css/jquery.mobile.min.css'}%
%{css '/data/admin/css/jqm-docs.css'}%
%{js '/data/js/jquery-1.7.js'}%
%{js '/data/js/jquery.mobile.min.js'}%

<div data-role="page"> 
	%{if $header_bool}%
	<div data-role="header" data-theme="a" data-position="fixed">
		%{$header}%
	</div>
	%{else}%
	<div data-role="header" data-theme="a" data-position="fixed"></div>
	%{/if}%
	
	<div data-role="content" data-theme="b">
	%{$body}%
	</div>

	%{if $footer_bool}%
	<div data-role="footer" class="footer-docs" data-theme="c">
		%{$footer}%
	</div>
	%{else}%
	<div data-role="footer" class="footer-docs" data-theme="c"></div>
	%{/if}%
</div>