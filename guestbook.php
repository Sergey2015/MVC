<?php

function runmodel($request) {
    $request = validate($request);
    $data = $request['command']($request);
   // var_dump($data);
    return $data;
}

function create($request) {
$request = validate($request);
    if ($_POST) {
   
        //Данные получены в POST, их нужно тщательно проверить,
        //здесь в примере они берутся без особой проверки (только на пустоту)
        //нужно написать и вызвать здесь функцию проверки полученных даныых
        $data['user'] = $_POST['user'];
        $data['message'] = $_POST['message'];
        $data = validate($data);
        if (empty($data['user']) || empty($data['message'])) {
            $data['error'] = 'Все поля должны быть заполнены';
            return $data;
        }
        if (!$mysqli = connect()) {
            $data['error'] = 'Не удалось подключиться к базе данных';
            return $data;
        }

        $data['user'] = mysqli_real_escape_string($mysqli, $data['user']);
        $data['message'] = mysqli_real_escape_string($mysqli, $data['message']);
        $sql = "INSERT INTO guestbook (user, message) VALUES ('{$data['user']}','{$data['message']}')";
        if ($result = mysqli_query($mysqli, $sql)) {

            //Данные добавлены, перезапрос 1 страницы, где они отобразятся
            header("Location: http://{$_SERVER['SERVER_NAME']}:8888{$_SERVER['SCRIPT_NAME']}?model={$request['model']}&page=1");
            exit();
        } else {
            echo mysqli_errno($mysqli) . ": " . mysqli_error($mysqli) . "\n";
            $data['error'] = 'Не удалось добавить данные';
        }
    } else {
        //данные по умолчанию для формы добавления будут пустыми
        $data['user'] = '';
        $data['message'] = '';
    }
   
   // var_dump($data);
    return $data;
}

function read($request) {
    $request = validate($request);
    if (!$mysqli = connect()) {
        $data['error'] = 'Не удалось подключиться к базе данных';
        return $data;
    }
    $sql = 'SELECT COUNT(*) FROM guestbook';
    if (!($result = mysqli_query($mysqli, $sql))) {
        $data['error'] = 'Ошибка запроса количества сообщений';
        return $data;
    }
    $row = mysqli_fetch_row($result);
     $itemsCount = $row[0];

    mysqli_free_result($result);
    $pagesCount = ceil($itemsCount / ITEMSPERPAGE);
    if ($request['page'] > $pagesCount) {
        showPage404();
        $data['error'] = 'Запрошенная Вами страница не найдена';
        return $data;
    }
    $firstRow = ($request['page'] - 1) * ITEMSPERPAGE;
    $sql = "SELECT id, user, message, messagetime FROM guestbook ORDER BY id DESC LIMIT $firstRow," . ITEMSPERPAGE;
    if (!($result = mysqli_query($mysqli, $sql))) {
        $data['error'] = 'Ошибка запроса сообщений';
        return $data;
    }
    //$asd = 1;
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_close($mysqli);
   // echo "$pagesCount";


    return $data;
}

function update($request) {
//Аналогично create, только для формы нужно данные взять из базы
     $request = validate($request);
    if ($_GET['command']=="update") {

    $data['id'] = $_GET['id'];
  // var_dump($_REQUEST); 
    if ($_POST) {
        //Данные получены в POST, их нужно тщательно проверить,
        //здесь в примере они берутся без особой проверки (только на пустоту)
        //нужно написать и вызвать здесь функцию проверки полученных даныых
        $data['user'] = $_POST['user'];
        $data['message'] = $_POST['message'];
        
        if (empty($data['user']) || empty($data['message'])) {
            $data['error'] = 'Все поля должны быть заполнены';
            return $data;
        }
        if (!$mysqli = connect()) {
            $data['error'] = 'Не удалось подключиться к базе данных';
            return $data;
        }
        $data['user'] = mysqli_real_escape_string($mysqli, $data['user']);
        $data['message'] = mysqli_real_escape_string($mysqli, $data['message']);
$data = validate($data);

        $sql = "UPDATE guestbook SET user='{$data['user']}', message='{$data['message']}' WHERE id='{$data['id']}'";
        if ($result = mysqli_query($mysqli, $sql)) {

            //Данные добавлены, перезапрос 1 страницы, где они отобразятся
            header("Location: http://{$_SERVER['SERVER_NAME']}:8888{$_SERVER['SCRIPT_NAME']}?model={$request['model']}&page=1");
            exit();
        } else {
            echo mysqli_errno($mysqli) . ": " . mysqli_error($mysqli) . "\n";
            $data['error'] = 'Не удалось добавить данные';
        }
    } else {

$sql = "SELECT id, user, message, messagetime FROM guestbook WHERE id='{$data['id']}'";
    if (!$mysqli = connect()) {
            $data['error'] = 'Не удалось подключиться к базе данных';
            return $data;
        }
if (!($result = mysqli_query($mysqli, $sql))) {
        $data['error'] = 'Ошибка запроса количества сообщений';
        return $data;
    }

    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
   
    
    mysqli_close($mysqli);
 

    }
    return $data;
} 


}

function delete($request) {
    $request = validate($request);
 if ($_GET['command']=="delete") {
    $data['id']=$_GET['id'];
        if (!$mysqli = connect()) {
            $data['error'] = 'Не удалось подключиться к базе данных';
            return $data;
        }
        $sql = "DELETE FROM guestbook WHERE id='{$data['id']}'";
        if ($result = mysqli_query($mysqli, $sql)) {

            //Данные добавлены, перезапрос 1 страницы, где они отобразятся
            header("Location: http://{$_SERVER['SERVER_NAME']}:8888{$_SERVER['SCRIPT_NAME']}?model={$request['model']}&page=1");
            exit();
        } else {
            echo mysqli_errno($mysqli) . ": " . mysqli_error($mysqli) . "\n";
            $data['error'] = 'Не удалось добавить данные';
        }
    } else {
        //данные по умолчанию для формы добавления будут пустыми
        $data['user'] = '';
        $data['message'] = '';
    }
    return $data;
} 


function connect() {
    if (!($mysqli = mysqli_connect(HOST, USER, PASSWORD, DATABASE)))
        return false;
    if (!mysqli_set_charset($mysqli, 'utf8'))
        return false;
    return $mysqli;
}


//пагинация
//var_dump($request);
function showPagination ($request) {
  if (!isset($_GET['page'])) {
      $_GET['page']=1;
  }
   $request = validate($request);
if (!$mysqli = connect()) {
        $data['error'] = 'Не удалось подключиться к базе данных';
        return $data;
    }
    $sql = 'SELECT COUNT(*) FROM guestbook';
    if (!($result = mysqli_query($mysqli, $sql))) {
        $data['error'] = 'Ошибка запроса количества сообщений';
        return $data;
    }
    $row = mysqli_fetch_row($result);
     $itemsCount = $row[0];

    mysqli_free_result($result);
    $pagesCount = ceil($itemsCount / ITEMSPERPAGE);
    


for($i=1;$i<=$pagesCount;$i++) {
   if ($_GET['page'] ==$i) {

   echo "<b>$i</b>";
}
else echo '<a href="'.$_SERVER['PHP_SELF'].'?page='.$i.'"> '.$i." </a>\n";
}
}
function showPage404 () {
     header("Location: 404.php");

exit();
}
//$data = ["\"{111}'vv'(222)<script>","dfgdfgdfg"];

function validate ($data) {
//$data = filter_input_array($data);
  //  $data = filter_var_array($data);
   // $data = filter_var($data, FILTER_SANITIZE_STRING);
    
    foreach ($data as &$value) {
        $value = trim($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value);
       // $data['page'] = "234vddfgdg";
        if (isset($data['page'])) {
            $data['page'] = intval($data['page']);
        }
        if (isset($data['id'])) {
            $data['id'] = intval($data['id']);
        }
       // echo "$value<br>";
    }


return $data;

}

//var_dump(validate($data));




