<html>
	<head>
		<title> Предварительные результаты экзаменов в КФ МГУ 2018.</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<link href='exam_style.css?ver=2018-07-25-3' rel='stylesheet' type='text/css' >
		<link href='../main.css?ver=2018-07-25-3' rel='stylesheet' type='text/css' >
	</head>
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
		<div class="header">
			<a class="button" href="../index.html"> Главная </a>
			<a class="button selected" href="result.php"> Экзамены в филиал 2018 </a>
			<a class="button" href="../math/show.php"> Олимпиады по математике </a>
			<a class="button" href="../books/show.php"> Книги </a>
		</div>
		
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
			<?php
				$page = "result_names.php";
				$attributes = "";
				$attributes .= "?id=".$id;
				$attributes .= "&sub=".$subjects_mask;
				$attributes .= "&lim=".$limit; 
				echo "<a href='".$page.$attributes."'>";
				echo "Результаты по предметам с фамилиями";
				echo "</a>\n";
			?>		</h3>
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
				
				# input
				$tops = get_top('top', $data_file_top);
				$multi_tables = get_multi_tables($subjects_char_index, $data_file_result);

				# work 1
				$merged_table = merge($multi_tables);
				$merged_table = sort_by_sum($merged_table);

				# work 2
				$merged_table =	set_status($merged_table, 
											$limit,
											$id);
				$merged_table = append_comment_colomn($merged_table, 
														$limit, 
														$tops, $faculties_name_for_top);
				$merged_table = unshift_position_colomn($merged_table);

				# output
				$header = get_merged_table_header($subjects_char_index,
												$subject_name, 
												array("Место", "Пропуск"),
												array("Сумма", "Может выбрать"));
				$wide_colomns = array(count($header) - 1);
				output_merged_table($merged_table, 
									$header, 
									$user_agent_type, 
									$wide_colomns,
									"wide_colomn");
			}
		?>
	</body>
</html>
