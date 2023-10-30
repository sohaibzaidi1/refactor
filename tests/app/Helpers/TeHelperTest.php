<?php 
use PHPUnit\Framework\TestCase;
use App\Helpers\TeHelper;

class TeHelperTest extends TestCase
{
    public function testWillExpireAtWhenDifferenceIsLessThan90Hours()
    {
        $dueTime = now()->addHours(60); // Due time 60 hours from now
        $createdAt = now();

        $result = TeHelper::willExpireAt($dueTime, $createdAt);

        $this->assertEquals($dueTime, $result);
    }

    public function testWillExpireAtWhenDifferenceIsLessThan24Hours()
    {
        $dueTime = now()->addHours(20); // Due time 20 hours from now
        $createdAt = now();

        $result = TeHelper::willExpireAt($dueTime, $createdAt);

        $expected = $createdAt->addMinutes(90);
        $this->assertEquals($expected, $result);
    }

    public function testWillExpireAtWhenDifferenceIsBetween24And72Hours()
    {
        $dueTime = now()->addHours(50); // Due time 50 hours from now
        $createdAt = now();

        $result = TeHelper::willExpireAt($dueTime, $createdAt);

        $expected = $createdAt->addHours(16);
        $this->assertEquals($expected, $result);
    }

    public function testWillExpireAtWhenDifferenceIsGreaterThan72Hours()
    {
        $dueTime = now()->addHours(96); // Due time 96 hours from now
        $createdAt = now();

        $result = TeHelper::willExpireAt($dueTime, $createdAt);

        $expected = $dueTime->subHours(48);
        $this->assertEquals($expected, $result);
    }
}
