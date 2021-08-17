<?php
require_once("$CFG->libdir/externallib.php");

class tool_coursestatistics_external extends external_api
{

    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function get_grades_parameters() {
        return new external_function_parameters(
            array()
        );
    }

    public static function get_grades() {
        global $DB;

        $result = array();
        //$result = array_filter($grading_info, 'array_filter');

        $sql = "SELECT course.shortname AS course,COUNT(en.id) as enrolled
                FROM mdl_course as course 
                JOIN mdl_enrol AS en ON en.courseid = course.id 
                JOIN mdl_user_enrolments AS ue ON ue.enrolid = en.id 
                JOIN mdl_user AS user2 ON ue.userid = user2.id
                GROUP BY course";

        $result['total'] = $DB->get_records_sql($sql);

        $sql = "SELECT c.shortname,COUNT(gg.userid) as passed
                FROM mdl_grade_grades as gg 
                JOIN mdl_grade_items AS gi ON gi.id = gg.itemid
                JOIN mdl_course AS c ON c.id = gi.courseid
                JOIN mdl_user AS u ON u.id = gg.userid
                WHERE gi.itemtype='course' AND gg.finalgrade > gi.gradepass
                GROUP BY c.id";

        $result['passed'] = $DB->get_records_sql($sql);

        $sql = "SELECT c.shortname,COUNT(gg.userid) as failed
                FROM mdl_grade_grades as gg 
                JOIN mdl_grade_items AS gi ON gi.id = gg.itemid
                JOIN mdl_course AS c ON c.id = gi.courseid
                JOIN mdl_user AS u ON u.id = gg.userid
                WHERE gi.itemtype='course' AND gg.finalgrade <= gi.gradepass
                GROUP BY c.id";

        $result['failed'] = $DB->get_records_sql($sql);

        return json_encode($result);
    }

    public static function get_grades_returns() {
        return new external_value(PARAM_RAW, 'Response');
    }
}