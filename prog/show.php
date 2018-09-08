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
			include_once "../routine/table.php";
			$agent = get_user_agent_type();
			
			if ($agent == 'desktop') {
				echo "<link href='../css/table.css?ver=2018-09-02-4' rel='stylesheet' type='text/css' >";
				echo "<link href='../css/main.css?ver=2018-09-02-4' rel='stylesheet' type='text/css' >";
			} else {
				echo "<link href='../css/table_m.css?ver=2018-09-02-4' rel='stylesheet' type='text/css' >";
				echo "<link href='../css/main_m.css?ver=2018-09-02-4' rel='stylesheet' type='text/css' >";
			}
		?>
		
	</head>
	<body>
		<?php
			$buttons = get_main_buttons("../");
			print_buttons("", "../prog/show.php", $buttons, "colomns_in_header", "");

			$olymp = "";
			if (isset($_GET["olymp"])) {
				$olymp = $_GET["olymp"];
			}
			$year = "";
			if (isset($_GET["year"])) {
				$year = strval($_GET["year"]);
			}
			$mask = "";
			if (isset($_POST["mask"])) {
				$mask = strval($_POST["mask"]);
			}
			$top = "";
			if (isset($_POST["top"])) {
				$top = strval($_POST["top"]);
			}
			?>
		
		<?php
			echo "<a name='type'></a>";
			div_open("Студенческие олимпиады по математике");
			print_buttons("show.php?olymp=", 
							$olymp, 
							array("msu" => "КФ МГУ", "acm" => "ACM"),
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
				if ($olymp == "acm") {
					$header = "Четвертьфинал чемпионата мира по программированию.";
					$array = get_table_from_file("acm/list.txt");
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
					if ($olymp == "acm") {
						$site = "https://neerc.ifmo.ru/archive/";
						$results_link = $site."$year/kazakhstan/standings.html";
						$material_buttons = array($results_link => "Результаты");
						if ($year >= 2006) {
							$problems_link = $site."$year/northern/problems.pdf";
							if ($year >= 2013) {
								$problems_link = $site."$year/northern/north-$year-statements.pdf"; 
							}
							$material_buttons = array($problems_link => "Задачи", $results_link => "Результаты");
						}
						print_buttons("", "", $material_buttons, "colomns3 external_link", "");
					} else {
						show_link_file("$directory/problems/$olymp-$year-problems", "Задачи ".$buttons[$year]);
						show_link_file("$directory/solutions/$olymp-$year-solutions", "Решения ".$buttons[$year]);
						show_link_file("$directory/results/$olymp-$year-results", "Результаты ".$buttons[$year]);
						print_header("Задачи");
						show_png_file("$directory/problems/$olymp-$year-$agent");
						print_header("Выберите год");
						print_buttons("show.php?olymp=$olymp&amp;year=", $year, $buttons, $year_colomn_width, "#header");
					}
					
					
					
					$table = get_table_from_file("$directory/results/$year.txt");
					if ($table) {
						echo "<a name='results'></a>";
						print_header("Результаты участников");
						if ($mask == "") {
							if ($year > 2013)
								$mask = "Kazakhstan Branch of Moscow State University";
							if ($year == 2013)
								$mask = "MSU Kaz Branch";
							if ($year == 2012)
								$mask = "KB MSU";
							if ($year == 2007)
								$mask = "AstanaMSU";
							if ($year == 2006)
								$mask = "Astana_MSU U.";
						}
						if ($top == "") {
							$top = 4;
						}

						$colomn = 1;
						if ($year == 2003)
							$colomn = 0;
						$universities = get_university_list($table, $colomn);
						$table = replace_brackets_to_label($table);
						if (isset($_POST['highlight'])) {
							$table = mark_row($table, $colomn, $mask);
						}
						if (isset($_POST['select'])) {
							$table = select_row($table, $colomn, $mask);
						}
						if (isset($_POST['tophighlight'])) {
							$table = mark_top($table, $colomn, $top);
						}
						if (isset($_POST['topselect'])) {
							$table = select_top($table, $colomn, $top);
						}
						print_form_select_two_action("show.php?olymp=$olymp&amp;year=$year#problems",
													$universities,
													"mask",
													$mask,
													array("highlight", "select"), 
													array("отметить", "выбрать"));
						print_form_two_action("show.php?olymp=$olymp&amp;year=$year#problems",
													"Лучшие команды из университета",
													"top",
													$top,
													array("tophighlight", "topselect"), 
													array("отметить", "выбрать"));
						#print_form("show.php?olymp=$olymp&amp;year=$year#problems",
						#			$top,
						#			"лучшие команды из университета",
						#			"top",
						#			"Отметить");
						#print_form_two_action("show.php?olymp=$olymp&amp;year=$year#problems",
						#						$mask,
						#						array("highlight", "select"), 
						#						array("Отметить", "Отфильтровать")); 
						print_table($table);
						print_header("Выберите год");
						print_buttons("show.php?olymp=$olymp&amp;year=", $year, $buttons, $year_colomn_width, "#header");
					}
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

