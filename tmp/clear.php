<?php
require_once '../kernel.php';

$tmp = $DB->selectCol('SELECT sheet_id FROM ?_3v_sheets WHERE sheet_period=? LIMIT 500', '2025-2026-1');

$DB->query('DELETE FROM ?_3v_practice WHERE sheet_id IN(?a)', $tmp);
$DB->query('DELETE FROM ?_3v_practice_items WHERE sheet_id IN(?a)', $tmp);
