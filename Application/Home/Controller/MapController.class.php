<?php
namespace Home\Controller;
use Think\Controller;
class MapController extends Controller {
     public $city;
    public function index(){
        $cname = "德州 ";
        $key = "2b9c7706ab44c6df65a194bcb9f5b030";
        $url = "http://restapi.amap.com/v3/geocode/geo?address=德州&output=json&key=".$key;

        $xy = "116.3799655,37.50744495";
        // $url = "http://restapi.amap.com/v3/geocode/regeo?output=json&location=".$xy."&key=".$key."&radius=1000&extensions=all";
        // $data = file_get_contents($url);
     //    echo $url;die;
        // $str = iconv( 'GB2312','UTF-8', $str);
        // $url="http://restapi.amap.com/v3/geocode/geo?address=".$str."&output=json&key=".$key;
    $content = file_get_contents($url);
            //初始化
            // 　　$ch = curl_init();
            //     curl_setopt($ch, CURLOPT_URL, $url);
            //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);    // 要求结果为字符串且输出到屏幕上
            //     curl_setopt($ch, CURLOPT_HEADER, 0); // 不要http header 加快效率
            //     curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
            //     curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            //     $output = curl_exec($ch);
            //     curl_close($ch);
            //     var_dump($output);die;

        echo "<pre>";
        $a = json_decode($content);
        dump($a->geocodes[0]->location);
        dump($a->regeocode->addressComponent->adcode);
        dump($a->geocodes[0]->location);
        
        $this->display();
    }

    // 根据坐标找位置
    public function cankao()
    {
        $this->display();
    }

    // 点击出坐标
    public function cankao2()
    {

        // 根据ip获取城市
        $key = "2b9c7706ab44c6df65a194bcb9f5b030";
        
        // $url = "http://restapi.amap.com/v3/ip?ip=".$this->getip()."&output=json&key=".$key;
        $url = "http://restapi.amap.com/v3/ip?ip=222.174.55.106&output=json&key=".$key;
        $city = file_get_contents($url);
        $city = json_decode($city);
        // dump($city->adcode); // 城市id
        // dump($city->city);  //城市名称
        // dump($city->rectangle);die;
        $z = $city->rectangle;
        $zb[] = explode(';',$z);
        $x = explode(',',$zb[0][1]);

        
        // 根据城市获取坐标
        $url = "http://restapi.amap.com/v3/geocode/geo?address=".$city->city."&output=json&key=".$key;
        $xy = file_get_contents($url);
        $xy = json_decode($xy);

        dump($xy->geocodes[0]->location); //坐标
        
        $arr = array(
                    'city_id' => $city->adcode,
                    'city_name' => $city->city
                );
        dump($arr);
        $ret=array(0=>'37.470679,116.33624',1=>'37.483757,116.350317',2=>'37.428633,116.393154');
        $this->assign('xy',json_encode($ret));
        $this->assign('len',count($ret));
        $this->assign('city_id',$city->adcode);

        $this->display();
    }

    // 获取ip
    public function getip() 
    {
        if (getenv ( 'HTTP_CLIENT_IP' ) && strcasecmp ( getenv ( 'HTTP_CLIENT_IP' ), 'unknown' )) {
            $cip = getenv ( 'HTTP_CLIENT_IP' );
        } elseif (getenv ( 'HTTP_X_FORWARDED_FOR' ) && strcasecmp ( getenv ( 'HTTP_X_FORWARDED_FOR' ), 'unknown' )) {
            $cip = getenv ( 'HTTP_X_FORWARDED_FOR' );
        } elseif (getenv ( 'REMOTE_ADDR' ) && strcasecmp ( getenv ( 'REMOTE_ADDR' ), 'unknown' )) {
            $cip = getenv ( 'REMOTE_ADDR' );
        } elseif (isset ( $_SERVER ['REMOTE_ADDR'] ) && $_SERVER ['REMOTE_ADDR'] && strcasecmp ( $_SERVER ['REMOTE_ADDR'], 'unknown' )) {
            $cip = $_SERVER ['REMOTE_ADDR'];
        }
        preg_match ( "/[\d\.]{7,15}/", $cip, $cips );
        $cip = isset ( $cips [0] ) ? $cips [0] : 'unknown';
        unset ( $cips );
        return $cip;
        // dump($cip);
    }

    // 根据ip获取地址
    public function city()
    {
        $key = "2b9c7706ab44c6df65a194bcb9f5b030";
        
        // $url = "http://restapi.amap.com/v3/ip?ip=".$this->getip()."&output=json&key=".$key;
        $url = "http://restapi.amap.com/v3/ip?ip=58.58.32.0&output=json&key=".$key;

        $data = file_get_contents($url);
        $a = json_decode($data);
        dump($a->adcode);
        // echo "<pre>";
        // dump($data);
        
    }

    // 根据提交的坐标查询位置名称
    public function sub()
    {
        $key = "2b9c7706ab44c6df65a194bcb9f5b030";
        $lon = I('post.lon');
        $lat = I('post.lat');
        $city_id = I('city_id');
        dump($city_id);
        $url = "http://restapi.amap.com/v3/geocode/regeo?output=json&location=".$lon.','.$lat."&key=".$key."&radius=1000&extensions=all";
        $data = file_get_contents($url);
        $datas = json_decode($data);

        // dump($datas->regeocode->addressComponent->city);die;   //获取 市名
        // dump($datas->regeocode->formatted_address);
        // dump($datas->regeocode->pois);
        $result = $datas->regeocode->pois; //一堆地址

        $arr = array();
        foreach ($result as $key => $value) {
            // $v = (array)$value;
            // dump($v);
            // $arr = array_rand($v,1);
            // dump($value->name);
            $arr[] = $value->name;

        }
            $key = array_rand($arr,1);

        dump($arr[$key]);
        dump($datas->regeocode->formatted_address);
        
        // dump($arr2);

    }   


    // ok完成版
    public function ok()
    {
        $this->display();
    }

    // 执行添加
    public function okAdd()
    {
      

        header("Content_type:text/html;charset=utf-8");
        $api_key = "2b9c7706ab44c6df65a194bcb9f5b030";
        // http://restapi.amap.com/v3/geocode/regeo?output=json&location=116.357464,37.434092&key=2b9c7706ab44c6df65a194bcb9f5b030&radius=1000&extensions=all
        $data = I('post.list');
        
        
        foreach ($data as $key => $value) {
            
            // array_pop($value);   //因为传来 的 最后一个值多余  清除最后一个
            

            foreach ($value as $key2 => $value2) {
                
                $url = "http://restapi.amap.com/v3/geocode/regeo?output=json&location=".$value2['lng'].','.$value2['lat']."&key=".$api_key."&radius=1000&extensions=all";

                $result = file_get_contents($url);

                $re = json_decode($result);
                $city_id = $re->regeocode->addressComponent->adcode;
                // dump($re->regeocode->addressComponent->adcode);die;   //城市ID

                $cname = iconv( 'UTF-8','GB2312', $re->regeocode->addressComponent->city);  //城市名称
                
                 $this->city = $cname;
                $str = $re->regeocode->formatted_address;  //大范围地址
                $detail = $re->regeocode->pois; //一堆地址
                
                foreach ($detail as $key3 => $value3) {
                    $arr = array();
                    $arr[] = $value3->name;
                }

                $k = array_rand($arr,1);

                // echo iconv( 'UTF-8','GB2312', $str)."<br>";  //大范围
                // echo iconv( 'UTF-8','GB2312', $arr[$k])."<br>";  //详细
                $sitename = iconv( 'UTF-8','GB2312', $str) . iconv( 'UTF-8','GB2312', $arr[$k]);
                
                echo  "sitename = ".$sitename."<br>"; 
                echo 'position = '.$value2['lng'].','.$value2['lat']."<br>";
                echo 'city_id = '.$city_id."<br>";
                
             //    echo $url;die;
                // $str = iconv( 'GB2312','UTF-8', $str);
                // $url="http://restapi.amap.com/v3/geocode/geo?address=".$str."&output=json&key=".$key;
            }     
            
            // $this->ajaxReturn($ajax);
        }
        
    }

    // 修改时显示所有的标记
    public function up()
    {
        $this->display();
    }


    // 坐标连线
    public function lianxian()
    {
        $ret=array(0=>'37.470679,116.33624',1=>'37.483757,116.350317');
        $this->assign('xy',json_encode($ret));
        $this->assign('len',count($ret));
        $this->display();
    }

    // 点击出坐标搜索地名
    public function dd()
    {
        $this->display();
    }

}