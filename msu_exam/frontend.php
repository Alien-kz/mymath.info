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

function output_merged_table($merged_table, $header, $user_agent_type, $selected_id) {
	echo "<p align='center'>\n";
	echo "<table class='jewel ".$user_agent_type."'>\n";
	
	echo "<tr>";
	foreach ($header as $head) {
			echo "<th>".$head."</th>";
	}
	echo "</tr>\n";

	$position = 0;
	foreach ($merged_table as $row) {
		$position += 1;
		$size = $row['size'];

		echo "<tr class='".$row['status']."'>";
		$cell_color = "";
		if ($row[0] == $selected_id) {
			$cell_color = "class='row_selected'"; 
			echo "<td>".$position."<a name='selected'></a></td>";
		} else {
			echo "<td>".$position."</td>";
		}

		for ($i = 0; $i < $size; $i++) {
			echo "<td ".$cell_color.">".$row[$i]."</td>"; 
		}
		echo "</tr>\n";
	}
	echo "</table>\n";
	echo "</p>\n";
}

function set_button($subjects_keys, $limit, $faculty, $user_agent_type, $page, $subjects_mask) {
	$id = "00000";
	if (!empty($_GET["id"]))
		$id = $_GET["id"];
	$class = "c".$user_agent_type;
	if ($subjects_mask == $subjects_keys)
		$class .= " selected";
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
		echo "<p align='center'>\n";
	}
}

function set_form($header, $subjects_mask, $limit, $id, $user_agent_type, $page) {
	$class="c$user_agent_type row_selected";
	echo "<h2 align='center'>".$header."</h2>\n";
	echo "<form action='$page' method='GET'>\n";
	echo "<p align='center'>\n";
	echo "<input type='hidden' name='sub' value='$subjects_mask'/>\n"; 
	echo "<input type='hidden' name='lim' value='$limit'/>\n"; 
	echo "<input type='number' name='id' min='10000' max='99999' value='$id' class='$class'/>\n";
	echo "<input type='submit' value='найти' class='$class'/>\n";
	echo "</p>\n";
	echo "</form>\n";
}

function set_buttons($header, $subjects_mask, $user_agent_type, $page) {
	echo "<h2 align='center'>".$header."</h2>";
	echo "<p align='center'>\n";
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
}

?>