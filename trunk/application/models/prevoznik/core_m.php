<?php

    class Core_m extends CI_Model {

        function __construct()
        {
            parent::__construct(); 
        }

        var $errors = '';

        function listaj_prevoznike(){
            $this->db->order_by("naziv", "asc");             
            return $this->db->get('prevoznik')->result_array();            
        }

        function add(){
            if($this->validate()) {
                $this->db->insert('prevoznik',$_POST);
                echo json_encode(array('success'=>'success'));
            }else {
                echo json_encode(array('success'=>'failed','message'=>$this->errors));
            }
        }

        function validate() {
            $this->form_validation->set_rules('naziv','<b>naziv</b> prevoznika','trim|required');
            $this->form_validation->set_message('required', 'Molimo unesite %s.');
            if($this->form_validation->run()) {
                return TRUE;
            }else {
                $this->errors = validation_errors(' ', '<br />');
                return FALSE;
            }
        }
    }
?>
