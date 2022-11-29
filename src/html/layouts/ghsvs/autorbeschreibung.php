<?php
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\Uri\Uri;

/**
*
* $article
*/

extract($displayData);

if (empty($article->autorenaliase))
{
	return;
}

$autorbeschreibung_active = !empty($article->autorbeschreibung_active);
$zitierweise_active = !empty($article->zitierweise_active);
?>
<?php
if ($autorbeschreibung_active || $zitierweise_active)
{ ?>
<div class="autorZitierweise mt-3 mt-xl-0">
	<?php
	if ($autorbeschreibung_active)
	{ ?>
	<div class="alert-info py-3 mb-2">
		<h3 class="h5 px-3"><?php echo (count($article->autorenaliase) > 1 ? 'Autoren' : 'Autor'); ?></h3>
		<ul class="mb-0 list-group small">
			<?php
			foreach ($article->autorenaliase as $autor)
			{ ?>
				<li class="list-group-item">
					<?php echo (($autor->name ?: $autor->alias)); ?>
					<?php echo ($autor->webpage ? ' (' .
						HTMLHelper::_('link', $autor->webpage, $autor->webpage) . ')' : '');
					?>
				</li>
			<?php
			}
			?>
		</ul>
	</div>
	<?php
	} ?>
	<?php
	if ($zitierweise_active)
	{
		$zitierweise = implode('; ',
		[
			$article->title,
			$article->AutorenNamesConcated,
			HTMLHelper::_('date', $article->created, 'Y'),
			Uri::getInstance()->current()
		]);
	?>
	<div class="alert-warning py-3">
		<h3 class="h5 px-3">Verpflichtende Zitierweise und Urheberrechte</h3>
		<ul class="mb-0 list-group small">
			<li class="list-group-item">
				Beachten Sie die Rechte des/der Urheber! Wenn Sie größere Teile von
				Artikeln übernehmen	wollen, fragen Sie zuvor nach!</li>
			<li class="list-group-item list-group-item-danger">
				Bilder und andere multimediale Inhalte bedürfen immer
				der Freigabe durch den/die Urheber.</li>
			<li class="list-group-item">
				Quellen-Nennung: <q><?php echo $zitierweise; ?></q></li>
		</ul>
	</div>
	<?php
	} ?>
</div><!--/autorZitierweise-->
<?php
}
