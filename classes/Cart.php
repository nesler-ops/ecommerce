<?php

class Cart {
    private $items = [];

    public function addItem($product, $quantity) {
        if (isset($this->items[$product['id']])) {
            $this->items[$product['id']]['quantity'] += $quantity;
        } else {
            $this->items[$product['id']] = [
                'product' => $product,
                'quantity' => $quantity
            ];
        }
    }

    public function removeItem($productId) {
        if (isset($this->items[$productId])) {
            unset($this->items[$productId]);
        }
    }

    public function updateQuantity($productId, $quantity) {
        if (isset($this->items[$productId])) {
            if ($quantity > 0) {
                $this->items[$productId]['quantity'] = $quantity;
            } else {
                unset($this->items[$productId]);
            }
        }
    }

    public function getItems() {
        return $this->items;
    }

    public function clearCart() {
        $this->items = [];
    }
}
?>
