<?php

defined('_JEXEC') or die;
extract($displayData);
Astroid\Framework::getDebugger()->log('Render Body');

$document = Astroid\Framework::getDocument();

// GHSVS. 1 Joomla-Zeile setMetaData in index.php reicht vollkommen:
//Astroid\Helper\Head::meta(); // site meta

Astroid\Helper\Head::scripts(); // site scripts
// Astroid\Helper\Head::favicon(); // site favicon

if ($document->isDev()) { // check is dev
    $document->include('comingsoon'); // load coming soon and return
    return;
}
$document->include('bodyStart'); // Body Start

$params = Astroid\Framework::getTemplate()->getParams();
$layout = Astroid\Framework::getTemplate()->getLayout();

$header = $params->get('header', TRUE);
$header_mode = $params->get('header_mode', 'horizontal');

$astroid_content_class = ['astroid-content']; // astroid_content_class

if ($header && !empty($header_mode) && $header_mode == 'sidebar')
{
    $astroid_content_class[] = 'has-sidebar';
    $astroid_content_class[] = 'sidebar-dir-' . $params->get('header_sidebar_menu_mode', 'left');
}

if ($header && !empty($header_mode) && $header_mode != 'sidebar')
{
    $document->addScript('vendor/jquery/jquery.easing.min.js', 'body');
}
?>
<!-- astroid container -->
<div class="astroid-container">
	<?php
	echo PHP_EOL . '<!--containerStart-->' . PHP_EOL;
	$document->include('containerStart'); // Container Start
	echo PHP_EOL . '<!--/containerStart-->' . PHP_EOL;

	echo PHP_EOL . '<!--header.sidebar-->' . PHP_EOL;
	$document->include('header.sidebar');
	echo PHP_EOL . '<!--/header.sidebar-->' . PHP_EOL;

	echo PHP_EOL . '<!--offcanvas-->' . PHP_EOL;
	$document->include('offcanvas');
	echo PHP_EOL . '<!--/offcanvas-->' . PHP_EOL;

	echo PHP_EOL . '<!--mobilemenu-->' . PHP_EOL;
	$document->include('mobilemenu');
	echo PHP_EOL . '<!--/mobilemenu-->' . PHP_EOL;
	?>
	<!-- astroid content -->
	<div class="<?php echo implode(' ', $astroid_content_class); ?>">
		<?php
		echo PHP_EOL . '<!--contentStart-->' . PHP_EOL;
		$document->include('contentStart');
		echo PHP_EOL . '<!--/contentStart-->' . PHP_EOL;
		?>
		<!-- astroid layout -->
		<div class="astroid-layout astroid-layout-<?php echo $params->get('template_layout', 'wide') ?>">
			<?php
			echo PHP_EOL . '<!--layoutStart-->' . PHP_EOL;
			$document->include('layoutStart');
			echo PHP_EOL . '<!--/layoutStart-->' . PHP_EOL;
			?>
			<div class="astroid-wrapper">
				<?php
				echo PHP_EOL . '<!--wrapperStart-->' . PHP_EOL;
				$document->include('wrapperStart');
				echo PHP_EOL . '<!--/wrapperStart-->' . PHP_EOL;
				?>
				<?php
				echo PHP_EOL . '<!--Astroid\Element\Layout::render()-->' . PHP_EOL;
				echo Astroid\Element\Layout::render();
				echo PHP_EOL . '<!--/Astroid\Element\Layout::render()-->' . PHP_EOL;
				?>
				<?php
				echo PHP_EOL . '<!--wrapperEnd-->' . PHP_EOL;
				$document->include('wrapperEnd');
				echo PHP_EOL . '<!--/wrapperEnd-->' . PHP_EOL;
				?>
			</div><!--/astroid-wrapper-->
			<?php
			echo PHP_EOL . '<!--layoutEnd-->' . PHP_EOL;
			$document->include('layoutEnd');
			echo PHP_EOL . '<!--/layoutEnd-->' . PHP_EOL;
			?>
		</div><!--/astroid-layout-->
		<?php
		echo PHP_EOL . '<!--contentEnd-->' . PHP_EOL;
		$document->include('contentEnd');
		echo PHP_EOL . '<!--/contentEnd-->' . PHP_EOL;
		?>
	</div><!--/astroid-content-->
	<?php
	echo PHP_EOL . '<!--containerEnd-->' . PHP_EOL;
	$document->include('containerEnd');
	echo PHP_EOL . '<!--/containerEnd-->' . PHP_EOL;
	?>
</div><!--/astroid-container-->
<?php
echo PHP_EOL . '<!--bodyEnd-->' . PHP_EOL;
$document->include('bodyEnd');
echo PHP_EOL . '<!--/bodyEnd-->' . PHP_EOL;
?>
<?php
// $document->include('preloader');
// $document->include('backtotop');
?>
<?php Astroid\Framework::getDebugger()->log('Render Body'); ?>
<jdoc:include type="modules" name="debug" style="none" />
