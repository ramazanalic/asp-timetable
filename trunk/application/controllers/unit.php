<?php
require_once($application_folder."/controllers/navigator.php");
class Unit extends navigator 
{

    function __construct()
    {
        parent::__construct(); 
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
        echo '</head><body>';
        
        $this->_getXML('rv.xml');
        //$this->_getXML('red_voznje.xml'); 

        echo '</body></html>';

    }

    function _getXML($fname)
    {

        $filename = $fname;
        $xmlfile="./assets/xml/".$filename; 
        $xmlRaw = file_get_contents($xmlfile);
        
        $this->load->library('simplexml');  
        $xmlData = $this->simplexml->xml_parse($xmlRaw);
          
        $this->getPrevoznik($xmlData);
        $this->getStanica($xmlData);
        $this->getPolazak($xmlData);

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

    function getPolazak($xmlData){

        $counter = 0;
        $counter2 = 0;
        
        $html = '<table cellpadding="0" cellspacing="0" border="1">';
        $html.= '<thead>';
        $html.= '<tr>';
        $html.= '<td>id</td>';
        $html.= '<td>vrijemepolaska</td>';
        $html.= '<td>vrijemedolaska</td>';
        $html.= '<td>pocetnastanica</td>';
        $html.= '<td>zadnjastanica</td>';
        $html.= '<td>peron</td>';
        $html.= '<td>prevoznik</td>';
        $html.= '<td>stanice</td>';
        $html.= '</tr>';
        $html.= '</thead>';
        $html.= '<tbody>';

        $result = '';

        foreach($xmlData['LISTA_POLAZAKA'] as $polazak)
        {
            foreach( $polazak as $row) {

                $vrijemepolaska = NULL;
                $vrijemedolaska = NULL;
                $pocetnastanica = NULL;
                $zadnjastanica = NULL;
                $peron = NULL;
                $prevoznik = NULL;

                if(isset($row['vrijemepolaska'])) $vrijemepolaska = strtotime("01.01.2011 ".$row['vrijemepolaska']);
                if(isset($row['vrijemedolaska'])) $vrijemedolaska = strtotime("01.01.2011 ".$row['vrijemedolaska']);
                if(isset($row['pocetnastanica'])) $pocetnastanica = $row['pocetnastanica'];
                if(isset($row['zadnjastanica'])) $zadnjastanica = $row['zadnjastanica'];
                if(isset($row['peron'])) $peron = $row['peron'];
                if(isset($row['prevoznik'])) $prevoznik = $row['prevoznik'];

                $prevoznik = $this->getPrevoznikID($prevoznik);

                $data = array(
                'vrijemepolaska' =>  $vrijemepolaska ,
                'vrijemedolaska' =>  $vrijemedolaska ,
                'pocetnastanica' =>  $pocetnastanica ,
                'zadnjastanica' =>   $zadnjastanica ,
                'peron' =>  $peron ,
                'prevoznik_id' =>  $prevoznik
                );


                $this->db->insert('polazak',$data);
                // $last_id = 111;
                
                $counter++;
                
                $last_id =   $this->db->insert_id();  
                
                $printvp = '';
                $printvd = '';
                if(isset($vrijemepolaska)){$printvp = date('d.m.Y H:i',$vrijemepolaska);}
                if(isset($vrijemedolaska)){$printvd = date('d.m.Y H:i',$vrijemedolaska);}

                $result .= '<tr>';
                $result .= '<td>'.$last_id.'</td>';
                $result .= '<td>'.$printvp.'</td>';
                $result .= '<td>'.$printvd.'</td>';
                $result .= '<td>'.$pocetnastanica.'</td>';
                $result .= '<td>'.$zadnjastanica.'</td>';
                $result .= '<td>'.$peron.'</td>';
                $result .= '<td>'.$prevoznik.'</td>';
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
                        
                        $this->db->insert('stopstanica',$stop_stanica);
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

}