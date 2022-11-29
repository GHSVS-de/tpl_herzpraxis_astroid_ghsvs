<?php
/*
GHSVS 2022:
- Für das Logo wird ein <PICTURE> mit media queries eingesetzt.
- Hintergund: Auf kleinen Geräten ist das Default-Logo unpassend.
- Nachteil: Das Fallback-Bild ist hier hart einkodiert.
*/
defined('_JEXEC') or die;

use Joomla\CMS\Uri\Uri;

extract($displayData);
?>

<?php
$headerLogo = Uri::root(true) . '/' . Astroid\Helper\Media::getPath() . '/' . $headerLogo;

$headerLogoSmall = Uri::root(true) . '/' . Astroid\Helper\Media::getPath()
. '/praxis/Logo_mit_Name_zweizeilig_470x113_2.jpg';
?>

<figure>
<picture>
<source srcset="<?php echo $headerLogoSmall; ?>" media="(max-width: 575.98px)">

<source srcset="<?php echo $headerLogo; ?>">

<img src="<?php echo $headerLogo; ?>" alt="<?php echo $alt; ?>"  class="<?php echo $class; ?>">
</picture>
</figure>
