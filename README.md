介绍
========
API监控框架，监控内容不设限制，PHP能实现的都能监控。本应用通过按照定义的规则自动执行子应用(Atom)，通过对子应用返回的结果和执行耗时，推送至workerman-statistics实现记录和统计。
基于workerman-statistics实现API监控结果的成功、失败、耗时等图表展示。

所需环境
========
需要PHP版本不低于5.3，只需要安装PHP的Cli即可，无需安装PHP-FPM、nginx、apache

安装
=========
1、下载 或者 ```git clone https://github.com/walkor/workerman-api-monitor```

2、命令行运行 ```composer install```

监控子应用例子
=========
```php
class Clock implements AtomInterface{
	public function execute()
	{
		$str=file_get_contents('http://worldclockapi.com/api/json/est/now');
		if(json_decode($str)){
			return true;
		}else{
			return false;
		}
	}
	public function getName()
	{
		return 'World Clock API';
	}

	public function getNameSpace()
	{
		return 'Sameple';
	}

	public function getLoopTime()
	{
		return 5;
	}
}

return 'Clock';
```

启动停止
=========

以ubuntu为例

启动  
`php start.php start -d`

重启启动  
`php start.php restart`

平滑重启/重新加载配置  
`php start.php reload`

查看服务状态  
`php start.php status`

停止  
`php start.php stop`

Windows系统上运行
======
1、Windows平台需要将Workerman目录替换成[Windows版本的Workerman](https://github.com/walkor/workerman-for-win)

2、运行start_for_win.bat

[Windows版本Workerman相关参见这里](http://www.workerman.net/windows)

权限验证
=======

  *  管理员用户名密码默认都为空，即不需要登录就可以查看监控数据
  *  如果需要登录验证，在applications/Statistics/Config/Config.php里面设置管理员密码


 [更多请访问www.workerman.net](http://www.workerman.net/workerman-statistics)
