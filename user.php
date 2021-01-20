<?php
if(empty($_GET['token'])){
    $response2=[
        'errno'=>'40002',
        'mgs'=>'缺少token参数',
    ];
    die(json_encode($response,JSON_UNESCAPED_UNICODE));
}


$token=$_GET['token'];
$pdo = new PDO("mysql:host=127.0.0.1;dbname=2006", 'root', 'root');
$sql = "select * from token where token='$token'";
$res = $pdo->query($sql);
$data =  $res->fetch(PDO::FETCH_ASSOC);
    if($data&&$data['expire']>time()){
        $sq = "select * from `user` where id=$data[uid]";
        $res1 = $pdo->query($sq);
        $arr =  $res1->fetch(PDO::FETCH_ASSOC);
//        print_r($arr);die;
        $response=[
          'error'=>0,
          'mgs'=>'授权成功',
          'data'=>$arr
        ];
        echo json_encode($response);

    }else{
        $response1=[
            'errno'=>400001,
            'mgs'=>"没有授权",
        ];
        echo json_encode($response1,JSON_UNESCAPED_UNICODE);
    }


