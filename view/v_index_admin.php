<div class="items">
	<div class="v_index_admin_items">
		<div class="article_title">Мои статьи</div>
		<?php 
		
		foreach($posts as $post){ ?>
			<div class="item">
				<div class="article_title">
					<strong><a href="/admin/post/one?id=<?=$post['id']?>"><?=$post['title']?></a></strong>
					<a href="/admin/post/edit?id=<?=$post['id']?>" class="btn1">Редакт.</a>
					<a href="/admin/post/del?id=<?=$post['id']?>" class="btn1">Удалить</a>
				</div>
			</div>	
		<?php } ?>	
	</div>
	<div class="v_index_admin_items">
		<div class="article_title">Список пользователей</div>
		<?php
		foreach($users as $user){ ?>
			<div class="item">
				<div class="article_title">
					<strong><a href="/admin/user/one?id=<?=$user['id']?>"><?=$user['login']?></a></strong>
					<a href="/admin/user/del?id=<?=$user['id']?>" class="btn1">Удалить</a>
				</div>
			</div>	
		<?php } ?>	
	</div>
	
	<p><a href="/admin/post/add" class="btn">Добавить статью</a></p>
	<p><a href="/" class="btn">Выйти из админки</a></p>
	<div class="buttons">
		<a href="/admin/user/add" class="btn">Зарегистрировать пользователя</a>
	</div>	
</div>