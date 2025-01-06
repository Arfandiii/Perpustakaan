<?php
namespace App\Helpers;

// require_once 'vendor/autoload.php';
use Sastrawi\Stemmer\StemmerFactory;
use Sastrawi\StopWordRemover\StopWordRemoverFactory;

class TextPreprocessingHelper
{
    public static function tokenize($text) {
        return preg_split('/[\s,\.!?;:()"\'-]+/', strtolower($text));
    }

    public static function filterTokens($tokens) {
        return array_filter($tokens, function($token) {
            return preg_match('/^[a-zA-Z]+$/', $token);
        });
    }

    public static function removeStopwords($tokens) {
        $stopWordRemoverFactory = new StopWordRemoverFactory();
        $stopWordRemover = $stopWordRemoverFactory->createStopWordRemover();

        return array_filter($tokens, function($token) use ($stopWordRemover) {
            return $stopWordRemover->remove($token) !== '';
        });
    }

    public static function stemTokens($tokens) {
        $stemmerFactory = new StemmerFactory();
        $stemmer = $stemmerFactory->createStemmer();

        // return array_map(function($token) use ($stemmer) {
        //     return $stemmer->stem($token);
        // }, $tokens);

        return array_filter(array_map(function($token) use ($stemmer) {
            return !empty($token) ? $stemmer->stem($token) : null;
        }, $tokens)); // Stem hanya jika token tidak kosong
    }

    
    public static function preprocessText($text) {
        // Tokenization
        $tokens = self::tokenize($text);

        // Filter tokens (e.g., remove punctuation)
        $filteredTokens = self::filterTokens($tokens);

        // Remove stopwords
        $filteredTokens = self::removeStopwords($filteredTokens);

        // Stemming
        $stemmedTokens = self::stemTokens($filteredTokens);

        return $stemmedTokens;
    }
}