<html>
	<head>
		<title> Предварителные результаты экзаменов.</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	</head>
	<body>
		<link href='msu_exam/style.css' rel='stylesheet' type='text/css' >
		<?php
			include_once "msu_exam/routine.php";
			include_once "msu_exam/frontend.php";			
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
		<p align='center' class='<?php echo $user_agent_type;?>'>
			Данные по отдельным предметам взяты с официального сайта <a href="http://msu.kz">msu.kz</a>. <br/>
			Сводные данные не являются официальным списком приёмной комиссии. <br/>
		</p>
	
		<form action="result.php#selected" method="GET">
		<input type="hidden" name="sub" value="<?php echo $subjects_mask;?>" /> 
		<input type="hidden" name="lim" value="<?php echo $limit;?>" /> 
			
		<p align='center'>
			<table class='<?php echo $user_agent_type;?>'>
			<tr><td><span class='row_top'>Абитуриенты</span></td> <td>входят в топ без учета резервистов. </td></tr>
			<tr><td><span class='row_reserved'>Абитуриенты</span></td> <td> могут подняться по списку по результатам резервного дня. </td></tr>
			<tr><td><span class='row_failed'>Абитуриенты</span></td> <td> точно не проходят по данному направлению. </td></tr>
			<tr><td><span class='row_selected'>Абитуриент</span></td> <td> по 5 последним цифрам пропуска 
				<input type="number" name="id" min="10000" max="99999" maxlength="3" value="<?php echo $id;?>"  class='c<?php echo $user_agent_type;?>'/> 
				<input type="submit" value="выбрать"  class='c<?php echo $user_agent_type;?>'/> 
			</td></tr>
			</table>
		</p>
		</form>.
		<?php	
			set_buttons("", $user_agent_type, "result.php");

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