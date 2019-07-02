

% mscthesis.cls was uwthesis.cls

%

% The Aber thesis style based on the Stanford thesis style

% Modified Richard Huss <rah94@aber.ac.uk> 17 Dec 1997
% Modified Edel Sherratt <eds@aber.ac.uk> 15 Jan 2018
% Adapted by Edel Sherratt <eds@aber.ac.uk> for master's dissertations.

%

% Please see the file 'README' for details, and thesis.tex and mybib.bib

% for sample usage. You should have received copies of all these files

% with this one, if not complain to the person you got this from.

% Some of these seem to have been lost from the package over the years ...



\NeedsTeXFormat{LaTeX2e}

\ProvidesClass{mscthesis}

\typeout{Aberthesis style May 1990 written by jjh based on suthesis}

\typeout{uwthesis - Modified for LaTeX2e by Richard Huss}
\typeout{uwthesis - Modified for Aberystwyth University by Edel Sherratt}


% Our basis---the standard report class

\LoadClass[12pt,titlepage ]{report}


% Some extra packages we need



%\RequirePackage{a4wide}

\usepackage{geometry}

\RequirePackage{authordate1-4}

\RequirePackage{setspace}

\RequirePackage{ifthen}





% Do we want lists of figures and tables? By default, yes.

\newboolean{@wantlistoffigures}

\setboolean{@wantlistoffigures}{true}

\newboolean{@wantlistoftables}

\setboolean{@wantlistoftables}{true}



\DeclareOption{nolof}{\setboolean{@wantlistoffigures}{false}}

\DeclareOption{nolot}{\setboolean{@wantlistoftables}{false}}



\ProcessOptions



% Set the margins etc.



\geometry{a4paper,left=1.5in,right=1in,top=1in,bottom=1in,nohead}



%\setlength{\oddsidemargin}{0.5in}

%\setlength{\evensidemargin}{0.5in}

%\setlength{\marginparwidth}{40pt}

%\setlength{\marginparsep}{9pt}

%\setlength{\topmargin}{0pt}

%\setlength{\headsep}{.3in}

%\setlength{\textheight}{8.1in}

%\setlength{\textwidth}{6.2in}

%\setlength{\topsep}{0pt}



% Set parameters for floats



\setcounter{totalnumber}{10}               % Pretty unlikely

\renewcommand{\topfraction}{0.85}          % Floats may occupy up to 85%

\renewcommand{\bottomfraction}{0.85}       %  of the page. This is slightly

\renewcommand{\textfraction}{0.15}         %  different to the old style

\renewcommand{\floatpagefraction}{0.60}    % Can allow quite a lot of

                                           %  whitespace on a float page





% And a few other things

\setcounter{secnumdepth}{10}

\pagenumbering{arabic}



 



% Macros to define department, supervisor and submission date



\def\dept#1{\gdef\@dept{#1}}

\def\supervisor#1{\gdef\@supervisor{#1}}
\def\degree#1{\gdef\@degree{#1}}
\def\module#1{\gdef\@module{#1}}

\def\submitdate#1{\gdef\@submitdate{#1}}



% and set defaults for these values



  \def\@title{}

  \def\@author{}\def\@dept{Department of Computer Science}

  \def\@supervisor{}
  
  \def\@degree{}
  
  \def\@module{}

  \def\@submitdate{\ifcase\the\month\or

    January\or February\or March\or April\or May\or June\or

    July\or August\or September\or October\or November\or December\fi

    \space \number\the\year}



% new command to create a blank page; thanks to Leo Breebaart https://www.kronto.org/thesis/tips/empty-pages.html - eds 15th Jan 2018
  \def\blankpage{%
  	
        \newpage
        
        \thispagestyle{empty}%
        \mbox{}
         
        \newpage
  }



% Generate title page

\def\titlep{%

        \thispagestyle{empty}%

        \ \vspace{1in}%

        \begin{center}

                {\Large\expandafter{\bf \@title}}

        \end{center}

        \vspace{0.75in}

        \begin{center}

                {\large\bf \@author} \\

        \vspace{1in}

          \@dept \\

          Aberystwyth University\\
          Wales \\

        \vspace{0.5in}

        \@submitdate

        \end{center}

        \vspace{1.5in}

        \begin{center}

        \begin{minipage}{5in}

         \begin{center}

          This thesis is submitted in partial fulfilment of the

          requirements for the degree of Master of Science\\ 

          \end{center}
      
      \vspace{1.5in}
      
      \begin{minipage}[b]{5in}
          Degree: \@degree\\
          Module: \@module\\
          Supervisor: \@supervisor
      \end{minipage}

          \end{minipage}

        \end{center}

     }



% Declaration

%\long\def\declaration#1{%

%\begin{center}

%\begin{minipage}{4.5in}

%\null\vskip1in

% \vskip.5in

%\begin{center}

%{\Large {\bf Certification}}

%\end{center}

%\vfill

%\vspace{.5in}

%\parindent=0pt

%The work presented in this thesis has been carried out under the

%supervision of \@supervisor\ of the \@dept,

%University of Wales, Aberystwyth.

%\par

%\vspace{1in}

%\hbox to 4in{\hfil\shortstack{\vrule width 3in height 0.4pt\\{\bf #1}}}

%\vspace{.75in}        

%\hbox to 4in{\hfil\shortstack{\vrule width 3in height 0.4pt\\

%{\bf \@supervisor}\\

%(Supervisor)}}

%\end{minipage}

%\end{center}}



% Declaration page

%\def\declarationpage{%

%        \vfill

%        \hspace{1.5in}

%       \declaration\@author

%       \vfill

%        }



% Signature

%\long\def\signature#1{%

%\begin{center}

%\begin{minipage}{4.5in}

%\null\vskip1in

%\vskip.5in

%\begin{center}

%{\Large {\bf Declaration}}

%\end{center}

%\vfill

%\parindent=0pt

%This thesis has not already been accepted in substance for any degree,

%and is not concurrently submitted in candidature for any degree.

%\par

%\vspace{1in}

%\hbox to 4in{\hfil\shortstack{\vrule width 3in height 0.4pt\\{\bf #1}}}

%\vspace{1in}

%Originality is not claimed for all parts of this thesis, where

%material from published sources is used appropriate acknowledgement is

%made both in the text and in the bibliography. Where source code has

%been provided, collaborators have been acknowledged in the text.

%\par

%\vspace{1in}

%\hbox to 4in{\hfil\shortstack{\vrule width 3in height 0.4pt\\{\bf #1}}}

%\vspace{.75in}        

%\hbox to 4in{\hfil\shortstack{\vrule width 3in height 0.4pt\\

%{\bf \@supervisor}\\

%(Supervisor)}}

%\end{minipage}

%\end{center}}



% Signature

\long\def\signaturepage{%

  \newlength{\candwidth}

  \settowidth{\candwidth}{(candidate)}

\vfill

\vfill

  \begin{center}

  {\Large {\bf Declaration}}

  \end{center}

\vfill

  \noindent This thesis has not previously been accepted in substance

  for any degree and is not being concurrently submitted in candidature

  for any degree.

\vfill

  \noindent Signed \dotfill (candidate)\\[1.5em]

  \noindent Date \dotfill \hspace{\candwidth}

\vfill

\vfill

  \begin{center}

  {\Large {\bf Statement 1}}

  \end{center}

\vfill

  \noindent This thesis is the result of my own investigations, except

  where otherwise stated.\\

  \noindent Other sources are acknowledged by footnotes giving explicit

  references. A bibliography is appended.

\vfill

  \noindent Signed \dotfill (candidate)\\[1.5em]

  \noindent Date \dotfill \hspace{\candwidth}

\vfill

\vfill

  \begin{center}

  {\Large {\bf Statement 2}}

  \end{center}

\vfill

  \noindent I hereby give consent for my thesis, if accepted, to be made

  available for photocopying and for inter-library loan, and for the

  title and summary to be made available to outside organisations.

\vfill

  \noindent Signed \dotfill (candidate)\\[1.5em]

  \noindent Date \dotfill \hspace{\candwidth}

\vfill

\vfill

}



\def\beforepreface{

        \titlep

        \blankpage

        \setcounter{page}{1}

        %\declarationpage

        %\blankpage

        %\signaturepage

        %\blankpage
    }



\def\prefacesection#1{%

        \newpage

        \begin{center}

        {\bf #1}

        \end{center}

        \vspace{2em}

}



\def\afterpreface{\newpage

        \tableofcontents

        \newpage

  \ifthenelse{\boolean{@wantlistoffigures}}{

          \listoffigures

          \newpage

  }{}

  \ifthenelse{\boolean{@wantlistoftables}}{

          \listoftables

          \newpage

  }{}

        \parskip=5pt plus 2pt minus 3pt

        }



% Things I decided to get rid of...



%\setcounter{tocdepth}{2}

%\brokenpenalty=10000

%\hyphenpenalty=5000

%\doublehyphendemerits=10000

%\finalhyphendemerits=10000

 

%\def\subsubsubsectionmark#1{}

%  \newcommand{\subsubsubsection}[1]{

%    \noindent

%    \paragraph{#1} \ \\

%    }



%\flushbottom



