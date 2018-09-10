<!doctype html>
<html>
	<head>
		<title>Задачи по математике, программированию и не только.</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="keywords" content="студенческие олимпиады, олимпиады по математике, олимпиады по программированию, Казахстанский филиал МГУ, олимпиада филиала МГУ, олимпиада Астана, вступительные задания МГУ, задачи по математике, задачи по математическому анализу, задачи по линейной алгебре, Республиканская студенческая олимпиада, математика, математическое и компьюетрное моделировние">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<?php
			include_once "routine/html.php";
			$agent = get_user_agent_type();
			$css = array("main", "chars");
			load_css("../", $css, $agent);
		?>
		
	</head>
	<body>
		<?php
			$buttons = get_main_buttons("");
			print_buttons("", "index.php", $buttons, "colomns_in_header", "");
		?>
	
		<div align="center">
		<div class="content_div">
			<h3 align='center'> Здравствуйте, уважаемые посетители! </h3>
			<p align='left'> 
				<?php print_text(file_get_contents("hello.txt")); ?>
			</p>
		</div>
		</div>

		<div align="center">
			<?php 
			div_open("Последнее обновление");
			print_text(replace_level(file_get_contents("news.txt"))); 
			div_close();
			?>
		</div>
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

