<?php

function baidu_translate($q = '') {
    if (empty($q)) return false;
    $q = filter_allowed_words($q);
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

function filter_allowed_words($str){
    // $str = str_replace('+', '-', $str);
    $str = preg_replace('/[^a-zA-Z0-9\x{4e00}-\x{9fa5}-_+]/u', ' ', $str);
    $str = preg_replace('/\s{2,}/', ' ', $str);
    // $str = preg_replace('/\s+/', '-', $str);
    return trim($str);
}

function rand_letter(){
    $letter = 'abcdefgHIJKLMN0123456789';
    $str = '';
    for ($i=0; $i < 5; $i++) {
        $str = $str . $letter[rand(0,23)];
    }
    return $str;
}