<?php
/*
In an Astroid template.

$document = Astroid\Framework::getDocument();
...
...

<!--ghsvs.assets-->
<?php
$document->include('ghsvs.assets',
	['js' =>
		[
			'templates/' . $this->template . '/js/user.js',
			'templates/' . $this->template . '/js/script.js',
		],
	'css' =>
		[
			'templates/' . $this->template . '/css/user.css',
			'templates/' . $this->template . '/css/sonstwas.css',
		]
	]
	);
?>
<!--/ghsvs.assets-->
*/
defined('_JEXEC') or die;

use Joomla\CMS\Uri\Uri;
extract($displayData);

if (!empty($css))
{
	foreach ($css as $path)
	{
		if (!is_file(JPATH_SITE . '/' . $path))
		{
			continue;
		}

		$mediaVersion = md5_file(JPATH_SITE . '/' . $path);
		echo '<link href="' . $path . '?' . $mediaVersion . '" rel="stylesheet" />';
	}
}

if (!empty($js))
{
	foreach ($js as $path)
	{
		if (!is_file(JPATH_SITE . '/' . $path))
		{
			continue;
		}

		$mediaVersion = md5_file(JPATH_SITE . '/' . $path);
		echo '<script src="' . Uri::root(true) . '/' . $path . '?' . $mediaVersion . '"></script>';
	}
}
