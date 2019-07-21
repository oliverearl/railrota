#!/bin/sh
# Author: Oliver Earl <ole4@aber.ac.uk>
# Manual build and count script using pdflatex / texcount

rm -f dissertation.pdf
if hash pdflatex 2>/dev/null; then
    pdflatex -synctex=1 -interaction=nonstopmode --shell-escape dissertation.tex
else
    echo 'pdflatex cannot be found in $PATH. Exiting.' >&2
    exit 1
fi
if hash perl 2>/dev/null; then
    if [ -e "texcount.pl" ]; then
        perl texcount.pl -inc -total dissertation.tex
    else
        echo 'Cannot find texcount.pl in local directory. Exiting.' >&2
        exit 1
    fi
else
    echo 'Perl is not installed. Exiting.' >&2
    exit 1
fi
