This package is part of Moodle - https://moodle.org/

Moodle is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Moodle is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

@copyright      2013 Matt Bury <matbury@gmail.com>  {@link https://matbury.com}
@license        https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later


Presentation module (reveal.js)
==============================

The Presentation module is an alternative to PowerPoint, PDF, and other
web browser-unfriendly formats.

It uses the free and open source JavaScript slide show library, reveal.js

See: https://github.com/hakimel/reveal.js which includes helpful documentation
for creating and editing presentations. reveal.js can also be used as a 
standalone presentation player (in a web browser) and be used for creating, 
editing, and previewing presentations before uploading them to Moodle. There is 
an online presentation editor at: http://slid.es However, it is not free and 
open source and creating a "freemium" account is required to use it.

Installation

1. Upload /revealjs/ directory and all its contents to /moodle/mod/ 
2. In Moodle, login as administrator
3. Go to Administration > Site administration > Notifications
4. Installation process will initiate (follow the on-screen instructions)

During the installation process, the Presentation Module will attempt to move 
the /moodle/mod/revealjs/revealjs/ directory to /moodledata/repository/
If this fails, you will have to move the directory and all its contents manually.

There's an example presentation in /revealjs/_revealjs_/matbury/sdl_learner/ to 
get you started

For further information about installing activity modules in Moodle see:
http://docs.moodle.org/31/en/Installing_add-ons
