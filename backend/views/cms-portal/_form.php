<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\widgets\ListView;
use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model backend\models\CmsPortal */
/* @var $form yii\widgets\ActiveForm */
$attributes = $model->attributeLabels();
foreach ($attributes as $key => $value) {
    if ($value=='Last Update' || $value=='Last User') {
        unset($attributes[$key]);
    }
}

?>

<div class="cms-portal-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-md-12">
            <iframe src="<?= str_replace('backend/', '', Url::to(['site/portal'])) ?>"  height="400" width="100%" id="theFrame"></iframe>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'Element')->dropDownList(
                $attributes, 
                ['prompt'=>'Pilih Element...','onchange'=>'openClose(this.value)']); ?>
        </div>
        <div class="col-md-8">
            <div class="col-md-12 fieldd" style="display:none" id="banner1">
                <?= $form->field($model, 'banner1')->widget(FileInput::classname(), [
                  'options' => ['accept' => 'img/*'],
                   'pluginOptions' => [
                        'width'=> '90%',
                        // 'initialPreview'=>$model->banner1,
                        // 'initialPreview'=>Html::img($baseurl.'/portal/img/cms/banner/'.$model->banner1,  ['class'=>'file-preview-image','style'=>'width:100%']),
                        'overwriteInitial'=>false,
                        
                        'allowedFileExtensions'=>['jpg','jpeg','png'],
                        'showPreview' => false,
                        'showCaption' => true,
                        'showRemove' => true,
                        'showCancel' => false,
                        'showUpload' => false,
                    ]
              ])->label('Upload Banner 1');?>
            </div>

             <div class="col-md-12 fieldd" style="display:none" id="banner2">
                <?= $form->field($model, 'banner2')->widget(FileInput::classname(), [
                  // 'options' => ['accept' => 'doc/*'],
                   'pluginOptions' => [
                        'width'=> '90%',
                        // 'initialPreview'=>Html::img($baseurl.'/portal/img/cms/banner/'.$model->banner2,  ['class'=>'file-preview-image','style'=>'width:100%']),
                        
                        'allowedFileExtensions'=>['jpg','jpeg','png'],
                        'showPreview' => false,
                        'showCaption' => true,
                        'showRemove' => true,
                        'showCancel' => false,
                        'showUpload' => false,
                    ]
              ])->label('Upload Banner 2');?>
            </div>

            <div class="col-md-12 fieldd" style="display:none" id="banner3">
                <?= $form->field($model, 'banner3')->widget(FileInput::classname(), [
                  // 'options' => ['accept' => 'doc/*'],
                   'pluginOptions' => [
                        'width'=> '90%',
                        // 'initialPreview'=>Html::img($baseurl.'/portal/img/cms/banner/'.$model->banner3,  ['class'=>'file-preview-image','style'=>'width:100%']),
                        
                        'allowedFileExtensions'=>['jpg','jpeg','png'],
                        'showPreview' => false,
                        'showCaption' => true,
                        'showRemove' => true,
                        'showCancel' => false,
                        'showUpload' => false,
                    ]
              ])->label('Upload Banner 3');?>
            </div>

            <div class="col-md-12 fieldd" style="display:none" id="banner4">
                <?= $form->field($model, 'banner4')->widget(FileInput::classname(), [
                  // 'options' => ['accept' => 'doc/*'],
                   'pluginOptions' => [
                        'width'=> '90%',
                        // 'initialPreview'=>Html::img($baseurl.'/portal/img/cms/banner/'.$model->banner4,  ['class'=>'file-preview-image','style'=>'width:100%']),
                        
                        'allowedFileExtensions'=>['jpg','jpeg','png'],
                        'showPreview' => false,
                        'showCaption' => true,
                        'showRemove' => true,
                        'showCancel' => false,
                        'showUpload' => false,
                    ]
              ])->label('Upload Banner 4');?>
            </div>

            <div class="col-md-12 fieldd" style="display:none" id="banner5">
                <?= $form->field($model, 'banner5')->widget(FileInput::classname(), [
                  // 'options' => ['accept' => 'doc/*'],
                   'pluginOptions' => [
                        'width'=> '90%',
                        // 'initialPreview'=>Html::img($baseurl.'/portal/img/cms/banner/'.$model->banner5,  ['class'=>'file-preview-image','style'=>'width:100%']),
                        'allowedFileExtensions'=>['jpg','jpeg','png'],
                        'showPreview' => false,
                        'showCaption' => true,
                        'showRemove' => true,
                        'showCancel' => false,
                        'showUpload' => false,
                    ]
              ])->label('Upload Banner 5');?>
            </div>

            <div class="col-md-12 fieldd" style="display:none" id="fitur1">
                <!-- <?= $form->field($model, 'fitur1')->textArea(['maxlength' => true])->label('Fitur 1') ?> -->
                 <?= $form->field($model, 'fitur1')->widget(TinyMce::className(), [
                    'options' => ['rows' => 20],
                    'language' => 'en',
                    'clientOptions' => [
                        'plugins' => [
                            "advlist autolink lists link charmap print preview anchor",
                            "searchreplace visualblocks code fullscreen",
                            "insertdatetime media table contextmenu paste"
                        ],
                        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                    ]
                ]);?>
            </div>

            <div class="col-md-12 fieldd" style="display:none" id="fitur2">
                <!-- <?= $form->field($model, 'fitur2')->textArea(['maxlength' => true])->label('Fitur 2') ?> -->
                 <?= $form->field($model, 'fitur2')->widget(TinyMce::className(), [
                    'options' => ['rows' => 20],
                    'language' => 'en',
                    'clientOptions' => [
                        'plugins' => [
                            "advlist autolink lists link charmap print preview anchor",
                            "searchreplace visualblocks code fullscreen",
                            "insertdatetime media table contextmenu paste"
                        ],
                        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                    ]
                ]);?>
            </div>

            <div class="col-md-12 fieldd" style="display:none" id="fitur3">
                <!-- <?= $form->field($model, 'fitur3')->textArea(['maxlength' => true])->label('Fitur 3') ?> -->
                 <?= $form->field($model, 'fitur3')->widget(TinyMce::className(), [
                    'options' => ['rows' => 20],
                    'language' => 'en',
                    'clientOptions' => [
                        'plugins' => [
                            "advlist autolink lists link charmap print preview anchor",
                            "searchreplace visualblocks code fullscreen",
                            "insertdatetime media table contextmenu paste"
                        ],
                        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                    ]
                ]);?>
            </div>

            <div class="col-md-12 fieldd" style="display:none" id="deskripsi">
                <!-- <?= $form->field($model, 'deskripsi')->textArea(['maxlength' => true])->label('Deskripsi') ?> -->
                 <?= $form->field($model, 'deskripsi')->widget(TinyMce::className(), [
                    'options' => ['rows' => 20],
                    'language' => 'en',
                    'clientOptions' => [
                        'plugins' => [
                            "advlist autolink lists link charmap print preview anchor",
                            "searchreplace visualblocks code fullscreen",
                            "insertdatetime media table contextmenu paste"
                        ],
                        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                    ]
                ]);?>
            </div>


            <div class="col-md-12 fieldd" style="display:none" id="deskripsi_img1">
                <?= $form->field($model, 'deskripsi_img1')->widget(FileInput::classname(), [
                  // 'options' => ['accept' => 'doc/*'],
                   'pluginOptions' => [
                        'width'=> '90%',
                        
                        'allowedFileExtensions'=>['jpg','jpeg','png'],
                        'showPreview' => false,
                        'showCaption' => true,
                        'showRemove' => true,
                        'showCancel' => false,
                        'showUpload' => false,
                    ]
              ])->label('Upload Image Deskripsi 1');?>
            </div>

            <div class="col-md-12 fieldd" style="display:none" id="deskripsi_img2">
                <?= $form->field($model, 'deskripsi_img2')->widget(FileInput::classname(), [
                  // 'options' => ['accept' => 'doc/*'],
                   'pluginOptions' => [
                        'width'=> '90%',
                        
                        'allowedFileExtensions'=>['jpg','jpeg','png'],
                        'showPreview' => false,
                        'showCaption' => true,
                        'showRemove' => true,
                        'showCancel' => false,
                        'showUpload' => false,
                    ]
              ])->label('Upload Image Deskripsi 2');?>
            </div>

            <div class="col-md-12 fieldd" style="display:none" id="deskripsi_img3">
                <?= $form->field($model, 'deskripsi_img3')->widget(FileInput::classname(), [
                  // 'options' => ['accept' => 'doc/*'],
                   'pluginOptions' => [
                        'width'=> '90%',
                        
                        'allowedFileExtensions'=>['jpg','jpeg','png'],
                        'showPreview' => false,
                        'showCaption' => true,
                        'showRemove' => true,
                        'showCancel' => false,
                        'showUpload' => false,
                    ]
              ])->label('Upload Image Deskripsi 3');?>
            </div>

            <div class="col-md-12 fieldd" style="display:none" id="deskripsi_text1">
                <!-- <?= $form->field($model, 'deskripsi_text1')->textArea(['maxlength' => true])->label('Text Deskripsi 1') ?> -->
                <?= $form->field($model, 'deskripsi_text1')->widget(TinyMce::className(), [
                    'options' => ['rows' => 20],
                    'language' => 'en',
                    'clientOptions' => [
                        'plugins' => [
                            "advlist autolink lists link charmap print preview anchor",
                            "searchreplace visualblocks code fullscreen",
                            "insertdatetime media table contextmenu paste"
                        ],
                        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                    ]
                ]);?>
            </div>

            <div class="col-md-12 fieldd" style="display:none" id="deskripsi_text2">
                <!-- <?= $form->field($model, 'deskripsi_text2')->textArea(['maxlength' => true])->label('Text Deskripsi 2') ?> -->
                <?= $form->field($model, 'deskripsi_text2')->widget(TinyMce::className(), [
                    'options' => ['rows' => 20],
                    'language' => 'en',
                    'clientOptions' => [
                        'plugins' => [
                            "advlist autolink lists link charmap print preview anchor",
                            "searchreplace visualblocks code fullscreen",
                            "insertdatetime media table contextmenu paste"
                        ],
                        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                    ]
                ]);?>
            </div>

            <div class="col-md-12 fieldd" style="display:none" id="deskripsi_text3">
                <!-- <?= $form->field($model, 'deskripsi_text3')->textArea(['maxlength' => true])->label('Text Deskripsi 3') ?> -->
                <?= $form->field($model, 'deskripsi_text3')->widget(TinyMce::className(), [
                    'options' => ['rows' => 20],
                    'language' => 'en',
                    'clientOptions' => [
                        'plugins' => [
                            "advlist autolink lists link charmap print preview anchor",
                            "searchreplace visualblocks code fullscreen",
                            "insertdatetime media table contextmenu paste"
                        ],
                        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                    ]
                ]);?>
            </div>

            <div class="col-md-12 fieldd" style="display:none" id="partner_img">
                <?= $form->field($model, 'partner_img')->widget(FileInput::classname(), [
                  // 'options' => ['accept' => 'doc/*'],
                   'pluginOptions' => [
                        'width'=> '90%',
                        
                        'allowedFileExtensions'=>['jpg','jpeg','png'],
                        'showPreview' => false,
                        'showCaption' => true,
                        'showRemove' => true,
                        'showCancel' => false,
                        'showUpload' => false,
                    ]
              ])->label('Upload Image Partner');?>
            </div>

            <div class="col-md-12 fieldd" style="display:none" id="partner_text">
                <!-- <?= $form->field($model, 'partner_text')->textArea(['maxlength' => true])->label('Text Partner') ?> -->
                <?= $form->field($model, 'partner_text')->widget(TinyMce::className(), [
                    'options' => ['rows' => 20],
                    'language' => 'en',
                    'clientOptions' => [
                        'plugins' => [
                            "advlist autolink lists link charmap print preview anchor",
                            "searchreplace visualblocks code fullscreen",
                            "insertdatetime media table contextmenu paste"
                        ],
                        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                    ]
                ]);?>
            </div>

            <div class="col-md-12 fieldd" style="display:none" id="term_con">
                <!-- <?= $form->field($model, 'term_con')->textArea(['maxlength' => true])->label('Term & Conditions') ?> -->
                <?= $form->field($model, 'term_con')->widget(TinyMce::className(), [
                    'options' => ['rows' => 20],
                    'language' => 'en',
                    'clientOptions' => [
                        'plugins' => [
                            "advlist autolink lists link charmap print preview anchor",
                            "searchreplace visualblocks code fullscreen",
                            "insertdatetime media table contextmenu paste"
                        ],
                        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                    ]
                ]);?>
            </div>
            <div class="col-md-12 fieldd" style="display:none" id="policy">
                <!-- <?= $form->field($model, 'policy')->textArea(['maxlength' => true])->label('Term & Conditions') ?> -->
                <?= $form->field($model, 'policy')->widget(TinyMce::className(), [
                    'options' => ['rows' => 20],
                    'language' => 'en',
                    'clientOptions' => [
                        'plugins' => [
                            "advlist autolink lists link charmap print preview anchor",
                            "searchreplace visualblocks code fullscreen",
                            "insertdatetime media table contextmenu paste"
                        ],
                        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                    ]
                ]);?>
            </div>

        </div>
        

        <div class="form-group col-md-12">
            <?= Html::submitButton('Apply', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    $(document).ready(function(e){
        // Submit form data via Ajax
        $("form").on('submit', function(e){
            $('#theFrame').contents().find("#loading").show();
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?= Url::to(['update'])?>',
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                },
                success: function(response){ //console.log(response);
                    document.getElementById('theFrame').contentDocument.location.reload(true);
                    $('#theFrame').contents().find("#dontTouch").show();
                }
            });
            return false;
        });
    });
    function openClose(val) {
        $('.fieldd').hide();
        $('#'+val).show(200);
    }
</script>