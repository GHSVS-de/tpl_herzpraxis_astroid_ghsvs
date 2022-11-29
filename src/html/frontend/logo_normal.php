<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

extract($displayData);
$params = Astroid\Framework::getTemplate()->getParams();
$logo_type = $params->get('logo_type', 'none');

if ($logo_type === 'none')
{
	return;
}

$document = Astroid\Framework::getDocument();

$sitename = Factory::getApplication()->get('sitename');
$header_mode = $params->get('header_mode', 'horizontal');
$header_stacked_menu_mode = $params->get('header_stacked_menu_mode', 'center');

if ($logo_type == 'text')
{
	$logo_text = $params->get('logo_text', $sitename);
	$tag_line = $params->get('tag_line', '');
}
else
{
   // Logo file
   $default_logo = $params->get('defult_logo', false);
   $mobile_logo = $params->get('mobile_logo', false);
   $stickey_header_logo = $params->get('stickey_header_logo', false);
}
$class = ['astroid-logo', 'astroid-logo-' . $logo_type, 'd-flex align-items-center'];

$logo_link_type = $params->get('logo_link_type', 'default');
$logo_link = Uri::root();
$logo_link_target = '_self';

if ($logo_link_type === 'custom')
{
	$logo_link = $params->get('logo_link_custom', '');

	if ($params->get('logo_link_target_blank', 0))
	{
		$logo_link_target = '_blank';
	}
}
?>
<?php if ($logo_type == 'image')
{
	$headerLogo = '';

	// Im Normalfall wird das $headerLogo = $default_logo sein.
	if (!empty($default_logo))
	{
		$headerLogo = $default_logo;
	}
	elseif (!empty($mobile_logo))
	{
		$headerLogo = $mobile_logo;
	}
	elseif (!empty($stickey_header_logo))
	{
		$headerLogo = $stickey_header_logo;
	}
}
?>
<?php if ($logo_type == 'text') : ?>
   <!-- text logo starts -->
   <?php
   $mr = ($header_mode == 'stacked' && ($header_stacked_menu_mode == 'seperated' || $header_stacked_menu_mode == 'center')) ? '' : ' mr-0 mr-lg-4';
   ?>
   <div class="logo-wrapper <?php echo implode(' ', $class); ?> flex-column<?php echo $mr; ?>">
      <a target="<?php echo $logo_link_target; ?>" class="site-title" href="<?php echo $logo_link; ?>"><?php echo $logo_text; ?></a>
      <p class="site-tagline"><?php echo $tag_line; ?></p>
   </div>
   <!-- text logo ends -->
<?php endif; ?>
<?php if ($logo_type == 'image') : ?>
   <!-- image logo starts -->
   <?php
   $mr = ($header_mode == 'stacked' && ($header_stacked_menu_mode == 'seperated' || $header_stacked_menu_mode == 'center')) ? '' : ' mr-0 mr-lg-4';
   ?>
   <div class="logo-wrapper">
      <a target="<?php echo $logo_link_target; ?>" class="<?php echo implode(' ', $class); ?><?php echo $mr; ?>" href="<?php echo $logo_link; ?>">
				<?php
				$document->include('ghsvs.logoFigure', [
					'headerLogo' => $headerLogo,
					'class' => 'astroidLogo',
					'alt' => $sitename
				]); ?>
      </a>
   </div><!--/logo-wrapper-->
   <!-- image logo ends -->
<?php endif; ?>
