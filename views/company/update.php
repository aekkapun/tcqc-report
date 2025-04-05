

<div class="card">
  <div class="card-header bg-secondary text-white">
  แก้ไขข้อมูลการลงทะเบียนบริษัท
  </div>
  <div class="card-body">
  <?= $this->render('_form', [
        'model' => $model,
        'initialPreview'=>$initialPreview,
        'initialPreviewConfig'=>$initialPreviewConfig
    ]) ?>
  </div>
</div>
