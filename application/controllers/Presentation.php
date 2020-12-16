<?php
class Presentation extends CI_Controller {

    /**
     * Presentation Controller
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('presentations_model');
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function create()
    {
        $data['title'] = 'Create presentation';
        $this->load->view('presentations/create', $data);
    }

    public function edit()
    {
        $pres_id = $this->input->post('pres_id');
        $pres_name = $this->input->post('pres_name');
        $this->presentations_model->update_presentation($pres_id);
    }

    public function store()
    {
        $this->form_validation->set_rules('presentationname', 'PresentationName', 'required');
        $presentation = $this->presentations_model->get_presentation($this->input->post('presentationname'));

        $id = $this->input->post('id');
 
        if ($this->form_validation->run() === FALSE)
        {
            if(empty($id))
            {
                redirect( base_url('createPresentation') );
            } else
            {
                redirect( base_url('editPresentation/'.$id) ); 
            }
        }
        else
        {
            /**
             * Check if presentation name already exists or not
             * If exists, redirect to create presentation page again
             * if not, create a new presentation
             */

            if($presentation) {
                redirect( base_url('createPresentation?exist=1') ); 
            } else {
                $data['presentation'] = $this->presentations_model->createOrUpdate();
                redirect( base_url() ); 
            }

        }
    }

}