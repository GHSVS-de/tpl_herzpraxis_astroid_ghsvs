<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
?>
<nav class="mod-breadcrumbs__wrapper" aria-label="<?php echo htmlspecialchars($module->title, ENT_QUOTES, 'UTF-8'); ?>">
	<ol class="mod-breadcrumbs breadcrumb">

		<?php
		// Zeige immer an, ggf. versteckt.
		$showHereClass = '';

		if (!$params->get('showHere', 1))
		{
			$showHereClass = ' visually-hidden';
		} ?>
		<li class="breadcrumb-item">
			{svg{bi/geo-fill}}
			<span class="<?php echo $showHereClass; ?>">
			<?php echo Text::_('MOD_BREADCRUMBS_HERE'); ?>
			</span>
		</li>
		<?php
		// Get rid of duplicated entries on trail including home page when using multilanguage
		for ($i = 0; $i < $count; $i++)
		{
			if (
				$i === 1
				&& !empty($list[$i]->link)
				&& !empty($list[$i - 1]->link)
				&& $list[$i]->link === $list[$i - 1]->link)
			{
				unset($list[$i]);
			}
		}

			// Find last and penultimate items in breadcrumbs list
			end($list);
			$last_item_key   = key($list);
			prev($list);
			$penult_item_key = key($list);

			// Make a link if not the last item in the breadcrumbs
			$show_last = $params->get('showLast', 1);
			?>
			<?php foreach ($list as $key => $item)
			{ ?>
				<?php if ($key !== $last_item_key)
				{ ?>
				<li class="breadcrumb-item">
					<?php if (!empty($item->link))
					{ ?>
					<a href="<?php echo $item->link; ?>">
						<?php echo $item->name; ?>
					</a>
					<?php
					}
					else
					{ ?>
					<span>
						<?php echo $item->name; ?>
					</span>
					<?php
					} ?>
				</li>
				<?php
				}
				elseif ($show_last && !in_array(Factory::getApplication()->input->get('option', ''), ['com_tags', 'com_osmap']))
				{ ?>
				<li class="breadcrumb-item active fst-italic" aria-current="location">
					<?php echo $item->name; ?>
				</li>
				<?php
				} ?>
			<?php
			} ?>
		</ol>
	</nav>
