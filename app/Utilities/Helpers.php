<?php

use App\Entities\User;

if (!function_exists('firstUser')) {
    /**
     *  Checks if no users are registered
     *
     * @return bool
     */
    function firstUser()
    {
        return (User::count() == 0);
    }
}