moodle/mod/revealjs/example_presentation/

This directory is not in the correct place!

The Presentation (mod_revealjs) module won't work without it!

Please put it in your moodledata directory so that the path names look like this:

/moodledata/repository/revealjscontent/aaaaa/matbury/hello_world/etc...

The Presentation module will search for all HTML files (presentations) in
/moodledata/repository/revealjscontent/aaaaa/*/*/*.html where * is a wildcard.

Presentations and media are stored and organised independently of Moodle's file
manager, making creating, editing, sharing, and transferring presentations
easier.

/matbury/ is my namespace, choose one for yourself, e.g. /johnsmith/
That way, everyone can immediately see which presentations are yours.

/hello_world/ is the name of the presentation. Keep them short but descriptive,
e.g. /esl_first_class_introduction/

Examine the example presentation and directories carefully to see how a
presentation is constructed.

These directories:
/moodledata/repository/revealjscontent/css/etc...
/moodledata/repository/revealjscontent/js/etc...
/moodledata/repository/revealjscontent/lib/etc...
/moodledata/repository/revealjscontent/plugin/etc...

and this file:
/moodledata/repository/revealjscontent/designer.html

are a complete HTML web page and software for creating, editing, and previewing
presentations before uploading them to Moodle. Open designer.html in a web
browser to see an example presentation.