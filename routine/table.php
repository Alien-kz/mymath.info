<?php

function get_table_from_file($filename) {
	if (!file_exists($filename))
		return array();
	$data = file($filename, 
				FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
	$table = array("header" => explode("\t", $data[0]));
	$height = count($data);
	for ($i = 1; $i < $height; $i++) {
		if ($data[$i] != "")
			array_push($table, explode("\t", $data[$i]));
	}
	return $table;
}

function replace_prize_text($table, $colomn, $multiple, $replace, $needles) {
	$html_pre = array();
	$html_post = "";
	if ($multiple) {
		$img = array("gold" => "&#10102",
					"silver" => "&#10103",
					"bronze" => "&#10104");
		foreach ($needles as $code) {
			$html_pre[$code] = "<big><big><span class='$code'>";
		}
		$html_post = "</span></big></big>";
	} else {
		$img = array("gold" => "&#10112",
					"silver" => "&#10113",
					"bronze" => "&#10114");
		foreach ($needles as $code) {
			$html_pre[$code] = "<p><big><big><big><span><b>";
		}
		$html_post = "</b></span></big></big></big></p>";
	}
	
	$height = count($table) - 1;
	for ($i = 0; $i < $height; $i++) {
		$row = $table[$i][$colomn];
		
		if ($multiple) {
			foreach ($needles as $needle => $code) {
				$result = $html_pre[$code].$img[$code].$html_post;
				$row = str_replace($needle, $result, $row);
			}
		} else {
			foreach ($needles as $needle => $code) {
				$result = $html_pre[$code].$img[$code]." ".$needle.$html_post;
				if ($replace)
					$result = $html_pre[$code].$img[$code].$html_post;
				$row = str_replace($needle, $result, $row);
				if ($row != $table[$i][$colomn]) {
					$table[$i]['row_type'] = $code;
					break;
				}
			}
		}
		$table[$i][$colomn] = $row;
	}
	return $table;
}

function cut_university($row) {
	$matches = array();
	$name = "";
	$marker = preg_match("/([0-9]|\(|:)/", $row, $matches, PREG_OFFSET_CAPTURE);
	if ($marker) {
		$position = $matches[0][1];
		$name = trim(substr($row, 0, $position));
	} else {
		$name = $row;
	}
	return $name;
}

function get_university_list($table, $colomn) {
	$list = array();
	$height = count($table) - 1;
	for ($i = 0; $i < $height; $i++) {
		$row = $table[$i][$colomn];
		$name = cut_university($row);
		if ($name == "Total runs")
			break;
		array_push($list, $name);
	}
	sort($list);
	$list = array_unique($list);
	return $list;
}

function mark_top($table, $colomn, $top) {
	$counter = array();
	$height = count($table) - 1;
	for ($i = 0; $i < $height; $i++) {
		$row = $table[$i][$colomn];
		$name = cut_university($row);
		if (isset($counter[$name]))
			$counter[$name] += 1;
		else
			$counter[$name] = intval(1);
		if ($counter[$name] <= $top) {
			$table[$i]['row_type'] = "silver";
		}
	}
	return $table;
}

function select_top($table, $colomn, $top) {
	$counter = array();
	$height = count($table) - 1;
	$new_table = array();
	if (isset($table['header'])) {
		$header = $table['header'];
		array_unshift($header, "№");
		$new_table['header'] = $header;
	}
	$current = 1;
	for ($i = 0; $i < $height; $i++) {
		$row = $table[$i][$colomn];
		$name = cut_university($row);
		if (isset($counter[$name]))
			$counter[$name] += 1;
		else
			$counter[$name] = intval(1);
		if ($counter[$name] <= $top) {
			$str = $table[$i];
			array_unshift($str, $current);
			array_push($new_table, $str);
			$current += 1;
		}
	}
	return $new_table;
}

function mark_row($table, $colomn, $needle) {
	$height = count($table) - 1;
	for ($i = 0; $i < $height; $i++) {
		$row = $table[$i][$colomn];
		$marker = stripos(" ".$row, $needle);
		if ($marker) {
			$table[$i]['row_type'] = "silver";
		}
	}
	return $table;
}

function select_row($table, $colomn, $needle) {
	if ($needle == "")
		return $table;
	$height = count($table) - 1;
	$new_table = array();
	if (isset($table['header'])) {
		$header = $table['header'];
		array_unshift($header, "№");
		$new_table['header'] = $header;
	}
	$current = 1;
	for ($i = 0; $i < $height; $i++) {
		$row = $table[$i][$colomn];
		$marker = stripos(" ".$row, $needle);
		if ($marker) {
			$str = $table[$i];
			array_unshift($str, $current);
			array_push($new_table, $str);
			$current += 1;
		}
	}
	return $new_table;
}


function replace_brackets_to_label($table) {
	$height = count($table) - 1;
	for ($i = 0; $i < $height; $i++) {
		$width = count($table[$i]) - 1;
		for ($j = 0; $j < $width; $j++) {
			$cell = $table[$i][$j];
			$cell = str_replace("(", "<br/><small>", $cell);
			$cell = str_replace(")", "</small>", $cell);
			$table[$i][$j] = $cell;
		}
	}
	return $table;
}

function print_table($table) {
# make array of col type
	$height = count($table);
	$row = current($table);
	$width = count($row);
	if (isset($row['row_type'])) {
		$row -= 1;
	}

# print preambulas
	echo "<div align='center'>\n";
	echo "<div class='xscroll'>\n";
	echo "<table align='center'>\n";

# print header
	if (isset($table['header'])) {
		echo "<thead>\n";
		echo "<tr>";
		for ($j = 0; $j < $width; $j++) {
			echo "<th>".$table['header'][$j]."</th>";
		}
		echo "</tr>\n";
		echo "</thead>\n";
		$height -= 1;
	}
	
# print body
	echo "<tbody>\n";
	for ($i = 0; $i < $height; $i++) {
		$row = $table[$i];
		$color = "";
		if (isset($row['row_type'])) {
			$color = " class='bg_".$row['row_type']."'";
		}
		echo "<tr$color>";
		for ($j = 0; $j < $width; $j++) {
			echo "<td>".$row[$j]."</td>"; 
		}
		echo "</tr>\n";
	}
	echo "</tbody>\n";

# print postambulas
	echo "</table>\n";
	echo "</div>\n";
	echo "</div>\n";
}
?>
