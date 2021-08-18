<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Filter form
 *
 * @package    tool_coursestatistics
 * @copyright  BS-23
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once("$CFG->libdir/formslib.php");

class filterform extends moodleform
{
    //Add elements to form
    public function definition()
    {
        global $CFG,$DB;

        $mform = $this->_form; // Don't forget the underscore!
        $mform->addElement('html', '<h4>'.get_string('coursestatistics_filter', 'tool_coursestatistics').'</h4><br><br>');

        $courses = $DB->get_records('course',null);
        $options= [];
        $options[-1]= 'None';
        foreach($courses AS $course) {
            $options[$course->id] = $course->fullname;
        }

        $mform->addElement('select', 'courses', get_string('coursestatistics_course', 'tool_coursestatistics'), $options); // Add elements to your form
        $mform->setType('courses', PARAM_INT);                   //Set type of element
        $mform->setDefault('courses', -1);        //Default value

        $buttonarray=array();
        //$buttonarray[] = $mform->createElement('submit', 'Submit', 'Filter');
        $mform->addgroup($buttonarray, 'buttonar', '', ' ', false);

    }

    //Custom validation should be added here
    public function validation($data, $files)
    {
        return array();
    }

}