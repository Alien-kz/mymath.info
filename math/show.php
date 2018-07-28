<html>
	<head>
		<title>Студенческие олимпиады по математике.</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<link href='table.css?ver=2018-07-25-3' rel='stylesheet' type='text/css' >
		<link href='../main.css?ver=2018-07-25-3' rel='stylesheet' type='text/css' >
	</head>
	<body>
		<div class="header">
			<a class="button" href="../index.html"> Главная </a>
			<a class="button" href="../msu_exam/result.php"> Экзамены в филиал 2018 </a>
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
							array("msu" => "Филиал МГУ (Астана)",
									"rep" => "Республиканская (МОН РК)", 
									"imc" => "IMC (Болгария)"));
			
			if ($olymp == "imc") {
				print_header("Казахстан на международной студенческой олимпиаде по математике IMC.");
				
				print_buttons("show.php?olymp=imc&year", 
								$year,
								array(		"2013" => "2013 год", 
								      		"2014" => "2014 год", 
										"2015" => "2015 год", 
										"2016" => "2016 год", 
										"2017" => "2017 год", 
										"2018" => "2018 год"));

				if ($year != "") {
					$site = "http://imc-math.org.uk/index.php?year=$year&item=results";
					if ($year == "2019") {
						$site = "http://imc-math.ddns.net/?show=results";
					}
					
					print_header("Подробные результаты на сайтe <a href='".$site."'>IMC</a>.");

					$head = "Результаты IMC-".$year;
					if ($year == "2019") {
						$head = "Предварительные результаты IMC-2018.";
					}
					
					print_header($head);
					$table = get_table_from_file("imc/$year.txt");
					print_table($table);
					
					$head = "Командные результаты IMC-".$year;
					print_header($head);
					$table = get_table_from_file("imc/$year-teams.txt");
					print_table($table);
				}
			}
			if ($olymp == "msu") {
				print_header("Олимпиады Казахстанского филиала МГУ по математике.");

				$buttons = array();
				for ($y = 2012; $y <= 2017; $y++) {
					$buttons[strval($y)] = $y." год";
				}
				$buttons['2014-bonus'] = "2014 год (доп.тур)";
				$buttons['2018-bonus'] = "2018 год (доп.тур)";
				
				ksort($buttons);

				
				print_buttons("show.php?olymp=msu&year", 
								$year,
								$buttons);
				if ($year != "") {
					print_header("Задачи");
					show_link_file("msu/problems/problems-$year", $buttons[$year]);
					#show_pdf_file("msu/problems/problems-$year.pdf");

					print_header("Решения");
					show_link_file("msu/solutions/solutions-$year", $buttons[$year]);
					#show_pdf_file("msu/solutions/solutions-$year.pdf");

					print_header("Результаты");
					show_link_file("msu/results/results-$year", $buttons[$year]);
					$table = get_table_from_file("msu/results/results-$year.txt");
					
					print_table($table);
				}

			}
			if ($olymp == "rep") {
				print_header("Республиканские олимпиады по математике.");

				$buttons = array();
				for ($y = 2014; $y <= 2018; $y++) {
					$buttons[strval($y)] = $y." год";
				}
				
				print_buttons("show.php?olymp=rep&year", 
								$year,
								$buttons);
								
				print_header("Результаты");
				$table = get_table_from_file("rep/result/$year.txt");
				print_table($table);
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

