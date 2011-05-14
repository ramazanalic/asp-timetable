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


                /* Vrsta polaska */

                if($_POST['vrstapolaska']=='dnevni'){
                    $dnevni = TRUE;
                    $vikendom = FALSE;
                }else if($_POST['vrstapolaska']=='vikendom'){
                        $dnevni = FALSE;
                        $vikendom = TRUE;
                    }
                    if(isset($_POST['sezonski'])){
                    $sezonski = TRUE;
                }else{
                    $sezonski = FALSE;
                }

                /* Polazak */

                $polazak = array(
                'datumvrijeme' => strtotime($_POST['prvipolazak']),
                'dnevni' => $dnevni,
                'vikendom' => $vikendom,
                'sezonski' => $sezonski,
                'prevoznik_id' => $_POST['prevoznik_id'],
                'prvipolazak' => strtotime($_POST['prvipolazak']),
                'zadnjipolazak' => strtotime($_POST['zadnjipolazak']),
                'peron' => $_POST['peron'],
                );

                $this->db->insert('polazak',$polazak);


                /* Uzmi id polaska */

                $polazak_id = $this->db->insert_id();



                /* Pocetna */

                /* Uzmi id stanice */

                $stanica = $this->db->get_where('stanica',array('naziv'=>$_POST['pocetna_stanica']))->row_array();

                $pocetna = array(

                'stanica_id' => $stanica['id'],
                'vrijemepolaska' => strtotime($_POST['vrijemepolaska_pocetna']),
                'vrijemedolaska' => NULL,
                'km' => $_POST['km_pocetna'],
                'polazak_id' => $polazak_id                    

                );

                $this->db->insert('stopstanica',$pocetna);



                /* Stop Stanice */

                $cnt = count($_POST['stanica']);

                for($i=0;$i<$cnt;$i++) {

                    if ($_POST['stanica'][$i] != 'Ostavite prazno da bi obrisali stanicu')
                    {


                        /* Uzmi id stanice */


                        $stanica = $this->db->get_where('stanica',array('naziv'=>$_POST['stanica'][$i]))->row_array();


                        $stop_stanica = array(

                        'stanica_id' => $stanica['id'],
                        'vrijemepolaska' => strtotime($_POST['vrijemepolaska'][$i]),
                        'vrijemedolaska' => strtotime($_POST['vrijemedolaska'][$i]),
                        'km' => $_POST['km'][$i],
                        'polazak_id' => $polazak_id                    

                        );


                        $this->db->insert('stopstanica',$stop_stanica);

                    }  


                }



                /* Zadnja */

                /* Uzmi id stanice */

                $stanica = $this->db->get_where('stanica',array('naziv'=>$_POST['zadnja_stanica']))->row_array();

                $zadnja = array(

                'stanica_id' => $stanica['id'],
                'vrijemepolaska' => NULL,
                'vrijemedolaska' => strtotime($_POST['vrijemedolaska_zadnja']),
                'km' => $_POST['km_zadnja'],
                'polazak_id' => $polazak_id                    

                );

                $this->db->insert('stopstanica',$zadnja);              


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
            $this->form_validation->set_rules('vrstapolaska','odaberite <b>vrstu</b> polaska','required');
            $this->form_validation->set_rules('prvipolazak','odaberite datum <b>prvog</b> polaska','required');
            $this->form_validation->set_rules('zadnjipolazak','odaberite datum <b>zadnjeg</b> polaska','required');
            $this->form_validation->set_rules('pocetna_stanica','unesite <b>početnu stanicu</b>','required|provjeri_stanicu[pocetna_stanica]');

            $this->form_validation->set_rules('stanica[]','BLA BLA','provjeri_stop_stanicu');

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
