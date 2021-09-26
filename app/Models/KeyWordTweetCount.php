<?php

namespace App\Models;

class KeyWordTweetCount
{
    public $keywordName;
    public $count;
    public $id;
    public $isNew;


    /**
     * @param $keywordName
     * @param $count
     *  @param $id
     *  @param $isNew
     */
    public function __construct($keywordName, $count, $id, $isNew)
    {
        $this->keywordName = $keywordName;
        $this->count = $count;
        $this->id = $id;
        $this->isNew=$isNew;
    }


}
