<?php
/*
GHSVS Override wegen ghsvs.page_heading.
Ansonsten Joomla 4.1.2
*/
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

/**
 * Note that this layout opens a div with the page class suffix. If you do not use the category children
 * layout you need to close this div either by overriding this file or in your main layout.
 */
$params    = $displayData->params;
$category  = $displayData->get('category');
$extension = $category->extension;
$canEdit   = $params->get('access-edit');
$className = substr($extension, 4);
$htag	   = $params->get('show_page_heading') ? 'h2' : 'h1';

$app = Factory::getApplication();

$category->text = $category->description;
$app->triggerEvent('onContentPrepare', array($extension . '.categories', &$category, &$params, 0));
$category->description = $category->text;

$results = $app->triggerEvent('onContentAfterTitle', array($extension . '.categories', &$category, &$params, 0));
$afterDisplayTitle = trim(implode("\n", $results));

$results = $app->triggerEvent('onContentBeforeDisplay', array($extension . '.categories', &$category, &$params, 0));
$beforeDisplayContent = trim(implode("\n", $results));

$results = $app->triggerEvent('onContentAfterDisplay', array($extension . '.categories', &$category, &$params, 0));
$afterDisplayContent = trim(implode("\n", $results));

$categoryDescription = ($params->get('show_description', 1) && trim($category->description))
	? $category->description : '';

/**
 * This will work for the core components but not necessarily for other components
 * that may have different pluralisation rules.
 */
if (substr($className, -1) === 's')
{
	$className = rtrim($className, 's');
}

$tagsData = $category->tags->itemTags;
?>

<?php
#### SEITENÜBERSCHRIFT (Menü)
if ($params->get('show_page_heading'))
{
	echo LayoutHelper::render('ghsvs.page_heading',
		['params' => $params]);
}
#### ENDE - SEITENÜBERSCHRIFT (Menü)
?>

<div class="<?php echo $className . '-category card item-page' . $displayData->pageclass_sfx; ?>">

	<?php if ($params->get('show_category_title', 1)) : ?>
		<div class=card-header>
		<<?php echo $htag; ?>>
			<?php echo HTMLHelper::_('content.prepare', $category->title, '', $extension . '.category.title'); ?>
		</<?php echo $htag; ?>>
		</div><!--/card-header-->

		<?php echo $afterDisplayTitle; ?>
	<?php endif; ?>

	<div class=card-body>

		<?php if ($beforeDisplayContent)
		{ ?>
			<div class=card-text><?php echo $beforeDisplayContent; ?></div>
		<?php
		} ?>

		<?php if ($categoryDescription || $params->def('show_description_image', 1))
		{ ?>
			<div class=card-text>
				<?php if ($params->get('show_description_image')
					&& $category->getParams()->get('image'))
				{
					echo LayoutHelper::render('joomla.html.image', [
						'src' => $category->getParams()->get('image'),
						'alt' => empty($category->getParams()->get('image_alt')) && empty($category->getParams()->get('image_alt_empty')) ? false : $category->getParams()->get('image_alt'),
					] );
				} ?>

				<?php if ($categoryDescription)
				{
					echo HTMLHelper::_('content.prepare', $categoryDescription, '',
						$extension . '.category.description');
				} ?>

			</div>
		<?php
		} ?>
		<div class=card-text>
				<?php echo $displayData->loadTemplate($displayData->subtemplatename); ?>
		</div>
		<?php if ($afterDisplayContent)
		{ ?>
			<div class=card-text><?php echo $afterDisplayContent; ?></div>
		<?php
		} ?>

	</div><!--/card-body-->

	<?php if ($params->get('show_cat_tags', 1)) : ?>
		<div class=card-footer>
			<?php echo LayoutHelper::render('joomla.content.tags', $tagsData); ?>
		</div><!--/card-footer-->
	<?php endif; ?>

	<?php if ($displayData->maxLevel != 0 && $displayData->get('children')) : ?>
		<div class="cat-children card-body">
			<?php if ($params->get('show_category_heading_title_text', 1) == 1) : ?>
				<h3>
					<?php echo Text::_('JGLOBAL_SUBCATEGORIES'); ?>
				</h3>
			<?php endif; ?>
			<?php echo $displayData->loadTemplate('children'); ?>
		</div>
	<?php endif; ?>
</div><!--/card item-page-->
