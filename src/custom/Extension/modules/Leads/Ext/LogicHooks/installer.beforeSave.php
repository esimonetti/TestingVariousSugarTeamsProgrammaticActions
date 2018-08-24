<?php

// file: custom/Extension/modules/Leads/Ext/LogicHooks/installer.beforeSave.php

$hook_array['before_save'][] = array(
    1,
    'Leads before save hook',
    'custom/logichooks/modules/Leads/beforeSaveLeads.php',
    'beforeSaveLeads',
    'callBeforeSave'
);
