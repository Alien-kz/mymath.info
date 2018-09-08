<!doctype html>
<html>
<head>
<style>
label {
	display:block;
}
textarea {
	display:block;
}
.row {
	display:inline-block;
}
a {
	border:1px solid blue;
	padding:5px;
}
</style>
<?php
include_once "tex2txt.php";
include_once "html2txt.php";

function check_post($attr) {
	return isset($_POST[$attr]) && $_POST[$attr] != "";
}
function check_get($attr) {
	return isset($_GET[$attr]) && $_GET[$attr] != "";
}

$converter_type = "";
$converter_name = "";
$suffix_input = "";
$suffix_output = "";
if (check_get('type')){
	$converter_type = $_GET['type'];
	if ($converter_type == "tex2txt") {
		$converter_name = "TeX-таблица | txt-таблица";
		$suffix_input = ".tex";
		$suffix_output = ".txt";
	}
	if ($converter_type == "html2txt") {
		$converter_name = "html-таблица | txt-таблица";
		$suffix_input = ".html";
		$suffix_output = ".txt";
	}
}

$file_input= "";
$file_output = "";
$text_input = "";
$text_output = "";

if (check_post('file_input')){
	$file_input = $_POST['file_input'];
}
if (check_post('file_output')){
	$file_output = $_POST['file_output'];
} else {
	$file_output = $file_input;
}


if (check_get('load')) {
	if (check_post('file_input')){
		$text_input = file_get_contents("../".$file_input.$suffix_input);
		$text_input = iconv("windows-1251", "utf-8", $text_input);
	}
} else {
	if (check_post('text_input')) {
		$text_input = $_POST['text_input'];
		if ($converter_type == "tex2txt") {
			$text_output = convert_tex_txt($text_input);
		}
		if ($converter_type == "html2txt") {
			$text_output = $text_input;
			$text_output = html_results_crop($text_output);
			$text_output = convert_html_txt($text_output);
		}
		if (check_post('file_output')) {
			$file_output = $_POST['file_output'];
			file_put_contents("../".$file_output.$suffix_output, $text_output);
		}
	}
}

$show_input = show_html($text_input);
$show_output = show_html($text_output);
?>
</head>

<body>

<div align='center'>
<a href='run.php?type=tex2txt'>tex | txt</a>
<a href='run.php?type=html2txt'>html | txt</a>
</div>

<h1 align='center'> <?php echo $converter_name;?> </h1>

<div align='center'>
 <form action="run.php?load=file&amp;type=<?php echo $converter_type;?>" method="post">
 <div>
 <span> <input name="file_input" size="20" value="<?php echo $file_input;?>"> <?php echo $suffix_input;?> </span>
 <span> <button>Загрузить</button></span>
 </div>
 </form>
</div>

<div align='center'>
 <form action="run.php?type=<?php echo $converter_type;?>" method="post">
 <div>
 <input type="hidden" id="file_input" name="file_input" value="<?php echo $file_input;?>" hidden>
 <span> <input name="file_output" size="20" value="<?php echo $file_output;?>"> <?php echo $suffix_output;?> </span>
 <span> <button>Преобразовать</button> </span>
 </div>

 <div class="row">
 <label for="input"> <?php echo $file_input.$suffix_input;?> </label>
 <textarea id="text_input" name="text_input" cols="80" rows="50"><?php echo $show_input;?></textarea>
 </div>

 <div class="row"> 
 <label for="output"> <?php echo $file_output.$suffix_output;?> </label>
 <textarea id="text_output" cols="80" rows="50" autofocus readonly><?php echo $show_output;?></textarea>
 </div>
 </form>
</div>

</body>
</html>
