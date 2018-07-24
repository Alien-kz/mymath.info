<?php

$data_file_result = array( 'm' => "math",
						'e' => "eng",
						'r' => "rus",
						'p' => "phys",
						'g' => "geo",
						'l' => "liter");
$data_file_top = array('mrp' => 'vmk',
						'mr' => 'mm',
						'mre' => 'econom',
						'mrg' => 'geo',
						'erl' => 'phyl');
$faculties_limits = array('vmk' => 27,
							'mm' => 25,
							'econom' => 27,
							'geo' => 26,
							'phyl' => 20);
$faculties_name_for_top = array('vmk' => 'Прикл.матем...',
								'mm' => 'Математика',
								'econom' => 'Экономика',
								'geo' => 'Экология...',
								'phyl' => 'Филология');
$subject_name = array( 'm' => "Математика",
						'e' => "Иностранный язык",
						'r' => "Русский язык",
						'p' => "Физика",
						'g' => "География",
						'l' => "Литература");
################################################################################
# id<tab>point<newline>
# id<tab>point<newline>
# ...
# id<tab>point<newline>
################################################################################

function file_to_array($filename) {
	$rows = file($filename, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
	$unique_table = array();
	foreach($rows as $value)
	{
		$str = explode("\t", $value);
#		$id = intval($str[0]);
		$id = $str[0];
		if ($id != "") {
			$point = intval($str[1]);
			$unique_table[ $id ] = $point;
		}
	}
	return $unique_table;
}

function write_top($multi_tables, $limit, $faculty) {
	$position = 0;
	$ids = "";
	foreach ($multi_tables as $row) {
		$position += 1;
		if ($position <= $limit) {
			$ids .= $row[0]."\n";
		}
	}
	file_put_contents("top/$faculty.txt", $ids, LOCK_EX);
}

function get_top($dir, $faculties) {
	$answer = array();
	foreach ($faculties as $faculty) {
		if (!file_exists("$dir/$faculty.txt"))
			continue;
		$top_array = file("$dir/$faculty.txt", FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
		if ($top_array != false)
			$answer[$faculty] = $top_array;
	}
	return $answer;
}


################################################################################
# ('vmk' => ("Баев Ален 117", "Баева Виолетта 300", ... ), 'mm' => ()
# 
################################################################################

function split_top($tops) {
	$splitted_tops = array();
	foreach ($tops as $faculty => $rows){
		$splitted_rows = array();
		foreach ($rows as $row) {
			$splitted = explode("\t", $row);
			if ($splitted[0] != "")
				array_push($splitted_rows, $splitted);
		}
		$splitted_tops[$faculty] = $splitted_rows;
	}
	return $splitted_tops;
}


################################################################################
# 'mre'
# math.txt -> $data['m'] = (id => point, id => point, ..., id => point)
# rus.txt  -> $data['r'] = (id => point, id => point, ..., id => point)
# eng.txt  -> $data['e'] = (id => point, id => point, ..., id => point)
################################################################################

function get_multi_tables($subjects_char_index, $datafile_name) {
	$multi_tables = array();
	$data = array();
	foreach ($datafile_name as $subject_key => $filename) {
		if (in_array($subject_key, $subjects_char_index)) {
			$data[$subject_key] = file_to_array('data/'.$filename.'.txt');
			array_push($multi_tables, $data[$subject_key]);
		}
	}
	return $multi_tables;
}


################################################################################
# n = $multi_tables_size
# $multi_tables 
# subj[0] => (id => point, id => point, ..., id => point)
# subj[1] => (id => point, id => point, ..., id => point)
# ...
# subj[n-1] => (id => point, id => point, ..., id => point)
################################################################################

function merge($multi_tables) {
	$multi_tables_number = count($multi_tables);
	$merged_table = array();
	$key_table = array();
	foreach ($multi_tables as $unique_table) {
		$key_table = $key_table + $unique_table;
	}
	foreach ($key_table as $id => $value) {
		$row = array_fill(0, $multi_tables_number + 2, 0);
		$row[ 0 ] = $id;

		$sum = 0;
		$fail = false;
		foreach ($multi_tables as $index => $subject) {
			if (array_key_exists($id, $subject)) {
				$row[ $index + 1 ] = $subject[ $id ];
				if ($subject[ $id ] == 2)
					$fail = true;
				$sum += $subject[ $id ];
			} else {
				$fail = true;
			}
		}
		if ($fail)
			$sum = 0;
		$row[$multi_tables_number + 1] = $sum;
		array_push($merged_table, $row);
	}
	return $merged_table;
}

function merge_all($multi_tables) {
	$multi_tables_number = count($multi_tables);
	$merged_table = array();
	$key_table = array();
	foreach ($multi_tables as $unique_table) {
		$key_table = $key_table + $unique_table;
	}
	foreach ($key_table as $id => $value) {
		$row = array_fill(0, $multi_tables_number + 2, 0);
		$row[ 0 ] = $id;

		$sum = 0;
		foreach ($multi_tables as $index => $subject) {
			$row[ $index + 1 ] = $subject[ $id ];
			$sum += intval($subject[ $id ]);
		}
		$row[$multi_tables_number + 1] = $sum;
		array_push($merged_table, $row);
	}
	return $merged_table;
}

################################################################################
# n = $row_size
# $merged_table 
# (id, subj[0], subj[1], subj[2], ..., subj[n-1], sum)
# (id, subj[0], subj[1], subj[2], ..., subj[n-1], sum)
# ...
# (id, subj[0], subj[1], subj[2], ..., subj[n-1], sum)
################################################################################

function sort_by_sum($merged_table) {
	$total_sum = array();
	foreach($merged_table as $row) {
		array_push($total_sum, end($row));
	}
	array_multisort($total_sum, SORT_DESC, $merged_table);
	return $merged_table;
}

function set_status($merged_table, $limit, $selected_id) {
	# status : 'DEFAULT', 'TOP', 'FAILED', 'RESERVED'
	$users = count($merged_table);
	$size = count(end($merged_table));

	for ($i = 0; $i < $users; $i++) {
		$row = $merged_table[$i];
		$status = 'row_default';	
		$reserve = 0;
		for ($j = 0; $j < $size - 1; $j++) {
			if ($row[$j] == 1) {
				$reserve += 1;
			}
		}
		if ($reserve == 1) {
			$status = 'row_reserved';
		}
		if (end($row) == 0){
			$status = 'row_failed';
		}				
		if ($i < $limit) {
			$status = 'row_top';
		}
		if ($merged_table[$i][0] == $selected_id) {
			$status = 'row_selected';
		}
		$merged_table[$i]['status'] = $status;
	}
	return $merged_table;
}

function set_final_status($merged_table, $limit) {
	# status : 'DEFAULT', 'TOP', 'FAILED', 'RESERVED'
	$users = count($merged_table);
	$collision = false;

	for ($i = 0; $i < $users; $i++) {
		$row = $merged_table[$i];
		$status = 'row_default';	
		if ($i < $limit) {
			$status = 'row_top';
		}
		if ($i < $limit && 
			$merged_table[$i][2] == $merged_table[$limit][2]) {
			$collision = true;
			$status = 'row_failed';
		}
		if ($i >= $limit && $collision &&
			$merged_table[$i][2] == $merged_table[$limit][2]) {
			$status = 'row_failed';
		}
		$merged_table[$i]['status'] = $status;
	}
	return $merged_table;
}

function append_comment_colomn($merged_table, $limit, $tops, $faculties_name_for_top) {
	$users = count($merged_table);
	for ($i = 0; $i < $users; $i++) {
		$row = $merged_table[$i];		
		$all_tops = "";
		foreach ($tops as $faculty => $thetop) {
			if (in_array($row[0], $thetop)){
				$all_tops .= $faculties_name_for_top[$faculty]."<br/>";
			}
		}
		array_push($merged_table[$i], $all_tops);
	}
	return $merged_table;
}


function append_final_comment_colomn($multi_table,
					$current_faculty, 
					$faculties_limits, 
					$faculties_name_for_top) {
	$merged_table = $multi_table[$current_faculty];
	$users = count($merged_table);

	$collision = false;
	for ($i = 0; $i < $users; $i++) {
		$user = $merged_table[$i];
		$all_tops = "";
		foreach ($faculties_name_for_top as $faculty => $fname) {
			if ($faculty != $current_faculty) {
				$size = $faculties_limits[$faculty];
				for ($j = 0; $j < $size; $j++) {
					$altuser = $multi_table[$faculty][$j];
					if ($user[0] != "..." &&
						$user[0] == $altuser[0] && 
						$user[1] == $altuser[1]) {
						$status = 'row_reserved';
						$all_tops .= $fname."<br/>";
					}
				}
			}
		}
		array_push($merged_table[$i], $all_tops);
	}
	return $merged_table;
}

function unshift_position_colomn($merged_table) {
	$users = count($merged_table);
	for ($i = 0; $i < $users; $i++) {
		array_unshift($merged_table[$i], $i + 1);
	}
	return $merged_table;

}


################################################################################
# 'mre'
# Номер Пропуск | Математика Русский Английский | Сумма Топ
################################################################################

function get_merged_table_header($subjects_char_index, $subject_name, $prefix_headers, $suffix_headers) {
		$header = $prefix_headers;
		foreach ($subject_name as $subject_key => $name) {
			if (in_array($subject_key, $subjects_char_index)) {	
				array_push($header, $name);
			}
		}
		return array_merge($header, $suffix_headers);
}

?>