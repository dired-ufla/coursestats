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
		return ($DB->count_records(COURSE_TABLE_NAME, 
			array('visible'=>'1')) - 1);
	} else if ($category == ALL_CATEGORIES and $dep != ALL_DEP) {
		return ($DB->count_records_sql('SELECT COUNT(*) FROM {course} co WHERE ' . $DB->sql_like('co.shortname', ':name', false, false). ' AND co.visible = :visible', 
			array('name'=>'%'.$dep.'%', 'visible'=>'1')));
	} else if ($category != ALL_CATEGORIES and $dep == ALL_DEP) {
		return $DB->count_records_sql('SELECT COUNT(*) FROM {course} co WHERE co.visible = :visible AND co.category = :cat', 
			array('cat'=>$category, 'visible'=>'1'));
	} else {
		return $DB->count_records_sql('SELECT COUNT(*) FROM {course} co WHERE co.visible = :visible AND co.category = :cat AND ' . $DB->sql_like('co.shortname', ':name', false, false), 
			array('visible'=>'1', 'cat'=>$category, 'name'=>'%'.$dep.'%'));
	}	
}

function get_amount_used_courses($dep, $type) {
	global $category;
	global $DB;
	
	if ($category == ALL_CATEGORIES and $dep == ALL_DEP) {
		return $DB->count_records_sql('SELECT COUNT(*) FROM {report_coursestats} cs JOIN {course} co ON co.id = cs.courseid WHERE cs.curr_usage_type = :type AND co.visible = :visible', 
			array('type'=>$type, 'visible'=>'1'));
	} else if ($category == ALL_CATEGORIES and $dep != ALL_DEP) {
		return $DB->count_records_sql('SELECT COUNT(*) FROM {course} co JOIN {report_coursestats} cs ON co.id = cs.courseid  WHERE cs.curr_usage_type = :type AND co.visible = :visible AND ' . $DB->sql_like('co.shortname', ':name', false, false), 
			array('type'=>$type, 'visible'=>'1', 'name'=>'%'.$dep.'%'));
	} else if ($category != ALL_CATEGORIES and $dep == ALL_DEP) {
		return $DB->count_records_sql('SELECT COUNT(*) FROM {report_coursestats} cs JOIN {course} co ON co.id = cs.courseid WHERE cs.curr_usage_type = :type AND co.visible = :visible AND co.category = :cat', 
			array('type'=>$type, 'visible'=>'1', 'cat'=>$category));
	} else {
		return $DB->count_records_sql('SELECT COUNT(*) FROM {course} co JOIN {report_coursestats} cs ON co.id = cs.courseid  WHERE cs.curr_usage_type = :type AND co.visible = :visible AND  co.category = :cat AND ' . $DB->sql_like('co.shortname', ':name', false, false), 
			array('type'=>$type, 'visible'=>'1', 'cat'=>$category, 'name'=>'%'.$dep.'%'));
	}
}

$departments = array(
	array('cod'=>'gae', 'acr'=>'DAE', 'name'=>'DAE - Administração e Economia'),
	array('cod'=>'gag', 'acr'=>'DAG', 'name'=>'DAG - Agricultura'),
	array('cod'=>'gat', 'acr'=>'GAT', 'name'=>'DAT - Automática'),
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
	array('cod'=>'gfd', 'acr'=>'DEF', 'name'=>'DEF - Educação Física'),
	array('cod'=>'gne', 'acr'=>'DEG', 'name'=>'DEG - Engenharia'),
	array('cod'=>'gea', 'acr'=>'GEA', 'name'=>'DEA - Engenharia Agrícola'),
	array('cod'=>'gel', 'acr'=>'DEL', 'name'=>'DEL - Ensino da Linguagem'),
	array('cod'=>'get', 'acr'=>'DEB', 'name'=>'DEN - Entomologia'),
	array('cod'=>'ges', 'acr'=>'DES', 'name'=>'DES - Estatística'),
	array('cod'=>'gfi', 'acr'=>'DFI', 'name'=>'DFI - Física'),
	array('cod'=>'gfp', 'acr'=>'DFP', 'name'=>'DFP - Fitopatologia'),
	array('cod'=>'gga', 'acr'=>'GGA', 'name'=>'DGA - Gestão Agroindustrial'),	
	array('cod'=>'gnu', 'acr'=>'DNU', 'name'=>'DNU - Nutrição'),
	array('cod'=>'gmv', 'acr'=>'DMV', 'name'=>'DMV - Medicina Veterinária'),
	array('cod'=>'gqi', 'acr'=>'DQI', 'name'=>'DQI - Química'),
	array('cod'=>'grs', 'acr'=>'GRS', 'name'=>'DRS - Recursos Hídricos e Saneamento'),
	array('cod'=>'gzo', 'acr'=>'DZO', 'name'=>'DZO - Zootecnia'),
	array('cod'=>'prg', 'acr'=>'PRG', 'name'=>'PRG - Graduação')
); 

header('Content-Type: application/excel');
header('Content-Disposition: attachment; filename="sample.csv"');

$fp = fopen('php://output', 'w');

$head = array(get_string('lb_choose_dep', 'report_coursestats'), get_string('lb_courses_created_amount', 'report_coursestats'),
	get_string('lb_forum_usage', 'report_coursestats'), get_string('lb_repository_usage', 'report_coursestats'), get_string('lb_activity_usage', 'report_coursestats'));

fputcsv($fp, $head);

foreach ($departments as $depto) {
	$co_created = get_amount_created_courses($depto['cod']);
	$co_forum_usage = get_amount_used_courses($depto['cod'], FORUM_USAGE_TYPE);
	$co_repository_usage = get_amount_used_courses($depto['cod'], REPOSITORY_USAGE_TYPE);
	$co_activity_usage = get_amount_used_courses($depto['cod'], ACTIVITY_USAGE_TYPE);
	
	$depname = $depto['name'];

	$dep_data = array($depname, $co_created, $co_forum_usage, $co_repository_usage, $co_activity_usage);
	fputcsv($fp, $dep_data);

}

fclose($fp);
