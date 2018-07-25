<html>
	<head>
		<title>Международная студенческая олимпиада по математике IMC.</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<link href='table.css?ver=2018-07-25-2' rel='stylesheet' type='text/css' >
		<link href='../main.css?ver=2018-07-25-2' rel='stylesheet' type='text/css' >
	</head>
	<body>
		<div class="header">
			<a class="button" href="../index.html"> Главная </a>
			<a class="button" href="../msu_exam/result.php"> Экзамены в филиал 2018 </a>
			<a class="button selected" href="show.php"> Олимпиада по математике IMC </a>
			<a class="button" href="../books/show.php"> Книги </a>
		</div>
		<div align="center">
		<h2>
			Казахстан на международной студенческой олимпиаде по математике IMC.
		</h2>
		</div>

		<?php
			include_once "table.php";
			$year = "2018";
			if (isset($_GET["year"]))
				$year = $_GET["year"];
			
			echo "<div align='center'>";
			for ($y = 2016; $y <= 2018; $y++) {
				$selected = "";
				if ($y == $year)
					$selected = " selected";
				echo "<a class='button $selected' href='show.php?year=$y'>$y</a> ";
			}
			echo "</div>";

			$site = "http://imc-math.org.uk/index.php?year=$year&item=results";
			if ($year == "2018") {
				$site = "http://imc-math.ddns.net/?show=results";
			}
			echo "<div align='center'><h2>";
			echo "Подробные результаты на сайтe ";
			echo "<a href='".$site."'>IMC</a>.";
			echo "</h2></div>\n";

			$head = "Результаты IMC-".$year;
			if ($year == "2018") {
				$head = "Предварительные результаты первого тура IMC-2018.";
			}
			echo "<div align='center'><h2>".$head."</h2></div>\n";

			$table = get_table_from_file("$year.txt");
			print_table($table)
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

