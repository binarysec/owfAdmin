{css '/data/admin/css/screen.css'}
<div id="page" align="center">
	<div id="toppage" align="center">
		<div id="date">
			<div class="smalltext" style="padding:13px;">
				<strong>{$admin_date}</strong>
			</div>
		</div>
		<div id="topbar">
			<div align="right" style="padding:12px;" class="smallwhitetext">
				<a href="{link '/session/logout'}" title="Logout">Logout</a>
			</div>
		</div>
	</div>
	<div id="header" align="center">
		<div class="titletext" id="logo">
			<div class="logotext" style="margin:30px">
				<span class="orangelogotext">BS</span>.adm
			</div>
		</div>
		<div id="pagetitle">
			<div id="title" class="titletext" align="right">
				{$admin_title}{if $admin_subtitle}::{$admin_subtitle}{/if}
			</div>
		</div>
	</div>
	<div id="content" align="center">
		<div id="menu" align="right">
			<div align="right" style="width:189px; height:8px;"><img src="/index.php/data/admin/img/mnu_topshadow.gif" width="189" height="8" alt="mnutopshadow" /></div>
			<div id="linksmenu" align="center">
				<a href="{link '/admin'}" title="Administration">Administration</a>
				{foreach $admin_sidemenu as $link => $desc}
					<a href="{link $link}" title="{$desc}">{$desc}</a>
				{/foreach}
			</div>
			<div align="right" style="width:189px; height:8px;"><img src="/index.php/data/admin/img/mnu_bottomshadow.gif" width="189" height="8" alt="mnubottomshadow" /></div>
		</div>
	</div>
	<div id="contenttext">
		<div class="bodytext" style="padding:12px;" align="justify">
			{$admin_body}
		</div>
	</div>
	<div id="footer" class="smallgraytext" align="center">
		LINKS<br />
		COPYRIGHT
	</div>
</div>



