<?php

function get_user_agent_type() { 
	if (preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]))
		return 'mobile';
	return 'desktop';
}

################################################################################
# $merged_table:
# id res1 res2 res3 ... resn sum alt
#
# $header:
# ('Пропуск', 'Математика', 'Русский', ...)
################################################################################

function output_merged_table($merged_table, $header, $user_agent_type, $selected_id, $_big) {
	echo "<div align='center'>\n";
	echo "<div class='brd'>\n";
	echo "<table border=1 class='jewel'>\n";
	echo "<thead>\n";
	echo "<tr class='".$user_agent_type."'>";
	foreach ($header as $head) {
			echo "<th>".$head."</th>";
	}
	echo "</tr>\n";
	echo "</thead>\n";

	echo "<tbody>\n";
	$position = 0;
	$width = $merged_table['size'];
	$height = count($merged_table) - 1;
	for ($i = 0; $i < $height; $i++) {
		$row = $merged_table[$i];
		$position = $i + 1;
		echo "<tr class='".$row['status']." ".$user_agent_type.$_big."'>";
		$cell_color = "";
		if ($row[0] == $selected_id) {
			$cell_color = "row_selected"; 
			echo "<td>".$position."<a name='selected'></a></td>";
		} else {
			echo "<td>".$position."</td>";
		}

		for ($j = 0; $j < $width; $j++) {
			echo "<td class='".$cell_color."'>".$row[$j]."</td>"; 
		}
		$append = "";
		if (!empty($row['top'])) {
			$append = $row['top'];
		}
		echo "<td class='".$cell_color." ".$user_agent_type."'>".$append."</td>";
		echo "</tr>\n";
	}
	echo "</tbody>\n";
	echo "</table>\n";
	echo "</div>\n";
	echo "</div>\n";
}

function set_button($subjects_keys, $limit, $faculty, $user_agent_type, $page, $subjects_mask) {
	$id = "00000";
	if (!empty($_GET["id"]))
		$id = $_GET["id"];
	$class = "c".$user_agent_type." ".$user_agent_type."_big";
	if ($subjects_mask == $subjects_keys)
		$class .= " selected";
	else
		$class .= " notselected";
	echo "<a href='".$page."?id=".$id."&sub=".$subjects_keys."&lim=".$limit."' class='$class'>".$faculty."</a> \n";
}

function set_simple_button($text, $user_agent_type, $page) {
	echo "<p align='center'>\n";
	set_button("0", "0&clear=true", $text, $user_agent_type, $page, "");
	echo "</p>\n";
}

function div_button($user_agent_type) {
	if ($user_agent_type == 'mobile') {
		echo "</p>\n";
		echo "<p>\n";
	}
}

function set_form($header, $subjects_mask, $limit, $id, $user_agent_type, $page) {
	echo "<div align='center' class='brd'>\n";
	$class = "c".$user_agent_type." ".$user_agent_type."_big selected";
	echo "<h3 align='center'>".$header."</h3>\n";
	echo "<p>\n";
	echo "<form action='$page' method='GET'>\n";
	echo "<input type='hidden' name='sub' value='$subjects_mask'/>\n"; 
	echo "<input type='hidden' name='lim' value='$limit'/>\n"; 
	echo "<input type='number' name='id' min='10000' max='99999' value='$id' class='$class'/>\n";
	echo "<input type='submit' value='найти' class='$class'/>\n";
	echo "</form>\n";
	echo "</p>\n";
	echo "</div>\n";
}

function set_buttons($header, $subjects_mask, $user_agent_type, $page) {
	echo "<div align='center' class='brd'>\n";
	echo "<h3 align='center'>".$header."</h3>\n";
	echo "<p>\n";
	set_button("mrp", "27", "Прикладная математика и информатика", $user_agent_type, $page, $subjects_mask);
	div_button($user_agent_type);
	set_button("mr", "25", "Математика", $user_agent_type, $page, $subjects_mask);
	div_button("mobile");
	set_button("mre", "27", "Экономика", $user_agent_type, $page, $subjects_mask);
	div_button($user_agent_type);
	set_button("mrg", "26", "Экология и природопользование", $user_agent_type, $page, $subjects_mask);
	div_button($user_agent_type);
	set_button("erl", "20", "Филология", $user_agent_type, $page, $subjects_mask);
	echo "</p>\n";
	echo "</div>\n";
}

?>