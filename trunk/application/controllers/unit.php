<?php

require_once($application_folder."/controllers/navigator.php");
class Unit extends navigator 
{


    /************************************************************* 
    *PROMJENI SAMO STRING U DOLASCI DA BI UNOSIO DOLASKE
    *************************************************************/ 

    var $TYPE = 'dolasci';
    var $XML;
    var $prefix; 
    var $sufix; 

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set ('Europe/Belgrade');

        echo $this->TYPE;
        switch ($this->TYPE) {

            case 'polasci':

                $this->XML = 'rvP.xml';
                $this->sufix = '';
                $this->prefix = 'p';

                break;

            case 'dolasci':

                $this->XML = 'rvD.xml';
                $this->sufix = '_d';
                $this->prefix = 'd';

                break;
        }

    }


    function timetest(){
        $timestamp = time();
        $datum = $this->translateDays(date("l",$timestamp));
        echo "Current day on this server is $datum <br>\n";
    }

    function translateDays($dayEng){

        switch ( $dayEng ){
            case 'Monday': return 'Ponedjeljak'; break;
            case 'Tuesday': return 'Utorak'; break;
            case 'Wednesday': return 'Srijeda'; break;
            case 'Thursday': return 'Cetvrtak'; break;
            case 'Friday': return 'Petak'; break;
            case 'Saturday': return 'Subota'; break;
            case 'Sunday': return 'Nedjelja'; break;
        }

    }

    function index()
    {

        echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN"> ';
        echo '<html><head>';
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
        echo '<style>body{font-size:11px;}</style>';
        echo '<style>table,tr,td{font-size:12px; border:1px dotted #dedede}</style>';
        echo '<style>td{padding:4px}</style>';
        echo '<title>Transfer podataka u bazu</title>';
        echo '</head><body>';

        echo $this->XML;
        $this->_getXML($this->XML);

        echo '</body></html>';

    }

    function _getXML($fname)
    {

        $filename = $fname;
        $xmlfile="./assets/xml/".$filename; 
        $xmlRaw = file_get_contents($xmlfile);

        $this->load->library('simplexml');  
        $xmlData = $this->simplexml->xml_parse($xmlRaw);

        $this->getStanica($xmlData);
        $this->polasci($xmlData);

    }  

    function getStanica($xmlData){


        $html = '<table cellpadding="0" cellspacing="0" border="1">';
        $html.= '<thead>';
        $html.= '<tr>';
        $html.= '<td><b>NAZIV</b></td>';
        $html.= '</tr>';
        $html.= '</thead>';
        $html.= '<tbody>';

        $result = '';

        foreach($xmlData['LISTA_STANICA'] as $stanice=>$value)
        {

            $cnt = count($value);
            for ($i=0;$i<$cnt;$i++){


                $result .= '<tr>';
                $result .= '<td>'.$value[$i].'</td>';
                $result .= '</tr>';

                $data = array(

                'naziv' => $value[$i]

                );


                $this->db->insert('stanica'.$this->sufix,$data);

            } 


        }  


        $html.= $result;
        $html.= '</tbody>';

        echo $html;        

        echo "<br /><br />"; 

        echo 'TABLE "<b>STANICA'.$this->sufix.'</b>" - '.$i. ' rows inserted'; 



    }


    /* 
    *  Tipovi polaska
    *  
    *  p = peridiocni polazaka na svakih n dana
    *  d = dnevni polazaka svakim danom
    *  o = polasci odredjenim danima (ponedjeljak, utorak, petak...)
    * 
    */

    function polasci($xmlData){

        foreach($xmlData['LISTA_POLAZAKA'] as $polazak2)
        {
            foreach($polazak2 as $polazak)
            {
                /************************************************************* 
                *  Pripremi podatke za polazak
                *************************************************************/ 

                $prvipolazak = NULL;
                $zadnjipolazak = NULL;
                $vrijemepolaska = NULL;
                $vrijemedolaska = NULL;
                $pocetnastanica = NULL;
                $zadnjastanica = NULL;
                $peron = NULL;
                $prevoznik_naziv = NULL;
                $tippolaska = NULL;
                $periodicni = NULL;
                $dnevni = NULL;
                $odredjenidani = NULL;


                if(isset($polazak['vaziod'])) $prvipolazak = strtotime($polazak['vaziod']);
                if(isset($polazak['vazido'])) $zadnjipolazak = strtotime($polazak['vazido']);
                if(isset($polazak['vrijemepolaska'])) $vrijemepolaska = strtotime("01.01.2011 ".$polazak['vrijemepolaska']);
                if(isset($polazak['vrijemedolaska'])) $vrijemedolaska = strtotime("01.01.2011 ".$polazak['vrijemedolaska']);
                if(isset($polazak['pocetnastanica'])) $pocetnastanica = $polazak['pocetnastanica'];
                if(isset($polazak['zadnjastanica'])) $zadnjastanica = $polazak['zadnjastanica'];
                if(isset($polazak['peron'])) $peron = $polazak['peron'];
                if(isset($polazak['prevoznik'])) $prevoznik = $polazak['prevoznik'];

                /************************************************************* 
                *  Uzmi atribut tippolaska
                *************************************************************/
                if(isset($polazak['@attributes']['tippolaska'])) {

                    $tippolaska = $polazak['@attributes']['tippolaska'];

                    if($tippolaska == 'p'){

                        $periodicni = $polazak['brojponavljanja'];

                    }else if ($tippolaska == 'd'){

                            $dnevni = TRUE;

                        }else if ($tippolaska == 'o'){

                                $odredjenidani = TRUE;

                            }else echo 'erro tip polaska';
                }


                $data = array(
                'prvipolazak' =>  $prvipolazak ,
                'zadnjipolazak' =>  $zadnjipolazak ,
                'vrijemepolaska' =>  $vrijemepolaska ,
                'vrijemedolaska' =>  $vrijemedolaska ,
                'pocetnastanica' =>  $pocetnastanica ,
                'zadnjastanica' =>   $zadnjastanica ,
                'peron' =>  $peron ,
                'naziv_prevoznika' =>  $prevoznik,
                'tippolaska' =>  $tippolaska,
                'periodicni'  => $periodicni,          
                'dnevni'  => $dnevni,          
                'odredjenidani'  => $odredjenidani          
                );


                /************************************************************* 
                *  Unesi polazak i uzmi id
                *************************************************************/
                $this->db->insert($this->prefix.'olazak',$data);

                $last_id = $this->db->insert_id(); 

                /************************************************************* 
                *  Unesi odredjene dane polaska  
                *************************************************************/
                if($odredjenidani){

                    //echo '<br /><br />Polazak '.$pocetnastanica.' - '.$zadnjastanica.' ide danima:<br />';


                    if(count($polazak['DANI']['dan'])==1){
                        $this->db->insert('danipolaska'.$this->sufix, array($this->prefix.'olazak_id' =>  $last_id , 'dan' => strtolower($polazak['DANI']['dan'])));
                        //echo strtolower($polazak['DANI']['dan']);    
                    }else{
                        foreach( $polazak['DANI'] as $dan) {  

                            foreach($dan as $value){
                                $this->db->insert('danipolaska'.$this->sufix, array($this->prefix.'olazak_id' =>  $last_id , 'dan' => strtolower($value)));
                                //echo strtolower($value).'<br />';
                            } 

                        } 
                    }

                } 

                /************************************************************* 
                *  Unesi listu stanica
                *************************************************************/
                foreach( $polazak['LISTA_STANICA'] as $stanica) {  

                    foreach( $stanica as $row) {

                        //echo $row['naziv']; 

                        $vrijemepolaska_stop = NULL;
                        $vrijemedolaska_stop = NULL;
                        $km = NULL;


                        $stanica_id = $this->getStanicaID($row['naziv']);

                        //echo "<br />ID STANICE:".$stanica_id."<br />";  

                        if(isset($row['vrijemepolaska'])) $vrijemepolaska_stop = strtotime("01.01.2011 ".$row['vrijemepolaska']);
                        if(isset($row['vrijemedolaska'])) $vrijemedolaska_stop = strtotime("01.01.2011 ".$row['vrijemedolaska']);
                        if(isset($row['km'])) $km = $row['km'];

                        $stop_stanica = array(
                        'stanica'.$this->sufix.'_id' =>  $stanica_id ,
                        'vrijemepolaska' =>  $vrijemepolaska_stop ,
                        'vrijemedolaska' =>  $vrijemedolaska_stop ,
                        'km' =>  $km ,
                        $this->prefix.'olazak_id' =>   $last_id 
                        );

                        $this->db->insert('stopstanica'.$this->sufix, $stop_stanica);

                    }

                }
            }
        }

        echo 'Usjesna akcija.';
    }

    function getStanicaID($naziv){


        $res = $this->db->get_where('stanica'.$this->sufix, array('naziv'=>$naziv))->row_array();
        //echo $this->db->last_query();
        return $res['id'];


    }  

    /*
    * 
    * The strtotime function [php.net] will accept a wide range of textual formats, 
    * including counts of particular day names like "+3 monday" (third monday from today) 
    * or "-2 friday" (two fridays ago). So, if you want the next 52 weeks worth of mondays, 
    * a simple loop will do the trick.
    * 
    */


    function loop_everu_moday(){

        for($i=1; $i<=52; $i++){
            echo date("M d Y", strtotime('+'.$i.' Monday')).'<br>';
        }

    }

    function loop_every_day(){

        $dayCount = 0;

        for($i=1; $i<=365; $i++){

            if ($dayCount++ % 2 == 1 ){
                echo date("M d Y", strtotime('+'.$i.' days')).'<br>';    
            }


        }
    }

}