<?php
App::uses('ClassRegistry', 'Utility');

class UsersControllerTest extends ControllerTestCase {
    public $fixtures = array('app.user');

    public function setUp() {
        parent::setUp();
        $this->TUser = ClassRegistry::init('TUser');
    }

    /**
     * Singup a count
     * @param array $data User input information
     * @param int $status mark the status: success or fail
     * @dataProvider signupDataProvider
     */
    public function testSignup($data, $status) {
        // error method
        $this->testAction('/users/signup', array('data' => $data, 'method' => 'get'));
        $output1 = $this->TUser->find('all');
        $this->assertNotContains($data, $output1);

        $this->testAction('/users/signup', array('data' => $data, 'method' => 'post'));
        $output2 = $this->TUser->find('count');
        if ($status == 1) {
            $this->assertNotEquals(count($output1), $output2);
            //test redirect
            $this->assertContains('/reports/index', $this->headers['Location']); //check redirect
        } else {
            $this->assertEquals(count($output1), $output2);
        }
    }

    public function signupDataProvider() {
        return array(
            // case 1: full message => success
            array(
                array(
                    'role_id' => '1',
                    'username' => 'nhinhgggggg',
                    'password' => '$2a$10$BfHHrQXlvahDbUxoh5TTaOUzK3wuDrlbO5K3.2/0sdsa5ZiHL1bNK',
                    'email' => 'nhinh@tmh-techlab.vn',
                    'created' => '2019-07-01 07:16:16',
                    'modified' => '2019-07-01 07:16:16',
                ),
                1, //status
            ),
            // case 2: illegal username => fail
            array(
                array(
                    'role_id' => '1',
                    'username' => '123nhinh',
                    'password' => '$2a$10$BfHHrQXlvahDbUxoh5TTaOUzK3wuDrlbO5K3.2/0sdsa5ZiHL1bNK',
                    'email' => 'nhinh@tmh-techlab.vn',
                    'created' => '2019-07-01 07:16:16',
                    'modified' => '2019-07-01 07:16:16',
                ),
                0,
            ),
            // case 3: Email not format => fail
            array(
                array(
                    'role_id' => '1',
                    'username' => 'nhinh',
                    'password' => '$2a$10$BfHHrQXlvahDbUxoh5TTaOUzK3wuDrlbO5K3.2/0sdsa5ZiHL1bNK',
                    'email' => 'nhinh',
                    'created' => '2019-07-01 07:16:16',
                    'modified' => '2019-07-01 07:16:16',
                ),
                0,
            ),
            // case 4: Double name in db => fail
            array(
                array(
                    'role_id' => '1',
                    'username' => 'admin',
                    'password' => '$2a$10$BfHHrQXlvahDbUxoh5TTaOUzK3wuDrlbO5K3.2/0sdsa5ZiHL1bNK',
                    'email' => 'nhinh@tmh-techlab.vn',
                    'created' => '2019-07-01 07:16:16',
                    'modified' => '2019-07-01 07:16:16',
                ),
                0,
            ),
            // case 5: Double email in db => fail
            array(
                array(
                    'role_id' => '1',
                    'username' => 'nhinh_test',
                    'password' => '$2a$10$BfHHrQXlvahDbUxoh5TTaOUzK3wuDrlbO5K3.2/0sdsa5ZiHL1bNK',
                    'email' => 'tampv@gmail.com',
                    'created' => '2019-07-01 07:16:16',
                    'modified' => '2019-07-01 07:16:16',
                ),
                0,
            ),
            // case 6: Username much more than 5 characters => fail
            array(
                array(
                    'role_id' => '1',
                    'username' => 'nhi',
                    'password' => '$2a$10$BfHHrQXlvahDbUxoh5TTaOUzK3wuDrlbO5K3.2/0sdsa5ZiHL1bNK',
                    'email' => 'nhi@gmail.com',
                    'created' => '2019-07-01 07:16:16',
                    'modified' => '2019-07-01 07:16:16',
                ),
                0,
            )
        );
    }

    /**
     *
     * Test edit profile method
     *
     * @param Array $data data test case
     * @param boolean $status is result status of test case
     *
     * @dataProvider editProfileDataProvider
     */
    public function testEditProfile($data, $status) {
        $this->testAction('/users/editProfile', array('data' => $data['TUser'], 'method' => 'post'));

        $output = $this->TUser->read('id, date_of_birth, phone_number, facebook', $data['TUser']['id']);
        $data['TUser']['date_of_birth'] = date("Y-m-d H:i:s", strtotime($data['TUser']['date_of_birth']));

        if ($status === 1) {
            $this->assertEquals($output, $data);
        } else {
            $this->assertNotEquals($output, $data);
        }
    }

    public function editProfileDataProvider() {
        return array(
            //case 1: message full -> success
            array(
                array(
                    'TUser' => array(
                        'id' => 1,
                        'date_of_birth' => '02/18/1993',
                        'phone_number' => '0973870336',
                        'facebook' => 'https://www.facebook.com/pvtamitns.edu.vn'
                    )
                ),
                1, //success
            ),
            //case 2: missing some field -> success
            array(
                array(
                    'TUser' => array(
                        'id' => 2,
                        'date_of_birth' => '02/18/1993',
                        'phone_number' => '',
                        'facebook' => ''
                    )
                ),
                1,
            )
        );
    }

    /**
     * Upload avatar and cover for Profile
     * @param int $type : 1-upload avatar image, 2-upload cover image
     * @param array $file File information is uploaded
     * @param int $status mark the status: success or fail
     * @dataProvider uploadFileProvider
     */
    public function testUploadAvatar($type, $file, $status) {
        CakeSession::write("Auth.User", array(
            'username' => 'pvtamh2bg',
            'role_id' => '1',
            'id' => 1
        ));
        $data['data']['mark'] = $type;
        $_FILES['file'] = $file;

        $id = CakeSession::read("Auth.User");
        $beforeUpload = $this->TUser->find('first', array(
            'conditions' => array(
                'id' => $id
            )
        ));

        $this->testAction('users/uploadAvatar', array('data' => $data, 'method' => 'post'));

        $afterUpload = $this->TUser->find('first', array(
            'conditions' => array(
                'id' => $id
            )
        ));

        if ($status == 1) {
            if ($type == 1) {
                // update avatar_user
                $this->assertNotEmpty($afterUpload['TUser']['avatar_user']);
                $this->assertNotEquals($beforeUpload['TUser']['avatar_user'], $afterUpload['TUser']['avatar_user']);
            } else {
                // update avatar_cover
                $this->assertNotEmpty($afterUpload['TUser']['cover_image']);
                $this->assertNotEquals($beforeUpload['TUser']['cover_image'], $afterUpload['TUser']['cover_image']);
            }
        } else {
            $this->assertEmpty($afterUpload['TUser']['avatar_user']);
            $this->assertEmpty($afterUpload['TUser']['cover_image']);

            $this->assertEquals($beforeUpload['TUser']['avatar_user'], $afterUpload['TUser']['avatar_user']);
            $this->assertEquals($beforeUpload['TUser']['cover_image'], $afterUpload['TUser']['cover_image']);
        }
        CakeSession::delete("Auth.User");
    }

    public function uploadFileProvider() {
        return array(
            // case 1: upload avatar profile, full message => success
            array(
                1, //upload avatar
                'file' => array(
                    'error' => UPLOAD_ERR_OK,
                    'name' => '60141006_2425036027548198_7817765159409025024_n.jpg',  // WRONG TYPE
                    'size' => 112547,
                    'tmp_name' => '/tmp/phppxAdOg',
                    'type' => 'image/jpeg'
                ),
                1 // status
            ),
            // case 2: upload cover image, full message => success
            array(
                2, // upload cover
                'file' => array(
                    'name' => '60141006_2425036027548198_7817765159409025024_n.jpg',
                    'type' => 'image/png',
                    'tmp_name' => '/tmp/php1LTVMO',
                    'error' => 0,
                    'size' => 215863
                ),
                1
            ),
            // case 3: upload avatar file empty => fail
            array(
                1,
                null,
                0
            )
        );
    }
}