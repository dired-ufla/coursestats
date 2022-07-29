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

function get_amount_created_courses($course) {
	global $category;
	global $DB;
	
	if ($category == ALL_CATEGORIES and $course == ALL_COURSES) {
		return ($DB->count_records(COURSE_TABLE_NAME, 
			array('visible'=>'1')) - 1);
	} else if ($category == ALL_CATEGORIES and $course != ALL_COURSES) {
		return ($DB->count_records_sql('SELECT COUNT(*) FROM {course} co WHERE ' . $DB->sql_like('co.shortname', ':name', false, false). ' AND co.visible = :visible', 
			array('name'=>'%'.$course.'%', 'visible'=>'1')));
	} else if ($category != ALL_CATEGORIES and $course == ALL_COURSES) {
		return $DB->count_records_sql('SELECT COUNT(*) FROM {course} co WHERE co.visible = :visible AND co.category = :cat', 
			array('cat'=>$category, 'visible'=>'1'));
	} else {
		return $DB->count_records_sql('SELECT COUNT(*) FROM {course} co WHERE co.visible = :visible AND co.category = :cat AND ' . $DB->sql_like('co.shortname', ':name', false, false), 
			array('visible'=>'1', 'cat'=>$category, 'name'=>'%'.$course.'%'));
	}	
}

function get_amount_used_courses($course) {
	global $category;
	global $DB;
	
	if ($category == ALL_CATEGORIES and $course == ALL_COURSES) {
		return $DB->count_records_sql('SELECT COUNT(*) FROM {report_coursestats} cs JOIN {course} co ON co.id = cs.courseid WHERE co.visible = :visible', 
			array('visible'=>'1'));
	} else if ($category == ALL_CATEGORIES and $course != ALL_COURSES) {
		return $DB->count_records_sql('SELECT COUNT(*) FROM {course} co JOIN {report_coursestats} cs ON co.id = cs.courseid  WHERE co.visible = :visible AND ' . $DB->sql_like('co.shortname', ':name', false, false), 
			array('visible'=>'1', 'name'=>'%'.$course.'%'));
	} else if ($category != ALL_CATEGORIES and $course == ALL_COURSES) {
		return $DB->count_records_sql('SELECT COUNT(*) FROM {report_coursestats} cs JOIN {course} co ON co.id = cs.courseid WHERE co.visible = :visible AND co.category = :cat', 
			array('visible'=>'1', 'cat'=>$category));
	} else {
		return $DB->count_records_sql('SELECT COUNT(*) FROM {course} co JOIN {report_coursestats} cs ON co.id = cs.courseid  WHERE co.visible = :visible AND  co.category = :cat AND ' . $DB->sql_like('co.shortname', ':name', false, false), 
			array('visible'=>'1', 'cat'=>$category, 'name'=>'%'.$course.'%'));
	}
}

$courses = array(
	array('cod'=>'G001', 'acr'=>'G001', 'name'=>'Agronomia'),
	array('cod'=>'G002', 'acr'=>'G002', 'name'=>'Zootecnia'),
	array('cod'=>'G003', 'acr'=>'G003', 'name'=>'Engenharia Agrícola'),
	array('cod'=>'G005', 'acr'=>'G005', 'name'=>'Engenharia Florestal'),
	array('cod'=>'G007', 'acr'=>'G007', 'name'=>'Medicina Veterinária'),
	array('cod'=>'G009', 'acr'=>'G009', 'name'=>'Administração'),
	array('cod'=>'G010', 'acr'=>'G010', 'name'=>'Ciência da Computação'),
	array('cod'=>'G011', 'acr'=>'G011', 'name'=>'Engenharia de Alimentos'),
	array('cod'=>'G012', 'acr'=>'G012', 'name'=>'Ciências Biológicas'),
	array('cod'=>'G013', 'acr'=>'G013', 'name'=>'Química (Licenciatura)'),
	array('cod'=>'G014', 'acr'=>'G014', 'name'=>'Sistemas de Informação'),
	array('cod'=>'G015', 'acr'=>'G015', 'name'=>'Matemática'),
	array('cod'=>'G018', 'acr'=>'G018', 'name'=>'Física'),
	array('cod'=>'G019', 'acr'=>'G019', 'name'=>'Engenharia Ambiental e Sanitária'),
	array('cod'=>'G020', 'acr'=>'G020', 'name'=>'Ciências Biológicas'),
	array('cod'=>'G021', 'acr'=>'G021', 'name'=>'Química (Bacharelado)'),
	array('cod'=>'G022', 'acr'=>'G022', 'name'=>'Engenharia de Controle e Automação'),
	array('cod'=>'G023', 'acr'=>'G023', 'name'=>'Nutrição'),
	array('cod'=>'G024', 'acr'=>'G024', 'name'=>'Filosofia'),
	array('cod'=>'G025', 'acr'=>'G025', 'name'=>'Letras'),
	array('cod'=>'G026', 'acr'=>'G026', 'name'=>'Administração Pública'),
	array('cod'=>'G027', 'acr'=>'G027', 'name'=>'Direito'),
	array('cod'=>'G028', 'acr'=>'G028', 'name'=>'Educação Física (Licenciatura)'),
	array('cod'=>'G029', 'acr'=>'G029', 'name'=>'Educação Física (Bacharelado)'),
	array('cod'=>'G030', 'acr'=>'G030', 'name'=>'ABI Engenharia'),
	array('cod'=>'G031', 'acr'=>'G031', 'name'=>'Engenharia Civil'),
	array('cod'=>'G032', 'acr'=>'G032', 'name'=>'Engenharia Mecânica'),
	array('cod'=>'G033', 'acr'=>'G033', 'name'=>'Engenharia Química'),
	array('cod'=>'G034', 'acr'=>'G034', 'name'=>'Engenharia de Materiais'),
	array('cod'=>'G035', 'acr'=>'G035', 'name'=>'Medicina'),
	array('cod'=>'G036', 'acr'=>'G036', 'name'=>'Pedagogia'),
	array('cod'=>'PAD', 'acr'=>'PAD', 'name'=>'PPG em Administração'),
	array('cod'=>'PAP', 'acr'=>'PAP', 'name'=>'PPG em Administração Pública'),
	array('cod'=>'PFP', 'acr'=>'PFP', 'name'=>'PPG em Agronomia/Fitopatologia'),
	array('cod'=>'PAG', 'acr'=>'PAG', 'name'=>'PPG em Agronomia/Fitotecnia'),
	array('cod'=>'PQI', 'acr'=>'PQI', 'name'=>'PPG em Agroquímica'),
	array('cod'=>'PBI', 'acr'=>'PBI', 'name'=>'PPG em Biotecnologia Vegetal'),
	array('cod'=>'PBA', 'acr'=>'PBA', 'name'=>'PPG em Botânica Aplicada'),
	array('cod'=>'PCC', 'acr'=>'PCC', 'name'=>'PPG em Ciência da Computação'),
	array('cod'=>'PCS', 'acr'=>'PCS', 'name'=>'PPG em Ciência do Solo'),
	array('cod'=>'PTM', 'acr'=>'PTM', 'name'=>'PPG em Ciência e Tecnologia da Madeira'),
	array('cod'=>'PGTPA', 'acr'=>'PGTPA', 'name'=>'PPG em Cieĉnia e Tecnologia da Produção Animal'),
	array('cod'=>'PSA', 'acr'=>'PSA', 'name'=>'PPG em Ciência da Saúde'),
	array('cod'=>'PMV', 'acr'=>'PMV', 'name'=>'PPG em Ciências Veterinárias'),
	array('cod'=>'PDS', 'acr'=>'PDS', 'name'=>'PPG em Desenvolvimento Sustentável e Extensão'),
	array('cod'=>'PEC', 'acr'=>'PEC', 'name'=>'PPG em Ecologia Aplicada'),
	array('cod'=>'PED', 'acr'=>'PED', 'name'=>'PPG em Educação'),
	array('cod'=>'PGECA', 'acr'=>'PGECA', 'name'=>'PPG em Educação Científica e Ambiental'),
	array('cod'=>'PEG', 'acr'=>'PEG', 'name'=>'PPG em Engenharia Agrícola'),
	array('cod'=>'PEA', 'acr'=>'PEA', 'name'=>'PPG em Engenharia Ambiental'),
	array('cod'=>'PGALI', 'acr'=>'PGALI', 'name'=>'PPG em Engenharia de Alimentos'),
	array('cod'=>'PEB', 'acr'=>'PEB', 'name'=>'PPG em Biomateriais'),
	array('cod'=>'PSI', 'acr'=>'PSI', 'name'=>'PPG em Engenharia de Sistemas e Automação'),
	array('cod'=>'PCF', 'acr'=>'PCF', 'name'=>'PPG em Engenharia Florestal'),
	array('cod'=>'PECEM', 'acr'=>'PECEM', 'name'=>'PPG em Ensino de Ciências e Educação Matemática'),
	array('cod'=>'PEN', 'acr'=>'PEN', 'name'=>'PPG em Entomologia'),
	array('cod'=>'PEX', 'acr'=>'PEX', 'name'=>'PPG em Estatística e Experimentação Agropecuária'),
	array('cod'=>'PFIL', 'acr'=>'PFIL', 'name'=>'PPG em Filosofia'),
	array('cod'=>'PPGF', 'acr'=>'PPGF', 'name'=>'PPG em Física'),
	array('cod'=>'PFV', 'acr'=>'PFV', 'name'=>'PPG em Fisiologia Vegetal'),
	array('cod'=>'PGM', 'acr'=>'PGM', 'name'=>'PPG em Genética e Melhoramento de Plantas'),
	array('cod'=>'PGMP', 'acr'=>'PGMP', 'name'=>'PPG em Genética e Melhoramento de Plantas - Profissional'),
	array('cod'=>'PPGL', 'acr'=>'PPGL', 'name'=>'PPG em Letras'),
	array('cod'=>'PMA', 'acr'=>'PMA', 'name'=>'PPG em Matemática - Profissional'),
	array('cod'=>'PMB', 'acr'=>'PMB', 'name'=>'PPG em Microbiologia Agrícola'),
	array('cod'=>'PPMQ', 'acr'=>'PPMQ', 'name'=>'PPG em Multicêntrico em Química de Minas Gerais'),
	array('cod'=>'PNS', 'acr'=>'PNS', 'name'=>'PPG em Nutrição e Saúde'),
	array('cod'=>'PAC', 'acr'=>'PAC', 'name'=>'PPG em Plantas Medicinais, Aromáticas e Condimentares'),
	array('cod'=>'PRH', 'acr'=>'PRH', 'name'=>'PPG em Recursos Hídricos'),
	array('cod'=>'PTA', 'acr'=>'PTA', 'name'=>'PPG em Tecnologias e Inovações Ambientais'),
	array('cod'=>'PZO', 'acr'=>'PZO', 'name'=>'PPG em Zootecnia'),
	array('cod'=>'PCA', 'acr'=>'PCA', 'name'=>'PPG em Ciência dos Alimentos'),
	array('cod'=>'PRPG', 'acr'=>'PRPG', 'name'=>'Pró-Reitoria de Pós-Graduação'),
	array('cod'=>'PRP', 'acr'=>'PRP', 'name'=>'Pró-Reitoria de Pós-Graduação')
); 


header('Content-Type: application/excel');
header('Content-Disposition: attachment; filename="sample.csv"');

$fp = fopen('php://output', 'w');

$head = array(get_string('lb_choose_course', 'report_coursestats'), get_string('lb_courses_created_amount', 'report_coursestats'),
	get_string('lb_used_courses', 'report_coursestats'));

fputcsv($fp, $head);

foreach ($courses as $course) {
	$co_created = get_amount_created_courses($course['cod']);

	if ($co_created == 0) {
		continue;
	}

	$co_used = get_amount_used_courses($course['cod']);
	
	$coursename = $course['cod'] . ' - ' . $course['name'];
	
	$course_data = array($coursename, $co_created, $co_used);
	fputcsv($fp, $course_data);

}

fclose($fp);