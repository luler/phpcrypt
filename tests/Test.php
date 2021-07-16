<?php
/**
 * Created by PhpStorm.
 * User: LinZhou <1207032539@qq.com>
 * Date: 2020/1/4
 * Time: 14:51
 */

namespace Test;

use Php\Crypt\Crypt;
use PHPUnit\Framework\TestCase;

class Test extends TestCase
{
    public function test()
    {
        $cleartext = "需要加密的数据";
        $cipher = Crypt::encrypt($cleartext, "123456");
        echo "\n";
        echo '加密后密文：' . $cipher . "\n";
        echo '解密后明文：' . Crypt::decrypt($cipher, "123456") . "\n";
//设置秘钥超时失效，只需把expires参数设置有效时间，单位是秒,比如有效期为一分钟，则设置expires为60
        $cipher = Crypt::encrypt($cleartext, "123456", 60);
        echo '加密后密文：' . $cipher . "\n";
        echo '解密后明文：' . Crypt::decrypt($cipher, "123456") . "\n";
    }
}
