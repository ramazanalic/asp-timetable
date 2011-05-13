<?php

    class Polazak_m extends CI_Model {

        function __construct()
        {
            parent::__construct(); 
        }

        var $errors = '';

        /*function listaj_prevoznike(){
        $this->db->order_by("naziv", "asc");             
        return $this->db->get('prevoznik')->result_array();            
        }*/

        /*function listaj_prevoznika($id){             
        return $this->db->get_where('prevoznik',array('id'=>$id))->row_array();            
        }*/

        function add(){
            if($this->validate()) {
                //$this->db->insert('prevoznik',$_POST);
                echo json_encode(array('success'=>'success'));
            }else {
                echo json_encode(array('success'=>'failed','message'=>$this->errors));
            }
        }

        function edit(){
            /*if($this->validate()) {
            $this->db->where('id', $_POST['id']);
            $this->db->update('prevoznik', $_POST);
            echo json_encode(array('success'=>'success'));
            }else {
            echo json_encode(array('success'=>'failed','message'=>$this->errors));
            }*/
        }

        function delete() {
            /*$this->db->where('id',$this->input->post('id'))->delete('prevoznik');
            echo json_encode(array('success'=>'success'));*/
        }

        function validate() {


            $this->form_validation->set_rules('prevoznik_id','odaberite <b>prevoznika</b>','provjeri_prevoznika');       
            $this->form_validation->set_rules('vrsta_polaska','odaberite <b>vrstu</b> polaska','required');
            $this->form_validation->set_rules('prvi_polazak','odaberite datum <b>prvog</b> polaska','required');
            $this->form_validation->set_rules('zadnji_polazak','odaberite datum <b>zadnjeg</b> polaska','required');
            $this->form_validation->set_rules('pocetna_stanica','unesite <b>početnu stanicu</b>','required|provjeri_stanicu[pocetna_stanica]');

            foreach($_POST as $key => $value){

                if(substr($key,0,7)=='stanica') {

                    if($value!='Ostavite prazno da bi obrisali stanicu'){
                        $this->firephp->fb($value);
                        $this->form_validation->set_rules($key,'unesite <b>zadnju stanicu</b>','provjeri_stanicu['.$key.']');     
                    }

                }                   
            }

            $this->form_validation->set_rules('zadnja_stanica','unesite <b>zadnju stanicu</b>','required|provjeri_stanicu[zadnja_stanica]');

            $this->form_validation->set_message('required', 'Molimo %s.');

            if($this->form_validation->run()== TRUE) {
                return TRUE;
            }else {
                $this->errors = validation_errors(' ', '<br />');
                return FALSE;
            }
        }


    }
?>
