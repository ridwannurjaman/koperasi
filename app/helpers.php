<?php


if(!function_exists('formatRupiah')){
    function formatRupiah($value)
    {
        $hasil_rupiah = "Rp " . number_format($value,2,',','.');
        return $hasil_rupiah;
    }
}
if(!function_exists('formatAngka')){
    function formatAngka($value)
    {
        $res = number_format($value,0,',','.');
        return $res;
    }
}