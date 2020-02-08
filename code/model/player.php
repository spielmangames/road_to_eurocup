<?php

namespace model;

class player
{
    protected $name;
    protected $nationality;
    protected $nationalityFlagPath;
    protected $attributes;
    protected $perks;
    protected $dateOfBirth;
    protected $transfermarktData;
    protected $isClassic;
    protected $isActive;
    protected $imagePath;

    public function __construct($playerName)
    {
        $playerData = $this->preparePlayerData($playerName);

        $this->name = $playerData[1];
        $this->nationality = $playerData[0];
        $this->nationalityFlagPath = '/road_to_eurocup/data/teams/' . $this->nationality . '.png';
        $this->attributes = $this->prepareAttributes($playerData[2]);
        $this->perks = $this->preparePerks($playerData[3]);
        $this->dateOfBirth = $playerData[4];
        $this->transfermarktData = $this->prepareTransfermarktData($playerData[5]);
//        $this->isClassic = (bool)$playerData[6];
//        $this->isActive = (bool)$playerData[7];
        $this->imagePath = '/road_to_eurocup/data/players/' . $this->nationality . '/' . $this->name . '.jpg';

        return $this;
    }

    private function preparePlayerData($playerName)
    {
        $data = new data();
        foreach ($data->getPlayersTable() as $playerData) {
            if ($playerData[1] === $playerName) {
                return $playerData;
            }
        }
    }

    private function prepareAttributes($playerAttributesData)
    {
        $attributes = [];
        $playerAttributesData = explode('|', $playerAttributesData);
        foreach ($playerAttributesData as $key => $record) {
            if ($record === '') {
                unset($playerAttributesData[$key]);
            }
        }
        $playerAttributesData = array_values($playerAttributesData);


        foreach ($playerAttributesData as $playerAttributeData) {
            $playerAttributeData = str_replace(': a', ' ', $playerAttributeData);
            $playerAttributeData = str_replace(' d', ' ', $playerAttributeData);
            $playerAttributeData = explode(' ', $playerAttributeData);
            $attributes[$playerAttributeData[0]] = [
                'attack' => (int)$playerAttributeData[1],
                'defence' => (int)$playerAttributeData[2]
            ];
        }

        return $attributes;
    }

    private function preparePerks($playerPerksData)
    {
        if ($playerPerksData == ' ') {
            return null;
        }

        $perksList = $this->parsePerksDataTxt();
        $playerPerksData = explode(',', $playerPerksData);

        $perks = [];
        foreach ($playerPerksData as $playerPerkData) {
            $perks[$playerPerkData] = $perksList[$playerPerkData];
        }

        return $perks;
    }

    private function prepareTransfermarktData($playerTransfermarktData)
    {
        $playerTransfermarktData = explode(' ', $playerTransfermarktData);
        $transfermarktData = [];
        $transfermarktData['link'] = sprintf(
            'http://www.transfermarkt.com/%s/profil/spieler/%s',
            $playerTransfermarktData[0],
            $playerTransfermarktData[1]
        );

        return $transfermarktData;
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
                'notes' => $record[5],
            ];
        }

        return $perks;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getNationality()
    {
        return $this->nationality;
    }

    public function getNationalityFlagPath()
    {
        return $this->nationalityFlagPath;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function getPerks()
    {
        return $this->perks;
    }

    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    public function getTransfermarktData()
    {
        return $this->transfermarktData;
    }

    public function getIsClassic()
    {
        return $this->isClassic;
    }

    public function getIsActive()
    {
        return $this->isActive;
    }

    public function getImagePath()
    {
        return $this->imagePath;
    }
}
