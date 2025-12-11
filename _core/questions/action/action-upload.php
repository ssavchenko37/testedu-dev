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

// $valid = false;
// p($highestColumn);
// if ($highestColumn == "T") {
//     $valid = true;
// }
$valid = true;
if ($valid) {
    $exist = $DB->select('SELECT question_code AS ARRAY_KEY, question_code, question_title FROM ?_3v_questions');
    $trans = array("А"=>"A","В"=>"B","С"=>"C");
    $xrray = array();
    for ($row = 1; $row <= $highestRow; $row++) {
        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
        $question = $rowData[0];
        foreach ($question as $k=>$q) {
            $question[$k] = trim($q);
        }
        if ($row > 1 && !empty($question[1])) {
            $xrray = array();
            if (!empty($trans[$question[6]])) {
                $question[6] = $trans[$question[6]];
            }
            $xrray[$row]['subject_code'] = $question[1];
            $xrray[$row]['chapter_code'] = $question[1] . DOT . $question[2]. DOT . $question[3]. DOT . $question[4];
            $xrray[$row]['question_code'] = $question[1] . DOT . $question[2]. DOT . $question[3]. DOT . $question[4]. DOT . $question[5]. DOT . $question[6];
            $xrray[$row]['question_index'] = $question[5];
            $xrray[$row]['question_type'] = $question[6];
            $xrray[$row]['question_title'] = $question[8];
            $xrray[$row]['question_ru'] = $question[7];

            $ifmedia = S_ROOT . DIRECTORY_SEPARATOR . S_STORAGE . DIRECTORY_SEPARATOR . 'question' . DIRECTORY_SEPARATOR . $xrray[$row]['question_code'];
            foreach (array("png","jpg","jpeg") as $ext) {
                if (is_file($ifmedia . "." . $ext)) {
                    $xrray[$row]['question_media'] = $xrray[$row]['question_code'] . "." . $ext;
                }
                if (is_file($ifmedia . "." . strtoupper($ext))) {
                    $xrray[$row]['question_media'] = $xrray[$row]['question_code'] . "." . strtoupper($ext);
                }
            }
            $ins = $xrray[$row];
            if (!is_array($exist[$ins['question_code']])) {
                $DB->query('INSERT INTO ?_3v_questions (?#) VALUES (?a)', array_keys($ins), array_values($ins));
                foreach (array(10,11,12,13,14) as $ans) {
                    $insa = array();
                    $ansen = $ans + 5;
                    if (!empty($question[$ans]) || !empty($question[$ansen])) {
                        $insa['subject_code'] = $ins['subject_code'];
                        $insa['chapter_code'] = $ins['chapter_code'];
                        $insa['question_code'] = $ins['question_code'];
                        $insa['answer_title'] = $question[$ansen];
                        $insa['answer_ru'] = $question[$ans];
                        if ($ans == 10) {
                            $insa['correct'] = 1;
                        }
                        $DB->query('INSERT INTO ?_3v_answers (?#) VALUES (?a)', array_keys($insa), array_values($insa));
                    }
                }
            }
        }
    }

    header("Cache-control: private");
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: " . strtok($_SERVER['REQUEST_URI'], '?'));
    exit;
}
