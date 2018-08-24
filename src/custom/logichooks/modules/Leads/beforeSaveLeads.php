<?php

// file: custom/logichooks/modules/Leads/beforeSaveLeads.php

require_once('custom/include/TeamUtility.php');

class beforeSaveLeads
{
    public function callBeforeSave($bean, $event, $arguments)
    {   
        $team = TeamUtility::getTeamToAdd(TeamUtility::$second_team_name);
        // set primary team on before save
        $bean->team_id = $team;
    }
}
