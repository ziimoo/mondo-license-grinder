<?php
define('DBTYPE','mysql');
define('DBHOST', $OPENSHIFT_MYSQL_DB_HOST);
define('DBPORT', $OPENSHIFT_MYSQL_DB_PORT);
define('DBUSER','admin8hZBFZs');
define('DBPASS','IJkM3P1gItbg');
define('DBNAME','mondo');
define('JQUERY','http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js');
define('JQUERYUI','http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js');
define('DOCSTORE','/path/to/licensedocs');
// the "cryptkey" file should be 32 bytes of original random data,
// e.g. head -c 32 /dev/urandom > cryptkey
// This is used to encrypt license documents
// NB. if you change the contents of this file, any previously stored docs will be unreadable
define('DOCKEY', 'asdasd adasda asdasd adasd adsadas');
//trailing slash needed
define('BASE_URL','http://mondo-thinkingbase.rhcloud.com/');

