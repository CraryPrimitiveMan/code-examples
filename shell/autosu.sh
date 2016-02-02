#! /usr/bin/expect -f
spawn su username
expect -exact "Password: "
send "password\n"
interact