<?php

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class Expectation extends AppModel {

	public $kojiharu_id = 3;

	//public $belongsTo = array(
    //   'Race' => array(
     //       'className' => 'Race',
    //        'foreignKey' => 'race_id'
    //    )
    //);

    //レースの予想を取得 ※第２引数がなければこじはるの予想を返す
    public function getExpectationData($race_id,$user_id = 3){
		$options = array(
			'conditions' => array(
				'Expectation.cancel_flg' => 0,
				'Expectation.race_id' => $race_id,
				'Expectation.user_id' => $user_id,
			),
			'limit' => 1
		);
		$resultData = $this->find("first",$options);

		$returnData = array();

		if(!empty($resultData)){
			$tmpArray = array();
			for($i=1;$i<=Configure::read('Base.box_count');$i++){
				$tmpArray[] = $resultData["Expectation"]["item".$i];
			}
			$raceCard = ClassRegistry::init('RaceCard');
			$options = array(
				"conditions" => array("RaceCard.id"=>$tmpArray)
			);
			$horseData["selectData"] = $raceCard->find("all",$options);
			$returnData = array_merge($resultData,$horseData);
		}
		return $returnData;
    }


	//最新のこじはるの予想を取得
    public function getRecentKojiharu(){
		$options = array(
			'conditions' => array(
				'Expectation.cancel_flg' => 0,
				'Expectation.user_id' => $this->kojiharu_id,
			),
			'order' => array("Expectation.id desc"),
			'limit' => 1
		);

		$result = $this->find("first",$options);

		$tmpArray = array();
		for($i=1;$i<=Configure::read('Base.box_count');$i++){
			$tmpArray[] = $result["Expectation"]["item".$i];
		}

		$race = ClassRegistry::init('Race');
		$raceData = $race->findById($result["Expectation"]["race_id"]);

		//表示用
		foreach($raceData["RaceCard"] as $key=>$data){
			if(in_array($data["id"], $tmpArray)){
				$result["Expectation"]["view"][] = $data;
			}
		}

		$resultData = array_merge($result,$raceData);
		return $resultData;
    }

    //指定したレースの自分の予想一覧を返す（複数レース）race_idは配列指定
    public function getExpectaionList($user_id,$race_id){
		$options = array(
			'conditions' => array(
				'Expectation.cancel_flg' => 0,
				'Expectation.race_id' => $race_id,
				'Expectation.user_id' => $user_id,
			),
			'order' => "race_id desc"
		);
		$raceData = $this->find("all",$options);

		//Expectationの馬idから馬番を得る
		$RaceCard = ClassRegistry::init('RaceCard');
		$umaData = $RaceCard->find("list",array("conditions"=>array("race_id"=>$race_id),"fields"=>array("uma")));
		$wkData  = $RaceCard->find("list",array("conditions"=>array("race_id"=>$race_id),"fields"=>array("wk")));

		$returnData = array();
		if(!empty($raceData)){
			foreach($raceData as $key=>$data){
				for($i=1;$i<=5;$i++){
					$data["Expectation"]["item".$i."_uma"] = $umaData[$data["Expectation"]["item".$i]];
					$data["Expectation"]["item".$i."_wk"] = $wkData[$data["Expectation"]["item".$i]];
				}
				$returnData[$data["Expectation"]["race_id"]] =$data;
			}
		}
		return $returnData;


    }


}
