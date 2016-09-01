<?

namespace ClientFileEditor\Service;

use ClientFileEditor\File;

/**
* 
*/
class FileService
{

  private $filesDirectory;
  
  function __construct($filesDirectory)
  {
    $this->filesDirectory = rtrim($filesDirectory,'/');
  }

 
  /**
   * Returns a list of Files in the specified directory.
   * This method is NOT recursive.
   **/ 
  public function getFiles()
  {
    $files = glob($this->filesDirectory . '/*.html');
    natsort($files);
    $listOfFiles = [];
    foreach ($files as $filePath) {
      $file = new File($filePath);
      $listOfFiles[$file->getFilename()] = $file;
    }
    return $listOfFiles;
  }

}