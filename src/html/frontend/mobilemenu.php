<?php
defined('_JEXEC') or die;
extract($displayData);

$params = Astroid\Framework::getTemplate()->getParams();
$document = Astroid\Framework::getDocument();

$header = $params->get('header', TRUE);
$header_mobile_menu = $params->get('header_mobile_menu', '');

if (!$header || empty($header_mobile_menu))
{
	return;
}

// $dir = 'left';
$dir = 'right';

$header = $params->get('header', TRUE);
$header_mode = $params->get('header_mode', 'horizontal');
$mode = $params->get('header_sidebar_menu_mode', 'left');
$dir = $header ? ($header_mode == 'sidebar' ? $mode : $dir) : $dir;
$document->addScript('vendor/astroid/js/offcanvas.js', 'body');
$document->addScript('vendor/astroid/js/mobilemenu.js', 'body');
?>
<div class="astroid-mobilemenu d-none d-init dir-<?php echo $dir; ?>"
	data-class-prefix="astroid-mobilemenu" id="astroid-mobilemenu">
	<div class="burger-menu-button active">
		<button aria-label="Mobile Menu Toggle" type="button" class="button close-offcanvas offcanvas-close-btn">
			<span class="box"><span class="inner"></span></span>
    </button>
	</div>
	<?php Astroid\Component\Menu::getMobileMenu($header_mobile_menu); ?>
</div>
<?php
$style = '.mobilemenu-slide.astroid-mobilemenu{visibility:visible;-webkit-transform:translate3d(' . ($dir == 'left' ? '-' : '') . '100%, 0, 0);transform:translate3d(' . ($dir == 'left' ? '-' : '') . '100%, 0, 0);}.mobilemenu-slide.astroid-mobilemenu-open .mobilemenu-slide.astroid-mobilemenu {visibility:visible;-webkit-transform:translate3d(0, 0, 0);transform:translate3d(0, 0, 0);}.mobilemenu-slide.astroid-mobilemenu::after{display:none;}';
$document->addStyledeclaration($style);
?>
