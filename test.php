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
                        #unticked_statement
                         #expr
                          #expr_without_variable
                           #internal_functions_in_yacc
require                     #T_REQUIRE
                            #expr
                             #expr_without_variable
                              #scalar
                               #common_scalar
'vendor/autoload.php'           #T_CONSTANT_ENCAPSED_STRING
;                        #';'
                      #top_statement
                       #statement
                        #unticked_statement
                         #expr
                          #expr_without_variable
                           #variable
                            #base_variable_with_function_calls
                             #base_variable
                              #reference_variable
                               #compound_variable
$lexer                          #T_VARIABLE
=                          #'='
                           #expr
                            #expr_without_variable
                             #new_expr
new                           #T_NEW
                              #class_name_reference
                               #class_name
                                #namespace_name
Lexer                            #T_STRING
\                                #T_NS_SEPARATOR
PhpLexer                         #T_STRING
                              #ctor_arguments
                               #function_call_parameter_list
(                               #'('
)                               #')'
;                        #';'
                      #top_statement
                       #statement
                        #unticked_statement
                         #expr
                          #expr_without_variable
                           #variable
                            #base_variable_with_function_calls
                             #base_variable
                              #reference_variable
                               #compound_variable
$ast                            #T_VARIABLE
=                          #'='
                           #expr
                            #expr_without_variable
                             #new_expr
new                           #T_NEW
                              #class_name_reference
                               #class_name
                                #namespace_name
AstBuilder                       #T_STRING
\                                #T_NS_SEPARATOR
ArrayAstBuilder                  #T_STRING
                              #ctor_arguments
                               #function_call_parameter_list
(                               #'('
)                               #')'
;                        #';'
                      #top_statement
                       #statement
                        #unticked_statement
                         #expr
                          #expr_without_variable
                           #variable
                            #base_variable_with_function_calls
                             #base_variable
                              #reference_variable
                               #compound_variable
$parser                         #T_VARIABLE
=                          #'='
                           #expr
                            #expr_without_variable
                             #new_expr
new                           #T_NEW
                              #class_name_reference
                               #class_name
                                #namespace_name
Parser                           #T_STRING
\                                #T_NS_SEPARATOR
PhpParser                        #T_STRING
                              #ctor_arguments
                               #function_call_parameter_list
(                               #'('
                                #non_empty_function_call_parameter_list
                                 #function_call_parameter
                                  #variable
                                   #base_variable_with_function_calls
                                    #base_variable
                                     #reference_variable
                                      #compound_variable
$lexer                                 #T_VARIABLE
,                                #','
                                 #function_call_parameter
                                  #variable
                                   #base_variable_with_function_calls
                                    #base_variable
                                     #reference_variable
                                      #compound_variable
$ast                                   #T_VARIABLE
)                               #')'
;                        #';'
                      #top_statement
                       #statement
                        #unticked_statement
                         #expr
                          #expr_without_variable
                           #variable
                            #base_variable_with_function_calls
                             #base_variable
                              #reference_variable
                               #compound_variable
$ast                            #T_VARIABLE
=                          #'='
                           #expr
                            #r_variable
                             #variable
                              #base_variable_with_function_calls
                               #base_variable
                                #reference_variable
                                 #compound_variable
$parser                           #T_VARIABLE
->                            #T_OBJECT_OPERATOR
                              #object_property
                               #object_dim_list
                                #variable_name
parse                            #T_STRING
                              #method_or_not
                               #method
                                #function_call_parameter_list
(                                #'('
                                 #non_empty_function_call_parameter_list
                                  #function_call_parameter
                                   #variable
                                    #base_variable_with_function_calls
                                     #function_call
                                      #namespace_name
file_get_contents                      #T_STRING
                                      #function_call_parameter_list
(                                      #'('
                                       #non_empty_function_call_parameter_list
                                        #function_call_parameter
                                         #expr_without_variable
                                          #expr
                                           #expr_without_variable
                                            #internal_functions_in_yacc
isset                                        #T_ISSET
(                                            #'('
                                             #isset_variables
                                              #isset_variable
                                               #variable
                                                #base_variable_with_function_calls
                                                 #base_variable
                                                  #reference_variable
                                                   #compound_variable
$_SERVER                                            #T_VARIABLE
[                                                  #'['
                                                   #dim_offset
                                                    #expr
                                                     #expr_without_variable
                                                      #scalar
                                                       #common_scalar
'argv'                                                  #T_CONSTANT_ENCAPSED_STRING
]                                                  #']'
[                                                  #'['
                                                   #dim_offset
                                                    #expr
                                                     #expr_without_variable
                                                      #scalar
                                                       #common_scalar
1                                                       #T_LNUMBER
]                                                  #']'
)                                            #')'
?                                         #'?'
                                          #expr
                                           #r_variable
                                            #variable
                                             #base_variable_with_function_calls
                                              #base_variable
                                               #reference_variable
                                                #compound_variable
$_SERVER                                         #T_VARIABLE
[                                               #'['
                                                #dim_offset
                                                 #expr
                                                  #expr_without_variable
                                                   #scalar
                                                    #common_scalar
'argv'                                               #T_CONSTANT_ENCAPSED_STRING
]                                               #']'
[                                               #'['
                                                #dim_offset
                                                 #expr
                                                  #expr_without_variable
                                                   #scalar
                                                    #common_scalar
1                                                    #T_LNUMBER
]                                               #']'
:                                         #':'
                                          #expr
                                           #expr_without_variable
                                            #scalar
                                             #common_scalar
__FILE__                                      #T_FILE
)                                      #')'
)                                #')'
                              #variable_properties
;                        #';'
                      #top_statement
                       #function_declaration_statement
                        #unticked_function_declaration_statement
                         #function
function                  #T_FUNCTION
                         #is_reference
print_ast                #T_STRING
(                        #'('
                         #parameter_list
                          #non_empty_parameter_list
                           #parameter
                            #optional_class_type
                            #is_reference
                            #is_variadic
$ast                        #T_VARIABLE
,                          #','
                           #parameter
                            #optional_class_type
                            #is_reference
                            #is_variadic
$level                      #T_VARIABLE
=                           #'='
                            #static_scalar
                             #static_scalar_value
                              #common_scalar
0                              #T_LNUMBER
)                        #')'
{                        #'{'
                         #inner_statement_list
                          #inner_statement
                           #statement
                            #unticked_statement
foreach                      #T_FOREACH
(                            #'('
                             #variable
                              #base_variable_with_function_calls
                               #base_variable
                                #reference_variable
                                 #compound_variable
$ast                              #T_VARIABLE
as                           #T_AS
                             #foreach_variable
                              #variable
                               #base_variable_with_function_calls
                                #base_variable
                                 #reference_variable
                                  #compound_variable
$n                                 #T_VARIABLE
                             #foreach_optional_arg
)                            #')'
                             #foreach_statement
                              #statement
                               #unticked_statement
{                               #'{'
                                #inner_statement_list
                                 #inner_statement
                                  #statement
                                   #unticked_statement
                                    #expr
                                     #expr_without_variable
                                      #variable
                                       #base_variable_with_function_calls
                                        #base_variable
                                         #reference_variable
                                          #compound_variable
$line                                      #T_VARIABLE
=                                     #'='
                                      #expr
                                       #expr_without_variable
                                        #expr
                                         #expr_without_variable
                                          #expr
                                           #r_variable
                                            #variable
                                             #base_variable_with_function_calls
                                              #function_call
                                               #namespace_name
str_repeat                                      #T_STRING
                                               #function_call_parameter_list
(                                               #'('
                                                #non_empty_function_call_parameter_list
                                                 #function_call_parameter
                                                  #expr_without_variable
                                                   #scalar
                                                    #common_scalar
' '                                                  #T_CONSTANT_ENCAPSED_STRING
,                                                #','
                                                 #function_call_parameter
                                                  #expr_without_variable
                                                   #expr
                                                    #r_variable
                                                     #variable
                                                      #base_variable_with_function_calls
                                                       #base_variable
                                                        #reference_variable
                                                         #compound_variable
$level                                                    #T_VARIABLE
+                                                  #'+'
                                                   #expr
                                                    #expr_without_variable
                                                     #scalar
                                                      #common_scalar
20                                                     #T_LNUMBER
)                                               #')'
.                                         #'.'
                                          #expr
                                           #expr_without_variable
                                            #scalar
                                             #common_scalar
'#'                                           #T_CONSTANT_ENCAPSED_STRING
.                                       #'.'
                                        #expr
                                         #r_variable
                                          #variable
                                           #base_variable_with_function_calls
                                            #base_variable
                                             #reference_variable
                                              #compound_variable
$n                                             #T_VARIABLE
[                                             #'['
                                              #dim_offset
                                               #expr
                                                #expr_without_variable
                                                 #scalar
                                                  #common_scalar
'type'                                             #T_CONSTANT_ENCAPSED_STRING
]                                             #']'
;                                   #';'
                                 #inner_statement
                                  #statement
                                   #unticked_statement
if                                  #T_IF
                                    #parenthesis_expr
(                                    #'('
                                     #expr
                                      #expr_without_variable
                                       #internal_functions_in_yacc
isset                                   #T_ISSET
(                                       #'('
                                        #isset_variables
                                         #isset_variable
                                          #variable
                                           #base_variable_with_function_calls
                                            #base_variable
                                             #reference_variable
                                              #compound_variable
$n                                             #T_VARIABLE
[                                             #'['
                                              #dim_offset
                                               #expr
                                                #expr_without_variable
                                                 #scalar
                                                  #common_scalar
'kids'                                             #T_CONSTANT_ENCAPSED_STRING
]                                             #']'
)                                       #')'
)                                    #')'
                                    #statement
                                     #unticked_statement
{                                     #'{'
                                      #inner_statement_list
                                       #inner_statement
                                        #statement
                                         #unticked_statement
echo                                      #T_ECHO
                                          #echo_expr_list
                                           #expr
                                            #expr_without_variable
                                             #expr
                                              #r_variable
                                               #variable
                                                #base_variable_with_function_calls
                                                 #base_variable
                                                  #reference_variable
                                                   #compound_variable
$line                                               #T_VARIABLE
.                                            #'.'
                                             #expr
                                              #expr_without_variable
                                               #scalar
                                                #common_scalar
"\n"                                             #T_CONSTANT_ENCAPSED_STRING
;                                         #';'
                                       #inner_statement
                                        #statement
                                         #unticked_statement
                                          #expr
                                           #r_variable
                                            #variable
                                             #base_variable_with_function_calls
                                              #function_call
                                               #namespace_name
print_ast                                       #T_STRING
                                               #function_call_parameter_list
(                                               #'('
                                                #non_empty_function_call_parameter_list
                                                 #function_call_parameter
                                                  #variable
                                                   #base_variable_with_function_calls
                                                    #base_variable
                                                     #reference_variable
                                                      #compound_variable
$n                                                     #T_VARIABLE
[                                                     #'['
                                                      #dim_offset
                                                       #expr
                                                        #expr_without_variable
                                                         #scalar
                                                          #common_scalar
'kids'                                                     #T_CONSTANT_ENCAPSED_STRING
]                                                     #']'
,                                                #','
                                                 #function_call_parameter
                                                  #expr_without_variable
                                                   #expr
                                                    #r_variable
                                                     #variable
                                                      #base_variable_with_function_calls
                                                       #base_variable
                                                        #reference_variable
                                                         #compound_variable
$level                                                    #T_VARIABLE
+                                                  #'+'
                                                   #expr
                                                    #expr_without_variable
                                                     #scalar
                                                      #common_scalar
1                                                      #T_LNUMBER
)                                               #')'
;                                         #';'
}                                     #'}'
                                    #elseif_list
elseif                               #T_ELSEIF
                                     #parenthesis_expr
(                                     #'('
                                      #expr
                                       #r_variable
                                        #variable
                                         #base_variable_with_function_calls
                                          #base_variable
                                           #reference_variable
                                            #compound_variable
$n                                           #T_VARIABLE
[                                           #'['
                                            #dim_offset
                                             #expr
                                              #expr_without_variable
                                               #scalar
                                                #common_scalar
'semantic'                                       #T_CONSTANT_ENCAPSED_STRING
]                                           #']'
)                                     #')'
                                     #statement
                                      #unticked_statement
{                                      #'{'
                                       #inner_statement_list
                                        #inner_statement
                                         #statement
                                          #unticked_statement
echo                                       #T_ECHO
                                           #echo_expr_list
                                            #expr
                                             #expr_without_variable
                                              #expr
                                               #r_variable
                                                #variable
                                                 #base_variable_with_function_calls
                                                  #function_call
                                                   #namespace_name
substr_replace                                      #T_STRING
                                                   #function_call_parameter_list
(                                                   #'('
                                                    #non_empty_function_call_parameter_list
                                                     #function_call_parameter
                                                      #variable
                                                       #base_variable_with_function_calls
                                                        #base_variable
                                                         #reference_variable
                                                          #compound_variable
$line                                                      #T_VARIABLE
,                                                    #','
                                                     #function_call_parameter
                                                      #expr_without_variable
                                                       #expr
                                                        #r_variable
                                                         #variable
                                                          #base_variable_with_function_calls
                                                           #base_variable
                                                            #reference_variable
                                                             #compound_variable
$n                                                            #T_VARIABLE
[                                                            #'['
                                                             #dim_offset
                                                              #expr
                                                               #expr_without_variable
                                                                #scalar
                                                                 #common_scalar
'text'                                                            #T_CONSTANT_ENCAPSED_STRING
]                                                            #']'
.                                                      #'.'
                                                       #expr
                                                        #expr_without_variable
                                                         #scalar
                                                          #common_scalar
' '                                                        #T_CONSTANT_ENCAPSED_STRING
,                                                    #','
                                                     #function_call_parameter
                                                      #expr_without_variable
                                                       #scalar
                                                        #common_scalar
0                                                        #T_LNUMBER
,                                                    #','
                                                     #function_call_parameter
                                                      #expr_without_variable
                                                       #expr
                                                        #expr_without_variable
                                                         #scalar
                                                          #common_scalar
1                                                          #T_LNUMBER
+                                                      #'+'
                                                       #expr
                                                        #r_variable
                                                         #variable
                                                          #base_variable_with_function_calls
                                                           #function_call
                                                            #namespace_name
strlen                                                       #T_STRING
                                                            #function_call_parameter_list
(                                                            #'('
                                                             #non_empty_function_call_parameter_list
                                                              #function_call_parameter
                                                               #variable
                                                                #base_variable_with_function_calls
                                                                 #base_variable
                                                                  #reference_variable
                                                                   #compound_variable
$n                                                                  #T_VARIABLE
[                                                                  #'['
                                                                   #dim_offset
                                                                    #expr
                                                                     #expr_without_variable
                                                                      #scalar
                                                                       #common_scalar
'text'                                                                  #T_CONSTANT_ENCAPSED_STRING
]                                                                  #']'
)                                                            #')'
)                                                   #')'
.                                             #'.'
                                              #expr
                                               #expr_without_variable
                                                #scalar
                                                 #common_scalar
"\n"                                              #T_CONSTANT_ENCAPSED_STRING
;                                          #';'
}                                      #'}'
                                    #else_single
}                               #'}'
}                        #'}'
                      #top_statement
                       #statement
                        #unticked_statement
echo                     #T_ECHO
                         #echo_expr_list
                          #expr
                           #expr_without_variable
                            #scalar
                             #common_scalar
"<?php\n"                     #T_CONSTANT_ENCAPSED_STRING
;                        #';'
                      #top_statement
                       #statement
                        #unticked_statement
                         #expr
                          #r_variable
                           #variable
                            #base_variable_with_function_calls
                             #function_call
                              #namespace_name
print_ast                      #T_STRING
                              #function_call_parameter_list
(                              #'('
                               #non_empty_function_call_parameter_list
                                #function_call_parameter
                                 #expr_without_variable
                                  #combined_scalar
array                              #T_ARRAY
(                                  #'('
                                   #array_pair_list
                                    #non_empty_array_pair_list
                                     #expr
                                      #r_variable
                                       #variable
                                        #base_variable_with_function_calls
                                         #base_variable
                                          #reference_variable
                                           #compound_variable
$ast                                        #T_VARIABLE
                                    #possible_comma
)                                  #')'
)                              #')'
;                        #';'
