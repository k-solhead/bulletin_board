<?php
//エスケープ処理
function html_escape($word) {
  return htmlspecialchars($word, ENT_QUOTES, 'UTF-8');
}

//POSTデータを取得する
function get_post($key) {
  if(isset($_POST[$key])) {
    $var = trim($_POST[$key]);
    return $var;
  }
}

//バリデーション文字列の長さをチェックする
function check_word($word, $length) {
  if(mb_strlen($word) === 0) {
    return FALSE;
  } elseif (mb_strlen($word) > $length) {
    return FALSE;
  } else {
    return TRUE;
  }
}

//データベースに接続する
function get_db_connect() {
  try{
    $dsn = 'mysql:dbname=sample;host=localhost;charset=utf8';
    $user = 'root';
    $password = '';

    $dbh = new PDO($dsn, $user, $password);
  }catch (PDOException $e) {
    echo($e->getMessage());
    die();
  }
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  return $dbh;
}

//書き込みをデータベースに保存する
function insert_comment($dbh, $name, $comment) {

  $date = date('Y-m-d H:i:s');
  $sql = "INSERT INTO board (name, comment, created) VALUE (:name, :comment, '{$date}')";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':name', $name, PDO::PARAM_STR);
  $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
  if(!$stmt->execute()) {
    return 'データの書き込みに失敗しました。';
  }
}

//データベース保存の全コメントデータを取得する
function select_comment($dbh) {

  $sql = "SELECT name, comment, created FROM board";
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $data[] = $row;
  }
  return $data;
}