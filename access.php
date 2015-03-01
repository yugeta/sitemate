<?php

date_default_timezone_set('Asia/Tokyo');

$access = new ACCESS();

$access->index();

class ACCESS{

    //計測初回処理
    function index(){

        //ユニークユーザー処理
        $uu = $this->uu();

        //日時取得
        list($date,$time,$msec) = $this->getDatetime();

        //UA崇徳
        $ua = $this->changeString($_SERVER["HTTP_USER_AGENT"]);
        //IP
        $ip = $_SERVER["REMOTE_ADDR"];
        //url
        //$url = $this->changeString($this->getUri());
        $url = $this->changeString($_SERVER["HTTP_REFERER"]);

        $this->setLog($_REQUEST["user"].",".$time.",".$msec.",".$uu.",".$ip.",".$url.",".$ua);

        //echo "finish";
        header("Content-Type: text/javascript");
        //header("Content-Type: image/jpeg");
    }
    //ログ書き込み
    function setLog($log){
        $dir = "data/";

        //フォルダ確認
        if(!is_dir($dir)){
            mkdir($dir,0777,true);
        }

        //データ書き込み
        file_put_contents($dir.date("Ymd").".log" , $log."\n" , FILE_APPEND);
    }
    //文字列置換(,)
    function changeString($str){
        $arr = explode(",",$str);
        $str = join("&#44;",$arr);
        return $str;
    }

    function getDatetime(){
        //日時取得
        $date = date("Ymd");
        //時刻取得
        $time = date("His");
        //マイクロタイム取得
        list($usec, $sec) = explode(" ", microtime());
        list($sec0,$msec) = explode(".",$usec);

        return array($date,$time,$msec);
    }

    function uu(){
        //cookie読み込み(3rd-party)
        $cookie = $_COOKIE["__a"];

        //初回の場合cookie作成
        if(!$cookie){
            list($date,$time,$msec) = $this->getDatetime();
            $cookie = $date.$time.".".$msec;
            //$_COOKIE["__a"] = $cookie;
        }

        //cookie書き込み(3rd-party) *有効期間は365日
        setcookie("__a",$cookie,time()+365*24*60*60);
        //$_COOKIE["__a"] = $cookie;
        //$_COOKIE["__b"] = $cookie;

        return $cookie;
    }

    //port + domain [http://hoge.com:8800/]
    //現在のポートの取得（80 , 443 , その他）
    function getSite(){
        //通常のhttp処理
        if($_SERVER['SERVER_PORT']==80){
            $site = 'http://'.$_SERVER['SERVER_NAME'];
        }
        //httpsページ処理
        else if($_SERVER['SERVER_PORT']==443){
            $site = 'https://'.$_SERVER['SERVER_NAME'];
        }
        //その他ペート処理
        else{
            $site = 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'];
        }

        return $site;
    }
    //フルパスを返す
    function getUri(){
        $uri = $this->getSite();
        if($_SERVER['REQUEST_URI']){
            $uri.= $_SERVER['REQUEST_URI'];
        }
        else{
            $uri = $this->getUrl.(($_SERVER['QUERY_STRING'])?"?".$_SERVER['QUERY_STRING']:"");
        }
        return $uri;
    }
}
