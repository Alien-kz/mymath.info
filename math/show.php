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
			
			if ($olymp == "imc") {
				print_header("Казахстан на международной студенческой олимпиаде по математике <br/> IMC International Mathematics Competition (Болгария).");
				
				$buttons = array();
				for ($y = 2013; $y <= 2018; $y++) {
					$buttons[strval($y)] = $y." год";
				}
				print_buttons("show.php?olymp=imc&year", $year, $buttons, "colomns6");
				
				if ($year != "") {
					print_header("Материалы олимпиады");
					
					$site = "http://imc-math.org.uk";
					$results_link = $site."/index.php?year=$year&item=results";
					$problems_link = $site."/index.php?year=$year&item=problems";
					if ($year == "2018") {
						$site = "http://imc-math.ddns.net";
						$results_link = $site."/?show=results";
						$problems_link = $site."/?show=day1";
					}					

					print_text("Задачи и решения доступны на официальном сайтe <br/> <a href='$problems_link'>$problems_link</a>.");
					print_text("Подробные результаты доступны на официальном сайтe <br/> <a href='$results_link'>$results_link</a>.");
									
					print_header("Результаты студентов из Казахстана на IMC-".$year." в личном зачете");
					$table = get_table_from_file("imc/results/$year.txt");
					$needles = array("First" => "gold", 
									 "Second" => "silver", 
									 "Third" => "bronze");
					$table = replace_prize_text($table, 
												count(current($table)) - 1, 
												False,
												True,
												$needles);
					$table = replace_prize_text($table, count(current($table)) - 1, False);
					print_table($table);
					
					print_header("Результаты команд из Казахстана на IMC-".$year);
					$table = get_table_from_file("imc/results/$year-teams.txt");
					$table = replace_prize_text($table, 
												count(current($table)) - 2, 
												True,
												True,
												$needles);
					print_table($table);					
				}
			}
			if ($olymp == "republic" or $olymp == "msu") {

				$buttons = array();
				$directory = $olymp;
				if ($olymp == "republic") {
					print_header("Республиканские студенческие предметные олимпиады по направлениям <br/> 'Математика' и 'Математическое и компьютерное моделирование' (МОН РК).");
					for ($y = 2014; $y <= 2018; $y++) {
						$buttons["math-".strval($y)] = "Матем ".$y;
					}
					for ($y = 2014; $y <= 2018; $y++) {
						$buttons["mcm-".strval($y)] = "МКМ ".$y;
					}
					$directory = "republic";
				}
				if ($olymp == "msu") {
					print_header("Олимпиады Казахстанского филиала МГУ по математике (г. Астана).");
					for ($y = 2008; $y <= 2017; $y++) {
						$buttons[strval($y)] = $y." год";
					}
					$buttons['2014-train'] = "2014 год (доп.тур)";
					$buttons['2018-train'] = "2018 год (доп.тур)";
				}
				print_buttons("show.php?olymp=$olymp&year", $year, $buttons, "colomns5");

				if ($year != "") {
					print_header("Материалы олимпиады");
					show_link_file("Задачи", "$directory/problems/$olymp-$year-problems", $buttons[$year]);
					show_link_file("Решения", "$directory/solutions/$olymp-$year-solutions", $buttons[$year]);
					show_link_file("Результаты", "$directory/results/$olymp-$year-results", $buttons[$year]);

					
					$table = get_table_from_file("$directory/results/$olymp-$year-results.txt");
					if (!strstr($year, "train")) {
						$needles = array("1" => "gold", "2" => "silver", "3" => "bronze");
						$table = replace_prize_text($table, 
													count(current($table)) - 1, 
													False,
													True,
													$needles);
					}
					print_table($table);
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

