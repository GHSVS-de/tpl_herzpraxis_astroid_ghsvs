<?php
// full_image venobox bs4
defined('JPATH_BASE') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Language\Text;
use Joomla\Registry\Registry;

// NEIN NEIN NEIN! Da Prüfung auf empty() fehlschlägt! Also runter
#echo PHP_EOL . '<!--File: ' . str_replace(JPATH_SITE, '', dirname(__FILE__)) . '/'. basename(__FILE__) . '-->' . PHP_EOL;

$item = $displayData['item'];
$images = Bs3ghsvsItem::getItemImagesghsvs($item);

if ($image = $images->get('image_fulltext'))
{
	echo PHP_EOL . '<!--File: ' . str_replace(JPATH_SITE, '', dirname(__FILE__)) . '/'. basename(__FILE__) . '-->' . PHP_EOL;

	$options = new Registry(isset(
		$displayData['options']) ? $displayData['options'] : []
	);
	$venobox = '';
	$figureClasses = ['autoLimited item-image image_fulltext'];

	// Siehe Beschreibung in der Datei.
	require(__DIR__ . '/imgClassTranslator.php');
	$figureClass = $images->get('float_fulltext', 'ghsvs_img-right');

	if (!empty($imgClassTranslator[$figureClass]))
	{
		$figureClass = $imgClassTranslator[$figureClass];
	}

	$figureClasses[] = $figureClass;
	$mediaQueries = [];
	$classes = $options->get('classes', '');
	$aTitle = 'GHSVS_HIGHER_RESOLUTION_1';

	// Zoom-Button.
	$aClass = ['btn btn-dark btn-sm stretched-link'];

	if (PluginHelper::isEnabled('system', 'venoboxghsvs'))
	{
		$venobox = 'venobox';
		HTMLHelper::_('plgvenoboxghsvs.venobox');
		$aTitle = 'GHSVS_HIGHER_RESOLUTION_0';
	}

	$alt = $images->get('image_fulltext_alt');
	$caption = $images->get('image_fulltext_caption');
	$alt = htmlspecialchars(($alt ? $alt : $caption), ENT_QUOTES, 'UTF-8');
	$caption = htmlspecialchars($caption, ENT_QUOTES, 'UTF-8');
	$picture = array('<picture>');

	// From plg_system_bs3ghsvs. If resizer active.
	// Returns empty array if nothing.
	$imgs = $images->get('fulltext_imagesghsvs');

	if (!empty($imgs[0]) && is_array($imgs[0]))
	{
		/* Derzeit folgende Größen im plg_system_bs3ghsvs
			_s: 320px
			_m: 400px
			_l: 480px
			_x: 700px
		*/
		/*
			xs: immer volle Breite. geht von 0 bis 575.98px. figure hat dann max 497px. => _l

			sm: immer volle Breite. bis 767.98px. figure hat dann max 690px. => _x
		*/
		$mediaQueries = array(

			// figure hat dann max 332px
			'(max-width: 410px)' => '_s',

			// figure hat dann max 402px.
			'(max-width: 480px)' => '_m',

			// Hier hört xs auf.
			'(max-width: 575.98px)' => '_l',

			// Hier hört sm auf.
			'(max-width: 767.98px)' => '_x',

			// float-end beginnt bei 768px.
			'(max-width: 890px)' => '_s',

			'(max-width: 1030px)' => '_m',

			// lg-max endet.
			'(max-width: 1199.98px)' => '_l',

			//xl beginnt: Position right kommt dazu.
			'(max-width: 1300px)' => '_s',
			'(max-width: 1440.98px)' => '_m',
			'(min-width: 1441px)' => '_l',
			//'(max-width: 991.98px)' => '_s',
			//'(max-width: 1199.98px)' => '_m',
			//'(max-width: 2600px)' => '_l',

			// Largest <source> without mediaQuery. Also for fallback <img> src, width and height calculation.
			// Value only if you want to force one. Otherwise _x or fallback _u is used.
			'srcSetKey' => '',
		);
	}

	// Use $imgs not $imgs[0] because of ['order'] index.
	// And because other $imgs collections can contain more than just 1 image.
	$sources   = Bs3ghsvsItem::getSources($imgs, $mediaQueries, $image);
	$sources   = $sources[0];
	$picture[] = $sources['sources'];
	$picture[] = '<img loading="lazy"'
		. ' src="' . $sources['assets']['img'] . '"'
		. ' alt="' . $alt . '"'
		. ' width="' . $sources['assets']['width'] . '"'
		. ' height="' . $sources['assets']['height'] . '"'
		. ' class="h-auto"'
		. '>';
	$picture[] = '</picture>';
	$picture = implode('', $picture);
	$aClass[] = $venobox;
	$figureClasses = implode(' ', $figureClasses);
?>
<div class="<?php echo $classes; ?>">
	<figure class="<?php echo $figureClasses; ?>">
		<div class="position-relative">
			<?php echo $picture; ?>
			<div class="iconGhsvs text-end">
				<a href="<?php echo $image; ?>" data-title="<?php echo $caption; ?>"
					class="<?php echo implode(' ', $aClass); ?>">
					<span class="sr-only"><?php echo Text::_($aTitle); ?></span>
					{svg{bi/zoom-in}}
				</a>
			</div>
		</div>
		<?php if ($caption)
		{ ?>
		<figcaption><?php echo $caption; ?></figcaption>
		<?php
		} ?>
	</figure>
</div>
<?php
} // if image_fulltext ?>
