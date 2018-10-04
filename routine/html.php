<?php

function load_css($prefix, $css_array, $agent) {
	$ver = "2018-09-26";
	$prefix = $prefix."css/";
	if ($agent == 'mobile') {
		foreach ($css_array as $css) {
			$file = $prefix.$css.".css";
			$file_m = $prefix.$css."_m.css";
			if (file_exists($file_m)) {
				echo "<link href='$file_m?ver=$ver' rel='stylesheet' type='text/css' >\n";
			} else {
				echo "<link href='$file?ver=$ver' rel='stylesheet' type='text/css' >\n";
			}
		}
	} else {
		foreach ($css_array as $css) {
			$file = $prefix.$css.".css";
			echo "<link href='$file?ver=$ver' rel='stylesheet' type='text/css' >\n";
		}
	}
}

function attr_get($attr_name) {
	if (isset($_GET[$attr_name])) {
		return $_GET[$attr_name];
	}
	return "";
}

function attr_post($attr_name) {
	if (isset($_POST[$attr_name])) {
		return $_POST[$attr_name];
	}
	return "";
}

function get_main_buttons($prefix) {
	return array($prefix."" => "Главная",
				$prefix."abiturient/" => "Абитуриентам", 
				$prefix."student/" => "Студентам", 
				$prefix."math/" => "Математика",
				$prefix."prog/" => "Программирование",
				$prefix."books/" => "Книги");
}

function print_head_buttons($selected_link, $buttons) {
	echo "\n";
	echo "<div align='center' class='buttons_div'>\n";
	foreach ($buttons as $link => $text) {
		$is_selected = "";
		if ($link === $selected_link)
			$is_selected = " selected";
		echo "<a class='$is_selected colomns_in_header button' href='$link'>$text</a> \n";
	}
	echo "</div>\n\n";
}

function gen_buttons_from_file($file) {
	$buttons = array();
	$array = get_table_from_file($file);
	$number = count($array) - 1;
	for ($i = 0; $i < $number; $i++) {
		$row = $array[$i];
		$buttons[$row[0]] = $row[1];
	}
	return $buttons;
}

function get_user_agent_type() { 
	if (preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]))
		return 'mobile';
	return 'desktop';
}

function div_open($text, $anchor) {
	if ($anchor)
		$anchor = "id='$anchor'";
	echo "<div align='center' $anchor>\n";
	echo "<div class='content_div'>\n";
	if ($text) {
		print_header($text);
	}
}

function div_close() {
	echo "</div>\n";
	echo "</div>\n\n";
}

function print_header($text) {
	echo " <div align='center' class='head_div bgcolor'>\n";
	$text = str_replace("~", "&nbsp;", $text);
	echo " $text\n";
	echo " </div>\n";
}

function print_centered_text($text) {
	echo "<div align='center' class='text_div'>\n";
	$text = str_replace("~", "&nbsp;", $text);
	echo "$text\n";
	echo "</div>\n";
}

function replace_level($text) {
	$text = str_replace("+++", "<span class='green'>&#10102;</span>", $text);
	$text = str_replace("++-", "<span class='yellow'>&#10103;</span>", $text);
	$text = str_replace("+--", "<span class='red'>&#10104;</span>", $text);
	return $text;
}


function prepare_text($text) {
#	# double newline
#	$text = preg_replace("/[\n]+/", "\n", $text);
	$text = str_replace("\n<h3>", "<h3>", $text);

	# table
	$text = str_replace("<table>\n", "<table>", $text);
	$text = str_replace("</table>\n", "</table>", $text);
	$text = str_replace("<tr>\n", "<tr>", $text);
	$text = str_replace("</tr>\n", "</tr>", $text);
	$text = str_replace("<td>\n", "<td>", $text);
	$text = str_replace("</td>\n", "</td>", $text);
	$text = str_replace("<th>\n", "<th>", $text);
	$text = str_replace("</th>\n", "</th>", $text);
	$text = str_replace("<table>", "<div class='xscroll'><table align='center' border='1'>", $text);
	$text = str_replace("</table>", "</table></div>", $text);
	
	# header0
	$text = str_replace("<h3>\n", "<h3>", $text);
	$text = str_replace("</h3>\n", "</h3>", $text);

	# external link
	$text = str_replace("<a ", "<a class='microbutton external_link' target='blank_' ", $text);
	
	# picture
	$text = preg_replace("/<picture (.*?)>/", "<div align='center'><img class='resized' src=$1></div>", $text);

	# file
	$text = preg_replace("/<file (.*?)>/", "<a class='microbutton download_link' target='blank_' href=$1 download> &#128190;", $text);
	$text = str_replace("</file>", "</a>", $text);

	# no file
	$text = preg_replace("/<nofile (.*?)>/", "", $text);
	$text = str_replace("</nofile>", "", $text);
	# no external link
	$text = preg_replace("/<noa (.*?)>/", "", $text);
	$text = str_replace("</noa>", "", $text);
	
	
	# newline
	$text = nl2br($text);
	
	return $text;
}
function print_text($text) {
	$text = prepare_text($text);
	
	echo "<div align='left'>\n";
	echo $text."\n";
	echo "</div>\n";
}

function prepare_code($text, $left_class) {
	$code_line_begin = "<div class='mycode $left_class'>";
	$code_line_end = "</div>\n";

	$text = str_replace("\n", $code_line_end.$code_line_begin, $text);
	$text = str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;", $text);
	$text = $code_line_begin.$text.$code_line_end;
	$text = "<div class='code_div'>\n".$text."</div>\n";
	return $text;
}

function print_code($text) {
	echo prepare_code($text, "line_number");
}

function find_positions($text, $needle) {
	$last_pos = 0;
	$positions = array();

	while (($last_pos = strpos($text, $needle, $last_pos))!== false) {
		$positions[] = $last_pos;
		$last_pos = $last_pos + strlen($needle);
	}
	return $positions;
}

function replace_code($text, $first_tag, $last_tag, $css_class) {
	$first_tag = "<code>";
	$last_tag = "</code>";
	$first_tag_length = strlen($first_tag);
	$last_tag_length = strlen($last_tag);
	$start = find_positions($text, $first_tag);
	$finish = find_positions($text, $last_tag);
	$blocks = count($start);

	$result = "";
	$finish[-1] = 0;
	for ($i = 0; $i < $blocks; $i++) {
		$code = substr($text, $start[$i], $finish[$i] - $start[$i] + $last_tag_length);
		$code = substr($code, $first_tag_length);
		$code = substr($code, 0, -$last_tag_length);
		$code = trim($code);
		$code = prepare_code($code, $css_class);
		
		$text_in_block = substr($text, $finish[$i - 1], $start[$i] - $finish[$i - 1]);
		$text_in_block = prepare_text($text_in_block);
		$result = $result.$text_in_block.$code;
	}
	$text_in_block = substr($text, $finish[$blocks - 1]);
	$text_in_block = prepare_text($text_in_block);
	$result = $result.$text_in_block;
	return $result;
}

function replace_code_tag($text, $first_tags, $last_tags, $css_class) {
	// code start, code finish, code type
	$tag_type_number = count($first_tags);
	$tag_type = array();
	$code_start_positions = array();
	$code_finish_positions = array();
	for ($i = 0; $i < $tag_type_number; $i++) {
		$first_tag = $first_tags[$i];
		$last_tag = $last_tags[$i];
		$first_tag_positions = find_positions($text, $first_tag);
		$last_tag_positions = find_positions($text, $last_tag);
		$first_tag_length = strlen($first_tag);
		$last_tag_length = strlen($last_tag);
		$first_tag_number = count($first_tag_positions);
		$last_tag_number = count($last_tag_positions);
		if ($first_tag_number != $last_tag_number) {
			return $text;
		}
		for ($j = 0; $j < $first_tag_number; $j++) {
			array_push($code_start_positions , $first_tag_positions[$j] + $first_tag_length);
			array_push($code_finish_positions, $last_tag_positions[$j]);
			$tag_type[$first_tag_positions[$j]] = $i;
		}
	}
	//sort
	sort($code_start_positions);
	sort($code_finish_positions);
	ksort($tag_type);
	$tag_type = array_values($tag_type);
	// text start, text finish
	$blocks = count($code_start_positions);
	$text_start_positions = array();
	$text_finish_positions = array();
	$text_start_positions[0] = 0;
	for ($i = 0; $i < $blocks; $i++) {
		$current_type = $tag_type[$i];
		$text_finish_positions[$i] = $code_start_positions[$i] - strlen($first_tags[$current_type]);
		$text_start_positions[$i + 1] = $code_finish_positions[$i] + strlen($last_tags[$current_type]);
	}
	$text_finish_positions[$blocks] = strlen($text);
	// replacing
	$result = "";
	for ($i = 0; $i < $blocks; $i++) {
		$text_in_block = substr($text, 
								$text_start_positions[$i], 
								$text_finish_positions[$i] - $text_start_positions[$i]);
		$text_in_block = trim($text_in_block);
		$text_in_block = prepare_text($text_in_block);
		$result = $result.$text_in_block;

		$current_type = $tag_type[$i];
		$code_in_block = substr($text, 
						$code_start_positions[$i], 
						$code_finish_positions[$i] - $code_start_positions[$i]);
		$code_in_block = trim($code_in_block);
		$code_in_block = prepare_code($code_in_block, $css_class[$current_type]);
		$result = $result.$code_in_block;
	}
	$text_in_block = substr($text, 
							$text_start_positions[$blocks], 
							$text_finish_positions[$blocks] - $text_start_positions[$blocks]);
	$text_in_block = prepare_text($text_in_block);
	$result = $result.$text_in_block;
	return $result;
}

function print_text_with_code($text) {
	$text = replace_code_tag($text, 
							array("<code>", "<bash>", "<python>", "<cmd>"), 
							array("</code>", "</bash>", "</python>", "</cmd>"), 
							array("line_number", "line_bash", "line_python", "line_cmd"));
	echo "<div align='left'>\n";
	echo $text."\n";
	echo "</div>\n";
}

function print_post($header, $anchor, $file) {
	if (file_exists($file)) {
		div_open($header, $anchor);
		print_text_with_code(file_get_contents($file)); 
		div_close();
	}
}

############################################# FORMS 

function input_hidden($default_keys, $current_keys) {
	foreach ($default_keys as $key => $value) {
		if ($value !== "false" and $value !== "") {
			$used = false;
			foreach ($current_keys as $ckey) {
				if ($key == $ckey) {
					$used = true;
					break;
				}
			}
			if ($used == false) {
				echo "<input type='hidden' name='$key' value='$value'>\n";
			}
		}
	}
}

function input_buttons($button_key, $button_values, $button_names, $default_keys) {
	$is_selected = "";
	if (isset($default_keys[$button_key]) and ($default_keys[$button_key] == $button_values[0]))
		$is_selected = " selected";
	echo "<button class='button $is_selected' type='submit' name='$button_key' value='$button_values[0]'> $button_names[0] </button>";
	
	$is_selected = "";
	if (isset($default_keys[$button_key]) and ($default_keys[$button_key] == $button_values[1]))
		$is_selected = " selected";
	echo "<button class='button $is_selected' type='submit' name='$button_key' value='$button_values[1]'> $button_names[1] </button>";
	
	echo "<button class='button' type='submit' name=''>сброс</button>";
}

function print_form($action, $text, $button_key, $button_values, $button_names, $default_keys) {
	echo "<div align='center'>\n";
	echo "<form action='$action' method='get'>\n";
	input_hidden($default_keys, array($button_key));

	echo "<div class='left inline'>";
	echo $text;
	echo "</div>";
	
	echo "<div class='right inline'>";
	input_buttons($button_key, $button_values, $button_names, $default_keys);
	echo "</div>";
	echo "</form>\n";

	echo "</div>\n";
}

function print_form_number($action, $text, $field_key, $value, $button_key, $button_values, $button_names, $default_keys) {
	echo "<div align='center'>\n";
	echo "<form action='$action' method='get'>\n";
	input_hidden($default_keys, array($field_key, $button_key));

	echo "<div class='left inline'>";
	$input = "<input type='number' min='1' max='9' name='$field_key' value='$value'>";
	$text = str_replace("<number>", $input, $text); 
	echo $text;
	echo "</div>";
	
	echo "<div class='right inline'>";
	input_buttons($button_key, $button_values, $button_names, $default_keys);
	echo "</div>";
	
	echo "</form>\n";
	echo "</div>\n";
}

function print_form_select($action, $values, $field_key, $value, $button_key, $button_values, $button_names, $default_keys) {
	echo "<div align='center'>\n";
	echo "<form action='$action' method='get'>\n";
	input_hidden($default_keys, array($field_key, $button_key));

	echo "<div class='left inline'>";
	echo "<select name='$field_key' autofocus>\n";
	foreach ($values as $current_value) {
		$is_selected = "";
		if ($current_value === $value)
			$is_selected = " selected";
		echo "<option $is_selected value='$current_value'> $current_value </option> \n";
	}
	echo "</select>\n";
	echo "</div>";
	
	echo "<div class='right inline'>";
	input_buttons($button_key, $button_values, $button_names, $default_keys);
	echo "</div>";
	
	echo "</form>\n";
	echo "</div>\n";

}

############################################# BUTTONS

function print_buttons_external($buttons) {
	echo "<div align='center' class='buttons_div'>\n";
	foreach ($buttons as $link => $text) {
		echo "<a class='button external_link' target='_blank' href='$link'>$text</a> \n";
	}
	echo "</div>\n";
}

function print_about($about, $directory, $link, $anchor) {
	$text = "";
	if ($about) {
		$text =  "скрыть";
		$link = $link."#".$anchor;
	} else {
		$text =  "подробнее...";
		$link = $link."&amp;about=true#".$anchor;
	}
	echo "<div align='center'>\n";
	echo "<a class='head_div minibutton' href='$link'>$text</a> \n";
	if ($about) {
		print_text(file_get_contents($directory."/about.txt")); 
	}
	echo "</div>\n";	
}

function print_buttons($link, $key_name, $key_selected, $buttons, $default_keys, $anchor) {
	echo "\n";
	echo "<div align='center'>\n";
	$attributes = "";
	if ($default_keys) {
		foreach ($default_keys as $key => $value) {
			$attributes = $attributes.$key."=".$value."&amp;";
		}
	}
	foreach ($buttons as $key => $text) {
		$is_selected = "";
		if (strval($key) === $key_selected)
			$is_selected = " selected";
		echo "<a class='$is_selected minibutton' href='$link?$attributes$key_name=$key$anchor'>$text</a> \n";
	}
	echo "</div>\n\n";
}

function print_select_buttons($link, $key_name, $key_selected, $buttons, $default_keys, $anchor) {
	echo "<div align='center'>\n";
	echo "<form action='$link' method='get'>";
	input_hidden($default_keys);

	echo "<div align='right' class='inline'>";
	echo "<select name='$key_name' autofocus>";	
	$html = "";
	foreach ($buttons as $key => $value) {
		$is_selected = "";
		if (strval($key) === $key_selected)
			$is_selected = " selected";
		$html = "<option $is_selected value='$key'> $value </option> \n".$html;
	}
	echo $html;
	echo "</select>";
	echo "</div>\n";

	echo "<div align='left' class='inline'>";
	echo "<input class='button' type='submit' value='показать'>\n";
	echo "</div>\n";

	
	echo "</form>\n";
	echo "</div>\n";
}

############################################# SHOW LINK AND FILE

function show_pdf_file($file) {
	echo "<div align='center'>\n";
	echo "<div>\n";
	echo "<iframe src='$file' width='800px' height='800px'></iframe>";
	echo "</div>\n";
	echo "</div>\n";
}

function show_link_file($file, $link_text) {
	if (file_exists($file.".pdf")) 
	{
		echo "<div align='center'>\n";
		echo "<span>\n";
		echo "<a class='button download_link' href='$file.tex' download> &#128190; $link_text (.tex) </a>";
		echo "</span>\n";
		echo "<span>\n";
		echo "<a class='button download_link' href='$file.pdf' download> &#128190; $link_text (.pdf) </a>";
		echo "</span>\n";
		echo "</div>\n";
	}
}

function show_png_file($file) {
	if (file_exists($file.".png")) {
		echo "<div align='center' class='image_div'>\n";
		echo "<img class='image_fit' src='$file.png'>";
		echo "</div>\n";
	}
	else if (file_exists($file."-0.png")) {
		echo "<div align='center'>\n";
		$part = 0;
		$file_name = $file."-".$part.".png";
		do {
			echo "<div align='center' class='image_div'>\n";
			echo " <img class='image_fit' src='$file_name'>\n";
			echo "</div>\n";
			$part += 1;
			$file_name = $file."-".$part.".png";
		} while (file_exists($file_name));

		echo "</div>\n";
	}
}

?>
