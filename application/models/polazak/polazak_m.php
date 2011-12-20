<?php

    class Polazak_m extends CI_Model {

        /************************************************************* 
        *  $TYPE STRING 
        *  POLASCI I DOLASCI
        *************************************************************/ 

        var $TYPE;
        var $prefix; 
        var $sufix;
        
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
            
            //tip polaska -> polazak ili dolazak
            $this->TYPE = $_POST['type'];

            switch ($this->TYPE) {

                case 'polasci':

                    $this->sufix = '';
                    $this->prefix = 'p';

                    break;

                case 'dolasci':

                    $this->sufix = '_d';
                    $this->prefix = 'd';

                    break;
            }

            $data = array();

            $this->db->select('stopstanica'.$this->sufix.'.*, stanica'.$this->sufix.'.naziv as naziv_stanice', FALSE);
            $this->db->join('stanica'.$this->sufix, 'stanica'.$this->sufix.'.id = stopstanica'.$this->sufix.'.stanica'.$this->sufix.'_id ');
            $data['res'] = $this->db->get_where('stopstanica'.$this->sufix, array($this->prefix.'olazak_id'=>$_POST['id_polaska']))->result_array();

            //$this->firephp->fb($this->db->last_query());   

            $HTML = '<div class="lista_stop_stanica">';

            $HTML .= $this->load->view('polazak/pogledaj_stop_stanice', $data, TRUE);

            $HTML .= '</div">';

            return $HTML;


        }

        function pogledaj_detalje_polaska(){

            switch ($_POST['tip_polaska']){
                case 'o':

                    $data['res'] = $this->db->get_where('danipolaska', array('polazak_id' => $_POST['id_polaska']))->result_array();

                    return $this->load->view('polazak/pogledaj_detalje_polaska_oderedjenimdanima', $data, TRUE);

                    break;

                case 'p':
                
                    $data['res'] = $this->db->get_where('polazak', array('id' => $_POST['id_polaska']))->result_array();
                    
                    return $this->load->view('polazak/pogledaj_detalje_polaska_periodicno', $data, TRUE);
                
                    break;
                    
                    case 'd':
                    return '<table class="tablesorter" id="stop_stanice_tbl" cellpadding="0" cellspacing="0" width="100%"><thead><tr class="header-row"><th width="140px">Dani polaska</th><th width="20"><a href="javascript:" id="close_stop" ><img src="assets/img/backgnds/x.png" style="margin-top: 3px;" /></a></th></tr></thead><tbody><tr><td>Polazi svakim danom.</td><td>&nbsp;</td></tr><tr id="lst_odd"><td>&nbsp;</td><td>&nbsp;</td></tr></tbody> ';
                    break;
            }



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
                'vrijemepolaska' => strtotime("01.01.2011 ".$_POST['vrijemepolaska_pocetna']),
                'vrijemedolaska' => strtotime("01.01.2011 ".$_POST['vrijemedolaska_zadnja']),
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
                'vrijemepolaska' => strtotime("01.01.2011 ".$_POST['vrijemepolaska_pocetna']),
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
                        'vrijemepolaska' => strtotime("01.01.2011 ".$_POST['vrijemepolaska'][$i]),
                        'vrijemedolaska' => strtotime("01.01.2011 ".$_POST['vrijemedolaska'][$i]),
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
                'vrijemedolaska' => strtotime("01.01.2011 ".$_POST['vrijemedolaska_zadnja']),
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
                'vrijemepolaska' => strtotime("01.01.2011 ".$_POST['vrijemepolaska_pocetna']),
                'vrijemedolaska' => strtotime("01.01.2011 ".$_POST['vrijemedolaska_zadnja']),
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
                'vrijemepolaska' => strtotime("01.01.2011 ".$_POST['vrijemepolaska_pocetna']),
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
                        'vrijemepolaska' => strtotime("01.01.2011 ".$_POST['vrijemepolaska'][$i]),
                        'vrijemedolaska' => strtotime("01.01.2011 ".$_POST['vrijemedolaska'][$i]),
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
                'vrijemedolaska' => strtotime("01.01.2011 ".$_POST['vrijemedolaska_zadnja']),
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

        /* Pretraga voznog reda Autobuske Stanice Podgorica 
        do kraja klase

        function search(){

        if($this->validate_search()==TRUE){

        $polazna_id = $this->get_stanica_id($_GET['srch_polazak']);
        $dolazna_id = $this->get_stanica_id($_GET['srch_dolazak']);

        $polasci_ids = $this->daj_spisak_polazaka_koji_ukljucuju($polazna_id, $dolazna_id);

        if(count($polasci_ids)>0){

        $html = '';

        foreach($polasci_ids as $value){
        $html .= $this->load->view('polazak/search', array('polasci' => $this->listaj_podatke_stanice_sa_id_polaska($value)), TRUE);
        }

        echo $_GET['jsoncall'] . '(' . json_encode(array('success' => true, 'html'=> $html)) . ');';

        }else{
        echo $_GET['jsoncall'] . '(' . json_encode(array('success' => true, 'html'=> '<tr class="odd"><td colspan="9" style="text-align: center;"><b>NEMA POLAZAKA ZA TRAŽENU RUTU</b></td></tr>.')) . ');';   
        }



        } else{

        echo $_GET['jsoncall'] . '(' . json_encode(array('success' => false, 'html'=>$this->errors)) . ');';

        }

        }

        function validate_search() {

        $_POST = $_GET;

        $this->form_validation->set_rules('srch_polazak','unesite <b>polaznu stanicu</b>','required|provjeri_stanicu[srch_polazak]');

        $this->form_validation->set_rules('srch_dolazak','unesite <b>dolaznu stanicu</b>','required|provjeri_stanicu[srch_dolazak]');

        $this->form_validation->set_message('required', 'Molimo %s.');

        if($this->form_validation->run()== TRUE) {
        return TRUE;
        }else {
        $this->errors = validation_errors(' ', '<br />');
        return FALSE;
        }
        }

        function get_stanica_id($name){

        $res = $this->db->get_where('stanica',array('naziv' => $name))->row_array();

        return $res['id'];

        }

        function listaj_podatke_stanice_sa_id_polaska($polazak_id){

        $this->db->select('polazak.*, prevoznik.naziv as naziv_prevoznika, prevoznik.grad as grad_prevoznika', FALSE);

        $this->db->join('prevoznik', 'prevoznik.id = polazak.prevoznik_id ');

        $this->db->where(array('polazak.id' => $polazak_id));

        return $this->db->get('polazak')->result_array(); 

        }

        function daj_spisak_polazaka_koji_ukljucuju($polazna_id, $dolazna_id){  //return Array


        $lista_polazaka = array();



        $res1 = $this->db->get('polazak')->result_array();

        foreach($res1 as $rs1){



        $id_ili_false = $this->da_li_ima_ovaj_polazak_ovim_redosledom($polazna_id, $dolazna_id, $rs1['id']);

        if($id_ili_false != FALSE){
        $lista_polazaka[] = $id_ili_false;  
        }


        }

        RETURN $lista_polazaka;

        }

        function da_li_ima_ovaj_polazak_ovim_redosledom($polazna_id, $dolazna_id, $polazak_id){  //return id polaska




        $this->db->where(array('stanica_id' => $polazna_id , 'polazak_id' => $polazak_id));
        $this->db->from('stopstanica');
        $cnt1 = $this->db->count_all_results();

        if($cnt1 ==0)   RETURN FALSE;




        $res1 = $this->db->get_where('stopstanica', array('stanica_id' => $polazna_id , 'polazak_id' => $polazak_id))->row_array();
        $id1 = $res1['id'];




        $this->db->where(array('stanica_id' => $dolazna_id , 'polazak_id' => $polazak_id));
        $this->db->from('stopstanica');
        $cnt2 = $this->db->count_all_results();

        if($cnt2 ==0)   RETURN FALSE;



        $res2 = $this->db->get_where('stopstanica', array('stanica_id' => $dolazna_id , 'polazak_id' => $polazak_id))->row_array();
        $id2 = $res2['id'];


        if($id2 > $id1){

        $this->firephp->fb('stopstanicaid-1: '.$id1);
        $this->firephp->fb('stopstanicaid-2: '.$id2);
        $this->firephp->fb('id-polaska: '.$polazak_id);
        $this->firephp->fb('---------------------------');
        RETURN $polazak_id;

        } else RETURN FALSE;
        }

        */
    }
?>
