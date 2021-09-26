<?php

namespace App\Http\Controllers;

use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isNull;

class Tweets extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function searchTweets(){

        // Dane do połączenia z api twittera
        $consumer_key=auth()->user()->consumerKey;
        $consumer_secret=auth()->user()->consumerSecret;
        $access_token=auth()->user()->accessToken;
        $access_token_secret=auth()->user()->accessTokenSecret;

        // Tworzenie połączenia z api twittera
        $connection = new TwitterOAuth($consumer_key, $consumer_secret,$access_token, $access_token_secret);

        // Aktualny user
        $user = auth()->user();

        if (count($user->keywords)>0) {

            // Algorytm tworzenia nowych tweetów na bazie słów w bazie
           for ($i = 0; $i < count($user->keywords); $i++) {

               $statuses = $connection->get("search/tweets", array("q" => $user->keywords[$i]->name, "count" => 2));

               for ($j = 0; $j < 2; $j++) {

                   $content = "";
                   if ($statuses->statuses[$j]->text != null) {
                       $content = $statuses->statuses[$j]->text;
                   }

                   $data = date_create('2000-01-01');
                   if ($statuses->statuses[$j]->created_at != null) {
                       $data = date_create($statuses->statuses[$j]->created_at);
                   }

                   $author = "";
                   if ($statuses->statuses[$j]->user->name != null) {
                       $author = $statuses->statuses[$j]->user->name;
                   }

                   // Tworzenie nowego teeta
                   $newTweet = auth()->user()->tweets()->create([
                       "user_id" => $user->id,
                       "content" => $content,
                       "data" => $data,
                       "author" => $author,
                       "ok" => 1,
                   ]);

                   // Tworzenie modelu tweet+keyword
                   $keywordTweet = auth()->user()->keyWordTweet()->create([
                       "user_id" => $user->id,
                       "tweet_id" => $newTweet->id,
                       "keyword_id" => $user->keywords[$i]->id,
                   ]);

               }
           }
       }

        $tweets = auth()->user()->tweets;
        return view('tweets.displayAllTweets', [
            'tweets'=>$tweets,
        ]);
    }

    public function tweets(){

        $tweets = auth()->user()->tweets;
        return view('tweets.displayAllTweets', [
            'tweets'=>$tweets,
        ]);

    }

}
