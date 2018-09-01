<html>
	<head>
		<title>Книги.</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<?php
			include_once "../routine/html.php";
			include_once "table.php";
			$agent = get_user_agent_type();
			
			if ($agent == 'desktop') {
				echo "<link href='books.css?ver=2018-09-01-2' rel='stylesheet' type='text/css' >";
				echo "<link href='../main.css?ver=2018-09-01-2' rel='stylesheet' type='text/css' >";
			} else {
				echo "<link href='books_m.css?ver=2018-09-01-2' rel='stylesheet' type='text/css' >";
				echo "<link href='../main_m.css?ver=2018-09-01-2' rel='stylesheet' type='text/css' >";
			}
		?>
		
	</head>
	<body>
		<?php
			$buttons = array("../index.php" => "Главная",
							"../abiturient/show.php" => "Абитуриентам", 
							"../math/show.php" => "Олимпиады по математике",
							"../books/show.php" => "Книги");
			$css = "colomns_in_header";
			print_buttons("", "../books/show.php", $buttons, $css);

		?>
		<div align="center">
			<h2>
			Изданное
			</h2>
			<div class="content_div">
				<a href="2008_2018_msu_olympiad_in_math.pdf">
					<img class='img_in_div' src="2008_2018_msu_olympiad_in_math_logo_mini.jpg">
					<p>
					Cтуденческие олимпиады <br/>
					Казахстанского филиала МГУ <br/>
					по математике 2008-2018
					</p>
				</a>
				<p class="comment">
					Сборник содержит 100 задач, предложенных на 12 олимпиадах Казахстанского филиала МГУ в период с 2008 по 2018 год, 
					и 18 задач, предложенных на республиканских студенческих олимпиадах в 2016 и 2017 году. В том числе около 30 авторских задач.
					К задачам даны указания. Также приведены результаты олимпиад с 2012 года.
				</p>
				<p class="comment"> 
					Авторы: Абдикалыков А.К., Баев А.Ж., Васильев А.Н.
				</p>
				<p class="comment"> 
					Уровень сложности: 4 из 5
				</p>
				<p class="comment"> 
					Объем: 109 страниц.
				</p>
			</div>
			<div class="content_div">
				<a href="2013_2018_msu_olympiad_in_programming.pdf">
					<img class='img_in_div' src="2013_2018_msu_olympiad_in_programming_logo_mini.jpg">
					<p>
					Cтуденческие олимпиады <br/>
					Казахстанского филиала МГУ <br/>
					по программированию 2013-2018
					</p>
				</a>
				<p class="comment">
					Сборник содержит 112 задач, предложенных на 13 олимпиадах Казахстанского филиала МГУ с 2013 по 2018 год. Большая часть задач авторская.
					К задачам даны указания. Также приведены результаты олимпиад.
				</p>
				<p class="comment"> 
					Авторы: Абдикалыков А.К., Баев А.Ж.
				</p>
				<p class="comment"> 
					Уровень сложности: 3 из 5
				</p>
				<p class="comment"> 
					Объем: 219 страниц.
				</p>
			</div>
		</div>
		<div align="center">
			<h2>
			Неизданное
			</h2>
			<div class="content_div">
				<a href="2014_2018_republic_olympiad_in_math_for_student.pdf">
					<p align="center">
					Cтуденческие республиканские олимпиады <br/>
					по математике и по математическому и компьютерному моделированию <br/>
					по программированию 2014-2018
					</p>
				</a>
				<p class="comment">
					Сборник содержит 50 задач, предложенных на 5 республиканских студенческих олимпиадах по математике и 5 республиканских студенческих олимпиадах по математическому и компьютерному моделированию с 2014 по 2018 год. Также приведены результаты олимпиад.
				</p>
				<p class="comment"> 
					Уровень сложности: 4 из 5
				</p>
				<p class="comment"> 
					Объем: 16 страниц.
				</p>
			</div>
		</div>
	</body>
</html>
