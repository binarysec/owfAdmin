<div data-role="content">

%{if $body}%
	<div class="content-secondary">
	%{$body}%
	</div>
	<div class="content-primary">
%{/if}%
	<ul data-role="listview" data-inset="true" %{if(count($subchans) > 5)}%data-filter="true"%{/if}% data-filter-placeholder="%{@ 'Search ...'}%">
		%{foreach $subchans as $chan}%
		<li><a href="%{$chan['link']}%">%{$chan['name']}%</a></li>
		%{/foreach}%
	</ul>
	
%{if $body}%
	</div>
%{/if}%

</div>
