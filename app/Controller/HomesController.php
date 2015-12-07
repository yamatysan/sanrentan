<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');

App::import('Vendor', 'simple_html_dom');



/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class HomesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array(
		'Expectation',
	);


	//入力・確認
	public function index(){
		$this->set("message","こんにちわ");

		$horseData = array();
		for($i=1;$i<=10;$i++){
			$horseData[] = "テスト".$i;
		}

		if(!empty($this->request->data['Expectation']['item'])){
			if(count($this->request->data['Expectation']['item'])==Configure::read('Base.box_count')){

				//ここでセッションにpost値を入れる
				$this->set("message","確認画面");
	            $this->Session->write('shop', $this->data);
    	        $this->set('postData',$this->data);

				$this->render('confirm');
				return;

			}else{
				$this->Session->setFlash(__('※'.Configure::read('Base.box_count').'つ選択してください。'));
			}
		}

		$this->set("horseData",$horseData);
	}

	//登録機能
	public function complete(){

		if(count($this->request->data['Expectation']['item'])==Configure::read('Base.box_count')){
			$expectationData = array(
				'race_id' => 1,
				'user_id' => 1,
			);
			for($i=0;$i<Configure::read('Base.box_count');$i++){
				$expectationData['item'.($i+1)] = $this->request->data['Expectation']['item'][$i];
			}
			$this->Expectation->create();
			$this->Expectation->save($expectationData);
			$this->Session->setFlash(__('※登録しました'));
		}else{
			$this->Session->setFlash(__('※不正な遷移です。'));
			$this->redirect('/');
		}
	}

	//URLからデータを取得する場合
	//参考URL http://www.junk-port.com/php/php-simple-html-dom-parser/
	public function index2(){

		//対象のレースを取得


		//htmlを取得
		$html = file_get_html('http://keiba.yahoo.co.jp/race/denma/1507040211/');
		
		//trのループ
		$i=0;
		$horseList = array();
		foreach($html->find('.denmaLs tr') as $key=>$element){
			//ヘッダー行は飛ばす
			if($i>0){
				//tdのループ
				$tdCounter = 0;
				foreach($element->find('td') as $key2=>$data){
					switch ($tdCounter) {
						
						case 0://枠
							$horseList[$i]["wk"] = $data->plaintext;
							break;
						case 1://馬番
							$horseList[$i]["uma"] = $data->plaintext;
							break;
						case 2://馬名,性齢
							$horseList[$i]["name"] = $data->find("strong")[0]->plaintext;
							$tmp = $data->find("span")[0]->plaintext;
							$horseList[$i]["sexage"] = explode('/',$tmp)[0]; 
							break;
						case 3://馬体重、増減
							$horseList[$i]["weight"] = substr($data->plaintext, 1,3); 
							$horseList[$i]["plus"] = substr($data->plaintext, 4); 
							break;
						case 4://騎手名、斤量
							$horseList[$i]["j_name"]   = $data->find("a")[0]->plaintext;
							$horseList[$i]["j_weight"]   = substr($data->plaintext, -5); 
							break;
						case 5://父馬、母馬、母父馬
							//$tmp = explode(" ",$data->plaintext);
							//$houseList[$i]["father"]   = ""; 
							//$houseList[$i]["mother"]   = "";
							//$houseList[$i]["m_father"] = "";

					} 
					$tdCounter++;
				}
			}
			$i++;
		}

		//DBに登録
	}
}