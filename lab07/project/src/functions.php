<?php

function getGames(): array
{
    if (!file_exists('data.json')) {
        return [];
    }

    return json_decode(file_get_contents('data.json'), true) ?? [];
}

function saveGame(array $game): void
{
    $games = getGames();
    $games[] = $game;

    file_put_contents('data.json', json_encode($games, JSON_PRETTY_PRINT));
}