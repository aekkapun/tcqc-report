<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;

$this->title = 'ระบบรายงานการใช้เครื่องหมายแสดงการใช้รถทดสอบ';
$findName = Yii::$app->user->identity ? Yii::$app->user->identity->find_name : null;
?>
<div class="site-index">
  <div class="d-flex align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm">
    <h2 class="mb-0 text-warning fw-bold text-center">ระบบรายงานการใช้เครื่องหมายแสดงการใช้รถทดสอบ</h2><br />
    <hr />
    <small class="text-center fw-bold d-flex align-items-center">
      รถทดสอบคุณภาพ QC | รถทดสอบก่อนผลิต TC
      <div class="alert alert-warning ms-2 mb-0 p-1" role="alert">
        <a href="#" class="alert-link"> </a>
      </div>

    </small>


  </div>
  <hr />

  <?php if (!Yii::$app->user->isGuest): ?>

    <div class="d-grid gap-2 col-6 mx-auto">
    <p>
        <?= Html::a(' ลงทะเบียนบริษัท ', ['company/create'], ['class' => 'btn btn-lg btn-primary d-flex align-items-center justify-content-center fw-semibold ']) ?>
    </p>
    </div>
  <?php endif; ?>
  <?php if (Yii::$app->user->isGuest): ?>
    <div id="carouselExampleDark" class="carousel carousel-dark slide">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active" data-bs-interval="10000">
          <img src="images/QC.jpg" class="d-block w-100" alt="แบบเครื่องหมายแสดงการใช้รถ สำหรับรถยนต์ QC">
          <div class="carousel-caption d-none d-md-block">
            <h5>(รถทดสอบคุณภาพ)</h5>
            <p>แบบเครื่องหมายแสดงการใช้รถ สำหรับรถยนต์ QC</p>
          </div>
        </div>
        <div class="carousel-item" data-bs-interval="2000">
          <img src="images/TC.jpg" class="d-block w-100" alt="แบบเครื่องหมายแสดงการใช้รถ สำหรับรถจักรยานยนต์ TC">
          <div class="carousel-caption d-none d-md-block">
            <h5>(รถทดสอบก่อนผลิต)</h5>
            <p>แบบเครื่องหมายแสดงการใช้รถ สำหรับรถจักรยานยนต์ TC</p>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  <?php endif; ?>
</div>