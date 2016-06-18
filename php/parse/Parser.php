<?php
class Parser {
    const CONF_PATTERN = '/^\s*\[(\.*)(\w+)\]\s*$/';
    private $lines = [];
    private $currentLineNb = -1;
    private $currentLine = '';
    private $currentLevelNb = -1;
    private $currentLevels = [];
    private $data = [];

    public function parse($input)
    {
        if (strpos($input, "\n") === false && is_file($input)) {
            if (false === is_readable($input)) {
                throw new Exception(sprintf('Unable to parse "%s" as the file is not readable.', $input));
            }

            $input = file_get_contents($input);
        }

        $this->currentLineNb = -1;
        $this->currentLine = '';
        $input = $this->cleanup($input);
        $this->lines = explode("\n", $input);

        while ($this->moveToNextLine()) {
            if ($this->isCurrentLineEmpty()) {
                continue;
            }

            if (preg_match(self::CONF_PATTERN, $this->currentLine, $matches)) {
                echo $matches[1], "----" , $matches[2], "\n";
                // array_push($this->currentLevels, $matches[1]);
                // $parseFuncName = 'parse' . ucfirst($matches[1]);
                // $this->$parseFuncName();
                // $name = array_pop($this->currentLevels);
                // $this->data[$name] = $feature;
            }

            // echo $this->currentLine;
        }
    }

    /**
     * Parse feature conf
     *
     * @return bool
     */
    private function parseFeature()
    {
        echo 'feature' . "\n";
        $feature = [];
        while ($this->moveToNextLine()) {
            if (preg_match(self::CONF_PATTERN, $this->currentLine, $matches)) {
                $this->moveToPreviousLine();
                break;
            }
            list($key, $value) = preg_split('/\s*:\s+/', $this->currentLine, -1, PREG_SPLIT_NO_EMPTY);
            $feature[trim($key)] = $value;
        }
        return $feature;
    }

    /**
     * Parse rule conf
     *
     * @return bool
     */
    private function parseRules()
    {
        echo 'rules' . "\n";
        $rules = [];
        while ($this->moveToNextLine()) {
            if (preg_match(self::CONF_PATTERN, $this->currentLine, $matches)) {
                $this->moveToPreviousLine();
                break;
            }

            list($key, $value) = preg_split('/\s*:\s+/', $this->currentLine, -1, PREG_SPLIT_NO_EMPTY);
            $feature[trim($key)] = $value;
        }
        return $rules;
    }

    /**
     * Parse file conf
     *
     * @return bool
     */
    private function parseFile()
    {
        echo 'file' . "\n";
    }

    /**
     * Moves the parser to the previous line.
     */
    private function moveToPreviousLine()
    {
        $this->currentLine = $this->lines[--$this->currentLineNb];
    }

    /**
     * Moves the parser to the next line.
     *
     * @return bool
     */
    private function moveToNextLine()
    {
        if ($this->currentLineNb >= count($this->lines) - 1) {
            return false;
        }

        $this->currentLine = $this->lines[++$this->currentLineNb];

        return true;
    }

    /**
     * Returns true if the current line is blank or if it is a comment line.
     *
     * @return bool Returns true if the current line is empty or if it is a comment line, false otherwise
     */
    private function isCurrentLineEmpty()
    {
        return $this->isCurrentLineBlank() || $this->isCurrentLineComment();
    }

    /**
     * Returns true if the current line is blank.
     *
     * @return bool Returns true if the current line is blank, false otherwise
     */
    private function isCurrentLineBlank()
    {
        return '' == trim($this->currentLine, ' ');
    }

    /**
     * Returns true if the current line is a comment line.
     *
     * @return bool Returns true if the current line is a comment line, false otherwise
     */
    private function isCurrentLineComment()
    {
        //checking explicitly the first char of the trim is faster than loops or strpos
        $ltrimmedLine = ltrim($this->currentLine, ' ');

        return '' !== $ltrimmedLine && $ltrimmedLine[0] === '#';
    }

    /**
     * Cleanups a conf string to be parsed.
     *
     * @param string $value The input conf string
     *
     * @return string A cleaned up conf string
     */
    private function cleanup($value)
    {
        return str_replace(["\r\n", "\r"], "\n", $value);
    }
}

$parser = new Parser();
$parser->parse('conf');
