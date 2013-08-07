<?php
/**
 * XXTEATest.php
 * @author: Revin Roman <xgismox@gmail.com>
 */

namespace xxteatest\xxtea;

use xxteatest\TestCase;
use yii\xxtea\XXTEA;

class XXTEATest extends TestCase
{

	public function testMain()
	{
		$this->assertInstanceOf('yii\xxtea\Crypt_XXTEA', $this->XXTEA()->crypt());

		$source_data = 'very important data';

		$hash = $this->XXTEA()->encrypt($source_data);
		$this->assertNotEmpty($hash);

		$data = $this->XXTEA()->decrypt($hash);
		$this->assertEquals($source_data, $data);

		$this->assertEmpty($this->XXTEA()->encrypt(''));
		$this->assertEmpty($this->XXTEA()->decrypt(''));
	}

	/**
	 * @return \yii\xxtea\XXTEA
	 */
	private function XXTEA()
	{
		return \Yii::$app->getComponent('xxtea');
	}

	public function testNullKeyExceptions()
	{
		$this->setExpectedException('yii\xxtea\XXTEAException', 'The secret key must be a string.');
		$this->XXTEA()->crypt()->setKey(null);
	}

	public function testNullKeyConfigExceptions()
	{
		$this->setExpectedException('yii\xxtea\XXTEAException', 'Secret key is undefined.');
		\Yii::createObject(['class' => 'yii\xxtea\XXTEA']);
	}

	public function testEmptyKeyExceptions()
	{
		$this->setExpectedException('yii\xxtea\XXTEAException', 'The secret key cannot be empty.');
		$this->XXTEA()->crypt()->setKey('');
	}

	public function testEmptyEncodeDataExceptions()
	{
		$this->setExpectedException('yii\xxtea\XXTEAException', 'The plain text must be a string.');
		$this->XXTEA()->encrypt([]);
	}

	public function testEmptyDecodeDataExceptions()
	{
		$this->setExpectedException('yii\xxtea\XXTEAException', 'The cipher text must be a string.');
		$this->XXTEA()->decrypt([]);
	}
}