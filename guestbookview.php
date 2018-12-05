<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $request['model'] ?></title>
</head>
<body>
<?php
if ($request['command'] == 'read') {
    include 'guestbookmessage.php';
} else {
    include 'guestbookform.php';
}
?>
</body>
</html>
