<?php

ini_set('error_reporting', E_ALL | E_STRICT);
ini_set('display_errors', true);
ini_set('log_errors', true);
set_time_limit(0);

/*
 * Turn off output buffering
 */
while (ob_get_level()) {
    ob_end_clean();
}

require_once '/var/www/html/magento/app/bootstrap.php';

$bootstrap = \Magento\Framework\App\Bootstrap::create(BP, $_SERVER);
$bootstrap->getObjectManager()->get('Magento\Framework\App\State')->setAreaCode('crontab');

//Set php to display errors
ini_set('display_errors', 1);

//Start timer
function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());

    return ((float)$usec + (float)$sec);
}

//don't print anything to the screen until end of script or buffer is full.
ob_start();

/** @var SalesOrderIndexGridAsyncInsertCron $obj */
$obj = $bootstrap->getObjectManager()->get('SalesOrderIndexGridAsyncInsertCron');

$obj->execute();