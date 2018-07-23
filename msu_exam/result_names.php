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
			<a href="result.php?"> Результаты по предметам с шифрами </a>
		</h3>
		</div>
		</div>

		<div align='center'>
		<div align='left' class='brd <?php echo $user_agent_type;?>'>
			<span class='row_failed'> Абитуриенты </span> попавшие на границу с равными баллам должны уточнять информацию в приёмной комиссии<br/>
		</div>
		</div>
		
		<?php
			echo "<div align='center'>\n";
			set_buttons("Направление", $subjects_mask, $user_agent_type, "result_names.php");
			echo "</div>\n";
		?>
		<?php
			if ($subjects_mask != "") {
				$merged_table = split_top(get_top('final', $data_file_top));
				$faculty = $data_file_top[$subjects_mask];
				$current_table = append_final_top($merged_table, $limit, $faculty, $faculties_limits, $faculties_name_for_top);
				$header = array("Место", "Фамилия", "Имя", "Балл", "Может выбрать");
				output_merged_table($current_table, $header, $user_agent_type, "", "");
			}
		?>
	</body>
</html>