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
    
    public function store_foldername($newFolderName)
    {
        $data = array(
            'vfoldername' => $newFolderName
        );
        $this->db->where('name', 'miguel');
        return $this->db->update('users', $data);
    }
}