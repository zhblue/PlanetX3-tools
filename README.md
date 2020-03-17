# PlanetX3-tools
Tools works on 8 Bit Guy's retro game planet x3

Demo

https://www.youtube.com/watch?v=tEMbb5-Yp7E&t=18s

The savegame.dat viewer (php)

http://px3.hustoj.com


Usage
--

Copy pxff.exe into planetx3's directory, execute it.

Saved game will get full Mine/Gas/Power with 255 ( pxff means 0xff )


* Planet X3 is a great retro game work on all x86 machines. Click [Here](http://www.the8bitguy.com/product/planet-x3-for-ms-dos-computers/)


map of savegame.dat
--

0x0000 - 0x7fff  256x128 tile codes top-left=0x0000

0x8000 - 0x8013  unit type 01:builder 02:tank 03:heavy tank

0x8014 - constructions type 14:Headquarters 15:Radar 16 19:factory 1A:Missile Silo

0x8080 - enemy constructions type  21:HQ 22:Gun Tower

0x8100 - 0x8113  unit X position

0x8180 -         enemy constructions X position

0x8200 - 0x8213  unit Y position

0x8280 -         enemy construction Y position

0x8300 - 0x8313  constructions X position

0x8400 - 0x8413  constructions Y position

0x8700 - 0x873f  life values for units and constructions

0x8740 - 0x876f  ~ unknown area

0x8780 - 0x87bf  enemy lifes for units and constructions (guess)

0x87c0 - 0x8fff  ~ unknown area

0x8910 - missile silo fill up

0x9000 - 0x9001  ~ unknown area

0x9002 -           Difficulty 0 1 2

0x9003 -           Mine

0x9004 -           Gas

0x9005 -           Energy

0x9006 - 0x900f ~ unknown area

0x9010 -          ms

0x9011 -        ~ unknown area

0x9012 -          Second

0x9013 -          Minute

0x9014 -          Hour

