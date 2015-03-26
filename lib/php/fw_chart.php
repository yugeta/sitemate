<?php

class fw_chart{
    function getGoogleChart(){
        //sample
        //http://chart.apis.google.com/chart?chs=150x150&chd=t:78.0,32.0,84.0&cht=lc

        $google = "http://chart.apis.google.com/chart?chs=700x200&cht=lc&chd=t:";
        $pvs = array();
        $uus = array();
        $lists = scanDir("data");
        for($i=0;$i<count($lists);$i++){
            if($lists[$i]=="." || $lists[$i]==".."){continue;}

            unset($data);
            exec("awk -F, '{print $4}' "."data/".$lists[$i]."|wc -l" , $data);
            $num = trim($data[0]);
            array_push($pvs,$num);

            unset($data);
            exec("awk -F, '{print $4}' "."data/".$lists[$i]."|sort|uniq|wc -l" , $data);
            $num = trim($data[0]);
            array_push($uus,$num);

        }

        return $google.join(",",$pvs);
    }
}
