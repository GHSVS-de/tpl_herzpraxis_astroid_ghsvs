<?php
defined('_JEXEC') or die;

use Joomla\Registry\Registry;
use Joomla\CMS\Uri\Uri;

/*
$pagination: $this->pagination of category/featured view.
$params: $this->params of category/featured view.
$settings: Array 		'settings' => [
			'align' => 'end',
			'paginationClasses' => ' d-none d-md-block',
			'outerClasses' => 'mt-3',
			'sprungLinkClasses' => ' d-block d-md-none',
			'sprungLinkHref' => '#PAGINATION_BLOCK',

			'echoBefore' => '<a id="PAGINATION_BLOCK" name="PAGINATION_BLOCK"></a>',
		],
*/

extract($displayData);

if ($pagination->pagesTotal < 2)
{
	return;
}

$settings = is_array($settings) ? $settings : [];
$registry = new Registry($settings);
$sprungLink = '';
$paginationClasses = $registry->get('paginationClasses') ? ' class="'
	. $registry->get('paginationClasses') . '"' : '';

$outerClasses = $registry->get('outerClasses') ? ' class="'
	. $registry->get('outerClasses') . '"' : '';

$align = $registry->get('align');

if (($sprungLinkClasses = $registry->get('sprungLinkClasses'))
	&& ($sprungLinkHref = $registry->get('sprungLinkHref')))
{
	$href = Uri::getInstance()->toString() . $sprungLinkHref;
	$sprungLinkClasses .= $align ? ' text-' . $align : '';

	$sprungLink = '<a href="' . $href  . '" class="' . $sprungLinkClasses  . '"
		aria-hidden="true">
		{svg{bi/arrow-bar-down}}Zur Seiten-Navigation{svg{bi/arrow-bar-down}}
	</a>';
} ?>

<div<?php echo $outerClasses; ?>>
	<?php echo $registry->get('echoBefore', ''); ?>

	<?php
	if ($params->get('show_pagination_results', 1))
	{ ?>
		<!--mb-0 wegen SprungLink, der nicht immer angezeigt wird-->
		<p class="counter mb-0<?php echo ($align ? ' text-' . $align : ''); ?>">
			<?php echo $pagination->getPagesCounter(); ?>
		</p>
	<?php
	} ?>

	<div<?php echo $paginationClasses; ?>>
		<?php	echo $pagination->getPaginationLinks(null, $settings); ?>
	</div>
	<?php echo $sprungLink; ?>
</div>
