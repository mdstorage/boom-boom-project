<?php

class SiteController extends Controller
{


	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$oModels = new Models();

        $aCatalogs = $oModels->getCatalogs();

        foreach($aCatalogs as &$aCatalog){
            $aCatalog = $aCatalog['catalog'];
        }

        $this->render('vybor_regiona', array('aCatalogs'=>$aCatalogs));
	}

    public function actionModelNames($catalog){
        $oModels = new Models();

        $aModelNames = $oModels->getModelNames($catalog);
        foreach($aModelNames as &$modelName){
            $modelName = $modelName['model_name'];
        }
        $aModelNameCodes = array();
        foreach($aModelNames as $modelName){
            $aModelNameCodes[$modelName] = $oModels->getModelNameCodes($modelName, $catalog);
        }
        $this->render(
            'vybor_modeli_2', array(
                'aModelNames'=>$aModelNames,
                'sCatalog'=>$catalog,
                'aModelNameCodes'=>$aModelNameCodes
                )
        );
    }

    public function actionModelCodes($catalog, $cd, $catalogCode, $modelName)
    {
        $oModelCodes = new ModelCodes();

        $aModelCodes = $oModelCodes->getModelCodes($catalog, $catalogCode);

        $this->render(
            'vybor_modifikacii', array(
                'sModelName'=>$modelName,
                'sCatalog'=>$catalog,
                'sCd'=>$cd,
                'aModelCodes'=>$aModelCodes
            )
        );
    }

    public function actionGroups($catalog, $cd, $catalogCode, $modelName, $modelCode)
    {
        $this->render('index', array('groups'=>1, 'sCatalog'=>$catalog, 'sCd'=>$cd, 'sCatalogCode'=>$catalogCode, 'sModelName'=>$modelName, 'sModelCode'=>$modelCode));
    }

    public function actionSubGroups($catalog, $catalogCode, $cd, $modelName, $modelCode, $groupNumber)
    {
        switch ($groupNumber){
            case 1:
                $min = 0;
                $max = 0;
                break;
            case 2:
                $min = 1;
                $max = 1;
                break;
            case 3:
                $min = 2;
                $max = 2;
                break;
            case 4:
                $min = 3;
                $max = 4;
                break;
            case 5:
                $min = 5;
                $max = 7;
                break;
            case 6:
                $min = 8;
                $max = 9;
                break;
        }

        $oPartCodes = new PartCodes();

        $aPartGroups = $oPartCodes->getPartGroupsByCatalogCode($catalog, $catalogCode, $min, $max);


        $this->render(
            'part_groups', array(
                'groupNumber'=>$groupNumber,
                'sCatalog'=>$catalog,
                'sCd'=>$cd,
                'sCatalogCode'=>$catalogCode,
                'sModelName'=>$modelName,
                'sModelCode'=>$modelCode,
                'aPartGroups'=>$aPartGroups
            )
        );

    }

    public function actionSchemas($catalog, $cd, $catalogCode, $modelName, $modelCode, $groupNumber, $partGroup)
    {
        $oPgPictures = new PgPictures();
        $aPgPictures = $oPgPictures->getPgPictures($catalog, $catalogCode, $partGroup, 30, 0);
        $iCountPictures = $oPgPictures->getCountPgPictures($catalog, $catalogCode, $partGroup);

        $this->render(
            'schemas', array(
                'aPgPictures'=>$aPgPictures,
                'iCountPictures'=>$iCountPictures,
                'sCatalog'=>$catalog,
                'sCd'=>$cd,
                'groupNumber'=>$groupNumber,
                'sCatalogCode'=>$catalogCode,
                'sModelName'=>$modelName,
                'sModelCode'=>$modelCode,
                'partGroup'=>$partGroup
            )
        );
    }

    public function actionPncs($catalog, $catalogCode, $cd, $modelName, $modelCode, $groupNumber, $partGroup, $page){

        $oPartCodes = new PartCodes();
        $aPncs = $oPartCodes->getPncs($catalog, $catalogCode, $partGroup);
        $aPncCodes = array();
        foreach($aPncs as $aPnc){
            $aPncCodes[] = $aPnc['pnc'];
        }

        $oPartCatalog = new PartCatalog();
        $aPartCatalog = array();
        foreach($aPncs as $aPnc){
            $aPartCatalog[$aPnc['pnc']] = $oPartCatalog->getPartCodesByPnc($catalog, $catalogCode, $aPnc['pnc']);
        }

        $oPartGroups = new PartGroups();
        $sPartGroupDescEn = $oPartGroups->getPartGroupDescEn($catalog, $partGroup);

        $oPgPictures = new PgPictures();
        $aPgPictures = $oPgPictures->getPgPictures($catalog, $catalogCode, $partGroup, 1, $page-1);
        $iCountPictures = $oPgPictures->getCountPgPictures($catalog, $catalogCode, $partGroup);

        $oImages = new Images();

        foreach($aPgPictures as &$aPgPicture){
            $aCoords = $oImages->getCoords($catalog, $cd, $aPgPicture['pic_code']);
            $aPgPicture['pnc_list'] = array();
            $aPgPicture['pncs'] = array();
            $aPgPicture['general'] = array();
            $aPgPicture['groups'] = array();
            $aPgPicture['groups_list'] = array();
            foreach($aCoords as $aCoord){
                if(in_array($aCoord['label2'], $aPncCodes)){
                    $aPgPicture['pncs'][] = $aCoord;
                    $aPgPicture['pnc_list'][$aCoord['label2']] = $aCoord['label2'];
                } elseif (strlen($aCoord['label2'])>4) {
                    $aPgPicture['general'][] = $aCoord;
                } else {
                    $aPgPicture['groups'][] = $aCoord;
                    $aPgPicture['groups_list'][$aCoord['label2']] = $aCoord;
                }
            }
        }

        $this->render(
            'part_codes', array(
                'groupNumber'=>$groupNumber,
                'sCatalog'=>$catalog,
                'sCd'=>$cd,
                'sCatalogCode'=>$catalogCode,
                'sModelName'=>$modelName,
                'sModelCode'=>$modelCode,
                'sPartGroup'=>$partGroup,
                'sPartGroupDescEn'=>$sPartGroupDescEn,
                'aPncs'=>$aPncs,
                'aPartCatalog'=>$aPartCatalog,
                'aPgPictures'=>$aPgPictures,
                'iCountPictures'=>$iCountPictures
            )
        );

    }
    public function actionFindByVin()
    {
        $request = Yii::app()->getRequest();
        $oComplectations = new Complectations();
        if ($request->isAjaxRequest){
            if (!empty($_POST['value'])){
                $value = $_POST['value'];
                $vin8 = substr($value, 0, 8);
                $serialNumber = substr($value, 10, 7);
                $frame = $oComplectations->getFrameByVin8($vin8);
            }

            if(!empty($_POST['frame']) && !empty($_POST['serial'])) {
                $frame = $_POST['frame'];
                $serialNumber = $_POST['serial'];
            }

            $oFrames = new Frames();
            $aData = $oFrames->getDataByFrameAndSerial($frame, $serialNumber);
            if (empty($aData)){
                die('Ничего не найдено. Проверьте введенные данные.');
            }

            $aComplectation = $oComplectations->getComplectationByModelCode($aData['model_code']);

            $oModels = new Models();
            $aModelName = $oModels->getModelNameByCodes($aComplectation['catalog'], $aComplectation['catalog_code']);

            echo "<br/>Название модели: <b>" . $aModelName['model_name'] . "</b><br/>";
            echo "Код модели: <b>" . $aData['model_code'] . "</b><br/>" .
                 "Период выпуска: <b>" . Functions::prodToDate($aComplectation['prod_start']) . " - " . Functions::prodToDate($aComplectation['prod_end']) . "</b><br/>" .
                 "Дата производства: <b>" . Functions::prodToDate($aData['vdate']) . "</b><br/>" .
                 "Цвет кузова: <b>" . $aData['body_color'] . "</b><br/>" .
                 "Цвет интерьера: <b>" . $aData['inter_color'] . "</b><br/>" .
                 "Двигатель: <b>" . $aComplectation['engine1'] . "</b><br/>";
            echo $aComplectation['body'] ? "Кузов: <b>" . $aComplectation['body'] . '</b><br/>':'';
            echo "Класс модели: <b>" . $aComplectation['grade'] . '</b><br/>';
            echo "Трансмиссия: <b>" . $aComplectation['atm_mtm'] . '</b><br/>';
            echo "Кузов: <b>" . $aComplectation['f1'] . '</b><br/><br/>';
             echo CHtml::link('Перейти в каталог', array(
                'groups',
                'catalog'=>$aComplectation['catalog'],
                'cd'=>$aModelName['cd'],
                'catalogCode'=>$aComplectation['catalog_code'],
                'modelName'=>$aModelName['model_name'],
                'modelCode'=>$aData['model_code']),
                array('class'=>'btn btn-default btn-lg')
                );
        }
    }

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}