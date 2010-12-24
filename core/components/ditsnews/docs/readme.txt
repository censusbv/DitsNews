-------------------
Component: DitsNews
-------------------
Version: 0.1 alpha
Since: December 24th, 2010
Author: Dit's Media (info@ditsmedia.nl)
License: GNU GPLv2 (or later at your option)

This component is a newsletter system for MODx Revolution. It allows you to manage subscribers/groups and send newsletters.

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
* move settings to MODx System Settings
* make message queue batch size editable (fixed at 50 for now)
* statistics (views, bounces, etc.)
* handle bounces
* remove unconfirmed subscriptions
* more translations (english and dutch only for now)

==========================================
 Requirements
==========================================
* MODx Revolution
* FormIt (for subscription form)
* Cronjobs (or some other method to run a script periodically)

==========================================
 Installation
==========================================
* Install through Package Management
* Add a cronjob (change paths): */5 * * * * /path/to/php /path/to/core/components/ditsnews/cron/cron.php
* Create the newsletter template (just a normal template; CSS must be in the template itself/no external CSS!)
* Create a signup page (ditsnewssignup chunk; change as required)
* Create a "Thank you" page (and set it as 'redirectTo' in the ditsnewssignup chunk)
* Create a confirm / opt-in page (add ditsnewsconfirm snippet)
* Create a unsubscribe page (add ditsnewsunsubscribe snippet)
* Go to Components -> DitsNews and change the settings (Menu -> Settings)

==========================================
 How to send your first newsletter
==========================================
* Add a testing Group
* Add yourself as a subscriber (and add yourself to the testing group)
* Create a newsletter based on the newsletter template
* Create a new newsletter and select the document you just created. Send it to the testing group only!
* After the cronjob runs you will receive your newsletter
* Test the newsletter in many differtent email clients (Apple Mail, Outlook, Gmail, etc.)
* For every webmail client: check the newsletter in different browsers!

==========================================
 Example newsletter template
==========================================
<html>
<head>
<title>My newsletter</title>
<base href="[[++site_url]]" />
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
[[!+unsubscribe:notempty=`<p><a href="[[+unsubscribe]]">Unsubscribe</a></p>`]]
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
[[+unsubscribe]]