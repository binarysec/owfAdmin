{css '/data/admin/css/screen.css'}

{if $user['id'] > 0}
	<div class="banner_notice">
		<p>
			Vous &ecirc;tes authentifi&eacute; en tant que <strong>{$user['email']}</strong>.
			<a href="{link '/session/logout'}" title="Se d&eacute;connecter">
				Cliquez-ici pour vous d&eacute;connecter.
			</a>
		</p>
	</div>
{else}
	<div class="banner_error">
		<p>
			Vous n'&ecirc;tes pas autoris&eacute; &agrave;
			acc&eacute;der &agrave; cet espace priv&eacute;.
			<a href="{link '/session/login'}" title="S'authentifier">
				Cliquez-ici pour vous authentifier.
			</a>
		</p>
	</div>
{/if}

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
		<li class="option"><a href="{link '/session/login'}">Se connecter en tant que...</a></li>
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
