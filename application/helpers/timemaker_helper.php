<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    if ( ! function_exists('makehour')) {

        function makehour($name, $type = 'metric', $htmli = '') {
            $html = '<!-- make hour -->';
            $html .= '<select name="'.$name.'" '.$htmli.' >';
            if($type == 'metric') {
                for($i=8; $i<=22; $i++) {
                    if($i < 10)
                        $html .= '<option value="0'.$i.'">0'.$i.'</option>';
                    else
                        $html .= '<option value="'.$i.'">'.$i.'</option>';
                }
            }
            $html .= '</select>';
            return $html;
        }
    }

    if ( ! function_exists('makeminutes')) {

        function makeminutes($name, $step = 10, $htmli = '') {
            $html = '<!-- make minutes -->';
            $html .= '<select name="'.$name.'" '.$htmli.' >';
            for($i=0; $i<60; $i = $i + $step) {
                if($i < 10)
                    $html .= '<option value="0'.$i.'">0'.$i.'</option>';
                else
                    $html .= '<option value="'.$i.'">'.$i.'</option>';
            }
            $html .= '</select>';
            return $html;
        }
    }

    if ( ! function_exists('makefull')) {
        function makefull($name, $step = 10, $htmli = '', $htmlc = '') {
            $html = '<!-- make full -->';
            $html .= '<select name="'.$name.'" '.$htmli.' ' .$htmlc.' >';
            for($i=0; $i<=23; $i++) {

                if($i < 10) {
                    for($j=0; $j<60; $j = $j + $step) {
                        if($i == 0 && $j == 0) {
                            $html .= '<option value="0'.$i.':0'.$j.'" selected="1">--- Ponoć ---</option>';
                        }else {
                            if($j < 10)
                                $html .= '<option value="0'.$i.':0'.$j.'">0'.$i.':0'.$j.'</option>';
                            else
                                $html .= '<option value="0'.$i.':'.$j.'">0'.$i.':'.$j.'</option>';
                        }
                    }
                }else {
                    for($j=0; $j<60; $j = $j + $step) {
                        if($i == 12 && $j == 0) {
                            $html .= '<option value="'.$i.':0'.$j.'" >--- Podne ---</option>';
                        }else {
                            if($j < 10)
                                $html .= '<option value="'.$i.':0'.$j.'">'.$i.':0'.$j.'</option>';
                            else{
                                $html .= '<option value="'.$i.':'.$j.'">'.$i.':'.$j.'</option>'; 
                            }

                        }
                    }
                }
            }
            $html .= '</select>';
            return $html;
        }
    }

?>