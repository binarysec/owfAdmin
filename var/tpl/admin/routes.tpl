<div data-role="content">

%{if $body}%
	<div class="content-secondary">
	%{$body}%
	</div>
	<div class="content-primary">
%{/if}%

%{if(count($subchans) > 5)}%
	<ul data-role="listview" data-inset="true" data-filter="true" data-filter-placeholder="%{@ 'Search ...'}%">
%{else}%
	<ul data-role="listview" data-inset="true">
%{/if}%
	%{foreach $subchans as $chan}%
	<li><a href="%{$chan['link']}%">%{$chan['name']}%</a></li>
	%{/foreach}%
</ul>
	
%{if $body}%
	</div>
%{/if}%

</div>
