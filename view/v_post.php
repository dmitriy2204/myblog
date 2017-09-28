<?php	
	$dt = date("d.m.Y", strtotime($article['dt'])); ?>
	<div class="article">
		<img src="/img/<?=$article['image']?>">
		<h2 class="title"><?=$article['title']?></h2>
		<div class="atricle_text">
			<?=$article['text']?>
		</div>
		<p>Дата добавления статьи: <?=$dt?></p>
	</div>
	<div id="return">
		<a href="/">Вернуться на главную страницу</a>
	</div>