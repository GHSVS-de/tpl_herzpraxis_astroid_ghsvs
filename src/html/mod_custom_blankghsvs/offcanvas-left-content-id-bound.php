<?php
/*
BS5-Offcanvas speziell für Astroid-Headers.
Rendert Module in bestimmter Dummy-Position, z.B. offcanvasContentDummyGhsvs.
Das sind (derzeit) Menü-Module.
Hintergedanke: Ich will mehrere Menümodule im Offcanvas-Content rendern, aber nur
1 Button zum Öffnen.
Benötigt connector-key (eindeutige id), der mit Button synct.
Siehe: offcanvas-button-id-bound.php
*/
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Language\Text;

// @since 2023-12
use GHSVS\Plugin\System\Bs3Ghsvs\Helper\Bs3GhsvsArticleHelper as Bs3ghsvsArticle;

echo PHP_EOL . '<!--File: ' . str_replace(JPATH_SITE, '', dirname(__FILE__)) . '/'. basename(__FILE__) . '-->' . PHP_EOL;

if (
	$params->get('robotsHide', 0) === 1
	&& Factory::getApplication()->client->robot
){
	return '';
}

/* To calculate a unique id for both participating modules (button and modal)
we need a identical base id in both modules. */
$modalId = Bs3ghsvsArticle::buildUniqueIdFromJinput(
	$params->get('connectorKey', ''));

$moduleSubHeader = $params->get('moduleSubHeader');
$offcanvasHeader = $module->showtitle ? $module->title
	: ($moduleSubHeader ?: 'GHSVS_MOBILEMENU_MENU');
?>
<div class="offcanvas offcanvas-start" tabindex="-1" id="<?php echo $modalId; ?>"
	aria-labelledby="<?php echo $modalId; ?>Header">
  <div class="offcanvas-header bg-light">
    <h5 id="<?php echo $modalId; ?>Header">
			<?php echo Text::_($offcanvasHeader); ?>
		</h5>
		<?php	echo LayoutHelper::render('ghsvs.closeButtonTop',
			['options' => ['dismissType' => 'offcanvas']]); ?>
  </div>
  <div class="offcanvas-body">
		<?php
			echo HTMLHelper::_('bs3ghsvs.rendermodules', 'offcanvasLeftDummyGhsvs');
		?>
	</div>
</div><!--/offcanvas-->
