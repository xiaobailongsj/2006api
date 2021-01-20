<?php

$account=empty($_POST['account'])?'':$_POST['account'];
$pwd = empty($_POST['pwd'])?'':$_POST['pwd'];
$pdo = new PDO("mysql:host=127.0.0.1;dbname=2006", 'root', 'root');
$sql = "select * from `user` where account = '$account'";
$res = $pdo->query($sql);
$data = $res->fetch(PDO::FETCH_ASSOC);
if($data){
    if(password_verify($pwd,$data['pwd'])){
        $token = password_hash($account.$pwd,PASSWORD_DEFAULT);
        $time = time()+7*86400;

        $sql = "insert into token(uid,token,expire)values ('$data[id]','$token','$time')";
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
echo json_encode($response1);
exit;

