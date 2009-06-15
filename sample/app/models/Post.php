<?php

/**
* Post class
*/
class Post
{
    function getAll()
    {
        return array(
            array('title' => "This is a post", 'body' => "show me the body"),
            array('title' => "Another post", 'body' => "What a testing post"),
            array('title' => "Third post", 'body' => "Testing post"));
    }
}
