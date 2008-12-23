{foreach $form_hidden_elements as $id => $element}
	{$element->render()}
{/foreach}
<table style="border-left: 6px solid #ddd;">
	{foreach $form_elements as $id => $element}
	<tr>
		<td style="width: 150px; font-weight: bold;">
			{if $element->label}
			<label for="{$id}">{$element->label}&nbsp;:</label>
			{/if}
		</td>
		<td style="width: 200px; vertical-align: top;">
			{$element->render()}
		</td>
	</tr>
	{/foreach}
</table>
