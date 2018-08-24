<?php

// file: custom/Extension/modules/Cases/Ext/LogicHooks/installer.afterSave.php

$hook_array['after_save'][] = array(
    1,
    'Cases after save hook',
    'custom/logichooks/modules/Cases/afterSaveCases.php',
    'afterSaveCases',
    'callAfterSave'
);
