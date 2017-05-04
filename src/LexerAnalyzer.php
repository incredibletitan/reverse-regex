<?php

namespace src;

/**
 * Class LexerAnalyzer
 *
 * Class for pseudo regex analyzing
 *
 * @author Yuriy Stos
 */
class LexerAnalyzer
{
    /**
     * Identifies is set opened
     *
     * @var bool
     */
    private $setMode = false;

    /**
     *  Alphabetical literal
     */
    const LITERAL_CHAR = 0;

    /**
     *  Numeric literal
     */
    const LITERAL_NUMERIC = 1;

    /**
     *  Opening character for Quantifier  ({)
     */
    const QUANTIFIER_OPEN = 4;

    /**
     *   Closing character for Quantifier (})
     */
    const QUANTIFIER_CLOSE = 5;

    /**
     *  Range character inside set ([)
     */
    const SET_OPEN = 11;

    /**
     *  Range character inside set (])
     */
    const SET_CLOSE = 12;

    /**
     *  Range character inside set (-)
     */
    const SET_RANGE = 13;

    /**
     * @var array $tokens
     */
    private $tokens = [];

    /**
     * LexerAnalyzer constructor.
     * @param $sourceString - String which needed to be analyzed
     */
    public function __construct($sourceString)
    {
        $this->tokens = $this->getTokens($sourceString);
    }

    /**
     * Returns token iterator for tokens list
     *
     * @return TokenIterator
     */
    public function getTokenIterator()
    {
        return new TokenIterator($this->tokens);
    }

    /**
     * Searches for tokens in the specified string
     *
     * @param string $sourceString - Source string
     * @return array - List of tokens
     */
    private function getTokens($sourceString)
    {
        $tokens = [];
        $stringLength = strlen($sourceString);

        for ($i = 0; $i < $stringLength; $i++) {
            $tokens[] = [
                'value' => $sourceString[$i],
                'type' => $this->detectTokenType($sourceString[$i]),
                'position' => $i
            ];
        }

        return $tokens;
    }

    /**
     * Detects token type
     *
     * @param $token - Token value
     * @return int - Token type
     * @throws \Exception
     */
    private function detectTokenType($token)
    {
        switch (true) {
            case ($token === '[' && $this->setMode === true) :
                throw new \Exception("Can't have a second character class while first remains open");
                break;
            case ($token === ']' && $this->setMode === false) :
                throw new \Exception("Can't close a character class while none is open");
                break;
            case ($token === '[' && $this->setMode === false) :
                $this->setMode = true;
                $type = self::SET_OPEN;
                break;
            case ($token === ']' && $this->setMode === true) :
                $this->setMode = false;
                $type = self::SET_CLOSE;
                break;
            case ($token === '-' && $this->setMode === true)  :
                return self::SET_RANGE;
                break;

            // Quantifers
            case ($token === '{' && $this->setMode === false) :
                return self::QUANTIFIER_OPEN;
            case ($token === '}' && $this->setMode === false) :
                return self::QUANTIFIER_CLOSE;

            // Default
            default :
                if (is_numeric($token) === true) {
                    $type = self::LITERAL_NUMERIC;
                } else {
                    $type = self::LITERAL_CHAR;
                }
        }
        return $type;
    }
}