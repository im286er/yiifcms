<div id="contentHeader">
  <h3><?php echo Yii::t('admin','Modeltype Manage');?></h3>
  <div class="searchArea">
    <ul class="action left" >
      <li ><a href="<?php echo $this->createUrl('ad/index')?>" class="actionBtn"><span><?php echo Yii::t('admin','Modeltype Manage');?></span></a></li>
      <li class="current"><a href="<?php echo $this->createUrl('adCreate')?>" class="actionBtn"><span><?php echo Yii::t('admin','Add');?></span></a></li>
    </ul>
    <div class="search right"> </div>
  </div>
</div>
<?php $this->renderPartial('_form',array('model'=>$model))?>
