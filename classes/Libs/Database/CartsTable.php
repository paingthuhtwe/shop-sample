<?php

namespace Libs\Database;

use PDOException;

class CartsTable
{
    private $db = null;
    public function __construct(MySQL $db)
    {
        $this->db = $db->connect();
    }
    public function insert($data)
    {
        try {
            $statement = $this->db->prepare("INSERT INTO carts (cart, product_id, user_id, created_at) VALUES (:cart, :product_id, :user_id, NOW()) ");
            $statement->execute($data);
            return $statement->lastInsertId();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }
    public function getAll()
    {
        try {
            $statement = $this->db->query("SELECT * FROM carts");
            return $statement->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }
    public function findByUserId($id)
    {
        try {
            $statement = $this->db->prepare("SELECT * FROM carts WHERE user_id = :user_id");
            $statement->execute([':user_id' => $id]);
            return $statement->rowCount();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }
}
