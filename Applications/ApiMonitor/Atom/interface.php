<?php
interface AtomInterface {
	/**
	 * 成功返回true，失败返回false
	 * @return boolean
	 */
	public function execute();
	/**
	 * 报表分类
	 * @var string
	 */
	public function getNameSpace();
	/**
	 * 报表展示名，在报表分类下
	 * @var string
	 */
	public function getName();
	/**
	 * 监控间隔时间秒(s)
	 * @var integer
	 */
	public function getLoopTime();
}