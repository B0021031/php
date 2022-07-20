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
    //$user_id = $_GET["user_id"];
    $begin = $_GET["begin"];
    $size = $_GET["size"];
    $order_status = $_GET["order_status"];

    $product_type = $_GET["product_type"];
    $product_id = $_GET["product_id"];
    $product_name = $_GET["product_name"];
    $product_price = $_GET["product_price"];
    $order_date = $_GET["order_date"];
    $status = $_GET["status"];
    //$order_status = 1;
    $order_user = $_GET["order_user"];

    // type_id を検索
    $query_tmp = "select type_id from type where name=:product_type";
    $stmt_tmp = $pdo->prepare($query_tmp);
    $stmt_tmp->bindParam(':product_type', $product_type);
    $stmt_tmp->execute();
    $product_type_id = $stmt_tmp->fetchAll()[0]["type_id"];

    
    // 上書き保存(product_idで一意に特定し、update で更新)  order_statusを消した
    $query = 'update products set type=:product_type_id, name=:product_name, price=:product_price, order_date=:order_date, order_user=:order_user where product_id=:product_id';
    $stmt = $pdo->prepare($query);
    $stmt->bindValue('product_type_id', $product_type_id, PDO::PARAM_INT);
    $stmt->bindValue(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->bindParam(':product_name', $product_name);
    $stmt->bindValue(':product_price', $product_price, PDO::PARAM_INT);
    $stmt->bindParam(':order_date', $order_date);
    //$stmt->bindValue(':order_status', $order_status, PDO::PARAM_INT);
    $stmt->bindParam('order_user', $order_user);
    $stmt->execute();
    $result = $stmt->fetchAll();

    $query_status = 'update status set status=:status where status_id=:order_status';
    $stmt = $pdo->prepare($query_status);
    $stmt->bindParam(':order_status', $order_status);
    $stmt->bindParam(':status', $status);
    $stmt->execute();
    
    // select * from products
    $query1 = 'select * from products limit :begin, :size';
    $stmt1 = $pdo->prepare($query1);
    $stmt1->bindValue(':begin', $begin, PDO::PARAM_INT);
    $stmt1->bindValue(':size', $size, PDO::PARAM_INT);
    $stmt1->execute();
    $result1 = $stmt1->fetchAll();

    require_once 'viewSelect_tpl.php';

      
} catch (PDOException $e){
    // 例外が発生したら無視
    //require_once 'viewSelect_tpl.php';
    echo $e->getMessage();
     exit();
}

?>