<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Almacenes;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use yii\bootstrap\Alert;

/* @var $this yii\web\View */
/* @var $model app\models\Productos */
/* @var $form yii\widgets\ActiveForm */

$almacenes= Almacenes::find()->all();
$datos= ArrayHelper::map($almacenes,'id','nombre');
?>


<div class="productos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'foto')->fileInput() ?>
    
    <?php
    if (!empty($model->foto)){
        echo Alert::widget([
            'body'=> Html::img($model->getFoto(),[
                'class'=>'img-responsive img-thumbnail',
            ]),
            'closeButton'=>[
                'tag'=> 'a',
                'href'=> \yii\helpers\Url::to(['productos/eliminar','id'=>$model->id]),
            ],
        ]);
    }
    ?>

    <?= $form->field($model, 'almacen')->dropDownList($datos,
            ['prompt'=>'Selecciona un Almacen']) ?>

    <?php
    echo '<label class="control-label">Fecha</label>';
    echo DatePicker::widget([
        'model'=>$model,
        'attribute'=>'fecha',
        'language'=>'es',
        'options'=> ['placeholder'=>'Introduce fecha'],
        'pluginOptions'=>[
            'todayHighlight'=> true,
            'todayBtn'=> true,
            'format'=>'dd/mm/yyyy',
            'autoclose' => true,
            ]
    ])?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
