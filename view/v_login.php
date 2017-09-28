<div class="login_form">
	<?php if($message):?>
			<div class="error">
				<?=$message?>
			</div>
		<?php endif;?>

	<div>
		<form class = "block" action="" method = "POST">
			<ul>
				<li
					<?php if(isset($errors['login'])):?>
						class = "error"
					<?php endif;?>	
				>
					<?php if(isset($errors['login'])):?>
						<p class = "error">
							<?=$errors['login']?>
						</p>
					<?php endif;?>
					<input type="text" name="login" placeholder = "Логин" value = "<?=$post['login']?>">
				</li>

				<li
					<?php if(isset($errors['login'])):?>
						class = "error"
					<?php endif;?>	
				>
					<?php if(isset($errors['password'])):?>
						<p class = "error">
							<?=$errors['password']?>
						</p>
					<?php endif;?>
					<input type="password" name="password" placeholder="Пароль" class="field"><br>
				</li>

				<li>
					<input type="checkbox" name="remember">Запомнить меня
				</li>

				<li>
					<input type="submit" value="Войти" class="field">
				</li>
			</ul>
		</form>
	</div>	
		<a href="/" class="btn">Вернуться на главную страницу</a>
</div>