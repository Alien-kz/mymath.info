<html>
	<head>
		<title> Материалы для абитуриентов.</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<link href='../main.css?ver=2018-08-30-2' rel='stylesheet' type='text/css' >
	</head>
	<body>
		<div class="header">
			<a class="button" href="../index.html"> Главная </a>
			<a class="button selected" href="show.php"> Абитуриентам </a>
			<a class="button" href="../math/show.php"> Олимпиады по математике </a>
			<a class="button" href="../books/show.php"> Книги </a>
		</div>

		<?php
			include_once "../routine/html.php";
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
			
			print_header("Вступительные экзамены в филиал МГУ.");
			print_buttons("show.php?subject", 
							$subject, 
							array("math" => "Математика",
								  "phys" => "Физика"),
							"colomns3");
			
			if ($subject == "math" or $subject  == "phys") {

				$buttons = array();
				$directory = $subject;
				$variant = "";
				if ($subject == "math") {
					print_header("Математика");
					for ($y = 2011; $y <= 2018; $y++) {
						$buttons[$y] = $y." год";
					}
					$variant = "1";
				}
				if ($subject == "phys") {
					print_header("Физика");
					for ($y = 2015; $y <= 2017; $y++) {
						$buttons[$y] = $y." год";
					}
					$variant = "2";
				}
				print_buttons("show.php?subject=$subject&year", $year, $buttons, "colomns4");

				if ($year != "") {
					print_header("Материалы экзамена");
					$file_name_1 = "$directory/msu-$subject-$year-1";
					$file_name_2 = "$directory/msu-$subject-$year-2";
					
					show_link_file($file_name_1, $buttons[$year]." 1 вариант");
					show_link_file($file_name_2, $buttons[$year]." 2 вариант");

					show_png_file($file_name_1);
					show_png_file($file_name_2);
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

