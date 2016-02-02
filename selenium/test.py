import getpass
from selenium import webdriver

browser = webdriver.Firefox()
browser.get('https://www.baidu.com/')
browser.get('https://github.com')
pwd = getpass.getpass('password: ')
print(pwd)
