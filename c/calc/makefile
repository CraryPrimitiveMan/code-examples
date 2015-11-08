objects = calc lex.yy.c y.output y.tab.c y.tab.h
default : y.tab.c lex.yy.c
	cc -o calc y.tab.c lex.yy.c

y.tab.c : calc.y
	yacc -dv calc.y

lex.yy.c : calc.l
	lex calc.l

.PHONY : clean
clean :
	rm -f $(objects)