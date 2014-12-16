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
         * Выборка регионов из базы данных для конкретного артикула
         */
        $aRegions = FindArticulModel::getRegions($articul);
        if(empty($aRegions)){
            throw new CHttpException("Запчасть с артикулом " .$articul. " отсутствует в каталоге.");
        } else {
            $oActiveRegion = Factory::createRegion();
            /*
             * Если регионы найдены, они помещаются в контейнер
             */
            $oContainer = Factory::createContainer()
                ->setActiveArticul(Factory::createArticul($articul))
                ->setRegions($aRegions, $oActiveRegion);
            /*
             * Если пользователь задал регион, то этот регион становится активным
             */
            if (!is_null($regionCode)){
                $oActiveRegion->setCode($regionCode);
            } else{
                /*
                 * Если пользователь не задавал регион, то в качестве активного выбирается первый из списка регионов объект
                 */
                $regions = $oContainer->getRegions();
                $oActiveRegion->setCode($regions[0]->getCode());
            }

            $oActiveRegion->setName($oActiveRegion->getCode());
            /*
             * Выборка моделей из базы для данного артикула и региона
             */
            $models = FindArticulModel::getActiveRegionModels($articul, $oActiveRegion->getCode());

            if(empty($models)){
                throw new CHttpException("Ошибка в выборе моделей для региона: " . $oActiveRegion->getRuname());
            } else {
                $oActiveRegion->setModels($models, Factory::createModel());
            }

            $oContainer->setActiveRegion($oActiveRegion);

        }

        $this->render('01_regions_models', array('oContainer'=>$oContainer));
    }

    public function actionArticulModelModifications()
    {
        if(Yii::app()->request->isAjaxRequest){

            $articul = Yii::app()->request->getPost('articul');
            $regionCode = Yii::app()->request->getPost('region');
            $modelCode = Yii::app()->request->getPost('model');

            if($articul && $regionCode && $modelCode){
                $oModel = Factory::createModel($modelCode);
                $modifications = FindArticulModel::getActiveModelModifications($articul, $regionCode, $modelCode);
                if(empty($modifications)){
                    throw new CHttpException("Ошибка в выборе модификаций для модели: " . $modelCode);
                } else {
                    $oModel->setModifications($modifications, Factory::createModification());
                }
                $oContainer = Factory::createContainer()
                    ->setActiveArticul(Factory::createArticul($articul))
                    ->setActiveRegion(Factory::createRegion($regionCode))
                    ->setActiveModel($oModel);

                $this->renderPartial('02_modifications', array('oContainer'=>$oContainer));
            } else {
                throw new CHttpException("Ошибка в передаче данных.");
            }
        }
    }

    public function actionComplectations($articul, $modificationCode, $regionCode){

        $params = Functions::getActionParams($this, __FUNCTION__, func_get_args());

        $complectations = FindArticulModel::getComplectations($modificationCode, $regionCode);

        if(empty($complectations)){
            throw new CHttpException("Ошибка в выборе комплектаций для модификации: " . $modificationCode);
        } else {
            $oModification = Factory::createModification($modificationCode)->setComplectations($complectations, Factory::createComplectation());
        }

        $oContainer = Factory::createContainer($articul)
            ->setActiveRegion(Factory::createRegion($regionCode, $regionCode))
            ->setActiveModification($oModification);

        $this->render('03_complectations', array('oContainer'=>$oContainer, 'params'=>$params));
    }

    public function actionGroups($articul, $modificationCode, $regionCode, $complectationCode)
    {
        $params = Functions::getActionParams($this, __FUNCTION__, func_get_args());

        $groups = FindArticulModel::getGroups($articul, $modificationCode, $regionCode);

        $oContainer = Factory::createContainer($articul)->setActiveRegion(Factory::createRegion($regionCode, $regionCode));

        if(empty($groups)){
            throw new CHttpException("Ошибка в выборе групп.");
        } else {
            $oContainer->setGroups($groups, Factory::createGroup());
        }

        $this->render('04_groups', array('oContainer'=>$oContainer, 'params'=>$params));
    }

    public function actionSubgroups($articul, $modificationCode, $regionCode, $groupCode, $complectationCode)
    {
        $params = Functions::getActionParams(__CLASS__, __FUNCTION__, func_get_args());
        $subGroups = FindArticulModel::getArticulModificationSubGroups($articul, $modificationCode, $regionCode, $groupCode);

        $oContainer = Factory::createContainer($articul);

        $oGroup = Factory::createGroup($groupCode, Functions::getGroupName($groupCode));

        if(empty($subGroups)){
            throw new CHttpException("Ошибка в выборе подгрупп.");
        } else {
            $oGroup->setSubGroups($subGroups);
        }

        $oContainer->setActiveGroup($oGroup);

        $oContainer->setActiveModification(Factory::createModification($modificationCode));

        $oContainer->setActiveRegion(Factory::createRegion($regionCode));

        $this->render('05_subgroups', array('oContainer'=>$oContainer, 'params'=>$params));

    }

    public function actionSchemas($articul, $regionCode, $modificationCode, $subGroupCode, $complectationCode)
    {
        $params = Functions::getActionParams(__CLASS__, __FUNCTION__, func_get_args());

        $schemas = FindArticulModel::getSchemas($regionCode, $modificationCode, $subGroupCode, $complectationCode);
        $modification = FindArticulModel::getModification($regionCode, $modificationCode);

        $oContainer = Factory::createContainer($articul)
            ->setActiveRegion(Factory::createRegion($regionCode))
            ->setActiveModification(Factory::createModification($modificationCode, $modificationCode)->setOptions(array(Functions::CD=>$modification[$modificationCode]['options'][Functions::CD])));

        if(empty($schemas)){
            throw new CHttpException('Ошибка в выборе набора схем.');
        } else {
            $oContainer->setSchemas($schemas, Factory::createSchema());
        }

        $this->render('06_schemas', array('oContainer'=>$oContainer, 'params'=>$params));
    }

    public function actionSchema($articul, $schemaCode, $regionCode, $modificationCode, $subGroupCode, $cd, $complectationCode)
    {
        $params = Functions::getActionParams(__CLASS__, __FUNCTION__, func_get_args());

        $pncCode = FindArticulModel::getPnc($articul, $regionCode, $modificationCode, $subGroupCode);

        $pncs = FindArticulModel::getPncs($schemaCode, $regionCode, $modificationCode, $subGroupCode, $cd);

        $commonArticuls = FindArticulModel::getCommonArticuls($schemaCode, $regionCode, $cd);

        $refGroups = FindArticulModel::getRefGroups($schemaCode, $regionCode, $cd);

        $oSchema = Factory::createSchema($schemaCode);

        if(!empty($pncs)){
            $oSchema->setPncs($pncs, Factory::createPnc());
        }

        if(!empty($commonArticuls)){
            $oSchema->setCommonArticuls($commonArticuls, Factory::createArticul());
        }

        if(!empty($refGroups)){
            $oSchema->setRefGroups($refGroups, Factory::createGroup());
        }

        $oContainer = Factory::createContainer()
            ->setActiveArticul(Factory::createArticul($articul))
            ->setActiveSchema($oSchema)
            ->setActiveRegion(Factory::createRegion($regionCode))
            ->setActivePnc(Factory::createPnc($pncCode)
                ->setArticuls(FindArticulModel::getArticuls($regionCode, $modificationCode, $pncCode, $complectationCode), Factory::createArticul())
            );

        $this->render('07_schema', array('oContainer'=>$oContainer, 'params'=>$params));
    }
}