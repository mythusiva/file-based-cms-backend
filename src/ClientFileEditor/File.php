<?

namespace ClientFileEditor;

/**
* 
*/
class File
{
  
  private $path;

  public function __construct($path)
  {
    $this->path = $path;
  }

  public function getPath()
  {
    return $this->path;
  }

  public function getFilename()
  {
    return basename($this->path);
  }

  public function getContents()
  {
    return file_get_contents($this->path);
  }

  public function putContents($contents)
  {
    file_put_contents($this->path, $contents);
  }
}