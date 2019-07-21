#!/bin/sh
# This script was found here and is credited accordingly:
# https://gist.github.com/dougalsutherland/266983/9c88f1ca1cf1420af03166dcfccb9cb10a21c110

arg=${1:-.}
exts="aux bbl blg brf idx ilg ind lof log lol lot out toc synctex.gz"

if [ -d $arg ]; then
    for ext in $exts; do
         rm -f $arg/*.$ext
    done
else
    for ext in $exts; do
         rm -f $arg.$ext
    done
fi
echo "Directory cleaned!"