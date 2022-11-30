<?php
defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Language\Text;
use Joomla\String\StringHelper;

if ($tagId = $params->get('tag_id', ''))
{
	$tagId = ' id="' . $tagId . '"';
}

$levelPrefix = Text::_('TPL_MODAL_MENUE_LEVEL_PREFIX');

foreach ($list as $item)
{
	$itemParams = $item->getParams();

	$item->liClass = ['list-group-item'];

	if ($item->type !== 'heading' && $item->type !== 'separator')
	{
		$item->liClass[] = 'list-group-item-action';
	}

	$item->liClass[] = 'item-' . $item->id . ' level-' . $item->level;
	$aClass = [];
	$item->add = '';

	/* Die geben wohl die einleitenden &nbsp; mit einer ESC-Folge ein(?)
	Im Quellcode kommt aber '   Thomas Boyken' raus. trim() hilft nichts.
	str_replace('&nbsp;', ...) hilft nix
	Wenn man das dann mit einem json_encode ausgibt, kommt man auf
	\u00a0\u00a0\u00a0Thomas Boyken und damit dann endlich auf:
	*/
	$item->title = StringHelper::trim($item->title, "\u{00a0}");

	/* Collect attributes like aria-* and others for the type subfiles.
	Can also be a SPAN attribute in case of headings.
	*/
	$item->aAttributes = [];

	if ($item->anchor_title)
	{
		$item->aAttributes['title'] = $item->anchor_title;
	}

	if ($item->anchor_css)
	{
		$aClass[] = $item->anchor_css;
	}

	if ($item->browserNav == 1)
	{
		$item->aAttributes['target'] = '_blank';
		$item->aAttributes['rel'] = 'noopener noreferrer';

		if ($item->anchor_rel == 'nofollow')
		{
			$attributes['rel'] .= ' nofollow';
		}
	}

	// At the moment only headings are used as dropdwon SPANs.
	if ($item->deeper)
	{
		$item->liClass[] = 'deeper';
	}

	if ($item->id == $default_id)
	{
		$item->liClass[] = 'default';
	}

	if (
		$item->id == $active_id
		|| ($item->type === 'alias'
			&& $itemParams->get('aliasoptions') == $active_id)
	){
		$item->liClass[] = 'current';
		$item->aAttributes['aria-current'] = 'page';
		$aClass[] = 'active';

		// Fürs li eigentlich.
		$item->add = '';
	}

	if (in_array($item->id, $path))
	{
		$item->liClass[] = 'active';
	}
	elseif ($item->type === 'alias')
	{
		$aliasToId = $itemParams->get('aliasoptions');

		if (count($path) > 0 && $aliasToId == $path[count($path) - 1])
		{
			$item->liClass[] = 'active';
		}
		elseif (in_array($aliasToId, $path))
		{
			$item->liClass[] = 'alias-parent-active';
		}
	}

	$type = ucfirst($item->type);
	$item->liClass[] = 'liType' . $type;
	$aClass[] = 'aType' . $type;

	if ($item->parent)
	{
		$item->liClass[] = 'parent';
	}

	// Just indent because I'm too lazy to build nested UL.
	$item->prefix = str_repeat($levelPrefix, ($item->level - 1));
	$item->liClass = implode(' ', $item->liClass);

	if ($aClass)
	{
		$item->aAttributes['class'] = implode(' ', $aClass) . ' ' . $item->liClass;
	}

	// Is in subfiles for chance to override.
	// $item->aAttributes = ArrayHelper::toString($item->aAttributes);
}
?>
<nav>
	<ul class="<?php echo 'list-group' . $class_sfx; ?>">
		<?php	foreach ($list as &$item)
		{ ?>

				<?php #echo $item->prefix;

				$item->title = $item->prefix . $item->title; ?>
				<?php switch ($item->type)
				{
					case 'separator':
					case 'heading':
					case 'component':
					case 'url':
						require ModuleHelper::getLayoutPath('mod_menu',
							'ghsvsDefault_' . $item->type);
					break;
					default:
						require ModuleHelper::getLayoutPath('mod_menu',
							'ghsvsDefault_url');
					break;
				} ?>

		<?php
		} ?>
	</ul>
</nav>
