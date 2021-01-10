<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    // items is an associative array
    public $items;
    public $totalQty = 0;
    public $totalPrice = 0;

    public function __construct($oldCart)
    {
        if ($oldCart) {
            $this->items        = $oldCart->items;
            $this->totalQty     = $oldCart->totalQty;
            $this->totalPrice   = $oldCart->totalPrice;
        }
    }

    public function add($item, $id, $qty)
    {
        // empty state of storedItem (qty(0), price(item.price), item(object))
        $storedItem = ['qty' => 0, 'price' => $item->price, 'item' => $item];
        // dd($storedItem['item']);
        // dd($this->items);

        // check if cart has items
        if ($this->items) {
            // check if cart has existing product
            // if yes let storedItem = Cart Item
            if (array_key_exists($id, $this->items)) {
                $storedItem = $this->items[$id];
                // dd($storedItem);
            }
        }

        //storedItem qty increase
        // $storedItem['qty'] = $storedItem['qty'] + $qty;
        $storedItem['qty']++;
        // dd($storedItem['qty']);

        //storedItem price = product->price * storedItem['qty']
        $storedItem['price'] = $item->price * $storedItem['qty'];
        // dd($storedItem['price']);
        // id is product number
        $this->items[$id] = $storedItem;
        // dd($this->items[$id]);
        // $this->totalQty = $storedItem['qty'];
        $this->totalQty++;
        // dd($this->totalQty);
        // $this->totalPrice = $storedItem['price'];
        $this->totalPrice += $item->price;
        // dd($this->totalPrice);
    }

    public function increaseByOne($id)
    {
        //Increase item qty ++
        $this->items[$id]['qty']++;
        //Calculation price
        $this->items[$id]['price'] += $this->items[$id]['item']['price'];
        //Update totolQty
        $this->totalQty++;
        //Update total price
        $this->totalPrice += $this->items[$id]['item']['price'];
    }

    public function decreaseByOne($id)
    {
        $this->items[$id]['qty']--;
        $this->items[$id]['price'] -= $this->item[$id]['item']['price'];
        $this->totalQty--;
        $this->totalPrice -= $this->items[$id]['item']['price'];
        if ($this->items[$id]['qty'] < 1) {
            unset($this->items[$id]);
        }
    }
}
