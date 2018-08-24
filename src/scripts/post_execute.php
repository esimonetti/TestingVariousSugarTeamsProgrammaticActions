<?php

require_once('custom/include/TeamUtility.php');

class TestingTeamsManipulation
{
    public static function populateTeam($team_name)
    {
        $sugarQuery = new SugarQuery();
        $sugarQuery->from(BeanFactory::newBean('Teams'));
        $sugarQuery->select(array('id'));
        $sugarQuery->where()->equals('name', $team_name);
        $sugarQuery->limit(1);
        $records = $sugarQuery->execute();

        if (empty($records))
        {
            $team = BeanFactory::newBean('Teams');
            $team->name = $team_name;
            $id = $team->save();
            echo 'Team ' . $team_name . ' created, please add the correct users to it'.PHP_EOL;
        } else {
            echo 'Team ' . $team_name . ' detected, skipping'.PHP_EOL;
        }
    }
}


TestingTeamsManipulation::populateTeam(TeamUtility::$first_team_name);
TestingTeamsManipulation::populateTeam(TeamUtility::$second_team_name);
