<?php
$user_id = $_GET["name"];
$password = $_GET["password"];
$begin = $_GET["begin"];
$size = $_GET["size"];
 
try{
  // データベースに接続
  $pdo = new PDO(
      // ホスト名、データベース名
      'mysql:host=localhost;dbname=order;',
      // ユーザー名
      'root',
      // パスワード
      '',
      // レコード列名をキーとして取得させる
      [ PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ]
  );
  
  // SQL文をセット
  $query = 'select * from users where user_id = :user_id and password = :password';
  $query1 = 'select * from products limit :begin, :size';

  // query
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':user_id', $user_id);
  $stmt->bindParam(':password', $password);
  $stmt->execute();
  $result = $stmt->fetchAll();
 
  // query1
  $stmt1 = $pdo->prepare($query1);
  $stmt1->bindValue(':begin', $begin, PDO::PARAM_INT);
  $stmt1->bindValue(':size', $size, PDO::PARAM_INT);
  $stmt1->execute();
  $result1 = $stmt1->fetchAll();

  // 処理
  if(empty($result)) {
    require_once 'login.html';
    echo "<div id='error-massage'>usernameまたはpasswordが違います</div>";
  } else {
    $user_name = $result[0]['name'];
    $password = $result[0]['password'];
    require_once 'viewSelect_tpl.php';
  }

  /*
  // ループして1レコードずつ取得
  foreach ($stmt as $row) {
      echo ($row["user_id"]);
      echo ", ";
      echo ($row["name"]);
      echo ", ";
      echo ($row["password"]);
      echo ", ";

  }
  #require_once 'login_tpl.php';
  */ 
} catch (PDOException $e){
  // 例外が発生したら無視
  //require_once 'exception_tpl.php';
  echo $e->getMessage();
  exit();
}
?>

<!--
<p><?php echo "ユーザー名：$user_id"; ?></p>
<p><?php echo "パスワード：$password"; ?></p>
-->

</body>
</html>