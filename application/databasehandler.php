<?php
include('dbcon.php');

class DatabaseHandler
{
    private $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getPDO();
    }

    public function create($table, $data)
    {
        $columns = implode(', ', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO $table ($columns) VALUES ($values)";

        $stmt = $this->pdo->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        return $stmt->execute();
    }

    public function read($table, $condition = '', $params = [])
    {
        $sql = "SELECT * FROM $table";

        if (!empty($condition)) {
            $sql .= " WHERE $condition";
        }

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($table, $data, $where) {
        // Generate the SET part of the query
        $set = '';
        foreach ($data as $key => $value) {
            $set .= "`$key` = :$key, ";
        }
        $set = rtrim($set, ', ');
    
        // Generate the WHERE part of the query
        $whereClause = '';
        foreach ($where as $key => $value) {
            $whereClause .= "`$key` = :$key AND ";
        }
        $whereClause = rtrim($whereClause, ' AND ');
    
        // Prepare and execute the query
        $query = "UPDATE `$table` SET $set WHERE $whereClause";
        $statement = $this->pdo->prepare($query);
    
        // Bind parameters
        foreach ($data as $key => $value) {
            $statement->bindValue(":$key", $value);
        }
        foreach ($where as $key => $value) {
            $statement->bindValue(":$key", $value);
        }
    
        // Execute the query
        $result = $statement->execute();
    
        return $result;
    }

    public function delete($table, $condition)
    {
        $sql = "DELETE FROM $table WHERE $condition";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute();
    }

    public function loginUser($email, $password)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
           $_SESSION['username']=$user['name'];
           $_SESSION['role']=$user['type'];
            return true;
        } else {
            return false;
        }
    }
}


?>