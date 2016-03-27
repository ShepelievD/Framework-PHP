<?php
/**
 * Map of events:
 * event name => class[delimiter]method
 * [delimiter] = @
 */
    return array(
        'app.init' => 'Framework\\Event\\Listeners\\AppEvent@init',
        'db.closeDB' => 'Framework\\Event\\Listeners\\DataBaseEvent@closeDB',
        'db.setUTF8' => 'Framework\\Event\\Listeners\\DataBaseEvent@setUTF8',
    );
    
