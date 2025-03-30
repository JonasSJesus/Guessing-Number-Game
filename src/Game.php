<?php

namespace Config;
 
use Config\Config\Colors;
use Config\Config\GameConfig;

class Game
{
    use GameConfig;


    private LeaderboardManager $leaderboard;
    private bool $success = false;
    private int $attempts = 1;
    private array $difficultyLevel = [
        1 => [
            "difficulty" => "\033[32mEasy\033[0m",
            "chances" => 13,
            "points_multiplier" => 1.0
        ],
        2 => [
            "difficulty" => "Medium",
            "chances" => 7,
            "points_multiplier" => 1.5
        ],
        3 => [
            "difficulty" => "Hard",
            "chances" => 5,
            "points_multiplier" => 2.0
        ],
    ];

    public function __construct() {
        $this->leaderboard = new LeaderboardManager();
    }


    public function run(): void
    {
        $this->playRound();
        sleep(1);
        echo PHP_EOL;
        echo "Table: " . PHP_EOL;
        $this->leaderboard->showLeaderboad();
    }


    /**
     * Play the game, ask for difficulty level and ask for another round 
     * 
     * @return void
     */
    public function playRound(): void
    {
        do {
            $this->showRules();
            $difficulty = (int) readline("Chose the diffculty level: ");
            
            echo PHP_EOL;
            echo "Great! You have selected the " . $this->difficultyLevel[$difficulty]["difficulty"] . " difficulty level. Let's start the game! \n";
            echo PHP_EOL;
            
            // $randomNumber = $this->generateRandomNumber();
            $randomNumber = 50;
            $success = false;
            
            for ($i=0; $i < $this->difficultyLevel[$difficulty]["chances"]; $i++) { 
                $attempt = readline("Enter your guess: ");
                if ($this->verifyNumber($randomNumber, $attempt)) {
                    $success = true;
                    break;
                }

                $this->attempts++;
            }
    
            if ($success) {
                echo $this->formatText("Congratulation, you win the game in {$this->attempts} attempts! :)", Colors::GREEN) . PHP_EOL;
                $nickName = readline("Tell me your name: (For the leaderboard ;) ");

                $points = $this->calculatePoints(
                                $this->attempts, 
                                $this->difficultyLevel[$difficulty]["chances"], 
                                $this->difficultyLevel[$difficulty]["points_multiplier"]
                            );

                $this->leaderboard->saveToLeaderboard($nickName, $points);
                echo PHP_EOL;
            } else {
                echo $this->formatText("Bad luck! you dont guess the correct number! :(", Colors::RED) . PHP_EOL;
                echo $this->formatText("the number was {$randomNumber} btw ;) ", Colors::RED) . PHP_EOL;
                echo PHP_EOL;
            }

            $question = strtolower(readline("Wanna play again? (y/N)")) ?: strtolower("n");
        } while ($question === "y");
    }


    /**
     * Compares the given number to the random number
     * 
     * @param int $number
     * @param int $attempt
     * @return bool
     */
    public function verifyNumber(int $number, int $attempt): bool
    {
        if ($attempt > $number) {
            echo "Incorrect! The number is less than $attempt. \n";
            echo "\n";
        }
    
        if ($attempt < $number) {
            echo "Incorrect! The number is greater than $attempt. \n";
            echo "\n";
        }
    
        if ($attempt == $number) {
            return true;
        }

        return false;
    }


    /**
     * Generates one number between 0 and 100
     * 
     * @return int
     */
    private function generateRandomNumber(): int
    {
        return rand(0, 100);
    }


    /**
     * Points based system instead of number of attempts
     * 
     * @param int $attempts
     * @param string $chances
     * @param float $multiplier
     * @return float
     */
    private function calculatePoints(int $attempts, string $chances, float $multiplier): int
    {
        $points = (($chances - $attempts + 1) / $chances ) * 100 * $multiplier;

        return $points;
    }
}
