<?php
    $begin = $_GET["begin"];
    $size = $_GET["size"];
    $user_name = $_GET["user_name"];


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

    $query1 = 'select * from products limit :begin, :size';
    $query_tmp = 'select count(*) from products';

    //prepare
    $stmt1 = $pdo->prepare($query1);                     
    $stmt_tmp = $pdo->prepare($query_tmp);

    $stmt_tmp->execute();
    $result_tmp = $stmt_tmp->fetchAll();
    if ($result_tmp[0]["count(*)"]<= $begin){
        $begin = 0;
    }

    //bind
    $stmt1->bindValue(':begin', $begin, PDO::PARAM_INT);   
    $stmt1->bindValue(':size', $size, PDO::PARAM_INT);

     //execute
    $stmt1->execute();                                    
      

    $result1 = $stmt1->fetchAll();
    require_once 'viewSelect_tpl.php';
} catch (PDOException $e){
    // 例外が発生したら無視
    //require_once 'exception_tpl.php';
    echo $e->getMessage();
    exit();
  }

?>