<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii2mod\editable\EditableColumn;
use yii2mod\user\models\enumerables\UserStatus;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \app\models\UserModelSearch */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <p>
        <?php echo Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(['enablePushState' => false, 'timeout' => 10000]); ?>
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'class' => EditableColumn::className(),
                'attribute' => 'username',
                'url' => ['edit-user'],
            ],
            'email:email',
            [
                'class' => EditableColumn::className(),
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
                'filterInputOptions' => ['prompt' => 'Select Status', 'class' => 'form-control'],
            ],
            [
                'attribute' => 'createdAt',
                'label' => 'Created date',
                'format' => 'date',
                'filter' => false,
            ],
            [
                'header' => 'Action',
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
            ],
        ],
    ]);
    ?>
    <?php Pjax::end(); ?>

</div>