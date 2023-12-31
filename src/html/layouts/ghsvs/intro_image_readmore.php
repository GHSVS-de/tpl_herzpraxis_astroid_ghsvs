<?php
// intro_image_readmore venobox bs4
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Registry\Registry;

// @since 2023-12
use GHSVS\Plugin\System\Bs3Ghsvs\Helper\Bs3GhsvsItemHelper as Bs3ghsvsItem;

$options = new Registry(isset(
	$displayData['options']) ? $displayData['options'] : []
);

$item = $displayData['item'];
$images = Bs3ghsvsItem::getItemImagesghsvs($item);

if ($image = $images->get('image_intro'))
{
	echo PHP_EOL . '<!--File: ' . str_replace(JPATH_SITE, '', dirname(__FILE__)) . '/'. basename(__FILE__) . '-->' . PHP_EOL;

	$venobox = '';
	$figureClasses = ['autoLimited item-image image_intro'];

	// Siehe Beschreibung in der Datei.
	require(__DIR__ . '/imgClassTranslator.php');
	$figureClass = $images->get('float_intro', 'ghsvs_img-default');

	if (!empty($imgClassTranslator[$figureClass]))
	{
		$figureClass = $imgClassTranslator[$figureClass];
	}

	$figureClasses[] = $figureClass;

	// e.g. blog 'leadItem'. Use it for different $mediaQueries if you want!
	$whichItem = $options->get('whichItem', '');
	$figureClasses[] = $whichItem;

	$mediaQueries = [];
	$classes = $options->get('classes', '');

	// A11Y Don't set several links per block to same target.
	$linkToArticle = !
		(($item->params->get('show_readmore') && $item->readmore)
		|| (int) $item->params->get('link_titles') === 1);

	if (($link = $options->get('link', '')) === '' && $linkToArticle)
	{
		JLoader::register('ContentHelperRoute', JPATH_BASE
			. '/components/com_content/helpers/route.php');
		$link = Route::_(ContentHelperRoute::getArticleRoute(
			$item->slug, $item->catid, $item->language
		));
	}

	$hasLink = $link !== '';
	$aTitle = 'GHSVS_HIGHER_RESOLUTION_1';

	// Zoom-Button.
	$aClass = ['btn btn-dark btn-sm'];

	if (PluginHelper::isEnabled('system', 'venoboxghsvs'))
	{
		$venobox = 'venobox';
		HTMLHelper::_('plgvenoboxghsvs.venobox');
		$aTitle = 'GHSVS_HIGHER_RESOLUTION_0';
	}

	$alt = $images->get('image_intro_alt');
	$caption = $images->get('image_intro_caption');
	$alt = htmlspecialchars(($alt ? $alt : $caption), ENT_QUOTES, 'UTF-8');
	$caption = htmlspecialchars($caption, ENT_QUOTES, 'UTF-8');

	$picture = array('<picture>');

	// From plg_system_bs3ghsvs. If resizer active.
	// Returns empty array if nothing.
	$imgs = $images->get('introtext_imagesghsvs');

	if (!empty($imgs[0]) && is_array($imgs[0]))
	{
		// ############# LEAD ITEMS!!! START ################
		// Leading items have normally col-6 of page full width (currently 1440px).
		if ($whichItem === 'leadItem')
		{
			$mediaQueries = array(
				// xs-max; Bild ganze Breite, oberhalb Text
				'(max-width: 575px)' => '_s',
				// sm-max;  Bild ganze Breite, oberhalb Text
				'(max-width: 767px)' => '_m',
				// md-max, Bild rechts, neben Text
				//'(max-width: 991px)' => !empty($imgs['_l']) ? $imgs['_l'] : null,
				// lg-max
				'(max-width: 1199px)' => '_l',
				// xl-min
				'(min-width: 1200px)' => '_x',

				// Largest <source> without mediaQuery. Also for fallback <img> src, width and height calculation.
				// Value only if you want to force one. Otherwise _x or fallback _u is used.
				'srcSetKey' => '',
			);
		}
		// ############# INTRO ITEMS!!! START ################
		else
		{
			$mediaQueries = array(

				// figure hat dann max 332px
				'(max-width: 410px)' => '_s',

				// figure hat dann max 402px.
				'(max-width: 460px)' => '_m',

				// Hier hört xs auf.
				'(max-width: 575.98px)' => '_l',

				// sm endet (1 Card-Spalte). Bild hat 700px. figure 689px.
				'(max-width: 767.98px)' => '_x',

				// md-max (2 Card-Spalten). Und lg
				'(max-width: 800.98px)' => '_s',
				'(max-width: 880.98px)' => '_m',
				'(max-width: 980.98px)' => '_l',
				'(max-width: 1199.98px)' => '_x',

				// xl startet (3 Card-Spalten)
				'(max-width: 1320.98px)' => '_m',
				'(max-width: 1700.98px)' => '_l',
				'(min-width: 1701px)' => '_x',

				// Largest <source> without mediaQuery. Also for fallback <img> src, width and height calculation.
				// Value only if you want to force one. Otherwise _x or fallback _u is used.
				'srcSetKey' => '',
			);
		}
		// ############# INTRO ITEMS!!! END ################
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
		<?php if ($hasLink)
		{ ?>
		<a href="<?php echo $link; ?>"
			aria-label="<?php echo Text::_('GHSVS_OPEN_ARTICLE'); ?>"
			class="aWithButtonOverlay">
			<?php echo $picture; ?>
			<div class="centeredButton btn btn-default" aria-hidden="true">
				{svg{bi/link-45deg}}
				{svg{bi/chevron-right}}
			</div>
		</a>
		<?php // if $link
		}
		else
		{
			$aClass[] = 'stretched-link';
			echo '<div class="position-relative">' . $picture;
		} ?>
		<div class="iconGhsvs text-end">
			<a href="<?php echo $image; ?>" data-title="<?php echo $caption; ?>"
				class="<?php echo implode(' ', $aClass); ?>">
				<span class="sr-only"><?php echo Text::_($aTitle); ?></span>
				{svg{bi/zoom-in}}
			</a>
		</div>
		<?php if (!$hasLink) {
			echo '</div>';
		} ?>
		<?php if ($caption)
		{ ?>
		<figcaption><?php echo $caption; ?></figcaption>
		<?php
		} ?>
	</figure>
</div>
<?php
} //not empty image_intro ?>
