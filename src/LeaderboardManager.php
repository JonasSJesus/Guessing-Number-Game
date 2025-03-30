<?php

namespace Config;

class LeaderboardManager
{
    private string $pathFile = __DIR__ . "/../Storage/ranking.json";

    public function saveToLeaderboard(string $nickName, int $points): void
    {
        if (!is_dir(__DIR__ . "/../Storage")) {
            echo "Creating directory Storage" . PHP_EOL;
            mkdir(__DIR__ . "/../Storage");
            sleep(1);
        }

        if (!is_file($this->pathFile)) {
            echo "Creating json file... " . PHP_EOL;
            touch($this->pathFile);
            sleep(1);
        }

        //data to save
        $data = [
            "Nickname" => $nickName,
            "Points" => $points
        ];

        // Transform json content in associative array
        $savedData = file_get_contents($this->pathFile);


        // Verify if already have json contents in archive
        if (!$savedData) {
            $data = [
                [
                "Nickname" => $nickName,
                "Points" => $points
                ]
            ];

            echo "Creating new table" . PHP_EOL;
            $payload = json_encode($data, JSON_PRETTY_PRINT);
            file_put_contents($this->pathFile, $payload);
            return;
        }
        
        // Append new data to old json array
        $dataToArray = json_decode($savedData, true);       
        array_push($dataToArray, $data);

        // Sort array by the highest points
        usort($dataToArray, function ($a, $b){
            return $b["Points"] <=> $a["Points"];
        });
        
        $payload = json_encode($dataToArray, JSON_PRETTY_PRINT);

        // Save the new array in file, rewriting it
        file_put_contents($this->pathFile, $payload);

    }
    

    public function showLeaderboad(): void
    {
        // get data from json
        $dataJson = file_get_contents($this->pathFile);

        // decode json to array
        $dataArray = json_decode($dataJson, true);

        // show leaderboard in CLI
        for ($i=0; $i < count($dataArray); $i++) { 
            echo $i+1 . "° | {$dataArray[$i]['Nickname']} - {$dataArray[$i]['Points']} Points" . PHP_EOL;
        }

    }
}
