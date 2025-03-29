<?php 

namespace Config\Config;

enum Colors: string
{
    case GREEN = '32';
    case BLUE = '34';
    case CIAN = '36';
    case RED = '31';
    case YELLOW = '33';

    public function getAnsiCode()
    {
        return "\033[" . $this->value . "m";
    }

    public function getFinalAnsi()
    {
        return "\033[0m";
    }
}