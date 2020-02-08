<?php
/**
 * Created by PhpStorm.
 * User: dvilchynskyi
 * Date: 02.02.15
 * Time: 14:02
 */

namespace model;


class data
{
    protected $playersTable;

    public function __construct()
    {
        $this->playersTable = $this->parsePlayersDataTxt();

        return $this;
    }

    private function parsePlayersDataTxt()
    {
        $content = explode(';', file_get_contents(PROJECT_PATH . '/data/players/players.txt'));
        $content = explode("\r\n", end($content));
        foreach ($content as $key => $record) {
            if ($record === '') {
                unset($content[$key]);
            }
        }
        $content = array_values($content);

        $playersData = array();
        foreach ($content as $playerData) {
            $playerData = explode('.', $playerData);
            foreach ($playerData as $key => $record) {
                if ($record === '') {
                    unset($playerData[$key]);
                }
            }
            $playerData = array_values($playerData);
            $playersData[] = $playerData;
        }

        return $playersData;
    }

    public function getPlayersTable()
    {
        return $this->playersTable;
    }
}
