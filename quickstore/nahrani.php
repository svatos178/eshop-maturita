<?php

function nahrani(string $nazevProduktu)
{
  $target_dir = "fotky/";
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo(basename($_FILES["fotka"]["name"]), PATHINFO_EXTENSION));
  $target_file = $target_dir . $nazevProduktu . time() . "." . $imageFileType;

  $check = getimagesize($_FILES["fotka"]["tmp_name"]);
  if ($check !== false) {
    $uploadOk = 1;
  } else {
    $fileUploadMessage = "Soubor není fotka.";
    $uploadOk = 0;
  }

  // Check file size
  if ($_FILES["fotka"]["size"] > 2048000) {
    $fileUploadMessage = "Příliš velký soubor.";
    $uploadOk = 0;
  }

  // Allow certain file formats
  if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    $fileUploadMessage = "Nahrávejte pouze PNG, JPEG nebo JPG formát.";
    $uploadOk = 0;
  }

  if ($uploadOk == 1) {
    if (move_uploaded_file($_FILES["fotka"]["tmp_name"], $target_file)) {
      return ["file" => $target_file];
    } else {
      $fileUploadMessage = "Chyba při nahrávání souboru.";
    }
  }

  return ["message" => $fileUploadMessage];
}
