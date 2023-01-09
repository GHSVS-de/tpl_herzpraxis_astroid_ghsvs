<?php
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Language\Text;
?>
<div class="blog-category<?php echo $this->pageclass_sfx; ?>" itemscope itemtype="https://schema.org/Blog">

	<?php
	#### SEITENÜBERSCHRIFT (Menü)
	echo LayoutHelper::render('ghsvs.page_heading',
		['params' => $this->params]);
	#### ENDE - SEITENÜBERSCHRIFT (Menü)
	?>

	<?php if ($this->params->get('show_description') && $this->category->description) : ?>
	<div class="category-desc clearfix">
		<?php echo HTMLHelper::_('content.prepare', $this->category->description, '', 'com_content.category'); ?>
	</div>
	<?php endif; ?>

  <?php if (!empty($this->lead_items)) : ?>
		<?php
		$blogClass = 'row-cols-1';
		?>
    <div class="row <?php echo $blogClass ?>">
      <?php foreach ($this->lead_items as &$item) : ?>
        <div class="col  mb-3">
          <article class="card h-100 item-page item-leading" itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
						<?php
						$this->item = &$item;
						echo $this->loadTemplate('item');
						?>
					</article>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <?php if (!empty($this->intro_items)) : ?>
		<?php
		$blogClass = 'row-cols-1 g-3 g-xl-4';

		if (($columns =(int) $this->params->get('num_columns')) > 1)
		{
			$blogClass .= ' row-cols-md-2';

			if ($columns >= 3)
			{
				$blogClass .= ' row-cols-xl-3';
			}
		} ?>
		<div class="row <?php echo $blogClass ?>">
      <?php foreach ($this->intro_items as $key => &$item) : ?>
        <div class="col">
					<article class="card h-100 item-page item-intro" itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
						<?php
						$this->item = &$item;
						echo $this->loadTemplate('item');
						?>
					</article>
        </div><!--/col-->
      <?php endforeach; ?>
    </div><!--/row row-cols-* -->
  <?php endif; ?>

	<?php if (!empty($this->link_items)) : ?>
		<div class="items-more">
			<h3><?php echo Text::_('COM_CONTENT_MORE_ARTICLES'); ?></h3>
			<?php echo $this->loadTemplate('links'); ?>
		</div>
	<?php endif; ?>
	<?php
	/* Unten. Hat einen Sprunganker. Hat extra großen Abstand oben, wegen dem
	blöden sticky Header */
	echo LayoutHelper::render('ghsvs.paginationLinks', [
		'pagination' => $this->pagination,
		'params' => $this->params,
		'settings' => [
			'align' => 'center',
			'outerClasses' => 'mt-6rem mt-md-3',
			'echoBefore' => '<a id="PAGINATION_BLOCK" name="PAGINATION_BLOCK"></a>',
		] ]) ?>

</div>
