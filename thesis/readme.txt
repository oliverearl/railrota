MSc Project report / Thesis
Author: Oliver Earl <ole4@aber.ac.uk>

This LaTeX template was constructed by Dr. Hannah Dee (hmd1@aber.ac.uk) and Neil Taylor (nst@aber.ac.uk) based on the Leeds thesis template and the Group Project template for Computer Science in Aberystwyth University. I credit it accordingly.

Comments and suggestions of the template itself should be directed to its GitHub repository: https://github.com/digidol/MMP

The template is designed to be used with pdflatex and may require modification to run with a different LaTeX engine. 

I am using LaTeX Workshop for Visual Studio Code for authoring, which compiles my mark-up automatically. You can also build manually by running the included build.sh file. Alternatively:

pdflatex dissertation
bibtex dissertation
pdflatex dissertaton (run this twice)


Either will result in dissertation.pdf being compiled.

I personally use the aforementioned extension for vscode to perform word counts, but I've included the TeXcount Perl 5 script in the repository to do this if desired. If you run build.sh, it will run this script for you after compilation.

Naturally, I didn't write it, so you can find it here: https://app.uio.no/ifi/texcount/