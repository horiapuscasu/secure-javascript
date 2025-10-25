Highly apreciated if using this because me here to self-distinguish.

Include in footer(include function of PHP on providing those 2 variables) after you logged in $_REQUEST[$sess_name] and $_COOKIE[$sess_name] to check server side.

< ? php ob_flush(); header("Location : ".$url); exit(); ? > (absolute url starting / is documentroot, ../ parent directory, ./ the directory itself  or relative, the magic constant __ DIR __ the directory of the script https://www.php.net/manual/en/language.constants.magic.php ex __ DIR __ .DIRECTORY_SEPARATOR.".." the parent directory,PHP_EOL \r\n windows \n linux ex echo "\r\n";addslashes to escape quotes-allow quotes of one type between quotes of the same type, escape sequences... without generating before output to redirect to index to log in,destroying the output ob_flush(),echo "< pre >".print_r($variable,1)."</ pre >" or var_dump($variable) to output a variable;

< ? php .... ? > processing instruction,< ? = .... ? > the same as echo

~Equivalent to session.use_trans_sid = 1 in php.ini(use even .user.ini in directory files) this to secure your site and ajaxes with $sess_name = 'SESSION' and $cookie='A VALUE' IF YOU USE $_SESSION YOU NEED session_write_close VERY FAST.LoadModule access_compat_module modules/mod_access_compat.so in httpd.conf to enable .htaccess which a bit of legacy
