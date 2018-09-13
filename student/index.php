<!doctype html>
<html>
	<head>
		<title> Материалы для студентов и магистрантов КФ МГУ.</title>
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
			print_head_buttons("../student/", $buttons);
			
			$subject= attr_get("subject");

			######################################## LEVEL 1

			div_open("Материалы по курсам", "top");
			$buttons = array("python" => "python",
							"latex" => "LaTeX",
							"master" => "ВМК (магистранты)");
			print_buttons("index.php", "subject", $subject, $buttons, "", "");
			div_close();

			######################################## LEVEL 2
			
			if ($subject == "python") {
				div_open("Информация", "content");
				print_text_with_code(file_get_contents($subject."/learn-python.txt")); 
				div_close();
				
				div_open("Устанавливаем python + matplotlib", "content");
				print_text_with_code(file_get_contents($subject."/install-python.txt")); 
				div_close();
				
				div_open("Устанавливаем jupyter", "content");
				print_text_with_code(file_get_contents($subject."/install-jupyter.txt")); 
				div_close();
			}
			if ($subject == "latex") {
				div_open("Вёрстка отчёта в LaTeX", "content");
				print_text_with_code(file_get_contents($subject."/install-latex.txt")); 
				div_close();
			}
			if ($subject == "master") {
				div_open("1 семестр", "content");
				print_text_with_code(file_get_contents($subject."/sem_1.txt")); 
				print_code(file_get_contents($subject."/sem_1_0.py")); 
				div_close();
				div_open("3 семестр", "content");
				print_text_with_code(file_get_contents($subject."/sem_3.txt")); 
				print_code(file_get_contents($subject."/sem_3_0.py")); 
				div_close();
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

