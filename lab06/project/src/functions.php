<?php

function getGames(): array
{
    if (!file_exists('data.txt')) {
        return [];
    }

    $json = file_get_contents('data.txt');
    return json_decode($json, true) ?? [];
}

function sortGames(array $games, string $sort): array
{
    usort($games, function ($a, $b) use ($sort) {
        return $a[$sort] <=> $b[$sort];
    });

    return $games;
}