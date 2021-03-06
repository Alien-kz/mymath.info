<!doctype html>
<html>
	<head>
		<title>Книги</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<?php
			include_once "../routine/html.php";
			$agent = get_user_agent_type();
			$css = array("main", "header", "books");
			load_css("../", $css, $agent);
		?>
		
	</head>
	<body>
		<?php
			$buttons = get_main_buttons("../");
			print_head_buttons("../books/", $buttons);

		?>
		
		<?php div_open("Изданное", ""); ?>
			<div>
			<div class="book_div">
					<a href="src/Intro_in_C_and_unix_shell.pdf">
				
					<img class='img_in_div' src="src/Intro_in_C_and_unix_shell_logo.jpg">
					<p>
					Введение <br/>
					в программирование на языке С <br />
					и знакомство со средой UNIX.
					</p>
				</a>
				<p class="comment">
				    Данное пособие предназначено для студентов первого курса направления "Математика" Казахстанского филиала МГУ имени М.В.~Ломоносова. Основная цель --- формирование первичных навыков программировании на языке C. Материал представлен в форме 14 тем, каждая из которых содержит теоретический материал, подробный разбор ключевых задач и задания для самостоятельной работы. Также в пособии описаны основные аспекты поведения в командной строке UNIX--систем на примере bash (Born Again Shell) и работы с компилятором C на примере gcc в среде UNIX.
				</p>
				<p class="comment"> 
					Автор: Баев А.Ж.
				</p>
				<p class="comment"> 
					Объем: 404 страницы.
				</p>
			</div>
			<div class="book_div">
					<a href="src/2011_2018_msu_math.pdf">
				
					<img class='img_in_div' src="src/2011_2018_msu_math_logo_mini.jpg">
					<p>
					Вступительное испытание <br/>
					по математике. <br/>
					Пособие для поступающих <br/>
					в Казахстанский филиал МГУ
					</p>
				</a>
				<p class="comment">
					Данное пособие предназначено для поступающих в Казахстанский филиал МГУ, учителей и выпускников средних школ. В пособии содержатся подробные решения задач, предложенных абитуриентам на вступительном экзамене по математике в 2011-2018 годах.
				</p>
				<p class="comment"> 
					Авторы: Баев А.Ж., Васильев А.Н., Галиева Н.К.
				</p>
				<p class="comment"> 
					Объем: 109 страниц.
				</p>
			</div>
			<div class="book_div">
					<a href="src/2008_2018_msu_olympiad_in_math.pdf">
					<img class='img_in_div' src="src/2008_2018_msu_olympiad_in_math_logo_mini.jpg">
					<p>
					Cтуденческие олимпиады <br/>
					Казахстанского филиала МГУ <br/>
					по математике 2008-2018
					</p>
				</a>
				<p class="comment">
					Сборник содержит 132 задачи, предложенные на 14 олимпиадах Казахстанского филиала МГУ в период с 2008 по 2018 год, и 18 задач, предложенных на республиканских студенческих олимпиадах в 2016 и 2017 году. В том числе около 30 авторских задач. К задачам даны указания. Также приведены результаты олимпиад с 2012 года.
				</p>
				<p class="comment"> 
					Авторы: Абдикалыков А.К., Баев А.Ж., Васильев А.Н.
				</p>
				<p class="comment"> 
					Уровень сложности: 4 из 5
				</p>
				<p class="comment"> 
					Объем: 98 страниц.
				</p>
			</div>

			<div class="book_div">
					<a href="src/2013_2018_msu_olympiad_in_programming.pdf">
				
					<img class='img_in_div' src="src/2013_2018_msu_olympiad_in_programming_logo_mini.jpg">
					<p>
					Cтуденческие олимпиады <br/>
					Казахстанского филиала МГУ <br/>
					по программированию 2013-2018
					</p>
				</a>
				<p class="comment">
					Сборник содержит 138 задач, предложенных на 15 олимпиадах Казахстанского филиала МГУ с 2013 по 2018 год. Большая часть задач авторская. К задачам даны указания. Также приведены результаты олимпиад.
				</p>
				<p class="comment"> 
					Авторы: Абдикалыков А.К., Баев А.Ж.
				</p>
				<p class="comment"> 
					Уровень сложности: 3 из 5
				</p>
				<p class="comment"> 
					Объем: 246 страниц.
				</p>
			</div>			
			</div>
		<?php div_close(); ?>

		<?php div_open("Неизданное", ""); ?>
			<div>
			<div class="book_div">
				<a href="src/2014_2018_republic_olympiad_in_math_for_student.pdf">
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
		<?php div_close(); ?>
	</body>
</html>
