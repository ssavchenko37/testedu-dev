<?php
class TS_tutors
{
    public $data = array();

    private $db;

    public function __construct()
    {
        global $DB;
        $this->db = $DB;
    }
}