# phpcrypt
这是一个PHP数据加密解密包，可以设置密码、过期时间，在一些需要对数据进行加密解密传输的应用中非常有用
# 使用例子
```
$crypt = new \Php\Crypt\Crypt();
$cleartext = "需要加密的数据";
$cipher = $crypt->encrypt($cleartext, "123456");
echo '密文：' . $cipher . "\n";
echo '明文：          ' . $crypt->decrypt($cipher, "123456") . "\n";
//设置秘钥超时失效，只需把expires参数设置有效时间，单位是秒,比如有效期为一分钟，则设置expires为60
$cipher = $crypt->encrypt($cleartext, "123456", 60);
echo '密文：       ' . $cipher . "\n";
echo '明文：          ' . $crypt->decrypt($cipher, "123456") . "\n";
```
