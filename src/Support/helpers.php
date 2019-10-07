<?php

if (! function_exists('isForeignKey')) {
    function isForeignKey($field)
    {
        return ((config('valkyrie.tagType') === 'prefix')
            ? startsWith($field)
            : endsWith($field));
    }
}

if (! function_exists('startsWith')) {
    function startsWith($field)
    {
        $tag = config('valkyrie.tag');
        $len = strlen($tag);
        return (substr($field, 0, $len) === $tag);
    }
}

if (! function_exists('endsWith')) {
    function endsWith($field)
    {
        $tag = config('valkyrie.tag');
        $len = strlen($tag);
        return (substr($field, -$len) === $tag);
    }
}