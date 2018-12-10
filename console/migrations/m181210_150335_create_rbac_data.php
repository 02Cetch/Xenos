<?php

use yii\db\Migration;
use backend\models\User;

/**
 * Class m181210_150335_create_rbac_data
 */
class m181210_150335_create_rbac_data extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;
        // Define permissions

        // user
        $viewUserReportsListPermission = $auth->createPermission('viewUserReportsListPermission');
        $auth->add($viewUserReportsListPermission);

        $viewUserReportsPermission = $auth->createPermission('viewUserReportsPermission');
        $auth->add($viewUserReportsPermission);

        $deleteUserReportsListPermission = $auth->createPermission('deleteUserReportsListPermission');
        $auth->add($deleteUserReportsListPermission);

        $approveUserReportsListPermission = $auth->createPermission('approveUserReportsListPermission');
        $auth->add($approveUserReportsListPermission);
        // end user

        // resume
        $viewResumeReportsListPermission = $auth->createPermission('viewResumeReportsListPermission');
        $auth->add($viewResumeReportsListPermission);

        $viewResumeReportsPermission = $auth->createPermission('viewResumeReportsPermission');
        $auth->add($viewResumeReportsPermission);

        $deleteResumeReportsListPermission = $auth->createPermission('deleteResumeReportsListPermission');
        $auth->add($deleteResumeReportsListPermission);

        $approveResumeReportsListPermission = $auth->createPermission('approveResumeReportsListPermission');
        $auth->add($approveResumeReportsListPermission);
        // end resume

        // vacancy
        $viewVacancyReportsListPermission = $auth->createPermission('viewVacancyReportsListPermission');
        $auth->add($viewVacancyReportsListPermission);

        $viewVacancyReportsPermission = $auth->createPermission('viewVacancyReportsPermission');
        $auth->add($viewVacancyReportsPermission);

        $deleteVacancyReportsListPermission = $auth->createPermission('deleteVacancyReportsListPermission');
        $auth->add($deleteVacancyReportsListPermission);

        $approveVacancyReportsListPermission = $auth->createPermission('approveVacancyReportsListPermission');
        $auth->add($approveVacancyReportsListPermission);
        // end vacancy

        // Define roles with permissions

        // MODERATOR
        $moderatorRole = $auth->createRole('moderator');
        $auth->add($moderatorRole);

        // user permissions
        $auth->addChild($moderatorRole, $viewUserReportsListPermission);

        // resume permissions
        $auth->addChild($moderatorRole, $viewResumeReportsListPermission);
        $auth->addChild($moderatorRole, $deleteResumeReportsListPermission);
        $auth->addChild($moderatorRole, $approveResumeReportsListPermission);

        // vacancy permissions
        $auth->addChild($moderatorRole, $viewVacancyReportsListPermission);
        $auth->addChild($moderatorRole, $deleteVacancyReportsListPermission);
        $auth->addChild($moderatorRole, $approveVacancyReportsListPermission);

        // END MODERATOR

        // ADMIN

        $adminRole = $auth->createRole('admin');
        $auth->add($adminRole);

        $auth->addChild($adminRole, $moderatorRole);
        // user permissions
        $auth->addChild($adminRole, $deleteUserReportsListPermission);
        $auth->addChild($adminRole, $approveUserReportsListPermission);


        // END ADMIN


        // Create admin user
        // Расчитывается, что после создания суперпользователя пароль будет изменен (или права админа переданы другому пользователю).
        $user = new User([
            'email' => 'admin@admin.com',
            'username' => 'Admin',
            'password_hash' => '$2y$13$P9.d7KUb8C6BHCvkdzMsrOi5U.vIAw01UmriB.34PiN50e8nTGFge', // 111111
            'account_type' => User::returnUserAccountType(),
            'created_at' => $time = time(),
            'updated_at' => $time,
        ]);
        $user->generateAuthKey();
        $user->save();
        // Assign admin role to
        $auth->assign($adminRole, $user->getId());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181210_150335_create_rbac_data cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181210_150335_create_rbac_data cannot be reverted.\n";

        return false;
    }
    */
}
