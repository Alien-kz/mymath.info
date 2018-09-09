<!doctype html>
<html>
	<head>
		<title>Студенческие олимпиады по математике.</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<?php
			include_once "../routine/html.php";
			include_once "../routine/table.php";
			$agent = get_user_agent_type();
			
			if ($agent == 'desktop') {
				echo "<link href='../css/table.css?ver=2018-09-09' rel='stylesheet' type='text/css' >";
				echo "<link href='../css/main.css?ver=2018-09-09' rel='stylesheet' type='text/css' >";
			} else {
				echo "<link href='../css/table_m.css?ver=2018-09-09' rel='stylesheet' type='text/css' >";
				echo "<link href='../css/main_m.css?ver=2018-09-09' rel='stylesheet' type='text/css' >";
			}
		?>
		
	</head>
	<body>
		<?php
			$buttons = get_main_buttons("../");
			print_buttons("", "../math/show.php", $buttons, "colomns_in_header", "");

			$olymp = "";
			if (isset($_GET["olymp"])) {
				$olymp = $_GET["olymp"];
			}
			$year = "";
			if (isset($_GET["year"])) {
				$year = strval($_GET["year"]);
			}
			
		?>
		
		<?php
			echo "<a name='type'></a>";
			div_open("Студенческие олимпиады по математике");
			print_buttons("show.php?olymp=", 
							$olymp, 
							array("msu" => "КФ МГУ",
									"republic" => "Республиканская", 
									"imc" => "IMC"),
							"colomns3",
							"#type");
			div_close();
			
			####################################################
							
			if ($olymp == "republic" or $olymp == "msu" or $olymp == "imc") {
				$buttons = array();
				$directory = $olymp;
				$header = "";
				if ($olymp == "msu") {
					$header = "Открытая студенческая олимпиада Казахстанского филиала МГУ по математике.";
					for ($y = 2008; $y <= 2017; $y++) {
						$buttons[strval($y)] = $y." год";
					}
					$buttons['2014-train'] = "2014 год (тренировка)";
					$buttons['2018-train'] = "2018 год (тренировка)";
					$needles = array("1" => "gold", 
									"2" => "silver", 
									"3" => "bronze");
					$year_colomn_width = "colomns5";
				}
				if ($olymp == "republic") {
					$header = "Республиканская студенческая олимпиада по направлениям 'Математика' и 'МКМ'.";
					$buttons["math-2006"] = "М 2006 год";
					for ($y = 2014; $y <= 2018; $y++) {
						$buttons["math-".strval($y)] = "Матем ".$y. " год";
					}
					for ($y = 2014; $y <= 2018; $y++) {
						$buttons["mcm-".strval($y)] = "МКМ ".$y." год";
					}
					$needles = array("1" => "gold", 
									"2" => "silver", 
									"3" => "bronze");
					$year_colomn_width = "colomns6";
				}
				if ($olymp == "imc") {
					$header = "Международная студенческая олимпиада International Mathematics Competition.";
					for ($y = 2013; $y <= 2018; $y++) {
						$buttons[strval($y)] = $y." год";
					}
					$needles = array("First" => "gold", 
									"Second" => "silver", 
									"Third" => "bronze");
					$year_colomn_width = "colomns6";
				}
				
				####################################################
				
				echo "<a name='header'></a>";
				div_open($header);
				if ($year == "about") {
					print_buttons("show.php?olymp=$olymp&amp;year=", $year, array("" => "Скрыть ..."), "colomns3", "#header");
					print_text(file_get_contents($directory."/about.txt")); 
				} else {
					print_buttons("show.php?olymp=$olymp&amp;year=", $year, array("about" => "Подробнее об олимпиаде ..."), "colomns3", "#header");

				}
				print_centered_text("Выберите год");
				if ($agent == "mobile")
					print_select_buttons("show.php", "year", $year, $buttons, array("olymp" => $olymp), "problems");
				else
					print_buttons("show.php?olymp=$olymp&amp;year=", $year, $buttons, $year_colomn_width, "#header");
				div_close();

				####################################################
				
				if ($year != "about" and $year != "") {
					echo "<a name='problems'></a>";
					div_open("Материалы олимпиады");
					if ($olymp == "imc") {
						$site = "http://imc-math.org.uk";
						$results_link = $site."/index.php?year=$year&amp;item=results";
						$problems_link = $site."/index.php?year=$year&amp;item=problems";
						if ($year == "2018") {
							$site = "http://imc-math.ddns.net";
							$results_link = $site."/?show=results";
							$problems_link = $site."/?show=day1";
						}
						$material_buttons = array($problems_link => "Задачи", $results_link => "Результаты");
						print_buttons_external($material_buttons, "colomns3");
					} else {
						show_link_file("$directory/problems/$olymp-$year-problems", "Задачи ".$buttons[$year]);
						show_link_file("$directory/solutions/$olymp-$year-solutions", "Решения ".$buttons[$year]);
						print_centered_text("Задачи");
						show_png_file("$directory/problems/$olymp-$year-$agent");
					}

					
					$table = get_table_from_file("$directory/results/$olymp-$year-results.txt");
					if (!strstr($year, "train")) {
						$marks = array();
						$table = replace_prize_text($table, 
													count(current($table)) - 1, 
													False,
													True,
													$needles,
													$marks);
					}
					div_close();
					
					if ($table) {
						div_open("Результаты");
						show_link_file("$directory/results/$olymp-$year-results", "Результаты ".$buttons[$year]);
						if ($olymp == "imc") {
							print_centered_text("Результаты участников из Казахстана");
							print_table($table);
							print_centered_text("Результаты команд из Казахстана");
							$table = get_table_from_file("$directory/results/$olymp-$year-teams.txt");
							$marks = array();
							$table = replace_prize_text($table, 
														count(current($table)) - 2, 
														True,
														True,
														$needles,
														$marks);
							print_table($table);
						} else {
							print_table($table);
						}
						echo "<a name='data_results'></a>";
						print_centered_text("Выберите год");
						print_buttons("show.php?olymp=$olymp&amp;year=", $year, $buttons, $year_colomn_width, "#data_results");
						div_close();
					}
				}
			}
		?>
		<p>
			<!-- Yandex.Metrika counter -->
			<script type="text/javascript" >
				(function (d, w, c) {
					(w[c] = w[c] || []).push(function() {
						try {
							w.yaCounter49639981 = new Ya.Metrika2({
								id:49639981,
								clickmap:true,
								trackLinks:true,
								accurateTrackBounce:true
							});
						} catch(e) { }
					});

					var n = d.getElementsByTagName("script")[0],
						s = d.createElement("script"),
						f = function () { n.parentNode.insertBefore(s, n); };
					s.type = "text/javascript";
					s.async = true;
					s.src = "https://mc.yandex.ru/metrika/tag.js";

					if (w.opera == "[object Opera]") {
						d.addEventListener("DOMContentLoaded", f, false);
					} else { f(); }
				})(document, window, "yandex_metrika_callbacks2");
			</script>
			<noscript><div><img src="https://mc.yandex.ru/watch/49639981" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
			<!-- /Yandex.Metrika counter -->
		</p>
	</body>
</html>

