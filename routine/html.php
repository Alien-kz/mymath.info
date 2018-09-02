<?php

function get_user_agent_type() { 
	if (preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]))
		return 'mobile';
	return 'desktop';
}

function div_open($text) {
	echo "<div align='center'>";
	echo "<div class='content_div'>";
	print_header($text);
}

function div_close() {
	echo "</div>";
	echo "</div>";
}

function print_header($text) {
	echo "<div align='center'>\n";
	echo "<p>$text</p>\n";
	echo "</div>\n";
}

function print_centered_text($text) {
	echo "<div align='center'>\n";
	echo "<div class='text_div'>\n";
	echo "$text\n";
	echo "</div>\n";
	echo "</div>\n";
}

function replace_level($text) {
	$text = str_replace("+++", "<span class='green'>&#10102;</span>", $text);
	$text = str_replace("++-", "<span class='yellow'>&#10103;</span>", $text);
	$text = str_replace("+--", "<span class='red'>&#10104;</span>", $text);
	return $text;
}

function print_text($text) {
	$text = nl2br($text);
	$text = str_replace("<a ", "<a class='button external_link' target='blank_' ", $text);
	echo "<div align='left'>\n";
	echo $text."\n";
	echo "</div>\n";
}

function print_buttons($link, $selected_key, $buttons, $options, $anchor) {
	echo "<div align='center'>\n";
	echo "<div class='buttons_div'>\n";
	foreach ($buttons as $key => $text) {
		$is_selected = "";
		if (strval($key) === $selected_key)
			$is_selected = " selected";
		if ($options == "vertical")
			echo "<div class='buttons_div'>\n";
		echo "<a class='button $is_selected $options' href='$link$key$anchor'>$text</a> \n";
		if ($options == "vertical")
			echo "</div>\n";
	}
	echo "</div>\n";
	echo "</div>\n";
}

function print_select_buttons($link, $key_name, $selected_key, $buttons, $defaults_keys, $anchor) {
	echo "<div align='center'>\n";
	echo "<form action='$link' method='get'>";
	echo "<select class='button colomns5' name='$key_name' autofocus>";
	
	foreach ($buttons as $key => $text) {
		$is_selected = "";
		if (strval($key) === $selected_key)
			$is_selected = " selected";
		echo "<option class='$is_selected' $is_selected value='$key'> $text </option> \n";
	}
	echo "</select>";
	foreach ($defaults_keys as $key => $value) {
		echo "<input type='hidden' name='$key' value='$value'>\n";
	}
	echo "<input class='button colomns5' type='submit' value='выбрать'>\n";
	echo "</form>\n";
	echo "</div>\n";
}
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
		echo "<a class='button' href='$file.tex' download> $link_text (.tex) </a>";
		echo "</span>\n";
		echo "<span>\n";
		echo "<a class='button' href='$file.pdf' download> $link_text (.pdf) </a>";
		echo "</span>\n";
		echo "</div>\n";
	}
}

function show_png_file($file) {
	if (file_exists($file.".png")) {
		div_open();
		echo "<div align='center' class='image_div'>\n";
		echo "<img class='image_fit' src='$file.png'>";
		echo "</div>\n";
		div_close();
	}
	else if (file_exists($file."-0.png")) {
		echo "<div align='center'>\n";
		div_open();
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
		div_close();
	}
}

?>
