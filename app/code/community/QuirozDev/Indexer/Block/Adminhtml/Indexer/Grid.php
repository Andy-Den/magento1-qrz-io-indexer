<?php

class QuirozDev_Indexer_Block_Adminhtml_Indexer_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    /**
     * @author Cristian Quiroz <cris@qcas.co>
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('qdev_indexer_processes_grid');
        $this->_filterVisibility = false;
        $this->_pagerVisibility = false;
    }

    /**
     * @return QuirozDev_Indexer_Block_Adminhtml_Indexer_Grid
     * @author Cristian Quiroz <cris@qcas.co>
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('quirozdev_indexer/indexer')->getIndexProcessCollection();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * Add name and description to collection elements
     * @return QuirozDev_Indexer_Block_Adminhtml_Indexer_Grid
     * @author Cristian Quiroz <cris@qcas.co>
     */
    protected function _afterLoadCollection()
    {
        /** @var $item Mage_Index_Model_Process */
        foreach ($this->_collection as $key => $item) {
            if (!$item->getIndexer()->isVisible()) {
                $this->_collection->removeItemByKey($key);
                continue;
            }
            $item->setName($item->getIndexer()->getName());
            $item->setDescription($item->getIndexer()->getDescription());
        }

        return parent::_afterLoadCollection();
    }

    /**
     * Prepare grid columns
     * @return QuirozDev_Indexer_Block_Adminhtml_Indexer_Grid
     * @author Cristian Quiroz <cris@qcas.co>
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'indexer_code',
            array(
                'header'   => Mage::helper('index')->__('Index'),
                'width'    => '180',
                'align'    => 'left',
                'index'    => 'name',
                'sortable' => false,
            )
        );

        $this->addColumn(
            'description',
            array(
                'header'   => Mage::helper('index')->__('Description'),
                'align'    => 'left',
                'index'    => 'description',
                'sortable' => false,
            )
        );

        $this->addColumn('action',
            array(
                'header'    => Mage::helper('index')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getIndexerCode',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('index')->__('Reindex Now'),
                        'url'     => array('base' => '*/*/reindex'),
                        'field'   => 'indexer_code'
                    ),
                ),
                'filter'    => false,
                'sortable'  => false,
                'is_system' => true,
            )
        );

        return parent::_prepareColumns();
    }


    /**
     * @param mixed $row
     * @return null
     * @author Cristian Quiroz <cris@qcas.co>
     */
    public function getRowUrl($row)
    {
        return null;
    }
}