<?php

namespace App\Http\Controllers;
use App\Models\KeyWord;
use App\Models\Tweet;
use App\Models\KeyWordTweetCount;
use DateTime;


class KeywordsController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function getAllKeywords(){
        $user = auth()->user();
        $keywordsOccurrences = $this->wordOccurrencesCount();

        return view('keywords.keywordsDisplay', [
            'keywords'=>$user->keywords,
            'keywordsOccurrences'=>$keywordsOccurrences,

        ]);
    }

    public function createKeywordForm(){
        return view('keywords.createKeyword');
    }

    public function createKeyword(){
        $keywordsOccurrences = $this->wordOccurrencesCount();
        $data = request()->validate([
            'name'=>'required'
        ]);

        auth()->user()->keywords()->create($data);
        $user = auth()->user();


        return view('keywords.keywordsDisplay', [
            'keywords'=>$user->keywords,
            'keywordsOccurrences'=>$keywordsOccurrences,
        ]);
    }

    public function removeKeyword($i){
        $keywordsOccurrences = $this->wordOccurrencesCount();

        $keyword = KeyWord::find($i);
        $keywords = auth()->user()->keywords;


        if($keyword){
            KeyWord::destroy($i);
        }

        for ($i = 0; $i < count($keywords); $i++) {
            if ($keywords[$i]->name==$keyword->name){
                unset($keywords[$i]);
            }
        }


        return view('keywords.keywordsDisplay', [
            'keywords'=>$keywords,
            'keywordsOccurrences'=>$keywordsOccurrences,
        ]);
    }

    // Funkcja przelicza wystapienia słów w tweetach
    public function wordOccurrencesCount(): array
    {
        $keywordsTab = auth()->user()->keywords;
        $keywordsTweetsTab = auth()->user()->keywordTweet;
        $keywordsTweetsOccurrences = array();
        $tweets = auth()->user()->tweets;


        for ($i = 0; $i < count($keywordsTab); $i++) {
            $n = new KeyWordTweetCount($keywordsTab[$i]->name, 0,$keywordsTab[$i]->id ,0);
            array_push($keywordsTweetsOccurrences,$n);
        }

        $act_date= date('Y/m/d H:i:s');
        $act_date_minus_three_days = new DateTime($act_date);
        $act_date_minus_three_days->modify('-3 days');

        for ($i = 0; $i < count($keywordsTweetsTab); $i++) {
            for ($j = 0; $j < count($keywordsTweetsOccurrences); $j++) {
                if ($keywordsTweetsTab[$i]->keyword_id==$keywordsTweetsOccurrences[$j]->id){
                    $keywordsTweetsOccurrences[$j]->count=$keywordsTweetsOccurrences[$j]->count+1;

                }
                 if ($tweets[$keywordsTweetsTab[$i]->keyword_id]->data<$act_date_minus_three_days) {
                     $keywordsTweetsOccurrences[$j]->isNew=1;
                    }

            }
        }
        return $keywordsTweetsOccurrences;

    }

    public function searchTweetsByKeyword($x){
        $keyword = KeyWord::find($x);
        $tweets = auth()->user()->tweets;
        $keywordsTweets = auth()->user()->keywordTweet;

        $tweetsKeys = array();
        $returnTweets = array();

        for ($i = 0; $i < count($keywordsTweets); $i++) {
            if ($x==$keywordsTweets[$i]->keyword_id){
                array_push($tweetsKeys,$keywordsTweets[$i]->tweet_id);
            }
        }

        for ($i = 0; $i < count($tweetsKeys); $i++) {
            for ($j = 0; $j < count($tweets); $j++) {
                if ($tweetsKeys[$i]==$tweets[$j]->id){
                    array_push($returnTweets,$tweets[$j]);
                }
            }
        }

        return view('keywords.keywordWithTweetDisplay', [
            'returnTweets'=>$returnTweets,
            'keyWord'=>$keyword->name,
            'keywordId'=>$keyword->id
        ]);
    }


    public function setToNotInteresting($y, $j){

        $tweet = Tweet::find($j);
        $tweets = auth()->user()->tweets;
        $keyword = KeyWord::find($y);

        $keywordsTweets = auth()->user()->keywordTweet;

        $tweetsKeys = array();
        $returnTweets = array();


        for ($i = 0; $i < count($keywordsTweets); $i++) {
            if ($y==$keywordsTweets[$i]->keyword_id){
                array_push($tweetsKeys,$keywordsTweets[$i]->tweet_id);
            }
        }

        for ($i = 0; $i < count($tweetsKeys); $i++) {
            for ($j = 0; $j < count($tweets); $j++) {
                if ($tweetsKeys[$i]==$tweets[$j]->id){
                    array_push($returnTweets,$tweets[$j]);
                }
            }
        }

        if($tweet){
            KeyWord::destroy($j);
        }

        // Zedytowany tweet z nowym statusem
        $editTweet = auth()->user()->tweets()->create([
            "user_id" => $tweet->id,
            "content" => $tweet->content,
            "data" => $tweet->data,
            "author" => $tweet->author,
            "ok" => 0,
        ]);



        // Edycja tablicy tweetow
        for ($i = 0; $i < count($returnTweets); $i++) {
            if ($returnTweets[$i]->id==$tweet->id){
                $returnTweets[$i]->ok=0;
            }
        }

        return view('keywords.keywordWithTweetDisplay', [
            'returnTweets'=>$returnTweets,
            'keyWord'=>$keyword->name,
            'keywordId'=>$keyword->id
        ]);

    }

    public function setToInteresting($y, $j){

        $tweet = Tweet::find($j);
        $tweets = auth()->user()->tweets;
        $keyword = KeyWord::find($y);

        $keywordsTweets = auth()->user()->keywordTweet;

        $tweetsKeys = array();
        $returnTweets = array();


        for ($i = 0; $i < count($keywordsTweets); $i++) {
            if ($y==$keywordsTweets[$i]->keyword_id){
                array_push($tweetsKeys,$keywordsTweets[$i]->tweet_id);
            }
        }

        for ($i = 0; $i < count($tweetsKeys); $i++) {
            for ($j = 0; $j < count($tweets); $j++) {
                if ($tweetsKeys[$i]==$tweets[$j]->id){
                    array_push($returnTweets,$tweets[$j]);
                }
            }
        }

        if($tweet){
            KeyWord::destroy($j);
        }

        // Zedytowany tweet z nowym statusem
        $editTweet = auth()->user()->tweets()->create([
            "user_id" => $tweet->id,
            "content" => $tweet->content,
            "data" => $tweet->data,
            "author" => $tweet->author,
            "ok" => 1,
        ]);



        // Edycja tablicy tweetow
        for ($i = 0; $i < count($returnTweets); $i++) {
            if ($returnTweets[$i]->id==$tweet->id){
                $returnTweets[$i]->ok=1;
            }
        }

        return view('keywords.keywordWithTweetDisplay', [
            'returnTweets'=>$returnTweets,
            'keyWord'=>$keyword->name,
            'keywordId'=>$keyword->id
        ]);

    }

}
