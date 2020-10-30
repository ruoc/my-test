<?php

class Message
{
    const MESSAGE = 'allMessages';
    
    public static function add($text, $class = 'success', $duration = 0)
    {
        $allMessages = (Session::get(self::MESSAGE)) ? Session::get(self::MESSAGE) : array();

        $now = time();

        array_push($allMessages, array('text' => $text, 'class' => $class, 'time' => $now, 'duration' => $duration));

        Session::set(self::MESSAGE, $allMessages);
    }

    public static function getAll()
    {
        $allMessages = (Session::get(self::MESSAGE)) ? Session::get(self::MESSAGE) : array();
        return $allMessages;
    }

    public static function cleanAll()
    {
        Session::set(self::MESSAGE, array());    
    }
    
    public static function remove($index)
    {
        $allMessages = self::getAll();

        unset($allMessages[$index]);

        Session::set(self::MESSAGE, $allMessages);
    }
    
}