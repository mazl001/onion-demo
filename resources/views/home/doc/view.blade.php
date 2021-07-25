@extends('home.public')

@section('title', '开发文档: 视图')

@section('content')
<pre class="brush:php;toolbar:false">
视图服务使用 Blade 模板引擎实现, 参考文档 https://packagist.org/packages/jenssegers/blade

它能够将控制器和应用程序逻辑在呈现逻辑中进行分离, 视图被存在 resources/views 目录下, 视图文件

以 .blade.php 结尾.


class DemoController {

    public function view() {
    
        return view('home.homepage', ['name' => 'John']);
    }
}
</pre>
@endsection