<?php
/**
 * Class to paginate a list of items in a old digg style
 *
 * @author Darko Goleš
 * @author Carlos Mafla <gigo6000@hotmail.com>
 * @www.inchoo.net
 */
namespace Club\PaginatorBundle\Helper;

class PaginatorNg {

    /**
     * @var int current displayed page
     */
    protected $currentPage;

    /**
     * @var int items limit (items per page)
     */
    protected $limit;

    /**
     * @var int total number of pages
     */
    protected $numPages;

    /**
     * @var int items limit (items per page)
     */
    protected $itemsCount;

    /**
     * @var int offset
     */
    protected $offset;

    /**
     * @var int shows the last page
     */
    protected $endRange;

    /**
     * @var int pages to show at left and right of current page
     */
    protected $midRange;

    /**
     * @var array range
     */
    protected $range;

    /**
     * @var object paginator
     */
    protected $paginator;

    function __construct($limit, $midRange)
    {
        $this->limit = $limit;
        $this->midRange = $midRange;
    }

    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    public function setPaginator(\Doctrine\ORM\Tools\Pagination\Paginator $paginator)
    {
        $this->paginator = $paginator;
        $this->itemsCount = count($paginator);

        return $this;
    }

    public function setCurrentPage($currentPage = 1)
    {
        $this->currentPage = $currentPage;

        return $this;
    }

    public function init($results=null, $paginator = null, $page = null, $url = null)
    {
        if ($results) $this->setLimit($results);
        if ($paginator) $this->setPaginator($paginator);
        if ($page) $this->setCurrentPage($page);
        if ($url) $this->setUrl($url);

        //Set defaults
        $this->setDefaults();

        //Calculate number of pages total
        $this->getInternalNumPages();

        //Calculate first shown item on current page
        $this->calculateOffset();
        $this->calculateRange();

        return $this;
    }

    private function calculateRange()
    {
        $startRange = $this->currentPage - floor($this->midRange/2);
        $endRange = $this->currentPage + floor($this->midRange/2);

        if($startRange <= 0)
        {
            $endRange += abs($startRange)+1;
            $startRange = 1;
        }

        if($endRange > $this->numPages)
        {
            $startRange -= $endRange-$this->numPages;
            $endRange = $this->numPages;
            if ($startRange <= 0) {
                $startRange = 1;
            }
        }

        $this->range = range($startRange, $endRange);
        $this->endRange = $endRange;
    }

    private function setDefaults()
    {
        //If currentPage is set to null or is set to 0 or less
        //set it to default (1)
        if ($this->currentPage == null || $this->currentPage < 1)
        {
            $this->currentPage = 1;
        }
        //if limit is set to null set it to default (20)
        if ($this->limit == null)
        {
            $this->limit = 20;
            //if limit is any number less than 1 then set it to 0 for displaying
            //items without limit
        }
        else if ($this->limit < 1)
        {
            $this->limit = 0;
        }
    }

    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    private function getInternalNumPages()
    {
        //If limit is set to 0 or set to number bigger then total items count
        //display all in one page
        if ($this->limit < 1 || $this->limit > $this->itemsCount)
        {
            $this->numPages = 1;
        }
        else
        {
            //Calculate rest numbers from dividing operation so we can add one
            //more page for this items
            $restItemsNum = $this->itemsCount % $this->limit;
            //if rest items > 0 then add one more page else just divide items
            //by limit
            $this->numPages = $restItemsNum > 0 ? intval($this->itemsCount / $this->limit) + 1 : intval($this->itemsCount / $this->limit);
        }
    }

    private function calculateOffset()
    {
        //Calculet offset for items based on current page number
        $this->offset = ($this->currentPage - 1) * $this->limit;
    }

    /**
     * @return int number of pages
     */
    public function getNumPages()
    {
        return $this->numPages;
    }

    /**
     * @return int current page
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * @return string url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return int items count
     */
    public function getItemsCount()
    {
        return $this->itemsCount;
    }

    /**
     * @return int limit items per page
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return int offset
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @return array range
     */
    public function getRange()
    {
        return $this->range;
    }

    /**
     * @return int mid range
     */
    public function getMidRange()
    {
        return $this->midRange;
    }

    /**
     * @return int end range
     */
    public function getEndRange()
    {
        return $this->endRange;
    }
}
