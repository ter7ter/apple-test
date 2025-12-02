<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\User;
use yii\console\ExitCode;

/**
 * Manages users.
 */
class UserController extends Controller
{
    /**
     * Creates a new user.
     * @param string $username The username.
     * @param string $password The password.
     */
    public function actionCreate($username, $password)
    {
        $user = new User();
        $user->username = $username;
        $user->email = $username . '@example.com';
        $user->setPassword($password);
        $user->generateAuthKey();
        $user->status = User::STATUS_ACTIVE;

        if ($user->save()) {
            $this->stdout("User '{$username}' created successfully.\n", \yii\helpers\Console::FG_GREEN);
            return ExitCode::OK;
        } else {
            $this->stdout("Error creating user '{$username}'.\n", \yii\helpers\Console::FG_RED);
            foreach ($user->getErrors() as $attribute => $errors) {
                foreach ($errors as $error) {
                    $this->stdout(" - {$attribute}: {$error}\n", \yii\helpers\Console::FG_RED);
                }
            }
            return ExitCode::UNSPECIFIED_ERROR;
        }
    }
}

