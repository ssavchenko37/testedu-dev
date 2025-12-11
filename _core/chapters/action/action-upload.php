<?php
define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
define('DOT', '.');

include S_ROOT . '/__outsider/Excel/PHPExcel.php';

$inputFile = $target_file;

$extension = strtoupper(pathinfo($inputFile, PATHINFO_EXTENSION));

try {
	$inputFileType = PHPExcel_IOFactory::identify($inputFile);
	$objReader = PHPExcel_IOFactory::createReader($inputFileType);
	$objPHPExcel = $objReader->load($inputFile);
} catch (Exception $e) {
	die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
}

$sheet = $objPHPExcel->getSheet(0);
$highestRow = $sheet->getHighestRow();
$highestColumn = $sheet->getHighestColumn();
$valid = false;
if ($highestColumn == "J") {
	$valid = true;
}
if ($valid) {
	$exist = $DB->select('SELECT chapter_code AS ARRAY_KEY, subject_code, chapter_title FROM ?_3v_chapters');
	$xrray = array();
	for ($row = 1; $row <= $highestRow; $row++) {
		$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
		$chapter = $rowData[0];
		foreach ($chapter as $k=>$c) {
			$chapter[$k] = trim($c);
		}
		if ($row > 1 && !empty($chapter[4])) {
			$xrray[$row]['subject_code'] = $chapter[0];
			$xrray[$row]['chapter_code'] = $chapter[0] . DOT . $chapter[1]. DOT . $chapter[2]. DOT . $chapter[3];
			$xrray[$row]['chapter_title'] = $chapter[4];
			$xrray[$row]['chapter_semester'] = $chapter[1];
			$xrray[$row]['chapter_modul'] = $chapter[2];
			$xrray[$row]['chapter_num'] = $chapter[3];
			$xrray[$row]['chapter_qst'] = $chapter[5];
			$xrray[$row]['chapter_a'] = $chapter[6];
			$xrray[$row]['chapter_b'] = $chapter[7];
			$xrray[$row]['chapter_c'] = $chapter[8];
			$ins = $xrray[$row];
			if (is_array($exist[$ins['chapter_code']])) {
				$DB->query('UPDATE ?_3v_chapters SET ?a WHERE chapter_code=?', $ins, $ins['chapter_code']);
			} else {
				$DB->query('INSERT INTO ?_3v_chapters (?#) VALUES (?a)', array_keys($ins), array_values($ins));
			}
		}
	}

	header("Cache-control: private");
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: " . strtok($_SERVER['REQUEST_URI'], '?'));
	exit;
}