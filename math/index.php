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
			$css = array("main", "header", "input", "table");
			load_css("../", $css, $agent);
		?> 
		
	</head>
	<body>
		<?php
			$buttons = get_main_buttons("../");
			print_head_buttons("../math/", $buttons);

			$olymp	= attr_get("olymp");
			$year 	= attr_get("year");
			$about 	= attr_get("about");

			#################################################### LEVEL 1
		
			div_open("Студенческие олимпиады по математике", "top");
			$buttons = array("msu" => "КФ МГУ", "republic" => "Республиканская", "imc" => "IMC");
			print_buttons("index.php", "olymp", $olymp, $buttons, "", "");
			div_close();
			
			#################################################### LEVEL 2
							
			if ($olymp == "republic" or $olymp == "msu" or $olymp == "imc") {
				$buttons = array();
				$directory = $olymp;
				$header = "";
				if ($olymp == "msu") {
					$header = "Открытая студенческая олимпиада Казахстанского филиала МГУ по математике";
					$buttons = gen_buttons_from_file("$olymp/list.txt");
					$buttons_train = gen_buttons_from_file("$olymp/list-train.txt");
					$buttons_notpro = gen_buttons_from_file("$olymp/list-notpro.txt");
					$needles = array("1" => "gold", "2" => "silver", "3" => "bronze");
				}
				if ($olymp == "republic") {
					$header = "Республиканская студенческая предметная олимпиада";
					$buttons_math = gen_buttons_from_file("$olymp/list-math.txt");
					$buttons_mcm = gen_buttons_from_file("$olymp/list-mcm.txt");
					$buttons = array_merge($buttons_math, $buttons_mcm);
					$needles = array("1" => "gold", "2" => "silver", "3" => "bronze");
				}
				if ($olymp == "imc") {
					$header = "Международная студенческая олимпиада International Mathematics Competition";
					$buttons = gen_buttons_from_file("$olymp/list.txt");
					$needles = array("First" => "gold", "Second" => "silver", "Third" => "bronze");
				}


				####################################################
				div_open($header, "about");
				print_about($about, $directory, "index.php?olymp=$olymp", "about");
				if ($olymp == "msu") {
					print_buttons("index.php", "year", $year, $buttons, array("olymp" => $olymp), "#about");
					print_centered_text("Тренировки");
					print_buttons("index.php", "year", $year, $buttons_train, array("olymp" => $olymp), "#about");
					print_centered_text("Для непрофильных специальностей");
					print_buttons("index.php", "year", $year, $buttons_notpro, array("olymp" => $olymp), "#about");
				} else if ($olymp == "republic") {
					print_centered_text("Математика");
					print_buttons("index.php", "year", $year, $buttons_math, array("olymp" => $olymp), "#about");
					print_centered_text("Математическое и компьютерное моделирование");
					print_buttons("index.php", "year", $year, $buttons_mcm, array("olymp" => $olymp), "#about");
				} else {
					print_buttons("index.php", "year", $year, $buttons, array("olymp" => $olymp), "#about");
				}
				div_close();

				####################################################  LEVEL 3
				
				if ($year != "about" and $year != "") {
					div_open("Материалы олимпиады", "problems");
					if ($olymp == "imc") {
						$site = "http://imc-math.org.uk";
						$results_link = $site."/index.php?year=$year&amp;item=results";
						$problems_link = $site."/index.php?year=$year&amp;item=problems";
						if ($year == "2020") {
							$site = "http://imc-math.ddns.net";
							$results_link = $site."/?show=results";
							$problems_link = $site."/?show=day1";
						}
						$material_buttons = array($problems_link => "Задачи", $results_link => "Результаты");
						print_buttons_external($material_buttons);
					} else {
						show_link_file("$directory/problems/$olymp-$year-problems", "Задачи ".$buttons[$year]);
						show_link_file("$directory/solutions/$olymp-$year-solutions", "Решения ".$buttons[$year]);
						print_centered_text("Задачи");
						show_png_file("$directory/problems-png/$olymp-$year-$agent");
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
						div_open("Результаты", "results");
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

