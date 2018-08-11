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
		foreach ($needles as $code) {
			$html_pre[$code] = "<span class='".$code."'>";
		}
		$html_post = "</span>";
	} else {
		foreach ($needles as $code) {
			$html_pre[$code] = "<p><big><span class='".$code."'>";
		}
		$html_post = "</span></big></p>";
	}
	$img = array("gold" => "&#10102",
				 "silver" => "&#10103",
				 "bronze" => "&#10104");
	
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
					break;
				}
			}
		}
		$table[$i][$colomn] = $row;
	}
	return $table;
}

function print_header($text) {
	echo "<div align='center'>\n";
	echo "<h2>\n";
	echo "$text\n";
	echo "</h2>\n";
	echo "</div>\n";
}

function print_buttons($link, $selected_key, $buttons) {
	echo "<div align='center'>\n";
	foreach ($buttons as $key => $text) {
		$is_selected = "";
		if (strval($key) === $selected_key)
			$is_selected = " selected";
		echo "<a class='button $is_selected' href='$link=$key'>$text</a> \n";
	}
	echo "</div>\n";
}

function print_table($table) {
# make array of col type
	$height = count($table);
	$width = count(current($table));

# print preambulas
	echo "<div align='center'>\n";
	echo "<div>\n";
	echo "<table>\n";

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
		echo "<tr>";
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

function show_pdf_file($file) {
	echo "<div align='center'>\n";
	echo "<div>\n";
	echo "<iframe src='$file' width='800px' height='800px'></iframe>";
	echo "</div>\n";
	echo "</div>\n";
}

function show_link_file($file, $header) {
	echo "<div align='center'>\n";
	echo "<span>\n";
	echo "<a class='button' href='$file.tex' download> $header в формате .tex </a>";
	echo "</span>\n";
	echo "<span>\n";
	echo "<a class='button' href='$file.pdf' download> $header в формате .pdf </a>";
	echo "</span>\n";
	echo "</div>\n";
}
?>