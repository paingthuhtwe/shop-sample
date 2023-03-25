<?php

namespace Libs\Database;

use PDOException;

class OrdersTable
{
    private $db = null;
    public function __construct(MySQL $db)
    {
        $this->db = $db->connect();
    }
    public function findByUserId($id)
    {
        try {
            $statement = $this->db->prepare("SELECT products.*, orders.* FROM orders LEFT JOIN products ON orders.product_id = products.id AND orders.user_id = :id");
            $statement->execute([':id' => $id]);
            return $statement->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }
    public function getAll()
    {
        try {
            $statement = $this->db->query("SELECT products.*, orders.* FROM orders LEFT JOIN products ON orders.product_id = products.id");
            return $statement->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }
    public function findByUserIdAndProductId($user_id, $product_id)
    {
        try {
            $statement = $this->db->prepare("SELECT * FROM orders WHERE user_id = :user_id AND product_id = :product_id");
            $statement->execute([
                ':user_id' => $user_id,
                ':product_id' => $product_id,
            ]);
            return $statement->fetch();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }
    public function update($id)
    {
        try {
            $statement = $this->db->prepare("UPDATE orders SET preorder=:order, updated_at = NOW() WHERE id = :id");
            $statement->execute([
                ':id' => $id,
            ]);
            return $statement->rowCount();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }
    public function insert($data)
    {
        try {
            $statement = $this->db->prepare("INSERT INTO orders (preorder, user_id, product_id, created_at) VALUES (:order, :user_id, :product_id, NOW()");
            $statement->execute($data);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }
}
