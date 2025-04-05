<div class="card">
  <div class="card-header bg-success text-white">
  ลงทะเบียนบริษัท
  </div>
  <div class="card-body">
  <?= $this->render('_form', [
        'model' => $model,
        'initialPreview'=>[],
        'initialPreviewConfig'=>[]
    ]) ?>
  </div>
</div>
