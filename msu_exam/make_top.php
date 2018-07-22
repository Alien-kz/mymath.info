<html>
	<head>
		<title> Предварителные результаты экзаменов.</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	</head>
	<link href='exam_style.css?ver=2018-07-22-5' rel='stylesheet' type='text/css' >
	<?php
		include_once "routine.php";
		include_once "frontend.php";			
		$user_agent_type = get_user_agent_type();
		$id = 0;
		if (!empty($_GET["id"]))
			$id = intval($_GET["id"]);

		$subjects_mask = "";
		if (!empty($_GET["sub"]))
			$subjects_mask = $_GET["sub"];

		$limit = 0;
		if (!empty($_GET["lim"]))
			$limit = intval($_GET["lim"]);

		$clear = (!empty($_GET["clear"])) && ($_GET["clear"]);
		if ($clear) {
			foreach ($data_file_top as $faculty) {
				file_put_contents("top/$faculty.txt", "", LOCK_EX);
			}
		}
	?>
	<body class='<?php echo $user_agent_type;?>'>
		<link href='exam_style.css?ver=2018-07-22-2' rel='stylesheet' type='text/css' >
		<p align="center">
			<table>
			<tr><td>
				<table>
				<tr><td>m</td><td>математика </td></tr>
				<tr><td>r</td><td>русский язык </td></tr>
				<tr><td>e</td><td>английский язык </td></tr>
				<tr><td>p</td><td>физика </td></tr>
				<tr><td>g</td><td>география </td></tr>
				<tr><td>l</td><td>литература </td></tr>
				</table>
			</td>
			<td>
				<table class='<?php echo $user_agent_type;?>'>
				<tr><td><span class='row_top'>Абитуриенты</span></td> <td>входят в топ без учета резервистов. </td></tr>
				<tr><td><span class='row_reserved'>Абитуриенты</span></td> <td> могли писать в резервный день. </td></tr>
				<tr><td><span class='row_failed'>Абитуриенты</span></td> <td> точно не проходят по данному направлению. </td></tr>
				</table>
			</td></tr>
			</table>
		</p>
		<?php	
			echo "<div align='center'>\n";
			set_buttons("Направление", $subjects_mask, $user_agent_type, "result.php");
			set_buttons("Закешировать топ", $subjects_mask, $user_agent_type, "make_top.php");
			set_simple_button("Очистить все топы", $user_agent_type, "make_top.php");
			echo "</div>\n";

			if ($subjects_mask != "") {
				$subjects_char_index = str_split($subjects_mask);
				$merged_table = sort_by_sum(merge(get_multi_tables($subjects_char_index, $data_file_result)));
				if (!empty($data_file_top[$subjects_mask]) && !$clear) {
					write_top($merged_table, $limit, $data_file_top[$subjects_mask]);
				}
				$tops = get_top($data_file_top);
				$header = get_merged_table_header($subjects_char_index, $subject_name, array("Место", "Пропуск"), array("Сумма", "В топе"));
				$merged_table = append_top_and_status_colomns($merged_table, $limit, $tops, $faculties_name_for_top);
				output_merged_table($merged_table, $header, $user_agent_type, $id);
			}
		?>
	</body>
</html>

