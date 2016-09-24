#!/bin/bash
echo -en "\e[93;44m test\e[0m"
exit 0

for backgroundColor in {40..47} {100..107} 49 ; do
    for foregroundColor in {30..37} {90..97} 39 ; do
        for rendition in 0 1 2 4 5 7 ; do
            echo -en "\e[${attr};${backgroundColor};${foregroundColor}m ^[${rendition};${backgroundColor};${foregroundColor}m \e[0m"
        done
        echo
    done
done

exit 0
