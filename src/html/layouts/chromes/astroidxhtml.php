<?php
defined('_JEXEC') or die;
extract($displayData);

$moduleTag     = $params->get('module_tag', 'div');
$headerTag     = htmlspecialchars($params->get('header_tag', 'h5'), ENT_COMPAT, 'UTF-8');
$bootstrapSize = (int) $params->get('bootstrap_size', 0);
$moduleClass   = trim($bootstrapSize != 0 ? ' span' . $bootstrapSize : '');

// Temporarily store header class in variable
$headerClass = $params->get('header_class');
$headerClass = $headerClass ? ' class="module-title ' . htmlspecialchars($headerClass, ENT_COMPAT, 'UTF-8') . '"' : ' class="module-title"';

// GHSVS. Additional class for 'moduletable'.
$cssClass = ['moduletable'];

if (trim($params->get('moduleclass_sfx', '')))
{
	$cssClass[] = $params->get('moduleclass_sfx', '');
}

if ($moduleClass)
{
	$cssClass[] = $moduleClass;
}

$layout = explode(':', $params->get('layout'))[1];
$cssClass[] = $module->module . '_' . $layout;
$cssClass = implode(' ', $cssClass);
?>
<<?php echo $moduleTag; ?> class="<?php echo $cssClass; ?>">
	<?php	if ($module->showtitle != 0)
	{ ?>
	<<?php echo $headerTag . $headerClass . '>' . $module->title;?></<?php echo $headerTag; ?>>
	<?php
	} ?>
	<?php echo $module->content; ?>
</<?php echo $moduleTag; ?>>
