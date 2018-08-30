<?php

function print_header($text) {
	echo "<div align='center'>\n";
	echo "<h2>\n";
	echo "$text\n";
	echo "</h2>\n";
	echo "</div>\n";
}

function print_text($text) {
	echo "<div align='center'>\n";
	echo "<h3>\n";
	echo "$text\n";
	echo "</h3>\n";
	echo "</div>\n";
}

function print_buttons($link, $selected_key, $buttons, $options) {
	echo "<div align='center'>\n";
	echo "<div class='buttons_div'>\n";
	foreach ($buttons as $key => $text) {
		$is_selected = "";
		if (strval($key) === $selected_key)
			$is_selected = " selected";
		if ($options == "vertical")
			echo "<div class='buttons_div'>\n";
		echo "<a class='button $is_selected $options' href='$link=$key'>$text</a> \n";
		if ($options == "vertical")
			echo "</div>\n";
	}
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

function show_link_file($header, $file, $button_text) {
	if (file_exists($file.".pdf")) 
	{
		echo "<div align='center'>\n";
		echo "<span>\n";
		echo "<a class='button' href='$file.tex' download> $header $button_text (.tex) </a>";
		echo "</span>\n";
		echo "<span>\n";
		echo "<a class='button' href='$file.pdf' download> $header $button_text (.pdf) </a>";
		echo "</span>\n";
		echo "</div>\n";
	}
}

function show_png_file($file) {
	if (file_exists($file.".png")) {
		echo "<div align='center'>\n";
		echo "<span>\n";
		echo "<img src='$file.png'>";
		echo "</span>\n";
		echo "</div>\n";
	}
	else if (file_exists($file."-0.png")) {
		echo "<div align='center'>\n";
		$part = 0;
		$file_name = $file."-".$part.".png";
		do {
			echo "<div>\n";
			echo " <img src='$file_name'>\n";
			echo "</div>\n";
			$part += 1;
			$file_name = $file."-".$part.".png";
		} while (file_exists($file_name));

		echo "</div>\n";
	}
}

?>
