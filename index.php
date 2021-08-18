<?php


require('../../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->libdir.'/gradelib.php');
require_once($CFG->dirroot.'/'.$CFG->admin.'/tool/coursestatistics/forms/filterform.php');

global $DB;

$PAGE->requires->css('/admin/tool/coursestatistics/assets/css/custom.css');
// Print the header.
echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('coursestatistics', 'tool_coursestatistics'));
//echo html_writer::link('/', 'Hello', array('id'=>'link'));
$stringman = get_string_manager();
$strings = $stringman->load_component_strings('tool_coursestatistics', 'en');
$PAGE->requires->strings_for_js(array_keys($strings), 'tool_coursestatistics');
echo html_writer::start_tag('pre');
//$grading_info = new GetGrades();
//print_r($grading_info->getresults());
//print_r($grading_info->get_course_eroll_count());
echo html_writer::end_tag('pre');

echo html_writer::start_div('chart');
echo html_writer::start_tag('canvas', array('id' =>'myChart'));
echo html_writer::end_tag('canvas');
echo html_writer::end_div();

echo html_writer::start_div('chart');
echo html_writer::start_tag('canvas', array('id' =>'failed'));
echo html_writer::end_tag('canvas');
echo html_writer::end_div();

echo html_writer::start_div('chart doughnut');

$mform = new filterform();

$mform->set_data(array());
$mform->display();
echo html_writer::start_tag('h3', array('id' =>'courseinfo'));
echo html_writer::end_tag('h3');
echo html_writer::start_tag('canvas', array('id' =>'doughnut'));
echo html_writer::end_tag('canvas');
echo html_writer::end_div();



echo html_writer::script(false , 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js');
//$PAGE->requires->js(new moodle_url('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js'));
$PAGE->requires->js(new moodle_url($CFG->wwwroot.'/admin/tool/coursestatistics/assets/js/custom.js'));
//echo html_writer::script(false , $CFG->wwwroot.'/admin/tool/coursestatistics/assets/js/custom.js');
echo $PAGE->requires->get_end_code(false);
