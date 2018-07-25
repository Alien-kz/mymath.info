<html>
	<head>
		<title>Международная студенческая олимпиада по математике IMC.</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">  </head>
	<link href='default.css?ver=2018-07-25-1' rel='stylesheet' type='text/css' >
	<body>
		<div align="center">
			<div class="bordered_href">
			<a href="show.php?year=2016"> 2016 </a>
			</div>
			<div class="bordered_href">
			<a href="show.php?year=2017"> 2017 </a>
			</div>
			<div class="bordered_href">
			<a href="show.php?year=2018"> 2018 </a>
			</div>
		</div>

		<?php
			include_once "table.php";
			$year = "2018";
			if (isset($_GET["year"]))
				$year = $_GET["year"];

			$site = "http://imc-math.org.uk/index.php?year=$year&item=results";
			if ($year == "2018") {
				$site = "http://imc-math.ddns.net/?show=results";
			}
			echo "<div align='center'>Подробные результаты на сайтe ";
			echo "<a href='".$site."'>IMC</a>.";
			echo "</div>\n";

			$head = "Результаты IMC-".$year;
			if ($year == "2018") {
				$head = "Предварительные результаты первого тура IMC-2018.";
			}
			echo "<div align='center'>".$head."</div>\n";

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

