<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

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
        // $this->global['topartistoldlist'] = $this->topartistold_model->getAll();

        $this->load->library('pagination');
            
        $count = $this->topartistold_model->getNumRows();

        $returns = $this->paginationCompress ( "topartistold/", $count, 10 );
            
        $this->global['topartistoldlist'] = $this->topartistold_model->getArtistList($returns["page"], $returns["segment"]);
            
        $this->loadViews("topartistold/index", $this->global, NULL , NULL);
    }

    public function edit($id) {
        
    }
    
}

?>