<?php
namespace app\modules\admin\controllers;
use Yii;
use yii\data\ActiveDataProvider;
use app\models\User;
use app\models\AuthItem;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

class UsersController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
               'class' => VerbFilter::className(),
               'actions' => [
                   'delete' => ['POST'],
               ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete',],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],

         ];
    }


    public function actionIndex()
    {
        $users = new ActiveDataProvider([
            'query' => User::find()->orderBy('id ASC'),
            'pagination' => [
                'pageSize' =>20
            ],
        ]);

        return $this->render('index', ['users' =>$users,]);
    }
    
    public function actionCreate()
    {
        $model = new User();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //TODO add roles to user//
            $oldRoles = $model->getRoles();
            $request = Yii::$app->request;
            $newRoles = $request->post('User')['roles'];
            //TODO implement compare
            $auth = Yii::$app->authManager;
            if(1){
                $auth->revokeAll($model->getId());
                foreach ($newRoles as $roleName) {
                    $role = $auth->getRole($roleName);
                    $auth->assign($role, $model->getId());
                }
            }

            return $this->redirect(['view', 'id' => $model->id]);

        }
        return $this->render('update', [
            'model'=> $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }


    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionView($id){
        $user = $this->findModel($id);
        return $this->render('view', [
            'model' => $user,
        ]);
        
    }
}
