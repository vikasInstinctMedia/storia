<?php

namespace App\Models;
use Session;

use Illuminate\Database\Eloquent\Model;

class UserCart extends Model
{
    
    protected $guarded = ['id'];

    protected $table= "user_cart";

    public function __construct()
    {

    }

// **************** ADD TO CART *******************

    public function add($item,$id) {
       
        $storedItem = ['qty' => 0,'stock' => $item->quantity, 'price' => $item->price, 'item' => $item];

        $storedItem['qty']++;
        $stck = (string)$item->quantity;
        if($stck != null){
                $storedItem['stock']--;
        }            
        
        $storedItem['price'] = $item->price * $storedItem['qty'];
        $this->items[$id] = $storedItem;
        $this->totalQty++;

    }

// **************** ADD TO CART ENDS *******************
    public function removeItem($id) {
        $this->totalQty -= $this->items[$id]['qty'];
        $this->totalPrice -= $this->items[$id]['price'];
        unset($this->items[$id]);
    }

}
