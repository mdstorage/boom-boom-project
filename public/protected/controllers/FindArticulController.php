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
    public function actionArticulRegions($articul, $regionCode = null)
    {
        /*
         * Модель для поиска по артикулу
         */
        $oFindArticulModel = new FindArticulModel();

        /*
         * Компонент, отслеживающий процесс поиска по артикулу
         */
        $oFindArticul = new FindArticul($articul);

        /*
         * Выборка регионов из базы данных для конкретного артикула
         */
        $aRegions = $oFindArticulModel->getRegions($articul);
        if(empty($aRegions)){
            throw new CHttpException("Запчасть с артикулом " .$articul. " отсутствует в каталоге.");
        } else {
            /*
             * Если регионы найдены, они помещаются в объект компонента oFindArticul
             */
            $oFindArticul->setRegions($aRegions);
            /*
             * Если пользователь задал регион, то этот регион становится активным
             */
            if (!is_null($regionCode)){
                $oActiveRegion = new Region($regionCode);
            } else{
                /*
                 * Если пользователь не задавал регион, то в качестве активного выбирается первый из списка регионов объект
                 */
                $regions = $oFindArticul->getRegions();
                $oActiveRegion = new Region($regions[0]->getCode());
            }

            $oActiveRegion->setName($oActiveRegion->getCode());
            /*
             * Выборка моделей из базы для данного артикула и региона
             */
            $models = $oFindArticulModel->getActiveRegionModels($articul, $oActiveRegion->getCode());

            if(empty($models)){
                throw new CHttpException("Ошибка в выборе моделей для региона: " . $oActiveRegion->getRuname());
            } else {
                $oActiveRegion->setModels($models);
            }

            $oFindArticul->setActiveRegion($oActiveRegion);
        }

        $this->render('region_models', array('oFindArticul'=>$oFindArticul));
    }

    public function actionArticulModelModifications()
    {
        if(Yii::app()->request->isAjaxRequest){

            $articul = Yii::app()->request->getPost('articul');
            $region = Yii::app()->request->getPost('region');
            $model = Yii::app()->request->getPost('model');

            if($articul && $region && $model){
                $oModel = new Model($model);
                $oModel->setRegion(new Region($region));
                $oFindArticulModel = new FindArticulModel();
                $modifications = $oFindArticulModel->getActiveModelModifications($articul, $region, $model);
                if(empty($modifications)){
                    throw new CHttpException("Ошибка в выборе модификаций для модели: " . $model);
                } else {
                    $oModel->setModifications($modifications);
                }
                $this->renderPartial('_model_modifications', array('oModel'=>$oModel, 'articul'=>$articul));
            } else {
                throw new CHttpException("Ошибка в передаче данных.");
            }
        }
    }

    public function actionArticulModificationGroups($articul, $modificationCode, $regionCode)
    {
        $params = Functions::getActionParams($this, __FUNCTION__, func_get_args());

        $groups = FindArticulModel::getArticulModificationGroups($articul, $modificationCode, $regionCode);

        $oFindArticul = new FindArticul($articul);
        $oRegion = new Region($regionCode);
        $oRegion->setName($regionCode);
        $oFindArticul->setActiveRegion($oRegion);

        if(empty($groups)){
            throw new CHttpException("Ошибка в выборе групп.");
        } else {
            $oFindArticul->setGroups($groups);
        }

        $this->render('modification_groups', array('oFindArticul'=>$oFindArticul, 'params'=>$params));
    }

    public function actionArticulGroupSubGroups($articul, $modificationCode, $regionCode, $groupCode)
    {
        $params = Functions::getActionParams($this, __FUNCTION__, func_get_args());
        $subGroups = FindArticulModel::getArticulModificationSubGroups($articul, $modificationCode, $regionCode, $groupCode);

        $oFindArticul = new FindArticul($articul);

        $oGroup = new Group();
        $oGroup->setCode($groupCode);
        $oGroup->setName(Functions::getGroupName($groupCode));
        if(empty($subGroups)){
            throw new CHttpException("Ошибка в выборе подгрупп.");
        } else {
            $oGroup->setSubGroups($subGroups);
        }
        $oFindArticul->setActiveGroup($oGroup);

        $oModification = new Modification();
        $oModification->setCode($modificationCode);
        $oFindArticul->setActiveModification($oModification);

        $oRegion = new Region($regionCode);
        $oFindArticul->setActiveRegion($oRegion);

        $this->render('group_subgroups', array('oFindArticul'=>$oFindArticul, 'params'=>$params));

    }

    public function actionArticulSubgroupSchemas($articul)
    {
        $params = Functions::getActionParams($this, __FUNCTION__, func_get_args());
        $oFindArticul = new FindArticul($articul);
        $this->render('subgroup_schemas', array('oFindArticul'=>$oFindArticul, 'params'=>$params));
    }
}