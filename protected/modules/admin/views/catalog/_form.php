<?php if (CHtml::errorSummary($model)):?>

<table id="tips">
  <tr>
    <td><div class="erro_div"><span class="error_message"> <?php echo CHtml::errorSummary($model); ?> </span></div></td>
  </tr>
</table>
<?php endif?>
<script type="text/javascript">
$(function(){
  $("#Catalog_parent_id").val(<?php echo $parentId ?>);
});
</script>
<?php $form = $this->beginWidget('CActiveForm',array('id'=>'xform','htmlOptions'=>array('name'=>'xform', 'enctype'=>'multipart/form-data'))); ?>
<table class="form_table">
  <tr>
    <td class="tb_title"><?php echo Yii::t('admin','Title Name');?>：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'catalog_name',array('size'=>40,'maxlength'=>128, 'class'=>'validate[required]')); ?></td>
  </tr>
  <tr>
    <td class="tb_title"><?php echo Yii::t('admin','Title Name Alias');?>：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'catalog_name_second',array('size'=>40,'maxlength'=>128, 'class'=>'validate[required]')); ?></td>
  </tr>
  <tr>
    <td class="tb_title"><?php echo Yii::t('admin','Unique Mark (Combination of letters or Numbers)');?>：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'catalog_name_alias',array('size'=>40,'maxlength'=>128)); ?></td>
  </tr>
  <tr>
    <td class="tb_title"><?php echo Yii::t('admin','Belong Category');?>：</td>
  </tr>
  <tr >
    <td ><select name="Catalog[parent_id]" id="Catalog_parent_id">
        <option value="0">==<?php echo Yii::t('admin','Top Category');?>==</option>
        <?php foreach((array)Catalog::get(0, $this->_catalog) as $catalog):?>
        <option value="<?php echo $catalog['id']?>" <?php $this->selected($catalog['id'], $model->parent_id);?>><?php echo $catalog['str_repeat']?><?php echo $catalog['catalog_name']?></option>
        <?php endforeach;?>
      </select></td>
  </tr>
  <tr>
    <td class="tb_title"><?php echo Yii::t('admin','Show Method');?>：</td>
  </tr>
  <tr >
    <td class="tb_title"><?php echo $form->dropDownList($model,'display_type',array('list'=>Yii::t('admin','List'), 'page'=>Yii::t('admin','Page')));?></td>
  </tr>
  <tr>
    <td class="tb_title"><?php echo Yii::t('admin','Show Numbers Of Per Page');?>：</td>
  </tr>
  <tr >
    <td class="tb_title"><?php echo $form->textField($model,'page_size',array('size'=>5,'maxlength'=>5)); ?></td>
  </tr>
  
  <tr>
    <td class="tb_title"><?php echo Yii::t('admin','Template List');?>：</td>
  </tr>
  <tr >
    <td ><?php echo $form->dropDownList($model,'template_list',array('list_post'=>Yii::t('admin','Post List Template'), 'list_page'=>Yii::t('admin','Page List Template'),'list_goods'=>Yii::t('admin','Goods List Template'))); ?><?php echo $model->template_list;?></td>
  </tr> 
  <tr>
    <td class="tb_title"><?php echo Yii::t('admin','Template Show');?>：</td>
  </tr>
  <tr >
    <td ><?php echo $form->dropDownList($model,'template_show',array('show_post'=>Yii::t('admin','Post Show Template'), 'show_page'=>Yii::t('admin','Page Show Template'), 'show_goods'=>Yii::t('admin','Goods Show Template'))); ?><?php echo $model->template_show;?></td>
  </tr>
  <tr>
    <td class="tb_title"><?php echo Yii::t('common','Redirect Url');?>：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'redirect_url',array('size'=>60,'maxlength'=>128)); ?> <?php echo Yii::t('admin','Rediretc To The Url If Input This');?></td>
  </tr>
  <tr>
    <td class="tb_title"><?php echo Yii::t('admin','Cover Image');?>：</td>
  </tr>
  <tr >
  	<td>
    	<input name="attach" type="file" id="attach" />
        <?php if ($model->attach_file):?>
        <a href="<?php echo $this->_baseUrl.'/'. $model->attach_file?>" target="_blank"><img style="padding:5px; border:1px solid #cccccc;" src="<?php echo $this->_baseUrl.'/'. $model->attach_file?>" width="50" align="absmiddle" /></a>
        <?php endif?>
        <?php if ($model->attach_thumb):?>
        <a href="<?php echo $this->_baseUrl.'/'. $model->attach_thumb?>" target="_blank"><img style="padding:5px; border:1px solid #cccccc;" src="<?php echo $this->_baseUrl.'/'. $model->attach_thumb?>" width="50" align="absmiddle" /></a>
        <?php endif?>
    </td>
  </tr>
  <tr>
    <td class="tb_title"><?php echo Yii::t('admin','Catalog Description');?>：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textArea($model,'content'); ?>      
      <?php $this->widget('application.widget.kindeditor.KindEditor',array(
	  'target'=>array(
	  	'#Catalog_content'=>array('uploadJson'=>$this->createUrl('/admin/uploadify/basicexecute', array('from'=>'editor')),		
		'allowFileManager'=>true, 		
	  	'extraFileUploadParams'=>array(array('sessionId'=>Yii::app()->session->sessionID))))));?></td>
  </tr>
  <tr>
    <td class="tb_title"><?php echo Yii::t('admin','SEO Title');?>：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'seo_title',array('size'=>50,'maxlength'=>128)); ?></td>
  </tr>
  <tr>
    <td class="tb_title"><?php echo Yii::t('admin','SEO Keywords');?>：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'seo_keywords',array('size'=>50,'maxlength'=>128)); ?></td>
  </tr>
  <tr>
    <td class="tb_title"><?php echo Yii::t('admin','SEO Description');?>：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textArea($model,'seo_description',array('rows'=>5,'cols'=>80)); ?></td>
  </tr>
  <tr>
    <td class="tb_title"><?php echo Yii::t('common','Status');?>：</td>
  </tr>
  <tr >
    <td ><?php echo $form->dropDownList($model,'status_is',array('Y'=>Yii::t('admin','Show'), 'N'=>Yii::t('admin','Hidden'))); ?><?php echo Yii::t('admin','Sort Order');?>:<?php echo $form->textField($model,'sort_order',array('size'=>6,'maxlength'=>128)); ?></td>
  </tr>
  <tr class="submit">
    <td >
      <input name="oAttach" type="hidden" value="<?php echo $model->attach_file ?>" />
      <input name="oThumb" type="hidden" value="<?php echo $model->attach_thumb ?>" />
      <input type="submit" name="editsubmit" value="<?php echo Yii::t('common','Submit');?>" class="button" tabindex="3" /></td>
  </tr>
</table>
<script type="text/javascript">
$(function(){
	$("#xform").validationEngine();	
});
</script>
<?php $form=$this->endWidget(); ?>