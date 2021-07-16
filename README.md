# phpcrypt

这是一个PHP数据加密解密包，可以设置密码、过期时间，在一些需要对数据进行加密解密传输的应用中非常有用

# 安装

```
composer require luler/phpcrypt
```

# 使用例子

```injectablephp
$cleartext = "需要加密的数据";
$cipher = \Php\Crypt\Crypt::encrypt($cleartext, "123456");
echo "\n";
echo '加密后密文：' . $cipher . "\n";
echo '解密后明文：' . \Php\Crypt\Crypt::decrypt($cipher, "123456") . "\n";
//设置秘钥超时失效，只需把expires参数设置有效时间，单位是秒,比如有效期为一分钟，则设置expires为60
$cipher = \Php\Crypt\Crypt::encrypt($cleartext, "123456", 60);
echo '加密后密文：' . $cipher . "\n";
echo '解密后明文：' . \Php\Crypt\Crypt::decrypt($cipher, "123456") . "\n";
```
