<?php
class Presentations_model extends CI_Model {
    
    /**
     * Presentation Model
     */

    public function __construct()
    {
        $this->load->database();
    }
    
    public function get_presentation($presentationname)
    {
        $query = $this->db->select('pres_id')
                  ->from('presentations')
                  ->where('pres_name', $presentationname)
                  ->get();
        return $query->result();
    }
    
    public function presentations_list()
    {
        $query = $this->db->select('*')
                    ->from('presentations')
                    ->get();
        return $query->result();
    }
    
    public function update_presentation($id)
    {
        $data = array(
            'pres_name' => $this->input->post('pres_name'),
        );
        
        $this->db->where('pres_id', $id);
        $this->db->update('presentations', $data);
        $response = [
            'pres_id' => $id,
            'pres_name' => $this->input->post('pres_name')
        ];
        echo json_encode($response);
    }
    
    public function createOrUpdate()
    {
        $this->load->helper('url');
        $id = $this->input->post('id');
 
        $data = array(
            'pres_name' => $this->input->post('presentationname'),
        );
        if (empty($id)) {
            return $this->db->insert('presentations', $data);
        } else {
            $this->db->where('pres_id', $id);
            return $this->db->update('presentations', $data);
        }
    }

}