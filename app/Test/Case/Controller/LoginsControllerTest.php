<?php
App::uses('ClassRegistry', 'Utility');

class LoginsControllerTest extends ControllerTestCase {
    public $fixtures = array('app.user','app.team','app.roleteam');

    public function setUp() {
        parent::setUp();
        $this->TUser = classRegistry::init('TUser');
    }

    /**
     * test login action
     *
     * @param array $data user information to login
     * @param int $status status of testcase: success or fail
     * @dataProvider loginProvider
     */
    public function testLogin($data, $status) {
        $this->testAction('/logins/login', array('method' => 'post', 'data' => $data));
        if ($status == 1) {
            $this->assertContains('/reports', $this->headers['Location']);
        } else {
            $error = 'Login fail!';
            $this->assertEquals($error, $this->vars['error']);
        }

        //logout mocked user
        $this->testAction('/Logins/logout');
    }

    public function loginProvider() {
        return array(
            array(
                array(
                    'TUser' => array(
                        'email' => 'tampv@gmail.com',
                        'password' => '12345678',
                    ),
                ),
                1,   //success
            ),

            //case 2: admin login success
            array(
                array(
                    'TUser' => array(
                        'email' => 'tampv@tmh-techlab.vn',
                        'password' => '12345678',
                    )
                ),
                1, //success
            ),

            // case 3: incorrect password -> fail
            array(
                array(
                    'TUser' => array(
                        'email' => 'tampv@tmh-techlab.vn',
                        'password' => '12345',
                    ),
                ),
                0, //status == false
            ),

            //case 4: incorrect email ->fail
            array(
                array(
                    'TUser' => array(
                        'email' => 'tranglt@tmh-techlab.vn',
                        'password' => '12345',
                    ),
                ),
                0, //status == false
            ),

        );
    }

    /**
     *
     * Test logout action
     * No need dataProvider
     */
    public function testLogout() {
        $this->testAction('/Logins/logout');
        $this->assertContains('/homes', $this->headers['Location']);
    }


    /**
     * test saving password in resetPassword action
     *
     * @param array $data : information of account that need reset password
     * @param int $status status of testcase: success of fail
     * @param int $user_id : id of user handling
     * @dataProvider passwordProvider
     */
    public function testSavePassword($data, $status, $user_id) {
        $this->testAction('/logins/resetPassword', array('method' => 'post', 'data' => $data));
        $output = $this->TUser->read('id, password, modified', $data['id']);
        $input['TUser'] = $data;
        $input['TUser']['password'] = '$2a$10$BfHHrQXlvahDbUxoh5TTaOUzK3wuDrlbO5K3.2/0sdsa5ZiHL1bNK';

        if ($status == 1) {
            $this->assertEquals($input, $output);
        } elseif ($status == 0) {
            $this->assertNotEqual($input, $output);
        }
    }

    public function passwordProvider() {
        return array(
            //case 1: pass
            array(
                array(
                    'id' => '1',
                    'password' => '123456',
                    'modified' => '2019-07-01 07:16:16',
                ),
                1,   //user_id
                1   //status if succesful saving
            ),

            //case 2:  fail
            array(
                array(
                    'id' => '1',
                    'password' => '1234567',
                    'modified' => '2019-07-01 07:16:16',
                ),
                2,   //user_id
                0   //status if fail
            ),

        );
    }

    /**
     * test sending email action
     *
     * @param array $data : information of account that need to send email
     * @param int $status status of test case: success or fail
     * @dataProvider emailProvider
     */
    public function testSendingEmail($data, $status) {

        $this->testAction('/logins/forgotPassword', array('method' => 'post', 'data' => $data));
        $message = "Check your email to reset password please!";
        $this->assertEquals($message, $this->vars['message']);

    }

    public function emailProvider() {
        return array(
            //case 1: pass
            array(
                array(
                    'email' => 'tampv@tmh-techlab.vn'
                ),
                1   //status if succesful
            ),

            //case 2: fail because email not exist
            array(
                array(
                    'email' => 'tampv@gmail.com'
                ),
                1   //status if succesful
            ),
        );
    }

}
