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
$faculties_name_for_top = array('vmk' => 'Прикл.математика...',
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
	$rows = file($filename);
	$unique_table = array();
	foreach($rows as $value)
	{
		$str = explode("\t", $value);
		$id = intval($str[0]);
		if ($id != 0) {
			$point = intval($str[1]);
			$unique_table[ $id ] = $point;
		}
	}
	return $unique_table;
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
	$multi_tables_size = count($multi_tables);
	$merged_table = array();
	foreach ($multi_tables as $unique_table) {
		$merged_table = $merged_table + $unique_table;
	}
	foreach ($merged_table as $id => $value) {
		$merged_table[ $id ] = array_fill(0, $multi_tables_size + 2, 0);
		$merged_table[ $id ][ 0 ] = $id;

		$sum = 0;
		$fail = false;
		foreach ($multi_tables as $index => $subject) {
			if (array_key_exists($id, $subject)) {
				$merged_table[ $id ][ $index + 1 ] = $subject[ $id ];
				if ($subject[ $id ] == 2)
					$fail = true;
				$sum += $subject[ $id ];
			} else {
				$fail = true;
			}
		}
		if ($fail)
			$sum = 0;
		$merged_table[ $id ][$multi_tables_size + 1] = $sum;
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

function get_top($faculties) {
	$answer = array();
	foreach ($faculties as $faculty) {
		if (!file_exists("top/$faculty.txt"))
			continue;
		$top_array = file("top/$faculty.txt");
		if ($top_array != false)
			$answer[$faculty] = $top_array;
	}
	return $answer;
}

function append_top_and_status_colomns($merged_table, $limit, $tops, $faculties_name_for_top) {
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
		
		$all_tops = "";
		foreach ($tops as $faculty => $thetop) {
			if (in_array($row[0], $thetop)){
				$all_tops .= $faculties_name_for_top[$faculty]."<br/>";
			}
		}
		
		$merged_table[$i][$size] = $all_tops;
		$merged_table[$i]['size'] = $size + 1;
		$merged_table[$i]['status'] = $status;
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