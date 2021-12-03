<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Domain\Ad;
use App\Domain\Picture;
use Symfony\Component\Filesystem\Filesystem;
use App\Domain\Repository\PersistenceRepository;

final class InFileSystemPersistence implements PersistenceRepository
{
    public const FILE_PATH_ADS = __DIR__ . "/adsdb.txt";
    public const FILE_PATH_PICTURES = __DIR__ . "/picturesdb.txt";
    
    private array $ads = [];
    private array $pictures = [];
    private Filesystem $fileSystem;
    
    public function __construct(Filesystem $fileSystem)
    {
        array_push($this->ads, new Ad(1, 'CHALET', 'Este piso es una ganga, compra, compra, COMPRA!!!!!', [], 300, null, null, null));
        array_push($this->ads, new Ad(2, 'FLAT', 'Nuevo ático céntrico recién reformado. No deje pasar la oportunidad y adquiera este ático de lujo', [4], 300, null, null, null));
        array_push($this->ads, new Ad(3, 'CHALET', '', [2], 300, null, null, null));
        array_push($this->ads, new Ad(4, 'FLAT', 'Ático céntrico muy luminoso y recién reformado, parece nuevo', [5], 300, null, null, null));
        array_push($this->ads, new Ad(5, 'FLAT', 'Pisazo,', [3, 8], 300, null, null, null));
        array_push($this->ads, new Ad(6, 'GARAGE', '', [6], 300, null, null, null));
        array_push($this->ads, new Ad(7, 'GARAGE', 'Garaje en el centro de Albacete', [], 300, null, null, null));
        array_push($this->ads, new Ad(8, 'CHALET', 'Maravilloso chalet situado en lAs afueras de un pequeño pueblo rural. El entorno es espectacular, las vistas magníficas. ¡Cómprelo ahora!', [1, 7], 300, null, null, null));

        array_push($this->pictures, new Picture(1, 'https://www.idealista.com/pictures/1', 'SD'));
        array_push($this->pictures, new Picture(2, 'https://www.idealista.com/pictures/2', 'HD'));
        array_push($this->pictures, new Picture(3, 'https://www.idealista.com/pictures/3', 'SD'));
        array_push($this->pictures, new Picture(4, 'https://www.idealista.com/pictures/4', 'HD'));
        array_push($this->pictures, new Picture(5, 'https://www.idealista.com/pictures/5', 'SD'));
        array_push($this->pictures, new Picture(6, 'https://www.idealista.com/pictures/6', 'SD'));
        array_push($this->pictures, new Picture(7, 'https://www.idealista.com/pictures/7', 'SD'));
        array_push($this->pictures, new Picture(8, 'https://www.idealista.com/pictures/8', 'HD'));
        
        $this->fileSystem = $fileSystem;
        $this->initDatabase();
    }
    
    private function initDatabase(): void
    {        
        if (!$this->fileSystem->exists(self::FILE_PATH_ADS))
        {
            $this->fileSystem->touch(self::FILE_PATH_ADS);
            $this->fileSystem->chmod(self::FILE_PATH_ADS, 0777);
            $this->fileSystem->dumpFile(self::FILE_PATH_ADS, serialize($this->ads));            
        }
        
        if (!$this->fileSystem->exists(self::FILE_PATH_PICTURES))
        {
            $this->fileSystem->touch(self::FILE_PATH_PICTURES);
            $this->fileSystem->chmod(self::FILE_PATH_PICTURES, 0777);
            $this->fileSystem->dumpFile(self::FILE_PATH_PICTURES, serialize($this->pictures));            
        }
    }
    
    public function findAllAds(): array
    {
        return unserialize(file_get_contents(self::FILE_PATH_ADS));
    }
    
    public function findAllPictures(): array
    {
        return unserialize(file_get_contents(self::FILE_PATH_PICTURES));
    }
    
    public function updateAds(array $adsList): void
    {
        $this->fileSystem->remove(self::FILE_PATH_ADS);
        
        $this->fileSystem->touch(self::FILE_PATH_ADS);
        $this->fileSystem->chmod(self::FILE_PATH_ADS, 0777);
        $this->fileSystem->dumpFile(self::FILE_PATH_ADS, serialize($adsList));
    }
}
