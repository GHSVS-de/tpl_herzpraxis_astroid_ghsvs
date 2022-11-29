<?php
/*
JLayout für Plugin plugins\content\phocagalleryghsvs\phocagalleryghsvs.php.
Gibt PhocaGallery-Bilder als Thumbnails einer PG-Kategorie aus.
Öffnet bei Klicks Venobox-Slides.
*/
\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;

/*
 * $images: einer PhocaGallery-Kategorie.
*/
extract($displayData);

if (empty($images))
{
	return;
}

HTMLHelper::_('plgvenoboxghsvs.venobox', '.venobox');

// Sanitize paths.
foreach ($images as $image)
{
	foreach (['linkthumbnailpath', 'linkOrigPath'] as $key)
	{
		$image->$key = implode('/', array_map('rawurlencode',
			explode('/', $image->$key)));
	}
}

$output = '';
$output .= Text::sprintf(
	'PLG_CONTENT_PHOCAGALLERYGHSVS_GALLERY_HEADLINE',
	$images[0]->catTitle
);
$output .= Text::sprintf(
	'PLG_CONTENT_PHOCAGALLERYGHSVS_GALLERY_DESCRIPTION',
	$images[0]->catDescription
);
$output .= Text::_('PLG_CONTENT_PHOCAGALLERYGHSVS_GALLERY_MANUAL');

$id = uniqid();
?>
<div class="ghsvssss phocagallerysss clearfixsss">
	<p>
		<button class="btn btn-success" type="button" data-bs-toggle="collapse"
			data-bs-target="#collapse-<?php echo $id; ?>" aria-expanded="false"
			aria-controls="collapse-<?php echo $id; ?>">
			Fotogalerie ein-ausblenden
		</button>
	</p>
	<div class="collapse bg-light mb-3 py-3 text-center border border-danger"
		id="collapse-<?php echo $id; ?>">
		<?php echo $output; ?>

		<div class="row g-2 justify-content-center">
			<?php foreach($images as $image)
			{ ?>
				<div class="col-auto">
					<div class="card border-danger pb-1" style="width:200px;">
						<img src="<?php echo $image->linkthumbnailpath; ?>"  loading="lazy"
							class="card-img-top" alt="">
						<div class=py-1>
							<p class="card-text"><?php echo $image->title; ?></p>
							<?php if (trim($image->description))
							{ ?>
								<div class="card-text"><?php echo $image->description; ?></div>
							<?php
							} ?>
						</div>
						<a class="venobox vbox-item stretched-link"
							data-title="<?php echo $image->title; ?>"
							href="<?php echo $image->linkOrigPath; ?>"
							data-gall="gall-<?php echo $id; ?>">
							<span class="visually-hidden">
								Klick öffnet PopUp mit Vollbild.
							</span>
						</a>
					</div>
				</div>
			<?php
			} ?>
		</div>
	</div>
</div>
