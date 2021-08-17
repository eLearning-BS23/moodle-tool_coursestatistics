<?php

//$services = array(
//    'getcoursegrades' => array(                      //the name of the web service
//        'functions' => array('tool_coursestatistics_get_grades'), //web service functions of this service
//        'requiredcapability' => '',                //if set, the web service user need this capability to access
//        //any function of this service. For example: 'some/capability:specified'
//        'restrictedusers' => 0,                      //if enabled, the Moodle administrator must link some user to this service
//        //into the administration
//        'enabled' => 1,                               //if enabled, the service can be reachable on a default installation
//    )
//);
$functions = array(
    'tool_coursestatistics_get_grades' => array(
        'classname' => 'tool_coursestatistics_external',
        'methodname' => 'get_grades',
        'classpath' => 'admin/tool/coursestatistics/classes/external/tool_coursestatistics_external.php',
        'description' => 'Load grades data',
        'type' => 'read',
        'ajax' => true,
        'loginrequired' => true,
    ),
    'tool_coursestatistics_getgradesbycourse' => array(
        'classname' => 'tool_coursestatistics_gradesbycourse_external',
        'methodname' => 'getgradesbycourse',
        'classpath' => 'admin/tool/coursestatistics/classes/external/tool_coursestatistics_gradesbycourse_external.php',
        'description' => 'Load grades data by course id',
        'type' => 'read',
        'ajax' => true,
        'loginrequired' => true,
    )
);

