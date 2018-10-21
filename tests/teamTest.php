<?php
/**
 * Created by PhpStorm.
 * User: Cedric
 * Date: 21/10/2018
 * Time: 18:09
 */

namespace App\Tests\Util;

use App\Entity\Team;
use PHPUnit\Framework\TestCase;

class teamTest extends TestCase
{
    public function test()
    {
        $team = new Team();

        $team->setName("champagne");
        $result = $team->getName();

        $this->assertEquals("champagne", $result);
    }
}