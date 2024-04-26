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
        $this->db->select('id, password_hash, name, is_admin, google_id');
        $this->db->from('users');
        $this->db->where('email', $email);
        $result = $this->db->get()->row();
    
        if ($result && password_verify($password, $result->password_hash)) {
            return array(
                'user_id' => $result->id,
                'username' => $result->name,
                'is_admin' => $result->is_admin,
                'email' => $email,
                'has_google' => !empty($result->google_id),
                'logged_in' => true
            );
        } else {
            return false;
        }
    }


    public function find_by_google_id($google_id) {
        $this->db->from('users');
        $this->db->where('google_id', $google_id);
        $result = $this->db->get()->row();
        
        if ($result) {
            return $result;
        } else {
            return null;
        }
    }

    public function has_google_account($user_id) {
        $this->db->select('google_id');
        $this->db->from('users');
        $this->db->where('id', $user_id);
        $result = $this->db->get()->row();
        return !empty($result->google_id);
    }

    public function create_user_from_google($google_user_info) {
        $data = array(
            'name' => $google_user_info->name,
            'email' => $google_user_info->email,
            'google_id' => $google_user_info->id,
            'registration_date' => date('Y-m-d H:i:s'),
            'is_admin' => false
        );
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    public function link_google_account($user_id, $google_id) {
        $data = array('google_id' => $google_id);
        $this->db->where('id', $user_id);
        return $this->db->update('users', $data);
    }
}