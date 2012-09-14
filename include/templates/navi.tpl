<ul class="navi">
{foreach from=$ARRAY item=group key=gname}
	<li>
		<h2>{$gname}</h2>
		<ul>
			{foreach from=$group key=name item=url}
				<li><a href="{$url}">{$name}</a></li>
			{/foreach}
		</ul>
	</li>
{/foreach}
</ul>