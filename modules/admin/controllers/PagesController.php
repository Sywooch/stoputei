<?php

namespace app\modules\admin\controllers;

use app\models\PageEditForm;
use app\models\Pages;
use yii\web\Controller;
use Yii;

class PagesController extends Controller
{
    public function actionEdit($id)
    {
        $model = new PageEditForm();
        if (is_null($id)) {
            return $this->redirect(['/admin/board/pages']);
        } else {
            $page = Pages::findOne($id);
            $model->title = $page->title;
            $model->body = $page->body;
            if ($model->load(Yii::$app->request->post()) and $model->validate()) {
                $page->title = $model->title;
                $page->body = $model->body;
                if ($page->save()) {
                    Yii::$app->session->setFlash('success', 'page');
                    return $this->redirect(['/admin/board/pages']);
                } else {
                    return $this->render('edit', [
                        'model' => $model,
                        'page' => $page
                    ]);
                }
            } else {
                return $this->render('edit', [
                    'model' => $model,
                    'page' => $page
                ]);
            }
        }
    }
}