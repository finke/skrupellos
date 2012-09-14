<?php
$navi = new \skrupellos\Navi();
$navi->addGroup('Hauptmenü');
$navi->addItem('HOME', './', 'Hauptmenü');
$navi->addItem('HOME', './?', 'Hauptmenü');
\skrupellos\Main::addContent($navi->getNavi(), 'nav');
