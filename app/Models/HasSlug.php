<?php


namespace App\Models;


interface HasSlug
{
    /**
     * Determine if model uses slug.
     *
     * @return bool
     */
    public function hasSlug();
}
