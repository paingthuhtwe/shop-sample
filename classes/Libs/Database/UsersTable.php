<?php

namespace Libs\Database;

use PDOException;

class UsersTable
{
    private $db = null;
    public function __construct(MySQL $db)
    {
        $this->db = $db->connect();
    }
    public function insert($data)
    {
        try {
            $query = "INSERT INTO users (name, email, phone, address, password, role_id, created_at ) VALUES (:name, :email, :phone, :address, :password, :role_id, NOW() )
            ";
            $statement = $this->db->prepare($query);
            $statement->execute($data);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            return $e->getMessage()();
        }
    }
    public function findByEmailAndPassword($email, $password)
    {
        try {
            $statement = $this->db->prepare("SELECT users.*, roles.role AS role, roles.value FROM users LEFT JOIN roles ON users.role_id = roles.id WHERE users.email = :email AND users.password = :password");
            $statement->execute([
                ':email' => $email,
                ':password' => $password,
            ]);
            return $statement->fetch() ?? false;
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }
    public function getAll()
    {
        $statement = $this->db->query("SELECT users.*, roles.role AS role, roles.value FROM users LEFT JOIN roles ON users.role_id = roles.id
    ");
        return $statement->fetchAll();
    }
    public function updatePhoto($name, $id)
    {
        try {
            $statement = $this->db->prepare("UPDATE users SET photo = :name WHERE id = :id");
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
    public function findById($id)
    {
        $statement = $this->db->prepare("SELECT users.*, roles.role AS role, roles.value FROM users LEFT JOIN roles ON users.role_id = roles.id WHERE users.id = :id");
        $statement->execute([':id' => $id]);
        return $statement->fetch();
    }
    public function suspend($id)
    {
        try {
            $statement = $this->db->prepare("UPDATE users SET suspended = 1 WHERE id = :id");
            $statement->execute([
                ':id' => $id,
            ]);
            return $statement->rowCount();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }
    public function unsuspend($id)
    {
        try {
            $statement = $this->db->prepare("UPDATE users SET suspended = 0 WHERE id = :id");
            $statement->execute([
                ':id' => $id,
            ]);
            return $statement->rowCount();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }
    public function changeRole($id, $role)
    {
        try {
            $statement = $this->db->prepare("UPDATE users SET role_id = :role WHERE id = :id");
            $statement->execute([
                ':id' => $id,
                ':role' => $role,
            ]);
            return $statement->rowCount();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }
    public function delete($id)
    {
        try {
            $statement = $this->db->prepare("DELETE FROM users WHERE id = :id");
            $statement->execute([
                ':id' => $id,
            ]);
            return $statement->rowCount();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }
    public function updateUser($data)
    {
        try {
            $statement = $this->db->prepare("UPDATE users SET name=:name, email=:email, phone=:phone, address=:address, updated_at=NOW() WHERE id = :id");
            $statement->execute($data);
            return $statement->rowCount();
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }
}
