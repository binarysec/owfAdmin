<ul>
{if $show_return}
<li><a href="{link '/admin/system/preferences'}">Revenir à la liste des groupes</a></li>
{/if}
{foreach $groups as $group}
<li><a href="{$group[1]}">{$group[0]->description}</a></li>
{/foreach}
</ul>