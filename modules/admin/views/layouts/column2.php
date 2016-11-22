<?php

use app\assets\AdminAsset;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\widgets\Menu;
use yii2mod\notify\BootstrapNotify;

/* @var $this \yii\web\View */
/* @var $content string */

AdminAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?php echo Yii::$app->language ?>">
    <head>
        <?php $this->registerMetaTag(['charset' => Yii::$app->charset]); ?>
        <?php $this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1']); ?>
        <?php echo Html::csrfMetaTags() ?>
        <title><?php echo implode(' | ', array_filter([Html::encode($this->title), Yii::$app->name])); ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <?php echo BootstrapNotify::widget(); ?>
    <div class="wrap">
        <?php NavBar::begin([
            'brandLabel' => 'Admin Panel',
            'brandUrl' => '/admin',
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'encodeLabels' => false,
            'items' => [
                [
                    'label' => '<i class="glyphicon glyphicon-user"></i> Users',
                    'items' => [
                        [
                            'label' => '<i class="glyphicon glyphicon-th-list"></i> User List',
                            'url' => ['/admin/user/index'],
                        ],
                        [
                            'label' => '<i class="glyphicon glyphicon-plus"></i> Create User',
                            'url' => ['/admin/user/create'],
                        ],
                    ],
                ],
                [
                    'label' => '<i class="glyphicon glyphicon-file"></i> CMS',
                    'url' => ['/admin/cms/index'],
                ],
                [
                    'label' => '<i class="glyphicon glyphicon-user"></i> RBAC',
                    'url' => ['/admin/rbac/assignment/index'],
                    'active' => $this->context->module->id == 'rbac',
                ],
                [
                    'label' => '<i class="glyphicon glyphicon-wrench"></i> Settings Storage',
                    'url' => ['/admin/settings-storage'],
                    'active' => $this->context->module->id == 'settings-storage',
                ],
                [
                    'label' => '<i class="glyphicon glyphicon-cog"></i> Cron Schedule Log',
                    'url' => ['/admin/settings/cron'],
                ],
            ],
        ]);

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                ['label' => '<i class="glyphicon glyphicon-globe"></i> Public Area', 'url' => ['/']],
                ['label' => '<i class="glyphicon glyphicon-off"></i> Logout (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post'],
                ],
            ],
            'encodeLabels' => false,
        ]);
        NavBar::end();
        ?>
        <div class="container">
            <?php echo Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <div class="row">
                <?php if (isset($this->params['sidebar'])): ?>
                    <div class="col-lg-2">
                        <?php echo Menu::widget([
                            'items' => $this->params['sidebar'],
                            'encodeLabels' => false,
                            'options' => [
                                'class' => 'nav nav-pills nav-stacked admin-side-nav',
                            ],
                        ]);
                        ?>
                    </div>
                <?php endif; ?>
                <div class="col-lg-10">
                    <?php echo $content; ?>
                </div>
            </div>
        </div>
    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>