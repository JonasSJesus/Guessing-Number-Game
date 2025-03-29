<?php

namespace Config\Config;

use Config\Config\Colors;


trait GameConfig
{


    /**
     * Show the rules of the game
     * 
     * @return void
     */
    private function showRules(): void
    {
        echo $this->formatText("Welcome to the guessing game!", Colors::BLUE) . PHP_EOL;
        echo $this->formatText("I'm thinking of a number between 1 and 100.", Colors::GREEN) . PHP_EOL;
        echo PHP_EOL;
        echo "Please select the difficulty level: \n";
        echo $this->formatText("1. Easy (13 chances)", Colors::GREEN);
        echo $this->formatText("2. Medium (7 chances)", Colors::YELLOW);
        echo $this->formatText("3. Hard (5 chances)", Colors::RED);
        echo PHP_EOL;
    }

    /**
     * Shows the menu options
     * 
     * @return void
     */
    private function showMenu(): bool|string
    {
        echo PHP_EOL;
        echo $this->formatText("Welcome to the guessing game!", Colors::BLUE) . PHP_EOL;
        echo $this->formatText("Selecione a opção desejada: ");
        echo $this->formatText("1. Play!");
        echo $this->formatText("2. Show leaderboard."); 
        echo $this->formatText("3. Exit") . PHP_EOL;

        $choice = readline("Select your choice: ");

        return $choice;
    }

    /**
     * Put color in text using Colors enum
     * 
     * @param mixed $text
     * @param \Config\Config\Colors $color
     * @return string
     */
    private function formatText($text, Colors|null $color = null): string
    {
        return $color != null ? $color->getAnsiCode() . $text . $color->getFinalAnsi() . PHP_EOL : $text . PHP_EOL;
    }

}
