<?php

namespace App\Models;

class Cart
{
    /**
     * @var null
     */
    public $items = null;
    /**
     * @var int
     */
    public $totalQty = 0;
    /**
     * @var int
     */
    public $totalPrice = 0;

    /**
     * Cart constructor.
     * @param $oldCart
     */
    public function __construct($oldCart)
    {
        if ($oldCart) {
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
        }
    }

    /**
     * @param $item
     * @param $id
     */
    public function add($item, $id)
    {
        $storedItem = ['qty' => 0, 'price' => $item->price, 'item' => $item];
        if ($this->items) {
            if (array_key_exists($id, $this->items)) {
                $storedItem = $this->items[$id];
            }
        }
        $storedItem['qty']++;
        if ($item->sale_price != null) {
            $storedItem['price'] = $item->sale_price * $storedItem['qty'];
            $this->totalPrice += $item->sale_price;
        } else {
            $storedItem['price'] = $item->price * $storedItem['qty'];
            $this->totalPrice += $item->price;
        }
        $this->items[$id] = $storedItem;
        $this->totalQty++;
    }

    /**
     * @param $id
     */
    public function reduceOne($id)
    {
        $this->items[$id]['qty']--;
        $this->totalQty--;
        $sale_price = $this->items[$id]['item']['sale_price'];
        $price = $this->items[$id]['item']['price'];
        if ($sale_price != null && $sale_price <= $price) {
            $this->totalPrice -= $sale_price;
            $this->items[$id]['price'] -= $sale_price;
        } else {
            $this->totalPrice -= $price;
            $this->items[$id]['price'] -= $price;
        }
        if ($this->items[$id]['qty'] <= 0) {
            unset($this->items[$id]);
        }
    }

    /**
     * @param $id
     */
    public function increaseOne($id)
    {
        $this->items[$id]['qty']++;
        $this->totalQty++;
        $sale_price = $this->items[$id]['item']['sale_price'];
        $price = $this->items[$id]['item']['price'];
        if ($sale_price != null && $sale_price <= $price) {
            $this->totalPrice += $sale_price;
            $this->items[$id]['price'] += $sale_price;
        } else {
            $this->totalPrice += $price;
            $this->items[$id]['price'] += $price;
        }
    }

    /**
     * @param $id
     */
    public function removeItem($id) {
        $this->totalQty -= $this->items[$id]['qty'];
        $sale_price = $this->items[$id]['item']['sale_price'];
        $price = $this->items[$id]['item']['price'];
        if ($sale_price != null && $sale_price <= $price) {
            $this->totalPrice -= $sale_price;
        } else {
            $this->totalPrice -= $price;
        }
        unset($this->items[$id]);
    }
}
