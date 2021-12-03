<?php

declare(strict_types=1);

namespace App\Tests\src\Domain\Service;

use PHPUnit\Framework\TestCase;
use App\Domain\Service\ProcessCalculatePointsForAdCompleted;
use App\Domain\Ad;
use DateTimeImmutable;

class ProcessCalculatePointsForAdCompletedTest extends TestCase
{
    private $processCalculatePointsForAdCompleted;
    
    public function setUp(): void 
    {
        $this->processCalculatePointsForAdCompleted = new ProcessCalculatePointsForAdCompleted();
    }
    
    public function testFlatAdIscompleted()
    {
        $adEntity = new Ad(1, 'FLAT', 'Este piso es una ganga, compra, compra, COMPRA!!!!!', [1], 300, null, null, null);
        
        $ad = $this->processCalculatePointsForAdCompleted->calculate($adEntity);
        
        $this->assertEquals(40, $ad->score());
    }
    
    public function testChaletAdIscompleted()
    {
        $adEntity = new Ad(1, 'CHALET', 'Este piso es una ganga, compra, compra, COMPRA!!!!!', [1], 300, 500, null, null);
        
        $ad = $this->processCalculatePointsForAdCompleted->calculate($adEntity);
        
        $this->assertEquals(40, $ad->score());
    }
    
    public function testGarageAdIscompleted()
    {
        $adEntity = new Ad(1, 'GARAGE', '', [1], 300, null, null, null);
        
        $ad = $this->processCalculatePointsForAdCompleted->calculate($adEntity);
        
        $this->assertEquals(40, $ad->score());
    }
    
     public function testGarageAdIsIrrelevant()
    {
        $adEntity = new Ad(1, 'GARAGE', '', [], 300, null, 20, null);
        
        $ad = $this->processCalculatePointsForAdCompleted->calculate($adEntity);
        
        $this->assertEquals(20, $ad->score());
        $this->assertInstanceOf(DateTimeImmutable::class, $ad->irrelevantSince());
    }
    
    public function testChaletAdIsIrrelevant()
    {
        $adEntity = new Ad(1, 'CHALET', 'Este piso es una ganga, compra, compra, COMPRA!!!!!', [], 300, 500, 35, null);
        
        $ad = $this->processCalculatePointsForAdCompleted->calculate($adEntity);
        
        $this->assertEquals(35, $ad->score());
        $this->assertInstanceOf(DateTimeImmutable::class, $ad->irrelevantSince());
    }
    
    public function testChaletAdIsNotIrrelevant()
    {
        $adEntity = new Ad(1, 'CHALET', 'Este piso es una ganga, compra, compra, COMPRA!!!!!', [1], 300, 500, 35, null);
        
        $ad = $this->processCalculatePointsForAdCompleted->calculate($adEntity);
        
        $this->assertEquals(75, $ad->score());
        $this->assertEquals(null, $ad->irrelevantSince());
    }
}
