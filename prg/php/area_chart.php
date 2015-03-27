<?php

new AREA_CHART();

class AREA_CHART{

	function __construct(){
		if($_REQUEST['mode']=="load_chart"){

			$test = array(array("Day","PV","UU"));

			$datas = $this->getData();

			for($i=0;$i<count($datas);$i++){
				$test[] = $datas[$i];
			}

			//print_r($test);
			//echo json_encode($datas);exit();
			echo json_encode($test);

			exit();
		}
	}

	function getData(){
		$lists = scanDir("data");
		$datas= array();
		//$pvs = array();
		//$uus = array();
		for($i=0;$i<count($lists);$i++){
			if($lists[$i]=="." || $lists[$i]==".."){continue;}

			unset($data);
			exec("awk -F, '{print $4}' "."data/".$lists[$i]."|wc -l" , $data);
			$num1 = (int)trim($data[0]);
			//array_push($pvs,$num1);

			unset($data);
			exec("awk -F, '{print $4}' "."data/".$lists[$i]."|sort|uniq|wc -l" , $data);
			$num2 = (int)trim($data[0]);
			//array_push($uus,$num2);

			$date = str_replace(".log","",$lists[$i]);

			$datas[] = array($date,$num1,$num2);
		}
		return $datas;
	}
}
