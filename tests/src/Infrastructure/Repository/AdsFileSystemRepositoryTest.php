<?php

declare(strict_types=1);

namespace App\Tests\src\Infrastructure\Repository;

use PHPUnit\Framework\TestCase;
use App\Domain\Repository\PersistenceRepository;
use App\Domain\Repository\PictureRepository;
use App\Infrastructure\Repository\AdsFileSystemRepository;
use App\Domain\Ad;
use App\Domain\Picture;
use App\Domain\PublicAd;
use App\Domain\QualityAd;

class AdsFileSystemRepositoryTest extends TestCase
{
    private $mockPersistenceRepository;
    private $mockPictureRepository;
    private $adsFileSystemRepository;
    
    public function setUp(): void 
    {
        $this->mockPersistenceRepository = $this->createMock(PersistenceRepository::class);
        $this->mockPictureRepository = $this->createMock(PictureRepository::class);
        
        $this->adsFileSystemRepository = new AdsFileSystemRepository($this->mockPersistenceRepository, $this->mockPictureRepository);
    }
    
    public function testListAdsForIdealistUsersWithResult()
    {
        $adEntities[] = new Ad(1, 'CHALET', 'Este piso es una ganga, compra, compra, COMPRA!!!!!', [], 300, null, 50, null);
        $adEntities[] = new Ad(2, 'FLAT', 'Nuevo ático céntrico recién reformado. No deje pasar la oportunidad y adquiera este ático de lujo', [4], 300, null, 89, null);
        $pictureEntity = new Picture(1, 'https://www.idealista.com/pictures/1', 'SD');
        
        $this->mockPersistenceRepository->method('findAllAds')->willReturn($adEntities);
        $this->mockPictureRepository->method('findById')->willReturn($pictureEntity);
        
        $adsForIdealistUsers = $this->adsFileSystemRepository->listAdsForIdealistUsers();
        
        $this->assertIsArray($adsForIdealistUsers);
        $this->assertInstanceOf(PublicAd::class, $adsForIdealistUsers[0]);
    }
    
    public function testListAdsForIdealistUsersWithResultWithoutScore()
    {
        $adEntities[] = new Ad(1, 'CHALET', 'Este piso es una ganga, compra, compra, COMPRA!!!!!', [], 300, null, 30, null);
        $adEntities[] = new Ad(2, 'FLAT', 'Nuevo ático céntrico recién reformado. No deje pasar la oportunidad y adquiera este ático de lujo', [4], 300, null, 10, null);
               
        $this->mockPersistenceRepository->method('findAllAds')->willReturn($adEntities);        
        $adsForIdealistUsers = $this->adsFileSystemRepository->listAdsForIdealistUsers();
        
        $this->assertIsArray($adsForIdealistUsers);
        $this->assertEmpty($adsForIdealistUsers);
    }
    
    public function testListAdsForIdealistUsersWithoutResult()
    {        
        $this->mockPersistenceRepository->method('findAllAds')->willReturn(array());
        $adsForIdealistUsers = $this->adsFileSystemRepository->listAdsForIdealistUsers();
        
        $this->assertIsArray($adsForIdealistUsers);
        $this->assertEmpty($adsForIdealistUsers);
    }
    
    public function testListAdsForQualityUsersWithResult()
    {
        $adEntities[] = new Ad(1, 'CHALET', 'Este piso es una ganga, compra, compra, COMPRA!!!!!', [], 300, null, 30, null);
        $adEntities[] = new Ad(2, 'FLAT', 'Nuevo ático céntrico recién reformado. No deje pasar la oportunidad y adquiera este ático de lujo', [4], 300, null, 10, null);
        $pictureEntity = new Picture(1, 'https://www.idealista.com/pictures/1', 'SD');
        
        $this->mockPersistenceRepository->method('findAllAds')->willReturn($adEntities);
        $this->mockPictureRepository->method('findById')->willReturn($pictureEntity);
        
        $adsForQualityUsers = $this->adsFileSystemRepository->listAdsForQualityUsers();
        
        $this->assertIsArray($adsForQualityUsers);
        $this->assertInstanceOf(QualityAd::class, $adsForQualityUsers[0]);
    }
    
    public function testListAdsForQualityUsersWithOutResult()
    {
        $this->mockPersistenceRepository->method('findAllAds')->willReturn(array());
        
        $adsForQualityUsers = $this->adsFileSystemRepository->listAdsForQualityUsers();
        
        $this->assertIsArray($adsForQualityUsers);
        $this->assertEmpty($adsForQualityUsers);
    }
}
