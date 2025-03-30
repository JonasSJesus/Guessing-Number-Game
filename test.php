<?php

/**
 * This is the entire game but in one file.
 * this "version" of the game doesn't have other features, such as leaderboards and multi rounds.
 * It was the "first version" of the game.
 * still playable though!
 * 
 */



echo "\033[36mWelcome to the Number Guessing Game! 
I'm thinking of a number between 1 and 100. 

Please select the difficulty level: 
1. Easy (10 chances)
2. Medium (5 chances)
3. Hard (3 chances)

\033[0m";

$difficultyLevel = [
    1 => [
        "difficulty" => "Easy",
        "chances" => 10
    ],
    2 => [
        "difficulty" =>"Medium",
        "chances" => 5
    ],
    3 => [
        "difficulty" =>"Hard",
        "chances" => 3
    ],
];

$difficulty = readline("Enter Your choice: ");

echo "\n";
echo "Great! You have selected the " . $difficultyLevel[$difficulty]["difficulty"] . " difficulty level.
Let's start the game! \n";
echo "\n";

$randomNumber = rand(0, 100) ;
//$randomNumber = 50 ;
$attempts = 1;

for ($i=0; $i < $difficultyLevel[$difficulty]["chances"]; $i++) { 
    $attempt = readline("Enter your guess: ");
    
    if ( $attempt > $randomNumber ){
        echo "Incorrect! The number is less than $attempt. \n";
        echo "\n";
    }

    if ( $attempt < $randomNumber ){
        echo "Incorrect! The number is greater than $attempt. \n";
        echo "\n";
    }

    if ( $attempt == $randomNumber ){
        break;
    }

    $attempts++;
}

echo "Congratulation, you win the game in $attempts attempts! \n";
echo "\n";

echo "The number was $randomNumber \n";

