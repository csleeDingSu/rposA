<?php

return array(

    /*
    |----------------------------------------------------------------------
    | Auto backup mode
    |----------------------------------------------------------------------
    |
    | This value is used when you save your file content. If value is true,
    | the original file will be backed up before save.
    */

    'autoBackup' => true,

    /*
    |----------------------------------------------------------------------
    | Backup location
    |----------------------------------------------------------------------
    |
    | This value is used when you backup your file. This value is the sub
    | path from root folder of project application.
    */

    'backupPath' => base_path('storage/dotenv-editor/backups/'),
	
	'protected_key' => ['APP_NAME','APP_ENV','APP_KEY','APP_DEBUG','APP_URL','APP_PORT','DB_CONNECTION','DB_HOST','DB_PORT','DB_DATABASE','DB_USERNAME','DB_PASSWORD','BROADCAST_DRIVER','CACHE_DRIVER','SESSION_DRIVER','SESSION_LIFETIME','QUEUE_DRIVER','REDIS_HOST','REDIS_PASSWORD','REDIS_PORT','REDIS_CLI_PORT','JWT_BLACKLIST_ENABLED','JWT_SECRET','weixinurl','weixinid','weixinsecret'],
	
);
