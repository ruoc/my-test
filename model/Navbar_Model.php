<?php

class Navbar_Model extends Model
{

    public function getAllCategories()
    {
        $result = $this->db->get('category');

        if ($result > 0) {
            return $result;
        }

        return false;
    }
}