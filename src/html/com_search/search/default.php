<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_search
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
use Joomla\CMS\Layout\LayoutHelper;
?>
<div class="search<?php echo $this->pageclass_sfx; ?>">
	<?php
	#### SEITENÜBERSCHRIFT (Menü)
	if ($this->params->get('show_page_heading'))
	{
		echo LayoutHelper::render('ghsvs.page_heading',
			['params' => $this->params]);
	}
	#### ENDE - SEITENÜBERSCHRIFT (Menü)
	?>
<div class="rowsss">
	<div>
		<div class="card item-page clearfix">
			<div class="card-header">
				<h2>Suche</h2>
			</div>
			<div class="card-body">
				<?php echo $this->loadTemplate('form'); ?>
				<?php if ($this->error == null && count($this->results) > 0) : ?>
					<?php echo $this->loadTemplate('results'); ?>
				<?php else : ?>
					<?php echo $this->loadTemplate('error'); ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
