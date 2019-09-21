#!/bin/bash

checkout-code ~/build
cd ~/build

#restore-from-cache repository "dependencies-$(sha1sum some.lock | awk '{print $1}')"
#store-in-cache repository "dependencies" vendor/
#
#if [ ! exists-in-cache repository "dependencies" ]
#then
#    echo "$1 is a file"
#else
#    echo "$1 is not a file"
#fi
