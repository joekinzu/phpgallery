<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Документ без названия</title>
</head>

<body>



<?php
$start = microtime(true);

$myFile = "file.txt";

$file = fopen($myFile,"r");

if (!$file)
{
	echo "Ошибка открытия файла <br>";
}
else
{
	$buffer = "";
	while (!feof($file))
	{
		$buffer .= fread($file,1);
	}
	echo $buffer . "<br>";
	fclose($file);
}

$file = fopen("file.txt", "r");
$buffer = '';
$buffer = fread($file, filesize("file.txt"));
echo "$buffer <br>";
fclose($file);

echo file_get_contents("file.txt") . "<br>";

echo file_get_contents("my_file.txt") . "<br>";
echo file_get_contents("my_file2.txt") . "<br>";

$f1 = fopen("my_file.txt","w");
$f2 = fopen("my_file2.txt","a");

$text = "Текст запишем в файл";
if ($count = fwrite($f1,$text))
{
	echo "Количество записанных байт равно $count <br>";
}
else
{
	echo "Ошибка записи в файл <br>";
}

$text2 = "Текст для добавления в файл";
if ($count = fwrite($f2,$text2,6))
{
	echo "Количество записанных байт равно $count <br>";
}
else
{
	echo "Ошибка записи в файл <br>";
}

echo file_get_contents("my_file.txt") . "<br>";
echo file_get_contents("my_file2.txt") . "<br>";


?>

<br><br>

<form action="?" method="post" enctype="multipart/form-data">
	<input type="file" name="myfiles"/>
	<input type="submit" value="Отправить файл"/>
</form>



<?php

echo "<pre>";
print_r($_FILES);
echo "</pre>";

$destination = $_FILES['myfiles']['name'];
if (move_uploaded_file($_FILES['myfiles']['tmp_name'],$destination))
{
	echo "Файл загружен успешно <br>";
}
else
{
	echo "Ошибка загрузки файла <br>";
}

 
echo "Время выполнения скрипта: " . (microtime(true) - $start) . " сек.";
?>





<p>Конец загрузки файлов</p>


<?php

//---------Пример №1 создание файла------------
$h = fopen("my_file.html","w"); 
/* открывает на запись файл my_file.html,
если он существует, или создает пустой 
файл с таким именем, если его еще нет */
$h = fopen("file/another_file.txt","w+"); 
/* открывает на запись и чтение или создает
файл another_file.txt в директории file */
//$h = fopen("http://php1-4/file.txt","r");
/* открывает на чтение файл, находящийся по 
указанному адресу*/
?>

<?php
//----------Пример №2 запись данных в файл-------------
$h = fopen("my_file.html","w");
$text = "Этот текст запишем в файл.";
if ($count = fwrite($h,$text)) 
  echo "Запись прошла успешно. Количество записаных байт: ".$count;
else 
  echo "Произошла ошибка при записи данных";
fclose($h);
?>

<?php
//----------Пример №3 добавление данных в файл ------------
$h = fopen("my_file.html","a"); 
$add_text = "Добавим текст в файл.";
if($count = fwrite($h,$add_text,7)) 
  echo "Добавление текста прошло успешно. Количество байт".$count;
else echo "Произошла ошибка при 
   добавлении данных<br>";
fclose($h);
?>

<?php
//----------Пример 4 считывание данных их файла------------
$h = fopen("my_file.html","r+");    
// открываем файл на запись и чтение
$content = fread($h, filesize("my_file.html"));
// считываем содержимое файла в строку
fclose($h); // закрываем соединение с файлом
echo "<br>".$content."<br>"; 
// выводим содержимое файла 
// на экран браузера
?>


<?php
//---------------Пример №5 считывание из файла строки текста--------------
$h = fopen("my_file.html", "r+");
$content = fgets($h,10);
fclose($h);
echo "<br> $content <br>";
?>

<?php
//-------------Пример №6 считывание файла целиком-------------
$h = fopen("my_file.html", "r");
while(!feof($h)){
	$content = fgets($h);
	echo "<br> $content <br>";
}

?>

<?php
//------------Пример №7 fgetss считывание без тегов
$h = fopen("my_file.html","r");
while (!feof ($h)) 
{
    $content = fgetss($h,1024,'<b><i>');
   echo $content,"<br>";
}
fclose($h);
?>

<?php
//-----------Пример 8 использование readfile ------------
$n = @readfile ("my_file.html"); 
/* выводит на экран содержимое файла и 
записывает его размер в переменную $n */
if (!$n) echo "Error in readfile"; 
/* если функция readfile() выполнилась 
с ошибкой, то $n=false и выводим 
сообщение об ошибке */
else echo "Число считанных символов".$n."<br>";   
  // если ошибки не было, то выводим число
  // считанных символов
?>

<?php
// -------------Пример 9 считывание файла в массив ---------------
$arr = file ("my_file.html"); 
foreach($arr as $i => $a) echo $i,": ", 
    htmlspecialchars($a), "<br>";
?>

<form enctype="multipart/form-data" action="?" method="post">
  <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
  Загрузить файл: <input type="file" name="myfile" /><br>
  <input type="submit" value="Отправить файл" name="OneFile" />
</form>
<? 

echo "<pre>";
print_r($_FILES);
echo "</pre>";
//-----------Прмер 10 Загрузка одного файла ---------------
if (isset($_POST['OneFile']))
{
$uploaddir = 'file/';     
    // будем сохранять загружаемые 
    // файлы в эту директорию
$destination = $uploaddir.$_FILES['myfile']['name'];
    // имя файла оставим неизменным
print "<pre>";
 if (move_uploaded_file($_FILES['myfile']['tmp_name'],$destination)) 
{ 
/* перемещаем файл из временной папки 
в выбранную директорию для хранения */
    print "Файл успешно загружен <br>";
} else 
{
  echo "Произошла ошибка при загрузке файла.
    Некоторая отладочная информация:<br>";
    print_r($_FILES);
}
print "</pre>"; 
}

echo 'Время выполнения скрипта: '.(microtime(true) - $start).' сек.';


$test = true;
var_dump(!$test);
var_dump($test);
?>




</body>
</html>