<?php
/************************************************************************** ctrl cookies data
 * @param array $string
 * @return boolean
 */
function setPeriod($prd)
{
	setcookie ("ts_prd", code2cook(['period' => $prd]), 0, "/");
	return true;
}
/************************************************************************** ctrl cookies data
 * @param array $arr
 * @return string
 */
function code2cook($arr)
{
	$str = base64_encode(json_encode($arr, JSON_UNESCAPED_UNICODE));
	$bp = substr($str, 0, 8);
	$ep = str_replace("=","_",substr($str, 8));
	return $ep . $bp;
}
/************************************************************************** ctrl cookies data
 * @param string $str
 * @return object
 */
function cook2code($str)
{
	$bp = substr($str, -8);
	$ep = str_replace($bp, "", $str);
	$ep = str_replace("_", "=", $ep);
	return json_decode(base64_decode($bp . $ep));
}


function getPath()
{
	$ReqUri = getenv("REQUEST_URI");
	$uri_arr = explode('?', $ReqUri);
	$uri = $uri_arr[0];
	$last_symbol = substr($uri, -1);
	if ($last_symbol == "/") $uri = substr($uri, 0,-1);
	$path_arr = explode('/', $uri);
	$pre_lang = ( in_array($uri_arr[1], array("ru","en","kg")) ) ? $uri_arr[1] : "" ;
	$lang = getLang( $pre_lang );
	$lang = ( in_array($lang, array("ru","en","kg")) ) ? $lang : "ru" ;
	$postfix = ( $lang == "ru" ) ? "": "_" . $lang;
	$last = end($path_arr);

	return array( $path_arr, $last, $lang, $postfix, ($uri_arr[1] ?? '') );
}
/************************************************************************** get Lang
 * @param string $sLang
 * @return string $lang
 */
function getLang($sLang){
	if (empty($sLang)) {
		if (!isset($_COOKIE['lang'])) {
			$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
			//$lang = "ru";
			setcookie ("lang", $lang, 0, "/");
		} else {
			$lang = $_COOKIE['lang'];
		}
	} else {
		$lang = $sLang;
		setcookie ("lang", $lang, 0, "/");
	}
	return $lang;
}
/************************************************************************** translate Phrase $text
 * @param string $text
 */
function _l( $text ){
	global $static_lang;
	echo ( empty( $static_lang[$text] ) ) ? $text : $static_lang[$text];
}
/************************************************************************** translate Phrase $text
 * @param string $text
 */
function _ll( $text ){
	global $static_lang;
	return ( empty($static_lang[$text]) ) ? $text : $static_lang[$text];
}
/************************************************************************** translate Phrase $text
 * @param array $texts
 */
function _lt( $texts ){
	global $lang;
	return ( $lang == "ru" ) ? $texts[0] : $texts[1];
}
/************************************************************************** translate Phrase $text
 * @param string $stud_name
 */
function _ls( $stud_name ){
	global $lang;
	$texts = [];
	$arr = explode('/',$stud_name);
	$texts = $arr;
	if (count($arr) == 1) {
		$texts[1] = $arr[0];
	}
	return ( $lang == "ru" ) ? trim($texts[1]) : trim($texts[0]);
}

/************************************************************************** Main nav
 * @param array $r
 * @param array $groupments
 * @return string $str
 */
function available_groupments($r, $groupments) {
	$grp = json_decode($r['grp']);
	$grp_arr = array();
	foreach( $grp as $g ) {
		$grp_arr[] = $groupments[$g];
	}
	return implode(", ", $grp_arr);
}
/************************************************************************** NAV for Admin with permissions
 * @param array $p_path
 * @param string $needle
 * @return boolean
 */
function protect_nav($p_path, $needle) {
	return in_array($needle, $p_path) || $_SESSION["admlvl"] == 1;
}

/************************************************************************** Main nav
 * @param array $items
 * @param $current
 * @return string $str
 */
function buildNav( $items, $current ){
	$str = "";
	foreach ( $items as $uin=>$title ) {
		$href = ( empty($uin) ) ? "/": "/" . $uin . "/";
		$li_options = ( $uin == $current ) ? " active": "";
		?>
		<li class="nav-item<?php echo $li_options?>">
			<?php
			if( $uin == $current ) {
				?>
				<a class="nav-link disabled" href="<?php echo $href?>"> <?php echo $title?> <span class="sr-only">(current)</span></a>
				<?php
			} else {
				?>
				<a class="nav-link" href="<?php echo $href?>"> <?php echo $title?></a>
				<?php
			}
			?>
		</li>
		<?php
	}
	return $str;
}
/************************************************************************** Show Error Message
 * @param string $error
 */
function getError( $error ) {
	$str  = "<div class='alert alert-danger'>\n";
	$str .= "<button type='button' class='close close-alert'><span>&times;</span></button>\n";
	$str .= "<i class='fas fa-exclamation-circle'></i> " . $error;
	$str .= "</div>";
	echo $str;
}
/************************************************************************** Show Ok Message
 * @param string $ok
 */
function getOk( $ok ) {
	$str  = "<div class='alert alert-success'>\n";
	$str .= "<button type='button' class='close close-alert'><span>&times;</span></button>\n";
	$str .= "<i class='far fa-check-circle'></i> " . $ok;
	$str .= "</div>";
	echo $str;
}
/**
 * @param  $start
 * @return array
 */
function scanTutorFolder($start) {
	$files = array();
	$handle = opendir(S_ROOT . "/" . $start);
	while (false !== ($file = readdir($handle))) {
		if ($file != '.' && $file != '..' && $file != 'Thumbs.db') {
			if(in_array(end(explode('.', $file)), array("htm", "html")) ) {
				array_push($files, $file);
			}
		}
	}
	return $files;
}

/**
 * @param  $start
 * @return array
 */
function scanFolder($start) {
	chdir($start);
	$files = array();
	$handle = opendir('.');
	while (false !== ($file = readdir($handle))) {
		if ($file != '.' && $file != '..' && $file != 'Thumbs.db') {
			array_push($files, $file);
		}
	}
	closedir($handle);
	return $files;
}
/**
 * @param  $start
 * @return array
 */
function scanImages($start) {
	chdir($start);
	$files = array();
	$handle = opendir('.');
	while (false !== ($file = readdir($handle))) {
		if ($file != '.' && $file != '..' && $file != 'Thumbs.db') {
			array_push($files, $file);
		}
	}
	closedir($handle);
	return $files;
}

/************************************************************************** Show Info Box
 * @param string $msg
 * @param bool|string $mode
 * @return string $str
 */
function ShowInfo($msg, $mode=false) {
	if( !$mode ) {
		$mode = "success";
	}
	echo "<div id=\"InfoInTop\" class=\"top-note bg-" . $mode . " text-white rounded-3\">" . $msg . " </div>";
}
/************************************************************************** Clear value
 * @param array $el
 * @return array $el
 */
function str2ss(&$el) {
  if (is_array($el)) {
    foreach($el as $k=>$v) {
      $el[$k] = stripslashes($el[$k]);
    }
    return $el;
  } else {
    $el = stripslashes($el);
    return $el;
  }
}
/************************************************************************** String to uin
 * @param string $text
 * @param $len
 * @return string $str
 */
function shortText($text, $len)
{
  $str = str_replace("<br />"," ",$text);
  $str = strip_tags($str);
  $str = substr($str, 0, $len);
  $str = rtrim($str, "?!,.-");
  $str = substr($str, 0, strrpos($str, ' '));
  $str = $str . "...";
  return $str;
}
/************************************************************************** String to uin
 * @param string $string
 * @return string $string
 */
function rus2translit($string) {
	$converter = array(
		'а' => 'a',   'б' => 'b',   'в' => 'v',
		'г' => 'g',   'д' => 'd',   'е' => 'e',
		'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
		'и' => 'i',   'й' => 'y',   'к' => 'k',
		'л' => 'l',   'м' => 'm',   'н' => 'n',
		'о' => 'o',   'п' => 'p',   'р' => 'r',
		'с' => 's',   'т' => 't',   'у' => 'u',
		'ф' => 'f',   'х' => 'h',   'ц' => 'c',
		'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
		'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
		'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

		'А' => 'A',   'Б' => 'B',   'В' => 'V',
		'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
		'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
		'И' => 'I',   'Й' => 'Y',   'К' => 'K',
		'Л' => 'L',   'М' => 'M',   'Н' => 'N',
		'О' => 'O',   'П' => 'P',   'Р' => 'R',
		'С' => 'S',   'Т' => 'T',   'У' => 'U',
		'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
		'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
		'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
		'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
	);
	return strtr($string, $converter);
}
/************************************************************************** String to uin
 * @param string $string
 * @return string $string
 */
function str2uin($string)
{
	$string = rus2translit($string);
	$string = strtolower($string);
	$string = preg_replace("/[.,!;?«»']/", "", $string);
	$string = str_replace("-"," ",$string);
	$string = preg_replace("/[^\w\x7F-\xFF\s]/", "", $string);
	$string = str_replace("\\","",$string);
	$string = str_replace(" ","-",$string);
	return str_replace("--","-",$string);
}
/************************************************************************** Select val = val
 * @param string $Val
 * @param array $arr
 * @return string $str
 */
function getOptions($Val, $arr) {
  $str = "";
  foreach ($arr as $sVal) {
    $selected = ($Val == $sVal) ? " selected" : "";
    $str .= "<option value='" . $sVal . "'" . $selected . ">" . $sVal . "</option>\n";
  }
  return $str;
}
/************************************************************************** Select key = val
 * @param string $Val
 * @param array $arr
 * @return string $str
 */
function getOptionsK($Val, $arr) {
  $str = "";
  foreach ($arr as $sKey => $sVal) {
    $selected = ($Val == $sKey) ? " selected" : "";
    $str .= "<option value='" . $sKey . "'" . $selected . ">" . $sVal . "</option>\n";
  }
  return $str;
}
/************************************************************************** Select key = val
 * @param string $val
 * @param array $arr
 * @return string $str
 */
function getOptionsKData($Val, $arr) {
	$str = "";
	foreach ($arr as $arrkey => $a) {
		$datas = "";
		foreach ($a as $k => $v) {
			if ($k != 'title') {
				$datas .= " data-" . $k . "='" . $v . "'";
			}
		}
		$selected = ($Val == $arrkey) ? " selected" : "";
		$str .= "<option " . $datas . " value='" . $arrkey . "'" . $selected . " >" . $a['title'] . "</option>\n";
	}
	return $str;
}
/************************************************************************** Select key = val
 * @param string $Val
 * @param array $arr
 * @return string $str
 */
function getOptionsClass($Val, $arr) {
	$str = "";
	foreach ($arr as $sKey => $sVal) {
		$selected = ($Val == $sKey) ? " selected" : "";
		$str .= "<option class='" . $sVal[1] . "' value='" . $sKey . "'" . $selected . ">" . $sVal[0] . "</option>\n";
	}
	return $str;
}
/************************************************************************** Select key = val
 * @param string $val
 * @param array $arr
 * @return string $str
 */
function getOptionsData($val, $arr) {
	$str = "";
	foreach ($arr as $arrkey => $a) {
		$datas = "";
		foreach ($a as $k => $v) {
			if ($k != 'title') {
				$datas .= " data-" . $k . "='" . $v . "'";
			}
		}
		$selected = ($val == $arrkey) ? " selected" : "";
		$str .= "<option " . $datas . " value='" . $arrkey . "'" . $selected . " >" . $a['title'] . "</option>\n";
	}
	return $str;
}
/************************************************************************** Select key = val
 * @param array $exists
 * @param array $arr
 * @return string $str
 */
function getOptionsMultiple($exists, $arr) {
	$str = "";
	foreach ($arr as $sKey => $sVal) {
		$selected = ( in_array( $sKey, $exists ) ) ? " selected" : "";
		$str .= "<option value='" . $sKey . "'" . $selected . ">" . $sVal . "</option>\n";
	}
	return $str;
}
/************************************************************************** Select key = val
 * @param string $val
 * @param array $arr
 * @return string $str
 */
function getOptionsMultipleData($exists, $arr) {
	$str = "";
	foreach ($arr as $arrkey => $a) {
		$datas = "";
		foreach ($a as $k => $v) {
			if ($k != 'title') {
				$datas .= " data-" . $k . "='" . $v . "'";
			}
		}
		$selected = ( in_array( $arrkey, $exists ) ) ? " selected" : "";
		$str .= "<option " . $datas . " value='" . $arrkey . "'" . $selected . " >" . $a['title'] . "</option>\n";
	}
	return $str;
}
/************************************************************************** Select key = val
 * @param string $Val
 * @param array $arr
 * @return string $str
 */
function getOptionsMulti($Val, $arr) {
  $str = "";
  $val_arr = (empty($Val)) ? array(): json_decode( $Val );
  foreach ($arr as $sKey => $sVal) {
    $selected = ( in_array( $sKey, $val_arr ) ) ? " selected" : "";
    $str .= "<option value='" . $sKey . "'" . $selected . ">" . $sVal . "</option>\n";
  }
  return $str;
}

/************************************************************************** Select key = val
 * @param array $row
 * @return array
 */
function get_question( $row ) {
  $question = trim(preg_replace('/^\d{1,3}./', '', $row));
  if( preg_match_all('/(?<=\{:).+?(?=\})/', $question, $matches) ) {
    $ins_q['img'] = $matches[0][0];
    $question = trim(preg_replace('/(?<=\{:).+?(?=\})/', '', $question));
    $pos = strpos($question, '{:}');
    $ins_q['question'] = trim(str_replace('{:}', '', $question));
    if( $pos == 0 ) {
      $ins_q['img_pos'] = "before";
    } else {
      $ins_q['img_pos'] = "after";
    }
  } else {
    $ins_q['question'] = $question;
    $ins_q['img'] = "";
    $ins_q['img_pos'] = "";
  }
  return $ins_q;
}
/************************************************************************** Select key = val
 * @param array $row
 * @return array
 */
function get_answer( $row ) {
  $ins_a = array();
  $answer = trim(preg_replace('/^[a-zA-Z]./', '', $row));
  if( preg_match_all('/(?<=\{:).+?(?=\})/', $answer, $matches) ) {
    $ins_a['img'] = $matches[0][0];
    $answer = trim(preg_replace('/(?<=\{:).+?(?=\})/', '', $answer));
    $pos = strpos($answer, '{:}');
    $ins_a['answer'] = trim(str_replace('{:}', '', $answer));
    if( $pos == 0 ) {
      $ins_a['img_pos'] = "first";
    } else {
      $ins_a['img_pos'] = "last";
    }
  } else {
    $ins_a['answer'] = $answer;
    $ins_a['img'] = "";
    $ins_a['img_pos'] = "";
  }
  $ins_a['correct'] = 0;
  if( preg_match('/(^\+)|(\+$)/', $answer) ) {
    $ins_a['answer'] = trim(preg_replace("/(^\+)|(\+$)/", "", $ins_a['answer']));
    $ins_a['correct'] = 1;
  }
  return $ins_a;
}
/************************************************************************** Select key = val
 * @param array $row
 * @return array
 */
function shuffle_assoc( $row )
{
  $keys = array_keys( $row );
  shuffle( $keys );
  return array_merge( array_flip( $keys ) , $row );
}


/************************************************************************** Select key = val
 * @param array $list
 * @param $exam_id
 * @return string $str
 */
function exam_groups($list, $exam_id) {
  $str = "";
  foreach( $list as $r ) {
    if( $r['exam_id'] == $exam_id) {
      $str .= $r['grup_title'] . "; ";
    }
  }
  return substr($str, 0, -2);
}
/************************************************************************** Select key = val
 * @param array $list
 * @param $exam_id
 * @return string $str
 */
function exam_chapters($list, $exam_id) {
  $str = "";
  foreach( $list as $r ) {
    if( $r['exam_id'] == $exam_id) {
      $str .= $r['subject_title'] . "/" . $r['chapter_title'] . "; ";
    }
  }
  return substr($str, 0, -2);
}

/***************************************************************************************************
 * ************************************************************************** /adm/module, /t/module
*/
function adm_hidden_inputs() {
  global $module_need_inputs;
  $str = "";
  foreach( $_POST as $t_key=>$t_val ) {
    if( in_array($t_key, $module_need_inputs) ) {
      echo '<input type="hidden" id="' . $t_key . '" name="' . $t_key . '" value="' . $t_val . '">' . "\n";
    }
  }
}
/************************************************************************** Select key = val
 * @param $m_c_id
 * @return array
 */
function chapter_info($m_c_id) {
  global $DB;
  return $DB->selectRow('SELECT C.*, S.*, E.module_id, E.qty AS module_chapter_qty, E.selected_qty AS module_selected_qty'
    . ' FROM ?_module_chapters E'
    . ' INNER JOIN ?_dev_chapters C ON E.chapter_id=C.chapter_id'
    . ' INNER JOIN ?_dev_subjects  S ON E.subject_id=S.subject_id'
    . ' WHERE E.m_c_id=?'
    , $m_c_id
  );
}
/************************************************************************** Select key = val
 * @param array $list
 * @param $module_id
 * @return string $str
 */
function module_groups($list, $module_id) {
  $str = "";
  foreach( $list as $r ) {
    if( $r['module_id'] == $module_id) {
      $str .= $r['grup_title'] . "; ";
    }
  }
  return substr($str, 0, -2);
}

/************************************************************************** Select key = val
 * @param array $list
 * @param $module_id
 * @param bool $mode
 * @return string $str
 */
function module_chapters($list, $module_id, $mode=false) {
  $str = "";
  $subj_link = 0;
  foreach( $list as $r ) {
    if( $r['module_id'] == $module_id) {
        if( $mode == 'string' ) {
            $str .= $r['subject_title'] . '/' . $r['chapter_title'] . "\n";
        } elseif ($mode == 'subj-chapter') {
            if( $subj_link == 0 ) {
                $subj_link = 1;
                $str .= '<a class="d-block btn btn-sm btn-outline-secondary mb-1" href="../module-results-group/suid=' . $r['subject_id'] . '">' . $r['subject_title'] . '</a>';
            }
            $str .= '<div class="ctrlBtn d-inline-block" data-pid="' . $r['m_c_id'] . '">' . "\n";
            $str .= '<button class="btn btn-sm btn-secondary mb-1" data-page="_show_module_chapter">' . $r['chapter_title'] . '</button>' . "\n";
            $str .= '</div>' . "\n";
			$str = substr($str, 0, -2);
        } else {
            $str .= '<div class="ctrlBtn" data-pid="' . $r['m_c_id'] . '">' . "\n";
            $str .= '<button class="btn btn-sm btn-secondary mb-1" data-page="_show_module_chapter">' . $r['subject_title'] . '/' . $r['chapter_title'] . '</button>' . "\n";
            $str .= '</div>' . "\n";
			$str = substr($str, 0, -2);
        }
    }
  }
  return $str;
}
/************************************************************************** Select key = val
 * @param array $list
 * @param $tutor_id
 * @return string $str
 */
function tutor_chapters($list, $tutor_id) {
  $str = "";
  $tmp = array();
  foreach( $list as $r ) {
    if( $r['tutor_id'] == $tutor_id) {
      $tmp[] = $r['subject_title'];
    }
  }
  $tmp = array_unique($tmp);
  foreach( $tmp as $r ) {
    $str .= $r . "; ";
  }
//  foreach( $list as $r ) {
//    if( $r['tutor_id'] == $tutor_id) {
//      $str .= $r['subject_title'] . "/" . $r['chapter_title'] . "; ";
//    }
//  }
  return substr($str, 0, -2);
}

/************************************************************************** Select key = val
 * @param array $list
 * @param $mode
 * @param bool $did
 * @param bool $btn
 * @return string $str
 */
function tutor_meta($list, $mode, $did=false, $btn=false) {
	global $lang;
    $str = "";
    if($mode == "dept") {
        foreach( $list as $r ) {
            $str .= $r['full_dept_ru'] ."<br><small>" . $r['role_title'] . "</small>; ";
        }
    }
    if($mode == "subj") {
        foreach( $list as $r ) {
            $str .= ($lang == "ru")
				? $r['full_subject_ru']
				: $r['full_subject_en']
			;
			$str .= "; ";
        }
    }
    if($mode == "dept_subj") {
        foreach( $list as $r ) {
            if($did == $r['dept_id']) {
                $str .= "<small class='text-muted'>" . $r['subject_id'] . ": </small>";
				$str .= ($lang == "ru") ? $r['full_subject_ru']: $r['full_subject_en'];
                if(!empty($r['subs_title'])) {
                    $str .= " (" . $r['subs_title'] . $r['t_s_id']. ")";
                }
                $str .= "; ";
            }
        }
    }
    $str = mb_substr($str, 0, -2);
    $str = str_replace(";",";<br>",$str);
    return $str;
}

/************************************************************************** Select key = val
 * @param integer $r
 * @param array $rate
 * @return array $assest
 */
function get_assest($percent, $rate) {
	global $DB;
	if (count($rate) == 0) {
		$rate = $DB->selectRow('SELECT * FROM ?_rate_scale WHERE rate_id=?', 1);
	}
	$assest = array();
	if( $percent <= $rate['excellent_max'] ) {
		$assest['number'] = "5";
		$assest['title'] = "(отл)";
		$assest['ru'] = "отлично";
		$assest['en'] = "excellent";
	}
	if( $percent <= $rate['good_max'] ) {
		$assest['number'] = "4";
		$assest['title'] = "(хор)";
		$assest['ru'] = "хорошо";
		$assest['en'] = "good";
	}
	if( $percent <= $rate['fair_max'] ) {
		$assest['number'] = "3";
		$assest['title'] = "(удов)";
		$assest['ru'] = "удов.";
		$assest['en'] = "fair";
	}
	if( $percent <= $rate['low_max'] ) {
		$assest['number'] = "2";
		$assest['title'] = "(неуд)";
		$assest['ru'] = "неуд.";
		$assest['en'] = "low";
	}
	return $assest;
}

/************************************************************************** Select key = val
 * @param array $r
 * @param array $rate
 * @return string $str
 */
function get_assessment($r, $rate) {
  $assessment = '';
  if( $r <= $rate['excellent_max'] ) {
    $assessment = "excellent";
  }
  if( $r < $rate['good_max'] ) {
    $assessment = "good";
  }
  if( $r < $rate['fair_max'] ) {
    $assessment = "fair";
  }
  if( $r < $rate['low_max'] ) {
    $assessment = "low";
  }
  return $assessment;
}

/**
 * @param array $passed
 * @param array $exist
 * @return array
 */
function arrsIntersect($passed, $exist)
{
    $reArr['newArr'] = $reArr['delArr'] = array();
    foreach ($passed as $c) {
        if (!in_array($c, $exist)){
            $reArr['newArr'][] = $c;
        }
    }
    foreach ($exist as $e) {
        if (!in_array($e, $passed)){
            $reArr['delArr'][] = $e;
        }
    }
    return $reArr;
}

/**
 * @param $qin
 * @return array
 */
function question_by_id($qin)
{
  global $DB;
  return $DB->selectRow('SELECT Q.*, C.chapter_uin, C.chapter_title, S.subject_uin, S.subject_title'
    . ' FROM ?_questions Q'
    . ' INNER JOIN ?_chapters C ON C.chapter_id=Q.chapter_id'
    . ' INNER JOIN ?_subjects S ON S.subject_id=Q.subject_id'
    . ' WHERE Q.question_id=?'
    , $qin
  );
}

/**
 * @param $get_date
 * @return array
 */
function exam_start_end($get_date)
{
    $start_month = array("winter"=>"12", "summer"=>"06");
    $ym =explode("_", $get_date);
    $re['start'] = $ym[0] . "-" . $start_month[$ym[1]] . "-01 00:00:01";
    $re['end'] = date("Y-m-d H:i:s", strtotime("+3 month +23 hours +59 minutes +58seconds", strtotime($re['start'])));
    return $re;
}

/**
 * @param $time_start
 * @return string
 */
function time12to24($time_start) {
	$t = str_replace(":"," ",$time_start);
	$t_arr = explode(" ", $t);

	$t_arr[2] = ($t_arr[0] == 12 ) ? "AM": $t_arr[2];

	if( $t_arr[2] == "PM" ) {
		$t_arr[0] = $t_arr[0] + 12;
	} else {
		if( strlen($t_arr[0]) == 1 ) {
			$t_arr[0] = "0" . $t_arr[0];
		}
	}
	return $t_arr[0] . ":" . $t_arr[1] . ":00";
}

function is_date($date) {
    return ($date == "0000-00-00 00:00:00") ? "": date('d F, Y h:i:s', strtotime($date));
}

/**
 * @param $tutor
 * @return string
 */
function build_tutor_fio($tutor) {
    global $lang;
    if (!empty($tutor['tutor_fullru']) && $lang == "ru") {
		$str = trim($tutor['tutor_fullru']);
    } else {
		$str = trim($tutor['tutor_name']);
		if(!empty($tutor['tutor_lastname'])) {
			$str = trim($tutor['tutor_lastname']) . " " . $str;
		}
		if(!empty($tutor['tutor_patronymic'])) {
			$str .= " " . trim($tutor['tutor_patronymic']);
		}
    }
	return $str;
}
/**
 * @param $tutor
 * @return string
 */
function build_stud_fio($name) {
	global $lang;
	$tmp = explode("/",$name);
	$str = ($lang == "en") ? $tmp[0]: $tmp[1];
	return trim($str);
}
function translate_name($name) {
    global $lang;
    $n = ($lang == 'ru') ? 1: 0;
    echo trim(explode('/', $name)[$n]);
}
/**
 * @param $tutor array
 * @param $ru string
 * @return string
 */
function build_tutor_name($tutor, $ru=false){
    $str = trim($tutor['tutor_name']);
    if(!empty($tutor['tutor_lastname'])) {
        $str = trim($tutor['tutor_lastname']) . " " . $str;
    }
    if(!empty($tutor['tutor_patronymic'])) {
        $str .= " " . trim($tutor['tutor_patronymic']);
    }
    if (!empty($tutor['tutor_fullru']) && $ru) {
		$str .= "<br><small class='tutor-subtitle'>" . trim($tutor['tutor_fullru']) . "</small>";
    }
    return $str;
}
function _t($t) {
	global $lang;
	echo ($lang == "ru") ? $t['tutor_fullru']: $t['tutor_fullname'];
}
/**
 * @param $tutor array
 * @param $ru string
 * @return string
 */
function build_tutor_ru($tutor){
	$str = '';
	if (!empty($tutor['tutor_fullru'])) {
		$str .= trim($tutor['tutor_fullru']) . " / ";
	}

	$str .= trim($tutor['tutor_name']);
	if(!empty($tutor['tutor_lastname'])) {
		$str .= " " . trim($tutor['tutor_lastname']);
	}
	if(!empty($tutor['tutor_patronymic'])) {
		$str .= " " . trim($tutor['tutor_patronymic']);
	}

	return $str;
}
/**
 * @param $subject
 * @return string
 */
function build_subject_title($subject) {
    return (empty($subject['subs_title'])) ? $subject['subject_sem']: $subject['subject_sem'] . " / " . $subject['subs_title'];
}

/**
 * @return array
 */
function year_entry() {
    $maxYear = date('Y', strtotime('+2 year'));
    $year_entry = array();
    $q = 1;
    for($i=2017; $i < $maxYear; $i++) {
        $year_entry[$q] = $i;
        $q++;
    }
    return $year_entry;
}

/**
 * @return array
 */
function check_allowed($s) {
	$check['icon'] = "fa-square";
	$check['type'] = "text-muted";
	$check['text'] = "";
	$check['calc'] = false;

	$module_min = ($s['exam_id'] > 0) ? MAX_TEST_SCORE: MIN_PERCENT;

	$qty = 0;
	$allowed = 1;
	$q = 0;
	$modules_total = 0;

	foreach ($s as $k=>$r) {
		if(in_array($k, array('module1','module2','module3','module4'))) {
			if ($q < $s['modules']) {
                if ($allowed == 1) {
					$allowed = ($r < $module_min) ? 0 : $allowed;
                }
				$q++;
                if ($r == 0) {
					$qty++;
                }
				$modules_total = $modules_total + $r;
			}
		}
	}
	$avg = ceil($modules_total/$q);
	$check['avg_accept'] = ($allowed < 1) ? 0: 1;
	$allowed = ($avg < MIN_PERCENT) ? 0: $allowed;
	$check['allowed'] = $allowed;
	
    if ($qty < $s['modules']) {
		$check['calc'] = true;
		$check['text'] = ($s['hasexam']) ? "не допуск": "не зачет";
		if ($allowed == 1) {
			$check['icon'] = "fa-check-square";
			$check['type'] = "text-success";
			$check['text'] = ($s['hasexam']) ? "допуск": "зачет";
		} else {
			$check['type'] = "text-danger";
        }
    }

    return $check;
}
/**
 * @return array
 */
function check_repeated($s) {
	$check['icon'] = "fa-square";
	$check['type'] = "text-muted";
	$check['text'] = "";

	$allowed = 1;
	$check['calc'] = true;

	$check['text'] = ($s['is_exam'] > 0) ? "не допуск": "не зачет";
	if ($s['avg'] < MIN_PERCENT) {
		$check['type'] = "text-danger";
		$allowed = 0;
	} else {
		$check['icon'] = "fa-check-square";
		$check['type'] = "text-success";
		$check['text'] = ($s['is_exam'] > 0) ? "допуск": "зачет";
	}
	$check['allowed'] = $allowed;

	return $check;
}

/**
 * @param $sheet_id
 * @return string
 */
function buildSheetNum($sheet_id) {
	$sheet_prefix = '000';
	if (strlen($sheet_id) == 2) {
		$sheet_prefix = '00';
    }
	if (strlen($sheet_id) == 3) {
		$sheet_prefix = '0';
	}
	if (strlen($sheet_id) == 4) {
		$sheet_prefix = '';
	}
    return $sheet_prefix . $sheet_id;
}

/**
 * @param $begin
 * @return array
 */
function schoolYears($begin=false) {
	$i = ($begin) ? $begin: date('Y');
	$years = array();
	do {
		$years[] = $i-1 . ' - ' . $i;
		$i--;
	} while ($i > 2017);
	sort($years);
    return $years;
}

/**
 * @param $sname
 * @return string
 */
function studentShort($sname) {
	global $lang;

	$re = "";
	$is_kyzy = strpos($sname, 'кызы');
	$is_uluu = strpos($sname, 'уулу');
	$names = explode("/", $sname);
	$str = "";
	if ($lang == "en") {
		$str = $names[0];
	}
	if ($lang == "ru") {
		$str = (empty($names[1])) ? $names[0]: $names[1];
	}
	if ($is_kyzy || $is_uluu) {
		$re = $str;
	} else {
		$arr = explode(" ", $str);
		$s1 = (!empty($arr[1])) ? mb_substr($arr[1], 0, 1, "utf-8") . "." : "";
		$s2 = (!empty($arr[2])) ? mb_substr($arr[2], 0, 1, "utf-8") . "." : "";
		$re = $arr[0] . " " . $s1 . $s2;
	}
	return $re;
}