<?php
/*
page_heading.php
2015-12-22
H1-Seitenüberschrift (Menü).
*/
\defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Helper\ModuleHelper;

$params = $displayData['params'];

// Die Seitenüberschrift im Menü.
if ($page_heading = ($params->get('show_page_heading') ? trim($params->get('page_heading', '')) : ''))
{
	$page_heading = '<span class="page_heading_main">' . $page_heading . '</span>';

	// Für Kategorie-Menüeinträge kann man Joomla-eigenes "page_subheading" angeben.
	// Zusätzlich gibt es ein "page_subheading_ghsvs", da nicht alle Menü-Typen "page_subheading" haben
	// "page_subheading" overruled 'page_subheading_ghsvs'
	$page_subheading = $params->get('page_subheading') ?: $params->get('page_subheading_ghsvs');
	$page_subheading = $page_subheading
		? '<span class="page_subheading">('
			. $page_subheading
			. ')</span>' : '';

	// CSS-Klassen-Suffix. Eigenes Menüeintrags-Feld (bs3ghsvs Felder).
	$class = 'page-header' . $params->get('pageheader_suffix_ghsvs', '');
  ?>
	<h1 class="page_heading">
		<?php echo $page_heading; ?>
		<?php echo $page_subheading; ?>
	</h1>
<?php
} ?>
<?php
// Eine Modulposition kann zum Rendern angegeben werden.
$position = !empty($displayData['bs3ghsvs.rendermodules-position'])
	? $displayData['bs3ghsvs.rendermodules-position'] : 'unter-page_heading';
$modules = HTMLHelper::_('bs3ghsvs.rendermodules', $position, ['style' => 'html5']);

if ($modules)
{
	echo $modules;
}
