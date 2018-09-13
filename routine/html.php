<?php

function load_css($prefix, $css_array, $agent) {
	$ver = "2018-09-13";
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

function print_text($text) {
	$text = preg_replace("/[\r\n]+/", "\n", $text);
	$text = str_replace("<table>\n", "<table align='center' border='1'>", $text);
	$text = str_replace("</table>\n", "</table>", $text);
	$text = str_replace("<tr>\n", "<tr>", $text);
	$text = str_replace("</tr>\n", "</tr>", $text);
	$text = str_replace("<h3>\n", "<h3>", $text);
	$text = str_replace("</h3>\n", "</h3>", $text);
	$text = str_replace("<a ", "<a class='button external_link' target='blank_' ", $text);
	$text = preg_replace("/<picture (.*?)>/", "<div align='center'><img class='resized' src=$1></div>", $text);
	$text = preg_replace("/<file (.*?)>/", "<a class='button download_link' target='blank_' href=$1> &#128190;", $text);
	$text = str_replace("</file>", "</a>", $text);

	$text = nl2br($text);
	echo "<div align='left'>\n";
	echo $text."\n";
	echo "</div>\n";
}

function print_code($text) {
	$text = nl2br($text);
	$text = str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;", $text);
	$text = "<div align='center'><div class='code'>".$text."</div></div>";
	echo $text;
}

function print_text_with_code($text) {
	$text = str_replace("<code>\n", "<div align='center'><div class='code'>", $text);
	$text = str_replace("</code>\n", "</div></div>", $text);
	$text = str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;", $text);
	print_text($text);
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
