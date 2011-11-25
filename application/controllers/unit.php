<?php

require_once($application_folder."/controllers/navigator.php");
class Unit extends navigator 
{

    function __construct()
    {
        parent::__construct(); 
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
        //load the parser library
        $this->load->library('parser');

        echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN"> ';
        echo '<html><head>';
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
        echo '<style>body{font-size:11px;}</style>';
        echo '<style>table,tr,td{font-size:12px; border:1px dotted #dedede}</style>';
        echo '<style>td{padding:4px}</style>';
        echo '<title>Transfer podataka u bazu</title>';
        echo '</head><body>';

        $this->_getXML('rvP.xml');

        echo '</body></html>';

    }

    function trancuate(){
        $query1 = 'TRUNCATE `danipolaska`';
        $query2 = 'DELETE FROM `polazak`';        
        $query3 = 'TRUNCATE `prevoznik`';
        $query4 = 'TRUNCATE `stanica`';
        $query5 = 'TRUNCATE `stopstanica`';
        $query6 = 'DELETE FROM `danipolaska`'; 

        $this->db->query($query6);
        $this->db->query($query5);
        $this->db->query($query2);

        /*$this->db->query($query1);        
        $this->db->query($query3);
        $this->db->query($query4);
        $this->db->query($query5);*/ 
    }

    function _getXML($fname)
    {

        $this->trancuate();

        $filename = $fname;
        $xmlfile="./assets/xml/".$filename; 
        $xmlRaw = file_get_contents($xmlfile);

        $this->load->library('simplexml');  
        $xmlData = $this->simplexml->xml_parse($xmlRaw);

        //$this->getPrevoznik($xmlData);
        //$this->getStanica($xmlData);
        //$this->getPolazak($xmlData);
        $this->polasci($xmlData);

    }

    function getPrevoznik($xmlData){

        $counter = 0;

        $html = "";

        $html.= '<table cellpadding="0" cellspacing="0" border="1">';
        $html.= '<thead>';
        $html.= '<tr>';
        $html.= '<td><b>NAZIV</b></td>';
        $html.= '<td><b>GRAD</b></td>';
        $html.= '</tr>';
        $html.= '</thead>';
        $html.= '<tbody>';

        $result = '';

        foreach($xmlData['LISTA_PREVOZNIKA'] as $prevoznik)
        {
            foreach( $prevoznik as $row) {

                $result .= '<tr>';
                $result .= '<td>'.$row['naziv'].'</td>';
                $result .= '<td>'.$row['grad'].'</td>';
                $result .= '</tr>';

                $data = array(
                'naziv' => $row['naziv'] ,
                'grad' => $row['grad']
                );


                $this->db->insert('prevoznik',$data);

                $counter++;

            }

        }  


        $html.= $result;
        $html.= '</tbody>';

        echo $html;        

        echo 'TABLE "<b>PREVOZNK</b>" - '.$counter. ' rows inserted';

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


                $this->db->insert('stanica',$data);

            } 


        }  


        $html.= $result;
        $html.= '</tbody>';

        echo $html;        

        echo "<br /><br />"; 

        echo 'TABLE "<b>STANICA</b>" - '.$i. ' rows inserted'; 



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
                $prevoznik = NULL;
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

                /************************************************************* 
                *  Uzmi id prevoznika
                *************************************************************/
                $prevoznik = $this->getPrevoznikID($prevoznik);


                $data = array(
                'prvipolazak' =>  $prvipolazak ,
                'zadnjipolazak' =>  $zadnjipolazak ,
                'vrijemepolaska' =>  $vrijemepolaska ,
                'vrijemedolaska' =>  $vrijemedolaska ,
                'pocetnastanica' =>  $pocetnastanica ,
                'zadnjastanica' =>   $zadnjastanica ,
                'peron' =>  $peron ,
                'prevoznik_id' =>  $prevoznik,
                'tippolaska' =>  $tippolaska,
                'periodicni'  => $periodicni,          
                'dnevni'  => $dnevni,          
                'odredjenidani'  => $odredjenidani          
                );


                /************************************************************* 
                *  Unesi polazak i uzmi id
                *************************************************************/
                $this->db->insert('polazak',$data);

                $last_id = $this->db->insert_id(); 

                /************************************************************* 
                *  Unesi odredjene dane polaska  
                *************************************************************/
                if($odredjenidani){

                    //echo '<br /><br />Polazak '.$pocetnastanica.' - '.$zadnjastanica.' ide danima:<br />';


                    if(count($polazak['DANI']['dan'])==1){
                        $this->db->insert('danipolaska',array('polazak_id' =>  $last_id , 'dan' => strtolower($polazak['DANI']['dan'])));
                        //echo strtolower($polazak['DANI']['dan']);    
                    }else{
                        foreach( $polazak['DANI'] as $dan) {  

                            foreach($dan as $value){
                                $this->db->insert('danipolaska',array('polazak_id' =>  $last_id , 'dan' => strtolower($value)));
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
                        'stanica_id' =>  $stanica_id ,
                        'vrijemepolaska' =>  $vrijemepolaska_stop ,
                        'vrijemedolaska' =>  $vrijemedolaska_stop ,
                        'km' =>  $km ,
                        'polazak_id' =>   $last_id 
                        );

                        $this->db->insert('stopstanica',$stop_stanica);

                    }

                }
            }
        }

        echo 'Usjesna akcija.';
    }

    function getPolazak($xmlData){

        $counter = 0;
        $counter2 = 0;

        $html = '<table cellpadding="0" cellspacing="0" border="1">';
        $html.= '<thead>';
        $html.= '<tr>';
        $html.= '<td>id</td>';
        $html.= '<td>prvipolazak</td>';
        $html.= '<td>zadnjipolazak</td>';
        $html.= '<td>vrijemepolaska</td>';
        $html.= '<td>vrijemedolaska</td>';
        $html.= '<td>pocetnastanica</td>';
        $html.= '<td>zadnjastanica</td>';
        $html.= '<td>peron</td>';
        $html.= '<td>prevoznik</td>';
        $html.= '<td>tippolaska</td>';
        $html.= '<td>stanice</td>';
        $html.= '</tr>';
        $html.= '</thead>';
        $html.= '<tbody>';

        $result = '';

        foreach($xmlData['LISTA_POLAZAKA'] as $polazak)
        {
            foreach( $polazak as $row) {

                $prvipolazak = NULL;
                $zadnjipolazak = NULL;
                $vrijemepolaska = NULL;
                $vrijemedolaska = NULL;
                $pocetnastanica = NULL;
                $zadnjastanica = NULL;
                $peron = NULL;
                $prevoznik = NULL;
                $tippolaska = NULL;
                $periodicni = NULL;
                $dnevni = NULL;
                $odredjenidani = NULL;


                if(isset($row['vaziod'])) $prvipolazak = strtotime($row['vaziod']);
                if(isset($row['vazido'])) $zadnjipolazak = strtotime($row['vazido']);
                if(isset($row['vrijemepolaska'])) $vrijemepolaska = strtotime("01.01.2011 ".$row['vrijemepolaska']);
                if(isset($row['vrijemedolaska'])) $vrijemedolaska = strtotime("01.01.2011 ".$row['vrijemedolaska']);
                if(isset($row['pocetnastanica'])) $pocetnastanica = $row['pocetnastanica'];
                if(isset($row['zadnjastanica'])) $zadnjastanica = $row['zadnjastanica'];
                if(isset($row['peron'])) $peron = $row['peron'];
                if(isset($row['prevoznik'])) $prevoznik = $row['prevoznik'];

                if(isset($row['@attributes']['tippolaska'])) {

                    $tippolaska = $row['@attributes']['tippolaska'];

                    if($tippolaska == 'p'){

                        $periodicni = $row['brojponavljanja'];

                    }else if ($tippolaska == 'd'){

                            $dnevni = TRUE;

                        }else if ($tippolaska == 'o'){

                                $odredjenidani = TRUE;

                            }else echo 'erro tip polaska';
                }

                $prevoznik = $this->getPrevoznikID($prevoznik);

                $data = array(
                'prvipolazak' =>  $prvipolazak ,
                'zadnjipolazak' =>  $zadnjipolazak ,
                'vrijemepolaska' =>  $vrijemepolaska ,
                'vrijemedolaska' =>  $vrijemedolaska ,
                'pocetnastanica' =>  $pocetnastanica ,
                'zadnjastanica' =>   $zadnjastanica ,
                'peron' =>  $peron ,
                'prevoznik_id' =>  $prevoznik,
                'tippolaska' =>  $tippolaska,
                'periodicni'  => $periodicni,          
                'dnevni'  => $dnevni,          
                'odredjenidani'  => $odredjenidani          
                );


                $this->db->insert('polazak',$data);

                $counter++;

                $last_id =   $this->db->insert_id(); 

                //echo 'odredjenidani-'.$odredjenidani.'<br />';

                //Unesi odredjene dane polaska
                if($odredjenidani){

                    if(count($row['DANI'])==1){
                        $this->db->insert('danipolaska',array('polazak_id' =>  $last_id , 'dan' => strtolower($row['DANI']['dan'][0])));    
                    }else{
                        foreach( $row['DANI'] as $dan) {  

                            foreach($dan as $value){
                                $this->db->insert('danipolaska',array('polazak_id' =>  $last_id , 'dan' => strtolower($value)));
                            } 

                        } 
                    }

                } 

                $printpp = '';
                $printzp = '';
                $printvp = '';
                $printvd = '';

                if(isset($prvipolazak)){$printpp = date('d.m.Y H:i',$prvipolazak);}
                if(isset($zadnjipolazak)){$printzp = date('d.m.Y H:i',$zadnjipolazak);}
                if(isset($vrijemepolaska)){$printvp = date('d.m.Y H:i',$vrijemepolaska);}
                if(isset($vrijemedolaska)){$printvd = date('d.m.Y H:i',$vrijemedolaska);}

                $result .= '<tr>';
                $result .= '<td>'.$last_id.'</td>';
                $result .= '<td>'.$printpp.'</td>';
                $result .= '<td>'.$printzp.'</td>';
                $result .= '<td>'.$printvp.'</td>';
                $result .= '<td>'.$printvd.'</td>';
                $result .= '<td>'.$pocetnastanica.'</td>';
                $result .= '<td>'.$zadnjastanica.'</td>';
                $result .= '<td>'.$peron.'</td>';
                $result .= '<td>'.$prevoznik.'</td>';

                $result .= '<td>'.$tippolaska.' - '. $row['@attributes']['opis'] .'</td>';

                $result .= '<td>';

                foreach( $row['LISTA_STANICA'] as $stanica) {  

                    foreach( $stanica as $row2) {

                        $vrijemepolaska_stop = NULL;
                        $vrijemedolaska_stop = NULL;
                        $km = NULL;


                        $stanica_id = $this->getStanicaID($row2['naziv']);

                        //echo "<br />ID STANICE:".$stanica_id."<br />";  

                        if(isset($row2['vrijemepolaska'])) $vrijemepolaska_stop = strtotime("01.01.2011 ".$row2['vrijemepolaska']);
                        if(isset($row2['vrijemedolaska'])) $vrijemedolaska_stop = strtotime("01.01.2011 ".$row2['vrijemedolaska']);
                        if(isset($row2['km'])) $km = $row2['km'];

                        $printvps = '';
                        $printvds = '';

                        if(isset($vrijemepolaska_stop)){$printvps = date('d.m.Y H:i',$vrijemepolaska_stop);}
                        if(isset($vrijemedolaska_stop)){$printvps = date('d.m.Y H:i',$vrijemedolaska_stop);}

                        $stop_stanica = array(
                        'stanica_id' =>  $stanica_id ,
                        'vrijemepolaska' =>  $vrijemepolaska_stop ,
                        'vrijemedolaska' =>  $vrijemedolaska_stop ,
                        'km' =>  $km ,
                        'polazak_id' =>   $last_id 
                        );

                        //$this->db->insert('stopstanica',$stop_stanica);
                        $counter2++;

                        $result.='<TABLE><TR>';
                        $result.= '<TD style="width:100px">'.$row2['naziv'].'</TD><TD> vp: '.$printvps.'</TD><TD>vd: '.$printvds.'</TD>';
                        $result.='</TR></TABLE>';



                    }

                }

                $result.= '<br />TABLE "<b>STOPSTANICA</b>" - '.$counter2. ' rows inserted<br />';

                $counter2 = 0;

                $result .= '</td>';
                $result .= '</tr>';


            }

        }  


        $html.= $result;
        $html.= '</tbody>';

        echo $html;        

        echo '<br /><br />TABLE "<b>POLAZAK</b>" - '.$counter. ' rows inserted';  

    }      

    function getPrevoznikID($naziv){


        $res = $this->db->get_where('prevoznik',array('naziv'=>$naziv))->row_array();
        //echo $this->db->last_query();
        return $res['id'];


    }

    function getStanicaID($naziv){


        $res = $this->db->get_where('stanica',array('naziv'=>$naziv))->row_array();
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

}