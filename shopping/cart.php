<?php
require_once 'ShoppingCart.php';

session_start();
$cart = isset($_SESSION['cart']) ? unserialize($_SESSION['cart']) : new ShoppingCart();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update'])) {
        $cart->updateCart($_POST['pro_id'], $_POST['quantity']);
    } elseif (isset($_POST['delete'])) {
        $cart->deleteCart($_POST['pro_id']);
    }
    $_SESSION['cart'] = serialize($cart);
    header("Location: cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Giỏ hàng</h1>
        <form method="post">
            <?php foreach ($cart->contentCart() as $product): ?>
                <div class="cart-item">
                    <h2><?php echo htmlspecialchars($product['pro_name']); ?></h2>
                    <p>Giá: <?php echo number_format($product['pro_price'], 2); ?> VND</p>
                    <p>Số lượng: <input type="number" name="quantity" value="<?php echo $product['quantity']; ?>"></p>
                    <input type="hidden" name="pro_id" value="<?php echo $product['pro_id']; ?>">
                    <button type="submit" name="update">Cập nhật</button>
                    <button type="submit" name="delete">Xóa</button>
                </div>
            <?php endforeach; ?>
        </form>
        <a href="index.php">Quay lại danh sách sản phẩm</a>
    </div>
</body>
</html>

