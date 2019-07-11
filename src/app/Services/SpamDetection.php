<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 7/11/2019
 * Time: 10:09 AM
 */

namespace App\Services;

use InstagramAPI\Instagram;

class SpamDetection
{
    public $ig;
    public $terms;
    public $externalUrls;

    public function __construct()
    {
        Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;
        $this->ig = new Instagram();
        $this->ig->login($_ENV['INSTAGRAM_USERNAME'], $_ENV['INSTAGRAM_PASSWORD']);
        $this->terms = ["porn", "sex", "masturbation", "naked", "dating", "fucking", "click here", "dirty", "look here", "sexx", "single"];
        $this->externalUrls = ["linktr.ee", "bit.ly"];
    }

    /**
     * Detect the likeliness a profile is a sex bot.
     *
     * @param $username
     * @return float|int
     */
    public function detectSexBot($username)
    {
        $user = $this->ig->people->getInfoByName($username)->getUser();
        $termScore = 0;
        $finalScore = 0;
        $bio = $user->getBiography();
        $url = $user->getExternalUrl();

        //Check if bio contains inappropriate terms. (weight = 0.5)
        foreach ($this->terms as $term){
            if(stripos($bio, $term)){
                $termScore++;
            }
        }

        //If has more than 3 terms, the user goes to the next step of the algorithm.
        if($termScore >= 3){
            $finalScore = $finalScore + 0.5;
        }

        // Check if URL is likely spam (weight = 0.3)
        foreach ($this->externalUrls as $externalUrl){
            if(stripos($url, $externalUrl)){
                $finalScore = $finalScore + 0.3;
            }
        }

        // Calculate Follower Ratio (weight = 0.05)
        $followRatio = $user->getFollowerCount()/$user->getFollowingCount();

        if($followRatio < 0.5){
            $finalScore = $finalScore + 0.05;
        }

        return $finalScore;
    }

    public function detectSpamCommentsFromPost($postId)
    {
        //TODO
    }
}