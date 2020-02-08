<?php

namespace model;

class team
{
    protected $name;
    protected $players;
    protected $imagePath;

    public function __construct($name)
    {
        $this->name = $name;
        $this->players = $this->preparePlayers();
        $this->imagePath = '/road_to_eurocup/data/teams/' . $this->name . '.png';

        return $this;
    }

    private function preparePlayers()
    {
        $players = array();
        $data = new data();
        foreach ($data->getPlayersTable() as $playerData) {
            if ($playerData[0] === $this->name) {
                $player = new player($playerData[1]);
                $players[$player->getName()] = $player;
            }
        }

        return $players;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPlayers()
    {
        return $this->players;
    }

    public function getImagePath()
    {
        return $this->imagePath;
    }
}
