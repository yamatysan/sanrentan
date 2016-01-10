<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');


// app/Model/User.php
class User extends AppModel {
    public $validate = array(
        'username' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'ログインIDを入力してください'
            ),
             'isUnique' => array(
                'rule' => 'isUnique', // 重複チェック
                'message' => '既に使用されているログインIDです'
            ), 
            'length' => array(
                'rule' => array( 'between', 4, 20),
                'message' => 'ログインIDは4文字以上、20文字以下で入力して下さい',
            ),
            'alpha' => array(
                'rule' => 'alphaNumeric',
                'message' => 'ログインIDは半角英数字のみ使用できます'
            ),


        ),
        'password' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'パスワードを入力してください'
            ),
            'custom' => array(
                'rule' => array('custom', '/^[a-zA-Z0-9]{6,}$/i'), // 半角英数6文字以上
                'message' => 'パスワードは半角英数6文字以上入力してください'
            ),
            'length' => array(
                'rule' => array( 'between', 6, 20),
                'message' => 'パスワードは6文字以上、20文字以下で入力して下さい',
            ),
        ),
        'role' => array(
            'valid' => array(
                'rule' => array('inList', array('admin', 'author')),
                'message' => 'Please enter a valid role',
                'allowEmpty' => false
            )
        ),
        'nickname' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'ニックネームを入力してください'
            ),
             'isUnique' => array(
                'rule' => 'isUnique', // 重複チェック
                'message' => '既に使用されているニックネームです'
            ), 
            'length' => array(
                'rule' => array( 'between', 2, 20),
                'message' => 'ニックネームは2文字以上、20文字以下で入力して下さい',
            ),
        ),
        'span' => array(
            'length' => array(
                'rule' => array( 'maxlength', 20),
                'message' => '競馬歴は20文字以下で入力して下さい',
            ),
        ),
        'favorite' => array(
            'length' => array(
                'rule' => array( 'maxlength', 50),
                'message' => '好きな馬は50文字以下で入力して下さい',
            ),
        ),
        'message' => array(
            'length' => array(
                'rule' => array( 'maxlength', 300),
                'message' => '自己紹介は300文字以下で入力して下さい',
            ),
        ),
    );


	public function beforeSave($options = array()) {
	    if (isset($this->data[$this->alias]['password'])) {
	        $passwordHasher = new BlowfishPasswordHasher();
	        $this->data[$this->alias]['password'] = $passwordHasher->hash(
	            $this->data[$this->alias]['password']
	        );
	    }
	    return true;
	}
    
}