<?php if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');
/**
 *
 * Constants
 *  
 * PHP 5
 *
 * tinySite(tm) : Tiny and Simple Content Management System
 * Copyright 2012, 7 Media Web Solutions, LLC (http://www.7mediaws.org/)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2012, 7 Media Web Solutions, LLC (http://www.7mediaws.org/)
 * @since tinySite(tm) v 1.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

// When system was installed?
$system = array();
$system['title'] = '{product}';
$system['company'] = '{company}';
$system['version'] = '{version}';
$system['installed'] = '{datenow}';

/* Set this to false in a production environment */
defined( 'DEVELOPMENT_ENVIRONMENT' )	or define( 'DEVELOPMENT_ENVIRONMENT', FALSE );

defined( 'DB_HOST' )					or define('DB_HOST', '{hostname}');
defined( 'DB_NAME' )					or define('DB_NAME', '{database}');
defined( 'DB_USER' )					or define('DB_USER', '{username}');
defined( 'DB_PASS' )					or define('DB_PASS', '{password}');
defined( 'TP' )							or define('TP' , '{dbprefix}'); // defines the table prefix

/* Always provide a TRAILING SLASH (/) AFTER A PATH */
defined( 'BASE_URL' )					or define( 'BASE_URL', '{siteurl}');
defined( 'SITE_TITLE' )					or define( 'SITE_TITLE', '{sitetitle}' );
defined( 'ADMIN_SLUG' )					or define( 'ADMIN_SLUG', '');
defined( 'LOGIN_SLUG' )					or define( 'LOGIN_SLUG', '');