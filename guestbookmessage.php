<?php

//var_dump($data);

echo "<a href='{$_SERVER['SCRIPT_NAME']}?model={$request['model']}&command=create'>Написать сообщение</a><br><br>";
foreach ($data as $value) {
echo "User: ".$value['user']."<br>";
echo "Message: ".$value['message']."<br>";

echo "<a href='{$_SERVER['SCRIPT_NAME']}?model={$request['model']}&command=update&id={$value['id']}'>Изменить сообщение</a><br><br>";
}



