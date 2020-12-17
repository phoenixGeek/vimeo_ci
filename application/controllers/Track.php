<?php
class Track extends CI_Controller {

    /**
     * Presentation Controller
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('links_model');
        $client_id = '095578219c5381b99319cdd1d90a5381f5a94a36';
        $client_secret = '5wu6YqN1fyjXsx9dztqkaO0N9gXLDXaJz9UN3vM3Snaz+PqK+k3W7KLijpDs44wo3In2BC0iTXl1URo9OWtBP/RJC7seClGq/y8V2dFyECJ85vaicETWnuO+sGuO1UlH';
        $access_token = '396fdb358bb95fcdad1c0b252cb1c5a7';
        $this->client = new \Vimeo\Vimeo($client_id, $client_secret, $access_token);
       
    }
    
    public function track()
    {
        $video_id = $this->input->post('_vid');
        $link_id = $this->input->post('_linkid');
        $response = $this->client->request('/me/videos/' .$video_id, array(), 'GET');
        $status = $response['body']['status'];

        if($status === 'available') {
            $this->links_model->update_active($link_id);
        }
        echo json_encode($status);
    }

}