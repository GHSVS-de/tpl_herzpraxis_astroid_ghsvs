<?php
/*
- Siehe templates/herzpraxis_astroid_ghsvs/images/favicons
- Die Bilder wurden generiert mit https://www.favicon-generator.org.
- Die Pfade in `browserconfig.xml` müssen händisch angepasst werden.
- Astroid-Templates: Siehe auch Einstellung im Template-Stil, die ich aber in document/body.php deaktiviert habe.
*/
\defined('_JEXEC') or die;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Factory;

/*
$template(= name of template)
*/
extract($displayData);
$basePath = 'templates/' . $template. '/images/favicons';
$urlToFavicons = Uri::root(true) . '/' . $basePath;
$manifestPath = JPATH_ROOT . '/' . $basePath . '/' . 'manifest.json';
$browserConfigPath = JPATH_ROOT . '/' . $basePath . '/' . 'browserconfig';

if (!is_file($manifestPath))
{
	$manifest = new stdClass();
	$manifest->name = 'App';
	$manifest->icons = [
		[
			"src" => $urlToFavicons . "/android-icon-36x36.png",
			"sizes" => "36x36",
			"type" => "image/png",
			"density" => "0.75"
		],
		[
			"src" => $urlToFavicons . "/android-icon-48x48.png",
			"sizes" => "48x48",
			"type" => "image/png",
			"density" => "1.0"
		],
		[
			"src" => $urlToFavicons . "/android-icon-72x72.png",
			"sizes" => "72x72",
			"type" => "image/png",
			"density" => "1.5"
		],
		[
			"src" => $urlToFavicons . "/android-icon-96x96.png",
			"sizes" => "96x96",
			"type" => "image/png",
			"density" => "2.0"
		],
		[
			"src" => $urlToFavicons . "/android-icon-144x144.png",
			"sizes" => "144x144",
			"type" => "image/png",
			"density" => "3.0"
		],
		[
			"src" => $urlToFavicons . "/android-icon-192x192.png",
			"sizes" => "192x192",
			"type" => "image/png",
			"density" => "4.0"
		]
	];

	file_put_contents($manifestPath, json_encode($manifest));
}

if (!is_file($browserConfigPath . '.xml'))
{
	$vorlage = $browserConfigPath . '-Vorlage.xml';

	if (is_file($vorlage))
	{
		$content = str_replace('{{urlToFavicons}}', $urlToFavicons,
			file_get_contents($vorlage));
		file_put_contents($browserConfigPath . '.xml', $content);
	}
}
?>
<!--Favicons by override ghsvs/favicons.php -->
<link rel="apple-touch-icon" sizes="57x57" href="<?php echo $urlToFavicons; ?>/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="<?php echo $urlToFavicons; ?>/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo $urlToFavicons; ?>/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo $urlToFavicons; ?>/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo $urlToFavicons; ?>/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?php echo $urlToFavicons; ?>/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="<?php echo $urlToFavicons; ?>/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?php echo $urlToFavicons; ?>/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo $urlToFavicons; ?>/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192" href="<?php echo $urlToFavicons; ?>/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo $urlToFavicons; ?>/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="<?php echo $urlToFavicons; ?>/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo $urlToFavicons; ?>/favicon-16x16.png">
<meta name="msapplication-config" content="<?php echo $urlToFavicons; ?>/browserconfig.xml">
<link rel="manifest" href="<?php echo $urlToFavicons; ?>/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="<?php echo $urlToFavicons; ?>/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
<link href="<?php echo $urlToFavicons; ?>/favicon.ico" rel="alternate icon" type="image/vnd.microsoft.icon">
<!--/Favicons-->
