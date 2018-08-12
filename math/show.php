<html>
	<head>
		<title>Студенческие олимпиады по математике.</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<link href='table.css?ver=2018-08-12-1' rel='stylesheet' type='text/css' >
		<link href='../main.css?ver=2018-08-12-1' rel='stylesheet' type='text/css' >
	</head>
	<body>
		<div class="header">
			<a class="button" href="../index.html"> Главная </a>
			<!--<a class="button" href="../msu_exam/result.php"> Экзамены в филиал 2018 </a>-->
			<a class="button selected" href="show.php"> Олимпиады по математике </a>
			<a class="button" href="../books/show.php"> Книги </a>
		</div>

		<?php
			include_once "table.php";
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
							array("msu" => "Олимпиада филиала МГУ (г. Астана)",
									"rep-math" => "Республиканская по математике (МОН РК)", 
									"rep-mcm" => "Республиканская по МКМ (МОН РК)", 
									"imc" => "IMC (Болгария)"));
			
			if ($olymp == "imc") {
				print_header("Казахстан на международной студенческой олимпиаде по математике IMC.");
				
				$buttons = array();
				for ($y = 2013; $y <= 2018; $y++) {
					$buttons[strval($y)] = $y." год";
				}
				print_buttons("show.php?olymp=imc&year", $year, $buttons);
				
				if ($year != "") {
					print_header("Результаты IMC-".$year." в личном зачете");
					$table = get_table_from_file("imc/$year.txt");
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
					
					print_header("Результаты IMC-".$year." в командном зачете");
					$table = get_table_from_file("imc/$year-teams.txt");
					$table = replace_prize_text($table, 
												count(current($table)) - 2, 
												True,
												True,
												$needles);
					print_table($table);
					
					$site = "http://imc-math.org.uk/index.php?year=$year&item=results";
					if ($year == "2018") {
						$site = "http://imc-math.ddns.net/?show=results";
					}
					print_header("Подробные результаты на сайтe <a href='".$site."'>IMC</a>.");

				}
			}
			if ($olymp == "msu") {
				print_header("Олимпиады Казахстанского филиала МГУ по математике.");

				$buttons = array();
				for ($y = 2008; $y <= 2017; $y++) {
					$buttons[strval($y)] = $y." год";
				}
				$buttons['2014-bonus'] = "2014 год (доп.тур)";
				$buttons['2018-bonus'] = "2018 год (доп.тур)";
#					ksort($buttons);
				print_buttons("show.php?olymp=msu&year", $year, $buttons);

				if ($year != "") {
					print_header("Материалы олимпиады");
					show_link_file("Задачи", "msu/problems/problems-$year", $buttons[$year]);
					show_link_file("Решения", "msu/solutions/solutions-$year", $buttons[$year]);

					#show_pdf_file("msu/problems/problems-$year.pdf");
					#show_pdf_file("msu/solutions/solutions-$year.pdf");

					if ($year >= 2012) {
						show_link_file("Результаты", "msu/results/results-$year", $buttons[$year]);
						$table = get_table_from_file("msu/results/results-$year.txt");
						if (!strstr($year, "bonus")) {
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

			}
			if ($olymp == "rep-math" or $olymp == "rep-mcm") {
				if ($olymp == "rep-mcm")
					print_header("Республиканские олимпиады по математическому и компьютерному моделированию.");
				else
					print_header("Республиканские олимпиады по математике.");

				$buttons = array();
				for ($y = 2014; $y <= 2018; $y++) {
					$buttons[strval($y)] = $y." год";
				}
				print_buttons("show.php?olymp=$olymp&year", $year, $buttons);
				

				if ($year != "") {
					print_header("Материалы олимпиады");
					show_link_file("Задачи", "rep/problems/problems-$year-$olymp", $buttons[$year]);
#					show_link_file("Решения", "rep/solutions/solutions-$year-rep", $buttons[$year]);
					show_link_file("Результаты", "rep/results/results-$year-$olymp", $buttons[$year]);

					
					$table = get_table_from_file("rep/result/$year.txt");
					$needles = array("1" => "gold", "2" => "silver", "3" => "bronze");
					$table = replace_prize_text($table, 
												count(current($table)) - 1, 
												False,
												True,
												$needles);
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

