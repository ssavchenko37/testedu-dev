<?php
class TS_cli
{
	public $data = array();

	private $db;
	private $lang;
	private $ts;
	private $adm_id;
	private $period_uin;
	private $stud_id;
	private $tutor_id;
	private $dept_id;
	private $subject_id;
	private $chapter_id;
	private $question_id;
	
	public function __construct()
	{
		global $DB, $lang;
		$this->db = $DB;
		$this->lang = $lang;
		$this->period_uin = $this->period()['uin'];
		if (isset($_COOKIE['ts_sys'])) {
			$ts_sys = cook2auth($_COOKIE['ts_sys']);
			if ($ts_sys->id > 0) {
				$this->ts['id'] = $ts_sys->id;
				$this->ts['umod'] = $ts_sys->umod;
				
				if ($ts_sys->umod == "a") {
					$this->adm_id = $ts_sys->id;
					$this->ts['usr'] = $this->db->selectRow('SELECT id, lvl, description, grp, payment_types FROM ?_adm WHERE id=?', $ts_sys->id);
					$this->ts['usr']['iid'] = $this->ts['umod'].$this->ts['usr']['id'];
				}
				if ($ts_sys->umod == "t") {
					$this->tutor_id = $ts_sys->id;
					$this->ts['usr'] = $this->db->selectRow('SELECT * FROM ?_tutor WHERE tutor_id=?', $ts_sys->id);
					unset($this->ts['usr']['tutor_uin']);
					unset($this->ts['usr']['tutor_pass']);
					$this->ts['usr']['iid'] = $this->ts['umod'].$this->ts['usr']['tutor_id'];
				}
				if ($ts_sys->umod == "s") {
					$this->stud_id = $ts_sys->id;
					$this->ts['usr'] = $this->db->selectRow('SELECT * FROM ?_students WHERE stud_id=?', $ts_sys->id);
					$this->ts['usr']['iid'] = $this->ts['umod'].$this->ts['usr']['stud_id'];
				}
			}
		}
	}

	public function tsdata()
	{
		return $this->ts;
	}
	public function request_encode($key, $val)
	{
		$str = base64_encode($this->ts['usr']['iid'] . $key . "=" . $val);
		$str = substr_count($str, '=').str_replace("=","",$str);
		return $str;
	}
	public function request_decode($key, $str)
	{
		$equals_arr = array("0"=>"", "1"=>"=", "2"=>"==", "3"=>"===");
		$equals = substr($str, 0, 1);
		$base = substr($str, 1);
		$base = str_replace($this->ts['usr']['iid'],"", base64_decode($base . $equals_arr[$equals]));
		$arr = explode("=", $base);
		
		return ($arr[0] == $key) ? $arr[1] : 0;
	}

	public function period($post_sp=false): array
	{
		$periods = $tmperiod = $this->db->selectCol('SELECT var_uin FROM ?_3v_vars WHERE var_type=? ORDER BY var_uin', 'sheets');
		$sheet_period = ($post_sp) ? $post_sp: end($periods);
		if (isset($_COOKIE['ts_prd']) && !$post_sp) {
			$sheet_period = cook2code($_COOKIE['ts_prd'])->period;
		}
		rsort($tmperiod);
		$flipped = array_flip($tmperiod);
		$semester_offset = 11 + $flipped[$sheet_period];
		return array("uin" => $sheet_period, "offset"=>$semester_offset, "list"=>$periods);
	}

	public function currentExamDate($prd): array
	{
		$parr = explode("-", $prd);
		$exam_se = array();
		$exam_dates = array(
			1 => array("SSSS-11-01",'EEEE-04-01'),
			2 => array("SSSS-05-01",'EEEE-07-01'),
		);
		if ($parr[2] == 1) {
			$exam_se[0] = str_replace("SSSS",$parr[0],$exam_dates[1][0]);
			$exam_se[1] = str_replace("EEEE",$parr[1],$exam_dates[1][1]);
		}
		if ($parr[2] == 2) {
			$exam_se[0] = str_replace("SSSS",$parr[1],$exam_dates[2][0]);
			$exam_se[1] = str_replace("EEEE",$parr[1],$exam_dates[2][1]);
		}
		return $exam_se;
	}

	public function tutor($tutor_id=false): array
	{
		$tutor = $this->db->selectRow('SELECT *'
			. ' FROM ?_tutor'
			. ' WHERE tutor_id=?'
			, ( $tutor_id ) ? $tutor_id : $this->tutor_id
		);
		$departments = $this->db->select('SELECT TD.t_d_id, TD.who_set, TD.who_update, TD.entered, TD.modified'
			. ', D.dept_id, D.dept_title, R.role_id, R.role_title'
			. ' FROM ?_tutor_dept TD'
			. ' INNER JOIN ?_departments D ON TD.dept_id=D.dept_id'
			. ' INNER JOIN ?_roles R ON TD.role_id=R.role_id'
			. ' WHERE tutor_id=?'
			, $tutor['tutor_id']
		);
		return array(
			"tutor" => $tutor,
			"departments" => $departments
		);
	}
	public function tutorsName(): array
	{
		return ($this->lang == "ru") 
			? $this->db->selectCol('SELECT tutor_id AS ARRAY_KEY, CONCAT(tutor_id, ") ", tutor_fullru) FROM ?_tutor ORDER BY tutor_fullru')
			: $this->db->selectCol('SELECT tutor_id AS ARRAY_KEY, CONCAT(tutor_id, ") ", tutor_fullname) FROM ?_tutor ORDER BY tutor_fullname')
		;
	}
	

	public function tutorDept($tutor_id=false, $t_d_id=false)
	{
		return $this->db->select('SELECT TD.t_d_id, TD.tutor_id, TD.who_set, TD.who_update, TD.entered, TD.modified'
			. ', D.dept_id, D.dept_code, D.dept_title, D.dept_ru, R.role_id, R.role_title'
			. ', CONCAT(D.dept_code, " / ", D.dept_title, " / ") AS full_dept_en'
			. ', CONCAT(D.dept_code, " / ", D.dept_ru, " / ") AS full_dept_ru'
			. ' FROM ?_tutor_dept TD'
			. ' INNER JOIN ?_departments D ON TD.dept_id=D.dept_id'
			. ' INNER JOIN ?_roles R ON TD.role_id=R.role_id'
			. ' WHERE 1=1 {AND TD.tutor_id=?} {AND t_d_id=?}'
			, ($tutor_id > 0) ? $tutor_id : DBSIMPLE_SKIP
			, ($t_d_id > 0) ? $t_d_id : DBSIMPLE_SKIP
		);
	}
	public function tutorSubj($tutor_id=false, $t_s_id=false)
	{
		return $this->db->select('SELECT TS.t_s_id, TS.tutor_id, TS.stype'
			. ', TS.entered AS ts_entered, TS.who_set'
			. ', S.*'
			. ', D.dept_title, D.dept_ru'
			. ', CONCAT(PLAN.plan_title, " / ", SEM.semester_title, " / ", S.subject_title) AS full_subject_en'
			. ', CONCAT(PLAN.plan_ru, " / ", SEM.semester_ru, " / ", S.subject_ru) AS full_subject_ru'
			. ', CONCAT(PLAN.plan_title, " / ", SEM.semester_title) AS plan_sem_en'
			. ', CONCAT(PLAN.plan_ru, " / ", SEM.semester_ru) AS plan_sem_ru'
			. ' FROM ?_tutor_subjects TS'
			. ' INNER JOIN ?_3v_subjects S ON TS.subject_id=S.subject_id'
			. ' INNER JOIN ?_departments D ON S.dept_code=D.dept_code'
			. ' INNER JOIN ?_3v_plans PLAN ON S.plan_id=PLAN.plan_id'
			. ' INNER JOIN ?_3v_semesters SEM ON S.semester_id=SEM.semester_id'
			. ' WHERE 1=1 {AND TS.period=?}'
			. ' {AND TS.tutor_id=?} {AND TS.t_s_id=?}'
			. ' ORDER BY S.semester_id, S.subject_uin, TS.grm_id, TS.stype'
			, ( $this->period_uin ) ? $this->period_uin: DBSIMPLE_SKIP
			, ( $tutor_id ) ? $tutor_id : DBSIMPLE_SKIP
			, ( $t_s_id ) ? $t_s_id : DBSIMPLE_SKIP
		);
	}

	public function groupment($dept_id): array
	{
		$groupment = [];
		if ($dept_id > 0) {
			$groupment = $this->db->selectRow('SELECT *'
				. ' FROM ?_groupments'
				. ' WHERE dept_id=?'
				, $dept_id
			);
		}
		return $groupment;
	}

	public function group($grup_id): array
	{
		$group = [];
		if ($grup_id > 0) {
			$group = $this->db->selectRow('SELECT *'
				. ' FROM ?_groups'
				. ' WHERE grup_id=?'
				, $grup_id
			);
		}
		return $group;
	}

	public function student($stud_id=false): array
	{
		return $this->db->selectRow('SELECT S.*, G.grup_uin, G.grup_title, D.dept_uin, D.dept_title, D.semester_id'
			. ' FROM ?_students S'
			. ' INNER JOIN ?_groups G ON S.grup_id=G.grup_id'
			. ' INNER JOIN ?_groupments D ON S.dept_id=D.dept_id'
			. ' WHERE stud_id=?'
			, ( $stud_id ) ? $stud_id : $this->stud_id
		);
	}

	public function sheets($opt)
	{
		return $this->db->select('SELECT SH.*'
			. ', SBJ.subject_title, SBJ.subject_ru, G.grup_title, S.semester_title'
			. ' FROM ?_3v_sheets SH'
			. ' INNER JOIN ?_3v_subjects SBJ ON SH.subject_id=SBJ.subject_id'
			. ' INNER JOIN ?_groups G ON SH.grup_id=G.grup_id'
			. ' INNER JOIN ?_3v_semesters S ON SH.semester_id=S.semester_id'
			. ' WHERE SBJ.is_sys=?'
			. ' {AND SH.sheet_period=?}'
			. ' {AND SH.sheet_period LIKE(?)}'
			. ' {AND SH.grm_id=?}'
			. ' {AND SH.grup_id=?}'
			. ' {AND SH.tutor_id=?}'
			, 0
			, (!$opt['bascket']) ? $opt['sheet_period']: DBSIMPLE_SKIP, ($opt['bascket']) ? $opt['sheet_period'] . "%": DBSIMPLE_SKIP
			,($opt['grm_id'] > 0) ? $opt['grm_id'] : DBSIMPLE_SKIP
			,($opt['grup_id'] > 0) ? $opt['grup_id'] : DBSIMPLE_SKIP
			,($opt['tutor_id'] > 0) ? $opt['tutor_id'] : DBSIMPLE_SKIP
		);
	}

	public function ibooks($opt)
	{
		$opt['grup_ids'] = (is_array($opt['grup_ids'])) ? $opt['grup_ids']: array();
		return $this->db->select('SELECT IB.*'
			. ', T.tutor_fullru, T.tutor_name, T.tutor_lastname, T.tutor_patronymic'
			. ', GR.grup_title'
			. ', S.subject_ru, S.subject_title, SM.semester_title'
			. ' FROM ?_ibook IB'
			. ' INNER JOIN ?_tutor T ON IB.tutor_id=T.tutor_id'
			. ' INNER JOIN ?_groups GR ON IB.grup_id=GR.grup_id'
			. ' INNER JOIN ?_3v_subjects S ON IB.subject_id=S.subject_id'
			. ' INNER JOIN ?_3v_semesters SM ON IB.semester_id=SM.semester_id'
			. ' WHERE sheet_period=?'
			. '{AND IB.tutor_id=?}'
			. '{AND IB.grm_id=?}'
			. '{AND IB.subject_id=?}'
			. '{AND IB.grup_id IN(?a)}'
			. ' ORDER BY IB.modified DESC'
			, $opt['sheet_period']
			, ( $opt['tutor_id'] > 0 ) ? $opt['tutor_id'] : DBSIMPLE_SKIP
			, ( $opt['grm_id'] > 0 ) ? $opt['grm_id'] : DBSIMPLE_SKIP
			, ( $opt['subject_id'] > 0 ) ? $opt['subject_id'] : DBSIMPLE_SKIP
			, ( count($opt['grup_ids']) > 0 ) ? $opt['grup_ids'] : DBSIMPLE_SKIP
		);
	}

	public function modules($opt)
	{
		return $this->db->select('SELECT *'
			. ', DATE_FORMAT(module_date, \'%d.%m.%Y\') as sDate'
			. ', DATE_FORMAT(module_date, \'%H:%i:%s\') as sTime'
			. ' FROM ?_module'
			. ' WHERE module_status IN(?a)'
			. ' {AND tutor_id=?}'
			. ' {AND module_id IN(?a)}'
			. ' {AND module_date BETWEEN STR_TO_DATE(?, \'%Y-%m-%d %H:%i:%s\') AND STR_TO_DATE(?, \'%Y-%m-%d %H:%i:%s\')} '
			. ' ORDER BY module_date DESC'
			. ' LIMIT ?d, ?d'
			, ( isset($opt['filter_status']) ) ? array($opt['filter_status']) : array(0,1,2)
			, $opt['tutor_id']
			, ( isset($opt['module_ids']) ) ? $opt['module_ids'] : DBSIMPLE_SKIP
			, ($opt['filter_daterange']) ? $opt['exam_se'][0] . " 00:00:00" : DBSIMPLE_SKIP, $opt['exam_se'][1] . " 23:59:59"
			, $opt['start'], $opt['limit']
	  );
	}
	public function module($module_id, $results_flag)
	{
		$module = $this->db->selectRow('SELECT * FROM ?_3v_modules WHERE module_id=?', $module_id);
		$results = [];
		if ($module['module_id'] > 0 && $results_flag) {
			$results = $this->db->select('SELECT * FROM ?_3v_module_results WHERE module_id=?', $module['module_id']);
		}
		return [
			'module' => $module,
			'results' => $results,
		];
	}

	public function exams($opt)
	{
		return $this->db->select('SELECT *'
			. ', DATE_FORMAT(exam_date, \'%d.%m.%Y\') as sDate'
			. ', DATE_FORMAT(exam_date, \'%H:%i:%s\') as sTime'
			. ' FROM ?_exam '
			. ' WHERE exam_status IN(?a)'
			. ' {AND exam_id IN(?a)}'
			. ' {AND subject_id=?}'
			. ' {AND tutor_id=?}'
			. ' AND exam_date BETWEEN STR_TO_DATE(?, \'%Y-%m-%d %H:%i:%s\') AND STR_TO_DATE(?, \'%Y-%m-%d %H:%i:%s\')'
			. ' ORDER BY exam_date DESC'
			. ' LIMIT ?d, ?d'
			, ( isset($opt['filter_status']) ) ? array($opt['filter_status']) : array(0,1,2)
			, ( isset($opt['exam_ids']) ) ? $opt['exam_ids'] : DBSIMPLE_SKIP
			, ( isset($opt['filter_type']) ) ? $opt['filter_type']: DBSIMPLE_SKIP
			, ( isset($opt['tutor_id']) ) ? $opt['tutor_id']: DBSIMPLE_SKIP
			, $opt['exam_se'][0] . " 00:00:00", $opt['exam_se'][1] . " 23:59:59"
			, $opt['start'], $opt['limit']
		);
	}

	public function subject($subject_id=false): array
	{
		return $this->db->selectRow('SELECT * FROM ?_3v_subjects'
			. ' WHERE subject_id=?'
			, ( $subject_id ) ? $subject_id : $this->subject_id
		);
	}
	public function chapter($chapter_id=false): array
	{
		return $this->db->selectRow('SELECT * FROM ?_3v_chapters'
			. ' WHERE chapter_id=?'
			, ( $chapter_id ) ? $chapter_id : $this->chapter_id
		);
	}
	public function question($question_id=false): array
	{
		return $this->db->selectRow('SELECT * FROM ?_3v_questions'
			. ' WHERE question_id=?'
			, ( $question_id ) ? $question_id : $this->question_id
		);
	}
}