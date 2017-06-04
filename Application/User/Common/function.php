<?php
function login($openid) {
    $where['openid'] = $openid;
    $user = M('user')->field('id,name,openid,class')->where($where)->find();
    if($user) {
        session('user', $user);
        return session('user')['id'];
    } else {
        return NULL;
    }
}
