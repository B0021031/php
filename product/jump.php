<?php

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

    $user_name = $_GET["user_name"];
    $begin = $_GET["begin"];
    $size = $_GET["size"];

    // query1
    $query1 = 'select * from products limit :begin, :size';
    $stmt1 = $pdo->prepare($query1);
    $stmt1->bindValue(':begin', $begin, PDO::PARAM_INT);
    $stmt1->bindValue(':size', $size, PDO::PARAM_INT);
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
