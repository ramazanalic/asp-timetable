<?php

    class Core_m extends CI_Model {

        function __construct()
        {
            parent::__construct(); 
        }

        function listaj_prevoznike(){
            return $this->db->get('prevoznik')->result_array();            
        }
    }
?>
