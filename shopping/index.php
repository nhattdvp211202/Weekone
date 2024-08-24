<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<?php
require_once 'Database.php';
require_once 'Product.php';
require_once 'ShoppingCart.php';

session_start();
$db = (new Database())->connect();
$productObj = new Product($db);
$products = $productObj->getProducts();
$cart = isset($_SESSION['cart']) ? unserialize($_SESSION['cart']) : new ShoppingCart();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    foreach ($products as $product) {
        if ($product['pro_id'] == $product_id) {
            $cart->insertCart($product);
            $_SESSION['cart'] = serialize($cart);
            break;
        }
    }
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách sản phẩm</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1>Danh sách sản phẩm</h1>
    <form method="post">
        <?php foreach ($products as $product): ?>
            <div class="product">
                <h2><?php echo htmlspecialchars($product['pro_name']); ?></h2>
                <p>Giá: <?php echo number_format($product['pro_price'], 2); ?> VND</p>
                <button type="submit" name="product_id" value="<?php echo $product['pro_id']; ?>">Thêm vào giỏ hàng</button>
            </div>
        <?php endforeach; ?>
    </form>
    <a href="cart.php">Xem giỏ hàng (<?php echo $cart->totalCart(); ?>)</a>
    </div> 
</body>
</html>
