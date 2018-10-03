<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Topartistold_model extends CI_Model
{
    public $table_name = "topartist_old";

    function getAll() {
        $query = $this->db->get($this->table_name);
        $result = $query->result_array();
        if(count($result) > 0) {
            return $result;
        } else {
            return [];
        }
    }

    function getNumRows() {
         $query = $this->db->get($this->table_name);
         return $query->num_rows();
    }

    function getArtistList($page, $segment) {
        $this->db->order_by('idTopArtist', 'ASC');
        $this->db->limit($page, $segment);
        $query = $this->db->get($this->table_name);
        $result = $query->result_array();

        if(count($result) > 0) {
            return $result;
        } else {
            return [];
        }
    }

}

  