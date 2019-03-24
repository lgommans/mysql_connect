# mysql_connect

Configure PHP to autoprepend this file and you can just upgrade to a newer PHP version without worrying about mysql_\* functions.

Note that you'll probably want to delete this if-statement and its contents: https://github.com/lgommans/mysql_connect/blob/master/autoprepend.php#L21 (I'm committing it with this because I link it to other users of my server, that might also want to use it, and for them it's convenient to have).
