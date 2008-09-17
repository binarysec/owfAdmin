{css '/data/admin/css/screen.css'}

<div class="page_notice">
	<p>
		Vous &ecirc;tes authentifi&eacute; en tant que <strong>k&eacute;o</strong>.
		Bienvenue dans l'interface d'administration Web de BinarySec&nbsp;!
	</p>
</div>

<div id="header">
	<form id="search" action="" method="POST">
		Rechercher&nbsp;: <input id="search_query" name="q" type="text" value="" />
		<input type="submit" value="Go" />
	</form>
	<h1>Panneau d'administration{if $page_subtitle}::{$page_subtitle}{/if}</h1>
</div>

<div id="help">
	<h2>{$help_title}</h2>
	<p>{$help_text}</p>
</div>

<div id="separation"></div>

<div id="sidebar">
	<span id="sidebar_header"><a href="javascript:history.go(-1);">&laquo;</a></span>
	<h2>Modules d'administration</h2>

	<ul>
		{foreach $sidebar_sections as $i => $section}
			{if $section['level'] == 0}</ul><ul>{/if}
			<li class="section_l{$section['level']}{if $section['selected']} selected{/if} {$section['style']}">
				<a href="{$section['link']}" title="{$section['name']}">{$section['name']}</a>
			</li>
		{/foreach}
	</ul>
	{$sidebar_ext}
	<ul>
		<li class="option"><a href="#">Se connecter en tant que...</a></li>
	</ul>
</div>

<div id="hint">
	<p>{$page_hint}</p>
</div>

<div id="main">
	{$body}

	{if $errors}
		<div align="center">
			<div class="warning">
				<h2>Attention</h2>
				<ol class="text">
					{foreach $errors as $error}
						<li>{$error}</li>
					{/foreach}
				</ol>
			</div>
		</div>
	{/if}
</div>
