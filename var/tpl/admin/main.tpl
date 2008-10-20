{css '/data/admin/css/screen.css'}

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	
	<td width="337" rowspan="2" background="{link '/data/admin/img/back_red.png'}">
		<img src="{link '/data/admin/img/logo.png'}">
	</td>

	<td align="right" valign="top" background="{link '/data/admin/img/back_red.png'}">
	
	<table border="0" cellspacing="0" cellpadding="0">
		<tr>
		<td width="1" align="left" valign="bottom" background="{link '/data/admin/img/back_grey.png'}">
			<img src="{link '/data/admin/img/up_rounded.png'}" width="4" height="4">
		</td>
		
		<td background="{link '/data/admin/img/back_grey.png'}">
		
		<table>
			<tr>
			<td class="admin_session">
				{foreach $langs as $code => $infos}
					<a href="{link $_URI, $infos['code']}" alt="{$infos['name']}">
						<img src="{link '/data/admin/img/flags/small/'.$code.'.gif'}" alt="{$infos['name']}" title="{$infos['name']}" />
					</a>
				-
				{/foreach}
				{@ 'Bienvenue, <strong>%s</strong> (%s)', $user['name'], $user['email']}
				{$page_topbar}
			</td>
			<td>
				<a href="/logout">
				<img border="0" src="/img/icons/disconnect_22.gif" title="Déconnexion"/>
				</a>
			</td>
			</tr>
		</table>
		
		</td>
		</tr>
	</table>
	
	<table border="0" cellspacing="0" cellpadding="0">
		<tr>
		<td width="1" align="left" valign="bottom">
		</td>
		
		<td background="{link '/data/admin/img/back_red.png'}">
		
		<table>
			<tr>
			<td class="admin_subtop">
				{$page_subtop}
			</td>
			</tr>
		</table>
		
		</td>
		</tr>
	</table>

	</td>
	</tr>
	<tr>
		<td width="100%" align="right" valign="bottom" background="{link '/data/admin/img/back_red.png'}">
		<img src="{link '/data/admin/img/left_bottom_banner_rounded.png'}" width="14" height="8">
	</td>
	</tr>
</table>

<!-- Header Menu -->
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	<tr>
	<td>
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
		<tr>
		<td width="9">
			<img src="{link '/data/admin/img/menu/back_01.png'}">
		</td>
		<td align="left" background="{link '/data/admin/img/menu/back_02.png'}" class="admin_subtitle">
			{$navigation}
			
		</td>
		<td width="9">
			<img src="{link '/data/admin/img/menu/back_03.png'}">
		</td>
		</tr>
	</table>
	</td>
	</tr>
</table>

<!-- Content Menu -->
<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="admin_content">
	<tr>
	{if $page_sidebar}
	<td align="left" valign="top" class="admin_sidebar">
		{foreach $page_sidebar as $sidebar}
		<div class="admin_sidebar_element">
			<h2>{$sidebar["title"]}</h2>
			<div class="admin_sidebar_data">{$sidebar["data"]}</div>
		</div>
		{/foreach}
	</td>
	{/if}
	<td width="100%" align="left" valign="top">
		<div id="main" class="admin_body">
			{if $page_subtitle}<h1>{$page_subtitle}</h1>{/if}
			{$body}
		</div>
	</td>
	</tr>
</table>

<!-- Footer Menu -->
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	<tr>
	<td width="9">
		<img src="{link '/data/admin/img/bot/01.png'}">
	</td>
	<td align="left" width="100%" background="{link '/data/admin/img/bot/02.png'}">
		<div class="admin_bottom">
		Copyright 2007 <a href="http://binarysec.com" target="_blank">BinarySEC</a>{$bottom}
		</div>
	</td>
	<td width="9">
		<img src="{link '/data/admin/img/bot/03.png'}">
	</td>
	</tr>

</table>
