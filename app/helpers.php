<?php

function formatArray($arr, $separator, $lastSeparator = null) {
    if (is_array($arr) || !empty($arr)) {
        if (is_array($arr) && count($arr) === 2 && trim($separator) === ',') {
            $separator = ' et ';
        }

        $count = count($arr);
        if ($count > 1 && $lastSeparator !== null) {
            $lastItem = array_pop($arr);
            $formattedString = implode('</strong>' . $separator . '<strong>', $arr);
            $formattedString .= '</strong>' . $lastSeparator . '<strong>' . $lastItem;
            return formatString($formattedString);
        } else {
            return formatString(implode('</strong>'.$separator.'<strong>', $arr));
        }
    }
}

function formatString($string) {
    $stripString = mb_strtolower($string);

    $stripString = preg_replace("/\(si applicable\)/","", $stripString);
    $stripString = preg_replace('/oui, /',"", $stripString);
    $stripString = preg_replace('/pas vraiment mais les gens/',"certains personnes se", $stripString);
    $stripString = preg_replace('/groupe autour du ou d\'un projet/',"groupe autour du projet", $stripString);
    $stripString = preg_replace('/acteurs et actrices du quartier, associations ou entreprises locales/',"acteurs et actrices du quartier", $stripString);

    // Inclusive writing
    $stripString = preg_replace('/visiteurs et visiteuses/',"visiteur·euse·s", $stripString);
    $stripString = preg_replace('/voisins et voisines/',"voisin·e·s", $stripString);
    $stripString = preg_replace('/acteurs et actrices/',"acteur·rice·s", $stripString);
    $stripString = preg_replace('/occupants et occupantes/',"occupant·e·s", $stripString);

    // Effets sociaux "santé"
    $stripString = preg_replace('/certaines personnes ont fait part ou ont paru/',"", $stripString);
    $stripString = preg_replace('/certaines personnes ont fait preuve/',"", $stripString);
    $stripString = preg_replace('/certaines personnes ont fait part/',"certains personnes se", $stripString);

    // Effets sociaux insertion professionnelle
    $stripString = preg_replace('/des emplois ont été créés au sein du lieu/',"d'obtenir des emplois au sein du lieu ", $stripString);
    $stripString = preg_replace('/des emplois ont été créés à l\'extérieur/',"d'obtenir des emplois à l'extérieur du lieu", $stripString);




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

function extractPercentageAndText($input) {
    $pattern = '/^(\d+(?:[,.]\d+)?)\s*%?\s*(.*)/';

    if (preg_match($pattern, $input, $matches)) {
        $percentageOrNumber = $matches[1];
        $restOfSentence = $matches[2];

        $wrappedPercentageOrNumber = $percentageOrNumber ? '<div class="number">' . $percentageOrNumber . '</div>' : '';
        $wrappedRestOfSentence = $restOfSentence ? '<div class="bold">' . $restOfSentence . '</div>' : '';

        return [$wrappedPercentageOrNumber, $wrappedRestOfSentence];
    } else {
        return ['<div class="bold">' . $input . '</div>', ''];
    }
}

?>
