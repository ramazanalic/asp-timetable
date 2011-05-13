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

        function listaj_prevoznika($id){             
            return $this->db->get_where('prevoznik',array('id'=>$id))->row_array();            
        }

        function add(){
            if($this->validate()) {
                $this->db->insert('prevoznik',$_POST);
                echo json_encode(array('success'=>'success'));
            }else {
                echo json_encode(array('success'=>'failed','message'=>$this->errors));
            }
        }

        function edit(){
            if($this->validate()) {
                $this->db->where('id', $_POST['id']);
                $this->db->update('prevoznik', $_POST);
                echo json_encode(array('success'=>'success'));
            }else {
                echo json_encode(array('success'=>'failed','message'=>$this->errors));
            }
        }

        function delete() {
            $this->db->where('id',$this->input->post('id'))->delete('prevoznik');
            echo json_encode(array('success'=>'success'));
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
