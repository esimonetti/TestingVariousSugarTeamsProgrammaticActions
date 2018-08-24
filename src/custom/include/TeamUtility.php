<?php

class TeamUtility
{
    public static $first_team_name = 'First Group';
    public static $second_team_name = 'Second Group';

    public static function getTeamToAdd($team_name)
    {
        $sugarQuery = new SugarQuery();
        $sugarQuery->from(BeanFactory::newBean('Teams'));
        $sugarQuery->select(array('id'));
        $sugarQuery->where()->equals('name', $team_name);
        $sugarQuery->limit(1);
        $records = $sugarQuery->execute();

        if (!empty($records) && !empty($records[0]['id'])) {
            return $records[0]['id'];
        }

        return false;
    }

    public static function getTeamsFromTeamset($teamset)
    {
        $teamSetBean = new TeamSet();
        return $teamSetBean->getTeamIds($teamset);
    }

    public static function printFinalTeamInfo($module, $id)
    {
        $GLOBALS['log']->fatal(__METHOD__ . ' now verifying the record, by re-retrievinig the bean');
        $retrieved_bean = BeanFactory::getBean($module, $id);
        $retrieved_bean->load_relationship('teams');
        $GLOBALS['log']->fatal(__METHOD__ . ' printing saved list of teams on the bean: '.print_r($retrieved_bean->teams->_teamList, true));
    
        $GLOBALS['log']->fatal(__METHOD__ . ' now verifying the record, by looking at the database directly');
        $builder = DBManagerFactory::getInstance()->getConnection()->createQueryBuilder();
        $builder->select(array('id', 'team_set_id'))->from($retrieved_bean->table_name);
        $builder->where('id = ' . $builder->createPositionalParameter($id));
        $res = $builder->execute();
        $row = $res->fetch();
        $teams = TeamUtility::getTeamsFromTeamset($row['team_set_id']);
        $GLOBALS['log']->fatal(__METHOD__ . ' printing teamset from database: '.print_r($teams, true));
    }
}
