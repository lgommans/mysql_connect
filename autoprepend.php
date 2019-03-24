<?php
	function mysql_pconnect($host, $username, $password) {
		return mysql_connect("p:$host", $username, $password);
	}

	function mysql_connect($host, $username, $password) {
		global $__MYSQLSERVERDATA;

		if (strpos($host, 'p:') === 0) {
			$host = substr($host, 2);
			$persistent = true;
			$__MYSQLSERVERDATA['persistent'] = true;
		}

		if (strpos($host, ':') !== false) {
			list($host, $port) = explode(':', $host, 2);
			$port = intval($port);
			$__MYSQLSERVERDATA['port'] = $port;
		}

		if ($host == 'localhost') {
			$host = '10.0.0.7';
		}

		$__MYSQLSERVERDATA['host'] = $host;
		$__MYSQLSERVERDATA['user'] = $username;
		$__MYSQLSERVERDATA['pass'] = $password;

		if (isset($port)) {
			$__MYSQLSERVERDATA['conn'] = new mysqli(($persistent ? "p:" : "") . $host, $username, $password, "", $port); // "" is dbname
		}
		else {
			$__MYSQLSERVERDATA['conn'] = new mysqli(($persistent ? "p:" : "") . $host, $username, $password);
		}

		return $__MYSQLSERVERDATA['conn'];
	}

	function mysql_select_db($dbname) {
		global $__MYSQLSERVERDATA;
		return $__MYSQLSERVERDATA['conn']->query("use `$dbname`");
	}

	function mysql_query($query) {
		global $__MYSQLSERVERDATA;
		$__MYSQLSERVERDATA['lastresult'] = $__MYSQLSERVERDATA['conn']->query($query);
		return $__MYSQLSERVERDATA['lastresult'];
	}

	function mysql_error() {
		global $__MYSQLSERVERDATA;
		return $__MYSQLSERVERDATA['conn']->error;
	}

	function mysql_num_rows($result=-1) {
		global $__MYSQLSERVERDATA;

		if ($result === -1) {
			$result = $__MYSQLSERVERDATA['lastresult'];
		}

		return $result->num_rows;
	}

	function mysql_fetch_row($result=-1) {
		global $__MYSQLSERVERDATA;

		if ($result === -1) {
			$result = $__MYSQLSERVERDATA['lastresult'];
		}

		return $result->fetch_row();
	}

	function mysql_fetch_assoc($result=-1) {
		global $__MYSQLSERVERDATA;

		if ($result === -1) {
			$result = $__MYSQLSERVERDATA['lastresult'];
		}

		return $result->fetch_assoc();
	}

	function mysql_fetch_array($result=-1) {
		global $__MYSQLSERVERDATA;

		if ($result === -1) {
			$result = $__MYSQLSERVERDATA['lastresult'];
		}

		return $result->fetch_array();
	}

	function mysql_real_escape_string($str) {
		global $__MYSQLSERVERDATA;
		return $__MYSQLSERVERDATA['conn']->escape_string($str);
	}
