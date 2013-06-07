<?php namespace AntonioRibeiro\Libraries;

use Illuminate\Routing\Controllers\Controller as IlluminateController;

class MyBaseController extends IlluminateController {

    /**
     * Sets the active theme.
     *
     * @param  mixed  $active
     * @return Cartalyst\Themes\ThemeInterface
     */
    public static function setActive($active)
    {
        /// do what you have to do
    }
    
}