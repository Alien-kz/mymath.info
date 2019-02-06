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
			$css = array("main", "header", "input", "table");
			load_css("../", $css, $agent);
		?>
		
	</head>
	<body>
		<?php
			$olymp		= attr_get("olymp");
			$year 		= attr_get("year");
			$filterkaz 	= attr_get("filterkaz");
			$filtermask = attr_get("filtermask");
			$mask 		= attr_get("mask");
			$filtertop 	= attr_get("filtertop");
			$top 		= attr_get("top");
			$about 		= attr_get("about");
			
			$buttons = get_main_buttons("../");
			print_head_buttons("../prog/", $buttons);

			#################################################### LEVEL 1

			div_open("Студенческие олимпиады по~программированию", "top");
			$buttons = array("msu" => "КФ МГУ", "acm-kaz" => "1/4 ACM", "acm-eurasia" => "1/2 ACM");
			print_buttons("index.php", "olymp", $olymp, $buttons, "", "");
			div_close();
			
			#################################################### LEVEL 2
							
			if ($olymp == "msu" or $olymp == "acm-kaz" or $olymp == "acm-eurasia") {
				$directory = $olymp;
				$header = "";
				$buttons_ind = array();
				$buttons_team = array();
				if ($olymp == "msu") {
					$header = "Открытая студенческая олимпиада Казахстанского филиала МГУ по~программированию";
					$buttons_ind = gen_buttons_from_file("$olymp/list-ind.txt");
					$buttons_team = gen_buttons_from_file("$olymp/list-team.txt");
				}
				if ($olymp == "acm-kaz") {
					$header = "Казахстанский четвертьфинал чемпионата мира по~программированию ACM~ICPC";
				}
				if ($olymp == "acm-eurasia") {
					$header = "Полуфинал чемпионата мира по~программированию ACM~ICPC (Северная~Евразия)";
				}
				$buttons = gen_buttons_from_file("$olymp/list.txt");
				
				####################################################
				
				div_open($header, "about");
				print_about($about, $directory, "index.php?olymp=$olymp", "about");
				if ($olymp == "msu") {
					print_centered_text("Индивидуальная олимпиада");
					print_buttons("index.php", "year", $year, $buttons_ind, array("olymp" => $olymp), "#about");
					print_centered_text("Командная олимпиада");
					print_buttons("index.php", "year", $year, $buttons_team, array("olymp" => $olymp), "#about");
				} else {
					print_buttons("index.php", "year", $year, $buttons, array("olymp" => $olymp), "#about");
				}
				div_close();
				
				#################################################### LEVEL 3
				
				if ($year != "about" and $year != "") {
					div_open("Материалы олимпиады", "problems");
					if ($olymp == "acm-kaz") {
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
						print_buttons_external($material_buttons);
					}
					if ($olymp == "acm-eurasia") {
						$site = "https://neerc.ifmo.ru/archive/";
						$link = "https://neerc.ifmo.ru/archive/index.html";
						$material_buttons = array($link => "Задачи и результаты");
						print_buttons_external($material_buttons);
					}
					if ($olymp == "msu") {
						$codeforces = $directory."/codeforces/msu-$year.txt";
						$codeforces_link = file_get_contents($codeforces);
						if ($codeforces_link != "")
							print_buttons_external(array($codeforces_link => "Тренировка на codeforces"));
						show_link_file("$directory/problems/$olymp-$year-problems", "Задачи ".$buttons[$year]);
						show_link_file("$directory/solutions/$olymp-$year-solutions", "Решения ".$buttons[$year]);
						print_centered_text("Задачи");
						show_png_file("$directory/problems-png/$olymp-$year-$agent");
					}
					div_close();
	
					
					div_open("Результаты участников", "results");
					if ($olymp == "msu") {
						show_link_file("$directory/results/$olymp-$year-results", "Результаты ".$buttons[$year]);
					}
					
					$table = get_table_from_file("$directory/results/$year.txt");
					if ($table) {
						if ($mask == "") {
							if ($olymp == "acm-kaz") {
								if ($year > 2013)
									$mask = "Kazakhstan Branch of Moscow State University";
								if ($year == 2012 or $year == 2013)
									$mask = "MSU Kaz Branch";
								if ($year == 2006 or $year == 2007)
									$mask = "Astana MSU";
							}
							if ($olymp == "acm-eurasia") {
								$mask = "Kazakhstan Branch of Moscow SU";
								if ($year == 2006 or $year == 2007)
									$mask = "Astana Moscow SU";
								if ($year == 2018)
									$mask = "Kazakhstan br of MSU";
							}
						}
						if ($top == "") {
							if ($olymp == "acm-kaz") {
								$top = 1;
							}
							if ($olymp == "acm-eurasia") {
								$top = 1;
							}
						}

						$colomn = 1;
						$universities = get_university_list($table, $colomn);
						$defaults_keys = array("olymp" => $olymp, "year" => $year);

						if ($filterkaz == "mark" || $filterkaz == "select") {
							$defaults_keys["filterkaz"] = $filterkaz;
							$kaz_universities = get_array_from_file("acm-eurasia/results/$year-kaz.txt");
							if ($filterkaz == "mark") {
								$table = mark_kaz($table, $colomn, $kaz_universities);
							}
							if ($filterkaz == "select") {
								$table = select_kaz($table, $colomn, $kaz_universities);
								$colomn += 1;
							}
						}
						if ($filtermask == "mark" || $filtermask == "select") {
							$defaults_keys["filtermask"] = $filtermask;
							$defaults_keys["mask"] = $mask;
							if ($filtermask == "mark") {
								$table = mark_row($table, $colomn, $mask);
							}
							if ($filtermask == "select") {
								$table = select_row($table, $colomn, $mask);
								$colomn += 1;
							}
						}
						if ($filtertop == "mark" || $filtertop == "select") {
							$defaults_keys["filtertop"] = $filtertop;
							$defaults_keys["top"] = $top;
							if ($filtertop == "mark") {
								$table = mark_top($table, $colomn, $top);
							}
							if ($filtertop == "select") {
								$table = select_top($table, $colomn, $top);
								$colomn += 1;
							}
						}
						$table = replace_brackets_to_label($table);
						$table = mark_plus($table);
						print_form_select("index.php?#results",
											$universities,
											"mask",
											$mask,
											"filtermask", 
											array("mark", "select"),
											array("отметить", "фильтр"),
											$defaults_keys
										);
						print_form_number("index.php?#results",
											"Лучшие <number> команд(ы) университета",
											"top",
											$top,
											"filtertop", 
											array("mark", "select"),
											array("отметить", "фильтр"),
											$defaults_keys
										);
						if ($olymp == "acm-eurasia") {
							print_form("index.php?#results",
											"Команды из Казахстана",
											"filterkaz", 
											array("mark", "select"),
											array("отметить", "фильтр"),
											$defaults_keys
										);
						}
						print_table($table);
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

