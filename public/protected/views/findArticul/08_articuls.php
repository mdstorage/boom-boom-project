<?php $this->widget('articulsListWidget', array(
    'tableId'=>$oContainer->getActivePnc()->getCode(),
    'articulsList'=>$oContainer->getActivePnc()->getArticuls()
        )
    );
