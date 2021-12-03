<?php

declare(strict_types=1);

namespace App\Tests\src\Infrastructure\Service;

use PHPUnit\Framework\TestCase;
use App\Infrastructure\Service\ProcessCalculatePointsForPicture;
use App\Domain\Repository\PictureRepository;
use App\Domain\Ad;
use App\Domain\Picture;

class ProcessCalculatePointsForPictureTest extends TestCase
{
    private $mockPictureRepository;
    private $calculatePointsForPicture;
    
    public function setUp(): void 
    {
        $this->mockPictureRepository = $this->createMock(PictureRepository::class);        
        $this->calculatePointsForPicture = new ProcessCalculatePointsForPicture($this->mockPictureRepository);
    }
    
    public function testProccessAdWithoutPicture(): void
    {
        $adEntity = new Ad(1, 'CHALET', 'Este piso es una ganga, compra, compra, COMPRA!!!!!', [], 300, null, null, null);
        $ad = $this->calculatePointsForPicture->calculate($adEntity);
        
        $this->assertInstanceOf(Ad::class, $ad);
        $this->assertEquals(0, $ad->score());
    }
    
    public function testProccessAdWithoutPictureLoseScore(): void
    {
        $adEntity = new Ad(1, 'CHALET', 'Este piso es una ganga, compra, compra, COMPRA!!!!!', [], 300, null, 40, null);
        $ad = $this->calculatePointsForPicture->calculate($adEntity);
        
        $this->assertInstanceOf(Ad::class, $ad);
        $this->assertEquals(30, $ad->score());
    }
    
    public function testProccessAdWithPictureHd(): void
    {
        $pictureEntity = new Picture(1, 'https://www.idealista.com/pictures/1', 'HD');
        $adEntity = new Ad(1, 'CHALET', 'Este piso es una ganga, compra, compra, COMPRA!!!!!', [1], 300, null, null, null);
        
        $this->mockPictureRepository->method('findById')->willReturn($pictureEntity);
        $ad = $this->calculatePointsForPicture->calculate($adEntity);
        
        $this->assertInstanceOf(Ad::class, $ad);
        $this->assertEquals(20, $ad->score());
    }
    
    public function testProccessAdWithPictureSd(): void
    {
        $pictureEntity = new Picture(1, 'https://www.idealista.com/pictures/1', 'SD');
        $adEntity = new Ad(1, 'CHALET', 'Este piso es una ganga, compra, compra, COMPRA!!!!!', [1], 300, null, null, null);
        
        $this->mockPictureRepository->method('findById')->willReturn($pictureEntity);
        $ad = $this->calculatePointsForPicture->calculate($adEntity);
        
        $this->assertInstanceOf(Ad::class, $ad);
        $this->assertEquals(10, $ad->score());
    }
    
    public function testProccessAdWithDiferentPictures():void
    {
        $pictureEntity = new Picture(1, 'https://www.idealista.com/pictures/1', 'SD');
        $pictureEntitySecondary = new Picture(2, 'https://www.idealista.com/pictures/2', 'HD');
        
        $adEntity = new Ad(1, 'CHALET', 'Este piso es una ganga, compra, compra, COMPRA!!!!!', [1, 2], 300, null, null, null);
        
        $this->mockPictureRepository->method('findById')->willReturnOnConsecutiveCalls($pictureEntity, $pictureEntitySecondary);
        $ad = $this->calculatePointsForPicture->calculate($adEntity);
        
        $this->assertInstanceOf(Ad::class, $ad);
        $this->assertEquals(30, $ad->score());
    }
    
    public function testProccessAdWithTwoPicturesHD(): void
    {
        $pictureEntity = new Picture(1, 'https://www.idealista.com/pictures/1', 'HD');
        $pictureEntitySecondary = new Picture(2, 'https://www.idealista.com/pictures/2', 'HD');
        
        $adEntity = new Ad(1, 'CHALET', 'Este piso es una ganga, compra, compra, COMPRA!!!!!', [1, 2], 300, null, null, null);
        
        $this->mockPictureRepository->method('findById')->willReturnOnConsecutiveCalls($pictureEntity, $pictureEntitySecondary);
        $ad = $this->calculatePointsForPicture->calculate($adEntity);
        
        $this->assertInstanceOf(Ad::class, $ad);
        $this->assertEquals(40, $ad->score());
    }
    
    public function testProccessAdWithTwoPicturesSD(): void
    {
        $pictureEntity = new Picture(1, 'https://www.idealista.com/pictures/1', 'SD');
        $pictureEntitySecondary = new Picture(2, 'https://www.idealista.com/pictures/2', 'SD');
        
        $adEntity = new Ad(1, 'CHALET', 'Este piso es una ganga, compra, compra, COMPRA!!!!!', [1, 2], 300, null, null, null);
        
        $this->mockPictureRepository->method('findById')->willReturnOnConsecutiveCalls($pictureEntity, $pictureEntitySecondary);
        $ad = $this->calculatePointsForPicture->calculate($adEntity);
        
        $this->assertInstanceOf(Ad::class, $ad);
        $this->assertEquals(20, $ad->score());
    }
}
