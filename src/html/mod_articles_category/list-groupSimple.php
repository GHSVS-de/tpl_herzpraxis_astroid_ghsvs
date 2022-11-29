<?php
defined('_JEXEC') or die;

if (!$list)
{
	return;
}
?>
<div class="mod_articles_category list-groupSimple">
	<div class="list-group category-module mod-list">
		<?php foreach ($list as $item)
		{
			$ariaCurrent = $item->active ? ' aria-current="true"' : ''; ?>
			<a href="<?php echo $item->link; ?>"<?php echo $ariaCurrent; ?>
				class="list-group-item list-group-item-action <?php echo $item->active; ?>">
				<?php echo $item->title; ?>
			</a>
		<?php
		} // foreach ?>
	</div>
</div>
