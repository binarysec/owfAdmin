{* ça rox man ! *}
<h2>Mes routes</h2>
<ul>
{foreach $routes as $route}
	<li class="cat_open">
		<a href="{$route['link']}" title="{$route['name']}">{$route['name']}</a>
	</li>
{/foreach}
</ul>
