<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');

    function paging_assoc($varkey, $assoc_n=3)
    {
        $CI =& get_instance();

        $qs_arr = $CI->uri->uri_to_assoc($assoc_n);
        $qs_tmp_arr=array();
        foreach($qs_arr as $key => $value)
            if ($key!=$varkey) $qs_tmp_arr[$key]=$value;

        foreach($CI->uri->segment_array() as $key => $value)
            if ($value=='p') $assoc_n = $key;

        $ofset = (isset($qs_arr[$varkey])) ? $qs_arr[$varkey] : 0;
        $qs_uri = $CI->uri->assoc_to_uri($qs_tmp_arr).'/'.$varkey;

        return array(
            'ofset' => $ofset,
            'seg' => $assoc_n+1,
            'uri' => $qs_uri,
            );
    }