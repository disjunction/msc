<?php
namespace Msc;

require_once MSC_LIB . '/FileTask.php';
require_once MSC_LIB . '/FileRepo.php';

class TaskController
{
    /**
     * @var FileRepo
     */
    protected $_inRepo;
    
    /**
     * @var FileRepo
     */
    protected $_outRepo;
    
    protected $_request;
    
    public function __construct(FileRepo $inRepo, FileRepo $outRepo, array $request) {
        $this->_inRepo = $inRepo;
        $this->_outRepo = $outRepo;
        $this->_request = $request;
    }
    
    public function actionFullList() {
        $files = array_unique(array_merge($this->_outRepo->getAllFilenames(), $this->_inRepo->getAllFilenames()));
        $result = array();
        foreach ($files as $file) {
            $fileTask = new FileTask($this->_inRepo->fullDir . '/' . $file,
                                         $this->_outRepo->fullDir . '/' . $file);
            $result[] = $fileTask->toArray();
        }
        return json_encode($result);
    }
    
    public function actionUpload() {
        $this->_inRepo->upload($_FILES['file']);
    }
    
    public function actionRemove() {
        $file = $this->_request['f'];
        $this->_inRepo->remove($file);
        $this->_outRepo->remove($file);
    }
}
