<?php

$viewIndex = new viewIndex();

$viewIndex->index();

class viewIndex{
    function index(){
        if(!is_dir("data")){return;}
        $lists = scanDir("data");
        $html = "";
        for($i=0;$i<count($lists);$i++){
            if($lists[$i]=="." || $lists[$i]==".."){continue;}
            $html.= "<tr>";
            $date = str_replace(".log","",$lists[$i]);
            $html.= "<td>".$date."</td>"."\n";

            unset($data);
            exec("awk -F, '{print $4}' ".$lists[$i]."|sort|uniq|wc -l" , $data);
            $html.= "<td>".$data[0]."</td>"."\n";

            $html.= "</tr>";
        }
    }
}
