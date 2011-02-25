<?php
/**
 * Default German Lexicon Entries for DitsNews
 * by Anselm Hannemann (http://anselm.novolo.de)
 * @package ditsnews
 * @subpackage lexicon
 */

//general
$_lang['ditsnews'] = 'DitsNews';
$_lang['ditsnews.desc'] = 'Newsletterverwaltung';
$_lang['ditsnews.menu'] = 'Menü';

//newsletters
$_lang['ditsnews.newsletters'] = 'Newsletter';
$_lang['ditsnews.newsletters.subject'] = 'Betreff';
$_lang['ditsnews.newsletters.date'] = 'Datum';
$_lang['ditsnews.newsletters.document'] = 'Dokument';
$_lang['ditsnews.newsletters.total'] = 'Gesamt';
$_lang['ditsnews.newsletters.sent'] = 'Gesendet';
$_lang['ditsnews.newsletters.new'] = 'neuer Newsletter';
$_lang['ditsnews.newsletters.groups'] = 'Gruppen';
$_lang['ditsnews.newsletters.remove'] = 'Newsletter entfernen';
$_lang['ditsnews.newsletters.remove.title'] = 'Newsletter entfernen?';
$_lang['ditsnews.newsletters.remove.confirm'] = 'Sind Sie sicher, dass Sie den Newsletter und alle enthaltenen Daten entfernen möchten?';
$_lang['ditsnews.newsletters.saved'] = 'Newsletter gespeichert (geplant)';

//groups
$_lang['ditsnews.groups'] = 'Gruppen';
$_lang['ditsnews.groups.name'] = 'Name';
$_lang['ditsnews.groups.public'] = 'Öffentlich';
$_lang['ditsnews.groups.public.desc'] = 'Öffentlich (erlaube Abonnement durch Formular)';
$_lang['ditsnews.groups.members'] = 'Mitglieder';
$_lang['ditsnews.groups.new'] = 'Neue Gruppe';
$_lang['ditsnews.groups.edit'] = 'Gruppe editieren';
$_lang['ditsnews.groups.remove'] = 'Gruppe entfernen';
$_lang['ditsnews.groups.remove.title'] = 'Gruppe entfernen?';
$_lang['ditsnews.groups.remove.confirm'] = 'Sind Sie sicher, dass Sie die Gruppe entfernen möchten? Abonnenten werden nicht entfernt.';
$_lang['ditsnews.groups.update'] = 'Gruppe updaten';
$_lang['ditsnews.groups.saved'] = 'Gruppe gespeichert';

//subscribers
$_lang['ditsnews.subscribers'] = 'Abonnenten';
$_lang['ditsnews.subscribers.firstname'] = 'Vorname';
$_lang['ditsnews.subscribers.lastname'] = 'Nachname';
$_lang['ditsnews.subscribers.company'] = 'Firma';
$_lang['ditsnews.subscribers.email'] = 'E-Mail';
$_lang['ditsnews.subscribers.new'] = 'neuer Abonnent';
$_lang['ditsnews.subscribers.exportcsv'] = 'CSV-Export';
$_lang['ditsnews.subscribers.importcsv'] = 'CSV-Import';
$_lang['ditsnews.subscribers.importcsv.start'] = 'Import starten';
$_lang['ditsnews.subscribers.importcsv.file'] = 'Datei';
$_lang['ditsnews.subscribers.importcsv.results'] = 'Ergebnisse';
$_lang['ditsnews.subscribers.importcsv.err.uploadfile'] = 'Bitte laden Sie eine Datei hoch';
$_lang['ditsnews.subscribers.importcsv.err.cantopenfile'] = 'Kann Datei nicht öffnen';
$_lang['ditsnews.subscribers.importcsv.err.firstrow'] = 'Die erste Zeile muss die Spaltennamen enthalten (Die erste Spalte muss email sein)';
$_lang['ditsnews.subscribers.importcsv.err.cantsaverow'] = 'Konnte Zeile [[+rownum]] nicht speichern';
$_lang['ditsnews.subscribers.importcsv.err.skippedrow'] = 'Zeile [[+rownum]] übersprungen';
$_lang['ditsnews.subscribers.importcsv.msg.complete'] = 'Import abgeschlossen. [[+importCount]] Einträge importiert ([[+newCount]] neu)';
$_lang['ditsnews.subscribers.confirm.subject'] = 'Bitte bestätigen Sie Ihr Newsletter-Abonnement';
$_lang['ditsnews.subscribers.confirm.success'] = 'Sie haben nun unseren Newsletter abonniert.';
$_lang['ditsnews.subscribers.confirm.err'] = 'Abonnent / Code Kombination inkorrekt.';
$_lang['ditsnews.subscribers.signup.err.emailunique'] = 'Diese E-Mail Adresse wird bereits verwendet';
$_lang['ditsnews.subscribers.unsubscribe.success'] = 'Sie wurden von unserem Newsletter-Verteiler entfernt.';
$_lang['ditsnews.subscribers.unsubscribe.err'] = 'Abonnent nicht gefunden.';
$_lang['ditsnews.subscribers.active'] = 'Aktiv';
$_lang['ditsnews.subscribers.groups'] = 'Gruppen';
$_lang['ditsnews.subscribers.remove'] = 'Abonnent entfernen';
$_lang['ditsnews.subscribers.remove.title'] = 'Abonnent entfernen?';
$_lang['ditsnews.subscribers.remove.confirm'] = 'Sind Sie sicher, dass Sie den Abonnent entfernen möchten??';
$_lang['ditsnews.subscribers.update'] = 'Abonnent editieren';
$_lang['ditsnews.subscribers.saved'] = 'Abonnent gespeichert';
$_lang['ditsnews.subscribers.error'] = 'Es trat ein Fehler beim Speichern des Abonnenten auf';

//settings
$_lang['ditsnews.settings'] = 'Einstellungen';
$_lang['ditsnews.settings.name'] = 'Name';
$_lang['ditsnews.settings.email'] = 'E-Mail';
$_lang['ditsnews.settings.bounceemail'] = 'E-Mail Adresse unzustellbar (entfernen)';
$_lang['ditsnews.settings.confirmpage'] = 'Bestätigungsseite';
$_lang['ditsnews.settings.unsubscribepage'] = 'Abonnement löschen Seite';
$_lang['ditsnews.settings.template'] = 'Template';
$_lang['ditsnews.settings.saved'] = 'Einstellungen gespeichert';
$_lang['ditsnews.settings.error'] = 'Es trat ein Fehler beim Speichern der Einstellungen auf';