<?php

class articulsListWidget extends CWidget
{

    public $tableId;
    public $articulsList;
    public $activeArticulCode;

    public function init()
    {

    }

    public function run()
    {
        $this->runWidget();
    }

    public function runWidget()
    {

        echo '<table class="table" id="' . $this->tableId . '">
            <thead>
            <tr>
                <th>Артикул</th>
                <th>' . Functions::QUANTITY . '</th>
                <th>' . Functions::PROD_START . '</th>
                <th>' . Functions::PROD_END . '</th>
                <th>Примечание</th>
        </tr>
        </thead>
        <tbody>';
        foreach($this->articulsList as $articul):
            $link = '<a href=' . Yii::app()->params['outUrl'] . $articul->getCode() .'target="_blank" >'. $articul->getCode() . '</a>';
            if($this->activeArticulCode == $articul->getCode()):
                $link = '<strong>'. $link . '</strong>';
            endif;
            echo '<tr>
                <td>' . $link . '</td>';
                foreach($articul->getOptions() as $name=>$value):
                    if($name == Functions::PROD_START || $name == Functions::PROD_END):
                        echo '<td>' . Functions::prodToDate($value) . '</td>';
                    else:
                        echo '<td>'. $value . '</td>';
                    endif;
                endforeach;
                echo '<td>' . $articul->getRuname() . '</td>
            </tr>';
        endforeach;
        echo '</tbody>
        </table>';

    }


} 