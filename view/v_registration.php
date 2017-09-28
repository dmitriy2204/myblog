<div class="add_user">
	<form class = "block" action="" method = "POST">
		<?php if($message):?>
			<div class="error">
				<?=$message?>
			</div>
		<?php endif;?>
		<ul>
			<li
				<?php if(isset($errors['login'])):?>
					class = "error"
				<?php endif;?>	
			>
				<p>Ваш логин:</p>
				<?php if(isset($errors['login'])):?>
					<p class = "error">
						<?=$errors['login']?>
					</p>
				<?php endif;?>	
				<input type="text" name="login" value = "<?=$post['login']?>">
			</li>

			<li
				<?php if(isset($errors['email'])):?>
					class = "error"
				<?php endif;?>	
			>
				<p>Ваш email:</p>
				<?php if(isset($errors['email'])):?>
					<p class = "error">
						<?=$errors['email']?>
					</p>
				<?php endif;?>	
				<input type="text" name="email" value = "<?=$post['email']?>">
			</li>

			<li
				<?php if(isset($errors['password'])):?>
					class = "error"
				<?php endif;?>	
			>
				<p>Ваш пароль:</p>
				<?php if(isset($errors['password'])):?>
					<p class = "error">
						<?=$errors['password']?>
					</p>
				<?php endif;?>
				<input type="password" name="password">
			</li>

			<li
				<?php if(isset($errors['password'])):?>
					class = "error"
				<?php endif;?>	
			>
				<p>Введите пароль еще раз:</p>
				<?php if(isset($errors['password'])):?>
					<p class = "error">
						<?=$errors['password']?>
					</p>
				<?php endif;?>
				<input type="password" name="password2">
			</li>

			<li>	
				<p><button type="submit" name="signup">Зарегистрироваться</button></p>
			</li>	
		</ul>
	</form>

	<br>
	<a href="/">Вернуться на главную страницу</a>
</div>