<?php
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Layout\LayoutHelper;
?>

<div class="blog-featured<?php echo $this->pageclass_sfx; ?>" itemscope itemtype="https://schema.org/Blog">

	<?php
	echo HTMLHelper::_('bs3ghsvs.layout', 'ghsvs.page_heading',
			array('params' => $this->params)
		); ?>

	<?php
	// Oben. blendet die Pagination-Links teils aus und zeigt stattdessen SprungLink.
	echo LayoutHelper::render('ghsvs.paginationLinks', [
		'pagination' => $this->pagination,
		'params' => $this->params,
		'settings' => [
			'align' => 'end',
			'paginationClasses' => 'd-none d-md-block',
			'sprungLinkClasses' => ' d-block d-md-none',
			'sprungLinkHref' => '#PAGINATION_BLOCK',
			'outerClasses' => 'mb-3 mb-md-0',
		],
		]
	); ?>

  <?php $leadingcount = 0; ?>
  <?php if (!empty($this->lead_items)) : ?>
    <div class="items-leading clearfix">
      <?php foreach ($this->lead_items as &$item) : ?>
        <div class="article-wraper">
          <div class="article-wraper-inner">
            <article class="item leading-<?php echo $leadingcount; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?><?php echo $item->featured ? ' item-featured' : ''; ?>" itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
              <?php
              $this->item = &$item;
              echo $this->loadTemplate('item');
              ?>
            </article>
          </div>
        </div>
        <?php $leadingcount++; ?>
      <?php endforeach; ?>
    </div><!-- end items-leading -->
  <?php endif; ?>

  <?php

  $introcount = (count($this->intro_items));
  $counter = 0;
  $columns = ASTROID_JOOMLA_VERSION > 3 ? 1 : $this->columns;

  ?>

  <?php if (!empty($this->intro_items)) : ?>
    <?php $row = $counter / $columns; ?>
		<div class="row row-cols-1">
      <?php foreach ($this->intro_items as $key => &$item) : ?>
        <?php $rowcount = ((int) $key % (int) $columns) + 1; ?>
        <div class="col">
					<article class="card" itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
						<?php
						$this->item = &$item;
						echo $this->loadTemplate('item');
						?>
					</article>
					<?php $counter++; ?>
        </div><!--/col-->
      <?php endforeach; ?>
    </div><!--/row row-cols-* -->
  <?php endif; ?>

  <?php if (!empty($this->link_items)) : ?>
    <?php echo $this->loadTemplate('links'); ?>
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
