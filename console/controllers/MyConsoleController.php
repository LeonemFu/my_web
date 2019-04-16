<?php
/**
 * Created by
 * User: herunfu
 * Date: 2019-01-01
 * 测试控制台模式
 */

namespace console\controllers;

use console\models\TestSingleCase;
use yii\console\Controller;
use yii\console\models;

class MyConsoleController extends Controller
{
    public function actionTest($say = '')
    {
        echo 'This is a test of Yii console' . "\n";

        if ($say) {
            var_dump($say);
        }
    }

	//搞搞正则匹配
    public function actionDoPcre()
	{
		$str = 'http://www.baidu.com.www.ww';
		//http或者https开头，到3个www结尾的部分，替换成*号
		$parttern = '#^(http|https)://[\D]*[w]{3}#';
		//查找
		preg_match($parttern, $str, $match);
		var_dump($match);
		//替换
		$ret = preg_replace($parttern, '*', $str);
		var_dump($ret);
	}

	public function actionTestEmpty()
	{
    	//用empty或者 >0 的方法来判断是否为空
    	$arr = ['    ', 1, '', 0, 'ckbb  dex'];
		foreach ($arr as $value) {
			print_r($value > 0 ? "不为空\n" : "空\n");
    	}

		echo "========================================>\n";

		foreach ($arr as $value) {
			print_r(empty($value) ? "空\n" : "不为空\n");
		}

		echo "========================================>\n";
		//去除数组中的空格跟空值
		foreach ($arr as $k => $v) {
			$arr[$k] = str_replace(' ', '', $v);
		}
		var_dump($arr);
	}

	public function actionDo()
	{
//		echo date('t', strtotime('2019-03-01'))."\n";
//
//		$info = pathinfo(__FILE__);
//		var_dump($info);

		$a = 20;
		$b = &$a;

		$b = 30;
		$a = 1;

		print_r($a);
		echo "\n";
		print_r($b);
		echo "\n";

	}

	public function actionDraw()
	{
		//画实心菱形
		for($i = 0; $i <= 4; $i++){
			echo str_repeat(" ",4 - $i);
			echo str_repeat("*",$i * 2 + 1);
			echo "\n";
		}

		/**
		 * 画空心菱形
		 * i = 0	* = 0
		 * i = 1	* = 1
		 * i = 2	* = 3
		 * i = 3	* = 5
		 * i = 4	* = 7

		 * $i*2 - 1
		 */
		for($i = 0; $i <= 4; $i++){
			echo str_repeat(" ",4 - $i);
			echo '*';
			echo str_repeat(" ",max($i * 2 - 1, 0));//输出菱形中间的空格
			//第二行开始才有行末的*号
			if ($i > 0) {
				echo '*';
			}
			echo "\n";
		}
	}

	//冒泡排序
	public function actionBubbleSort()
	{
		// 定义一个随机的数组
		$a = array(23,15,43,25);

		// 第一层可以理解为从数组中键为0开始循环到最后一个
		for ($i = 0; $i < count($a) ; $i++) {
			//第二层为从$i+1的地方循环到数组最后
			for ($j = $i+1; $j < count($a); $j++) {
				//比较数组中两个相邻值的大小
				if ($a[$i] < $a[$j]) {
					$tem = $a[$i]; // 这里临时变量，存贮$i的值
					$a[$i] = $a[$j]; // 第一次更换位置
					$a[$j] = $tem; // 完成位置互换
				}
    		}

			print_r($a);
		}
		print_r($a);
	}

	//快速排序
	public function actionQs()
	{
//		$a = array(13,2,42,34,56,23,67,365,87665,54,68,3);
		$a = array(13,2,42);

		function quick_sort($a)
		{
			if (count($a) <= 0) {
				return $a;
			}

			$mid = $a[0];//随便取个中间值
			$left = array();
			$right = array();

			//数组有多少个元素就循环多少遍
			for ($i = 1; $i < count($a); $i++) {
				if ($a[$i] > $mid) {
					$right[] = $a[$i];
				}else{
					$left[] = $a[$i];
				}
			}

			// 递归排序划分好的2边
			$left = quick_sort($left);
			$right = quick_sort($right);

			// 合并排序后的数据，别忘了合并中间值
			return array_merge($left, array($mid), $right);
		}

		print_r(quick_sort($a));
	}

	//二分查找
	public function actionDichotomySearch()
	{
		/**
		 * 二分查找
		 * @param Array $arr 待查找的数组
		 * @param Int $key 要查找的关键字
		 * @return Int
		 */
		function bin_search(Array $arr,$key)
		{
			$high = count($arr);
			if($high <= 0) return 0;
			$low = 0;

			while($low <= $high)
			{
				//当前查找区间arr[low..high]非空
				$mid = intval(($low + $high) / 2);

				//当传入的搜索值，是比数组中任何一个都要大的，此时每次的$low就会一直靠右，最终$mid有可能会出现一个数组中没有的键
				if (empty($arr[$mid])) {
					return "Not found";
				}

				if($arr[$mid] == $key) {
					return $mid; //查找成功返回
				}

				if($arr[$mid] > $key) {
					$high = $mid - 1; //继续在arr[low..mid-1]中查找
				}else {
					$low = $mid + 1; //继续在arr[mid+1..high]中查找
				}
			}
			return "Not found"; //当low>high时表示查找区间为空，查找失败
		}

		$arr = array(1,2,4,6,10,40,50,80,100,110);
		echo bin_search($arr,130)."\n";
	}

	//检验单例模式
	public function actionGetSingleCase()
	{
		$a = TestSingleCase::getInstance();
		$b = TestSingleCase::getInstance();
//		$c = new TestSingleCase();

//		$d = TestSingleCase::$instance;

		var_dump($a === $b);
	}

	public function actionTc(){
    	$a = 1;
    	$b = &$a;

    	$b = $a++;
    	echo $b.'-'.$a."\n";
	}

	public function actionTc2(){
    	$a = 2;
    	$b = 3;

    	$a = $a + $b;
    	$b = $a - $b;
    	$a = $a - $b;

    	var_dump($a);
    	var_dump($b);
	}

	public function actionTc3(){

	}

}

