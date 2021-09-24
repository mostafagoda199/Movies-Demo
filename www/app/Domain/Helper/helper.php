<?php

if (!function_exists('getModels')) {
    /**
     * @return array
     * @author Mustafa Goda
     */
    function getModels() : array
    {
        $models = [];
        $ignore = ['.', '..'];
        foreach (array_filter(scandir(app_path().'/Models'), function ($file) use ($ignore) {
            return !in_array($file, $ignore);
        }) as $model) {
            $models[] = basename($model, '.php');
        }
        return $models;
    }
}
