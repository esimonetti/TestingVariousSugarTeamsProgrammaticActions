<?php

// file: custom/logichooks/modules/Leads/afterSaveLeads.php

require_once('custom/include/TeamUtility.php');

class afterSaveLeads
{
    public function callAfterSave($bean, $event, $arguments)
    {   
        $GLOBALS['log']->fatal(__METHOD__ . ' for id '.$bean->id);
        $GLOBALS['log']->fatal(__METHOD__ . ' with team_set_id '.$bean->team_set_id);
        
        $team = TeamUtility::getTeamToAdd(TeamUtility::$second_team_name);

        if (!empty($team)) {
            $teams = TeamUtility::getTeamsFromTeamset($bean->team_set_id);

            $GLOBALS['log']->fatal(__METHOD__ . ' list of teams before the custom logic: '.print_r($teams, true));
            $GLOBALS['log']->fatal(__METHOD__ . ' replacing with team '.$team);

            $bean->load_relationship('teams');

            $bean->teams->replace(
                array(
                    $team
                )
            );

            $GLOBALS['log']->fatal(__METHOD__ . ' team_set_id after replacing with new team '.$bean->team_set_id);
            $GLOBALS['log']->fatal(__METHOD__ . ' printing what should be the final list of teams: '.print_r($bean->teams->_teamList, true));

            TeamUtility::printFinalTeamInfo('Leads', $bean->id);
        }
    }
}
