rm dissertation.pdf &&
pdflatex -synctex=1 -interaction=nonstopmode --shell-escape dissertation.tex &&
perl texcount.pl -inc -total dissertation.tex