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

function courseNameContains($courseName, $acronyms) {
	foreach($acronyms as $acr) {
		if (substr($courseName, 0, strlen($acr)) === strtoupper($acr)) {
			return true;
		}
	}
	return false;
}


function get_amount_created_courses($dep) {
	global $category;
	global $DB;
	$cods = explode(",", $dep);
	$courses = array();
	
	if ($category == ALL_CATEGORIES) {
		$courses = $DB->get_records(COURSE_TABLE_NAME, 
			array('visible'=>'1'));
	} else {
		$courses = $DB->get_records(COURSE_TABLE_NAME, array('visible'=>'1', 'category' => $category));
	} 

	$count = 0;
	foreach($courses as $course) {
		if (courseNameContains($course->shortname, $cods)) {
			$count++;
		}
	}

	return $count;
}

function get_amount_used_courses($dep) {
	global $category;
	global $DB;
	$cods = explode(",", $dep);
	$courses;
	
	if ($category == ALL_CATEGORIES) {
		$courses = $DB->get_records_sql('SELECT * FROM {report_coursestats} cs JOIN {course} co ON co.id = cs.courseid WHERE co.visible = :visible', 
			array('visible'=>'1'));
	} else {
		$courses = $DB->get_records_sql('SELECT * FROM {report_coursestats} cs JOIN {course} co ON co.id = cs.courseid WHERE co.visible = :visible AND co.category = :cat', 
			array('visible'=>'1', 'cat'=>$category));
	} 

	$count = 0;
	foreach($courses as $course) {
		if (courseNameContains($course->shortname, $cods)) {
			$count++;
		}
	}

	return $count;
}

$departments = array(
	array('cod'=>'gac,lac', 'acr'=>'DAC/ICET', 'name'=>'Computação Aplicada'),
	array('cod'=>'gae,eas,tae,eae,lae', 'acr'=>'DAE/FCSA', 'name'=>'Administração e Economia'),
	array('cod'=>'gag,fit', 'acr'=>'DAG/ESAL', 'name'=>'Agricultura'),
	array('cod'=>'gam,tam,eam', 'acr'=>'DAM/EENG', 'name'=>'Engenharia Ambiental'),
	array('cod'=>'gap,eap,lap', 'acr'=>'DAP/FCSA', 'name'=>'Administração Pública'),
	array('cod'=>'gat,tat,eat', 'acr'=>'DAT/EENG', 'name'=>'Automática'),
	array('cod'=>'gbi,bio,tbi,ebi,mbi', 'acr'=>'DBI/ICN', 'name'=>'Biologia'),
	array('cod'=>'gca,ali,tca,eca', 'acr'=>'DCA/ESAL', 'name'=>'Ciência dos Alimentos'),
	array('cod'=>'gcc,com,lcc', 'acr'=>'DCC/ICET', 'name'=>'Ciência da Computação'),
	array('cod'=>'gef,cif', 'acr'=>'DCF/ESAL', 'name'=>'Ciências Florestais'),
	array('cod'=>'gch', 'acr'=>'DCH/FAELCH', 'name'=>'Ciências Humanas'),
	array('cod'=>'gcs,cso', 'acr'=>'DCS/ESAL', 'name'=>'Ciência do Solo'),
	array('cod'=>'gea,lea', 'acr'=>'DEA/EENG', 'name'=>'Engenharia Agrícola'),
	array('cod'=>'gec', 'acr'=>'DEC/ICN', 'name'=>'Ecologia e Conservação'),
	array('cod'=>'gde,edu', 'acr'=>'DED/FAELCH', 'name'=>'Educação'),
	array('cod'=>'gfd,efd', 'acr'=>'DEF/FCS', 'name'=>'Educação Física'),
	array('cod'=>'gne,eng,meg,leg', 'acr'=>'DEG/EENG', 'name'=>'Engenharia'),
	array('cod'=>'gel', 'acr'=>'DEL/FAELCH', 'name'=>'Estudos da Linguagem'),
	array('cod'=>'get,ent', 'acr'=>'DEN/ESAL', 'name'=>'Entomologia'),
	array('cod'=>'ges', 'acr'=>'DES/ICET', 'name'=>'Estatística'),
	array('cod'=>'gex,cex', 'acr'=>'DEX/ICET', 'name'=>'Ciências Exatas'),
	array('cod'=>'gfi,lif', 'acr'=>'DFI/ICN', 'name'=>'Física'),
	array('cod'=>'gfm,tfm,efm,pfm,lmm', 'acr'=>'DFM/ICET', 'name'=>'Educação em Ciências Físicas e Matemáticas'),
	array('cod'=>'gfp,fip', 'acr'=>'DFP/ESAL', 'name'=>'Fitopatologia'),
	array('cod'=>'gga', 'acr'=>'DGA/ESAL', 'name'=>'Gestão Agroindustrial'),
	array('cod'=>'gdi,edi,lir', 'acr'=>'DIR/FCSA', 'name'=>'Direito'),
	array('cod'=>'gsa', 'acr'=>'DME/FCS', 'name'=>'Medicina'),	
	array('cod'=>'gmm', 'acr'=>'DMM/ICET', 'name'=>'Matemática e Matemática Aplicada'),
	array('cod'=>'gmv,vet', 'acr'=>'DMV/FZMV', 'name'=>'Medicina Veterinária'),
	array('cod'=>'gnu', 'acr'=>'DNU/FCS', 'name'=>'Nutrição'),
	array('cod'=>'gqi,qui', 'acr'=>'DQI/ICN', 'name'=>'Química'),
	array('cod'=>'grh,grs,trs,ers', 'acr'=>'DRH/EENG', 'name'=>'Recursos Hídricos'),
	array('cod'=>'gzo,zoo,tzo,ezo', 'acr'=>'DZO/FZMV', 'name'=>'Zootecnia'),
	array('cod'=>'gctt,prg', 'acr'=>'PROGRAD', 'name'=>'Graduação')
); 

header('Content-Type: application/excel');
header('Content-Disposition: attachment; filename="sample.csv"');

$fp = fopen('php://output', 'w');

$head = array(get_string('lb_choose_dep', 'report_coursestats'), get_string('lb_courses_created_amount', 'report_coursestats'),
	get_string('lb_used_courses', 'report_coursestats'));

fputcsv($fp, $head);

foreach ($departments as $depto) {
	$co_created = get_amount_created_courses($depto['cod']);
	$co_used = get_amount_used_courses($depto['cod']);
	
	$depname = $depto['acr'] . ' - ' . $depto['name'];

	$dep_data = array($depname, $co_created, $co_used);
	fputcsv($fp, $dep_data);

}

fclose($fp);
