<?php

class FindArticulController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
    public function actionArticulRegions($articul, $region = null)
    {
        $oFindArticul = new FindArticul($articul, $region);

        $this->render('region_models', array('oFindArticul'=>$oFindArticul));
    }

    public function actionArticulModelModifications()
    {
        $articul = Yii::app()->request->getPost('articul');
        $region = Yii::app()->request->getPost('region');
        $model = Yii::app()->request->getPost('model');

        $oModel = new Model(array('articul'=>$articul, 'region'=>$region, 'model'=>$model));

        $oModel->setModifications();

        $this->renderPartial('model_modifications', array('oModel'=>$oModel));
    }
}