<?php

// file: custom/Extension/modules/Leads/Ext/LogicHooks/installer.afterSave.php

$hook_array['after_save'][] = array(
    1,
    'Leads after save hook',
    'custom/logichooks/modules/Leads/afterSaveLeads.php',
    'afterSaveLeads',
    'callAfterSave'
);
