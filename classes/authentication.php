<?php
require_once 'dbHandler.php';
session_start();

class Authentication
{
	private $dbHandler;
	
	public function __construct()
	{
		$this->dbHandler = new dbHandler();
		if (empty($_SESSION['loggedIn']) || ($_SESSION['client'] != md5($_SERVER['HTTP_USER_AGENT'])) || ($_SESSION['ip'] != $_SERVER['REMOTE_ADDR']))
		{
			if (!empty($_COOKIE['autoLogin']))
			{
				$ip = $_SERVER['REMOTE_ADDR'];
				$client = md5($_SERVER['HTTP_USER_AGENT']);
				$key = md5($_COOKIE['autoLogin'].$client);
				$query = 'SELECT u.`username`,u.`passwd` FROM `autoLogin` AS a 
				LEFT JOIN `User` AS u 
				ON a.`id_user`=u.`id_user` WHERE a.`ip`="'.$ip.'" AND a.`key`="'.$key.'" LIMIT 1';
				$result = $this->dbHandler->ExecuteQuery($query);
				if (mysql_num_rows($result) > 0)
				{
					$row = mysql_fetch_assoc($result);
					if (!$this->Login($row['username'], $row['passwd'], true))
					{
						if (strpos($_SERVER['PHP_SELF'],'login') === false)
						{
							$_SESSION['autoRedirect'] = $_SERVER['REQUEST_URI'];
							header('Location: login.php');
						}
					}
				}
				else
				{
					if (strpos($_SERVER['PHP_SELF'],'login') === false)
					{
						$_SESSION['autoRedirect'] = $_SERVER['REQUEST_URI'];
						header('Location: login.php');
					}
				}
			}
			else
			{
				if (strpos($_SERVER['PHP_SELF'],'login') === false)
				{
					$_SESSION['autoRedirect'] = $_SERVER['REQUEST_URI'];
					header('Location: login.php');
				}
			}
		}
	}
	
	public function __destruct()
	{
		unset ($this->dbHandler);
	}
	
	public function Login($username, $passwd, $remember=false)
	{
		$username = mysql_real_escape_string($username);
		$query = 'SELECT `id_user` FROM `User` WHERE `username`="'.$username.'" AND `passwd`="'.$passwd.'" LIMIT 1';
		$result = $this->dbHandler->ExecuteQuery($query);
		if (mysql_num_rows($result) > 0)
		{
			$userID = mysql_fetch_assoc($result);
			$userID = $userID['id_user'];
			$ip = $_SERVER['REMOTE_ADDR'];
			$client = md5($_SERVER['HTTP_USER_AGENT']);
			$date = date('Y-m-d');
			if (!empty($_COOKIE['autoLogin']))
			{
				setcookie('autoLogin','',time()-6000);
			}
			$expire = $remember ? time()+60*60*24*7 : 0;
			$value = md5($username.$passwd.session_id());
			$key = md5($value.$client);
			setcookie('autoLogin', $value, $expire, '/','', false, true);
			$query = 'SELECT `lastVisited` FROM `autoLogin` WHERE `ip`="'.$ip.'"';
			$result = $this->dbHandler->ExecuteQuery($query);
			$this->dbHandler->ExecuteQuery('BEGIN');
			if (mysql_num_rows($result) > 0)
			{
				$query = 'UPDATE `autoLogin` SET `key`="'.$key.'", `lastVisited`="'.$date.'" WHERE `ip`="'.$ip.'"';
			}
			else
			{
				$query = 'INSERT INTO `autoLogin`(`id_user`, `ip`, `key`, `lastVisited`)
				VALUES('.$userID.', "'.$ip.'", "'.$key.'", "'.$date.'");';
			}
			if ($this->dbHandler->ExecuteQuery($query))
			{
				$this->dbHandler->ExecuteQuery('COMMIT');
				$_SESSION['loggedIn'] = true;
				$_SESSION['client'] = $client;
				$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
				return true;
			}
			else
			{
				$this->dbHandler->ExecuteQuery('ROLLBACK');
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	public function Logout()
	{
		$key = md5($_COOKIE['autoLogin'].$_SESSION['client']);
		$query = 'DELETE FROM `autoLogin` WHERE `ip`="'.$_SESSION['ip'].'" AND `key`="'.$key.'"';
		$this->dbHandler->ExecuteQuery($query);
		setcookie('autoLogin','',time()-6000);
		unset($_COOKIE['autoLogin']);
		unset($_SESSION['loggedIn']);
		unset($_SESSION['ip']);
		unset($_SESSION['client']);
	}
	
	public static function GetLoginForm()
	{
		$html = '<form method="post">
		<input type="text" name="username" /><br />
		<input type="password" name="passwd" /><br />
		<input type="checkbox" name="remember" /> Запомняне <br />
		<input type="submit" name="login" value="Login" />
		</form>';
		return $html;
	}
}