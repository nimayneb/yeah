#!/bin/bash

for foreground in 38 48 ; do
    for color in {0..256} ; do
        echo -en "\e[${foreground};5;${color}m ${color}\t\e[0m"

        if [ $((($color + 1) % 10)) == 0 ] ; then
            echo
        fi
    done
    echo
done

exit 0
