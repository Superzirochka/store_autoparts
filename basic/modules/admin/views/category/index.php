<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Категории');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">
    <div class="d-flex justify-content-between">

        <h1><?= Html::encode($this->title) ?></h1>

        <p class="mt-5">
            <?= Html::a(Yii::t('app', 'Создать категорию'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    </div>

    <? //=// GridView::widget([
    //     'dataProvider' => $dataProvider,
    //     'columns' => [
    //         ['class' => 'yii\grid\SerialColumn'],

    //         //'Id',
    //         // 'Id_lang',
    //         'Name',
    //         'Description',
    //         //  'MetaDescription',
    //         //   'MetaTitle',
    //         //   'MetaKeyword',
    //         //   'Img',
    //         //   'Id_parentCategory',
    //         //  'id_node',

    //         ['class' => 'yii\grid\ActionColumn'],
    //     ],
    // ]); 
    ?>

    <table class="table table-striped table-bordered text-white">
        <thead>
            <tr>
                <th>Номер категории</th>
                <th>Наименование</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category['Id'] => $category['Name']) : ?>
                <? if ($category['Id'] == 0 || $category['Id'] == null) {

                    continue;
                } ?>
                <tr>
                    <td>
                        <?= $category['Id'] ?>
                    </td>
                    <td><?= $category['Name']; ?></td>

                    <td class="d-flex justify-content-around">



                        <?= Html::a(
                            '<span class="glyphicon glyphicon-list"></span>',
                            ['/admin/category/products', 'id' => $category['Id']],
                            ['title' => 'Товары категории']
                        );
                        ?>
                        <?=
                        Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            ['/admin/category/view', 'id' => $category['Id']],
                            ['title' => 'Просмотр']
                        );
                        ?>
                        <?=
                        Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            ['/admin/category/update', 'id' => $category['Id']],
                            ['title' => 'Редактировать']
                        );
                        ?>
                        <?=
                        Html::a(
                            '<span class="glyphicon glyphicon-trash"></span>',
                            ['/admin/category/delete', 'id' => $category['Id']],
                            [
                                'data-confirm' => 'Вы уверены, что хотите удалить эту категорию?',
                                'data-method' => 'post',
                                'title' => 'Удалить'
                            ]
                        );
                        ?>

                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>