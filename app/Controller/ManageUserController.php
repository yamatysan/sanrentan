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

App::uses('AdminController', 'Controller');


/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class ManageUserController extends AdminController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array(
		'User'
	);

	public $kojiharu_id = 3;

    public function beforeFilter() {
		AuthComponent::$sessionKey = 'Auth.admins';
        parent::beforeFilter();

    }

	//ユーザー一覧
	public function admin_index(){
		//TODO 年月による検索をつけたい

		$this->Paginator->settings = array(
			"conditions" => array(
				"is_deleted" => 0
			),
			"order" => "User.id desc",
			"recursive" => "-1",
			"limit" => 20
		);
		$userList = $this->Paginator->paginate('User');
		$this->set('userList', $userList);


	}

	//ユーザー詳細
	public function admin_user_view($id){
		if(empty($id)){
			$this->Flash->error(__('idを指定してください'));
		} 


		//$this->set(compact('raceData'));

	}


	//ユーザー編集
	public function admin_user_edit($id){
		//とりあえずUserテーブルのみでOK
		$userData = $this->User->findById($id);
		$this->set("userData",$userData);

        if ($this->request->is('post')||$this->request->is('put')) {

        	$this->request->data["User"]["id"] = $id;

            if ($this->User->save($this->request->data)) {
                $this->Flash->success(__('更新しました。id='.$id));
                return $this->redirect("./index");
            }
            $this->Flash->error(
                __('登録に失敗しました')
            );

        }else{
	        //$this->request->data = $userData;
        }

	}

	//レース削除
	public function admin_race_delete($id){
        $this->Race->id = $id;
        if (!$this->Race->exists()) {
	    	$this->Session->setFlash("レースが存在しません");
            return $this->redirect("./index");
        }

		$this->Race->saveField('is_deleted', 1);  
		$this->Race->saveField('deleted_date', date("Y-m-d H:i:s"));  
        $this->Flash->success(__('削除しました'));
        return $this->redirect("./index");
	}



}