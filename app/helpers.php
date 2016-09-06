<?php

if (!function_exists('active_if')) {
    /**
     * @param $condition
     *
     * @return string
     */
    function active_if($condition)
    {
        return ($condition) ? ' class="active"' : '';
    }
}
