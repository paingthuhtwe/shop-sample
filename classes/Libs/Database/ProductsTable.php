<?php

namespace Libs\Database;

use PDOException;

class ProductsTable
{
    private $db = null;
    public function __construct(MySQL $db)
    {
        $this->db = $db->connect();
    }
    public function insert($data)
    {
        try {
            $query = "INSERT INTO products (title, description, price, photo, stock, created_at) VALUES (:title, :description, :price, :photo, :stock, NOW() )
            ";
            $statement = $this->db->prepare($query);
            $statement->execute($data);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            return $e->getMessage()();
        }
    }
    public function getAll()
    {
        try {
            $statement = $this->db->query("SELECT * FROM products");
            return $statement->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }
    public function delete($id)
    {
        try {
            $statement = $this->db->prepare("DELETE FROM products WHERE id=:id");
            $statement->execute([':id' => $id]);
            return $statement->rowCount();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }
    public function findById($id)
    {
        try {
            $statement = $this->db->prepare("SELECT * FROM products WHERE id=:id");
            $statement->execute([
                ':id' => $id,
            ]);
            return $statement->fetch();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }
    public function updatePhoto($name, $id)
    {
        try {
            $statement = $this->db->prepare("UPDATE products SET photo=:name WHERE id=:id");
            $statement->execute([
                ':name' => $name,
                ':id' => $id,
            ]);
            return $statement->rowCount();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }
    public function updateProduct($data)
    {
        try {
            $statement = $this->db->prepare("UPDATE products SET title=:title, description=:description, stock=:stock, price=:price, updated_at=NOW() WHERE id=:id");
            $statement->execute($data);
            return $statement->rowCount();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }
}
