<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\MailContact;
use app\modules\admin\models\Answer;
use yii\data\ActiveDataProvider;
use app\modules\admin\controllers\AdminController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MailContactController implements the CRUD actions for MailContact model.
 */
class MailcontactController extends AdminController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all MailContact models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => MailContact::find(),
            'sort' => [
                'defaultOrder' => [
                    // сортировка по статусу, по возрастанию
                    'Status' => SORT_DESC,
                    'DateAdd' => SORT_DESC,
                    //ASC
                ]
            ]
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MailContact model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Answer::find()->select('Id, IdMailContakt, Title, Text, DateAnswer')->where(['IdMailContakt' => $id])
        ]);
        //$answer = Answer::find()->select('Id, IdMailContakt, Title, Text, DateAnswer')->where(['IdMailContakt' => $id])->orderBy('DateAdd DESC')->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Creates a new MailContact model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MailContact();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->Id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MailContact model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $answer = new Answer();

        $today = date("Y-m-d H:i:s");
        $answer->IdMailContakt = $model->Id;
        $answer->DateAnswer = $today;
        $email = $model->Email;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->Id]);
        }
        if ($answer->load(Yii::$app->request->post()) && $answer->save()) {
            // отправляем письмо на почту 
            $textBody = 'Имя: ' . strip_tags($model->FIO) . PHP_EOL;
            $textBody .= 'Почта: ' . strip_tags($email) . PHP_EOL . PHP_EOL;
            $textBody .= 'Сообщение: ' . PHP_EOL . strip_tags($email);

            $htmlBody = '<p><b>Имя</b>: ' . strip_tags($model->FIO) . '</p>';
            $htmlBody .= '<p><b>Почта</b>: ' . strip_tags($email) . '</p>';
            $htmlBody .= '<p><b>Сообщение</b>:</p>';
            $htmlBody .= '<p>' . nl2br(strip_tags($answer->Text)) . '</p>';

            $mail = Yii::$app->mailer->compose(
                'feedback', // шаблон находиься в папке basic/mail
                [
                    'name' => strip_tags($model->FIO),
                    'email' => strip_tags($email),
                    'body' => strip_tags($answer->Text)
                ]
            );
            $mail->setFrom(Yii::$app->params['senderEmail'])
                ->setTo($email)
                ->setSubject('Заполнена форма обратной связи')
                ->send();
            return $this->redirect(['view', 'id' => $answer->IdMailContakt]);
        }

        return $this->render('update', [
            'model' => $model,
            'answer' => $answer
        ]);
    }

    /**
     * Deletes an existing MailContact model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();
        \Yii::$app
            ->db
            ->createCommand()
            ->update('mail_contact', ['Status' => 'delete'], 'Id=' . $id)
            ->execute();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MailContact model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MailContact the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MailContact::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'Данная страницам не найдена.'));
    }
}
