<!Doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<php?
  $user_name = $_GET["user_name"];
  $type = $_GET["new_product_type"];
  $name = $_GET["new_product_name"];
  $price = $_GET["new_product_price"];
  $date = strval($_GET["new_product_order_year"]) . "-" . strval($_GET["new_product_order_month"]) . "-" . strval($_GET["new_product_order_day"]);
?>
</body>
</html>