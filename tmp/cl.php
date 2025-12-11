<?php
require_once '../kernel.php';

$tmp = $DB->selectCol('SELECT ibook_id FROM ?_ibook WHERE sheet_period=? OR sheet_period=? ORDER BY ibook_id DESC LIMIT 500', '2025-2026-1arch', '2025-2026-1');

$DB->query('DELETE FROM ?_ibook_items WHERE ibook_id IN(?a)', $tmp);
$DB->query('DELETE FROM ?_ibook_meta WHERE ibook_id IN(?a)', $tmp);
$DB->query('DELETE FROM ?_ibook_temps WHERE ibook_id IN(?a)', $tmp);
$DB->query('DELETE FROM ?_ibook WHERE ibook_id IN(?a)', $tmp);