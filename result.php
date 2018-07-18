<html>
	<head>
		<title> Предварителные результаты экзаменов .</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">  </head>
	<body>
		<p align="center">
			Данные взяты с официального сайта и отсортированы. <br/>
			Не являются официальным источником. <br/>
		</p>
		<p align="center">
			<a href="result.php?sub=mre&lim=27"> Экономика </a><br/>
			<a href="result.php?sub=mrp&lim=27"> Прикладная математика и информатика </a><br/>
			<a href="result.php?sub=mr&lim=25"> Математика </a><br/>
			<a href="result.php?sub=mrg&lim=26"> Экология </a><br/>
			<a href="result.php?sub=erl&lim=20"> Филология </a><br/>
		</p>		
			<?php
				function file_to_array($filename)
				{
					$rows = file($filename);
					$result = array();
					foreach($rows as $value)
					{
						$str = explode("\t", $value);
						$ident = intval($str[0]);
						$point = intval($str[1]);
						$result[ $ident ] = $point;
					}
					return $result;
				}

				function print_full_table($multiarray, $header, $limit)
				{
					echo "<p align='center'>\n";
					echo "<table border>\n";
					echo "<tr><td>Место</td>";
					foreach ($header as $head) {
						 echo "<td>".$head."</td>";
					}
					echo "</tr>\n";

					$position = 0;
					foreach ($multiarray as $row) {
						$position += 1;
						if ($position <= $limit) {
							echo "<tr bgcolor='silver'><td>".$position."</td>";
						} else { 
							echo "<tr><td>".$position."</td>";
						}
						foreach ($row as $point) {
							  echo "<td>".$point."</td>"; 
						}
						echo "</tr>\n";
					}
					echo "</table>\n";
					echo "</p>\n";
				}
				
				function merge($multiarray, $multiarraysize) {
					$result = array();
					foreach ($multiarray as $value) {
						$result = $result + $value;
					}
					foreach ($result as $ident => $value) {
						$result[ $ident ] = array_fill(0, $multiarraysize + 2, 0);
						$result[ $ident ][0] = $ident;

						$sum = 0;
						foreach ($multiarray as $index => $subject) {
							if (array_key_exists($ident, $subject)) {
								$result[ $ident ][ $index + 1 ] = $subject[ $ident ];
								$sum += $subject[ $ident ];
							}
							$result[ $ident ][$multiarraysize + 1] = $sum;
							
						}
					}
					return $result;
				}
				
				function sort_by_sum($multiarray, $multiarraysize) {
					$total_sum = array();
					foreach($multiarray as $point) {
						array_push($total_sum, $point[$multiarraysize + 1]);
					}
					array_multisort($total_sum, SORT_DESC, $multiarray);
					return $multiarray;
				}

				$identifier = "Пропуск";
				$total = "Сумма";
				$subject = array( 'm' => "Математика",
								  'e' => "Иностранный язык",
								  'r' => "Русский язык",
								  'p' => "Физика",
								  'g' => "География",
								  'l' => "Литература");
				$datafile = array( 'm' => "math",
								  'e' => "eng",
								  'r' => "rus",
								  'p' => "phys",
								  'g' => "geo",
								  'l' => "liter");
								  
				if (!empty($_GET["sub"])) {
					$superkey = str_split($_GET["sub"]);
					$data = array();
					foreach ($subject as $key => $value) {
						if (in_array($key, $superkey)) {	
							$file = $datafile[$key];
							$subj = $subject[$key];
							$data[$key] = file_to_array('data/'.$file.'.txt');
							$header = array($identifier, $subj);
						}
					}
					
					$multiarray = array();
					$header = array($identifier);
					$multiarraysize = 0;
					foreach ($subject as $key => $value) {
						if (in_array($key, $superkey)) {	
							array_push($multiarray, $data[$key]);
							array_push($header, $subject[$key]);
							$multiarraysize += 1;
						}
					}
					array_push($header, $total);					
					$merged_table = merge($multiarray, $multiarraysize);
					$merged_table = sort_by_sum($merged_table, $multiarraysize);
					$limit = 0;
					if (!empty($_GET["lim"]))
						$limit = intval($_GET["lim"]);
					print_full_table($merged_table, $header, $limit);
				}
			?>
		<p>
			Используйте ключи: <br/>
			m - математика <br/>
			r - русский язык <br/>
			e - английский язык <br/>
			p - физика <br/>
			g - география <br/>
			l - литература <br/>
			Например, для экзаменов по экономике: <br/>
			result.php?sub=mre
		</p>
	</body>
</html>

