<?php

declare(strict_types=1);

namespace App\Tests\src\Infrastructure\Repository;

use PHPUnit\Framework\TestCase;
use App\Domain\Repository\PersistenceRepository;
use App\Infrastructure\Repository\PictureFileSystemRepository;
use App\Domain\Picture;

class PictureFileSystemRepositoryTest extends TestCase
{
    private $mockPersistenceRepository;
    private $pictureRepository;
    
    public function setUp(): void 
    {
        $this->mockPersistenceRepository = $this->createMock(PersistenceRepository::class);
        $this->pictureRepository = new PictureFileSystemRepository($this->mockPersistenceRepository);
    }
    
    public function testFindByIdWithResult():void
    {
        $this->mockPersistenceRepository->method('findAllPictures')->willReturn(array($this->createPictureEntity()));
        $picture = $this->pictureRepository->findById(1);

        $this->assertIsObject($picture);
        $this->assertInstanceOf(Picture::class, $picture);
    }

    public function testFindByIdWithoutResult(): void
    {
        $this->mockPersistenceRepository->method('findAllPictures')->willReturn(array());
        $picture = $this->pictureRepository->findById(1);

        $this->assertNull($picture);
    }
    
    private function createPictureEntity(): Picture
    {
        return new Picture(1, 'https://www.idealista.com/pictures/1', 'SD');
    }
}
