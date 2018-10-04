<?php
function convert_tex_txt($input) {
	$output = $input."\n";
	$output = str_replace("$","", $output);
	$output = str_replace("\\Sigma","Итог", $output);
	$output = str_replace("&","\t", $output);
	$output = str_replace("\\\\","", $output);
	$output = preg_replace("/\\\\[^\n]*\n/", "", $output);
	$output = preg_replace("/%[^\n]*\n/", "", $output);
	$output = preg_replace("/#[^\n]*\n/", "", $output);
	$output = preg_replace("/{[^\n]*\n/", "", $output);
	$output = preg_replace("/}[^\n]*\n/", "", $output);
	$output = preg_replace('/^[ \t]*[\r\n]+/m', '', $output);
	$output = str_replace("\r","", $output);
	return $output;
}
?>
