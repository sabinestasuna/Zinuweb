<?php
class Category_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get_categories() {
        $this->db->select('id, name');
        $query = $this->db->get('categories');
        return $query->result_array();
    }

}