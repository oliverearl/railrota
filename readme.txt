Web-Based Rostering System for Volunteer Worked Organisations - MSc Project CHM9360
'Railrota'
***********************
Oliver Earl
ole4@aber.ac.uk

A live instance of the application is available on my personal webspace for your convenience:
https://www.oliverearl.co.uk/railrota

Email: jane.doe@railrota.com
Password: password

***********************
Directories of this Repository
***********************
--project--
This contains all of the files that make up the developed software project, Railrota. This will include fully pre-compiled
assets and code, and preinstalled dependencies, *UNLESS*, you have cloned this repository from GitHub, in which case, you'll
have to follow the instructions below. It's relatively straightforward in any case.

More in-depth information into the subdirectories within this subdirectory and the other files and their respective purposes
can be found in the readme.md file therein.

--written_deliverable--
This is a compiled PDF of the final thesis deliverable. It is the same document as the additional write-up document that was 
submitted to Blackboard.

--thesis--
This contains the LaTeX source code of the write-up, including any appendices and images. There are also Bash and Perl 
scripts for quickly compiling the markup and performing word counts. Please see the readme.txt file in this subdirectory for 
more information.

--specification--
This contains PDFs and text files that have been provided by my supervisor, or have been downloaded from Blackboard. They
are there to provide additional meta information if necessary, but they should not be marked or considered a part of the thesis.

***********************
Application Deployment Instructions
***********************
The application is written in Laravel - a framework for the PHP programming language. You will need at least
PHP 7.1 to install and run the application. You will also need Node.js and either NPM or Yarn to download 
and compile front-end assets, such as JavaScript and Sass. 

There is an automated installation script written in Bash. I can confirm that it works, and I would recommend making use of it.
Please see the readme Markdown file in the project subdirectory for more information, as well as instructions on manual installation and deployment.

Alternatiely, simply uploading the entire folder and modifying the .env file to match your database configuration should be sufficient at
the bare minimum, provided you run *php artisan migrate:fresh* to set up the new database configuration. You will probably 
want to set up an administrator user too, which can be done afterwards with *php artisan db:seed --class=AdminSeeder*
(This is not an option if you got this project from GitHub.)

***********************
Thesis Compilation Instructions
***********************
Should you wish to compile the thesis from source, please use pdflatex. More information can be found in the readme.txt
file in the thesis subdirectory. Consulting the code comments in 'dissertation.tex' may also prove useful.

***********************
Running Tests
***********************
After a full installation of Railrota, you can run tests by executing *composer run test* to print out PHPUnit feature
and unit tests results to stdout, or alternatively *composer run test-export* to output test results to a formatted
HTML file.

If you encounter any problems, your installation may not be installed correctly. #worksonmymachine

***********************
Generating Documentation
***********************
Generated documentation has been included in the *project/docs* folder. However, if you wish to regenerate them for 
any reason, you can run *composer run docs* to invoke the Sami tool.

***********************
License
***********************
The Railrota software is governed by an MIT license. It is free software.

The thesis content is not under license and remains the works of Oliver Earl unless stated otherwise.

***********************
Third-Party Licenses
***********************

Application:

- Laravel Framework and its dependencies - MIT 
    (https://github.com/laravel/laravel)
- DOMPDF Wrapper for Laravel - MIT 
    (https://github.com/barryvdh/laravel-dompdf)
- Sami API Documentation Generator - MIT 
    (https://github.com/FriendsOfPHP/Sami)
- PHPUnit - BSD-3 Clause 
    https://github.com/sebastianbergmann/phpunit)

Thesis:

- LaTeX Design derived from MMP Layout by Neil Taylor and Hannah Dee
    (https://github.com/digidol/MMP)
- TeXCount Perl Script for performing word count operations - LaTeX Project Public License
    (https://app.uio.no/ifi/texcount/about.html) - (https://www.latex-project.org/lppl.txt)

***********************
Troubleshooting
***********************
More information on application troubleshooting is available in the *project/readme.md* file. 

Please note that you can email me for assistance at any time at ole4@aber.ac.uk

From the 27th of September, I might not have access to my Aberystwyth email address any more, so it would be 
advisable to email me on oliver.earl@mail.bcu.ac.uk as I will be a full time student of Birmingham City University
by then.

Furthermore, you can find this entire repository on GitHub at https://github.com/oliverearl/railrota.
It will be set to private until it is fully marked, so please contact me for access.