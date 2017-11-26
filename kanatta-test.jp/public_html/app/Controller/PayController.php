<?php
class PayController extends AppController {
	// コントローラー名
	public $name = 'Pay';
	// モデルを指定しない
	public $uses = null;
	// レイアウトとして使用するものを指定。Layouts フォルダの、haskap.ctp を使う。
	public function index() {
	}
	
	public function pay_pay() {
		App::uses('Sanitize', 'Utility');
		// pay_payアクション内
		$this->request->data;

		// prでの出力結果
		Array
		(
			[Payment] => Array
			(
				[name] => hogera
			)
		);
	}
}

?>