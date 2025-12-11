<?php
header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ERROR | E_PARSE); //error_reporting(E_ERROR | E_WARNING | E_PARSE);

if (preg_match ("/(192.168|10.4.100|10.4.101|10.211.55|127.0.0)/i", $_SERVER["SERVER_ADDR"])) {
	define('S_SRV', 'local');
	define('PRO_HOST', 'http://testedu');
	define('SURVEY_HOST', 'http://survey.testedu');
} else {
	define('S_SRV', 'remote');
	define('PRO_HOST', 'http://test.edu.kg');
	define('SURVEY_HOST', 'http://survey.test.edu.kg');
}

//#...................... Pathes
define('S_ROOT', dirname(__FILE__));
define('S_LIB', S_ROOT . '/_lib');
define('A_ADM', 'iadm');
define('S_ADM', 'istd');
define('T_ADM', 'itch');
define('T_RTN', 'ratings');

define('S_AVA', 'Files/ava');
define('S_PIC', 'Files/pic');
define('S_STORAGE', 'Files/storage');
define('S_UPLOADS', 'Files/uploads');

//#......................Global Constants
define('MAX_MODULES', 4);
define('MIN_PERCENT', 60);
define('MAX_TEST_SCORE', 40);
define('MIN_TEST_SCORE', 24); //MAX_TEST_SCORE*MIN_PERCENT/100
define('MAX_ATTEND_SCORE', 20);
define('MAX_ACTIVITY_SCORE', 40);
define('EXPIRY', 604800);


//#...................... General options
// Include in All script
if (!defined("PATH_SEPARATOR"))
	define("PATH_SEPARATOR", getenv("COMSPEC")? ";" : ":");
ini_set("include_path", ini_get("include_path").PATH_SEPARATOR.dirname(__FILE__));

//#...................... DSN connect to DB
if (S_SRV == 'local') {
	define('S_DSN_DEFAULT', 'mypdo://host_574946_dev:rjdK076dc8fJcAGZ@localhost/host_574946_dev?charset=utf8');
} else {
	define('S_DSN_DEFAULT', 'mypdo://host_574946_dev:rjdK076dc8fJcAGZ@localhost/host_574946_dev?charset=utf8');
}
// if (S_SRV == 'local') {
// 	define('S_DSN_DEFAULT', 'mypdo://host__admin:RRuMwZV6VjYXCMFR@localhost/host_574946_A?charset=utf8');
// } else {
// 	define('S_DSN_DEFAULT', 'mypdo://host__admin:RR$uMw!ZV6VjYXCMFR@localhost/host_574946_A?charset=utf8');
// }

// if (S_SRV == 'local') {
// 	define('S_DSN_S', 'mypdo://host__admin:RRuMwZV6VjYXCMFR@localhost/host_574946_S?charset=utf8');
// } else {
// 	define('S_DSN_S', 'mypdo://host__admin:RR$uMw!ZV6VjYXCMFR@localhost/host_574946_S?charset=utf8');
// }

// if (S_SRV == 'local') {
// 	define('S_DSN_T', 'mypdo://host__admin:RRuMwZV6VjYXCMFR@localhost/host_574946_tk?charset=utf8');
// } else {
// 	define('S_DSN_T', 'mypdo://host__admin:RR$uMw!ZV6VjYXCMFR@localhost/host_574946_tk?charset=utf8');
// }

define('S_TABLE_PREFIX', 'ts_');

date_default_timezone_set("Asia/Bishkek");

//#...................... Include files
require_once S_LIB . '/debug.php';
require_once S_LIB . '/db.php';
require_once S_LIB . '/functions.php';
require_once S_LIB . '/tsclass.php';

$pathInfo = getPath();
$sPath    = $pathInfo[0];
$last     = $pathInfo[1];
$lang     = $pathInfo[2];
$postfix  = $pathInfo[3];
$tsreq  = $pathInfo[4];

include "__outsider/lang/_" . $lang . ".php";

$TS = new TS_cli;

$exam_statuses = array(
	array("Pending", "text-info", "btn-info"),
	array("Active", "text-success", "btn-success"),
	array("Close", "text-danger", "btn-danger"),
);
$exam_modes = array("pending","active","close");

$module_statuses = array(
	array("Pending", "text-info", "btn-info"),
	array("Active", "text-success", "btn-success"),
	array("Close", "text-danger", "btn-danger"),
	array("Deleted", "text-secondary", "btn-secondary")
);
$module_modes = array("pending","active","close");

$modulesMeta = array(
	"modes" => array("pending","active","close","deleted"),
	"statuses" => array(array("Pending","info"), array("Active","success"), array("Close","danger"), array("Deleted","secondary"))
);

