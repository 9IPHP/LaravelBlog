<?php

function baidu_translate($q = '') {
    if (empty($q)) return false;
    $q = str_replace('&', '', $q);
    $appid = env('BAIDU_TRANSTALE_APPID');
    $key = env('BAIDU_TRANSTALE_KEY');
    $salt = rand(1, 999);
    $sign = md5($appid . $q . $salt . $key);
    $url = 'http://api.fanyi.baidu.com/api/trans/vip/translate?q=' . $q . '&appid=' . $appid . '&salt=' . $salt . '&from=zh&to=en&sign=' . $sign;
    $result = json_decode(file_get_contents($url), true);
    $dst = $result['trans_result'][0]['dst'];
    return $dst ? strtolower($dst) : false;
}

function mb_content_filter_cut($content, $start = 0, $length = 200, $marker='...')
{
    return mb_strimwidth(strip_tags($content), $start, $length, $marker);
}