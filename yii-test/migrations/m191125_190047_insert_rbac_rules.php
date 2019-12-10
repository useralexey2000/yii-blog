<?php

use yii\db\Migration;

/**
 * Class m191125_190047_insert_rbac_rules
 */
class m191125_190047_insert_rbac_rules extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //Yii::$app->authManager;

        $auth = Yii::$app->authManager;
        //permissions:
        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'create post';
        $auth->add($createPost);

        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'update post';
        $auth->add($updatePost);

        $deletePost = $auth->createPermission('deletePost');
        $deletePost->description = 'delete post';
        $auth->add($deletePost);
        
        //roles:
        $author = $auth->createRole('author');
        $auth->add($author);
        $auth->addChild($author, $createPost);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $updatePost);
        $auth->addChild($admin, $deletePost);
        $auth->addChild($admin, $author);

        //rules:
        $postOwnerRule = new \app\rbac\PostOwnerRule;
        $auth->add($postOwnerRule);
        $updateOwnPost = $auth->createPermission('updateOwnPost');
        $updateOwnPost->ruleName = $postOwnerRule->name;
        $auth->add($updateOwnPost);

        $deleteOwnPost = $auth->createPermission('deleteOwnPost');
        $deleteOwnPost->ruleName = $postOwnerRule->name;
        $auth->add($deleteOwnPost);

        $auth->addChild($updateOwnPost, $updatePost);
        $auth->addChild($author, $updateOwnPost);

        $auth->addChild($deleteOwnPost, $deletePost);
        $auth->addChild($author, $deleteOwnPost);

        // /$deleteOwnPost = $auth->createPermission();

        //assign role admin:
        $auth->assign($admin, 1);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
    }
}