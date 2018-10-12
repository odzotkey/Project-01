<a href="katalog.php">Back</a>
<?php
session_start();
$conn = New mysqli("localhost", "root","","data" );
if(isset($_GET["id"])){
   //session_destroy();
$query = $conn->query("SELECT * FROM products WHERE id = '".$_GET["id"]."'");
$prod = $query->fetch_object();
if(!empty($_SESSION["cart"])){
$arrayId = array_column($_SESSION["cart"], "cid");
   if (!in_array($_GET["id"], $arrayId)){
    $count = count($_SESSION["cart"]);
    $cart = array(
     "cid"=>$prod->id,
     "name"=>$prod->name,
     "price"=>$prod->price,
     "qty"=>1
   );
   $_SESSION["cart"][$count] = $cart;
   } else {
    foreach($_SESSION["cart"] as $keys => $val){
    if($_GET["id"] == $val["cid"]){
    $cart = array(
    "cid"=>$prod->id,
    "name"=>$prod->name,
    "price"=>$prod->price,
    "qty"=>1 + $val["qty"]
    );
    $_SESSION["cart"][$keys] = $cart;
    }
    }
   
   }

} else {
$cart = array(
    "cid"=>$prod->id,
    "name"=>$prod->name,
    "price"=>$prod->price,
    "qty"=>1
  );
  $_SESSION["cart"][0] = $cart;

}
echo "<pre>";
print_r($_SESSION["cart"]);
header("location:katalog.php");
}
