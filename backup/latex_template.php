<?php
// latex_template.php
return <<<EOT
\\documentclass[12pt]{article}
\\usepackage[utf8]{inputenc}
\\usepackage{graphicx}
\\usepackage{geometry}
\\geometry{margin=1in}

\\begin{document}

% --------------------
% First Page: Title Page
% --------------------
\\begin{titlepage}
    \\centering
    \\vspace*{1cm}
    \\includegraphics[width=0.6\\textwidth]{%LOGO_PATH%} \\\\[2em]

    {\\Huge \\textbf{Survey Report}} \\\\[1.5em]
    {\\LARGE \\textbf{%SURVEY_TITLE%}} \\\\[3em]

    \\vfill
    {\\large \\textbf{Author:} %DOCUMENT_AUTHOR%} \\\\[0.5em]
    {\\large \\textbf{Date:} %DOCUMENT_DATE%}
\\end{titlepage}

\\newpage

% ------------------------
% Second Page: Recommendations
% ------------------------
\\section*{Recommendations}

%RECOMMENDATIONS%

\\end{document}
EOT;
?>
