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
			include_once "../routine/table.php";
			$agent = get_user_agent_type();
			$css = array("main", "header", "input", "chars");
			load_css("../", $css, $agent);
		?>
	</head>
	<body>
		<?php
			$buttons = get_main_buttons("../");
			print_head_buttons("../abiturient/", $buttons);
			
			$subject= attr_get("subject");
			$year 	= attr_get("year");
			$about 	= attr_get("about");

			######################################## LEVEL 1

			div_open("Вступительные экзамены в~Казахстанский филиал МГУ", "top");
			$buttons = array("math" => "Математика", "phys" => "Физика");
			print_buttons("index.php", "subject", $subject, $buttons, "", "");
			div_close();

			######################################## LEVEL 2
			
			if ($subject == "math" or $subject  == "phys") {
				$header = "";
				if ($subject == "math") {
					$header = "Экзамен по~математике";
				}
				if ($subject == "phys") {
					$header = "Экзамен по~физике";
				}
				$directory = $subject;
				$buttons = gen_buttons_from_file("$subject/list.txt");

				div_open($header, "about");
				print_about($about, $directory, "index.php?subject=$subject", "about");
				print_buttons("index.php", "year", $year, $buttons, array("subject" => $subject), "#about");
				div_close();

				######################################## LEVEL 3

				if ($year != "" and $year != "about") {
					div_open("Материалы экзамена", "problems");
					$file_name_1 = "$directory/problems/msu-$subject-$year-1";
					$file_name_2 = "$directory/problems/msu-$subject-$year-2";
					
					show_link_file($file_name_1, $buttons[$year]." 1 вариант");
					show_link_file($file_name_2, $buttons[$year]." 2 вариант");

					$file_name_1 = "$directory/png/msu-$subject-$year-1";
					$file_name_2 = "$directory/png/msu-$subject-$year-2";
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

