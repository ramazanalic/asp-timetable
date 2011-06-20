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
        echo '</head><body>';

        $this->_getXML('red_voznje');

        echo '</body></html>';

    }

    function _getXML($fname)
    {

        $filename = $fname.'.xml';
        $xmlfile="./assets/xml/".$filename;
        $xmlRaw = file_get_contents($xmlfile);

        $this->load->library('simplexml');
        $xmlData = $this->simplexml->xml_parse($xmlRaw);

        $this->getPrevoznik($xmlData);
        $this->getStanica($xmlData);
        $this->getPolazak($xmlData);

    }

    function getPrevoznik($xmlData){

        $html = '<table cellpadding="0" cellspacing="0" border="1">';
        $html.= '<thead>';
        $html.= '<tr>';
        $html.= '<td>NAZIV</td>';
        $html.= '<td>GRAD</td>';
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

            }

        }  


        $html.= $result;
        $html.= '</tbody>';

        echo $html;        

        echo 'Rows inserted.';

    }    

    function getStanica($xmlData){

        $html = '<table cellpadding="0" cellspacing="0" border="1">';
        $html.= '<thead>';
        $html.= '<tr>';
        $html.= '<td>NAZIV</td>';
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

        echo $i.' rows inserted.';

    }

    function getPolazak($xmlData){

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
                
                if(isset($row['vrijemepolaska'])) $vrijemepolaska = $row['vrijemepolaska'];
                if(isset($row['vrijemedolaska'])) $vrijemedolaska = $row['vrijemedolaska'];
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
                $last_id =   $this->db->insert_id();  
                
                $result .= '<tr>';
                $result .= '<td>'.$last_id.'</td>';
                $result .= '<td>'.$vrijemepolaska.'</td>';
                $result .= '<td>'.$vrijemedolaska.'</td>';
                $result .= '<td>'.$pocetnastanica.'</td>';
                $result .= '<td>'.$zadnjastanica.'</td>';
                $result .= '<td>'.$peron.'</td>';
                $result .= '<td>'.$prevoznik.'</td>';
                $result .= '<td>';
                
                foreach( $row['LISTA_STANICA'] as $stanica) {  
                     foreach( $stanica as $row2) {
                         $result.= $row2['naziv'].'<br />';
                     }
                 }
                
                $result .= '</td>';
                $result .= '</tr>';
                
                
            }

        }  


        $html.= $result;
        $html.= '</tbody>';

        echo $html;        

        echo 'Rows inserted.';

    }
    
    function getPrevoznikID($naziv){
        
        
        $res = $this->db->get_where('prevoznik',array('naziv'=>$naziv))->row_array();
        //echo $this->db->last_query();
        return $res['id'];
        
        
    }

}