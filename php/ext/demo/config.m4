dnl $Id$
dnl config.m4 for extension demo

dnl Comments in this file start with the string 'dnl'.
dnl Remove where necessary. This file will not work
dnl without editing.

dnl If your extension references something external, use with:

dnl PHP_ARG_WITH(demo, for demo support,
dnl Make sure that the comment is aligned:
dnl [  --with-demo             Include demo support])

dnl Otherwise use enable:

PHP_ARG_ENABLE(demo, whether to enable demo support,
Make sure that the comment is aligned:
[  --enable-demo           Enable demo support])

if test "$PHP_DEMO" != "no"; then
  dnl Write more examples of tests here...

  dnl # --with-demo -> check with-path
  dnl SEARCH_PATH="/usr/local /usr"     # you might want to change this
  dnl SEARCH_FOR="/include/demo.h"  # you most likely want to change this
  dnl if test -r $PHP_DEMO/$SEARCH_FOR; then # path given as parameter
  dnl   DEMO_DIR=$PHP_DEMO
  dnl else # search default path list
  dnl   AC_MSG_CHECKING([for demo files in default path])
  dnl   for i in $SEARCH_PATH ; do
  dnl     if test -r $i/$SEARCH_FOR; then
  dnl       DEMO_DIR=$i
  dnl       AC_MSG_RESULT(found in $i)
  dnl     fi
  dnl   done
  dnl fi
  dnl
  dnl if test -z "$DEMO_DIR"; then
  dnl   AC_MSG_RESULT([not found])
  dnl   AC_MSG_ERROR([Please reinstall the demo distribution])
  dnl fi

  dnl # --with-demo -> add include path
  dnl PHP_ADD_INCLUDE($DEMO_DIR/include)

  dnl # --with-demo -> check for lib and symbol presence
  dnl LIBNAME=demo # you may want to change this
  dnl LIBSYMBOL=demo # you most likely want to change this 

  dnl PHP_CHECK_LIBRARY($LIBNAME,$LIBSYMBOL,
  dnl [
  dnl   PHP_ADD_LIBRARY_WITH_PATH($LIBNAME, $DEMO_DIR/$PHP_LIBDIR, DEMO_SHARED_LIBADD)
  dnl   AC_DEFINE(HAVE_DEMOLIB,1,[ ])
  dnl ],[
  dnl   AC_MSG_ERROR([wrong demo lib version or lib not found])
  dnl ],[
  dnl   -L$DEMO_DIR/$PHP_LIBDIR -lm
  dnl ])
  dnl
  dnl PHP_SUBST(DEMO_SHARED_LIBADD)

  PHP_NEW_EXTENSION(demo, demo.c, $ext_shared,, -DZEND_ENABLE_STATIC_TSRMLS_CACHE=1)
fi
