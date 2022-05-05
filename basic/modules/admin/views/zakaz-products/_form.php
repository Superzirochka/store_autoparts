<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\models\Kurs;
use app\modules\admin\models\Supplier;

$currentKurs = Kurs::find()->where(['Id' => 1])->one();
$session = Yii::$app->session;
$session->open();
if ($session->has('kurs')) {
    $kurs = $session->get('kurs');
} else {
    $session->set('kurs', ['kurs' => $currentKurs->Current_kurs]);
}
/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\ZakazProducts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zakaz-products-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-row">
        <div class="col-md-4 mb-4">

            <?= $form->field($model, 'Supplier')->dropdownList(
                Supplier::find()->select(['Supplier', 'Id'])->indexBy('Id')->orderBy('Supplier ASC')->column()
            ) ?>

        </div>
        <div class="col-md-4 mb-4">
            <?= $form->field($model, 'Brand')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4 mb-4">
            <?= $form->field($model, 'ProductName')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <?= $form->field($model, 'Description')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'TermsDelive')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'Img')->textInput(['maxlength' => true]) ?>
    <div class="form-row">
        <p class="text-right text-warning ml-5">Текущий курс: 1 у.е = <input id='kurs' type="text" value="<?= $kurs['kurs'] ?>" readonly='true'>
            грн</p>
    </div>

    <div class="form-row">

        <div class="col-md-4 mb-4">
            <?= $form->field($model, 'EntryPrice')->textInput(['maxlength' => true, 'id' => 'EntryPrice']) ?>
        </div>
        <div class="col-md-4 mb-4">
            <?= $form->field($model, 'Markup')->textInput([
                'maxlength' => true,
                'id' => 'Markup',
                'value' => !empty($model->Markup) ? $model->Markup : 50
            ]) ?>
        </div>
        <div class="col-md-4 mb-4">

            <p class="mt-5 ml-5">Цена <span id='Price' class="text-danger  -light ml-2"><?= $model->Price ?></span> грн</p>


        </div>
    </div>



    <?= $form->field($model, 'Count')->textInput() ?>

    <div class="form-group d-flex justify-content-around">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success w-25']) ?>
        <a class="btn btn-primary w-25" onclick="javascript:history.back();">Oтмена</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    Markup.oninput = function() {
        // console.log(Markup.value)
        Price.innerHTML = (1 + Markup.value / 100) * kurs.value * EntryPrice.value;
    };
    // console.log(Price.value)
    EntryPrice.oninput = function() {
        // console.log(Markup.value)
        Price.innerHTML = (1 + Markup.value / 100) * kurs.value * EntryPrice.value;
    };
</script>