#!/bin/sh

# Before running this script:
#git clone https://github.com/php/php-src.git

rm grammars/*

cd php-src

for TAG in `git tag -l`
do
    git checkout $TAG -- Zend/zend_language_parser.y 2> /dev/null
    cp Zend/zend_language_parser.y zend_language_parser.$TAG.y
done

mv zend_language_parser.php-5.*.y ../grammars/

cd - > /dev/null
cd grammars

PREV_Y_FILE=/dev/null
Y_TMP='ytmp'

for Y_FILE in `php -r '$y=glob("*.y");usort($y,"version_compare");echo implode("\n",$y);'`
do
    # Except for E_COMPILE_ERROR extraction, bison could be used here:
    # bison -v -o /dev/null $Y_FILE --report-file=$Y_TMP 2> /dev/null

    (
    php -- $Y_FILE <<'EOPHP'
<?php
        $y = file_get_contents($_SERVER['argv'][1]);
        $y = explode("\n%pure_parser", $y, 2);
        $y = str_replace("$", "\x7F", $y[1]);
        $y = token_get_all('<?php %pure_parser' . $y);
        $errorState = 0;
        $prevToken = null;
        $curlyDepth = 0;
        $part = 0;
        $z = '';

        $yLen = count($y);
        $y[] = null;

        for ($i = 0; $i < $yLen; ++$i) {
            $token =& $y[$i];
            $nextToken =& $y[$i+1];

            if ('b"' === $nextToken) {
                $nextToken = array('"', $nextToken);
            } elseif (!isset($nextToken[1])) {
                $nextToken = array($nextToken[0], $nextToken[0]);
            }

            switch ($token[0]) {
                case T_WHITESPACE:
                case T_COMMENT:
                case T_DOC_COMMENT:
                    continue 2;
            }

            if ('{' === $token[0]) {
                $curlyDepth++;
            } elseif ('}' === $token[0]) {
                $curlyDepth--;
            } elseif (0 === $curlyDepth) {
                switch ($token[0]) {
                    case ':':
                        $z .= ":\n  ";
                        $prevToken = ':';
                        break;

                    case ';':
                        if ('|' === $prevToken) {
                            $z .= " /* empty */";
                        }
                        $z .= "\n;\n\n";
                        $prevToken = ';';
                        break;

                    case '|':
                        if (':' === $prevToken) {
                            $z .= "  /* empty */\n  |";
                        } else {
                            $z .= "\n  |";
                        }
                        $prevToken = '|';
                        break;

                    case '%':
                        if ('%' === $prevToken) {
                            if (2 === ++$part) {
                                break 2;
                            }
                            $z .= "%\n\n";
                        } elseif (0 === $part) {
                            $z .= "\n%";
                        } else {
                            $z .= ' %';
                        }
                        $prevToken = '%';
                        break;

                    default:
                        if (':' === $nextToken[0] && '%' !== $prevToken && ';' !== $prevToken) {
                            if ('|' === $prevToken) {
                                $z .= " /* empty */";
                            } elseif (':' === $prevToken) {
                                $z .= "/* empty */";
                            }
                            $z .= "\n;\n\n";
                        }

                        if (':' === $prevToken) {
                            $z .= '  ';
                        } elseif ('%' !== $prevToken && ';' !== $prevToken && ':' !== $prevToken) {
                            $z .= ' ';
                        }
                        $z .= $token[1];
                        $prevToken = $token[0];
                        break;
                }
            } elseif ('E_COMPILE_ERROR' === $token[1]) {
                $errorState = -2;
            } elseif (0 === ++$errorState) {
                $z .= ' {'.$token[1].'}';
            }
        }

        $z = str_replace("\x7F", "$", $z);
        $z = preg_replace('/ ".*"$/m', '', $z);
        $z = preg_replace('/\n%code.*/', '', $z);

        echo substr($z, 8, -2)."%%\n";
EOPHP

    ) > $Y_TMP

    mv $Y_TMP $Y_FILE

    if diff $PREV_Y_FILE $Y_FILE > /dev/null ;
    then
        rm $Y_FILE
    else
        PREV_Y_FILE=$Y_FILE
        echo $Y_FILE
    fi
done

cd - > /dev/null
