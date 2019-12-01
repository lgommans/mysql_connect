<?php
	function mysql_pconnect($host, $username, $password) {
		return mysql_connect("p:$host", $username, $password);
	}

	function mysql_connect($host, $username, $password) {
		global $__MYSQLSERVERDATA;

		$persistent = false;
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

	function mysql_unbuffered_query($query) {
		global $__MYSQLSERVERDATA;
		$__MYSQLSERVERDATA['lastresult'] = $__MYSQLSERVERDATA['conn']->query($query);
		return $__MYSQLSERVERDATA['lastresult'];
	}

	function mysql_errno() {
		global $__MYSQLSERVERDATA;
		return $__MYSQLSERVERDATA['conn']->errno;
	}

	function mysql_error() {
		global $__MYSQLSERVERDATA;
		return $__MYSQLSERVERDATA['conn']->error;
	}

	function mysql_affected_rows($conn=-1) {
		global $__MYSQLSERVERDATA;

		if ($conn === -1) {
			$conn = $__MYSQLSERVERDATA['conn'];
		}

		return $conn->affected_rows;
	}

	function mysql_num_rows($result=-1) {
		global $__MYSQLSERVERDATA;

		if ($result === -1) {
			$result = $__MYSQLSERVERDATA['lastresult'];
		}

		return $result->num_rows;
	}

	function mysql_free_result($result) {
		$result->free_result();
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

	function mysql_insert_id($conn=-1) {
		global $__MYSQLSERVERDATA;

		if ($conn === -1) {
			$conn = $__MYSQLSERVERDATA['conn'];
		}

		return $conn->insert_id;
	}

	function mysql_escape_string($str) {
		global $__MYSQLSERVERDATA;
		return $__MYSQLSERVERDATA['conn']->escape_string($str);
	}

	function mysql_real_escape_string($str) {
		global $__MYSQLSERVERDATA;
		return $__MYSQLSERVERDATA['conn']->escape_string($str);
	}

	function mysql_result($result, $rowno, $field=0) {
		while ($rowno > 0) {
			$row = $result->fetch_row();
			$rowno--;
		}
		return $result->fetch_array()[$field];
	}

