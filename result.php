<html>
	<head>
		<title> Предварителные результаты экзаменов .</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">  </head>
	<body>
		<p align="center">
			Данные взяты с официального сайта и отсортированы.
			Не являются официальным источником.
		</p>
		<p>
			<?php
				$rows = file('data/math.txt');
				echo "<table border>\n";
				echo "<tr><td>Место</td><td>Пропуск</td><td>Математика</td></tr>\n";
				
				foreach($rows as $key => $value)
				{
					$result = explode(" ", $value);
					$position = $key + 1;
					echo "<tr><td>$position</td> <td>$result[0]</td> <td>$result[1]</td> </tr>\n";
				}
				echo "</table>\n";
			?>
		</p>
	</body>
</html>

