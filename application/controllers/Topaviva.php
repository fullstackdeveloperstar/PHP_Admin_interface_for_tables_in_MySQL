<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
class Topaviva extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('topaviva_model');
        $this->isLoggedIn();   
    }
    
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $this->global['pageTitle'] = 'Avivamiento : Topaviva';

        $this->load->library('pagination');
            
        $count = $this->topaviva_model->getNumRows();

        $returns = $this->paginationCompress ( "topaviva/", $count, 10 );
            
        $this->global['topavivalist'] = $this->topaviva_model->getAvivaList($returns["page"], $returns["segment"]);
            
        $this->loadViews("topaviva/index", $this->global, NULL , NULL);
    }

    public function edit($id) {
        $this->global['pageTitle'] = 'Avivamiento : Topaviva';

        $this->global['aviva'] = $this->topaviva_model->getById($id);
            
        $this->loadViews("topaviva/edit", $this->global, NULL , NULL);
    }

    public function add() {
        $this->global['pageTitle'] = 'Avivamiento : Topaviva';
            
        $this->loadViews("topaviva/add", $this->global, NULL , NULL);
    }

    public function postedit($id) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('artista','artista','trim|required|max_length[128]');
        $this->form_validation->set_rules('votos','votos','trim|required|max_length[128]');
        $this->form_validation->set_rules('cancion','cancion','trim|required|max_length[128]');

        if($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('error', 'Please Input Valid Values.');
            redirect('topaviva/edit/'.$id);
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
                    redirect('topaviva/edit/'.$id);
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
                        redirect('topaviva/edit/'.$id);
                    }
                }

            }

            if($_FILES['music']['name'] != ""){
                $config['upload_path']          = './assets/upload/';
                $config['allowed_types']        = '*';
                $config['max_size']             = 100000;
                $config['remove_spaces']        = TRUE;
                $config['encrypt_name']         = TRUE;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('music'))
                {
                    $this->session->set_flashdata('error',  $this->upload->display_errors());
                    redirect('topaviva/edit/'.$id);
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
                            'Key'    => 'musics/'.$uploaddata['file_name'],
                            'Body'   => fopen($uploaddata['full_path'], 'r'),
                            'ACL'    => 'public-read',
                        ]);
                        
                        $data['file'] = $result['ObjectURL'];
                    } catch (Aws\S3\Exception\S3Exception $e) {
                        $this->session->set_flashdata('error',  $e->getMessage());
                        redirect('topaviva/edit/'.$id);
                    }
                }

            }

            $this->topaviva_model->updateById($id, $data);
            $this->session->set_flashdata('success', 'Aviva updated successfully');
            redirect('topaviva/edit/'.$id);
        }
    }

    public function postadd(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('artista','artista','trim|required|max_length[128]');
        $this->form_validation->set_rules('votos','votos','trim|required|max_length[128]');
        $this->form_validation->set_rules('cancion','cancion','trim|required|max_length[128]');

        if($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('error', 'Please Input Valid Values.');
            redirect('topaviva/add');
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
                redirect('topaviva/add');
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
                    redirect('topaviva/add');
                }
            }

            if ( ! $this->upload->do_upload('music'))
            {
                $this->session->set_flashdata('error',  $this->upload->display_errors());
                redirect('topaviva/add');
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
                        'Key'    => 'musics/'.$uploaddata['file_name'],
                        'Body'   => fopen($uploaddata['full_path'], 'r'),
                        'ACL'    => 'public-read',
                    ]);
                    
                    $data['file'] = $result['ObjectURL'];
                } catch (Aws\S3\Exception\S3Exception $e) {
                    $this->session->set_flashdata('error',  $e->getMessage());
                    redirect('topaviva/add');
                }
            }

            $this->topaviva_model->add($data);
            $this->session->set_flashdata('success', 'Aviva added successfully');
            redirect('topaviva');
        }
    }

    public function delete($id) {
        $this->topaviva_model->delete($id);
        redirect('topaviva');
    }
    
}

?>