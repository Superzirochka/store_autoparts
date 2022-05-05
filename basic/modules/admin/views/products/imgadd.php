<?php

use mihaildev\ckeditor\CKEditor;


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$this->title = 'Добавить изображение ' . $model->Name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app',  $model->Name), 'url' => ['view?id=' . $model->Id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div>
    <div class="d-flex justify-content-between">

        <h2 class="mt-5 pl-0"><?= Html::encode($this->title) . ' ' . $model->MetaTitle ?></h2>
        <a class="btn mt-5" onclick="javascript:history.back();"><span class="arrow"> </span> Назад</a>
    </div>

    <?php $form = ActiveForm::begin(
        [
            'options' => ['method' => 'POST'],
        ]
    ); ?>
    <div class="d-flex justify-content-around mb-3 col-sm-12">

        <?if (count($moreImg)==0){
echo "<p>Дополнительное изображение отсутствует...</p>";
}?>

        <? foreach ($moreImg as $img):?>
        <div class="col-sm-3">
            <?= Html::img('@web/img/' . $img['Img'], ['alt' => 'Product', 'class' => 'pic', 'width' => 280, 'height' => 180]); ?>
            <?= Html::a(Yii::t('app', 'Удалить'), ['deleteimg', 'img' => $img['Img']], [
                'class' => 'btn btn-danger w-25',
                'data' => [
                    'confirm' => Yii::t('app', 'Вы уверены, что хотите удалить этот товар?'),
                    'method' => 'post',
                ],
            ]) ?>
        </div>
        <? endforeach ?>

    </div>
    <?= $form->field($dopimg, 'fileupload')->fileInput([
        'id' => 'Img1'
    ]); ?>

    <div class="form-group d-flex justify-content-around">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success w-25']) ?>
        <a class="btn btn-primary w-25" onclick="javascript:history.back();">Oтмена</a>
    </div>


    <?php ActiveForm::end();
    ?>

</div>