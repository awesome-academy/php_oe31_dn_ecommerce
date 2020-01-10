<?php
function convertVnd($strNum) {
    $len = strlen($strNum);
    $counter = config('custome.cf_function_sp.convert_vnd.counter');
    $loopCod = config('custome.cf_function_sp.convert_vnd.loop_codition');
    $jumps = config('custome.cf_function_sp.convert_vnd.start_jump');
    $startSub = config('custome.cf_function_sp.convert_vnd.start_sub');
    $lengthSub = config('custome.cf_function_sp.convert_vnd.length_sub');
    $startSubCod = config('custome.cf_function_sp.convert_vnd.start_sub_codition');
    $lengthSubCod = config('custome.cf_function_sp.convert_vnd.length_sub_codition');
    $unitVnd = config('custome.unit_vnd');
    $result = "";

    while ($len - $counter >= $loopCod) {
        $con = substr($strNum, $len - $counter, $jumps);
        $result = '.' . $con . $result;
        $counter += $jumps;
    }

    $con = substr($strNum, $startSub , $lengthSub - ($counter - $len));
    $result = $con . $result;
    if (substr($result, $startSubCod, $lengthSubCod) == '.') {
        $result = substr($result, $lengthSubCod, $len + 2);
    }
    $result = $result . $unitVnd;

    return $result;
}
