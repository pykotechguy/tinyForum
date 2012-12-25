tinyForum
=========

tinyForum is a simple and lightweight forum built using the tinyPHP MVC Framework.

## Beta

Please be advised, this is beta. Although it should work without issues, be careful with 
installing on a production server. I advise that you use for testing purposes only until 
1.0-Stable is released.

## Requirements

* PHP 5.3.x
* MySQLi
* mod_rewrite

## Installation

* You must update the .htaccess before uploading the files to your server. For example, if you 
are going to install the files at http://example.com/forum/, then you will need to edit 
.htaccess accordingly (RewriteBase /forum/, RewriteRule ^$ http://example.com/forum/index)

* Upload the files to the server, bring up the url in the browser where you have installed the 
files and follow through with the installer. Once the installer is complete, it will redirect you 
to a blank page (http://example.com/index.php). index.php is not being served. So you will need to 
delete the index.php at the end. This will only happen after installation. I need to figure out a fix 
for this.

* Now that you see your newly installed forum, you may log in and start setting it up.

## Changelog and New Features

* version 0.1.BETA-1 (2012.12.25) - Initial commit with README.md
* version 0.1.BETA-1 (2012.12.25) - All files and installer uploaded
* version 0.2.BETA (2012.12.25) - Fixed issue with lists in forum posts, moved version constant to index.php, and 
updated versioning.