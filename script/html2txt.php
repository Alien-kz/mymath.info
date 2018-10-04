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
	$output = preg_replace("/<tr.*?>/", "", $output);			#remove <tr>
	$output = preg_replace("/<\/(tr|thead)>/", "\n", $output);	#replace </tr> or </thead> to newline
	$output = preg_replace("/<(td|th).*?>/", "", $output);		#remove <td> and <th>
	$output = preg_replace("/<\/(td|th)>/", "\t", $output);		#replace </td> to tabulation
	$output = str_replace("<s>", " (", $output);				#replace <s> to ( - team members start
	$output = str_replace("</s>", ")", $output);				#replace </s> to ) - team members fin
	$output = preg_replace("/<.+?>/", "", $output);				#remove all tags

	$output = str_replace("\t\n","\n", $output);
	$output = str_replace("\n\n","\n", $output);
	$output = str_replace("  "," ", $output);
	return $output;
}
?>
