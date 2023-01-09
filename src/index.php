<?php
defined('_JEXEC') or die;
defined('_ASTROID') or die('Please install and activate Astroid Framework in order to use this template.');

use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Layout\LayoutHelper;
use GHSVS\Template\HerzpraxisAstroidGhsvs\Site\Helper\TemplateHelper;

if (! ($done = PluginHelper::isEnabled('system', 'astroidghsvs'))) {
	die('Please install or activate and/or configure plugin "plg_system_astroidghsvs" in order to use this template.');
}

$wa = $this->getWebAssetManager();
$wa->usePreset('herzpraxis_astroid_ghsvs.framework');

$isRobot = Factory::getApplication()->client->robot;

if ($done)
{
	/*
	 * OPTIONAL possibility to override all or some parameters of
	 *  AstroidGhsvsHelper::$compileSettingsDefault (= Settings of plg__astroidghsvs).
	 * But you don't have to! Leave array empty or remove if you like default
	 * 	settings.
	 * Heads up! The Helper does not protect you in the case of incorrect
	 * 	entries like wrong folders or so.
	 */
		AstroidGhsvsHelper::$compileSettingsCustom = [
		// 'sourceMaps' => false,
		'scssFolder' => 'scss-ghsvs',
		// ## Needs AstroidGhsvsHelper::$replaceThis comment in template index.php:
		'placeHolderMode' => true,
		// ## Set to -1 if you want to disable compiling completely.
		// 'forceSCSSCompilingGhsvs' => 0,
		// 'includeStyleId' => true,
		'ignoreAstroidVariables' => 1,
	];

	if ($isRobot)
	{
		AstroidGhsvsHelper::$compileSettingsCustom = [
			'forceSCSSCompilingGhsvs' => -2,
		];
	}
	else
	{
		/*
		These scss files (enter without extension!) must be in scss folder of
		this template (see parameter 'scssFolder' (default: 'scss-ghsvs'))!
		Only 'template' will include Astroid variables automatically. Others not.
			(See parameter 'mainCssName' (default: 'template')).
		'template' will compile 'scss-ghsvs/template.scss' to 'css/template.css'
		and 'css/template.min.css'
		and according sourcemap files if activated (see parameter 'sourceMaps'
		(default: false)).
		The resulting CSS files will be included in the template if not marked
		with a '|noInsert'. See
		Der Befehl zum Kompilieren wird in einem System-Plugin in
		"public function onAfterAstroidRender()" abgefeuert.
		*/
		AstroidGhsvsHelper::$filesToCompile = [
			//'editorghsvs|noInsert',
			//'slick|noInsert',
			//'template-zalta|noInsert',
			'template',
			'mod_splideghsvs|noInsert',
			'toTop|noInsert',
		];

		/* If your template is NOT an Astroid template the plugin method
		onAfterAstroidRender() is not fired. Therefore activate this line then: */
		# $done = AstroidGhsvsHelper::runScssGhsvs('');
	}
}

$document = Astroid\Framework::getDocument();
$this->setMetaData('viewport', 'width=device-width, initial-scale=1');
$this->setHtml5(true);
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" class="no-js jsNotActive">
	<head>
		<!--astroid head-meta--><astroid:include type="head-meta" /><!--/astroid head-meta-->
		<jdoc:include type="metas" />
		<!--DO-NOT-REMOVE-OR-CHANGE-THE-FOLLOWING-COMMENT:-->
		<!--<ghsvs:include type="stylesheets">-->
		<jdoc:include type="styles" />
		<!--DO-NOT-REMOVE-OR-CHANGE-THIS-COMMENT_START <astroid:include type="head-stylessssssssssssssss" /> /DO-NOT-REMOVE-OR-CHANGE-THIS-COMMENT_END-->
		<jdoc:include type="scripts" />
		<!-- astroid head-scripts --><astroid:include type="head-scripts" /><!-- /astroid head-scripts -->
		<!-- astroid body-scripts <astroid:include type="body-scriptsssssssssssssssssssssss" /> /astroid body-scripts -->
<?php $document->include('ghsvs.favicons', ['template' => $this->template]); ?>
	</head>
	<body class="<?php echo $document->getBodyClass(); ?>">
		<div id="div4all">
		<?php $document->include('document.body', [
			'templatePath' => 'templates/' . $this->template
		]); ?>
		</div>

		<?php
		if (!$isRobot)
		{ ?>
		<div id="noscriptdiv" role="alert" aria-hidden="true">
			<?php echo Text::_('TPL_WOHNMICHL_ACTIVATE_JAVASCRIPT');?>
		</div>
		<?php
		} ?>
		<?php if (!$isRobot)
		{
		 // echo HTMLHelper::_('bs3ghsvs.toTop');
		 echo LayoutHelper::render('ghsvs.toTop');
		} ?>

	</body>
</html>
