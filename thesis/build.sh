rm mscthesis.pdf &&
pdflatex -synctex=1 -interaction=nonstopmode --shell-escape mscthesis.tex &&
perl texcount.pl -inc -total mscthesis.tex