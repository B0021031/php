<!Doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title></title>

    <!--css-->
    <link rel="stylesheet" href="css/viewSelect.css"></link>

</head>
<body>

<div id="splash">
    <div id="splash_text"></div>
</div>

<div calss="splashbg"></div>

<div class="title">
<header id="header">
  <h1>Products</h1>
</header>
</div>


<form action="search.php" name="search" method="get">
    <input type="text" name="search_word" placeholder="Product Name">
    <input type="hidden" name="user_name" value=<?php echo $user_name; ?>>
    <input type="hidden" name="begin" value=<?php echo $begin; ?>>
    <input type="hidden" name="size" value=<?php echo $size; ?>>
    <input type="submit" name="submitBtn" value="search">
</form>

<main>
<h2>ようこそ　<?php echo $user_name; ?>　さん</h2>
<?php
foreach($result1 as $row){
    echo '<p>';
    echo "<form action='show_editProduct_info.php' method='get'>";
    echo "<input type='submit' name='edit_product_btn' value='Edit'>";
    $product_id = $row["product_id"];
    $product_name = $row["name"];
    $product_price = $row["price"];
    echo $product_id;
    echo '：';
    echo $product_name;
    echo ', ￥';
    echo $product_price;
    echo "<input type='hidden' name='begin' value='$begin'>";
    echo "<input type='hidden' name='size' value='$size'>";
    echo "<input type='hidden' name='product_id' value='$product_id'>";
    echo "<input type='hidden' name='user_name' value='$user_name'>";
    echo '</p>';
    echo "</form>";
}
?>

<table>
<tr>
<td>
<form action="selection.php" method="get">
    <input type="hidden" name="user_name" value="<?php echo $user_name; ?>">
    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
    <input type="hidden" name="begin" value="
<?php
    $next = $begin - 5;
    if ($next < 0) {
        $next = 0;
    }
    echo $next; ?>">
    <input type="hidden" name="size" value="<?php echo $size; ?>">
    <input type="submit" name="submitBtn" value="Back">

</form>
</td>

<td>
<form action="selection.php" method="get">
    <input type="hidden" name="user_name" value="<?php echo $user_name; ?>">
    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
    <input type="hidden" name="begin" value="<?php echo $begin+5; ?>">
    <input type="hidden" name="size" value="<?php echo $size; ?>">
    <input type="submit" name="submitBtn" value="Next">
</form>
</td>
</tr>
</table>

<form action="input_addProduct_info.php" method="get">
    <input type="hidden" name="user_name" value=<?php echo $user_name; ?>>
    <input type="hidden" name="begin" value=<?php echo $begin; ?>>
    <input type="hidden" name="size" value=<?php echo $size; ?>>
    <input type="submit" name="submitBtn" value="Add new">
</form>
</main>

<div class="search_result" style="overflow: scroll; width:250px; height:300px;">
<?php 
    if (isset($search_result)){
        echo "RESULT：<br>";
        foreach($search_result as $row){
            echo '<p>';
            echo "<form action='show_editProduct_info.php' method='get'>";
            echo "<input type='submit' name='edit_product_btn' value='edit' style='background: transparent; cursor: pointer;'>";
            $product_id = $row["product_id"];
            $product_name = $row["name"];
            $product_price = $row["price"];
            echo $product_id;
            echo '：';
            echo $product_name;
            echo ', ';
            echo "￥" . $product_price;
            echo "<input type='hidden' name='begin' value='$begin'>";
            echo "<input type='hidden' name='size' value='$size'>";
            echo "<input type='hidden' name='product_id' value='$product_id'>";
            echo "<input type='hidden' name='user_name' value='$user_name'>";
            echo "</form>";  
            echo '</p>';
        }
    }
?>
</div>
<!--
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>
<script src="https://rawgit.com/kimmobrunfeldt/progressbar.js/master/dist/progressbar.min.js"></script>
<script tyep="text/javascript" src="javascript/viewSelect.js"></script>
-->
</body>
</html>