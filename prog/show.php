<!doctype html>
<html>
	<head>
		<title>Студенческие олимпиады по программированию.</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<?php
			include_once "../routine/html.php";
			include_once "../math/table.php";
			$agent = get_user_agent_type();
			
			if ($agent == 'desktop') {
				echo "<link href='table.css?ver=2018-09-02-4' rel='stylesheet' type='text/css' >";
				echo "<link href='../main.css?ver=2018-09-02-4' rel='stylesheet' type='text/css' >";
			} else {
				echo "<link href='table_m.css?ver=2018-09-02-4' rel='stylesheet' type='text/css' >";
				echo "<link href='../main_m.css?ver=2018-09-02-4' rel='stylesheet' type='text/css' >";
			}
		?>
		
	</head>
	<body>
		<?php
			$buttons = array("../index.php" => "Главная",
							"../abiturient/show.php" => "Абитуриентам", 
							"../math/show.php" => "Олимпиады по математике",
							"../prog/show.php" => "Олимпиады по программированию",
							"../books/show.php" => "Книги");
			print_buttons("", "../prog/show.php", $buttons, "colomns_in_header", "");

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
							array("msu" => "КФ МГУ" #, "acm" => "ACM"
								),
							"colomns2",
							"#type");
			div_close();
			
			####################################################
							
			if ($olymp == "msu" or $olymp == "acm") {
				$buttons = array();
				$directory = $olymp;
				$header = "";
				$year_colomn_width = "colomns5";
				if ($olymp == "msu") {
					$header = "Открытая студенческая олимпиада Казахстанского филиала МГУ по программированию.";
					$array = get_table_from_file("msu/list.txt");
					$number = count($array) - 1;
					for ($i = 0; $i < $number; $i++) {
						$row = $array[$i];
						$buttons[$row[0]] = $row[1];
					}
					$year_colomn_width = "colomns5";
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
				print_header("Выберите год");
				if ($agent == "mobile")
					print_select_buttons("show.php", "year", $year, $buttons, array("olymp" => $olymp), "problems");
				else
					print_buttons("show.php?olymp=$olymp&amp;year=", $year, $buttons, $year_colomn_width, "#header");
				div_close();

				####################################################
				
				if ($year != "about" and $year != "") {
					echo "<a name='problems'></a>";
					div_open("Материалы олимпиады");
					show_link_file("$directory/problems/$olymp-$year-problems", "Задачи ".$buttons[$year]);
					show_link_file("$directory/solutions/$olymp-$year-solutions", "Решения ".$buttons[$year]);
					show_link_file("$directory/results/$olymp-$year-results", "Результаты ".$buttons[$year]);
					print_header("Задачи");
					show_png_file("$directory/problems/$olymp-$year-$agent");
					echo "<a name='data_results'></a>";
					print_header("Выберите год");
					print_buttons("show.php?olymp=$olymp&amp;year=", $year, $buttons, $year_colomn_width, "#data_results");
					div_close();
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

