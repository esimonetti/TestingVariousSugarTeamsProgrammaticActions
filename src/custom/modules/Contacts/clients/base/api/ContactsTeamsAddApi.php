<?php

require_once('custom/include/TeamUtility.php');

class ContactsTeamsAddApi extends ContactsApi
{
    public function registerApiRest()
    {
        return array(
            'create' => array(
                'reqType' => 'POST',
                'path' => array('Contacts'),
                'pathVars' => array('module'),
                'method' => 'createRecord',
                'shortHelp' => 'This method creates a new record of the specified type',
                'longHelp' => 'include/api/help/module_post_help.html',
            ),
            'update' => array(
                'reqType' => 'PUT',
                'path' => array('Contacts','?'),
                'pathVars' => array('module','record'),
                'method' => 'updateRecord',
                'shortHelp' => 'This method updates a record of the specified type',
                'longHelp' => 'include/api/help/module_record_put_help.html',
            ),
        );
    }

    protected function manipulateTeams($module, $id)
    {
        if (!empty($id)) {
            $team = TeamUtility::getTeamToAdd(TeamUtility::$first_team_name);

            $bean = BeanFactory::retrieveBean($module, $id);
            if (!empty($bean->id)) {
                $GLOBALS['log']->fatal('Loaded '.$module.' '.$bean->id);

                $teams = TeamUtility::getTeamsFromTeamset($bean->team_set_id);
                $bean->load_relationship('teams');

                $GLOBALS['log']->fatal(__METHOD__ . ' list of teams before the custom logic: '.print_r($teams, true));
                $GLOBALS['log']->fatal(__METHOD__ . ' adding team '.$team);

                $bean->teams->add(
                    array(
                        $team
                    )
                );

                $GLOBALS['log']->fatal(__METHOD__ . ' team_set_id after adding new team '.$bean->team_set_id);
                $GLOBALS['log']->fatal(__METHOD__ . ' printing what should be the final list of teams: '.print_r($bean->teams->_teamList, true));
                
                TeamUtility::printFinalTeamInfo($module, $id);
            }
        }
    }

    protected function updateBean(SugarBean $bean, ServiceBase $api, array $args)
    {
        $id = parent::updateBean($bean, $api, $args);
        $GLOBALS['log']->fatal(__METHOD__ . ' for id '.$bean->id);
        $GLOBALS['log']->fatal(__METHOD__ . ' with team_set_id '.$bean->team_set_id);
 
        $this->manipulateTeams('Contacts', $id);

        return $id;
    }

    public function createBean(ServiceBase $api, array $args, array $additionalProperties = array())
    {
        $parentReturn = parent::createBean($api, $args, $additionalProperties);
        $GLOBALS['log']->fatal(__METHOD__ . ' ' . $parentReturn->id);   
        $this->manipulateTeams('Contacts', $parentReturn->id);

        return $parentReturn;
    }
}
