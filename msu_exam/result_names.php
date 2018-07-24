<html>
	<head>
		<title> Предварительные результаты экзаменов в КФ МГУ 2018.</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	</head>
	<link href='exam_style.css?ver=2018-07-24-1' rel='stylesheet' type='text/css' >
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
			<?php
				$page = "result.php";
				$attributes .= "?id=".$id;
				$attributes .= "&sub=".$subjects_mask;
				$attributes .= "&lim=".$limit; 
				echo "<a href='".$page.$attributes."'>";
				echo "Результаты по предметам с шифрами";
				echo "</a>\n";
			?>
		</h3>
		</div>
		</div>

		<div align='center'>
		<div align='left' class='brd <?php echo $user_agent_type;?>'>
			<span class='row_failed'> Абитуриенты, </span> попавшие на границу с равными баллам, должны уточнять информацию в приёмной комиссии.<br/>
			<span class='row_reserved'> Абитуриенты, </span> прошедшие на несколько направлений, должны выбрать одно.<br/>
			Окончательные списки будут содержать по одной фамилии в каждом списке.<br/>
		</div>
		</div>
		
		<?php
			echo "<div align='center'>\n";
			set_buttons("Направление", $subjects_mask, $user_agent_type, "result_names.php");
			echo "</div>\n";
		?>
		<?php
			if ($subjects_mask != "") {
				$faculty = $data_file_top[$subjects_mask];

				# input
				$multi_table = split_top(get_top('final', $data_file_top));				
				# work 2
				$merged_table = append_final_comment_colomn($multi_table, 
												$faculty, 
												$faculties_limits, 
												$faculties_name_for_top);
				$merged_table = set_final_status($merged_table, $limit);
				$merged_table = unshift_position_colomn($merged_table);
				
				# output				
				$header = array("Место", "Фамилия", "Имя", "Балл", "Может выбрать");
				$wide_colomns = array(1, 2, 4);
				output_merged_table($merged_table, 
									$header, 
									$user_agent_type, 
									$wide_colomns,
									"wide_colomn");
			}
		?>
	</body>
</html>