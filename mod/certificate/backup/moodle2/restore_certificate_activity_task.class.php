<?php

// This file is part of the Certificate module for Moodle - http://moodle.org/
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
 * @package moodlecore
 * @subpackage backup-moodle2
 * @copyright 2010 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/certificate/backup/moodle2/restore_certificate_stepslib.php'); // Because it exists (must)

/**
 * certificate restore task that provides all the settings and steps to perform one
 * complete restore of the activity
 */
class restore_certificate_activity_task extends restore_activity_task {

    /**
     * Define (add) particular settings this activity can have
     */
    protected function define_my_settings() {
        // No particular settings for this activity
    }

    /**
     * Define (add) particular steps this activity can have
     */
    protected function define_my_steps() {
        // Certificate only has one structure step
        $this->add_step(new restore_certificate_activity_structure_step('certificate_structure', 'certificate.xml'));
    }

    /**
     * Define the contents in the activity that must be
     * processed by the link decoder
     */
    static public function define_decode_contents() {
        $contents = array();

        $contents[] = new restore_decode_content('certificate', array('intro'), 'certificate');

        return $contents;
    }

    /**
     * Define the decoding rules for links belonging
     * to the activity to be executed by the link decoder
     */
    static public function define_decode_rules() {
        $rules = array();

        $rules[] = new restore_decode_rule('CERTIFICATEVIEWBYID', '/mod/certificate/view.php?id=$1', 'course_module');
        $rules[] = new restore_decode_rule('CERTIFICATEINDEX', '/mod/certificate/index.php?id=$1', 'course');

        return $rules;

    }

    /**
     * Define the restore log rules that will be applied
     * by the {@link restore_logs_processor} when restoring
     * certificate logs. It must return one array
     * of {@link restore_log_rule} objects
     */
    static public function define_restore_log_rules() {
        $rules = array();

        $rules[] = new restore_log_rule('certificate', 'add', 'view.php?id={course_module}', '{certificate}');
        $rules[] = new restore_log_rule('certificate', 'update', 'view.php?id={course_module}', '{certificate}');
        $rules[] = new restore_log_rule('certificate', 'view', 'view.php?id={course_module}', '{certificate}');
        $rules[] = new restore_log_rule('certificate', 'received', 'report.php?a={certificate}', '{certificate}');
        $rules[] = new restore_log_rule('certificate', 'view report', 'report.php?id={certificate}', '{certificate}');

        return $rules;
    }

    /**
     * Define the restore log rules that will be applied
     * by the {@link restore_logs_processor} when restoring
     * course logs. It must return one array
     * of {@link restore_log_rule} objects
     *
     * Note this rules are applied when restoring course logs
     * by the restore final task, but are defined here at
     * activity level. All them are rules not linked to any module instance (cmid = 0)
     */
    static public function define_restore_log_rules_for_course() {
        $rules = array();

        // Fix old wrong uses (missing extension)
        $rules[] = new restore_log_rule('certificate', 'view all', 'index.php?id={course}', null);

        return $rules;
    }

    /*
     * This function is called after all the activities in the backup have been restored.
     * This allows us to get the new course module ids, as they may have been restored
     * after the certificate module, meaning no id was available at the time.
     */
    public function after_restore() {
        global $DB;

        // Get the new module
        $sql = "SELECT c.*
                FROM {certificate} c
                INNER JOIN {course_modules} cm
                ON c.id = cm.instance
                WHERE cm.id = :cmid";
        if ($certificate = $DB->get_record_sql($sql, (array('cmid'=>$this->get_moduleid())))) {
            // A flag to check if we need to update the database or not
            $update = false;
            if ($certificate->printdate > 2) { // If greater than 2, then it is a grade item value
                if ($newitem = restore_dbops::get_backup_ids_record($this->get_restoreid(), 'course_module', $certificate->printdate)) {
                    $update = true;
                    $certificate->printdate = $newitem->newitemid;
                }
            }
            if ($certificate->printgrade > 2) {
                if ($newitem = restore_dbops::get_backup_ids_record($this->get_restoreid(), 'course_module', $certificate->printgrade)) {
                    $update = true;
                    $certificate->printgrade = $newitem->newitemid;
                }
            }
            if ($update) {
                // Update the certificate
                $DB->update_record('certificate', $certificate);
            }
        }
    }
}
