<div class="items">
	
	<?php 
		foreach($posts as $post){ ?>
			<div class="item">
				<div class="article_title">
					<strong><a href="/post/one?id=<?=$post['id']?>"><?=$post['title']?></a></strong>
				</div>
				<img src="/img/<?=$post['image']?>">
				<?=$post['text']?>
			</div>	
	<?php } ?>	
	<div class="buttons">
		<a href="/user/login" class="btn">Войти</a><span> || </span>
		<a href="/user/add" class="btn">Зарегистрироваться</a>
	</div>	
	<p><a href="/login" class="btn">Выйти</a></p>
</div>