<?php
if (($_POST['mode'] ?? '')) {
    include "action/action.php";
}

$departments = $DB->select('SELECT * FROM ?_departments ORDER BY dept_code + 1');
$dept_tutors = $DB->select('SELECT dept_id AS ARRAY_KEY, COUNT(t_d_id) AS qty FROM ?_tutor_dept GROUP BY dept_id');
$dept_subjects = $DB->select('SELECT dept_code AS ARRAY_KEY, COUNT(subject_id) AS qty FROM ?_3v_subjects GROUP BY dept_code');
