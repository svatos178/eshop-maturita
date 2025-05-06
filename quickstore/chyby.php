<?php
if (count($errors) > 0) : ?>
	<div class="error">
		<?php foreach ($errors as $error) : ?>
			<h2 class="error"><?php echo $error ?></h2>
		<?php endforeach ?>
	</div>
<?php endif ?>