<?php
class Colors {
    
    function colors(){
        $headerBackground = 'purple';
        $bodyBackground = '#eee';
        $roomNameColor = "white";
        $headerControlButtonColor = 'indianred';


        $contentShareHeaderBackground = '#eee';
        $contentShareHeaderColor = 'purple';
        return array('bodyBackground'=>$bodyBackground,'headerBackground'=>$headerBackground,'roomNameColor'=>$roomNameColor,'headerControlButtonColor'=>$headerControlButtonColor,
            'contentShareHeaderBackground'=>$contentShareHeaderBackground,'contentShareHeaderColor'=>$contentShareHeaderColor
        );
    }
    
}

?>
