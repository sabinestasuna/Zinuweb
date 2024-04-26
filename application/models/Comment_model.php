<?php

class Comment_model extends CI_Model {

    public function add_comment($article_id, $user_id, $content) {
        $data = array(
            'article_id' => $article_id,
            'user_id' => $user_id,
            'content' => $content,
            'date_posted' => date('Y-m-d H:i:s')
        );
        return $this->db->insert('comments', $data);
    }

    public function get_comments_by_article($article_id) {
        $this->db->select('comments.*, users.name as author_name');
        $this->db->from('comments');
        $this->db->join('users', 'users.id = comments.user_id');
        $this->db->where('article_id', $article_id);
        $this->db->order_by('date_posted', 'desc');
        return $this->db->get()->result_array();
    }

    public function delete_comment($comment_id) {
        $this->db->where('id', $comment_id);
        $this->db->delete('comments');
        return $this->db->affected_rows();
    }
}