<?php
class Folders_model extends CI_Model {
    
    /**
     * Folder Model
     */
    
    public function __construct()
    {
        $this->load->database();
    }
    
    public function insert($folder_arr)
    {
        $this->db->empty_table('folders');
        return $this->db->insert_batch('folders', $folder_arr);
    }
    
}