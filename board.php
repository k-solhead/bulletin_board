<?php
require_once('./functions.php');

//データベースへの接続
$dbh = get_db_connect();
$errs = [];

if($_SERVER['REQUEST_METHOD'] === 'POST') {
  //フォームからのPOSTデータ取得
  $name = get_post('name');
  $comment = get_post('comment');
  //バリデーション（文字数チェック）
  if(!check_word($name, 50)) {
    $errs[] = 'お名前を修正してください。';
  }
  if(!check_word($comment, 200)) {
    $errs[] = 'コメント欄を修正してください。';
  }
  if(count($errs) === 0) {
    $result = insert_comment($dbh, $name, $comment);
  }
}
//全コメントデータの取得
$data = select_comment($dbh);

include_once('view.php');
