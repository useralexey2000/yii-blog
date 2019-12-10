<?php

namespace app\rbac;
use yii\rbac\Rule;

class PostOwnerRule extends Rule
{
    public $name = 'isOwner';

    public function execute($user, $item, $params)
    {

        error_log('user_id is: '.$params['user_id']);
        
        return isset($params['user_id']) ? $params['user_id'] == $user : false;
    }
}

?>