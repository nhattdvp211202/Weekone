<?php
class ShoppingCart {
    private $cart = [];

    public function insertCart($product) {
        if (isset($this->cart[$product['pro_id']])) {
            $this->cart[$product['pro_id']]['quantity']++;
        } else {
            $product['quantity'] = 1;
            $this->cart[$product['pro_id']] = $product;
        }
    }

    public function updateCart($pro_id, $quantity) {
        if (isset($this->cart[$pro_id])) {
            if ($quantity > 0) {
                $this->cart[$pro_id]['quantity'] = $quantity;
            } else {
                $this->deleteCart($pro_id);
            }
        }
    }

    public function deleteCart($pro_id) {
        if (isset($this->cart[$pro_id])) {
            unset($this->cart[$pro_id]);
        }
    }

    public function totalCart() {
        return count($this->cart);
    }

    public function contentCart() {
        return $this->cart;
    }
}
?>
