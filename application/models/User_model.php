<?php

class User_model extends CI_Model {

    public function register_user($name, $email, $password_hash) {
        $data = array(
            'name' => $name,
            'email' => $email,
            'password_hash' => $password_hash,
            'registration_date' => date('Y-m-d H:i:s')
        );
        return $this->db->insert('users', $data);
    }

    public function login_user($email, $password) {
        $this->db->select('id, password_hash, name');
        $this->db->from('users');
        $this->db->where('email', $email);
        $result = $this->db->get()->row();
    
        if ($result && password_verify($password, $result->password_hash)) {
            return array(
                'user_id' => $result->id,
                'username' => $result->name,
                'is_admin' => $result->is_admin
            );
        } else {
            return false;
        }
    }
}