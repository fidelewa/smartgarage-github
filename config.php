<?php
define('WEB_URL', 'http://luxurygarage.e-mitic.com/');
define('ROOT_PATH', '/var/www/luxurygarage.e-mitic.com/web/gms/');


define('DB_HOSTNAME', '127.0.0.1');
define('DB_USERNAME', 'c1_luxu');
define('DB_PASSWORD', 'vj_88DnK');
define('DB_DATABASE', 'c1_luxu');
$link = mysql_connect(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD) or die(mysql_error());mysql_select_db(DB_DATABASE, $link) or die(mysql_error());?>
