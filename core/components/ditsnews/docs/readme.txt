-------------------
Component: DitsNews
-------------------
Version: 0.2.0 alpha3
Since: June, 23rd, 2011
Author: Dit's Media (info@ditsmedia.nl)
License: GNU GPLv2 (or later at your option)

==========================================
 !!!!! Warning  !!!!!
==========================================

Version 0.2.0 is not 100% compatible with 0.1.0! There are some database and functionality changes. As always, backup before updating!

Also, the CSV import/export is missing in this release. It will be back in 0.2.1.

==========================================
 Description
==========================================

This component is a newsletter system for MODX Revolution. It allows you to manage subscribers/groups and send newsletters.

==========================================
 Features
==========================================
* newsletters/groups/subscribers management
* import/export subscribers (CSV)
* message queue (50 messages per batch)
* subscribe through form
* confirm subscription (link in email message)
* unsubscribe via link in newsletter
* public/private groups (you can only subscribe to public groups)

==========================================
 Upcoming versions (TODO)
==========================================
* move settings to MODX System Settings
* make message queue batch size editable (fixed at 50 for now)
* statistics (views, bounces, etc.)
* handle bounces
* remove unconfirmed subscriptions
* more translations (english and dutch only for now)

==========================================
 Requirements
==========================================
* MODX Revolution (tested with 2.1.1)
* FormIt (for subscription form)
* Cronjobs (or some other method to run a script periodically)

==========================================
 Installation
==========================================
* Install through Package Management
* Add a cronjob (change paths): */5 * * * * /path/to/php /path/to/core/components/ditsnews/cron/cron.php
* Create the newsletter template (just a normal template; CSS must be in the template itself with full URL paths to images. No external CSS!)
* Create a signup page (ditsnewssignup chunk; change as required)
* Create a "Thank you" page (and set it as 'redirectTo' in the ditsnewssignup chunk)
* Create a confirm / opt-in page (add ditsnewsconfirm snippet) and set it's id in ditsnewssignup chunk
* Create a unsubscribe page (add ditsnewsunsubscribe snippet) and add a link to this page in your newsletter template
* Go to Components -> DitsNews and change the settings (Menu -> Settings)

==========================================
 How to send your first newsletter
==========================================
* Add a testing Group
* Add yourself as a subscriber (and add yourself to the testing group)
* Create a new newsletter and select the document you just created. Send it to the testing group only!
* After the cronjob runs you will receive your newsletter
* Test the newsletter in many differtent email clients (Apple Mail, Outlook, Gmail, etc.)
* For every webmail client: check the newsletter in different browsers!

==========================================
 Example newsletter template
==========================================
[[!ditsnewsPlaceholders? &firstnameDefault=`Subscriber`]] <!-- Sets firstname field of email newsletter to "Subscriber" when empty -->
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>My newsletter</title>
<base href="[[++site_url]]" /><!-- Important! DitsNews needs this to create correct URLs! -->
<style type="text/css">
a {
 font-weight: bold;
 color: #ff0000
}
</style>
</head>
<body>
<p>Hello [[!+firstname:default=`Subscriber`]],</p>
[[*content]]
<p><a href="[[~10]]">Unsubscribe</a></p><!-- Link to unsubscribe page: user data will be added while sending -->
</body>
</html>

==========================================
 Available placeholders
==========================================
[[+firstname]]
[[+lastname]]
[[+fullname]]
[[+company]]
[[+email]]