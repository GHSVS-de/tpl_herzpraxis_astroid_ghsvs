<?php
/*
Ein Offcanvas-Button speziell für Astroid-Headers.
Für Buttons, die über einen connector-key (eindeutige id) mit Modals verbunden
werden können.
Wenn man sr-only oder aria-xy-Zeugs in der Buttonbeschriftung haben möchte,
kann man das z.B. über Sprachstring machen.
Für die Button-Class wird das "Modulklassensuffix" "missbraucht". Es reicht z.B.
"btn-danger", um das default "btn-warning" zu überschreiben. Nicht ganz schön,
aber aus B\C-Gründen so gemacht.
Siehe: offcanvas-content-id-bound.php
*/
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

echo PHP_EOL . '<!--File: ' . str_replace(JPATH_SITE, '', dirname(__FILE__)) . '/'. basename(__FILE__) . '-->' . PHP_EOL;

if (
	$params->get('robotsHide', 0) === 1
	&& Factory::getApplication()->client->robot
){
	return '';
}

/* To calculate a unique id for both participating modules (button and modal)
we need a identical base id in both modules. */
JLoader::register('Bs3ghsvsArticle',
	JPATH_PLUGINS . '/system/bs3ghsvs/Helper/ArticleHelper.php'
);
$modalId = Bs3ghsvsArticle::buildUniqueIdFromJinput(
	$params->get('connectorKey', ''));

$moduleSubHeader = $params->get('moduleSubHeader');
$buttonTitle = $module->showtitle ? $module->title
	: ($moduleSubHeader ?: 'GHSVS_MOBILEMENU_MENU');
$buttonClass = $moduleclass_sfx ? ' ' . $moduleclass_sfx : '';
?>
<div class="d-flex justify-content-end order-last">
	<div class="align-self-center">
		<button aria-label="<?php echo Text::_('GHSVS_MOBILEMENU_TOGGLE'); ?>"
			class="btn btn-offcanvas-menu<?php echo $buttonClass; ?>" type="button"
			data-bs-toggle="offcanvas"
			data-bs-target="#<?php echo $modalId; ?>"
			aria-controls="<?php echo $modalId; ?>" >
			{svg{bi/list}}<span class="buttonTitle"><?php echo Text::_($buttonTitle); ?></span>
		</button>
	</div>
</div>
