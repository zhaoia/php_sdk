<?php

$app_key = 'your app_key';
$secretcode = 'your secretcode';

function createSign ($paramArr) { 
    global $secretcode; 
    $str = '';
    ksort($paramArr);
    foreach ($paramArr as $key => $val) { 
       if ($key !='' && $val !='') { 
           $str .= $key.'='.$val."&";
       } 
    }
    $str .= 'secretcode='.$secretcode; 
    $sign = strtoupper(md5($str));
    return $sign; 
}

function createStrParam ($paramArr) { 
    $strParam = ''; 
    foreach ($paramArr as $key => $val) { 
       if ($key != '' && $val != '') { 
           $strParam .= $key.'='.urlencode($val).'&'; 
       } 
    } 
    return $strParam; 
} 

function get_results ($params,$baseUrl){
    $sign = createSign($params);
    $strParam = createStrParam($params);
    $strParam .= 'sign='.$sign;
    $url = $baseUrl.$strParam;
    $result = file_get_contents($url);
    return $result;
}


function get_product_lists ($keyword,$page=1,$per_page=16,$sort=''){
    global $app_key;
    $params = array(
        'appkey' => $app_key,
        'keyword' => $keyword,
        'page' => $page,
        'per_page' => $per_page,
        'sort' => $sort
    );
    $baseUrl = 'http://www.zhaoia.com/service/get_product_lists?';
    $result = get_results($params,$baseUrl);
    return $result;
}

function get_product_info ($id){
    global $app_key;
    $params = array(
        'appkey' => $app_key,
        'id' => $id
    );
    $baseUrl = 'http://www.zhaoia.com/service/get_product_info?';
    $result = get_results($params,$baseUrl);
    return $result;
}

function get_related_product_lists ($id,$lsize=8){
    global $app_key;
    $params = array(
        'appkey'=>$app_key,
        'id'=>$id,
        'lsize'=>$lsize
    );
    $baseUrl = 'http://www.zhaoia.com/service/get_related_product_lists?';
    $result = get_results($params,$baseUrl);
    return $result;
}

function get_context_product_lists($keyword,$lurl,$lsize=8){
    global $app_key;
    $params = array(
        'appkey' => $app_key,
        'keyword' => $keyword,
        'url' => $lurl,
        'lsize' => $lsize
    );
    $baseUrl = 'http://www.zhaoia.com/service/get_context_product_lists?';
    $result = get_results($params,$baseUrl);
    return $result;
}

echo get_product_lists('dell',$page=2,$per_page=4,$sort='desc');
echo "\n";
echo "=====================================\n";
echo get_product_info('85f286c812340d61c727a427bd527566');
echo "\n";
echo "=====================================\n";
echo get_related_product_lists('85f286c812340d61c727a427bd527566',$lsize=2);
echo "\n";
echo "=====================================\n";
echo get_context_product_lists('Canon 佳能 EOS 500D 单反相机 套机 含18-55IS头 - 新蛋中国','http://www.newegg.com.cn/Product/90-c13-193.htm',$lsize=3);
echo "\n";

?>
