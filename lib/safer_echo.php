<?php

/** Safe Echo Function
 * Takes in a value and passes it through htmlspecialchars()
 * or
 * Takes an array, a key, and default value and will return the value from the array if the key exists or the default value.
 * Can pass a flag to determine if the value will immediately echo or just return so it can be set to a variable
 */
function se($v, $k = null, $default = "", $isEcho = true)
{
    if (is_array($v) && isset($k) && isset($v[$k])) {
        $returnValue = $v[$k];
    } else if (is_object($v) && isset($k) && isset($v->$k)) {
        $returnValue = $v->$k;
    } else {
        $returnValue = $v;
        if (is_array($returnValue) || is_object($returnValue)) {
            $returnValue = $default;
        } else if ($returnValue === null) {
            $returnValue = $default;
        }
    }
    if ($isEcho) {
        echo htmlspecialchars($returnValue ?? '', ENT_QUOTES);
    } else {
        return htmlspecialchars($returnValue ?? '', ENT_QUOTES);
    }
}

function safer_echo($v, $k = null, $default = "", $isEcho = true)
{
    return se($v, $k, $default, $isEcho);
}