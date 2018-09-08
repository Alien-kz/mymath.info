<?php
function show_html($input) {
	$output = $input;
	$output = str_replace("<","&lt;", $output);
	$output = str_replace(">","&gt;", $output);
	return $output;
}
function html_results_crop($input) {
	$output = $input;
	$marker1 = stripos($output, '<table class="standings">');
	$marker2 = stripos($output, '<table border="0" cellspacing="0" cellpadding="1">');
	if($marker1) 
		$output = substr($output, $marker1);
	if($marker2) 
		$output = substr($output, $marker2);
	return $output;
}
function convert_html_txt($input) {
	$output = $input;
	
	$output = str_replace("\n","", $output);
	$output = str_replace("\r","", $output);
	$output = preg_replace("/<tr.*?>/", "", $output);
	$output = preg_replace("/<\/(tr|thead)>/", "\n", $output);
	$output = preg_replace("/<(td|th).*?>/", "", $output);
	$output = preg_replace("/<\/(td|th)>/", "\t", $output);
	$output = str_replace("<s>", " (", $output);
	$output = str_replace("</s>", ")", $output);
	$output = preg_replace("/<.+?>/", "", $output);

	$output = str_replace("\t\n","\n", $output);
	$output = str_replace("\n\n","\n", $output);
	$output = str_replace("  "," ", $output);
	return $output;
}
?>
