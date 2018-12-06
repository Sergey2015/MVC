<?php
 header("HTTP/1.x 404 Not Found");
header("Status: 404 Not Found");
//var_dump($_SERVER);
?>

<!DOCTYPE html>
<html>
<head>
	<title>404</title>
</head>
<body>
<div style="font-size: 30px">Страница не найдена</div>
Серверу передан заголовок со статусом 404. Ответ сервера 404
<br><br><a href="index.php">На главную</a>
</body>
</html>
