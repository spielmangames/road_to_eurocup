<?php

$league1Teams = [
    1 => 'дніпро',
    2 => 'зоря',
    3 => 'металіст',
    4 => 'динамо',
    5 => 'металург',
    6 => 'шахтар',
    7 => 'чорноморець',
    8 => 'ворскла',
];
$league2Teams = [
    1 => 'буковина',
    2 => 'таврія',
    3 => 'кривбас',
    4 => 'іллічівець',
    5 => 'волинь',
    6 => 'карпати',
    7 => 'нива',
    8 => 'оболонь',
];

$legs = [
    [[1, 5], [2, 6], [3, 7], [4, 8]],
    [[1, 8], [2, 5], [3, 6], [4, 7]],
    [[1, 7], [2, 8], [3, 5], [4, 6]],
    [[1, 6], [2, 7], [3, 8], [4, 5]],
    [[1, 2], [3, 4], [5, 6], [7, 8]],
    [[1, 3], [2, 4], [5, 7], [6, 8]],
    [[1, 4], [2, 3], [5, 8], [6, 7]],
];
shuffle($legs);
shuffle($legs);

if (!validateSchedule($league1Teams, $legs)) {
    echo "помилка: список матчів сформовано невірно";
    die;
}

$leaguesSchedule = getLeaguesSchedule($league1Teams, $league2Teams, $legs);
$leagueCupSchedule = getLeagueCupSchedule($league1Teams);

$a = 1;

function validateSchedule(array $leagueTeams, array $legs)
{
    $allMatches = getAllMatches($leagueTeams);
    foreach ($legs as $leg) {
        if (!legIsCompleted($leg)) {
            return false;
        }
        foreach ($leg as $match) {
            unset($allMatches[array_search($match, $allMatches)]);
        }
    }
    if (!empty($allMatches)) {
        return false;
    }
    return true;
}

function getAllMatches(array $leagueTeams)
{
    $allMatches = [];
    for ($i = 1; $i <= count($leagueTeams); $i++) {
        for ($j = 1; $j <= count($leagueTeams); $j++) {
            if ($i !== $j) {
                if (!in_array([$i, $j], $allMatches) && !in_array([$j, $i], $allMatches)) {
                    $allMatches[] = [$i, $j];
                }
            }
        }
    }
    if ((count($leagueTeams) * (count($leagueTeams) - 1)) / 2 !== count($allMatches)) {
        return null;
    }
    return $allMatches;
}

function legIsCompleted(array $leg)
{
    $unique = [1, 2, 3, 4, 5, 6, 7, 8];
    foreach ($leg as $match) {
        unset($unique[array_search($match[0], $unique)]);
        unset($unique[array_search($match[1], $unique)]);
    }
    if (!empty($unique)) {
        return false;
    }
    return true;
}

function getLeaguesSchedule(array $league1Teams, array $league2Teams, array $legs)
{
    $league1Schedule = [];
    $league2Schedule = [];
    for ($leg = 0; $leg < count($legs); $leg++) {
        foreach ($legs[$leg] as $match) {
            shuffle($match);
            shuffle($match);
            $league1Schedule[$leg + 1][] = [$league1Teams[$match[0]], $league1Teams[$match[1]]];
            $league2Schedule[$leg + 1][] = [$league2Teams[$match[0]], $league2Teams[$match[1]]];
        }
    }
    return [
        "league1" => $league1Schedule,
        "league2" => $league2Schedule
    ];
}

function getLeagueCupSchedule(array $league1Teams)
{

}