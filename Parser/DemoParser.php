<?php

namespace Tchwork\Parser\Parser;

/**
 * This is an automatically generated file, DO NOT EDIT.
 */
class DemoParser extends AbstractParser
{
    protected $YY2TBLSTATE = 4;
    protected $YYNLSTATES = 13;
    protected $YYUNEXPECTED = 32767;
    protected $YYDEFAULT = -32766;
    protected $YYBADCH = 10;
    protected $YYINTERRTOK = 1;

    protected $yyerror = array(
    );

    protected $yytoken = array(
        "EOF",
        "error",
        "NUMBER",
        "'+'",
        "'-'",
        "'*'",
        "'/'",
        "'\\n'",
        "'('",
        "')'"
    );

    protected $yynode = array(
        "start",
        "start",
        "lines",
        "line",
        "expr"
    );

    protected $yymap = array(
            0,   10,   10,   10,   10,   10,   10,   10,   10,   10,
            7,   10,   10,   10,   10,   10,   10,   10,   10,   10,
           10,   10,   10,   10,   10,   10,   10,   10,   10,   10,
           10,   10,   10,   10,   10,   10,   10,   10,   10,   10,
            8,    9,    5,    3,   10,    4,   10,    6,   10,   10,
           10,   10,   10,   10,   10,   10,   10,   10,   10,   10,
           10,   10,   10,   10,   10,   10,   10,   10,   10,   10,
           10,   10,   10,   10,   10,   10,   10,   10,   10,   10,
           10,   10,   10,   10,   10,   10,   10,   10,   10,   10,
           10,   10,   10,   10,   10,   10,   10,   10,   10,   10,
           10,   10,   10,   10,   10,   10,   10,   10,   10,   10,
           10,   10,   10,   10,   10,   10,   10,   10,   10,   10,
           10,   10,   10,   10,   10,   10,   10,   10,   10,   10,
           10,   10,   10,   10,   10,   10,   10,   10,   10,   10,
           10,   10,   10,   10,   10,   10,   10,   10,   10,   10,
           10,   10,   10,   10,   10,   10,   10,   10,   10,   10,
           10,   10,   10,   10,   10,   10,   10,   10,   10,   10,
           10,   10,   10,   10,   10,   10,   10,   10,   10,   10,
           10,   10,   10,   10,   10,   10,   10,   10,   10,   10,
           10,   10,   10,   10,   10,   10,   10,   10,   10,   10,
           10,   10,   10,   10,   10,   10,   10,   10,   10,   10,
           10,   10,   10,   10,   10,   10,   10,   10,   10,   10,
           10,   10,   10,   10,   10,   10,   10,   10,   10,   10,
           10,   10,   10,   10,   10,   10,   10,   10,   10,   10,
           10,   10,   10,   10,   10,   10,   10,   10,   10,   10,
           10,   10,   10,   10,   10,   10,    1,    2
    );

    protected $yyaction = array(
           19,   -1,   12,    7,    8,    5,    6,    0,   18,    5,
            6,   24,   25,   17,    0,    0,    0,    0,    4
    );

    protected $yycheck = array(
            7,    0,    1,    5,    6,    3,    4,    0,    7,    3,
            4,    9,    2,    7,   -1,   -1,   -1,   -1,    8
    );

    protected $yybase = array(
            0,    1,    6,    2,   10,   10,   10,   10,   10,   -2,
           -2,    7,   -7,    0,   10,   -2,   -2
    );

    protected $yydefault = array(
            2,32767,32767,32767,32767,32767,32767,32767,32767,    7,
            8,32767,32767
    );

    protected $yygoto = array(
            3,    9,   10,   22,   23
    );

    protected $yygcheck = array(
            4,    4,    4,    4,    4
    );

    protected $yygbase = array(
            0,    0,    0,    0,   -4
    );

    protected $yygdefault = array(
        -32768,   11,    1,   16,    2
    );

    protected $yylhs = array(
            0,    1,    2,    2,    3,    3,    3,    4,    4,    4,
            4,    4,    4
    );

    protected $yylen = array(
            1,    1,    0,    2,    2,    1,    2,    3,    3,    3,
            3,    3,    1
    );
}
