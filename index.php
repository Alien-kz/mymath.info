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
			
			if ($agent == 'desktop') {
				echo "<link href='main.css?ver=2018-09-02-1' rel='stylesheet' type='text/css' >";
			} else {
				echo "<link href='main_m.css?ver=2018-09-02-1' rel='stylesheet' type='text/css' >";
			}
		?>
		
	</head>
	<body>
		<?php
			$buttons = array("index.php" => "Главная",
							"abiturient/show.php" => "Абитуриентам", 
							"math/show.php" => "Олимпиады по математике",
							"books/show.php" => "Книги");
			print_buttons("", "index.php", $buttons, "colomns_in_header", "");
		?>
	
		<div align="center">
			<div class="hello_div">
				<h3 align='center'> Здравствуйте, уважаемые посетители! </h3>			
			
				<p> Данный сайт является сборником различных материалов студенческих олимпиад по математике и программированию Казахстанского филиала МГУ. </p>

				<p> Не забывайте следить за информацией об интересных мероприятиях в филиале МГУ на странице <a href='http://vk.com/aperture_time'>aperture_time</a>.</p> 

				<p> Обратная связь по почте: a-l-e-n на mail.ru.</p> 
				
<!--				<p> Большой любитель олимпиад, Баев Ален.</p> -->
			</div>
		</div>
	
		<div align="center">
			<div class="hello_div">
		
			<h3  align='center'> Последнее обновление </h3>
		
			Опубликованы варианты вступительных экзаменов в Казахстанский филиал 2011-2017 годов по математике и 2015-2017 годов по физике. <br/>
<a href="abiturient/show.php"> Задания вступительных экзаменов</a>
			</div>
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

