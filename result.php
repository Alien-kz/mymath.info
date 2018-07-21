<html>
	<head>
		<title> Предварителные результаты экзаменов.</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	</head>
	<body>
		<link href='msu_exam/style.css' rel='stylesheet' type='text/css' >
		<p align="center">
			Данные по отдельным предметам взяты с официального сайта <a href="http://msu.kz">msu.kz</a>. <br/>
			Сводные данные не являются официальным списком приёмной комиссии. <br/>
			Не забывайте, что некоторые абитуриенты теоретически могут сдавать экзамен в резервный день <span style="background:Aquamarine">(выставлен 1 балл)</span>. <br/>
			Попадание в топ на специальность "Математика" не означает, что абитуриент реально поступает на указанное направление.  <br/>
		</p>
		<p align="center">
			Чтобы подсветить отдельный пропуск, замените нули id=00000 на последние пять цифр пропуска. <br/>
		</p>
		<?php
			include_once "msu_exam/routine.php";
			include_once "msu_exam/frontend.php";
			
			$user_agent_type = get_user_agent_type();
			$limit = 0;
			if (!empty($_GET["lim"]))
				$limit = intval($_GET["lim"]);

			$id = 0;
			if (!empty($_GET["id"]))
				$id = intval($_GET["id"]);
	
			$subjects_mask = "";
			if (!empty($_GET["sub"]))
				$subjects_mask = $_GET["sub"];
			
			set_buttons("Выберите направление", $user_agent_type, "result.php");

			if ($subjects_mask != "") {
				$subjects_char_index = str_split($subjects_mask);
				$merged_table = sort_by_sum(merge(get_multi_tables($subjects_char_index, $data_file_result)));
				$tops = get_top($data_file_top);
				$header = get_merged_table_header($subjects_char_index, $subject_name, array("Место", "Пропуск"), array("Сумма", "В топе"));
				$merged_table = append_top_and_status_colomns($merged_table, $limit, $tops, $faculties_name_for_top);
				output_merged_table($merged_table, $header, $user_agent_type, $id);
			}
		?>
	</body>
</html>