<?php
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\Registry\Registry;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;

jimport('astroid.framework.article');
jimport('astroid.framework.template');
$template = Astroid\Framework::getTemplate();
$astroidArticle = new AstroidFrameworkArticle($this->item, true);
$params = $this->item->params;
$tpl_params = $template->getParams();
HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers/html');
$canEdit = $this->item->params->get('access-edit');
$info = $params->get('info_block_position', 0);
$useDefList = ($params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date') || $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category') || $params->get('show_author') || $tpl_params->get('astroid_readtime', 1));

// Post Format
$post_attribs = new Registry(json_decode($this->item->attribs));
$post_format = $post_attribs->get('post_format', 'standard');
?>
<?php
$image = trim(LayoutHelper::render('ghsvs.intro_image',
	[
	'item' => $this->item,
	'options' => ['classes' => 'div4imgBlog']
	]
));
?>

<div class="card-header">
	<?php echo LayoutHelper::render('joomla.content.blog_style_default_item_title', $this->item); ?>
</div>

<div class="card-body<?php echo $tpl_params->get('show_post_format') ? ' has-post-format' : ''; ?><?php echo (!empty($image) ? ' has-image' : ''); ?>">

	<?php echo HTMLHelper::_('bs3ghsvs.layout', 'ghsvs.termin',
		['item' => $this->item]
	); ?>

	<?php echo $image; ?>

	<?php if (!$params->get('show_intro')) : ?>
		<?php echo $this->item->event->afterDisplayTitle; ?>
	<?php endif; ?>

	<?php echo $this->item->event->beforeDisplayContent; ?>

	<?php echo $this->item->introtext; ?>
      <?php
      if ($params->get('show_readmore') && $this->item->readmore) :
         if ($params->get('access-view')) :
            $link = Route::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language));
         else :
            $menu = JFactory::getApplication()->getMenu();
            $active = $menu->getActive();
            $itemId = $active->id;
            $link1 = Route::_('index.php?option=com_users&view=login&Itemid=' . $itemId);
            $returnURL = Route::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language));
            $link = new Uri($link1);
            $link->setVar('return', base64_encode($returnURL));
         endif;
      ?>
         <?php echo LayoutHelper::render('joomla.content.readmore', array('item' => $this->item, 'params' => $params, 'link' => $link)); ?>
      <?php endif; ?>

</div><!--/card-body -->
<?php
$cardInfos = '';

if ( $useDefList)
{
	$cardInfos = LayoutHelper::render('joomla.content.info_block', array('item' => $this->item, 'params' => $params, 'position' => 'below'));
}
if (trim(strip_tags($cardInfos)))
{ ?>
<div class="card-footer"><?php echo $cardInfos; ?></div>
<?php } ?>

<?php echo $this->item->event->afterDisplayContent; ?>
