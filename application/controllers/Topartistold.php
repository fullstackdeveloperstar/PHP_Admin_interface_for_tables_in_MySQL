<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class Topartistold extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('topartistold_model');
        $this->isLoggedIn();   
    }
    
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        
        $this->global['pageTitle'] = 'Avivamiento : TopartistOld';

        $this->load->library('pagination');
            
        $count = $this->topartistold_model->getNumRows();

        $returns = $this->paginationCompress ( "topartistold/", $count, 10 );
            
        $this->global['topartistoldlist'] = $this->topartistold_model->getArtistList($returns["page"], $returns["segment"]);
            
        $this->loadViews("topartistold/index", $this->global, NULL , NULL);
    }

    public function edit($id) {
        $this->global['pageTitle'] = 'Avivamiento : TopartistOld';

        $this->global['artist'] = $this->topartistold_model->getById($id);
            
        $this->loadViews("topartistold/edit", $this->global, NULL , NULL);
    }

    public function add() {
        $this->global['pageTitle'] = 'Avivamiento : TopartistOld';
            
        $this->loadViews("topartistold/add", $this->global, NULL , NULL);
    }

    public function postedit($id) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('artista','artista','trim|required|max_length[128]');
        $this->form_validation->set_rules('votos','votos','trim|required|max_length[128]');
        $this->form_validation->set_rules('cancion','cancion','trim|required|max_length[128]');

        if($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('error', 'Please Input Valid Values.');
            redirect('topartistold/edit/'.$id);
        }
        else{
            $data['artista'] = $this->input->post('artista');
            $data['votos'] = $this->input->post('votos');
            $data['cancion'] = $this->input->post('cancion');
            if($_FILES['img']['name'] != ""){
                $config['upload_path']          = './assets/upload/';
                $config['allowed_types']        = '*';
                $config['max_size']             = 100000;
                $config['remove_spaces']        = TRUE;
                $config['encrypt_name']         = TRUE;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('img'))
                {
                    $this->session->set_flashdata('error',  $this->upload->display_errors());
                    redirect('topartistold/edit/'.$id);
                }
                else
                {
                    $uploaddata = $this->upload->data();
                    $s3 = S3Client::factory(
                        array(
                            'credentials' => array(
                                'key' => AWS_KEY,
                                'secret' => AWS_SECRET,
                            ),
                            'version' => 'latest',
                            'region'  => 'us-east-1'
                        )
                    );

                   try {
                        $result = $s3->putObject([
                            'Bucket' => AWS_BUCKET,
                            'Key'    => 'images/'.$uploaddata['file_name'],
                            'Body'   => fopen($uploaddata['full_path'], 'r'),
                            'ACL'    => 'public-read',
                        ]);
                        
                        $data['img'] = $result['ObjectURL'];
                    } catch (Aws\S3\Exception\S3Exception $e) {
                        $this->session->set_flashdata('error',  $e->getMessage());
                        redirect('topartistold/edit/'.$id);
                    }
                }

            }

            $this->topartistold_model->updateById($id, $data);
            $this->session->set_flashdata('success', 'Artist updated successfully');
            redirect('topartistold/edit/'.$id);
        }
    }

    public function postadd(){

        $this->load->library('form_validation');
        $this->form_validation->set_rules('artista','artista','trim|required|max_length[128]');
        $this->form_validation->set_rules('votos','votos','trim|required|max_length[128]');
        $this->form_validation->set_rules('cancion','cancion','trim|required|max_length[128]');

        if($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('error', 'Please Input Valid Values.');
            redirect('topartistold/add');
        }
        else{
            $data['artista'] = $this->input->post('artista');
            $data['votos'] = $this->input->post('votos');
            $data['cancion'] = $this->input->post('cancion');

            $config['upload_path']          = './assets/upload/';
            $config['allowed_types']        = '*';
            $config['max_size']             = 100000;
            $config['remove_spaces']        = TRUE;
            $config['encrypt_name']         = TRUE;

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('img'))
            {
                $this->session->set_flashdata('error',  $this->upload->display_errors());
                redirect('topartistold/add');
            }
            else
            {
                $uploaddata = $this->upload->data();
                $s3 = S3Client::factory(
                    array(
                        'credentials' => array(
                            'key' => AWS_KEY,
                            'secret' => AWS_SECRET,
                        ),
                        'version' => 'latest',
                        'region'  => 'us-east-1'
                    )
                );

               try {
                    $result = $s3->putObject([
                        'Bucket' => AWS_BUCKET,
                        'Key'    => 'images/'.$uploaddata['file_name'],
                        'Body'   => fopen($uploaddata['full_path'], 'r'),
                        'ACL'    => 'public-read',
                    ]);
                    
                    $data['img'] = $result['ObjectURL'];
                } catch (Aws\S3\Exception\S3Exception $e) {
                    $this->session->set_flashdata('error',  $e->getMessage());
                    redirect('topartistold/add');
                }
            }

            $this->topartistold_model->add($data);
            $this->session->set_flashdata('success', 'Artist added successfully');
            redirect('topartistold');
        }

        
    }

    public function delete($id) {
        $this->topartistold_model->delete($id);
        redirect('topartistold');
    }
    
}

?>