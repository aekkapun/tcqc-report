<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'ประกาศกรมการขนส่งทางบก.';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
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
<hr/>
  <div class="card-body">
       <h5 class="card-title text-center fw-bold  "> ประกาศกรมการขนส่งทางบก. เรื่อง กำหนดหลักเกณฑ์ วิธีการ และเงื่อนไขในการขออนุญาต การอนุญาต <br/> และระยะเวลาในการใช้รถ และเครื่องหมายแสดงการใช้รถที่ใช้เพื่อการทดสอบ. พ.ศ. ๒๕๖๐ </h5> <hr/>

    <?php
$pdfUrl = Yii::$app->request->baseUrl . '/announcement.pdf'; 
?>
<iframe src="<?= $pdfUrl ?>" width="100%" height="800px"></iframe>
</div>
</div>
