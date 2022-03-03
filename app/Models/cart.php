<?php

namespace App\models;

class cart
{
    private $listProducts = null;
    private $totalPrice = 0;
    private $totalQuantity = 0;

    // gán trạng thái(thông tin) giỏ hàng cũ vào giỏ hàng mới khi được gọi:
    public function __construct($oldCart)
    {
        $this->listProducts = $oldCart->listProducts;
        $this->totalPrice = $oldCart->totalPrice;
        $this->totalQuantity = $oldCart->totalQuantity;
    }
    // thêm 1 sản phẩm bất kì vào giỏ hàng:
    public function addToCard($product)
    {
        $id = $product->id;
        // tạo và gán giá trị mặc định của sản phẩm mơi thêm vào:
        $newProduct = [
            'info' => $product,
            'totalQuantityItem' => '0',
        ];
        // kiểm tra sản phẩm thêm vào có đang tồn tại trong giỏ hàng hiện tại, nếu có thì gán sản phẩm hiện tại có trong giỏ hàng cho sản phẩm mới:
        if ($this->listProducts) {
            if (array_key_exists($id, $this->listProducts)) {
                $newProduct = $this->listProducts[$id];
            }
        }
        // cập nhật trangk thái sản phẩm mới:
        $newProduct['totalQuantityItem'] ++;
        $newProduct['totalPriceItem'] = $newProduct['totalQuantityItem'] * $newProduct['info']->selling_price;
        // thêm sản phẩm mới với trạng thái được thay đổi vào lại giỏ hàng:
        $this->listProducts[$id] = $newProduct;
        // cập nhật lại tổng tiền và tổng số lượng sản phẩm của giỏ hàng sau khi thêm sản phẩm mới:
        $this->totalQuantity ++;
        $this->totalPrice += $newProduct['info']->selling_price;
    }
}
