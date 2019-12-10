<?php
namespace app\modules\admin\controllers;
use Yii;
use yii\data\ActiveDataProvider;
use app\models\User;
use app\models\AuthItem;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

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
            //  'access' => [
            //     'class' => AccessControl::className(),
            //     'only' => ['create', 'update', 'delete'],
            //     'denyCallback' => function ($rule, $action) {
            //         throw new ForbiddenHttpException('You are not allowed to access this page');
            //     },
            //     'rules' => [
            //         [
            //             'allow' => true,
            //             'actions' => ['create'],
            //             'roles' => ['createPost'],
            //         ],
            //         [
            //            'allow' => true,
            //            'actions' => ['delete'],
            //            'roles' => ['deletePost'],
            //            'roleParams' =>[
            //                //'post_id'=>Yii::$app->request->get('post_id'),
            //                'owner_id'=>Yii::$app->request->get('owner_id'),
            //            ],
            //         ],
            //         [
            //             'allow' => true,
            //             'actions' => ['update'],
            //             'roles' => ['updatePost'],
            //         ],
            //         [
            //            'allow' => true,
            //            'actions' => ['view'],
            //            'roles' => ['viewPost'],
            //         ],

            //     ],
            // ],
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

    // public function actionView($id)
    // {
    //     return $this->render('view', [
    //         'model' => $this->findModel($id),
    //     ]);
    // }

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
        
        //$authorRole = AuthItem::findOne('author');
        //$user->link($authorRole);
        //$user->save();
        //$auth->revoke($authorRole, $id);//die;
        //$auth->assign($authorRole, $id);
        //$uRoles = $user->roles;var_dump($uRoles);die;
        //$newRoles = ['admin'];//var_dump($newRoles);die;
        //$auth = Yii::$app->authManager;
        //$oldRoles = $auth->getRolesByUser($id);


        // $user = Yii::$app->db->createCommand('SELECT * FROM user WHERE id=:id')
        //    ->bindValue(':id', $id)
        //    ->queryOne();
        //    var_dump($user);die;

    }
}
