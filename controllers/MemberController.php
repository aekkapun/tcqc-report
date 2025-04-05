<?php

namespace app\controllers;

use Yii;
use app\models\UserReq;
use app\models\UserReqSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * MemberController implements the CRUD actions for UserReq model.
 */
class MemberController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulkdelete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all UserReq models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new UserReqSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single UserReq model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax)
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "UserReq #".$id,
                'content' =>$this->renderAjax('view', [
                    'model' => $this->findModel($id),
                ]),
                'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => 'modal']).
                    Html::a(Yii::t('yii2-ajaxcrud', 'Update'), ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
            ];
        }
        else
        {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new UserReq model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new UserReq();  

        if($request->isAjax)
        {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet)
            {
                return [
                    'title' => Yii::t('yii2-ajaxcrud', 'Create New')." UserReq",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => 'modal']).
                        Html::button(Yii::t('yii2-ajaxcrud', 'Create'), ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            }
            else if($model->load($request->post()) && $model->save())
            {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => Yii::t('yii2-ajaxcrud', 'Create New')." UserReq",
                    'content' => '<span class="text-success">'.Yii::t('yii2-ajaxcrud', 'Create').' UserReq '.Yii::t('yii2-ajaxcrud', 'Success').'</span>',
                    'footer' =>  Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => 'modal']).
                        Html::a(Yii::t('yii2-ajaxcrud', 'Create More'), ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            }
            else
            {
                return [
                    'title' => Yii::t('yii2-ajaxcrud', 'Create New')." UserReq",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => 'modal']).
                        Html::button(Yii::t('yii2-ajaxcrud', 'Save'), ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            }
        }
        else
        {
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save())
            {
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else
            {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing UserReq model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
{
    $request = Yii::$app->request;
    $model = $this->findModel($id);

    if ($request->isAjax) {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($request->isGet) {
            return [
                'title' => Yii::t('yii2-ajaxcrud', 'Update') . " UserReq #" . $id,
                'content' => $this->renderAjax('update', ['model' => $model]),
                'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), [
                        'class' => 'btn btn-default pull-left',
                        'data-bs-dismiss' => 'modal'
                    ]) .
                    Html::button(Yii::t('yii2-ajaxcrud', 'Save'), [
                        'class' => 'btn btn-primary',
                        'type' => 'submit'
                    ])
            ];
        } elseif ($model->load($request->post())) {

            // ตรวจสอบและแฮชรหัสผ่านหากมีการอัปเดตค่าใหม่
            if (!empty($model->password_hash) && $model->isAttributeChanged('password_hash')) {
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password_hash);
            } else {
                // หากไม่มีการเปลี่ยนแปลงค่ารหัสผ่าน ให้ใช้ค่าดั้งเดิม
                $model->password_hash = $model->getOldAttribute('password_hash');
            }

            // กำหนดค่า password_reset_token เป็น username
            $model->password_reset_token = $model->username;

            if ($model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "UserReq #" . $id,
                    'content' => $this->renderAjax('view', ['model' => $model]),
                    'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), [
                            'class' => 'btn btn-default pull-left',
                            'data-bs-dismiss' => 'modal'
                        ]) .
                        Html::a(Yii::t('yii2-ajaxcrud', 'Update'), ['update', 'id' => $id], [
                            'class' => 'btn btn-primary',
                            'role' => 'modal-remote'
                        ])
                ];
            } else {
                return [
                    'title' => Yii::t('yii2-ajaxcrud', 'Update') . " UserReq #" . $id,
                    'content' => $this->renderAjax('update', ['model' => $model]),
                    'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), [
                            'class' => 'btn btn-default pull-left',
                            'data-bs-dismiss' => 'modal'
                        ]) .
                        Html::button(Yii::t('yii2-ajaxcrud', 'Save'), [
                            'class' => 'btn btn-primary',
                            'type' => 'submit'
                        ])
                ];
            }
        }
    } else {
        if ($model->load($request->post())) {

            // ตรวจสอบและแฮชรหัสผ่านหากมีการเปลี่ยนแปลงค่า
            if (!empty($model->password_hash) && $model->isAttributeChanged('password_hash')) {
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password_hash);
            } else {
                $model->password_hash = $model->getOldAttribute('password_hash');
            }

            // กำหนดค่า password_reset_token เป็น username
            $model->password_reset_token = $model->username;

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', ['model' => $model]);
    }
}


    /**
     * Delete an existing UserReq model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax)
        {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }
        else
        {
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }

     /**
     * Delete multiple existing UserReq model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkdelete()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk )
        {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if($request->isAjax)
        {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }
        else
        {
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the UserReq model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserReq the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserReq::findOne($id)) !== null)
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
