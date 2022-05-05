<?php //addgruop
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::t('app', 'Добавить группу');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Покупатели'), 'url' => ['index']];

$this->params['breadcrumbs'][] = Yii::t('app', 'Добавить');
?>

<div class="customers-form">

    <?php $form = ActiveForm::begin(); ?>



    <?= $form->field($model, 'Name')->textInput() ?>

    <div class="form-group d-flex justify-content-around">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success w-25']) ?>
        <a class="btn btn-primary w-25" onclick="javascript:history.back();">Oтмена</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>