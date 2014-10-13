<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

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

        $this->render('index', array('aCatalogs'=>$aCatalogs));
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
            'index', array(
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
            'index', array(
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
                $max = 2;
                break;
            case 2:
                $min = 3;
                $max = 4;
                break;
            case 3:
                $min = 5;
                $max = 7;
                break;
            case 4:
                $min = 8;
                $max = 9;
                break;
        }

        $oPartCodes = new PartCodes();

        $aPartGroups = $oPartCodes->getPartGroupsByCatalogCode($catalog, $catalogCode, $min, $max);

        $this->render(
            'index', array(
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

    public function actionPncs($catalog, $catalogCode, $cd, $modelName, $modelCode, $groupNumber, $partGroup){

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
        $aPgPictures = $oPgPictures->getPgPictures($catalog, $catalogCode, $partGroup);

        $oImages = new Images();

        foreach($aPgPictures as &$aPgPicture){
            $aCoords = $oImages->getCoords($catalog, $cd, $aPgPicture['pic_code']);
            $aPgPicture['pnc_list'] = array();
            $aPgPicture['pncs'] = array();
            $aPgPicture['general'] = array();
            $aPgPicture['groups'] = array();
            foreach($aCoords as $aCoord){
                if(in_array($aCoord['label2'], $aPncCodes)){
                    $aPgPicture['pncs'][] = $aCoord;
                    $aPgPicture['pnc_list'][$aCoord['label2']] = $aCoord['label2'];
                } elseif (strlen($aCoord['label2'])>4) {
                    $aPgPicture['general'][] = $aCoord;
                } else {
                    $aPgPicture['groups'][$aCoord['label2']] = $aCoord;
                }
            }
        }

        $this->render(
            'index', array(
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
                'aPgPictures'=>$aPgPictures
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

            echo "Название модели: " . $aModelName['model_name'] . "<br/>";
            echo "Код модели: " . $aData['model_code'] . "<br/>" .
                 "Период выпуска: " . Functions::prodToDate($aComplectation['prod_start']) . " - " . Functions::prodToDate($aComplectation['prod_end']) . "<br/>" .
                 "Дата производства: " . Functions::prodToDate($aData['vdate']) . "<br/>" .
                 "Цвет кузова: " . $aData['body_color'] . "<br/>" .
                 "Цвет интерьера: " . $aData['inter_color'] . "<br/>" .
                 "Двигатель: " . $aComplectation['engine1'] . "<br/>";
            echo $aComplectation['body'] ? "Кузов: " . $aComplectation['body'] . '<br/>':'';
            echo "Класс модели: " . $aComplectation['grade'] . '<br/>';
            echo "Трансмиссия: " . $aComplectation['atm_mtm'] . '<br/>';
            echo "Кузов: " . $aComplectation['f1'] . '<br/>';
            echo CHtml::link('Каталог', array(
                'groups',
                'catalog'=>$aComplectation['catalog'],
                'cd'=>$aModelName['cd'],
                'catalogCode'=>$aComplectation['catalog_code'],
                'modelName'=>$aModelName['model_name'],
                'modelCode'=>$aData['model_code']));
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