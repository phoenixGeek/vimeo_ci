<?php
class Links_model extends CI_Model {
    
    /**
     * Link Model
     */
    public function __construct()
    {
        $this->load->database();
        $this->load->model('presentations_model');
    }
    
    public function links_list()
    {
        $query = $this->db->select('*')
                  ->from('links')
                  ->join('presentations', 'presentations.pres_id = links.pres_id')
                  ->get();
        return $query->result();
    }
    
    public function get_links_by_id($id)
    {
        $query = $this->db->get_where('links', array('link_id' => $id));
        return $query->row();
    }
    
    public function createOrUpdate($url)
    {
        $id = $this->input->post('id');
        $presentation = $this->presentations_model->get_presentation($this->input->post('presentationname'));

        $data = array(
            'link_name' => $this->input->post('linkname'),
            'pres_id' => $presentation[0]->pres_id,
            'url' => $url
        );
        if (empty($id)) {
            return $this->db->insert('links', $data);
        } else {
            $this->db->where('id', $id);
            return $this->db->update('links', $data);
        }
    }
    
    public function update_link()
    {
        $id = $this->input->post('id');
        $data = array(
            'link_name' => $this->input->post('linkname')
        );
        if($id) {
            $this->db->where('link_id', $id);
            return $this->db->update('links', $data);
        }
    }

    public function delete($id)
    {
        $this->db->where('link_id', $id);
        return $this->db->delete('links');
    }
}