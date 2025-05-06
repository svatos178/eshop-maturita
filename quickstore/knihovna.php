<?php
function import_file (string $filename): string {
  return $filename . "?v=" . md5(filemtime($filename));
}