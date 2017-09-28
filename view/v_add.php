<div class="add_article">
	<form class = "block" action="" method="POST">
		<ul>
			<li
				<?php if(isset($errors['title'])):?>
					class = "error"
				<?php endif;?>	
			>
				<?php if(isset($errors['title'])):?>
					<p class="error">
						<?=$errors['title']?>
					</p>
				<?php endif;?>	
			    <p>Название статьи</p>
			    <input type="text" name="title" value="<?=isset($title) ? $title : ''?>">
			</li>
			<li
				<?php if(isset($errors['text'])):?>
					class = "error"
				<?php endif;?>	
			>
				<?php if(isset($errors['text'])):?>
					<p class="error">
						<?=$errors['text']?>
					</p>
				<?php endif;?>   
			    <p>Текст статьи</p>
			    <textarea name="text" cols = "50" rows="5"><?=isset($text) ? $text : ''?></textarea>
			</li>
			<li>     
			    <input type="submit" class="sub" value="Добавить статью">
			</li>    
	    </ul>
	</form>
	<a href="/">Вернуться на главную страницу</a>
</div>
