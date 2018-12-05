<?php

var_dump($data);


foreach ($data as $value) {
echo "User: ".$value['user']."<br>";
echo "Message: ".$value['message']."<br>";
}