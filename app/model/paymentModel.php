<?php
namespace App\model;

use Database\DBConnection;

class paymentModel {

    protected $pdo;

    public function __construct(DBConnection $pdo)
    {
        $this->pdo = $pdo->getPDO();
    }

    public function paymentMethode(){
        
    }
}