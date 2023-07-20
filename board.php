<?php
require_once('functions.php');

$errs = [];
$data = [];
$dbh = get_db_connect();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = get_post('name');
  $comment = get_post('comment');

  if(check_word($name, 50)) {
    $errs = 'お名前を修正してください。';
  }
  if(check_word($comment, 200)) {
    $errs = 'コメント欄を修正してください。';
  }
  if(count($errs) === 0) {
    $result = insert_comment($dbh, $name, $comment);
  }
}

$data = select_comment($dbh);

include_once('view.php');
