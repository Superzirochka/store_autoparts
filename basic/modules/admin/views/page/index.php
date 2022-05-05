<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Страницы');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Добавить страницу'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Наименование</th>
                <th>Мета-тег keywords</th>
                <th>Мета-тег description</th>
                <th colspan="3"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pages as $page) : ?>
                <tr>
                    <td><?= $page['Name']; ?></td>
                    <td><?= $page['Name_ua']; ?></td>
                    <td><?= $page['Description']; ?></td>
                    <td colspan="3">
                        <?=
                            Html::a(
                                '<span class="glyphicon glyphicon-eye-open"></span>',
                                ['/admin/page/view', 'id' => $page['Id']],
                                ['title' => 'просмотр']
                            );
                        ?>

                        <?=
                            Html::a(
                                '<span class="glyphicon glyphicon-pencil"></span>',
                                ['/admin/page/update', 'id' => $page['Id']],
                                ['title' => "редактировать"]
                            );
                        ?>

                        <?=
                            Html::a(
                                '<span class="glyphicon glyphicon-trash"></span>',
                                ['/admin/page/delete', 'id' => $page['Id'],],
                                [
                                    'data-confirm' => 'Вы уверены, что хотите удалить эту страницу?',
                                    'data-method' => 'post',
                                    'title' => "удаление"
                                ]
                            );
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?//= GridView::widget([
    //     'dataProvider' => $dataProvider,
    //     'columns' => [
    //         ['class' => 'yii\grid\SerialColumn'],

    //         //'Id',
    //         // 'parent_id',
    //         [
    //             'attribute' => 'parent_id',
    //             'value' => function ($data) {
    //                 $parent = $data->getParentName();
    //                 return empty($parent) ? 'Без родителя' : $parent;
    //             }
    //         ],
    //         'Name',
    //         'Name_ua',
    //         // 'Slug',
    //         //'Content:ntext',
    //         //'Content_ua:ntext',
    //         //'Keywords',
    //         //'Keywords_ua',
    //         //'Description',
    //         //'Description_ua',

    //         ['class' => 'yii\grid\ActionColumn'],
    //     ],
    // ]); ?>


</div>