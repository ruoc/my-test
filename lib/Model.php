<?php
class Model
{

    protected $db;

    function __construct()
    {
        $this->db = new MysqliDb(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

}