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
 * Strings for component 'report_coursestats', language 'en'
 *
 * @package   	report
 * @subpackage 	coursestats
 * @copyright 	2017 Paulo Jr.
 * @license   	http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require(dirname(__FILE__).'/../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require(__DIR__. '/constants.php');

admin_externalpage_setup('reportcoursestats', '', null, '', array('pagelayout'=>'report'));
$category = optional_param('category', ALL_CATEGORIES, PARAM_INT);

function get_amount_created_courses($dep) {
	global $category;
	global $DB;
	
	if ($category == ALL_CATEGORIES and $dep == ALL_DEP) {
		return ($DB->count_records(COURSE_TABLE_NAME) - 1);
	} else if ($category == ALL_CATEGORIES and $dep != ALL_DEP) {
		return ($DB->count_records_sql('SELECT COUNT(*) FROM {course} co WHERE ' . $DB->sql_like('co.shortname', ':name', false, false), array('name'=>'%'.$dep.'%')));
	} else if ($category != ALL_CATEGORIES and $dep == ALL_DEP) {
		return $DB->count_records(COURSE_TABLE_NAME, array('category'=>$category));
	} else {
		return $DB->count_records_sql('SELECT COUNT(*) FROM {course} co WHERE co.category = :cat AND ' . $DB->sql_like('co.shortname', ':name', false, false), array('cat'=>$category, 'name'=>'%'.$dep.'%'));
	}	
}

function get_amount_used_courses($dep) {
	global $category;
	global $DB;
	
	if ($category == ALL_CATEGORIES and $dep == ALL_DEP) {
		return $DB->count_records(PLUGIN_TABLE_NAME);
	} else if ($category == ALL_CATEGORIES and $dep != ALL_DEP) {
		return $DB->count_records_sql('SELECT COUNT(*) FROM {course} co JOIN {report_coursestats} cs ON co.id = cs.courseid  WHERE ' . $DB->sql_like('co.shortname', ':name', false, false), array('name'=>'%'.$dep.'%'));
	} else if ($category != ALL_CATEGORIES and $dep == ALL_DEP) {
		return $DB->count_records(PLUGIN_TABLE_NAME, array('categoryid'=>$category));
	} else {
		return $DB->count_records_sql('SELECT COUNT(*) FROM {course} co JOIN {report_coursestats} cs ON co.id = cs.courseid  WHERE co.category = :cat AND ' . $DB->sql_like('co.shortname', ':name', false, false), array('cat'=>$category, 'name'=>'%'.$dep.'%'));
	}
}

$departments = array(
	array('cod'=>'gag', 'acr'=>'DAG', 'name'=>'DAG - Agricultura'),
	array('cod'=>'gbi', 'acr'=>'DBI', 'name'=>'DBI - Biologia'),
	array('cod'=>'gca', 'acr'=>'DCA', 'name'=>'DCA - Ciência dos Alimentos'),
	array('cod'=>'gcc', 'acr'=>'DCC', 'name'=>'DCC - Ciência da Computação'),
	array('cod'=>'gcs', 'acr'=>'DCS', 'name'=>'DCS - Ciência do Solo'),
	array('cod'=>'gsa', 'acr'=>'DSA', 'name'=>'DSA - Ciências da Saúde'),
	array('cod'=>'gex', 'acr'=>'DEX', 'name'=>'DEX - Ciências Exatas'),
	array('cod'=>'gef', 'acr'=>'DCF', 'name'=>'DCF - Ciências Florestais'),
	array('cod'=>'gch', 'acr'=>'DCH', 'name'=>'DCH - Ciências Humanas'),
	array('cod'=>'gdi', 'acr'=>'DIR', 'name'=>'DIR - Direito'),
	array('cod'=>'gde', 'acr'=>'DED', 'name'=>'DED - Educação'),
	array('cod'=>'gne', 'acr'=>'DEG', 'name'=>'DEG - Engenharia'),
	array('cod'=>'get', 'acr'=>'DEB', 'name'=>'DEN - Entomologia'),
	array('cod'=>'ges', 'acr'=>'DES', 'name'=>'DES - Estatística'),
	array('cod'=>'gfi', 'acr'=>'DFI', 'name'=>'DFI - Física'),
	array('cod'=>'gfp', 'acr'=>'DFP', 'name'=>'DFP - Fitopatologia'),
	array('cod'=>'gnu', 'acr'=>'DNU', 'name'=>'DNU - Nutrição'),
	array('cod'=>'gmv', 'acr'=>'DMV', 'name'=>'DMV - Medicina Veterinária'),
	array('cod'=>'gqi', 'acr'=>'DQI', 'name'=>'DQI - Química'),
	array('cod'=>'gzo', 'acr'=>'DZO', 'name'=>'DZO - Zootecnia')
); 

$dept_acr_array = array('DAG', 'DBI', 'DCA', 'DCC', 'DCS', 'DSA', 'DEX', 
	'DCF', 'DCH', 'DIR', 'DED', 'DEG', 'DEB', 'DES', 'DFI', 'DFP', 
	'DNU', 'DMV', 'DQI', 'DZO');

$url = new moodle_url($CFG->wwwroot . '/report/coursestats/index.php');
$link = html_writer::link($url, get_string('link_back', 'report_coursestats'));

if ($category == ALL_CATEGORIES) {
	$catname = get_string('lb_all_categories', 'report_coursestats');
} else {
	$cat = $DB->get_record(COURSE_CATEGORIES_TABLE_NAME, array('id'=>$category));
	$catname = $cat->name;
}

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('pluginname', 'report_coursestats') . ' (' .$catname. ') - ' . $link);

$table = new html_table();
$table->size = array( '55%', '15%', '15%', '15%');
$table->head = array(get_string('lb_choose_dep', 'report_coursestats'), get_string('lb_courses_created_amount', 'report_coursestats'),
	get_string('lb_used_courses', 'report_coursestats'), get_string('lb_percent_of_used_courses', 'report_coursestats'));

$link = '<a href=' . $CFG->wwwroot . '/report/coursestats/main.php?category=' . $category . '&depname=' . get_string('lb_all_dep', 'report_coursestats') . '&dep=' . ALL_DEP . '>' .get_string('lb_all_dep', 'report_coursestats') . '</a>';
$co_created = get_amount_created_courses(ALL_DEP);
$co_used = get_amount_used_courses(ALL_DEP);
if ($co_created > 0) {
	$co_percent = number_format(($co_used / $co_created) * 100, 2) . '%';
} else {
	$co_percent = '-';
}
	
$table->data[] = array($link, $co_created, $co_used, $co_percent);

$created_courses_array = array();
$used_courses_array = array();
$percentage_used_courses_array = array();

foreach ($departments as $depto) {
	$co_created = get_amount_created_courses($depto['cod']);
	$co_used = get_amount_used_courses($depto['cod']);
	
	$created_courses_array[] = $co_created;
	$used_courses_array[] = $co_used;
	
	$link = '<a href=' . $CFG->wwwroot . '/report/coursestats/main.php?category=' . $category . '&depname=' . $depto['acr'] . 
		'&dep=' . $depto['cod'] . '>' . $depto['name'] . '</a>';
	
	if ($co_created > 0) {
		$co_percent = number_format(($co_used / $co_created) * 100, 2) . '%';
		$percentage_used_courses_array[] = number_format(($co_used / $co_created) * 100, 2);
	} else {
		$co_percent = '-';
		$percentage_used_courses_array[] = 0;
	}
	$table->data[] = array($link, $co_created, $co_used, $co_percent);
}
 
if (class_exists('core\chart_bar')) {
	$chart_stacked = new core\chart_bar();
	$chart_percentage = new core\chart_bar();
	
	$created_courses_serie = new core\chart_series(get_string('lb_courses_created_amount', 'report_coursestats'), $created_courses_array);
	$used_courses_serie = new core\chart_series(get_string('lb_used_courses', 'report_coursestats'), $used_courses_array);
	$percentage_used_courses_serie = new core\chart_series(get_string('lb_percent_of_used_courses', 'report_coursestats'), $percentage_used_courses_array);
	
	$chart_stacked->add_series($created_courses_serie);
	$chart_stacked->add_series($used_courses_serie);
	$chart_stacked->set_labels($dept_acr_array);

	$chart_percentage->add_series($percentage_used_courses_serie);
	$chart_percentage->set_labels($dept_acr_array);
	
	echo $OUTPUT->render_chart($chart_stacked, false);
	echo $OUTPUT->render_chart($chart_percentage, false);
}

$url_csv = new moodle_url($CFG->wwwroot . '/report/coursestats/csvgen.php?category=' . $category);
$link_csv = html_writer::link($url_csv, get_string('link_csv', 'report_coursestats'));

echo '<p align="center">' . $link_csv . '</p>';

echo html_writer::table($table);

echo $OUTPUT->footer();

