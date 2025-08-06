<?php

namespace App\Controllers;

use App\model\ProductModel;

class HomeController extends Controller
{
    public function index()
    {
        $productModel = new ProductModel($this->getDB());
        $products = $productModel->getAll();

        return $this->view('home.home', compact('products'));
    }
}
