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
			<a href="result_names.php?"> Бакалавры </a>
		</h3>
		</div>
		</div>

		<div align='center'>
		<div align='left' class='brd <?php echo $user_agent_type;?>'>
			<span class='row_top'>Абитуриенты</span> входят в топ без учета резервистов. <br/>
		</div>
		</div>

		<?php
			$multi_table = array();
			$multi_table[0] = file_to_array('magi/et.txt');
			$multi_table[1] = file_to_array('magi/eng.txt');
			$merged_table = sort_by_sum(merge_all($multi_table));
			
			# work 2
			$merged_table =	set_status($merged_table, 
										16,
										"");
			$merged_table = unshift_position_colomn($merged_table);

			output_merged_table($merged_table, 
								array('Позиция', 'ФИО', 'ЭТ', 'АНГЛ', 'ИТОГ'),
								$user_agent_type,
								array(1), "extra_wide_colomn");
		?>
	</body>
</html>