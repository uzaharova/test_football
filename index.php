<?php

$teams_data = get_include_contents('data.php');

function match($c1, $c2)
{
    global $teams_data;

    $team_1 = $teams_data[$c1];
    $team_2 = $teams_data[$c2];

    $win_avg_1 = $team_1['goals']['scored'] / $team_1['games'];
    $win_avg_2 = $team_2['goals']['scored'] / $team_2['games'];

    $skip_avg_1 = $team_1['goals']['skiped'] / $team_1['games'];
    $skip_avg_2 = $team_2['goals']['skiped'] / $team_2['games'];

    $success_team_1 = get_team_success($team_1);
    $success_team_2 = get_team_success($team_2);

    $draw_team_1 = get_team_draw($team_1);
    $draw_team_2 = get_team_draw($team_2);

    $power_success_1 = $success_team_1 / $win_avg_1;
    $power_success_2 = $success_team_2 / $win_avg_2;

    $power_defense_1 = $draw_team_1 / $skip_avg_1;
    $power_defense_2 = $draw_team_2 / $skip_avg_2;

    $goal_1 = $power_success_1 * $power_defense_1 * $win_avg_1 * rand(1, 5);
    $goal_2 = $power_success_2 * $power_defense_2 * $win_avg_2 * rand(1, 5);

    return ceil($goal_1) . ' : ' . ceil($goal_2);
}

function get_include_contents($filename) {
    if (is_file($filename)) {
        ob_start();
        $data = include($filename);
        $content = ob_get_clean();

        return is_array($data) ? $data : $content;
    }
    return false;
}

function get_team_success($team)
{
    return $team['win'] / ($team['draw'] + $team['defeat']);
}

function get_team_draw($team)
{
    return $team['draw'] / ($team['win'] + $team['defeat']);
}