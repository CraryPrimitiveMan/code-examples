try:
    print('try......')
    r = 10 / int('2')
    print('result:', r)
except ValueError as e:
    print('ValueError:', e)
except ZeroDivisionError as e:
    print('ZeroDividionError:', e)
else:
    print('no error!')
finally:
    print('finally......')
print('END')
