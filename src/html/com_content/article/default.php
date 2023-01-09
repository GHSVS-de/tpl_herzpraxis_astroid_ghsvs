<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Associations;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Content\Administrator\Extension\ContentComponent;
use Joomla\Component\Content\Site\Helper\RouteHelper;

// Create shortcuts to some parameters.
$params  = $this->item->params;
$canEdit = $params->get('access-edit');
$user    = Factory::getUser();
$info    = $params->get('info_block_position', 0);
$htag    = $this->params->get('show_page_heading') ? 'h2' : 'h1';

// Check if associations are implemented. If they are, define the parameter.
$assocParam        = (Associations::isEnabled() && $params->get('show_associations'));
$currentDate       = Factory::getDate()->format('Y-m-d H:i:s');
$isNotPublishedYet = $this->item->publish_up > $currentDate;
$isExpired         = !is_null($this->item->publish_down) && $this->item->publish_down < $currentDate;

$links = $this->loadTemplate('links');

$beforeDisplayContent = $this->item->event->beforeDisplayContent;
$afterDisplayContent = $this->item->event->afterDisplayContent;
$afterDisplayTitle = $this->item->event->afterDisplayTitle;

$useDefList = $params->get('show_modify_date')
		|| $params->get('show_publish_date') || $params->get('show_create_date')
		|| $params->get('show_hits') || $params->get('show_category')
		|| $params->get('show_parent_category') || $params->get('show_author')
		|| $assocParam;
?>

<?php
#### SEITENÜBERSCHRIFT (Menü)
echo LayoutHelper::render('ghsvs.page_heading', ['params' => $this->params]);
#### ENDE - SEITENÜBERSCHRIFT (Menü)
?>

<article class="com-content-article card item-page <?php echo $this->pageclass_sfx; ?>">

	<div class=card-header>
		<<?php echo $htag; ?> itemprop="headline">
			<?php echo $this->escape($this->item->title); ?>
			<?php
				echo LayoutHelper::render('ghsvs.articleSubtitle',
					['item' => $this->item]);
			?>
		</<?php echo $htag; ?>>

		<?php echo $afterDisplayTitle; ?>
	</div><!--/card-header-->

	<div class=card-body>

		<?php if ($beforeDisplayContent)
		{ ?>
			<div class=card-text><?php echo $beforeDisplayContent; ?></div>
		<?php
		} ?>

		<?php echo LayoutHelper::render('ghsvs.full_image', ['item' => $this->item]); ?>
		<div itemprop="articleBody" class="com-content-article__body card-text">
			<?php echo $this->item->text; ?>
		</div>

		<?php if ($links)
		{ ?>
			<div class=card-text>
			<h3>Links</h3>
			<?php echo $links; ?></div>
		<?php
		} ?>

		<?php if ($afterDisplayContent)
		{ ?>
			<div class=card-text><?php echo $afterDisplayContent; ?></div>
		<?php
		} ?>

	</div><!--/card-body-->

	<?php if ($useDefList || !empty($this->item->pagination)) : ?>
		<div class=card-footer>
			<?php if ($useDefList)
			{
				echo LayoutHelper::render('joomla.content.info_block', array('item' => $this->item, 'params' => $params, 'position' => 'below'));
			} ?>
			<?php if (!empty($this->item->pagination))
			{
				echo $this->item->pagination;
			} ?>
		</div><!--/card-footer-->
	<?php endif; ?>
</article><!--/card-->
