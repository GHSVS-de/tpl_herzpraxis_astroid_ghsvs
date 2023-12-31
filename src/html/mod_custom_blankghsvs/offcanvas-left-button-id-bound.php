<?php
/*
Ein Offcanvas-Button speziell für Bootstrap-Offcanvas.
Für Buttons, die über einen connector-key (eindeutige id) mit Modals verbunden
werden können.
Wenn man sr-only oder aria-xy-Zeugs in der Buttonbeschriftung haben möchte,
kann man das z.B. über Sprachstring machen.
Für die Button-Class wird das "Modulklassensuffix" "missbraucht". Es reicht z.B.
"btn-danger", um das default "btn-warning" zu überschreiben. Nicht ganz schön,
aber aus B\C-Gründen so gemacht.
Siehe: offcanvas-left-content-id-bound.php
*/
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
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
$buttonTitle = $module->showtitle ? $module->title
	: ($moduleSubHeader ?: 'GHSVS_MOBILEMENU_MENU');
$buttonClass = $moduleclass_sfx ? ' ' . $moduleclass_sfx : '';
?>

<button
	aria-label="<?php echo Text::_('Seitenbereich mit Teilenknöpfen ausfahren'); ?>"
	class="btn btn-warning p-0 px-1 <?php echo $buttonClass; ?>" type="button"
	data-bs-toggle="offcanvas"
	data-bs-target="#<?php echo $modalId; ?>"
	aria-controls="<?php echo $modalId; ?>" >
	<?php echo Text::_($buttonTitle); ?>
</button>
