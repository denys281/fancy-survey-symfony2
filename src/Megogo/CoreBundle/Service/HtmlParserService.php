<?php

namespace Megogo\CoreBundle\Service;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\CssSelector\CssSelector;

/**
 * Class HtmlParserService. Function for html parce
 * @package Megogo\CoreBundle\Service
 */
class HtmlParserService
{

    /**
     *
     * @return null|string
     */
    public function getRandomGifFromGifBin()
    {
        // Get html content from page
        $ch = curl_init("http://www.gifbin.com/random");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        $content = curl_exec($ch);
        curl_close($ch);

        $crawler = new Crawler($content);
        // Format path to input, with our gif
        $selector = CssSelector::toXPath(
            'body > div#wrap > div#content > div#main > div.box > div#share-links > input.link-code-box'
        );

        // Get path to gif
        return $crawler->filterXpath($selector)->eq(1)->attr('value');
    }


} 