<html>
	<head>
		<title> Предварительные результаты экзаменов в КФ МГУ 2018.</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	</head>
	<link href='exam_style.css?ver=2018-07-23' rel='stylesheet' type='text/css' >
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
	?>
	<body>
		<div align='center'>
		<div align='center' class='row_failed brd'>
		<h3>
			Данная таблица не является официальным списком приёмной комиссии.<br/>
			Официальные результаты будут опубликованы на сайте <a href="http://msu.kz">msu.kz</a>
		</h3>
		</div>
		</div>

		<div align='center'>
		<div align='center' class='brd'>
		<h3>
			<a href="result_names.php?"> Результаты по предметам с фамилиями </a>
		</h3>
		</div>
		</div>

		<div align='center'>
		<div align='left' class='brd <?php echo $user_agent_type;?>'>
			<span class='row_top'>Абитуриенты</span> входят в топ без учета резервистов. <br/>
			<span class='row_reserved'>Абитуриенты</span> могли писать в резервный день. <br/>
			<span class='row_failed'>Абитуриенты</span> точно не проходят по данному направлению. <br/> <br/>
			<span class='arrow_up'>&#9650;</span> 
			Вы можете подняться в таблице за счет абитуриентов, которые прошли на другие направления или отказались. <br/>
			<span class='arrow_down'>&#9660;</span> 
			Вы можете спуститься в таблице за счет <span class='row_reserved'>абитуриентов</span>, которые имели возможность сдать в резерный день. <br/>
		</div>
		</div>

		<?php
			echo "<div align='center'>\n";
			set_buttons("Направление", $subjects_mask, $user_agent_type, "result.php");
			set_form("Последние 5 цифр пропуска", $subjects_mask, $limit, $id, $user_agent_type, "result.php#selected");
			echo "</div>\n";
		?>
		<?php
			if ($subjects_mask != "") {
				$subjects_char_index = str_split($subjects_mask);
				$merged_table = sort_by_sum(merge(get_multi_tables($subjects_char_index, $data_file_result)));
				$tops = get_top('top', $data_file_top);
				$header = get_merged_table_header($subjects_char_index, $subject_name, array("Место", "Пропуск"), array("Сумма", "В топе"));
				$merged_table = append_top_and_status_colomns($merged_table, $limit, $tops, $faculties_name_for_top);
				output_merged_table($merged_table, $header, $user_agent_type, $id, "_big");
			}
		?>
	</body>
</html>