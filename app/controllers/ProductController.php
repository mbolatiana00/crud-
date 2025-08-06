<?php

namespace App\Controllers;

use App\model\ProductModel;

class ProductController extends Controller
{
    public function index()
    {
        $productModel = new ProductModel($this->getDB());
        $products = $productModel->getAll();

        return $this->view('products.index', [
            'products' => $products,
            'title' => 'Notre Menu'
        ]);
    }

    public function show(int $id)
    {
        $productModel = new ProductModel($this->getDB());
        $product = $productModel->findById($id);

        if (!$product) {
            http_response_code(404);
            return $this->view('errors.404');
        }

        return $this->view('products.show', [
            'product' => $product,
            'title' => $product->getName()
        ]);
    }
}
