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
    /*
     * Возвращает картинку со списком pnc, part_codes для каждой pnc, общих для всех групп part_codes
     */
    public function actionPncs($catalog, $catalogCode, $cd, $modelName, $modelCode, $groupNumber, $partGroup, $page){

        $oPartCodes = new PartCodes();
        /*
         * array $aPncs
         * Множество pnc, которые входят в данную группу, и их описаний.
         * Структура:
         * array (
              0 =>
              array (
                'pnc' => '81510',
                'desc_en' => '81510 LAMP ASSY, FRONT TURN SIGNAL, RH',
              ),
              1 =>
              array (
                'pnc' => '81510B',
                'desc_en' => '81510B BULB (FOR FRONT TURN SIGNAL LAMP)',
              ),
            )
         */
        $aPncs = $oPartCodes->getPncs($catalog, $catalogCode, $partGroup);
        /*
         * array $aPncCodes
         * Индексный массив pnc
         * array (
              0 => '81510',
              1 => '81510B',
            )
         */
        $aPncCodes = array();
        foreach($aPncs as $aPnc){
            $aPncCodes[] = $aPnc['pnc'];
        }

        $oPartCatalog = new PartCatalog();
        /*
         * array $aPartCatalog
         * Вложенный ассоциативный массив. Ключи первого уровня: Pnc.
         * Второй уровень: принадлежащие конкретному pnc part_codes с характеристиками
         * array (
              81510 =>
              array (
                0 =>
                array (
                  'part_code' => '8151020650',
                  'quantity' => '01',
                  'start_date' => '199202',
                  'end_date' => '199402',
                  'add_desc' => 'ST191..JPP..RHD..SED..GL HONG KONG SPEC',
                ),
                1 =>
                array (
                  'part_code' => '8151020660',
                  'quantity' => '01',
                  'start_date' => '199202',
                  'end_date' => '199601',
                  'add_desc' => 'AT190,CT190,ST191..JPP',
                ),
              ),
              '81510B' =>
              array (
                0 =>
                array (
                  'part_code' => '9913211210',
                  'quantity' => '02',
                  'start_date' => '199202',
                  'end_date' => '199601',
                  'add_desc' => 'AT190,CT190,ST191..JPP 12V 21W',
                ),
              ),
            )
         */
        $aPartCatalog = array();
        foreach($aPncs as $aPnc){
            $aPartCatalog[$aPnc['pnc']] = $oPartCatalog->getPartCodesByPnc($catalog, $catalogCode, $aPnc['pnc']);
        }

        $oPartGroups = new PartGroups();
        /*
         * string
         * Текстовое название группы запчастей
         */
        $sPartGroupDescEn = $oPartGroups->getPartGroupDescEn($catalog, $partGroup);

        $oPgPictures = new PgPictures();

        /*
         * array
         * Множество картинок (схем), имеющих отношение к группе запчастей
         * Потом этот массив дополнится значениями меток, имеющих отношение к
         * array (
              0 =>
              array (
                'pic_code' => 'MET403A',
              ),
            )
         */
        $aPgPictures = $oPgPictures->getPgPictures($catalog, $catalogCode, $partGroup, 1, $page-1);

        $iCountPictures = $oPgPictures->getCountPgPictures($catalog, $catalogCode, $partGroup);

        $oImages = new Images();

        foreach($aPgPictures as &$aPgPicture){
            /*
             * array $aCoords
             * Множество всех меток, изображенных на конкретной картинке.
             * Среди этих меток и pnc, и part_codes общих деталей, и номера связанных групп.
             * Все эти метки надо разделить по разным массивам, поскольку у них разные роли.
             * Структура:
             * array (
                  0 =>
                  array (
                    'x1' => '295',
                    'y1' => '467',
                    'x2' => '348',
                    'y2' => '484',
                    'label2' => '81510',
                    'desc_en' => 'LAMP ASSY, FRONT TURN SIGNAL, RH',
                  ),
                  1 =>
                  array (
                    'x1' => '370',
                    'y1' => '619',
                    'x2' => '421',
                    'y2' => '635',
                    'label2' => '81510',
                    'desc_en' => 'LAMP ASSY, FRONT TURN SIGNAL, RH',
                  ),
                )
             */
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

        /*
         * Измененный массив $aPgPicture
         * array (
              'pic_code' => 'MET513H',
              'pnc_list' =>
              array (
                85035 => '85035',
                85310 => '85310',
              ),
              'pncs' =>
              array (
                0 =>
                array (
                  'x1' => '549',
                  'y1' => '441',
                  'x2' => '603',
                  'y2' => '455',
                  'label2' => '85035',
                  'desc_en' => 'NOZZLE SUB-ASSY, WASHER',
                ),
                1 =>
                array (
                  'x1' => '608',
                  'y1' => '583',
                  'x2' => '662',
                  'y2' => '598',
                  'label2' => '85035',
                  'desc_en' => 'NOZZLE SUB-ASSY, WASHER',
                ),
              ),
              'general' =>
              array (
                0 =>
                array (
                  'x1' => '444',
                  'y1' => '628',
                  'x2' => '537',
                  'y2' => '642',
                  'label2' => '828172A290',
                  'desc_en' => false,
                ),
                1 =>
                array (
                  'x1' => '123',
                  'y1' => '327',
                  'x2' => '214',
                  'y2' => '341',
                  'label2' => '8533610010',
                  'desc_en' => false,
                ),
              ),
              'groups' =>
              array (
                8505 =>
                array (
                  'x1' => '36',
                  'y1' => '201',
                  'x2' => '121',
                  'y2' => '217',
                  'label2' => '8505',
                  'desc_en' => 'HEADLAMP CLEANER',
                ),
              ),
            )
         */

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