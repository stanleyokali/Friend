<?php

namespace app\controllers;
use Yii;
use app\models\Users;
use app\models\LoginForm;

class UsersController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionRegister()
    {
        $user = new Users();

        if ($user->load(Yii::$app->request->post())) {
            if ($user->validate()) {
                // Save Record
                $user->save();
                //send message
                yii::$app->getSession()->setFlash('success', 'You are Registered');

                return $this->redirect(array('login'));
            }
        }

        return $this->render('register', [
            'user' => $user,
        ]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //return $this->goBack();
            return $this->redirect(array(''));
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    

}
