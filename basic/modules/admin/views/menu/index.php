<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Меню');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Новый пункт'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <!-- <?//= GridView::widget([
                // 'dataProvider' => $dataProvider,
                // 'columns' => [
                //     ['class' => 'yii\grid\SerialColumn'],
                //     [
                //         'attribute' => 'Id_parentMenu',
                //         'value' => function ($data) {
                //             $parent = $data->getParentName();
                //             return empty($parent) ? 'Без родителя' : $parent;
                //         }
                //     ],
                //     // 'Id',
                //     'NameMenu',
                //     'NameMenu_ua',
                //     'Title',
                //     'Title_ua',
                //     //'Link',
                //     //'Sort',
                //     //'Content',
                //     //'Id_lang',
                //     //'Id_parentMenu',

                //     ['class' => 'yii\grid\ActionColumn'],
                // ],
            //]); ?> -->

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Название</th>
                <th>Назва </th>

                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pages as $page) : ?>
                <tr>
                    <td><?= $page['NameMenu']; ?></td>
                    <td><?= $page['NameMenu_ua']; ?></td>
                    <td>
                        <?=
                            Html::a(
                                '<span class="glyphicon glyphicon-eye-open"></span>',
                                ['/admin/menu/view', 'id' => $page['Id']]
                            );
                        ?>

                        <?=
                            Html::a(
                                '<span class="glyphicon glyphicon-pencil"></span>',
                                ['/admin/menu/update', 'id' => $page['Id']]
                            );
                        ?>

                        <?=
                            Html::a(
                                '<span class="glyphicon glyphicon-trash"></span>',
                                ['/admin/menu/delete', 'id' => $page['Id']],
                                [
                                    'data-confirm' => 'Вы уверены, что хотите удалить эту страницу?',
                                    'data-method' => 'post'
                                ]
                            );
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


</div>