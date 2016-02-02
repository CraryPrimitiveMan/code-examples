class Animal(object):
    def run(self):
        print('Animal runing')

class Runnable(object):
    def run(self):
        print('Runnable Running')

class Dog(Animal, Runnable):
    pass

d = Dog()
d.run()
