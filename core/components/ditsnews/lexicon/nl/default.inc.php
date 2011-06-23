<?php
/**
 * Default English Lexicon Entries for DitsNews
 *
 * @package ditsnews
 * @subpackage lexicon
 */

//general
$_lang['ditsnews'] = 'DitsNews';
$_lang['ditsnews.desc'] = 'Nieuwsbrief systeem voor MODX.';
$_lang['ditsnews.menu'] = 'Menu';
$_lang['ditsnews.search...'] = 'Zoeken...';

//newsletters
$_lang['ditsnews.newsletters'] = 'Nieuwsbrieven';
$_lang['ditsnews.newsletters.subject'] = 'Onderwerp';
$_lang['ditsnews.newsletters.date'] = 'Datum';
$_lang['ditsnews.newsletters.document'] = 'Document';
$_lang['ditsnews.newsletters.total'] = 'Totaal';
$_lang['ditsnews.newsletters.sent'] = 'Verstuurd';
$_lang['ditsnews.newsletters.new'] = 'Nieuwe nieuwsbrief';
$_lang['ditsnews.newsletters.groups'] = 'Groepen';
$_lang['ditsnews,newsletters.remove'] = 'Verwijder nieuwsbrief';
$_lang['ditsnews.newsletters.remove.title'] = 'Verwijder nieuwsbrief?';
$_lang['ditsnews.newsletters.remove.confirm'] = 'Weet u zeker dat u deze nieuwsbrief en alle bijbehorende data wilt verwijderen?';
$_lang['ditsnews.newsletters.saved'] = 'Nieuwsbrief opgeslagen (ingepland)';
$_lang['ditsnews.newsletters.err.save'] = 'Kan nieuwsbrief niet opslaan/inplannen';
$_lang['ditsnews.newsletters.err.nf'] = 'Kan document niet openen';
$_lang['ditsnews.newsletters.err.remove'] = 'Kan nieuwsbrief niet verwijderen';

//groups
$_lang['ditsnews.groups'] = 'Groepen';
$_lang['ditsnews.groups.name'] = 'Naam';
$_lang['ditsnews.groups.public'] = 'Publiek';
$_lang['ditsnews.groups.public.desc'] = 'Publiek (aanmelden via formulier toegestaan)';
$_lang['ditsnews.groups.members'] = 'Leden';
$_lang['ditsnews.groups.new'] = 'Nieuwe groep';
$_lang['ditsnews.groups.edit'] = 'Bewerk groep';
$_lang['ditsnews.groups.remove'] = 'Verwijder groep';
$_lang['ditsnews.groups.remove.title'] = 'Verwijder groep?';
$_lang['ditsnews.groups.remove.confirm'] = 'Weet u zeker dat u deze groep wilt verwijderen? Abonnees worden niet verwijderd.';
$_lang['ditsnews.groups.update'] = 'Groep bijwerken';
$_lang['ditsnews.groups.saved'] = 'Groep opgeslagen';
$_lang['ditsnews.groups.err.nf'] = 'Groep niet gevonden';
$_lang['ditsnews.groups.err.save'] = 'Kan group niet opslaan';

//subscribers
$_lang['ditsnews.subscribers'] = 'Abonnees';
$_lang['ditsnews.subscribers.firstname'] = 'Voornaam';
$_lang['ditsnews.subscribers.lastname'] = 'Achternaam';
$_lang['ditsnews.subscribers.company'] = 'Organisatie';
$_lang['ditsnews.subscribers.email'] = 'E-mail';
$_lang['ditsnews.subscribers.signupdate'] = 'Aanmeldingsdatum';
$_lang['ditsnews.subscribers.new'] = 'Nieuwe abonnee';
$_lang['ditsnews.subscribers.exportcsv'] = 'Exporteer CSV';
$_lang['ditsnews.subscribers.importcsv'] = 'Importeer CSV';
$_lang['ditsnews.subscribers.importcsv.start'] = 'Start importeren';
$_lang['ditsnews.subscribers.importcsv.file'] = 'Bestand';
$_lang['ditsnews.subscribers.importcsv.results'] = 'Resultaat';
$_lang['ditsnews.subscribers.importcsv.err.uploadfile'] = 'Upload een bestand';
$_lang['ditsnews.subscribers.importcsv.err.cantopenfile'] = 'Kan bestand niet openen';
$_lang['ditsnews.subscribers.importcsv.err.firstrow'] = 'Eerste rij moet kolomnamen bevatten (en eerste kolom moet email zijn)';
$_lang['ditsnews.subscribers.importcsv.err.cantsaverow'] = 'Kan rij [[+rownum]] niet opslaan';
$_lang['ditsnews.subscribers.importcsv.err.skippedrow'] = 'Rij [[+rownum]] overgeslagen';
$_lang['ditsnews.subscribers.importcsv.msg.complete'] = 'Importeren gereed. [[+importCount]] records geimporteerd ([[+newCount]] nieuw)';
$_lang['ditsnews.subscribers.confirm.subject'] = 'Bevestig uw aanmelding';
$_lang['ditsnews.subscribers.confirm.success'] = 'U bent nu op onze nieuwsbrief geabonneerd.';
$_lang['ditsnews.subscribers.confirm.err'] = 'Abonnee / code combinatie niet correct.';
$_lang['ditsnews.subscribers.signup.err.emailunique'] = 'E-mailadres al in gebruik';
$_lang['ditsnews.subscribers.unsubscribe.success'] = 'U bent uit ons adresbestand verwijderd.';
$_lang['ditsnews.subscribers.unsubscribe.err'] = 'Abonnee niet gevonden.';
$_lang['ditsnews.subscribers.active'] = 'Actief';
$_lang['ditsnews.subscribers.groups'] = 'Groepen';
$_lang['ditsnews.subscribers.remove'] = 'Verwijder abonnee';
$_lang['ditsnews.subscribers.remove.title'] = 'Verwijder abonnee?';
$_lang['ditsnews.subscribers.remove.confirm'] = 'Weet u zeker dat u deze abonnee wilt verwijderen?';
$_lang['ditsnews.subscribers.update'] = 'Abonnee bijwerken';
$_lang['ditsnews.subscribers.saved'] = 'Abonnee opgeslagen';
$_lang['ditsnews.subscribers.err.save'] = 'Fout bij opslaan van abonnee';
$_lang['ditsnews.subscribers.err.ae'] = 'Er bestaat al een abonnee met dit e-mailadres';


//settings
$_lang['ditsnews.settings'] = 'Instellingen';
$_lang['ditsnews.settings.name'] = 'Naam';
$_lang['ditsnews.settings.email'] = 'E-mail';
$_lang['ditsnews.settings.bounceemail'] = 'Bounce e-mailadres';
$_lang['ditsnews.settings.confirmpage'] = 'Bevestigingspagina';
$_lang['ditsnews.settings.unsubscribepage'] = 'Afmeldpagina';
$_lang['ditsnews.settings.template'] = 'Template';
$_lang['ditsnews.settings.saved'] = 'Instellingen opgeslagen';
$_lang['ditsnews.settings.error'] = 'Fout bij opslaan van instellingen';