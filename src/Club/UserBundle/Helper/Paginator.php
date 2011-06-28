<?php

namespace Club\UserBundle\Helper;

class Paginator {

    //current displayed page
    protected $currentpage;
    //limit items on one page
    protected $limit;
    //total number of pages that will be generated
    protected $numpages;
    //total items loaded from database
    protected $itemscount;
    //starting item number to be shown on page
    protected $offset;
    //Current url
    protected $currentUrl;

    protected $options;

    function __construct($itemscount, $currenturl, $options=array(10,20,30,50,100,500)) {
        //set total items count from controller
        $this->itemscount = $itemscount;
        //get params from request URL
        $this->getParamsFromRequest();
        //Calculate number of pages total
        $this->getInternalNumPages();
        //Calculate first shown item on current page
        $this->calculateOffset();

        $this->currentUrl = $currenturl;

        $this->options = $options;
    }

    private function getParamsFromRequest() {
        //If current page number is set in URL
        if (isset($_GET['page'])) {
            $this->currentpage = $_GET['page'];
        } else {
            //else set default page to render
            $this->currentpage = 1;
        }
        //If limit is defined in URL
        if (isset($_GET['limit'])) {
            $this->limit = $_GET['limit'];
        } else {   //else set default limit to 20
            $this->limit = 50;
        }
        //If currentpage is set to null or is set to 0 or less
        //set it to default (1)
        if (($this->currentpage == null) || ($this->currentpage < 1)) {
            $this->currentpage = 1;
        }
        //if limit is set to null set it to default (50)
        if (($this->limit == null)) {
            $this->limit = 50;
            //if limit is any number less than 1 then set it to 0 for displaying
            //items without limit
        } else if ($this->limit < 1) {
            $this->limit = 0;
        }
    }

    public function getNumpages() {
        return $this->numpages;
    }

    private function getInternalNumPages() {
        //If limit is set to 0 or set to number bigger then total items count
        //display all in one page
        if (($this->limit < 1) || ($this->limit > $this->itemscount)) {
            $this->numpages = 1;
        } else {
            //Calculate rest numbers from dividing operation so we can add one
            //more page for this items
            $restItemsNum = $this->itemscount % $this->limit;
            //if rest items > 0 then add one more page else just divide items
            //by limit
            $restItemsNum > 0 ? $this->numpages = intval($this->itemscount / $this->limit) + 1 : $this->numpages = intval($this->itemscount / $this->limit);
        }
    }

    public function getOptions() {
        return $this->options;
    }

    public function setOptions($options) {
        $this->options = $options;
    }


    private function calculateOffset() {
        //Calculet offset for items based on current page number
        $this->offset = ($this->currentpage - 1) * $this->limit;
    }

    public function getCurrentpage() {
        return $this->currentpage;
    }

    public function getCurrentUrl() {
        return $this->currentUrl;
    }

        //For using from controller
    public function getLimit() {
        return $this->limit;
    }
    //For using from controller
    public function getOffset() {
        return $this->offset;
    }

    public function getItemsCount()
    {
      return $this->itemscount;
    }
}
