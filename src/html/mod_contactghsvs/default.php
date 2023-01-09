<?php
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

/*
$contact Object
(
	[name] => Herz-Kreislauf-Praxis Dr. Thomas Wolber
	[con_position] => info2019@herzpraxis.at
	[address] => St. Ulrich Straße 40
	AT-6840 Götzis
	Vorarlberg, Österreich
	[suburb] => Götzis
	[state] => Vorarlberg
	[country] => Österreich
	[postcode] => 6840
	[telephone] => 05523 51183
	[fax] => 05523 51183 4
	[misc] =>
	[image] =>
	[email_to] => v.schlothauer@ghsvs.de

	[mobile] =>
	[webpage] =>

	[fields] => stdClass Object
			(
					[telefon_link] => tel:+43552351183
			)

	[lageplan] => /kontakt/lageplan-anfahrt
	[kontaktformular] => /kontakt/schreiben-sie-uns
)
*/

// com_fields fields.
$fields = $contact->fields;

#### BLOCK Anmeldung vorbereiten:
$anmeldung = [];

if (($telephone = trim($contact->telephone)) && !empty($fields->telefon_link))
{
	if (isset($fields->telefon_link) && trim($fields->telefon_link))
	{
		$telephone = '<a href="' . $fields->telefon_link . '">' . $telephone . '</a>';
	}

	$anmeldung[] = 'Telefon: ' . $telephone;
}

if ($fax = trim($contact->fax))
{
	$anmeldung[] = 'Fax: ' . $fax;
}

if ($email = trim($contact->email_to))
{
	// $anmeldung[] = 'E-Mail: ' . HTMLHelper::_('email.cloak', $email);
}

if ($contact->kontaktformular)
{
	$anmeldung[] = '<span class="a4kontaktFormular">E-Mail via <a href="' . $contact->kontaktformular
		. '">Kontaktformular</a></span>';
}

$anmeldung = implode('<br>', $anmeldung);
#### BLOCK Anmeldung vorbereiten - ENDE
#### BLOCK Adresse vorbereiten:
$adresse = [];
$adresse[] = $contact->name;
$adresse[] = nl2br($contact->address);

if ($contact->lageplan)
{
	$adresse[] = '<a class=a4anfahrtSeite href="' . $contact->lageplan
		. '">Lageplan, Anfahrt</a>';
}
$adresse = implode('<br>', $adresse);
#### BLOCK Adresse vorbereiten - ENDE
?>
<div class="row mod_contactghsvs_row position-<?php echo $module->position; ?>">
  <div class="col-md-6 mod_contactghsvs_col">
    <div class="card h-100">
      <div class="card-body">
        <h2 class="card-title">Anmeldung</h2>
        <p class="card-text">
					<?php echo $anmeldung; ?>
				</p>
      </div>
    </div>
  </div>
  <div class="col-md-6 mod_contactghsvs_col">
    <div class="card h-100">
      <div class="card-body">
        <h2 class="card-title">Adresse</h2>
        <p class="card-text">
					<?php echo $adresse; ?>
				</p>
      </div>
    </div>
  </div>
</div>
