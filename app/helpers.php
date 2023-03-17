<?php

function formatArray($arr, $separator) {
    return formatString(implode($separator, $arr));
}

function formatString($string) {
    $stripString = mb_strtolower($string);

    $stripString = preg_replace("/\(si applicable\)/","", $stripString);
    $stripString = preg_replace('/oui, /',"", $stripString);
    $stripString = preg_replace('/pas vraiment mais les gens/',"certains personnes se", $stripString);

    switch ($stripString) {
        case 'quotidienne':
            return 'au quotidien';
            break;

        case 'ponctuelle':
            return 'de manière ponctuelle';
            break;

        default:
            return $stripString;
            break;
    }
}

?>
