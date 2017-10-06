<?php
require(__DIR__. '/../constants.php');

function xmldb_report_coursestats_upgrade($oldversion) {
    global $DB;
    $dbman = $DB->get_manager();

    if ($oldversion < 2017061737) {

        // Define field categoryid to be added to report_coursestats.
        $table = new xmldb_table(PLUGIN_TABLE_NAME);
        $field = new xmldb_field('categoryid', XMLDB_TYPE_INTEGER, '10', null, null, null, '0', 'last_update');
		
        // Conditionally launch add field categoryid.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

		$key = new xmldb_key('categoryid_fk', XMLDB_KEY_FOREIGN, array('categoryid'), 'course_categories', array('id'));

        // Launch add key categoryid_fk.
        $dbman->add_key($table, $key);


        // Coursestats savepoint reached.
        upgrade_plugin_savepoint(true, 2017061737, 'report', 'coursestats');
        
		$result = $DB->get_records(PLUGIN_TABLE_NAME);
		foreach ($result as $cs) {
			$course = $DB->get_record(COURSE_TABLE_NAME, array('id'=>$cs->courseid));
			$cs->categoryid = $course->category;
			$DB->update_record(PLUGIN_TABLE_NAME, $cs); 
		}

    }


    return true;
}
