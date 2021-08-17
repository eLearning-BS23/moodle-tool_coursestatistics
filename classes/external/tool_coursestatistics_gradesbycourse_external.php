<?php
require_once("$CFG->libdir/externallib.php");

class tool_coursestatistics_gradesbycourse_external extends external_api
{

    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function getgradesbycourse_parameters() {
        return new external_function_parameters(
            array("courseid" => new external_value(PARAM_INT, "courseid"))
        );
    }

    public static function getgradesbycourse($id) {
        global $DB;

        $params = self::validate_parameters(
            self::getgradesbycourse_parameters(),
            array('courseid'=>$id)
        );

        $result = array();

        $sql = "SELECT c.fullname,COUNT(gg.userid) as passed
                FROM mdl_grade_grades as gg 
                JOIN mdl_grade_items AS gi ON gi.id = gg.itemid
                JOIN mdl_course AS c ON c.id = gi.courseid
                JOIN mdl_user AS u ON u.id = gg.userid
                WHERE gi.itemtype='course' 
                    AND gg.finalgrade > gi.gradepass
                    AND c.id = :courseid
                GROUP BY c.id";

        $result['passed'] = array_values($DB->get_records_sql($sql, array('courseid'=>$id)));

        $sql = "SELECT c.fullname,COUNT(gg.userid) as failed
                FROM mdl_grade_grades as gg 
                JOIN mdl_grade_items AS gi ON gi.id = gg.itemid
                JOIN mdl_course AS c ON c.id = gi.courseid
                JOIN mdl_user AS u ON u.id = gg.userid
                WHERE gi.itemtype='course' 
                  AND gg.finalgrade <= gi.gradepass
                  AND c.id = :courseid
                GROUP BY c.id";

        $result['failed'] = array_values($DB->get_records_sql($sql, array('courseid'=>$id)));

        $res = array(
            'course'=>$result['passed'][0]->fullname,
            'passed'=>$result['passed'][0]->passed,
            'failed'=>$result['failed'][0]->failed
        );

        return json_encode($res);
    }

    public static function getgradesbycourse_returns() {
        return new external_value(PARAM_RAW, 'Response');
    }
}