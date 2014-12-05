%pure_parser
%token NUMBER
%left '+' '-'
%left '*' '/'
%%

start:
    lines
;

lines:
    /* empty */
  | lines line
;

line:
    expr '\n'
  | '\n'
  | error '\n'
;

expr:
    expr '+' expr
  | expr '-' expr
  | expr '*' expr
  | expr '/' expr
  | '(' expr ')'
  | NUMBER
;

%%
