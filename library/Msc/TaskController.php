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
    
    public function __construct(FileRepo $inRepo, FileRepo $outRepo) {
        $this->_inRepo = $inRepo;
        $this->_outRepo = $outRepo;
    }
    
    public function actionFullList()
    {
        $files = $this->_outRepo->getAllFilenames();
        $result = array();
        foreach ($files as $file) {
            $fileTask = new FileTask($this->_inRepo->fullDir . '/' . $file,
                                         $this->_outRepo->fullDir . '/' . $file);
            $result[] = $fileTask->toArray();
        }
        return json_encode($result);
    }
}
