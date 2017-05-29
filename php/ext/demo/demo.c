/*
  +----------------------------------------------------------------------+
  | PHP Version 7                                                        |
  +----------------------------------------------------------------------+
  | Copyright (c) 1997-2017 The PHP Group                                |
  +----------------------------------------------------------------------+
  | This source file is subject to version 3.01 of the PHP license,      |
  | that is bundled with this package in the file LICENSE, and is        |
  | available through the world-wide-web at the following url:           |
  | http://www.php.net/license/3_01.txt                                  |
  | If you did not receive a copy of the PHP license and are unable to   |
  | obtain it through the world-wide-web, please send a note to          |
  | license@php.net so we can mail you a copy immediately.               |
  +----------------------------------------------------------------------+
  | Author:                                                              |
  +----------------------------------------------------------------------+
*/

/* $Id$ */

#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include "php.h"
#include "php_ini.h"
#include "ext/standard/info.h"
#include "php_demo.h"

/* If you declare any globals in php_demo.h uncomment this:
ZEND_DECLARE_MODULE_GLOBALS(demo)
*/

/* True global resources - no need for thread safety here */
static int le_demo;

/* {{{ PHP_INI
 */
/* Remove comments and fill if you need to have entries in php.ini
PHP_INI_BEGIN()
    STD_PHP_INI_ENTRY("demo.global_value",      "42", PHP_INI_ALL, OnUpdateLong, global_value, zend_demo_globals, demo_globals)
    STD_PHP_INI_ENTRY("demo.global_string", "foobar", PHP_INI_ALL, OnUpdateString, global_string, zend_demo_globals, demo_globals)
PHP_INI_END()
*/
/* }}} */

/* Remove the following function when you have successfully modified config.m4
   so that your module can be compiled into PHP, it exists only for testing
   purposes. */
PHP_FUNCTION(hello)
{
    zend_string *hello;
    hello = strpprintf(0, "hello world");
    RETURN_STR(hello);

}

PHP_FUNCTION(get_size)
{
    zval *val;
    size_t size;
    zend_string *result;
    HashTable *myht;

    if (zend_parse_parameters(ZEND_NUM_ARGS(), "z", &val) == FAILURE) {
        return;
    }

    if (Z_TYPE_P(val) == IS_STRING) {
        result = strpprintf(0, "string size is %d", Z_STRLEN_P(val));
    } else if (Z_TYPE_P(val) == IS_ARRAY) {
        myht = Z_ARRVAL_P(val);
        result = strpprintf(0, "array size is %d", zend_array_count(myht));
    } else {
        result = strpprintf(0, "can not support");
    }

    RETURN_STR(result);
}

PHP_FUNCTION(str_concat)
{
    zend_string *prefix, *subject, *result;
    zval *string;

    if (zend_parse_parameters(ZEND_NUM_ARGS(), "Sz", &prefix, &string) == FAILURE) {
        return;
    }

    subject = zval_get_string(string);
    if (zend_binary_strncmp(ZSTR_VAL(prefix), ZSTR_LEN(prefix), ZSTR_VAL(subject), ZSTR_LEN(subject), ZSTR_LEN(prefix)) == 0) {
        RETURN_STR(subject);
    }
    result = strpprintf(0, "%s %s", ZSTR_VAL(prefix), ZSTR_VAL(subject));
    RETURN_STR(result);
}

PHP_FUNCTION(array_concat)
{
    zval *arr, *prefix, *entry, *prefix_entry, value;
    zend_string *string_key, *result;
    zend_ulong num_key;

    if (zend_parse_parameters(ZEND_NUM_ARGS(), "aa", &arr, &prefix) == FAILURE) {
        return;
    }
    
    array_init_size(return_value, zend_hash_num_elements(Z_ARRVAL_P(arr)));
    
    ZEND_HASH_FOREACH_KEY_VAL(Z_ARRVAL_P(arr), num_key, string_key, entry) {
        if (string_key && zend_hash_exists(Z_ARRVAL_P(prefix), string_key)) {
            prefix_entry = zend_hash_find(Z_ARRVAL_P(prefix), string_key);
            if (Z_TYPE_P(entry) == IS_STRING && prefix_entry != NULL && Z_TYPE_P(prefix_entry) == IS_STRING) {
                result = strpprintf(0, "%s%s", Z_STRVAL_P(prefix_entry), Z_STRVAL_P(entry));
                ZVAL_STR(&value, result);
                zend_hash_update(Z_ARRVAL_P(return_value), string_key, &value);
            }
        } else if (string_key == NULL && zend_hash_index_exists(Z_ARRVAL_P(prefix), num_key)) {
            prefix_entry = zend_hash_index_find(Z_ARRVAL_P(prefix), num_key);
            if (Z_TYPE_P(entry) == IS_STRING && prefix_entry != NULL && Z_TYPE_P(prefix_entry) == IS_STRING) {
                result = strpprintf(0, "%s%s", Z_STRVAL_P(prefix_entry), Z_STRVAL_P(entry));
                ZVAL_STR(&value, result);
                zend_hash_index_update(Z_ARRVAL_P(return_value), num_key, &value);
            }
        } else if (string_key) {
            zend_hash_update(Z_ARRVAL_P(return_value), string_key, entry);
            zval_add_ref(entry);
        } else {
            zend_hash_index_update(Z_ARRVAL_P(return_value), num_key, entry);
            zval_add_ref(entry);
        }
    }ZEND_HASH_FOREACH_END();
}

static void say_hash_destroy(HashTable *ht)
{
    zend_string *key;
    zval *element;

    if ((ht)->u.flags & HASH_FLAG_INITIALIZED) {
        ZEND_HASH_FOREACH_STR_KEY_VAL(ht, key, element) {
            if (key) {
                free(key);
            }
            switch (Z_TYPE_P(element)) {
                case IS_STRING:
                    free(Z_PTR_P(element));
                    break;
                case IS_ARRAY:
                    say_hash_destroy(Z_ARRVAL_P(element));
                    break;
            }
        } ZEND_HASH_FOREACH_END();
        free(HT_GET_DATA_ADDR(ht));
    }
    free(ht);
}

static void say_entry_dtor_persistent(zval *zvalue)
{
    if (Z_TYPE_P(zvalue) == IS_ARRAY) {
        say_hash_destroy(Z_ARRVAL_P(zvalue));
    } else if (Z_TYPE_P(zvalue) == IS_STRING) {
        zend_string_release(Z_STR_P(zvalue));
    }
}

PHP_MINIT_FUNCTION(say)
{
    zend_constant c;
    zend_string *key;
    zval value;
    ZVAL_NEW_PERSISTENT_ARR(&c.value);
    zend_hash_init(Z_ARRVAL(c.value), 0, NULL, (dtor_func_t)say_entry_dtor_persistent, 1);
    add_index_long(&c.value, 0, 2);
    key = zend_string_init("site", 4, 1);
    ZVAL_STR(&value, zend_string_init("www.bo56.com", 12, 1));
    zend_hash_update(Z_ARRVAL(c.value), key, &value);
    c.flags = CONST_CS|CONST_PERSISTENT;
    c.name = zend_string_init("__ARR__", 7, 1);
    c.module_number = module_number;
    zend_register_constant(&c);

    REGISTER_STRINGL_CONSTANT("__SITE__", "www.bo56.com", 12, CONST_PERSISTENT);
    REGISTER_NS_STRINGL_CONSTANT("say", "__SITE__", " 疯狂的原始人", 18, CONST_CS|CONST_PERSISTENT);
}

PHP_MSHUTDOWN_FUNCTION(say)
{
    zval *val;
    val = zend_get_constant_str("__ARR__", 7);
    say_hash_destroy(Z_ARRVAL_P(val));
    ZVAL_NULL(val);
    return SUCCESS;
}

/* Every user-visible function in PHP should document itself in the source */
/* {{{ proto string confirm_demo_compiled(string arg)
   Return a string to confirm that the module is compiled in */
PHP_FUNCTION(confirm_demo_compiled)
{
	char *arg = NULL;
	size_t arg_len, len;
	zend_string *strg;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "s", &arg, &arg_len) == FAILURE) {
		return;
	}

	strg = strpprintf(0, "Congratulations! You have successfully modified ext/%.78s/config.m4. Module %.78s is now compiled into PHP.", "demo", arg);

	RETURN_STR(strg);
}
/* }}} */
/* The previous line is meant for vim and emacs, so it can correctly fold and
   unfold functions in source code. See the corresponding marks just before
   function definition, where the functions purpose is also documented. Please
   follow this convention for the convenience of others editing your code.
*/


/* {{{ php_demo_init_globals
 */
/* Uncomment this function if you have INI entries
static void php_demo_init_globals(zend_demo_globals *demo_globals)
{
	demo_globals->global_value = 0;
	demo_globals->global_string = NULL;
}
*/
/* }}} */

/* {{{ PHP_MINIT_FUNCTION
 */
PHP_MINIT_FUNCTION(demo)
{
	/* If you have INI entries, uncomment these lines
	REGISTER_INI_ENTRIES();
	*/
	return SUCCESS;
}
/* }}} */

/* {{{ PHP_MSHUTDOWN_FUNCTION
 */
PHP_MSHUTDOWN_FUNCTION(demo)
{
	/* uncomment this line if you have INI entries
	UNREGISTER_INI_ENTRIES();
	*/
	return SUCCESS;
}
/* }}} */

/* Remove if there's nothing to do at request start */
/* {{{ PHP_RINIT_FUNCTION
 */
PHP_RINIT_FUNCTION(demo)
{
#if defined(COMPILE_DL_DEMO) && defined(ZTS)
	ZEND_TSRMLS_CACHE_UPDATE();
#endif
	return SUCCESS;
}
/* }}} */

/* Remove if there's nothing to do at request end */
/* {{{ PHP_RSHUTDOWN_FUNCTION
 */
PHP_RSHUTDOWN_FUNCTION(demo)
{
	return SUCCESS;
}
/* }}} */

/* {{{ PHP_MINFO_FUNCTION
 */
PHP_MINFO_FUNCTION(demo)
{
	php_info_print_table_start();
	php_info_print_table_header(2, "demo support", "enabled");
	php_info_print_table_end();

	/* Remove comments if you have entries in php.ini
	DISPLAY_INI_ENTRIES();
	*/
}
/* }}} */

/* {{{ demo_functions[]
 *
 * Every user visible function must have an entry in demo_functions[].
 */
const zend_function_entry demo_functions[] = {
	PHP_FE(hello,	NULL)
	PHP_FE(get_size,	NULL)
	PHP_FE(str_concat,	NULL)
	PHP_FE(array_concat,	NULL)
	PHP_FE(confirm_demo_compiled,	NULL)		/* For testing, remove later. */
	PHP_FE_END	/* Must be the last line in demo_functions[] */
};
/* }}} */

/* {{{ demo_module_entry
 */
zend_module_entry demo_module_entry = {
	STANDARD_MODULE_HEADER,
	"demo",
	demo_functions,
	PHP_MINIT(demo),
	PHP_MSHUTDOWN(demo),
	PHP_RINIT(demo),		/* Replace with NULL if there's nothing to do at request start */
	PHP_RSHUTDOWN(demo),	/* Replace with NULL if there's nothing to do at request end */
	PHP_MINFO(demo),
	PHP_DEMO_VERSION,
	STANDARD_MODULE_PROPERTIES
};
/* }}} */

#ifdef COMPILE_DL_DEMO
#ifdef ZTS
ZEND_TSRMLS_CACHE_DEFINE()
#endif
ZEND_GET_MODULE(demo)
#endif

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: noet sw=4 ts=4 fdm=marker
 * vim<600: noet sw=4 ts=4
 */
