<?php
require_once MSC_LIB . '/FileTask.php';
require_once MSC_LIB . '/FileRepo.php';

class Msc_TaskController
{
    /**
     * @var Msc_FileRepo
     */
    protected $_inRepo;
    
    /**
     * @var Msc_FileRepo
     */
    protected $_outRepo;
    
    public function __construct(Msc_FileRepo $inRepo, Msc_FileRepo $outRepo) {
        $this->_inRepo = $inRepo;
        $this->_outRepo = $outRepo;
    }
    
    public function actionFullList()
    {
        $files = $this->_outRepo->getAllFilenames();
        $result = array();
        foreach ($files as $file) {
            $fileTask = new Msc_FileTask($this->_inRepo->fullDir . '/' . $file,
                                         $this->_outRepo->fullDir . '/' . $file);
            $result[] = $fileTask->toArray();
        }
        return json_encode($result);
    }
}
