<?php
                    #start
                     #top_statement_list
                      #top_statement
namespace              #T_NAMESPACE
                       #namespace_name
Tchwork                 #T_STRING
\                       #T_NS_SEPARATOR
Parser                  #T_STRING
;                      #';'
                      #top_statement
                       #statement
                        #expr
                         #expr_without_variable
                          #internal_functions_in_yacc
require                    #T_REQUIRE
                           #expr
                            #expr_without_variable
                             #scalar
                              #dereferencable_scalar
'vendor/autoload.php'          #T_CONSTANT_ENCAPSED_STRING
;                       #';'
                      #top_statement
                       #statement
                        #expr
                         #expr_without_variable
                          #variable
                           #callable_variable
                            #simple_variable
$lexer                       #T_VARIABLE
=                         #'='
                          #expr
                           #expr_without_variable
                            #new_expr
new                          #T_NEW
                             #class_name_reference
                              #class_name
                               #name
                                #namespace_name
Lexer                            #T_STRING
\                                #T_NS_SEPARATOR
PhpLexer                         #T_STRING
                             #ctor_arguments
                              #argument_list
(                              #'('
)                              #')'
;                       #';'
                      #top_statement
                       #statement
                        #expr
                         #expr_without_variable
                          #variable
                           #callable_variable
                            #simple_variable
$ast                         #T_VARIABLE
=                         #'='
                          #expr
                           #expr_without_variable
                            #new_expr
new                          #T_NEW
                             #class_name_reference
                              #class_name
                               #name
                                #namespace_name
AstBuilder                       #T_STRING
\                                #T_NS_SEPARATOR
ArrayAstBuilder                  #T_STRING
                             #ctor_arguments
                              #argument_list
(                              #'('
)                              #')'
;                       #';'
                      #top_statement
                       #statement
                        #expr
                         #expr_without_variable
                          #variable
                           #callable_variable
                            #simple_variable
$parser                      #T_VARIABLE
=                         #'='
                          #expr
                           #expr_without_variable
                            #new_expr
new                          #T_NEW
                             #class_name_reference
                              #class_name
                               #name
                                #namespace_name
Parser                           #T_STRING
\                                #T_NS_SEPARATOR
PhpParser                        #T_STRING
                             #ctor_arguments
                              #argument_list
(                              #'('
                               #non_empty_argument_list
                                #argument
                                 #expr
                                  #variable
                                   #callable_variable
                                    #simple_variable
$lexer                               #T_VARIABLE
,                               #','
                                #argument
                                 #expr
                                  #variable
                                   #callable_variable
                                    #simple_variable
$ast                                 #T_VARIABLE
)                              #')'
;                       #';'
                      #top_statement
                       #statement
                        #expr
                         #expr_without_variable
                          #variable
                           #callable_variable
                            #simple_variable
$ast                         #T_VARIABLE
=                         #'='
                          #expr
                           #variable
                            #callable_variable
                             #dereferencable
                              #variable
                               #callable_variable
                                #simple_variable
$parser                          #T_VARIABLE
->                           #T_OBJECT_OPERATOR
                             #member_name
parse                         #T_STRING
                             #argument_list
(                             #'('
                              #non_empty_argument_list
                               #argument
                                #expr
                                 #variable
                                  #callable_variable
                                   #function_call
                                    #name
                                     #namespace_name
file_get_contents                     #T_STRING
                                    #argument_list
(                                    #'('
                                     #non_empty_argument_list
                                      #argument
                                       #expr
                                        #expr_without_variable
                                         #expr
                                          #expr_without_variable
                                           #internal_functions_in_yacc
isset                                       #T_ISSET
(                                           #'('
                                            #isset_variables
                                             #isset_variable
                                              #expr
                                               #variable
                                                #callable_variable
                                                 #dereferencable
                                                  #variable
                                                   #callable_variable
                                                    #dereferencable
                                                     #variable
                                                      #callable_variable
                                                       #simple_variable
$_SERVER                                                #T_VARIABLE
[                                                   #'['
                                                    #optional_expr
                                                     #expr
                                                      #expr_without_variable
                                                       #scalar
                                                        #dereferencable_scalar
'argv'                                                   #T_CONSTANT_ENCAPSED_STRING
]                                                   #']'
[                                                #'['
                                                 #optional_expr
                                                  #expr
                                                   #expr_without_variable
                                                    #scalar
1                                                    #T_LNUMBER
]                                                #']'
)                                           #')'
?                                        #'?'
                                         #expr
                                          #variable
                                           #callable_variable
                                            #dereferencable
                                             #variable
                                              #callable_variable
                                               #dereferencable
                                                #variable
                                                 #callable_variable
                                                  #simple_variable
$_SERVER                                           #T_VARIABLE
[                                              #'['
                                               #optional_expr
                                                #expr
                                                 #expr_without_variable
                                                  #scalar
                                                   #dereferencable_scalar
'argv'                                              #T_CONSTANT_ENCAPSED_STRING
]                                              #']'
[                                           #'['
                                            #optional_expr
                                             #expr
                                              #expr_without_variable
                                               #scalar
1                                               #T_LNUMBER
]                                           #']'
:                                        #':'
                                         #expr
                                          #expr_without_variable
                                           #scalar
__FILE__                                    #T_FILE
)                                    #')'
)                             #')'
;                       #';'
                      #top_statement
                       #function_declaration_statement
                        #function
function                 #T_FUNCTION
                        #returns_ref
print_ast               #T_STRING
(                       #'('
                        #parameter_list
                         #non_empty_parameter_list
                          #parameter
                           #optional_type
                           #is_reference
                           #is_variadic
$ast                       #T_VARIABLE
,                         #','
                          #parameter
                           #optional_type
                           #is_reference
                           #is_variadic
$level                     #T_VARIABLE
=                          #'='
                           #expr
                            #expr_without_variable
                             #scalar
0                             #T_LNUMBER
)                       #')'
                        #backup_doc_comment
{                       #'{'
                        #inner_statement_list
                         #inner_statement
                          #statement
foreach                    #T_FOREACH
(                          #'('
                           #expr
                            #variable
                             #callable_variable
                              #simple_variable
$ast                           #T_VARIABLE
as                         #T_AS
                           #foreach_variable
                            #variable
                             #callable_variable
                              #simple_variable
$n                             #T_VARIABLE
)                          #')'
                           #foreach_statement
                            #statement
{                            #'{'
                             #inner_statement_list
                              #inner_statement
                               #statement
                                #expr
                                 #expr_without_variable
                                  #variable
                                   #callable_variable
                                    #simple_variable
$line                                #T_VARIABLE
=                                 #'='
                                  #expr
                                   #expr_without_variable
                                    #expr
                                     #expr_without_variable
                                      #expr
                                       #variable
                                        #callable_variable
                                         #function_call
                                          #name
                                           #namespace_name
str_repeat                                  #T_STRING
                                          #argument_list
(                                          #'('
                                           #non_empty_argument_list
                                            #argument
                                             #expr
                                              #expr_without_variable
                                               #scalar
                                                #dereferencable_scalar
' '                                              #T_CONSTANT_ENCAPSED_STRING
,                                           #','
                                            #argument
                                             #expr
                                              #expr_without_variable
                                               #expr
                                                #variable
                                                 #callable_variable
                                                  #simple_variable
$level                                             #T_VARIABLE
+                                              #'+'
                                               #expr
                                                #expr_without_variable
                                                 #scalar
20                                                #T_LNUMBER
)                                          #')'
.                                     #'.'
                                      #expr
                                       #expr_without_variable
                                        #scalar
                                         #dereferencable_scalar
'#'                                       #T_CONSTANT_ENCAPSED_STRING
.                                   #'.'
                                    #expr
                                     #variable
                                      #callable_variable
                                       #dereferencable
                                        #variable
                                         #callable_variable
                                          #simple_variable
$n                                         #T_VARIABLE
[                                      #'['
                                       #optional_expr
                                        #expr
                                         #expr_without_variable
                                          #scalar
                                           #dereferencable_scalar
'type'                                      #T_CONSTANT_ENCAPSED_STRING
]                                      #']'
;                               #';'
                              #inner_statement
                               #statement
                                #if_stmt
                                 #if_stmt_without_else
if                                #T_IF
(                                 #'('
                                  #expr
                                   #expr_without_variable
                                    #internal_functions_in_yacc
isset                                #T_ISSET
(                                    #'('
                                     #isset_variables
                                      #isset_variable
                                       #expr
                                        #variable
                                         #callable_variable
                                          #dereferencable
                                           #variable
                                            #callable_variable
                                             #simple_variable
$n                                            #T_VARIABLE
[                                         #'['
                                          #optional_expr
                                           #expr
                                            #expr_without_variable
                                             #scalar
                                              #dereferencable_scalar
'kids'                                         #T_CONSTANT_ENCAPSED_STRING
]                                         #']'
)                                    #')'
)                                 #')'
                                  #statement
{                                  #'{'
                                   #inner_statement_list
                                    #inner_statement
                                     #statement
echo                                  #T_ECHO
                                      #echo_expr_list
                                       #echo_expr
                                        #expr
                                         #expr_without_variable
                                          #expr
                                           #variable
                                            #callable_variable
                                             #simple_variable
$line                                         #T_VARIABLE
.                                         #'.'
                                          #expr
                                           #expr_without_variable
                                            #scalar
                                             #dereferencable_scalar
"\n"                                          #T_CONSTANT_ENCAPSED_STRING
;                                     #';'
                                    #inner_statement
                                     #statement
                                      #expr
                                       #variable
                                        #callable_variable
                                         #function_call
                                          #name
                                           #namespace_name
print_ast                                   #T_STRING
                                          #argument_list
(                                          #'('
                                           #non_empty_argument_list
                                            #argument
                                             #expr
                                              #variable
                                               #callable_variable
                                                #dereferencable
                                                 #variable
                                                  #callable_variable
                                                   #simple_variable
$n                                                  #T_VARIABLE
[                                               #'['
                                                #optional_expr
                                                 #expr
                                                  #expr_without_variable
                                                   #scalar
                                                    #dereferencable_scalar
'kids'                                               #T_CONSTANT_ENCAPSED_STRING
]                                               #']'
,                                           #','
                                            #argument
                                             #expr
                                              #expr_without_variable
                                               #expr
                                                #variable
                                                 #callable_variable
                                                  #simple_variable
$level                                             #T_VARIABLE
+                                              #'+'
                                               #expr
                                                #expr_without_variable
                                                 #scalar
1                                                 #T_LNUMBER
)                                          #')'
;                                     #';'
}                                  #'}'
elseif                            #T_ELSEIF
(                                 #'('
                                  #expr
                                   #variable
                                    #callable_variable
                                     #dereferencable
                                      #variable
                                       #callable_variable
                                        #simple_variable
$n                                       #T_VARIABLE
[                                    #'['
                                     #optional_expr
                                      #expr
                                       #expr_without_variable
                                        #scalar
                                         #dereferencable_scalar
'semantic'                                #T_CONSTANT_ENCAPSED_STRING
]                                    #']'
)                                 #')'
                                  #statement
{                                  #'{'
                                   #inner_statement_list
                                    #inner_statement
                                     #statement
echo                                  #T_ECHO
                                      #echo_expr_list
                                       #echo_expr
                                        #expr
                                         #expr_without_variable
                                          #expr
                                           #variable
                                            #callable_variable
                                             #function_call
                                              #name
                                               #namespace_name
substr_replace                                  #T_STRING
                                              #argument_list
(                                              #'('
                                               #non_empty_argument_list
                                                #argument
                                                 #expr
                                                  #variable
                                                   #callable_variable
                                                    #simple_variable
$line                                                #T_VARIABLE
,                                               #','
                                                #argument
                                                 #expr
                                                  #expr_without_variable
                                                   #expr
                                                    #variable
                                                     #callable_variable
                                                      #dereferencable
                                                       #variable
                                                        #callable_variable
                                                         #simple_variable
$n                                                        #T_VARIABLE
[                                                     #'['
                                                      #optional_expr
                                                       #expr
                                                        #expr_without_variable
                                                         #scalar
                                                          #dereferencable_scalar
'text'                                                     #T_CONSTANT_ENCAPSED_STRING
]                                                     #']'
.                                                  #'.'
                                                   #expr
                                                    #expr_without_variable
                                                     #scalar
                                                      #dereferencable_scalar
' '                                                    #T_CONSTANT_ENCAPSED_STRING
,                                               #','
                                                #argument
                                                 #expr
                                                  #expr_without_variable
                                                   #scalar
0                                                   #T_LNUMBER
,                                               #','
                                                #argument
                                                 #expr
                                                  #expr_without_variable
                                                   #expr
                                                    #expr_without_variable
                                                     #scalar
1                                                     #T_LNUMBER
+                                                  #'+'
                                                   #expr
                                                    #variable
                                                     #callable_variable
                                                      #function_call
                                                       #name
                                                        #namespace_name
strlen                                                   #T_STRING
                                                       #argument_list
(                                                       #'('
                                                        #non_empty_argument_list
                                                         #argument
                                                          #expr
                                                           #variable
                                                            #callable_variable
                                                             #dereferencable
                                                              #variable
                                                               #callable_variable
                                                                #simple_variable
$n                                                               #T_VARIABLE
[                                                            #'['
                                                             #optional_expr
                                                              #expr
                                                               #expr_without_variable
                                                                #scalar
                                                                 #dereferencable_scalar
'text'                                                            #T_CONSTANT_ENCAPSED_STRING
]                                                            #']'
)                                                       #')'
)                                              #')'
.                                         #'.'
                                          #expr
                                           #expr_without_variable
                                            #scalar
                                             #dereferencable_scalar
"\n"                                          #T_CONSTANT_ENCAPSED_STRING
;                                     #';'
}                                  #'}'
}                            #'}'
}                       #'}'
                      #top_statement
                       #statement
echo                    #T_ECHO
                        #echo_expr_list
                         #echo_expr
                          #expr
                           #expr_without_variable
                            #scalar
                             #dereferencable_scalar
"<?php\n"                     #T_CONSTANT_ENCAPSED_STRING
;                       #';'
                      #top_statement
                       #statement
                        #expr
                         #variable
                          #callable_variable
                           #function_call
                            #name
                             #namespace_name
print_ast                     #T_STRING
                            #argument_list
(                            #'('
                             #non_empty_argument_list
                              #argument
                               #expr
                                #expr_without_variable
                                 #scalar
                                  #dereferencable_scalar
array                              #T_ARRAY
(                                  #'('
                                   #array_pair_list
                                    #non_empty_array_pair_list
                                     #array_pair
                                      #expr
                                       #variable
                                        #callable_variable
                                         #simple_variable
$ast                                      #T_VARIABLE
                                    #possible_comma
)                                  #')'
)                            #')'
;                       #';'
