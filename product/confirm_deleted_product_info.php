<!Doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title></title>

    <!--css-->
    <link rel="stylesheet" href="css/delete_product.css">

</head>
<body>

<div id="splash">
<div id="splash-logo"></div>
</div>

<div class="splashbg"></div>

<?php

$product_id = $_GET["product_id"];
$user_name = $_GET["user_name"];
$begin = $_GET["begin"];
$size = $_GET["size"];
$order_status = $_GET["order_status"];


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


    // query
    $query = 'select * from products where product_id=:product_id';
    $query_status = 'select status from status where status_id=:order_status';

    // prepare
    $stmt = $pdo->prepare($query);
    $stmt_status = $pdo->prepare($query_status);

    // bind
    $stmt->bindValue(':product_id', $product_id, PDO::PARAM_INT);
    $stmt_status->bindValue(':order_status', $order_status, PDO::PARAM_INT);

    // execute
    $stmt->execute();
    $stmt_status->execute();

    $result = $stmt->fetchAll();
    $status = $stmt_status->fetchAll()[0]["status"];

    echo "<div id='container'>";

    echo "<header id='header'>";
    echo "<h1>Remove a product</h1>";
    echo "</header>";

    echo "<main>";
    echo "<h2>Are you sure you want to remove this?</h2>";
    echo "<form action='delete_product.php' name='contents'>";

    foreach($result as $row){
        echo "<p></p>";
        echo "ID　　　$product_id<br>";
        echo "商品名　" . $row['name'] . "<br>";
        echo "価格　　" . $row['price'] . "<br>";
        echo "注文日　" . $row['order_date'] . "<br>";
        echo "状態　　" . $status . "<br>";
        echo "注文者　" . $row['order_user'] . "<br>";
    }

    echo "<table>";
    echo "<tr>";
    echo "<td>";
    echo "<input type='submit' name='submitBtn' value='Yes'>";
    echo "<input type='hidden' name='user_name' value='$user_name'>";
    echo "<input type='hidden' name='product_id' value='$product_id'>";
    echo "<input type='hidden' name='begin' value='$begin'>";
    echo "<input type='hidden' name='size' value='$size'>";
    echo "<input type='hidden' name='order_status' value='$order_status'>";
    echo "</form>";
    echo "</td>";

    echo "<td>";
    echo "<form action='jump.php'>";
    echo "<input type='submit' name='submitBtn' value='No'>";
    echo "<input type='hidden' name='user_name' value='$user_name'>";
    echo "<input type='hidden' name='begin' value='$begin'>";
    echo "<input type='hidden' name='size' value='$size'>";
    echo "</form>"; 
    echo "</td>";
    echo "</tr>";
    echo "</table>";

    echo "</main>";
    echo "</div>";


} catch (PDOException $e){
    // 例外が発生したら無視
    //require_once 'exception_tpl.php';
    echo $e->getMessage();
    exit();
}
?>

<!--JQuery-->
<!--<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>-->
<!--javascript-->
<!--<script type="text/javascript" src="javascript/delete_loading.js"></script>-->

</body>
</html>