<?php

/**
 * Class LexerAnalyzer
 *
 * Class for pseudo regex analyzing
 *
 * @author Yuriy Stos
 */
class LexerAnalyzer
{
    private $escape_mode = false;
    private $set_mode = false;
    private $set_internal_counter = 0;

    //  ----------------------------------------------------------------------------
    # Char Constants

    /**
     * @integer an escape character
     */
    const T_ESCAPE_CHAR = -1;

    /**
     *  The literal type ie a=a ^=^
     */
    const T_LITERAL_CHAR = 0;

    /**
     *  Numeric literal  1=1 100=100
     */
    const T_LITERAL_NUMERIC = 1;

    /**
     *  The opening character for group. [(]
     */
    const T_GROUP_OPEN = 2;

    /**
     *  The closing character for group  [)]
     */
    const T_GROUP_CLOSE = 3;

    /**
     *  Opening character for Quantifier  ({)
     */
    const T_QUANTIFIER_OPEN = 4;

    /**
     *   Closing character for Quantifier (})
     */
    const T_QUANTIFIER_CLOSE = 5;

    /**
     *  Star quantifier character (*)
     */
    const T_QUANTIFIER_STAR = 6;

    /**
     *  Pluse quantifier character (+)
     */
    const T_QUANTIFIER_PLUS = 7;

    /**
     *  The one but optonal character (?)
     */
    const T_QUANTIFIER_QUESTION = 8;

    /**
     *  Start of string character (^)
     */
    const T_START_CARET = 9;

    /**
     *  End of string character ($)
     */
    const T_END_DOLLAR = 10;

    /**
     *  Range character inside set ([)
     */
    const T_SET_OPEN = 11;

    /**
     *  Range character inside set (])
     */
    const T_SET_CLOSE = 12;

    /**
     *  Range character inside set (-)
     */
    const T_SET_RANGE = 13;

    /**
     *  Negated Character in set ([^)
     */
    const T_SET_NEGATED = 14;

    /**
     *  The either character (|)
     */
    const T_CHOICE_BAR = 15;

    /**
     *  The dot character (.)
     */
    const T_DOT = 16;


    //  ----------------------------------------------------------------------------
    # Shorthand constants

    /**
     *  One Word boundry
     */
    const T_SHORT_W = 100;
    const T_SHORT_NOT_W = 101;

    const T_SHORT_D = 102;
    const T_SHORT_NOT_D = 103;

    const T_SHORT_S = 104;
    const T_SHORT_NOT_S = 105;

    /**
     *  Unicode sequences /p{} /pNum
     */
    const T_SHORT_P = 106;


    /**
     *  Hex Sequences /x{} /xNum
     */
    const T_SHORT_X = 108;

    /**
     *  Unicode hex sequence /X{} /XNum
     */
    const T_SHORT_UNICODE_X = 109;

    /**
     * @var array $tokens
     */
    private $tokens = [];

    public function __construct($sourceString)
    {
        $this->tokens = $this->getTokens($sourceString);
    }

    /**
     * @return TokenIterator
     */
    public function getTokenIterator()
    {
        return new TokenIterator($this->tokens);
    }

    /**
     * Searches for tokens in the specified string
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

    private function detectTokenType($token)
    {
        switch (true) {
            // Charset
            case ($token === '[' && $this->escape_mode === false && $this->set_mode === true) :
                echo("Can't have a second character class while first remains open");
                break;
            case ($token === ']' && $this->escape_mode === false && $this->set_mode === false) :
                echo("Can't close a character class while none is open");
                break;
            case ($token === '[' && $this->escape_mode === false && $this->set_mode === false) :
                $this->set_mode = true;
                $type = self::T_SET_OPEN;
                $this->set_internal_counter = 1;
                break;
            case ($token === ']' && $this->escape_mode === false && $this->set_mode === true) :
                $this->set_mode = false;
                $type = self::T_SET_CLOSE;
                $this->set_internal_counter = 0;
                break;
            case ($token === '-' && $this->escape_mode === false && $this->set_mode === true)  :
                $this->set_internal_counter++;
                return self::T_SET_RANGE;
                break;

            // Quantifers
            case ($token === '{' && $this->escape_mode === false && $this->set_mode === false) :
                return self::T_QUANTIFIER_OPEN;
            case ($token === '}' && $this->escape_mode === false && $this->set_mode === false) :
                return self::T_QUANTIFIER_CLOSE;

            // Default
            default :
                if (is_numeric($token) === true) {
                    $type = self::T_LITERAL_NUMERIC;
                } else {
                    $type = self::T_LITERAL_CHAR;
                }

                if ($this->set_mode === true) {
                    $this->set_internal_counter++;
                }


                $this->escape_mode = false;
        }
        return $type;
    }
}