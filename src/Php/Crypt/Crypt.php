<?php

namespace Php\Crypt;

class Crypt
{
    /**
     * 加密
     * @param unknown $data //要加密的数据
     * @param unknown $key //加密秘钥
     * @param number $expires //有效期
     * @return string   //返回加密过的数据
     */
    public function encrypt($data, $key, $expires = 0)
    {
        if (!is_int($expires) || $expires < 0 || empty ($key) || empty ($data)) {
            throw new \Exception('There is a problem with the input parameters');
        }
        //设置是否检测超时
        if ($expires >= 1) {
            $setdate = '*';
        } else {
            $setdate = '!';
        }
        $time = time() + $expires;
        $data = base64_encode($time . $data);
        // 加入时间参数
        $key = strtoupper(md5($time . $key));
        $arr = array_combine(range('A', 'Z'), range('Z', 'A'));
        $pieces = str_split($data);
        // 普通字符替换
        $temp = 0;
        // 加密核心
        for ($i = 0; $i < count($pieces); $i++) {

            //字符替换
            $pieces[$i] = isset($arr[$pieces[$i]]) ? $arr[$pieces[$i]] : $pieces[$i];

            // 设置偏移
            $pieces [$i] = ord($pieces [$i]) + 1;

            // 与秘钥异或运算
            $pieces [$i] = chr($pieces [$i] ^ ord($key [$temp]));

            if ((strlen($key) - 1) <= $temp) {
                $temp = 0;
            } else {
                $temp++;
            }
        }
        // 混淆时间
        $arr2 = array('F', 'E', 'M', 'A', 'Q', 'J', 'Z', 'T', 'S', 'L');
        $time = strval($time);
        for ($i = 0; $i < strlen($time); $i++) {
            $time [$i] = $arr2 [$time [$i]];
        }
        return base64_encode($setdate . $time . $setdate . implode('', $pieces));
    }

    /**
     * 解密
     * @param unknown $data //已加密的数据
     * @param unknown $key //解密秘钥
     * @return string|mixed  //返回解密结果
     */
    public function decrypt($data, $key)
    {
        if (empty ($data) || empty ($key)) {
            return 'data or key empty';
        }
        $data = base64_decode($data);
        $checkdate = 0;
        $nowtime = time();
        if (substr($data, 0, 1) == '!') {
            $checkdate = 1;
            $needle = '!';
        } else {
            $needle = '*';
        }
        $time = substr($data, strpos($data, $needle, 0) + 1, strpos($data, $needle, 1) - 1);
        $data = substr($data, strpos($data, $needle, 1) + 1);
        //判断加密数据合法性
        if (empty($time) || empty($data)) {
            throw new \Exception('the encrypted data is invalid');
        }
        unset($data_explodes);
        //恢复时间
        $arr2 = array('F', 'E', 'M', 'A', 'Q', 'J', 'Z', 'T', 'S', 'L');
        $str = join($arr2);
        for ($i = 0; $i < 10; $i++) {
            $time [$i] = strpos($str, $time [$i]);
        }
        if ($checkdate == 1 && $time < $nowtime) {
            throw new \Exception('The secret key expired');
        }
        $key = strtoupper(md5($time . $key));
        $arr = array_combine(range('Z', 'A'), range('A', 'Z'));
        $pieces = str_split($data);
        $temp = 0;
        for ($i = 0; $i < count($pieces); $i++) {
            //异或恢复
            $pieces [$i] = ord($pieces [$i]);
            $pieces [$i] = $pieces [$i] ^ ord($key [$temp]);

            if ((strlen($key) - 1) <= $temp) {
                $temp = 0;
            } else {
                $temp++;
            }
            //偏移恢复
            $pieces [$i] = chr($pieces [$i] - 1);
            //字符恢复
            $pieces[$i] = isset($arr[$pieces[$i]]) ? $arr[$pieces[$i]] : $pieces[$i];
        }
        $result = base64_decode(join('', $pieces));
        if ($checkdate) {
            if (substr($result, 0, 10) < $nowtime || substr($result, 0, 10) != $time) {
                throw new \Exception('The secret key timeout');
            }
        }

        return str_replace($time, '', $result);
    }
}