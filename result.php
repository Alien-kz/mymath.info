<html>
	<head>
		<title> Предварителные результаты экзаменов.</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">  </head>
		<style>
		.c {
			border: 1px solid #333; /* Рамка */
			display: inline-block;
			padding: 5px 15px; /* Поля */
			text-decoration: none; /* Убираем подчёркивание */
			color: #000; /* Цвет текста */
		}
		.c:hover {
			box-shadow: 0 0 5px rgba(0,0,0,0.3); /* Тень */
			background: linear-gradient(to bottom, #fcfff4, #e9e9ce); /* Градиент */
			color: #a00;
		}
		.mobile {
			font-size: 24pt;
		}
		.desktop {
			font-size: 11pt;
		}
		.jewel {
			border: 1px solid #000; /* Рамка вокруг таблицы */
			border-collapse: collapse;
		}
		.selected {
			font-weight: bold;
			background: #693;
		}
		.jewel th {
			background: #666;
			color: #fff;
		}
		.jewel td, .jewel th { 
			padding: 3px; /* Поля вокруг текста */
			text-align: center; /* Выравнивание по центру */ 
			border: 1px solid #000;
		}
		.jewel td, .jewel th { 
			width: 50pt; /* Ширина таблицы */
		}
		</style>
	</head>
	<body>
		<p align="center">
			Данные по отдельным предметам взяты с официального сайта <a href="http://msu.kz">msu.kz</a>. <br/>
			Сводные данные не являются официальным списком приёмной комиссии. <br/>
			Не забывайте, что некоторые абитуриенты сдают экзамен в резервный день. <br/>
			Попадание в топ не означает, что абитуриент реально поступает на указанное направление.  <br/>
		</p>
			<?php
				function is_mobile() { 
					return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
				}
				function file_to_array($filename)
				{
					$rows = file($filename);
					$result = array();
					foreach($rows as $value)
					{
						$str = explode("\t", $value);
						$ident = intval($str[0]);
						$point = intval($str[1]);
						if ($ident != 0)
							$result[ $ident ] = $point;
					}
					return $result;
				}

				function print_full_table($multiarray, $header, $limit, $id, $tops, $faculties_name)
				{
					echo "<p align='center'>\n";
					if(is_mobile()){
						echo "<table class='jewel mobile'>\n";
					} else {
						echo "<table class='jewel desktop'>\n";
					}
					
					echo "<tr><th>Место</th>";
					foreach ($header as $head) {
						 echo "<th>".$head."</th>";
					}
					echo "<th>В топе</th>";
					echo "</tr>\n";

					$position = 0;
					foreach ($multiarray as $row) {
						$position += 1;
						if ($position <= $limit) {
							echo "<tr bgcolor='silver'><td>".$position."</td>";
						} else { 
							echo "<tr><td>".$position."</td>";
						}
						foreach ($row as $point) {
							if ($row[0] == $id)
								echo "<td class='selected'>".$point."</td>";
							else
								echo "<td>".$point."</td>"; 
						}
						$appendix = "<td>";
						$alt = "";
						foreach ($tops as $faculty => $thetop) {
							if (in_array($row[0], $thetop)){
								$alt.=$faculties_name[$faculty]."<br/>";
							}
						}
						$appendix .= "$alt</tr>\n";
						echo $appendix;
					}
					echo "</table>\n";
					echo "</p>\n";
				}

				function write_top($multiarray, $limit, $faculty) {
					$position = 0;
					$ids = "";
					foreach ($multiarray as $row) {
						$position += 1;
						if ($position <= $limit) {
							$ids .= $row[0]."\n";
						}
					}
					file_put_contents("top/$faculty.txt", $ids, LOCK_EX);
				}
				
				function get_top($faculties) {
					$answer = array();
					foreach ($faculties as $faculty) {
						if (!file_exists("top/$faculty.txt"))
							continue;
						$top_array = file("top/$faculty.txt");
						if ($top_array != false)
							$answer[$faculty] = $top_array;
					}
					return $answer;
				}
				
				function merge($multiarray, $multiarraysize) {
					$result = array();
					foreach ($multiarray as $value) {
						$result = $result + $value;
					}
					foreach ($result as $ident => $value) {
						$result[ $ident ] = array_fill(0, $multiarraysize + 2, 0);
						$result[ $ident ][0] = $ident;

						$sum = 0;
						$fail = false;
						foreach ($multiarray as $index => $subject) {
							if (array_key_exists($ident, $subject)) {
								$result[ $ident ][ $index + 1 ] = $subject[ $ident ];
								if ($subject[ $ident ] <= 2)
									$fail = true;								
								$sum += $subject[ $ident ];
							}
							if ($fail)
								$sum = 0;
							$result[ $ident ][$multiarraysize + 1] = $sum;
							
						}
					}
					return $result;
				}
				
				function sort_by_sum($multiarray, $multiarraysize) {
					$total_sum = array();
					foreach($multiarray as $point) {
						array_push($total_sum, $point[$multiarraysize + 1]);
					}
					array_multisort($total_sum, SORT_DESC, $multiarray);
					return $multiarray;
				}
				
				$type = "";
				if(is_mobile()){
					$type = 'mobile';
				} else {
					$type = 'desktop';
				}
				$id = "&id=00000";
				if (!empty($_GET["id"]))
					$id = "&id=".$_GET["id"];

				$faculties = array('mrp' => 'vmk',
								 'mr' => 'mm',
								 'mre' => 'econom',
								 'mrg' => 'geo',
								 'erl' => 'phyl');
				$faculties_name = array('vmk' => 'Прикл.математика...',
								 'mm' => 'Математика',
								 'econom' => 'Экономика',
								 'geo' => 'Экология...',
								 'phyl' => 'Филология');

				echo "<p align='center'>\n";
				echo "<a href='result.php?sub=mrp&lim=27$id' class='c ".$type."'>Прикладная математика и информатика</a> \n";
				echo "<a href='result.php?sub=mr&lim=25$id' class='c ".$type."'>Математика</a>\n";
				echo "</p>\n";
				echo "<p align='center'>\n";
				echo "<a href='result.php?sub=mre&lim=27$id' class='c ".$type."'>Экономика</a> \n";
				echo "<a href='result.php?sub=mrg&lim=26$id' class='c ".$type."'>Экология и природопользование</a>\n";
				echo "</p>\n";
				echo "<p align='center'>\n";
				echo "<a href='result.php?sub=erl&lim=20$id' class='c ".$type."'>Филология</a>\n";
				echo "</p>\n";
				$identifier = "Пропуск";
				$total = "Сумма";
				$subject = array( 'm' => "Математика",
								  'e' => "Иностранный язык",
								  'r' => "Русский язык",
								  'p' => "Физика",
								  'g' => "География",
								  'l' => "Литература");
				$datafile = array( 'm' => "math",
								  'e' => "eng",
								  'r' => "rus",
								  'p' => "phys",
								  'g' => "geo",
								  'l' => "liter");
				if (!empty($_GET["sub"])) {
					$superkey = str_split($_GET["sub"]);
					$data = array();
					foreach ($subject as $key => $value) {
						if (in_array($key, $superkey)) {	
							$file = $datafile[$key];
							$subj = $subject[$key];
							$data[$key] = file_to_array('data/'.$file.'.txt');
							$header = array($identifier, $subj);
						}
					}
					
					$multiarray = array();
					$header = array($identifier);
					$multiarraysize = 0;
					foreach ($subject as $key => $value) {
						if (in_array($key, $superkey)) {	
							array_push($multiarray, $data[$key]);
							array_push($header, $subject[$key]);
							$multiarraysize += 1;
						}
					}
					array_push($header, $total);					
					$merged_table = merge($multiarray, $multiarraysize);
					$merged_table = sort_by_sum($merged_table, $multiarraysize);
					$limit = 0;
					if (!empty($_GET["lim"]))
						$limit = intval($_GET["lim"]);
					$id = 0;
					if (!empty($_GET["id"]))
						$id = intval($_GET["id"]);
					
					$tops = get_top($faculties);
					print_full_table($merged_table, $header, $limit, $id, $tops, $faculties_name);
					
					if (!empty($_GET["top"])) {
						$subject_mask = $_GET["sub"];
						if (!empty($faculties[$subject_mask])) {
							write_top($merged_table, $limit, $faculties[$subject_mask]);
						}
					}
				}
			?>
		<p align="center">
			Чтобы подсветить отдельный пропуск, замените нули id=00000 на последние пять цифр пропуска. <br/>
		</p>
		<p>
			Используйте ключи: <br/>
			m - математика <br/>
			r - русский язык <br/>
			e - английский язык <br/>
			p - физика <br/>
			g - география <br/>
			l - литература <br/>
			Например, для экзаменов по экономике: <br/>
			result.php?sub=mre
		</p>
	</body>
</html>

