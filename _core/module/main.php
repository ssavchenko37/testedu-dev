<?php
$mdcode = $TS->request_decode('mdcode',$tsreq);

$module = $TS->module($mdcode, false)['module'];
$module['date_formated'] = date("d.m.Y H:i", strtotime($module['module_date']));

$results = $DB->select('SELECT R.*, S.*, G.grup_title'
    . ', DATE_FORMAT(R.res_entered, \'%d.%m.%Y\') as sDate'
    . ', DATE_FORMAT(R.res_entered, \'%H:%i:%s\') as sTime'
    . ' FROM ?_3v_module_results R'
    . ' INNER JOIN ?_students S ON R.stud_id=S.stud_id'
    . ' INNER JOIN ?_groups G ON S.grup_id=G.grup_id'
    . ' WHERE R.module_id=?'
    . ' ORDER BY G.grup_ord'
    , $mdcode
);

$tutor = $DB->selectRow('SELECT * FROM ?_tutor WHERE tutor_id=?', $module['tutor_id']);
$module_groups = explode('/', substr($module['module_groups'], 1, -1));
$plan_id = $DB->selectCell('SELECT GRM.plan_id FROM ?_groupments GRM INNER JOIN ?_groups GRP ON GRM.dept_id=GRP.dept_id WHERE grup_id=?',$module_groups[0]);
$subject = $DB->selectRow('SELECT * FROM ?_3v_subjects'
    . ' WHERE plan_id=? AND semester_id=? AND subject_code=?'
    , $plan_id, $module['sem'], $module['sbj']
);
