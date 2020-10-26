<?php

function date_range($first, $last, $step = '+1 day', $output_format = 'Y-m-d H:i:s')
{

    $dates = array();
    $current = strtotime($first);
    $last = strtotime($last);

    while ($current <= $last) {

        $dates[] = date($output_format, $current);
        $current = strtotime($step, $current);
    }


    if (strtotime($dates[count($dates) - 1]) < $last) {

        $dates[] = date($output_format, $last);

    }

    return $dates;
}

function set_alerts($alerts_array = array())
{
    session_start();
    $_SESSION['alerts'] = json_encode($alerts_array);
}

function set_alert($type, $msg)
{
    session_start();
    $_SESSION['alerts'] = json_encode(array('type' => $type, 'msg' => $msg));

}

function permutations(&$elements)
{
    if (count($elements) < 2) return $elements;

    $newperms = array();
    foreach ($elements as $key => $element) {
        $newelements = $elements;
        unset($newelements[$key]);

        $perms = permutations($newelements);
        foreach ($perms as $perm) {
            $newperms[] = $element . " " . $perm;
        }
    }
    return $newperms;
}


function permuteUnique($items, $perms = [], &$return = []) {
    if (empty($items)) {
        $return[] = implode(' ', $perms);
    } else {
        sort($items);
        $prev = false;
        for ($i = count($items) - 1; $i >= 0; --$i) {
            $newitems = $items;
            $tmp = array_splice($newitems, $i, 1)[0];
            if ($tmp != $prev) {
                $prev = $tmp;
                $newperms = $perms;
                array_unshift($newperms, $tmp);
                permuteUnique($newitems, $newperms, $return);
            }
        }
        return $return;
    }
}

?>