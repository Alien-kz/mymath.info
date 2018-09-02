<!doctype html>
<html>
	<head>
		<title> Материалы для абитуриентов.</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		
		<?php
			include_once "../routine/html.php";
			$agent = get_user_agent_type();
			
			if ($agent == 'desktop') {
				echo "<link href='../main.css?ver=2018-09-02-4' rel='stylesheet' type='text/css' >";
			} else {
				echo "<link href='../main_m.css?ver=2018-09-02-4' rel='stylesheet' type='text/css' >";
			}
			echo "<link href='../chars.css?ver=2018-09-02-4' rel='stylesheet' type='text/css' >";
		?>
	</head>
	<body>
		<?php
			$buttons = array("../index.php" => "Главная",
				"../abiturient/show.php" => "Абитуриентам", 
				"../math/show.php" => "Олимпиады по математике",
				"../books/show.php" => "Книги");
			print_buttons("", "../abiturient/show.php", $buttons, "colomns_in_header", "");

		
			$subject = "";
			if (isset($_GET["subject"])) {
				$subject = $_GET["subject"];
			}
			$year = "";
			if (isset($_GET["year"])) {
				$year = $_GET["year"];
			}
		?>
		
		<?php
			div_open("Вступительные экзамены в Казахстанский филиал МГУ");
			print_buttons("show.php?subject=", 
							$subject, 
							array("math" => "Математика",
								  "phys" => "Физика"),
							"colomns3", "");
			div_close();

			########################################
			
			if ($subject == "math" or $subject  == "phys") {
				$header = "";
				$buttons = array();
				$directory = $subject;
				$variant = "";
				if ($subject == "math") {
					for ($y = 2011; $y <= 2017; $y++) {
						$buttons[$y] = $y." год";
					}
					$variant = "1";
					$header = "Экзамен по математике";
				}
				if ($subject == "phys") {
					for ($y = 2015; $y <= 2017; $y++) {
						$buttons[$y] = $y." год";
					}
					$variant = "2";
					$header = "Экзамен по физике";
				}


				echo "<a name='material'></a>";
				div_open($header);
				if ($year == "about") {
					print_buttons("show.php?subject=$subject&amp;year=", $subject, array("" => "Скрыть ..."), "colomns3", "#material");
					print_text(file_get_contents("$subject/about.txt")); 
				} else {
					print_buttons("show.php?subject=$subject&amp;year=", $year, array("about" => "Подробнее об экзамене ..."), "colomns3", "#material");
			
				
				}
				print_header("Выберите год");
				print_buttons("show.php?subject=$subject&amp;year=", $year, $buttons, "colomns7", "#material");
				div_close();

				########################################

				if ($year != "" and $year != "about") {
					div_open("Материалы экзамена");
					$file_name_1 = "$directory/problems/msu-$subject-$year-1";
					$file_name_2 = "$directory/problems/msu-$subject-$year-2";
					
					show_link_file($file_name_1, $buttons[$year]." 1 вариант");
					show_link_file($file_name_2, $buttons[$year]." 2 вариант");

					show_png_file($file_name_1."-".$agent);
					show_png_file($file_name_2."-".$agent);
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

