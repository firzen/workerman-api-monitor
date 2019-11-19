<?php 
/**
 */

use \Workerman\Worker;
use Workerman\Lib\Timer;

include dirname(__DIR__).'/Statistics/Clients/StatisticClient.php';

// WebServer
$mon = new Worker("http://0.0.0.0:1010");
$mon->name = 'ApiMonitor';
$files=array();
foreach (glob(__DIR__.'/Atom/*.php') as $fn){
	if (substr($fn,-13,13) !='interface.php') {
		$files[]=$fn;
	}else {
		require $fn;
	}
}
asort($files);
print_r($files);

$mon->count=count($files);

$mon->onWorkerStart=function() use ($mon,$files){
	$mon->lastrun=0;
	
	// 根据ID处理不同的Atom
	$classname=require $files[$mon->id];
	/** @var $atom AtomInterface **/
	$atom=new $classname;
	slog($atom->getNameSpace().'> '.$atom->getName() ." Started.");
	
	// 检查
	Timer::add(1,function()use($mon,$atom){
		if (!$mon->lastrun || time()-$mon->lastrun > $atom->getLoopTime()) {
			slog($atom->getName().' Run');
			
			$mon->lastrun=time();
			StatisticClient::tick($atom->getNameSpace(),$atom->getName());
			$ret=false;
			try {
				$ret=$atom->execute();
			} catch (Exception $e) {
				$ret=false;
			}
			StatisticClient::report($atom->getNameSpace(),$atom->getName(),$ret,0,'');
		}
	});
};

function slog($str){
	echo date('Ymd Hi').']'.$str."\n";
}

// 如果不是在根目录启动，则运行runAll方法
if(!defined('GLOBAL_START'))
{
    Worker::runAll();
}
