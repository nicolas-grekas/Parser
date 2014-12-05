<?php

namespace Tchwork\Parser\Parser;

/**
 * This is an automatically generated file, DO NOT EDIT.
 */
class DemoParser extends AbstractParser
{
    const YY2TBLSTATE  = 4;
    const YYNLSTATES   = 13;
    const YYUNEXPECTED = 32767;
    const YYDEFAULT    = -32766;
    const YYBADCH      = 10;
    const YYINTERRTOK  = 1;

    protected static $yyerror = array(
    );

    public static $yytoken = array(
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

    protected static $yynode = array(
        "start",
        "start",
        "lines",
        "line",
        "expr"
    );

    protected static $yymap = array(
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

    protected static $yyaction = array(
           19,   -1,   12,    7,    8,    5,    6,    0,   18,    5,
            6,   24,   25,   17,    0,    0,    0,    0,    4
    );

    protected static $yycheck = array(
            7,    0,    1,    5,    6,    3,    4,    0,    7,    3,
            4,    9,    2,    7,   -1,   -1,   -1,   -1,    8
    );

    protected static $yybase = array(
            0,    1,    6,    2,   10,   10,   10,   10,   10,   -2,
           -2,    7,   -7,    0,   10,   -2,   -2
    );

    protected static $yydefault = array(
            2,32767,32767,32767,32767,32767,32767,32767,32767,    7,
            8,32767,32767
    );

    protected static $yygoto = array(
            3,    9,   10,   22,   23
    );

    protected static $yygcheck = array(
            4,    4,    4,    4,    4
    );

    protected static $yygbase = array(
            0,    0,    0,    0,   -4
    );

    protected static $yygdefault = array(
        -32768,   11,    1,   16,    2
    );

    protected static $yylhs = array(
            0,    1,    2,    2,    3,    3,    3,    4,    4,    4,
            4,    4,    4
    );

    protected static $yylen = array(
            1,    1,    0,    2,    2,    1,    2,    3,    3,    3,
            3,    3,    1
    );
}
