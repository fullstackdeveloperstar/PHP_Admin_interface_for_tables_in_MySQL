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

    function getById($id) {
        $this->db->where('idTopArtist', $id);
        $query = $this->db->get($this->table_name);
        $result = $query->result_array();

        if(count($result) > 0) {
            return $result[0];
        } else {
            return [];
        }
    }

    function updateById($id, $data) {
        $this->db->where('idTopArtist', $id);
        $this->db->update($this->table_name, $data);
    }

    function add($data){
        $this->db->insert($this->table_name, $data);
    }

    function delete($id) {
        $this->db->where('idTopArtist', $id);
        $this->db->delete($this->table_name);
    }

}

  