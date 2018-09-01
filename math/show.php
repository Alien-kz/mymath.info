<html>
	<head>
		<title>Студенческие олимпиады по математике.</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<link href='table.css?ver=2018-08-30-1' rel='stylesheet' type='text/css' >
		<link href='../main.css?ver=2018-08-30-1' rel='stylesheet' type='text/css' >
	</head>
	<body>
		<div class="header">
			<a class="button" href="../index.html"> Главная </a>
			<a class="button" href="../abiturient/show.php"> Абитуриентам </a>
			<a class="button selected" href="show.php"> Олимпиады по математике </a>		
			<a class="button" href="../books/show.php"> Книги </a>
		</div>

		<?php
			include_once "table.php";
			include_once "../routine/html.php";
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
			
			print_header("Студенческие олимпиады по математике.");
			print_buttons("show.php?olymp", 
							$olymp, 
							array("msu" => "КФ МГУ",
									"republic" => "Республиканская", 
									"imc" => "IMC"),
							"colomns3");
			
			if ($olymp == "republic" or $olymp == "msu" or $olymp == "imc") {
				$buttons = array();
				$directory = $olymp;
				# print header and genearate year buttons
				if ($olymp == "msu") {
					print_header("Открытая студенческая олимпиада");
					print_header("Казахстанского филиала МГУ по математике.");
					for ($y = 2008; $y <= 2017; $y++) {
						$buttons[strval($y)] = $y." год";
					}
					$buttons['2014-train'] = "2014 год (тренировка)";
					$buttons['2018-train'] = "2018 год (тренировка)";
					$needles = array("1" => "gold", 
									"2" => "silver", 
									"3" => "bronze");

				}
				if ($olymp == "republic") {
					print_header("Республиканская студенческая олимпиада");
					print_header("'Математика' и 'МКМ'.");
					for ($y = 2014; $y <= 2018; $y++) {
						$buttons["math-".strval($y)] = "Матем ".$y;
					}
					for ($y = 2014; $y <= 2018; $y++) {
						$buttons["mcm-".strval($y)] = "МКМ ".$y;
					}
					$needles = array("1" => "gold", 
									"2" => "silver", 
									"3" => "bronze");
				}
				if ($olymp == "imc") {
					print_header("Международная студенческая олимпиада");
					print_header("International Mathematics Competition.");				
					for ($y = 2013; $y <= 2018; $y++) {
						$buttons[strval($y)] = $y." год";
					}
					$needles = array("First" => "gold", 
									"Second" => "silver", 
									"Third" => "bronze");
				}
				
				# print about button and year buttons
				if ($year == "about") {
					print_buttons("show.php?olymp=$olymp&year", $year, array("" => "Скрыть ..."), "colomns3");
					print_text(file_get_contents($directory."/about.txt")); 
				} else {
					print_buttons("show.php?olymp=$olymp&year", $year, array("about" => "Подробнее об олимпиаде ..."), "colomns3");
				}
				print_header("Выберите год");
				print_buttons("show.php?olymp=$olymp&year", $year, $buttons, "colomns5");

				if ($year != "" and $year != "about") {
					print_centered_text("Материалы олимпиады");
					if ($olymp == "imc") {
						$site = "http://imc-math.org.uk";
						$results_link = $site."/index.php?year=$year&item=results";
						$problems_link = $site."/index.php?year=$year&item=problems";
						if ($year == "2018") {
							$site = "http://imc-math.ddns.net";
							$results_link = $site."/?show=results";
							$problems_link = $site."/?show=day1";
						}					

						print_centered_text("<a href='$problems_link'>Задачи</a>.");
						print_centered_text("<a href='$results_link'>Результаты</a>.");
					} else {
						show_link_file("$directory/problems/$olymp-$year-problems", "Задачи ".$buttons[$year]);
						show_link_file("$directory/solutions/$olymp-$year-solutions", "Решения ".$buttons[$year]);
						show_link_file("$directory/results/$olymp-$year-results", "Результаты ".$buttons[$year]);
						show_png_file("$directory/problems/$olymp-$year-problems");
					}

					
					$table = get_table_from_file("$directory/results/$olymp-$year-results.txt");
					if (!strstr($year, "train")) {
						$table = replace_prize_text($table, 
													count(current($table)) - 1, 
													False,
													True,
													$needles);
					}
					print_table($table);
					
					if ($olymp == "imc") {
						print_centered_text("Команды из Казахстана");
						$table = get_table_from_file("$directory/results/$olymp-$year-teams.txt");
						$table = replace_prize_text($table, 
													count(current($table)) - 2, 
													True,
													True,
													$needles);
						print_table($table);
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

