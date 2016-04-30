<?php
namespace Users\Controller\Component;

use Cake\Controller\Component;
use Cake\Filesystem\Folder;

class UploaderComponent extends Component
{

    public $controller = null;

    public function initialize(array $config = [])
    {
        $this->controller = $this->_registry->getController();
    }

    /**
     * @param $file
     * @param string $destination
     * @return array|bool
     */
    public function uploadImage($file, $destination = 'webroot')
    {
        if(!empty($file) && ($file['error'] == 0)){
            if($this->controller->Auth->user('id')){
                $userId = $this->controller->Auth->user('id');
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $name = pathinfo($file['name'], PATHINFO_FILENAME);
                if(in_array($ext, ['jpeg', 'jpg', 'png', 'gif'])){
                    $newFileName = $this->_uniqueString() . '.' . $ext;
                    $uploadFolder = new Folder(WWW_ROOT . $destination, true, 0755);

                    if(move_uploaded_file($file['tmp_name'], $uploadFolder->path . DS . $newFileName)){
                        $fileInfo = [
                            'user_id' => $userId,
                            'name' => $name,
                            'mime_type' => $file['type'],
                            'size' => $file['size'],
                            'path' => str_replace(DS, '/', ($destination . DS . $newFileName)),
                        ];
                        return $fileInfo;
                    }
                }
            }
        }
        return false;
    }

//    private function __createOtherSizes($destinationPath, $fileName){
//        $cropSizes = Configure::read('FileManager.settings.size');
//        list($name, $ext) = explode('.', $fileName);
//        foreach($cropSizes as $alias => $size){
//            $resizeImage = new ResizeImage($destinationPath . DS . $fileName);
//            $resizeImage->resizeTo($size[0], $size[1], 'maxWidth');
//            $resizeImage->saveImage($destinationPath . DS . $name . '_' . $alias . '.' . $ext);
//        }
//    }

    /**
     * @param int $length
     * @return string
     */
    protected function _uniqueString($length = 32)
    {
        return substr(str_shuffle(md5(time())), 0, $length);
    }
}