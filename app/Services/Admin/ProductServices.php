<?php

namespace App\Services\Admin;

use DB;
use App\Repositories\Admin\ProductRepository;

class ProductServices
{
    protected $product;

    public function __construct()
    {
        $this->products = new ProductRepository();
    }

    public function create($data)
    {
        $this->products->create($data);

        return true;
    }

    public function update($data, $id)
    {
        $this->products->update($data, $id);

        return true;
    }

    public function delete($id)
    {
        $this->products->delete($id);

        return true;
    }
}
