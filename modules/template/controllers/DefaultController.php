<?php

namespace app\modules\template\controllers;

use yii\web\Controller;

/**
 * Default controller for the `template` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
