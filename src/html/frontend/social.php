<?php
defined('_JEXEC') or die;
extract($displayData);
// $document = Astroid\Framework::getDocument();
$params = Astroid\Framework::getTemplate()->getParams();
$social_profiles = $params->get('social_profiles', []);

if (!empty($social_profiles))
{
   $social_profiles = json_decode($social_profiles);
}
else
{
	return;
}
$class='justify-content-center';
?>
<ul class="nav navVerticalView astroid-social-icons<?php echo !empty($class) ? ' ' . $class : ''; ?>">
	<?php foreach ($social_profiles as $social_profile)
	{
	switch ($social_profile->id) {
		case 'whatsapp':
		$social_profile_link = 'https://wa.me/' . $social_profile->link;
	break;
		case 'telegram':
		$social_profile_link = 'https://t.me/' . $social_profile->link;
		break;
	case 'skype':
		$social_profile_link = 'skype:' . $social_profile->link . '?chat';
		break;
	default:
		$social_profile_link = $social_profile->link;
		break;
	}

	$sid = md5($social_profile->color . $social_profile_link
		. $social_profile->icon);
	$social_profile->title = ($social_profile->title ? $social_profile->title : 'Social Icon');
	?>
	<li>
		<a aria-label="<?php echo $social_profile->title; ?>. (Öffnet neue Seite)"
			title="<?php echo $social_profile->title; ?>"
			href="<?php echo $social_profile_link; ?>"
			target="_blank" rel="noopener noreferrer">
			<span class="<?php echo $social_profile->icon; ?> fa-2x" aria-hidden="true">
			</span>
		</a>
	</li>
	<?php
	} ?>
</ul>
