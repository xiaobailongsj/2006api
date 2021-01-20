<?php

$account=empty($_POST['account'])?'':$_POST['account'];
$pwd = empty($_POST['pwd'])?'':$_POST['pwd'];
$pdo = new PDO("mysql:host=127.0.0.1;dbname=2006", 'root', 'root');
$sql = "select * from `user` where account = '$account'";
$res = $pdo->query($sql);
$data = $res->fetch(PDO::FETCH_ASSOC);
if($data){
    if(password_verify($pwd,$data['pwd'])){
        $hash_str = password_hash($account.$pwd,PASSWORD_DEFAULT);
        $token = substr($hash_str,10,20);
        $time = time()+7*86400;
        $sq = "delete from token where uid=$data[id]";
//        $sql = "update token set uid='$data[id]',token='$token',expire='$time' where uid=$data[id]";
//        echo $sql;die;
        $res1=$pdo->query($sq);
        $sql = "insert into token(uid,token,expire)values ('$data[id]','$token','$time')";
//
//        echo $sql;die;
        $res =$pdo->query($sql);
        $response = [
            'errno'=>0,
            'mgs'=>'登录成功',
            'data'=>[
                'token'=>$token
            ],
        ];
        echo json_encode($response);
        exit;
    }
}
$response1=[
      'errno'=>400001,
      'mgs'=>"账号或密码有误",
];
echo json_encode($response1,JSON_UNESCAPED_UNICODE);
exit;

