<?php
class Rsa
{
    public $privateKey = '-----BEGIN PRIVATE KEY-----
MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQDkaTKbAERvJGE0
jGsdPXUI1FpO1uDkBkuuQU4LRv0Quw9r8j+fVNkN9rZVXMV7MiGOgb80Z0k9zRxZ
5KWOqMnSlrpyO3WjhFpDJeSmqZ4wLMFwmxrr31AjabD5Nkf9dQ7RiEIuM49g27+M
3OFvdIPcLgCyXnkl8FwBceBs38QbCXY5MrwlZr13yWZnyj6fbbG8t4atAzJ6bnj3
FZuvynC3QnMaVi6YnTIlBOUOHtqt/jsUTOCWkwKqkZh+RZF2fx3IFkSpJAOMgT5p
jSnfEJkK5E4JJHobLo/dFO0J7Gve+qb/lfJ9UpnZe78N1TAvbJiNZoN22ghbuIAW
M5qqIqOzAgMBAAECggEBAItUJFtqoVQOpADy+s/+UirNpjzbVJmjwXyNN3cnmW0g
PjsBrY+aqUCcUwLlMU2B+fg86w6jRokdWgL3t4m7Kkl8SkUuQgc5z/mP3tdPNkB6
vJDc/GIPeYnwidSrKOTSB/UGoiAesYJK6aCaiCV9tIWVxjUH7eyXnvf+qAChyrUW
PG/FirLyYmz1yRG99VKKE+iEIzemGSswU0DI0bwTFQ0MunLeJf0EdT20XppNwnl4
uoRgOBpMkW02vxDDWke2YIpk128KFRtPE3zF7W+Prb3ifMuQHSqDdqTgZA5+G3A9
D+lwczy95+0mIBpJ8rKQGjJ51ZT5WVMET9+Hb9+nUIECgYEA9NluRzIi9tZxwQa2
KdU8WAtWZZQZfG18mSFg8/QYrAGF2TyLAW0mEIe7nQXxPzm50HdpxTJCkUrXGm3u
hfPayx18H4oVVYRepSSfV+xe7wdogJWV6i5h/LaZsiTk1O8vF9Cwc3yUyVoMtKsg
yVcsONOzo/Kg/vwejQJb1C8dNvMCgYEA7tAewjA25vDmfiWZ0lrWKlwGQZ97+pMU
X+N12DWxL1Lvi6jBKXlK+Eiz19Qm/mBz9RxrDDY4/o0IjtTxdOh5thDaiqIcnqQn
PiBpm7zbheZOlPBGjFJ1vwueIWvqbx9vcqHik/4xHwuFNwQ+YCSpVpVoqrgoN/h/
fX5+hKm1kEECgYEAzn69UZAICtLKNveZE+jBLqPJJnvjjpur1F1hLfzz/cR/BLnZ
pcdOrew7Hu+PCTp+6kB7VJLRr0VF6gVCf3gsUta4AsVqvqeXRoF/XSB84+wEh0Ug
nNKnUwEQ2DvjPW3G8rfOyGcN+E5YntogGY3KPtbUDvWmL8WjYlrV5Toi0l8CgYAQ
Ujr37JGkAOzPzEQSA1FFvdpTm9G+U1T+JK6GI01DvbhPZC4nZnnAND/OTVqI4hCq
vNF4GTCV/Q+Lq3QBGG5RCh/Vf7TTBscD0PVGxoZ+RTozpaQ8rNoNP38EK7ru80gL
npK8qI+03nWxR+H3cin8l+N6X3GoOZyE+CMvb+XPwQKBgEeDjwTWxVhH/uksO3pw
MgbHjauD6AjuW9jc2a7ngFCWSQxQ3+xK1Spn6pbVdLPiBgInxCIl8d6S1yFU0Uan
iZHgy4fs1hdJRSuJ6qydqSwlS2C+gDpyY8ye0i+jq5VYYhKcpJCrCgaQGbleuaUd
ldp7v1FD8uyeemknGA35f6Id
-----END PRIVATE KEY-----';

    public $publicKey = '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA5GkymwBEbyRhNIxrHT11
CNRaTtbg5AZLrkFOC0b9ELsPa/I/n1TZDfa2VVzFezIhjoG/NGdJPc0cWeSljqjJ
0pa6cjt1o4RaQyXkpqmeMCzBcJsa699QI2mw+TZH/XUO0YhCLjOPYNu/jNzhb3SD
3C4Asl55JfBcAXHgbN/EGwl2OTK8JWa9d8lmZ8o+n22xvLeGrQMyem549xWbr8pw
t0JzGlYumJ0yJQTlDh7arf47FEzglpMCqpGYfkWRdn8dyBZEqSQDjIE+aY0p3xCZ
CuROCSR6Gy6P3RTtCexr3vqm/5XyfVKZ2Xu/DdUwL2yYjWaDdtoIW7iAFjOaqiKj
swIDAQAB
-----END PUBLIC KEY-----';

    public function __construct()
    {
    }

    public function publicEncrypt($data, $publicKey)
    {
        openssl_public_encrypt($data, $encrypted, $publicKey);
        return $encrypted;
    }

    public function publicDecrypt($data, $publicKey)
    {
        openssl_public_decrypt($data, $decrypted, $publicKey);
        return $decrypted;
    }

    public function privateEncrypt($data, $privateKey)
    {
        openssl_private_encrypt($data, $encrypted, $privateKey);
        return $encrypted;
    }

    public function privateDecrypt($data, $privateKey)
    {
        openssl_private_decrypt($data, $decrypted, $privateKey);
        return $decrypted;
    }
}

$rsa = new Rsa();

// 使用公钥加密
$str = 'IUMBGcLwJECdxUu3LMbeEhGQdoRjCLqFwfZQBO/Odh3tClbq76Tva7yYqTVxexXLmZ3uY8DrOk/XwcVVRr6g9rBnv/zxBxUShCdN0CwkoguvI+6Oju2aUBlM4FhUp+gmasa5YfqylEp1RpsVAp67GMGlxZvp0ekfhFXkjSqAguPd7dKq5YjftP12xOyuJHAzzg7U+eHxffxnneKqXkK7QrfQD6VrLpbYmayPSjMza/RbjXF+d85UeUZUaF25PZ7Y7kD4Yo7/hY/L6peeOkI5//tpl6U4QY9VsFsjAbIpNMsZuNjE/cZ57Kc5WScPsmy0o9wsp5DUEJmu+YYmr6adoA==';
// 这里使用base64是为了不出现乱码，默认加密出来的值有乱码
// $str = base64_encode($str);
// echo "公钥加密（base64处理过）：\n", $str, "\n";
$str = base64_decode($str);
$pubstr = $rsa->publicDecrypt($str, $rsa->publicKey);
echo "公钥解密：\n", $pubstr, "\n";
$privstr = $rsa->privateDecrypt($str, $rsa->privateKey);
echo "私钥解密：\n", $privstr, "\n";
