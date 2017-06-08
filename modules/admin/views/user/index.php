<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii2mod\editable\EditableColumn;
use yii2mod\user\models\enums\UserStatus;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \app\modules\admin\models\search\UserSearch */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <p>
        <?php echo Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(['timeout' => 10000]); ?>
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'class' => EditableColumn::class,
                'attribute' => 'username',
                'url' => ['edit-user'],
            ],
            'email:email',
            [
                'class' => EditableColumn::class,
                'attribute' => 'status',
                'url' => ['edit-user'],
                'value' => function ($model) {
                    return UserStatus::getLabel($model->status);
                },
                'type' => 'select',
                'editableOptions' => function ($model) {
                    return [
                        'source' => UserStatus::listData(),
                        'value' => $model->status,
                    ];
                },
                'filter' => UserStatus::listData(),
                'filterInputOptions' => ['prompt' => Yii::t('app', 'Select Status'), 'class' => 'form-control'],
            ],
            [
                'attribute' => 'created_at',
                'format' => 'date',
                'filter' => false,
            ],
            [
                'header' => Yii::t('app', 'Action'),
                'class' => 'yii\grid\ActionColumn',
                'template' => '{switch} {update} {delete}',
                'buttons' => [
                    'switch' => function ($url, $model) {
                        $options = [
                            'title' => Yii::t('app', 'Become this user'),
                            'aria-label' => Yii::t('app', 'Become this user'),
                            'data-pjax' => '0',
                            'data-confirm' => Yii::t('app', 'Are you sure you want to switch to this user for the rest of this Session?'),
                            'data-method' => 'POST',
                        ];

                        $url = ['switch', 'id' => $model->id];
                        $icon = '<span class="glyphicon glyphicon-user"></span>';

                        return Html::a($icon, $url, $options);
                    },
                ],
            ],
        ],
    ]);
    ?>
    <?php Pjax::end(); ?>

</div>
