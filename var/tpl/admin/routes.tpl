<div data-role="content">

%{if $body}%
	<div class="content-secondary">
	%{$body}%
	</div>
	<div class="content-primary">
%{/if}%
	<ul data-role="listview" data-inset="true" data-filter="true" data-filter-placeholder="%{@ 'Search ...'}%">
		%{foreach $subchans as $chan}%
		<li><a href="%{$chan['link']}%">%{$chan['name']}%</a></li>
		%{/foreach}%
	</ul>
	
%{if $body}%
	</div>
%{/if}%

</div>
