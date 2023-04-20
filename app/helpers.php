<?php

function formatArray($arr, $separator) {
    if (is_array($arr) || !empty($arr)) {
        if (is_array($arr) && count($arr) === 2 && trim($separator) === ',') {
            $separator = ' et ';
        }
        return formatString(implode('</strong>'.$separator.'<strong>', $arr));
    }
}

function formatString($string) {
    $stripString = mb_strtolower($string);

    $stripString = preg_replace("/\(si applicable\)/","", $stripString);
    $stripString = preg_replace('/oui, /',"", $stripString);
    $stripString = preg_replace('/pas vraiment mais les gens/',"certains personnes se", $stripString);
    $stripString = preg_replace('/groupe autour du ou d\'un projet/',"groupe autour du projet", $stripString);

    // Inclusive writing
    $stripString = preg_replace('/visiteurs et visiteuses/',"visiteur·euse·s", $stripString);
    $stripString = preg_replace('/voisins et voisines/',"voisin·e·s", $stripString);
    $stripString = preg_replace('/acteurs et actrices/',"acteur·rice·s", $stripString);
    $stripString = preg_replace('/occupants et occupantes/',"occupant·e·s", $stripString);

    // Remove everything between parantheses
    $pattern = '/\([^)]*\)/';
    $stripString = preg_replace($pattern, '', $stripString);

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
