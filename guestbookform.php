<?php

?>
<div>
    <form action="<?=$_SERVER['SCRIPT_NAME']?>?model=<?=$request['model']?>&command=<?=$request['command']?>&page=<?=$request['page']?><?=$request['command']=='update'?"&id={$request['id']}":''?>" method="POST">
        <?= isset($data['error'])?"<p>{$data['error']}</p>":''?>
        <p>Ваше имя<br><input type="text" size="25" name="user" value="<?=$request['command']=='update'?$data[0]['user']:''?>" maxlength="25" ></p>
        <p>Ваше сообщение<br><textarea name="message" rows="10" cols="40" maxlength="2000" ><?=$request['command']=='update'?$data[0]['user']:''?></textarea></p>
        <p><input type="submit" value="Отправить"></p>
    </form>
</div>
