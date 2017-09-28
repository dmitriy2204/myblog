<form action="" method="post">
  	<p>Название статьи</p>
    <input type="text" name="title" value="<?=$title?>">
    <p>Текст статьи</p>
    <textarea name="text" cols = "50" rows="5"><?=$text?></textarea>
    <input type="submit" class="sub" value="Добавить статью">
</form>
<p><?=$msg?></p>
