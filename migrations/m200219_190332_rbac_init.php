<?php

use yii\db\Migration;

/**
 * Class m200219_160332_rbac_init
 */
class m200219_190332_rbac_init extends Migration
{
    public function up()
    {
        $auth = Yii::$app->authManager;

        // add "booking" permission
        $booking = $auth->createPermission('booking');
        $booking->description = 'Booking';
        $auth->add($booking);

        // add "manageUser" permission
        $manageUser = $auth->createPermission('manageUser');
        $manageUser->description = 'manage user';
        $auth->add($manageUser);

        $manageBank = $auth->createPermission('manageBank');
        $manageUser->description = 'Bank Manager';
        $auth->add($manageBank);

        $manageDiet = $auth->createPermission('manageDiet');
        $manageDiet->description = 'Diet Manager';
        $auth->add($manageDiet);

        // add "author" role and give this role the "booking" permission
        $customer = $auth->createRole('customer');
        $auth->add($customer);
        $auth->addChild($customer, $booking);

        $employee = $auth->createRole('employee');
        $auth->add($employee);
        $auth->addChild($employee, $manageBank);
        $auth->addChild($employee, $customer);

        // add "admin" role and give this role the "manageUser" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $manageUser);
        $auth->addChild($admin, $manageDiet);
        $auth->addChild($admin, $customer);
        $auth->addChild($admin, $employee);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($admin, 1);

    }
    
    public function down()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();
    }
}
