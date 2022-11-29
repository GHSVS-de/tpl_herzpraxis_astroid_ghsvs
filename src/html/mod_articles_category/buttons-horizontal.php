<?php
defined('_JEXEC') or die;

if (!$list)
{
	return;
}
?>
<div class="mod_articles_category buttons-horizontal d-grid gap-2 d-lg-flex
	justify-content-lg-center">
	<?php foreach ($list as $item)
	{
		$ariaCurrent = $item->active
			? ' aria-current=true aria-disabled=true" tabindex="-1"' : ''; ?>
		<a href="<?php echo $item->link; ?>" role=button<?php echo $ariaCurrent; ?>
			class="btn btn-outline-danger<?php echo $item->active ? ' active disabled' : ''; ?>">
			<?php echo $item->title; ?>
		</a>
	<?php
	} // foreach ?>
</div>
