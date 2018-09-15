<?php
    date_default_timezone_set("Asia/Jakarta");
    defined("DBDRIVER")or define('DBDRIVER','mysql');
    defined("DBHOST")or define('DBHOST','127.0.0.1');
    defined("DBNAME")or define('DBNAME','expert_system');
    defined("DBUSER")or define('DBUSER','root');
    defined("DBPASS")or define('DBPASS','root'); 

    $connect = new mysqli(DBHOST,DBUSER,DBPASS,DBNAME);
?>