<?php

namespace Dreamcoil;

session_name('sessid');

session_start();

$_SESSION['Hey'] = 'Bla';

var_dump($_SESSION);
