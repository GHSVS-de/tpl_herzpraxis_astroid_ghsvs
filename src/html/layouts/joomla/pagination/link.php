<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

$item    = $displayData['data'];
$display = $item->text;
$app = Factory::getApplication();

switch ((string) $item->text)
{
	// Check for "Start" item
	case Text::_('JLIB_HTML_START') :
		$icon = $app->getLanguage()->isRtl() ? '{svg{bi/skip-end}}'
			: '{svg{bi/skip-start}}';
		#$aria = Text::sprintf('JLIB_HTML_GOTO_PAGE', $item->text);
		$aria = "Gehe zur ersten Seite";
		break;

	// Check for "Prev" item
	case $item->text === Text::_('JPREV') :
		$item->text = Text::_('JPREVIOUS');
		$icon = $app->getLanguage()->isRtl() ? '{svg{bi/skip-forward}}'
			: '{svg{bi/skip-backward}}';
		#$aria = Text::sprintf('JLIB_HTML_GOTO_PAGE', $item->text);
		$aria = "Gehe eine Seite zurück";
		break;

	// Check for "Next" item
	case Text::_('JNEXT') :
		$icon = $app->getLanguage()->isRtl() ? '{svg{bi/skip-backward}}'
			: '{svg{bi/skip-forward}}';
		#$aria = Text::sprintf('JLIB_HTML_GOTO_PAGE', $item->text);
		$aria = "Gehe eine Seite vor";
		break;

	// Check for "End" item
	case Text::_('JLIB_HTML_END') :
		$icon = $app->getLanguage()->isRtl() ? '{svg{bi/skip-start}}'
			: '{svg{bi/skip-end}}';
		#$aria = Text::sprintf('JLIB_HTML_GOTO_PAGE', $item->text);
		$aria = "Gehe zur letzten Seite";
		break;

	default:
		$icon = null;
		$aria = Text::sprintf('JLIB_HTML_GOTO_PAGE', $item->text);
		break;
}

if ($icon !== null)
{
	$display = $icon;
}

if ($displayData['active'])
{
	if ($item->base > 0)
	{
		$limit = 'limitstart.value=' . $item->base;
	}
	else
	{
		$limit = 'limitstart.value=0';
	}

	$class = 'active';

	if ($app->isClient('administrator'))
	{
		$link = 'href="#" onclick="document.adminForm.' . $item->prefix . $limit . '; Joomla.submitform();return false;"';
	}
	elseif ($app->isClient('site'))
	{
		$link = 'href="' . $item->link . '"';
	}
}
else
{
	$class = (property_exists($item, 'active') && $item->active) ? 'active'
		: 'disabled';
}

?>
<?php if ($displayData['active']) : ?>
	<li class="page-item">
		<a aria-label="<?php echo $aria; ?>" <?php echo $link; ?> class="page-link">
			<?php echo $display; ?>
		</a>
	</li>
<?php elseif (isset($item->active) && $item->active) : ?>
	<?php $aria = Text::sprintf('JLIB_HTML_PAGE_CURRENT', $item->text); ?>
	<li class="<?php echo $class; ?> page-item">
		<span aria-current="true" aria-label="<?php echo $aria; ?>" class="page-link"><?php echo $display; ?></span>
	</li>
<?php else : ?>
	<li class="<?php echo $class; ?> page-item">
		<span class="page-link" aria-hidden="true"><?php echo $display; ?></span>
	</li>
<?php endif; ?>
