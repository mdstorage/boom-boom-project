<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle='Что-то пошло не так.';
?>

<div class="error">
<?php echo CHtml::encode($code); ?>
</div>