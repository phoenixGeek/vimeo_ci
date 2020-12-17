<?php
class Link extends CI_Controller {

    /**
     * Link Controller
     */
    public function __construct()
    {
        /**
         * Construct part where loads models, CI libraries, CI helper modules
         */
        parent::__construct();
        $this->load->model('links_model');
        $this->load->model('presentations_model');
        $this->load->model('users_model');
        $this->load->model('folders_model');
        $this->load->helper('string');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function index()
    {
        $data['links'] = $this->links_model->links_list();
        $data['presentations'] = $this->presentations_model->presentations_list();

        $data['title'] = 'Links List';
        $this->load->view('links/list', $data);
    }

    public function create()
    {
        // controller for create a link
        $data['title'] = 'Create link';
        $data['presentations'] = $this->presentations_model->presentations_list();
        $this->load->view('links/create', $data);
    }

    public function edit($id)
    {
        // controller for edit a link
        $id = $this->uri->segment(2);
        $data = array();

        if (empty($id))
        { 
         show_404();
        } else
        {
          $data['link'] = $this->links_model->get_links_by_id($id);
          $this->load->view('links/edit', $data);
        }
    }

    public function update()
    {
        // controller for update a link
        $this->form_validation->set_rules('linkname', 'LinkName', 'required');
        $id = $this->input->post('id');
        if ($this->form_validation->run() === FALSE)
        {
            if(empty($id))
            {
                redirect( base_url('createLink') ); 
            } else
            {
                redirect( base_url('editLink/'.$id) ); 
            }
        } 
        else
        {
            $data['link'] = $this->links_model->update_link();
            redirect(''); 
        }
    }

    public function store()
    {
        // controller for store a link
        $user = $this->users_model->get_user();
        $this->form_validation->set_rules('presentationname', 'PresentationName', 'required');
        $this->form_validation->set_rules('linkname', 'LinkName', 'required');
 
        $id = $this->input->post('id');
 
        if ($this->form_validation->run() === FALSE)
        {
            if(empty($id))
            {

                redirect( base_url('createLink') ); 
            } else
            {
                redirect( base_url('edit/'.$id) ); 
            }
        }
        else
        {
            if(!empty($_FILES['myfile']['tmp_name']))
            {
                $dname = explode(".", $_FILES['myfile']['name']);
                $ext = end($dname);
                $configVideo['upload_path'] = 'uploads/video/';
                $configVideo['max_size'] = '102400';
                $configVideo['allowed_types'] = array('mp4', 'mpg', 'avi'); # add video extenstion on here
                $configVideo['overwrite'] = FALSE;
                $configVideo['remove_spaces'] = TRUE;
                $video_name = random_string('alpha', 8);
                $configVideo['file_name'] = $video_name;

                $this->load->library('upload', $configVideo);
                $this->upload->initialize($configVideo);

                if (!$this->upload->do_upload('myfile')) //check if upload video to current server or not
                {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('createPresentation');
                } 
                else
                {
                    $url = 'uploads/video/' .$video_name. '.'. $ext;
                    // create a new vimeo api instance
                    $client_id = '095578219c5381b99319cdd1d90a5381f5a94a36';
                    $client_secret = '5wu6YqN1fyjXsx9dztqkaO0N9gXLDXaJz9UN3vM3Snaz+PqK+k3W7KLijpDs44wo3In2BC0iTXl1URo9OWtBP/RJC7seClGq/y8V2dFyECJ85vaicETWnuO+sGuO1UlH';
                    $access_token = '396fdb358bb95fcdad1c0b252cb1c5a7';
                    $client = new \Vimeo\Vimeo($client_id, $client_secret, $access_token);

                    $folder_arr = array();
                    $newFolderName = 'v_' .$user[0]->user_id . '_'. $user[0]->name;
                    $this->users_model->store_foldername($newFolderName);
                    $response = $client->request('/me/projects/', array(), 'GET');
                    $isProjectExist = false;

                    // check if vimeo targeted project(folder) exists or not
                    foreach($response['body']['data'] as $key => $project) {
                        array_push($folder_arr, ['foldername' => $project['name']]);
                        if($project['name'] === $newFolderName)
                        {
                            $isProjectExist = true;
                            $projectSplitedResult = explode('/', $project['uri']);
                            $project_id = end($projectSplitedResult);
                            break;
                        }
                    }
                    $this->folders_model->insert($folder_arr);

                    if($isProjectExist) {

                        // upload a video to existed vimeo folder
                        $uri = $client->upload($url, array(
                            "name" => $video_name,
                            "description" => "Awesome educational video."
                        ));
                        $video_data = $client->request($uri . '?fields=link');
                        
                        $splitedResult = explode('/', $uri);
                        $video_id = end($splitedResult);
                        $new_url = "https://vimeo.com/" . $video_id;
                        $response = $client->request('/me/projects/' .$project_id .'/videos' .'/' .$video_id, array(), 'PUT');

                    } else {

                        // createa a new folder in vimeo and upload a video to this new folder
                        $uri = $client->upload($url, array(
                            "name" => $video_name,
                            "description" => "Awesome educational video."
                        ));
                        $video_data = $client->request($uri . '?fields=link');

                        $splitedResult = explode('/', $uri);
                        $video_id = end($splitedResult);
                        $new_url = "https://vimeo.com/" . $video_id;

                        $response = $client->request('/me/projects/', array('name' => $newFolderName), 'POST');
                        $uriSplitedResult = explode('/', $response['body']['uri']);
                        $project_id = end($uriSplitedResult);
                        $response = $client->request('/me/projects/' .$project_id .'/videos' .'/' .$video_id, array(), 'PUT');
                    }

                    $this->session->set_flashdata('success', 'Video Has been Uploaded');
                    // $this->folders_model->insert($folder_arr);                    
                    $data['link'] = $this->links_model->createOrUpdate($new_url);
                    redirect(''); 
                }
                
            }

        }
    }

    public function delete()
    {
        //controller for delete a link
        $id = $this->uri->segment(2);
        if (empty($id))
        {
            show_404();
        }
                 
        $links = $this->links_model->delete($id);
         
        redirect('');        
    }
}