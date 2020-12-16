<?php
class Users_model extends CI_Model {
    
    /**
     * User Model
     */
    
    public function __construct()
    {
        $this->load->database();
    }
    
    public function get_user()
    {
        $query = $this->db->select('*')
                  ->from('users')
                  ->where('name', 'miguel')
                  ->get();
        return $query->result();
    }
    
}