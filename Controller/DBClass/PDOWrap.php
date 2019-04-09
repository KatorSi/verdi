<?php

namespace Controller\DBClass;

use \PDO;

class PDOWrap
{
    private $dbh;

    private $error;

    /** @var \PDOStatement */
    private $stmt;

    public function __construct()
    {
        $dsn = 'mysql:host=' . \Config::$db['db_host'] . ';dbname=' . \Config::$db['db_name'];
        $options = array(
            PDO::ATTR_PERSISTENT         => true,
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
        );
        try {
            $this->dbh = new PDO($dsn, \Config::$db['db_user'], \Config::$db['db_pass'], $options);
        } catch (\PDOException $e) {
            $this->error = $e->getMessage();
            die();
        }
    }

    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }

    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute()
    {
        return $this->stmt->execute();
    }

    public function resultset()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function numericresult()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_NUM);
    }

    public function groupresult()
    {
        $this->execute();
        return $this->stmt->fetchAll(\PDO::FETCH_GROUP | \PDO::FETCH_UNIQUE | \PDO::FETCH_ASSOC);
    }

    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    public function lastInsertId()
    {
        return $this->dbh->lastInsertId();
    }

    public function beginTransaction()
    {
        return $this->dbh->beginTransaction();
    }

    public function endTransaction()
    {
        return $this->dbh->commit();
    }

    public function cancelTransaction()
    {
        return $this->dbh->rollBack();
    }

    public function debugDumpParams()
    {
        return $this->stmt->debugDumpParams();
    }

    public function insert($data, $table)
    {
        $setSqlKeys = [];
        $setSqlValues = [];
        foreach ($data as $key => $value) {
            $setSqlKeys[] = "$key";
            $setSqlValues[$key] = ":$key";
        }
        $setStringKeys = implode(', ', $setSqlKeys);
        $setStringValues = implode(', ', $setSqlValues);
        $sql = sprintf("INSERT INTO $table (%s) VALUES (%s)", $setStringKeys, $setStringValues);
        $this->query($sql);
        try {
            foreach ($data as $key => $value) {
                $this->bind(":$key", trim($value));
            }
            $this->execute();
            $response['status'] = true;
            $response['message'] = $this->lastInsertId();
        } catch (\Exception $e) {
            $response['error'] = $e->getMessage();
            $response['status'] = false;
        }
        return $response;
    }

    public function update($data, $where, $table)
    {
        $setSql = [];
        $whereSql = [];
        foreach ($data as $key => $value) {
            $setSql[] = "$key = :$key";
        }
        foreach ($where as $key => $value) {
            $whereSql[] = "$key = :$key";
        }
        $setString = implode(', ', $setSql);
        $whereString = implode(' AND ', $whereSql);
        $sql = sprintf("UPDATE $table SET %s WHERE %s", $setString, $whereString);
        $this->query($sql);
        try {
            foreach ($data as $key => $value) {
                $this->bind(":$key", $value);
            }
            foreach ($where as $key => $value) {
                $this->bind(":$key", $value);
            }
            $this->execute();
            $response['status'] = true;
            $response['message'] = $this->lastInsertId();
        } catch (\Exception $e) {
            $response['error'] = $e->getMessage();
            $response['status'] = false;
        }
        return $response;
    }

    public function delete($table, $where){
        $whereSql = [];
        foreach ($where as $key => $value) {
            $whereSql[] = "$key = :$key";
        }
        $whereString = implode(' AND ', $whereSql);

        $sql = sprintf("DELETE FROM $table WHERE %s", $whereString);
        $this->query($sql);
        try {
            foreach ($where as $key => $value) {
                $this->bind(":$key", $value);
            }
            if($this->execute()){
                $response['status'] = true;
                $response['message'] = $this->lastInsertId();
            }
            else{
                $response['error'] = '';
                $response['status'] = false;
            }

        } catch (\Exception $e) {
            $response['error'] = $e->getMessage();
            $response['status'] = false;
        }

        return $response;
    }
}