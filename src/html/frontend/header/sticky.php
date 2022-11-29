<?php
/*
GHSVS 2021:
Das meiste wurde entfernt, da nur noch BS5-Offcanvas-Modul als Menü verwendet
wird.
Im Template-Stil zu setzen:
Header Block 1: Module Position.
Block 1 Position: offcanvas (was aber nichts (mehr) mit dem Offcanvas von Astroid
zu tun hat.
Andere Menüeinstellungen sind deaktiviert oder auf "empty-dummy-menu", obwohl mit
diesem Override eh wurst.
*/
defined('_JEXEC') or die;

extract($displayData);

$params = Astroid\Framework::getTemplate()->getParams();
$document = Astroid\Framework::getDocument();
$class = ['astroid-header', 'astroid-header-sticky'];
$stickyheader = $params->get('stickyheader', 'sticky');
$class[] = 'header-' . $stickyheader . '-desktop';
$stickyheadermobile = $params->get('stickyheadermobile', 'sticky');
$class[] = 'header-' . $stickyheadermobile . '-mobile';
$stickyheadertablet = $params->get('stickyheadertablet', 'sticky');
$class[] = 'header-' . $stickyheadertablet . '-tablet';

$navWrapperClass = ['astroid-nav-wraper', 'align-self-center', 'px-2', 'd-none', 'd-lg-block'];
$mode = $params->get('header_horizontal_menu_mode', 'left');
$stickey_mode = $params->get('stickey_horizontal_menu_mode', 'center');

$block_1_type = $params->get('stickey_block_1_type', 'position');
$block_1_position = $params->get('stickey_block_1_position', 'offcanvas');
$block_1_custom = $params->get('stickey_block_1_custom', '');

switch ($stickey_mode)
{
	case 'left':
		$navWrapperClass[] = 'mr-auto';
	break;
	case 'right':
		$navWrapperClass[] = 'ml-auto';
	break;
	case 'center':
		$navWrapperClass[] = 'mx-auto';
	break;
}
?>
<!--header sticky.php-->
<header id="astroid-sticky-header" class="<?php echo implode(' ', $class); ?>
	d-none">
	<div class="d-flex flex-row justify-content-between div4maxWidth">

		<div class="header-left-section d-flex justify-content-start
			<?php echo $stickey_mode == 'left' ? ' flex-lg-grow-1' : ''; ?>">
			<?php $document->include('logo_sticky'); ?>
		</div>

		<?php if ($block_1_type != 'blank' || $stickey_mode == 'right') : ?>
			<div class="header-right-section d-flex justify-content-end
				<?php echo $stickey_mode == 'right' ? ' flex-lg-grow-1' : ''; ?>">
				<?php if ($block_1_type !== 'blank') : ?>
					<div class="header-right-block align-self-center">
						<?php if ($block_1_type === 'position')
							{
								echo $document->position($block_1_position, 'none');
							}
							elseif ($block_1_type === 'custom')
							{
								echo '<div class="header-block-item">';
								echo $block_1_custom;
								echo '</div>';
							}
						?>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</header>
<!--/header sticky.php-->
