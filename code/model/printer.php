<?php

namespace model;

class printer
{
    public function printTeamPlayers($teamName)
    {
        $result = [];
        $team = new team($teamName);
        $players = $team->getPlayers();
        foreach ($players as $player) {
            $result[] = $this->preparePlayer($player);
        }

        echo json_encode($result, JSON_PRETTY_PRINT);
    }

    public function printPlayers(array $playersNames)
    {
        $result = [];
        foreach ($playersNames as $playerName) {
            $player = new player($playerName);
            $result[] = $this->preparePlayer($player);
        }

        echo json_encode($result, JSON_PRETTY_PRINT);
    }

    private function preparePlayer($player)
    {
        return [
            'name' => $player->getName(),
            'classic' => $this->prepareIsClassic($player),
            'dateOfBirth' => $player->getDateOfBirth(),
            'nationalityFlag' => $player->getNationalityFlagPath(),
            'nationality' => $player->getNationality(),
            'attributes' => $this->preparePlayerAttributes($player),
            'attackPerks' => $this->preparePlayerPerks($player, 'att'),
            'defencePerks' => $this->preparePlayerPerks($player, 'def'),
            'photo' => $player->getImagePath()
        ];
    }

    private function preparePlayerPerks($player, $perkType)
    {
        $playerPerks = [];
        $perks = $player->getPerks();
        if (!$perks) {
            return '';
        }
        foreach ($perks as $perkKey => $perk) {
            if ($perk['type'] === $perkType) {
                $playerPerks[] = [
                    'key' => $perkKey,
                    'title' => $perk['title']
                ];
            }
        }

        return $playerPerks;
    }

    private function prepareIsClassic($player)
    {
        return $player->getIsClassic() ? ' (classic)' : '';
    }

    private function preparePlayerAttributes($player)
    {
        $playerAttributes = [];
        foreach ($player->getAttributes() as $position => $attributes) {
            $playerAttributes[] = [
                'position' => $position,
                'attack' => $attributes['attack'],
                'defence' => $attributes['defence']
            ];
        }

        return $playerAttributes;
    }

    public function printTacticalCards()
    {
        $result = [];
        foreach ($this->getTacticalCards() as $key => $teamCard) {
            $result[] = [
                'key' => $key,
                'title' => $teamCard['title'],
                'description1' => $teamCard['description1'],
                'description2' => $teamCard['description2'],
                'result' => $teamCard['result']
            ];
        }
        $result = $this->removeEmpties($result);

        echo json_encode($result, JSON_PRETTY_PRINT);
    }

    private function getTacticalCards()
    {
        $content = explode('----' . "\n", file_get_contents('C:\xampp\htdocs\road_to_eurocup\data\tactical.txt'));
        foreach ($content as $key => $record) {
            if ($record == '﻿') {
                unset($content[$key]);
            }
        }
        $content = array_values($content);

        $teamCards = [];
        foreach ($content as $record) {
            $record = explode('/', $record);
            if (count($record) !== 5) {
                echo 'invalid team card ' . $record[0] . ' formatting!';
                die;
            }
            $teamCards[$record[0]] = [
                'title' => $record[1],
                'description1' => $record[2],
                'description2' => $record[3],
                'result' => $record[4]
            ];
        }

        return $teamCards;
    }

    public function printHomeTacticalCards()
    {
        $result = [];
        foreach ($this->getHomeTacticalCards() as $key => $teamCard) {
            $result[] = [
                'key' => $key,
                'title' => $teamCard['title'],
                'description1' => $teamCard['description1'],
                'description2' => $teamCard['description2'],
                'result' => $teamCard['result']
            ];
        }

        echo json_encode($result, JSON_PRETTY_PRINT);
    }

    private function getHomeTacticalCards()
    {
        $content = explode('----' . "\n", file_get_contents('C:\xampp\htdocs\road_to_eurocup\data\hometactical.txt'));
        foreach ($content as $key => $record) {
            if ($record == '﻿') {
                unset($content[$key]);
            }
        }
        $content = array_values($content);

        $teamCards = [];
        foreach ($content as $record) {
            $record = explode('/', $record);
            if (count($record) !== 5) {
                echo 'invalid team card ' . $record[0] . ' formatting!';
                die;
            }
            $teamCards[$record[0]] = [
                'title' => $record[1],
                'description1' => $record[2],
                'description2' => $record[3],
                'result' => $record[4]
            ];
        }

        return $teamCards;
    }

    public function printPerks()
    {
        $result = [];
        foreach ($this->parsePerksDataTxt() as $key => $perk) {
            $result[] = [
                'key' => $key,
                'type' => $perk['type'],
                'title' => $perk['title'],
                'short_description' => $perk['short_description'],
                'long_description' => $perk['long_description'],
                'notes' => $perk['notes'],
            ];
        }

        echo json_encode($result, JSON_PRETTY_PRINT);
    }

    public function setPerksMap()
    {
        $filePath = PROJECT_PATH . '/data/perks_map.txt';

        $result = '';
        foreach ($this->parsePerksDataTxt() as $key => $perk) {
            $result .= '[' . $key . '] ' . $perk['title'];
            $result .= "\r\n     " . $perk['short_description'];
            $result .= "\r\n     " . $perk['long_description'];
            $result .= "\r\n     " . $perk['notes'] . "\r\n";
        }
        file_put_contents($filePath, $result);
    }

    private function parsePerksDataTxt()
    {
        $content = explode('----' . "\r\n", file_get_contents(PROJECT_PATH . '/data/perks.txt'));
        foreach ($content as $key => $record) {
            if ($record === '﻿') {
                unset($content[$key]);
            }
        }
        $content = array_values($content);

        $perks = [];
        foreach ($content as $record) {
            $record = explode('/', $record);
            if (count($record) !== 6) {
                echo 'invalid perk ' . $record[0] . ' formatting!';
                die;
            }
            $perks[$record[1]] = [
                'type' => $record[0],
                'title' => $record[2],
                'short_description' => $record[3],
                'long_description' => $record[4],
                'notes' => $this->getPerksResult($record[5]),
            ];
        }

        return $perks;
    }

    public function removeEmpties($array)
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = $this->removeEmpties($value);
                $array[$key] = $value;
            }
            if ($value === ' ') {
                unset($array[$key]);
            }
        }
        return $array;
    }

    public function getPerksResult($perkResultId)
    {
        $content = explode('----' . "\r\n", file_get_contents(PROJECT_PATH . '/data/perks_results.txt'));
        foreach ($content as $key => $record) {
            if ($record === '﻿') {
                unset($content[$key]);
            }
        }
        $content = array_values($content);

        $perksResults = [];
        foreach ($content as $record) {
            $record = explode('/', $record);
            if (count($record) !== 2) {
                echo 'invalid perk result ' . $record[0] . ' formatting!';
                die;
            }
            $perksResults[$record[0]] = [
                'result' => $record[1]
            ];
        }

        $perkResultId = str_replace("\r\n", '', $perkResultId);
        $perkResult = $perksResults[$perkResultId]['result'];

        return $perkResult;
    }

    public function printEmptyGamePlans()
    {
        $result = [];
        for ($i = 0; $i < 27; $i++) {
            $result[$i]['brick'] = '/road_to_eurocup/code/brick.png';
            $result[$i]['bricklong'] = '/road_to_eurocup/code/brick_long.png';
        }
        $result = $this->removeEmpties($result);

        echo json_encode($result, JSON_PRETTY_PRINT);
    }
}
