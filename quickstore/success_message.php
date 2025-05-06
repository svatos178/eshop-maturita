<?php if (isset($success) && $success) : ?>
  <h2>změny úspěšně uloženy</h2>
<?php endif ?>

<?php if (isset($fileUploadMessage)) : ?>
  <h2><?= $fileUploadMessage ?></h2>
<?php endif ?>