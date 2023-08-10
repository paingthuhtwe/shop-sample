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
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }
    public function getAll()
    {
        try {
            $statement = $this->db->query("SELECT carts.*, carts.id AS cartId, products.*, products.id AS productId FROM carts RIGHT JOIN products ON products.id = carts.product_id");
            return $statement->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }
    public function getAllByUserId($id)
    {
        try {
            $statement = $this->db->prepare("SELECT carts.*, carts.id AS cartId, products.*, products.id AS productId FROM carts RIGHT JOIN products ON products.id = carts.product_id AND carts.user_id = :id");
            $statement->execute([':id' => $id]);
            return $statement->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }
    public function getAllConfrim($id)
    {
        try {
            $statement = $this->db->prepare("SELECT carts.*, carts.id AS cartId, products.*, products.id AS productId FROM carts RIGHT JOIN products ON products.id = carts.product_id AND carts.user_id = :id AND carts.confirm = 1");
            $statement->execute([':id' => $id]);
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
            return $statement->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }
    public function findByCartId($id)
    {
        try {
            $statement = $this->db->prepare("SELECT * FROM carts WHERE id = :id");
            $statement->execute([':id' => $id]);
            return $statement->fetch();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }
    public function findByUserIdAndProductId($user_id, $product_id)
    {
        try {
            $statement = $this->db->prepare("SELECT * FROM carts WHERE user_id = :user_id AND product_id = :product_id");
            $statement->execute([':user_id' => $user_id, ':product_id' => $product_id]);
            return $statement->fetch();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }
    public function updateCart($data)
    {
        try {
            $statement = $this->db->prepare("UPDATE carts SET cart=:cart, updated_at=NOW() WHERE user_id = :user_id AND product_id = :product_id");
            $statement->execute($data);
            return $statement->rowCount();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }
    public function confirm($data)
    {
        try {
            $statement = $this->db->prepare("UPDATE carts SET confirm=:confirm, updated_at=NOW() WHERE user_id = :user_id");
            $statement->execute($data);
            return $statement->fetch();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }
}
