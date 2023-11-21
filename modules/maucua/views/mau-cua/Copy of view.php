<?php

use yii\widgets\DetailView;
use app\widgets\views\ImageListWidget;
use app\modules\maucua\models\MauCua;

/* @var $this yii\web\View */
/* @var $model app\modules\maucua\models\MauCua */
?>
<div class="mau-cua-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'code',
            'ten_cua',
            'kich_thuoc',
            'id_he_nhom',
            'id_loai_cua',
            'id_parent',
            'date_created',
            'user_created',
        ],
    ]) ?>
    
    
    <?php /* ImageListWidget::widget([
    	    'loai' => MauCua::MODEL_ID,
    	    'id_tham_chieu' => $model->id
    	]) */ ?>
    	
    	
	<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="https://picsum.photos/200" class="d-block w-100" alt="...">
          <div class="carousel-caption d-none d-md-block">
            <h5>First slide label</h5>
            <p>Some representative placeholder content for the first slide.</p>
          </div>
        </div>
        
        <div class="carousel-item">
          <img src="https://picsum.photos/200" class="d-block w-100" alt="...">
          <div class="carousel-caption d-none d-md-block">
            <h5>Second slide label</h5>
            <p>Some representative placeholder content for the second slide.</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="https://picsum.photos/200" class="d-block w-100" alt="...">
          <div class="carousel-caption d-none d-md-block">
            <h5>Third slide label</h5>
            <p>Some representative placeholder content for the third slide.</p>
          </div>
        </div>
        
      </div>
      
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>

</div>
