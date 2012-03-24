<?php
/**
 * Default English Lexicon Entries for DitsNews
 *
 * @package ditsnews
 * @subpackage lexicon
 */

//general
$_lang['ditsnews'] = 'DitsNews';
$_lang['ditsnews.desc'] = 'Newsletter manager for MODX';
$_lang['ditsnews.menu'] = 'Menu';
$_lang['ditsnews.search...'] = 'Search...';

//newsletters
$_lang['ditsnews.newsletters'] = 'Newsletters';
$_lang['ditsnews.newsletters.subject'] = 'Subject';
$_lang['ditsnews.newsletters.date'] = 'Date';
$_lang['ditsnews.newsletters.document'] = 'Document';
$_lang['ditsnews.newsletters.total'] = 'Total';
$_lang['ditsnews.newsletters.sent'] = 'Sent';
$_lang['ditsnews.newsletters.new'] = 'New newsletter';
$_lang['ditsnews.newsletters.groups'] = 'Groups';
$_lang['ditsnews.newsletters.remove'] = 'Remove newsletter';
$_lang['ditsnews.newsletters.remove.title'] = 'Remove newsletter?';
$_lang['ditsnews.newsletters.remove.confirm'] = 'Are you sure you want to remove this newsletter and all it\'s data?';
$_lang['ditsnews.newsletters.saved'] = 'Newsletter saved (scheduled)';
$_lang['ditsnews.newsletters.err.save'] = 'Could not save/schedule newsletter';
$_lang['ditsnews.newsletters.err.nf'] = 'Could not open/find document';
$_lang['ditsnews.newsletters.err.remove'] = 'Could not remove newsletter';

//groups
$_lang['ditsnews.groups'] = 'Groups';
$_lang['ditsnews.groups.name'] = 'Name';
$_lang['ditsnews.groups.public'] = 'Public';
$_lang['ditsnews.groups.public.desc'] = 'Public (allow subscription through form)';
$_lang['ditsnews.groups.members'] = 'Members';
$_lang['ditsnews.groups.members'] = 'Members';
$_lang['ditsnews.groups.new'] = 'New group';
$_lang['ditsnews.groups.edit'] = 'Edit group';
$_lang['ditsnews.groups.remove'] = 'Remove group';
$_lang['ditsnews.groups.remove.title'] = 'Remove group?';
$_lang['ditsnews.groups.remove.confirm'] = 'Are you sure you want to remove this group? Subscribers won\'t be deleted';
$_lang['ditsnews.groups.update'] = 'Update group';
$_lang['ditsnews.groups.saved'] = 'Group saved';
$_lang['ditsnews.groups.err.nf'] = 'Group not found';
$_lang['ditsnews.groups.err.save'] = 'Could not save group';

//subscribers
$_lang['ditsnews.subscribers'] = 'Subscribers';
$_lang['ditsnews.subscribers.firstname'] = 'First name';
$_lang['ditsnews.subscribers.lastname'] = 'Last name';
$_lang['ditsnews.subscribers.company'] = 'Company';
$_lang['ditsnews.subscribers.email'] = 'Email';
$_lang['ditsnews.subscribers.signupdate'] = 'Signup date';
$_lang['ditsnews.subscribers.new'] = 'New subscriber';
$_lang['ditsnews.subscribers.exportcsv'] = 'Export CSV';
$_lang['ditsnews.subscribers.importcsv'] = 'Import CSV';
$_lang['ditsnews.subscribers.importcsv.start'] = 'Start import';
$_lang['ditsnews.subscribers.importcsv.file'] = 'File';
$_lang['ditsnews.subscribers.importcsv.results'] = 'Results';
$_lang['ditsnews.subscribers.importcsv.err.uploadfile'] = 'Please, upload a file';
$_lang['ditsnews.subscribers.importcsv.err.cantopenfile'] = 'Can\'t open file';
$_lang['ditsnews.subscribers.importcsv.err.firstrow'] = 'First row must contain column names (first column must be email)';
$_lang['ditsnews.subscribers.importcsv.err.cantsaverow'] = 'Can\'t save row [[+rownum]]';
$_lang['ditsnews.subscribers.importcsv.err.skippedrow'] = 'Skipped row [[+rownum]]';
$_lang['ditsnews.subscribers.importcsv.msg.complete'] = 'Import complete. Imported [[+importCount]] records ([[+newCount]] new)';
$_lang['ditsnews.subscribers.confirm.subject'] = 'Confirm your newsletter subscription';
$_lang['ditsnews.subscribers.confirm.success'] = 'You are now subscribed to our newsletter.';
$_lang['ditsnews.subscribers.confirm.err'] = 'Subscriber / code combination incorrect.';
$_lang['ditsnews.subscribers.signup.err.emailunique'] = 'Email address already in use';
$_lang['ditsnews.subscribers.unsubscribe.success'] = 'You have been removed from our mailing list.';
$_lang['ditsnews.subscribers.unsubscribe.err'] = 'Subscriber not found.';
$_lang['ditsnews.subscribers.active'] = 'Active';
$_lang['ditsnews.subscribers.groups'] = 'Groups';
$_lang['ditsnews.subscribers.remove'] = 'Remove subscriber';
$_lang['ditsnews.subscribers.remove.title'] = 'Remove subscriber?';
$_lang['ditsnews.subscribers.remove.confirm'] = 'Are you sure you want to remove this subscriber?';
$_lang['ditsnews.subscribers.update'] = 'Update subscriber';
$_lang['ditsnews.subscribers.saved'] = 'Subscriber saved';
$_lang['ditsnews.subscribers.err.save'] = 'Error while saving subscriber';
$_lang['ditsnews.subscribers.err.ae'] = 'A subscriber with the same email address already exists';


//settings
$_lang['ditsnews.settings'] = 'Settings';
$_lang['ditsnews.settings.name'] = 'Name';
$_lang['ditsnews.settings.email'] = 'Email';
$_lang['ditsnews.settings.bounceemail'] = 'Bounce email address';
$_lang['ditsnews.settings.chunktpl'] = 'Name of chunk with template for email (if blank is taken from the template of the resource)';
$_lang['ditsnews.settings.confirmpage'] = 'Confirmation page';
$_lang['ditsnews.settings.unsubscribepage'] = 'Unsubscribe page';
$_lang['ditsnews.settings.template'] = 'Template';
$_lang['ditsnews.settings.saved'] = 'Settings saved';
$_lang['ditsnews.settings.error'] = 'Error while saving settings';