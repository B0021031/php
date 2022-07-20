<!Doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title></title>

    <!--css-->
    <link rel="stylesheet" href="css/edit_product.css">

</head>
<body>

<div id="splash">
    <div id="splash-logo">loading now...</div>
  </div> 

<div class="splashbg"></div>

<div id="container">
  <header id="header">
    <h1>Edit Product Information</h1>
  </header>

<main>
<h2>Please Edit Product Information</h2>
<?php
$product_id = $_GET["product_id"];
$user_name =$_GET["user_name"];
//$user_id = $_GET["user_id"];
$begin = $_GET["begin"];
$size = $_GET["size"];
//$product_name = $_GET["product_name"];
//$product_price = $_GET["product_price"];
//$user_name = $_GET["user_name"];
//$password = $_GET["password"];

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

  $kind_of_status = array('発注済', '納品済', '未発注');
  
  // SQL文をセット
  //$query = 'select * from products where name=:product_name and price=:product_price';
  $query = 'select * from products where product_id = :product_id';
  $query1 = 'select * from type';
  $query_tmp = 'select type from products where product_id=:product_id'; 

  // prepare
  $stmt = $pdo->prepare($query);
  $stmt1 = $pdo->prepare($query1);
  $tmp = $pdo->prepare($query_tmp);
  
  //$stmt->bindParam(':product_name', $product_name);
  //$stmt->bindValue(':product_price', $product_price, PDO::PARAM_INT);
  $stmt->bindValue(':product_id', $product_id, PDO::PARAM_INT);
  $tmp->bindValue(':product_id', $product_id, PDO::PARAM_INT);
  

  // execute
  $stmt->execute();
  $stmt1->execute();
  $tmp->execute();
  
  $result = $stmt->fetchAll();
  $result1 = $stmt1->fetchAll();
  $type = $tmp->fetchAll()[0]["type"];

  // status.status_id = products.order_status (商品の状態を取得)
  $order_status = $result[0]["order_status"];
  $query_status = 'select status from status where status_id=:order_status';  // status_id = order_status
  $stmt_status = $pdo->prepare($query_status);
  $stmt_status->bindValue(':order_status', $order_status, PDO::PARAM_INT);
  $stmt_status->execute();
  $status = $stmt_status->fetchAll()[0]["status"];

  // 更新
  echo "<form action='edit_product.php'>";
  echo "分類　　　<select name='product_type'>";
  foreach($result1 as $row){
    $type_id = $row["type_id"];
    $type_name = $row["name"];

    if ($row["type_id"]==$type){
    echo "<option value='" . strval($type_name) . "' selected >" . $type_name . "</option>";
    }
    else {
      echo "<option value='" . strval($type_name) . "'>" . $type_name . "</option>";
    }
  }
  echo "</select><br>";

  foreach($result as $row){
    $product_id = $row["product_id"];
    $name = $row["name"];
    $price = $row["price"];
    $order_date = $row["order_date"];
    $order_status = $row["order_status"];
    $order_user = $row["order_user"];
                                  
    //echo "id：<input type='text' name='product_id' value='$product_id'><br>";
    echo "<input type='hidden' name='product_id' value='$product_id'>";
    echo "商品名　　<input type='text' name='product_name' placeholder='商品名' value='$name' required><br>";
    echo "価格　　　<input type='number' name='product_price' placeholder='価格' value='$price' required><br>";
    echo "注文日時　<input type='date' name='order_date' value='$order_date' required><br>";

    echo "状態　　　";
    echo "<select name='status'>";
    foreach($kind_of_status as $row){  
      if ($row==$status){
      echo "<option value='" . $row . "' selected >" . $row . "</option>";
      }
      else {
        echo "<option value='" . $row . "'>" . $row . "</option>";
      }
    }
    echo "</select><br>";

    echo "注文者　　<input type='text' name='order_user' placeholder='注文者' value='$order_user' readonly><br>";
    echo "<p></p>";
  }

  // ok_button
  echo "<table>";
  echo "<tr>";
  echo "<td>";
  echo "<input type='hidden' name='user_name' value='$user_name'>";
  //echo "<input type='hidden' name='user_id' value='$user_id'>";
  echo "<input type='hidden' name='begin' value='$begin'>";
  echo "<input type='hidden' name='size' value='$size'>";
  echo "<input type='hidden' name='order_status' value='$order_status'>";
  echo "<input type='submit' name='submitBtn' value='OK'>";
  echo "</form>";
  echo "</td>";

  // delete_button
  echo "<td>";
  echo "<form action='confirm_deleted_product_info.php'>";
  echo "<input type='hidden' name='product_id' value='$product_id'>";
  echo "<input type='hidden' name='user_name' value='$user_name'>";
  echo "<input type='hidden' name='begin' value='$begin'>";
  echo "<input type='hidden' name='size' value='$size'>";
  echo "<input type='hidden' name='order_status' value='$order_status'>";
  echo "<input type='submit' name='submitBtn' value='Delete'>";
  echo "</form>";
  echo "</td>";
  echo "</tr>";
  echo "</table>";

} catch (PDOException $e) {
    // 例外が発生したら無視
    //require_once 'exception_tpl.php';
    echo $e->getMessage();
    exit();
}
?>
</main>
</div><!---#container-->

<!--JQuery-->
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<!--javascript-->
<script type="text/javascript" src="javascript/edit_product.js"></script>
</body>
</html>