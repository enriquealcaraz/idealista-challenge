<?php

declare(strict_types=1);

namespace App\Tests\src\Domain\Service;

use PHPUnit\Framework\TestCase;
use App\Domain\Service\ProcessCalculatePointsForDescription;
use App\Domain\Ad;

class ProcessCalculatePointsForDescriptionTest extends TestCase
{
    private $processCalculatePointsForDescription;
    
    public function setUp(): void 
    {
        $this->processCalculatePointsForDescription = new ProcessCalculatePointsForDescription();
    }
    
    public function testDescriptionNotNull()
    {
        $adEntity = new Ad(1, 'CHALET', 'Este piso es una ganga, compra, compra, COMPRA!!!!!', [], 300, null, null, null);
        
        $ad = $this->processCalculatePointsForDescription->calculate($adEntity);
        
        $this->assertInstanceOf(Ad::class, $ad);
        $this->assertEquals(5, $adEntity->score());
    }
    
    public function testLengthDescriptionFlatBetween29And49()
    {
        $description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec elit nibh, consequat et rhoncus sed, venenatis posuere leo. Etiam nunc mauris, facilisis quis dapibus vel, dapibus at nisi. Donec nec elit a erat elementum suscipit.';
        $adEntity = new Ad(1, 'FLAT', $description, [], 300, null, null, null);
        
        $ad = $this->processCalculatePointsForDescription->calculate($adEntity);
        
        $this->assertInstanceOf(Ad::class, $ad);
        $this->assertEquals(15, $adEntity->score());
    }
    
    public function testLengthDescriptionFlat20Words()
    {
        $description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin velit sem, porta at commodo aliquam, tristique et leo. Pellentesque habitant.';
        $adEntity = new Ad(1, 'FLAT', $description, [], 300, null, null, null);
        
        $ad = $this->processCalculatePointsForDescription->calculate($adEntity);
        
        $this->assertInstanceOf(Ad::class, $ad);
        $this->assertEquals(15, $adEntity->score());
    }
    
    public function testLengthDescriptionFlat49Words()
    {
        $description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec et sollicitudin neque. Nullam dignissim in enim non elementum. Nullam condimentum orci at tellus aliquam, accumsan cursus elit ultricies. Suspendisse non purus nec sapien luctus elementum. Ut gravida, urna vitae tempus semper, mi magna lobortis sapien, id mattis mauris diam.';
        $adEntity = new Ad(1, 'FLAT', $description, [], 300, null, null, null);
        
        $ad = $this->processCalculatePointsForDescription->calculate($adEntity);
        
        $this->assertInstanceOf(Ad::class, $ad);
        $this->assertEquals(15, $adEntity->score());
    }
    
    
    public function testLengthDescriptionFlatUp50()
    {
        $description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque pretium, mi vel dignissim accumsan, ligula sapien gravida lectus, ac vestibulum magna arcu ac justo. Quisque semper, ex vitae condimentum dignissim, velit ex eleifend elit, ut fermentum mi nibh sed velit. Aliquam faucibus bibendum dolor. Nullam convallis orci sed turpis hendrerit vestibulum. Nullam et dui porttitor, rhoncus ante.';
        $adEntity = new Ad(1, 'FLAT', $description, [], 300, null, null, null);
        
        $ad = $this->processCalculatePointsForDescription->calculate($adEntity);
        
        $this->assertInstanceOf(Ad::class, $ad);
        $this->assertEquals(35, $adEntity->score());
    }
    
    public function testLengthDescriptionFlat50()
    {
        $description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam mattis feugiat maximus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed aliquam augue nec feugiat ornare. In ut dolor sit amet ligula porttitor vestibulum. Quisque ultricies hendrerit eros sit amet elementum. Donec non dignissim urna, in consequat lectus. Etiam eget.';
        $adEntity = new Ad(1, 'FLAT', $description, [], 300, null, null, null);
        
        $ad = $this->processCalculatePointsForDescription->calculate($adEntity);
        
        $this->assertInstanceOf(Ad::class, $ad);
        $this->assertEquals(35, $adEntity->score());
    }
    
    public function testLengthDescriptionChalet50()
    {
        $description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam mattis feugiat maximus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed aliquam augue nec feugiat ornare. In ut dolor sit amet ligula porttitor vestibulum. Quisque ultricies hendrerit eros sit amet elementum. Donec non dignissim urna, in consequat lectus. Etiam eget.';
        $adEntity = new Ad(1, 'CHALET', $description, [], 300, null, null, null);
        
        $ad = $this->processCalculatePointsForDescription->calculate($adEntity);
        
        $this->assertInstanceOf(Ad::class, $ad);
        $this->assertEquals(5, $adEntity->score());
    }
    
    public function testLengthDescriptionChaletUp50()
    {
        $description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque pretium, mi vel dignissim accumsan, ligula sapien gravida lectus, ac vestibulum magna arcu ac justo. Quisque semper, ex vitae condimentum dignissim, velit ex eleifend elit, ut fermentum mi nibh sed velit. Aliquam faucibus bibendum dolor. Nullam convallis orci sed turpis hendrerit vestibulum. Nullam et dui porttitor, rhoncus ante.';
        $adEntity = new Ad(1, 'CHALET', $description, [], 300, null, null, null);
        
        $ad = $this->processCalculatePointsForDescription->calculate($adEntity);
        
        $this->assertInstanceOf(Ad::class, $ad);
        $this->assertEquals(25, $adEntity->score());
    }    
    
    public function testKeyWordsDescription()
    {
        $description = 'Luminoso Nuevo Céntrico Reformado Ático';
        $adEntity = new Ad(1, 'CHALET', $description, [], 300, null, null, null);
        
        $ad = $this->processCalculatePointsForDescription->calculate($adEntity);
        
        $this->assertInstanceOf(Ad::class, $ad);
        $this->assertEquals(30, $adEntity->score());
    }
    
    public function testAnyKeyWordsDescription()
    {
        $description = 'Luminoso Nuevo Céntrico';
        $adEntity = new Ad(1, 'FLAT', $description, [], 300, null, null, null);
        
        $ad = $this->processCalculatePointsForDescription->calculate($adEntity);
        
        $this->assertInstanceOf(Ad::class, $ad);
        $this->assertEquals(20, $adEntity->score());
    }
}
