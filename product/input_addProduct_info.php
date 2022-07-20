<!Doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title></title>

    <!--css-->
    <link rel="stylesheet" href="css/input_addProduct_info.css">

</head>
<body>

<div id="splash">
<div id="splash-logo">loading now...</div>
</div>
<div class="splashbg"></div>


<div id="container">
<header id="header">
  <h1>Add a new Product</h1>
</header>

<main>
<h2>Please enter information about a new product</h2>
<form action="add_product.php" method="get">
<select name="new_product_type">
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

    $query = 'select * from type';

    //prepare
    $stmt = $pdo->prepare($query);

    //execute
    $stmt->execute();                                 
    
    $result = $stmt->fetchAll();

    foreach($result as $row){
        $type_id = $row["type_id"];
        $type_name = $row["name"];
        echo "<option value='" . strval($type_name) . "'>" . $type_name . "</option>";
    }
    
    echo "</select><br>";



} catch (PDOException $e){
    // 例外が発生したら無視
    //require_once 'exception_tpl.php';
    echo $e->getMessage();
    exit();
  }

?>
</select><br>

<input type="text" name="new_product_name" placeholder="新規商品名" required><br>
<input type="number" pattern="^[0-9]+$" name="new_product_price" placeholder="価格" required><br>
<input type='date' name='date' required><br>
<input type="hidden" name="user_name" value=<?php echo $_GET["user_name"]; ?>>
<input type='hidden' name='begin' value=<?php echo $_GET["begin"]; ?>>
<input type='hidden' name='size' value=<?php echo $_GET["size"]; ?>>

<input type="submit" name="submitBtn" value="　Add　">
</form>


</main>
</div>

<!--JQuery-->
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<!--javascript-->
<script type="text/javascript" src="javascript/input_addProduct.js"></script>

</body>
</html>