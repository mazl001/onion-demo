@extends('home.public')

@section('title', '开发文档: 加密、解密')

@section('content')
<pre class="brush:php;toolbar:false">
在日常设计及开发中，为确保数据传输和数据存储的安全，可通过特定的算法，将数据明文

加密成复杂的密文. 框架采用 对称加密 的方式, 只要拥有相同的密钥就可以进行加密解密.

密钥配置文件 config/app.php.


//加密
$encrypt = Encrypter::encrypt('hello world');

//解密
$decrypt = Encrypter::decrypt($encrypt);

</pre>
@endsection