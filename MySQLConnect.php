<?php

// Задание 1
// конечно надо менять абстрактный класс, чтобы коннект был не через такой метод с передачей параметров
// а запросы делать через модель данных, и логику запросов в таблицы делать уже через эти модели

class MySQLConnect extends DBConnect
{
    private $db_connection;
    private $sth;

    /**
     * @param $host
     * @param $port
     * @param $database
     * @param $username
     * @param $password
     * @return PDO
     */
    public function connect($host, $port, $database, $username, $password)
    {
        if ($this->db_connection) {
            return $this->db_connection;
        }
        $dsn = "mysql:host=" . $host . ";dbname=" . $database  . ";port=" . $port;
        $this->db_connection = new PDO($dsn, $username, $password);
        return $this->db_connection;


    }

    /**
     * @param $sql
     * @param $params
     * @return MySQLConnect
     */
    public function query($sql, $params = null)
    {
        $sth = $this->db_connection->prepare($sql. $params);
        $sth->execute();
        $this->sth = $sth;
        return $this;

    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        if ($this->sth) {
            return $this->sth->fetchAll(PDO::FETCH_ASSOC);
        }
        return null;
    }

    /**
     * @return mixed
     */
    public function getFetch()
    {
        if ($this->sth) {
            return $this->sth->fetch(PDO::FETCH_ASSOC);
        }
        return null;
    }
}