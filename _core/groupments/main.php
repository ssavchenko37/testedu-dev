<?php
if (($_POST['mode'] ?? '')) {
    include "action/action.php";
}

$groupments = $DB->select('SELECT * FROM ?_groupments ORDER BY semester_id');
$dept_groups = $DB->select('SELECT dept_id AS ARRAY_KEY, COUNT(grup_id) AS qty FROM ?_groups GROUP BY dept_id');
$plans = $DB->selectCol('SELECT plan_id AS ARRAY_KEY, plan_title FROM ?_3v_plans');
