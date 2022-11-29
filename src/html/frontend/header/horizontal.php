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
$mode = $params->get('header_horizontal_menu_mode', 'left');
$block_1_type = $params->get('header_block_1_type', 'blank');
$block_1_position = $params->get('header_block_1_position', '');
$block_1_custom = $params->get('header_block_1_custom', '');
$class = ['astroid-header', 'astroid-horizontal-header', 'astroid-horizontal-' . $mode . '-header'];
?>
<!--header horizontal.php-->
<header id="astroid-header" class="<?php echo implode(' ', $class); ?>">
	<div class="d-flex flex-row justify-content-between">
		<div class="header-left-section d-flex
			justify-content-start<?php echo $mode == 'left' ? ' flex-lg-grow-1' : ''; ?>">
			<?php $document->include('logo_normal'); ?>
    </div>

		<?php if ($block_1_type != 'blank' || $mode == 'right') : ?>
			<div class="header-right-section d-flex justify-content-end
				<?php echo $mode == 'right' ? ' flex-lg-grow-1' : ''; ?>">
				<?php if ($block_1_type !== 'blank') : ?>
					<div class="header-right-block align-self-center">
						<?php	if ($block_1_type === 'position')
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
<!--/header horizontal.php-->
