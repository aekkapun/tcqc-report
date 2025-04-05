<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.png')]);
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <title>ระบบขออนุญาตให้ใช้รถเพื่อการทดสอบ</title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header id="header">
        <?php
        NavBar::begin([
            'brandLabel' => Html::img('@web/images/logo.png', ['alt' => 'Logo', 'style' => 'height:40px; margin-right:10px;']),
            'brandUrl' => Yii::$app->homeUrl,
            'options' => ['class' => 'navbar-expand-md navbar-light bg-light bd-navbar  navbar fixed-top fw-bold']
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav ms-auto'],
            'encodeLabels' => false,
            'items' => [
                ['label' => 'หน้าหลัก', 'url' => ['/site/index']],
                [
                    'label' => 'ใบอนุญาตรถทดสอบ',
                    'url' => ['/tr/index'],
                    'visible' => !Yii::$app->user->isGuest // แสดงเฉพาะเมื่อล็อกอินแล้ว
                ],
                [
                    'label' => 'Report Log',
                    'url' => ['/report-log/index'],
                    'visible' => !Yii::$app->user->isGuest // แสดงเฉพาะเมื่อล็อกอินแล้ว
                ],
                [
                    'label' => '<i class="fa fa-search" aria-hidden="true"></i>  สอบถาม',
                    'items' => [
                        ['label' => '<i class="fa fa-caret-right" aria-hidden="true"></i>   สืบค้นด้วยเลขเครื่องหมาย', 'url' => ['/find/find/find-cert-number']],
                        ['label' => '<i class="fa fa-caret-right" aria-hidden="true"></i>   สืบค้นด้วยเลขที่หนังสืออนุญาต', 'url' => ['/find/find/find-book-no']],
                        ['label' => '<i class="fa fa-caret-right" aria-hidden="true"></i>   สืบค้นด้วยชื่อผู้ได้รับหนังสืออนุญาต ', 'url' => ['/find/find/find-veh-user']],
                        ['label' => '<i class="fa fa-caret-right" aria-hidden="true"></i>   สืบค้นด้วยเลขเลขตัวถังและเลขเครื่องยนต์ ', 'url' => ['/find/find/find-mac-eng']],
                    ],
                    'visible' => !Yii::$app->user->isGuest, // แสดงเฉพาะเมื่อล็อกอินแล้ว
                    'encode' => false, // ไม่ต้องเข้ารหัส HTML ใน label
                ],
                [
                    'label' => 'ประกาศกรมการขนส่งทางบก', 'url' => ['/site/about'],
                    'visible' => Yii::$app->user->isGuest,
                ],
                [
                    'label' => '<i class="fa fa-user" aria-hidden="true"></i>  ข้อมูลผู้ใช้งาน :' . @Yii::$app->user->identity->username,
                    'items' => [
                        ['label' => '<i class="fa fa-caret-right" aria-hidden="true"></i>   เปลี่ยนรหัสผ่าน', 'url' => ['/find/find/find-cert-number']],
                    ],
                    'visible' => !Yii::$app->user->isGuest
                ],
                Yii::$app->user->isGuest
                    ? ['label' => 'เข้าสู่ระบบ', 'url' => ['/site/login']]
                    : '<li class="nav-item">'
                    . Html::beginForm(['/site/logout'])
                    . Html::submitButton(
                        '<i class="fa fa-window-close" aria-hidden="true"></i> ออกจากระบบ',
                        ['class' => 'nav-link btn btn-link btn-flat float-right']
                    )
                    . Html::endForm()
                    . '</li>'
            ]
        ]);
        NavBar::end();
        ?>
    </header>

    <main id="main" class="flex-shrink-0 py-5" role="main" style="margin-top: 80px;">
        <div class="container">
            <?php if (!empty($this->params['breadcrumbs'])): ?>
                <?=
                Breadcrumbs::widget([
                    'homeLink' => [
                        'label' => '<i class="fa fa-home"></i> ' . Yii::t('yii', 'หน้าหลัก'),
                        'url' => Yii::$app->homeUrl,
                        'encode' => false // Requested feature
                    ],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
                ?>
                <hr />
            <?php endif ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <footer id="footer" class="mt-auto py-3 bg-light">
        <div class="container">
            <div class="row text-muted">
                <div class="col-md-6 text-center text-md-start">&copy; ระบบรายงานการใช้เครื่องหมายแสดงการใช้รถทดสอบ <?= date('Y') ?></div>
                <div class="col-md-6 text-center text-md-end">DLT</div>
            </div>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>