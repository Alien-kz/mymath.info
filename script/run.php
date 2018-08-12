<head>
<style>
button, input, .block {
	padding:10px; 
	margin-bottom:10px; 
	font-size:2em;
}
.div_block {
	display: inline-block;
}
</style>

<?php
function convert($input) {
	$output = $input."\n";
	$output = str_replace("$","", $output);
	$output = str_replace("\\Sigma","Итог", $output);
	$output = str_replace("&","\t", $output);
	$output = str_replace("\\\\","", $output);
	$output = preg_replace("/\\\\[^\n]*\n/", "", $output);
	$output = preg_replace("/%[^\n]*\n/", "", $output);
	$output = preg_replace("/#[^\n]*\n/", "", $output);
	$output = preg_replace("/{[^\n]*\n/", "", $output);
	$output = preg_replace("/}[^\n]*\n/", "", $output);
	$output = preg_replace('/^[ \t]*[\r\n]+/m', '', $output);
	$output = str_replace("\r","", $output);
	return $output;
}

function check_attribute($attr) {
	return isset($_POST[$attr]) && $_POST[$attr] != "";
}

$input = "";

$output = "";
$file_output = "";
if (check_attribute('input')) {
	$input  = $_POST['input'];
	$output = convert($input);
	if (check_attribute('file')) {
		$file = $_POST['file'];
		$file_output = "../".$file;
		file_put_contents($file_output.".txt", $output);
	}
}
$file = "";
$file_input = "";
if (check_attribute('file')){
	$file = $_POST['file'];
	$file_input = "../".$file;
	$input = file_get_contents($file_input.".tex");
}
?>
</head>

<body>
<h1 align='center'> TeX таблица в TXT таблицу </h1>

<div align='center'>
<form action="run.php" method="post">
<div> <input type="hidden" id="input" name="input" value="<?php echo $input;?>" hidden> </div>
<div> <input name="file" size="50" value="<?php echo $file;?>"> </div>
<div><button>Загрузить</button></div>
</form>

<form action="run.php" method="post">
<div><button>Преобразовать</button></div>

<div>
<div class='div_block'> 
<div class='block'> <?php echo $file_input.".tex";?> </div>
<textarea name="input" cols="80" rows="50"><?php echo $input;?></textarea>
<div> <input type="hidden" id="file" name="file" value="<?php echo $file;?>" hidden> </div>
</div>

<div class='div_block'> 
<div class='block'> <?php echo $file_output.".txt";?>  </div>
<textarea cols="80" rows="50" autofocus readonly><?php echo $output;?></textarea> 
</div>
</div>

</form>
</div>
</body>
