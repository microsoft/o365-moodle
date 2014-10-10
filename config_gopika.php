<?php  // Moodle configuration file

unset($CFG);
global $CFG;
$CFG = new stdClass();

$CFG->dbtype    = 'mysqli';
$CFG->dblibrary = 'native';
$CFG->dbhost    = 'localhost';
$CFG->dbname    = 'moodle';
$CFG->dbuser    = 'root';
$CFG->dbpass    = '';
$CFG->prefix    = 'mdl_';
$CFG->dboptions = array (
  'dbpersist' => 0,
  'dbport' => '',
  'dbsocket' => '',
);

$CFG->wwwroot   = 'http://gopikalocal.com';
$CFG->dataroot  = 'C:\\wamp\\moodledata';
$CFG->admin     = 'admin';
$CFG->calendar  = 'oeventshook';

$CFG->directorypermissions = 0777;

$CFG->phpunit_prefix = 'phpu_';
$CFG->phpunit_dataroot = 'C:\\wamp\\phpu_moodledata';

require_once(dirname(__FILE__) . '/lib/setup.php');

// There is no php closing tag in this file,
// it is intentional because it prevents trailing whitespace problems!
