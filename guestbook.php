<?php

function runModel($request) {
$sss = $request['command'] ($request); // будет вызвана функция, которая называется по значению параметра

return $sss;
}

function create ($request) {
}


function read($request) {
	$pagesCount = 10;
	$mysqli = connect();
	$sql = 'SELECT COUNT(*) FROM guestbook';
	if (!$result=mysqli_query($mysqli, $sql)) {
		die ('ошибка запроса');
	}
		$row = mysqli_fetch_row($result);
		$itemsCount = $row[0];
		mysqli_free_result ($result);
		$pageCounts = ceil($itemsCount/ITEMSPERPAGE);
		if ($request['page']>$pagesCount) die('Страница не найдена');
		$firstRow = ($request['page']-1)*ITEMSPERPAGE;
		$sql = "SELECT * FROM guestbook ORDER BY id DESC LIMIT $firstRow, " . ITEMSPERPAGE;
		if (!($result=mysqli_query($mysqli,$sql))) {
			die("не вышло..");
		}



		$row2 = mysqli_fetch_row($result);
		//var_dump($row2);
		
		return $row2;
		
	

	//exit();
	
}
//read("read");


function update ($request) {

}

function delete ($request) {
	
}

function connect () {
	if (!($link = mysqli_connect(HOST, USER, PASSWORD, DATABASE)))
		die("облом");
	if (!mysqli_set_charset($link, 'utf8')) 
		die("облом2");
	return $link;
	
}




