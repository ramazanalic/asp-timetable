<?php

    class Polazak_m extends CI_Model {

        function __construct()
        {
            parent::__construct(); 
        }

        var $errors = '';

        function listaj_stanice(){


            /* Return as regular string Array */
            
            $arr = array();
            $this->db->order_by("naziv", "asc");             
            $res = $this->db->get('stanica')->result_array();  

            
            /* Prepare data for autocomplete */
            
            foreach($res as $stanica){
                $arr[]= $stanica['naziv'];
            }

            return $arr;          
        }

        function pogledaj_stop_stanice(){

            $data = array();

            $this->db->select('stopstanica.*, stanica.naziv as naziv_stanice', FALSE);
            $this->db->join('stanica', 'stanica.id = stopstanica.stanica_id ');
            $data['res'] = $this->db->get_where('stopstanica',array('polazak_id'=>$_POST['id_polaska']))->result_array();

            $this->firephp->fb($this->db->last_query());   

            $HTML = '<div class="lista_stop_stanica">';

            $HTML .= $this->load->view('polazak/pogledaj_stop_stanice', $data, TRUE);

            $HTML .= '</div">';

            return $HTML;


        }

        function listaj_stop_stanice($polazak_id){
            $this->db->select('stopstanica.*, stanica.naziv as naziv_stanice', FALSE);
            $this->db->join('stanica', 'stanica.id = stopstanica.stanica_id ');
            $res = $this->db->get_where('stopstanica',array('polazak_id'=>$polazak_id))->result_array();
            return $res;
        }

        function listaj_polazak($id){             
            return $this->db->get_where('polazak',array('id'=>$id))->row_array();            
        }

        function listaj_polaske(){             
            $this->db->select('polazak.*, prevoznik.naziv as naziv_prevoznika, prevoznik.grad as grad_prevoznika', FALSE);
            $this->db->join('prevoznik', 'prevoznik.id = polazak.prevoznik_id ');
            $res = $this->db->get('polazak')->result_array();  
            return $res;
        }

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
                'pocetnastanica' => $_POST['pocetna_stanica'],
                'zadnjastanica' => $_POST['zadnja_stanica'],
                'vrijemepolaska' => strtotime($_POST['vrijemepolaska_pocetna']),
                'vrijemedolaska' => strtotime($_POST['vrijemedolaska_zadnja']),
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

                $cnt = 0;
                if(isset($_POST['stanica'])) $cnt = count($_POST['stanica']);

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
                'pocetnastanica' => $_POST['pocetna_stanica'],
                'zadnjastanica' => $_POST['zadnja_stanica'],
                'vrijemepolaska' => strtotime($_POST['vrijemepolaska_pocetna']),
                'vrijemedolaska' => strtotime($_POST['vrijemedolaska_zadnja']),
                'dnevni' => $dnevni,
                'vikendom' => $vikendom,
                'sezonski' => $sezonski,
                'prevoznik_id' => $_POST['prevoznik_id'],
                'prvipolazak' => strtotime($_POST['prvipolazak']),
                'zadnjipolazak' => strtotime($_POST['zadnjipolazak']),
                'peron' => $_POST['peron'],
                );

                $this->db->where('id', $_POST['id']);                
                $this->db->update('polazak',$polazak);


                /* Uzmi id polaska */

                $polazak_id = $_POST['id'];


                /* Prvo briši sve stop stanice */
                
                $this->db->where('polazak_id', $polazak_id);                
                $this->db->delete('stopstanica');

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

                $cnt = 0;
                if(isset($_POST['stanica'])) $cnt = count($_POST['stanica']);

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

        function delete() {
            $this->db->where('id',$this->input->post('id'))->delete('polazak');
            echo json_encode(array('success'=>'success'));
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
