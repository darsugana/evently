<?php

/**
 * This is the starter class for User_Generated.
 *
 * @see User_Generated, CoughObject
 **/
class User extends User_Generated implements CoughObjectStaticInterface {
	
	const PASSWORD_SALT = '2fy5SV"cx';
	
	private static function hashPassword($password, $email)
	{
		return hash('sha256', $password . $email . self::PASSWORD_SALT);
	}
	
	public function setPassword($password)
	{
		$this->setPasswordHash(self::hashPassword($password, $this->getEmail()));
	}
	
	public static function constructByEmailAndPassword($email, $password)
	{
		$db = self::getDb();
		
		$sql = '
			SELECT
				*
			FROM
				user
			WHERE
				email = '. $db->quote($email) .'
				AND (password_hash = ' . $db->quote($password) . '
					OR password_hash = ' . $db->quote(self::hashPassword($password, $email)) . ')
				AND is_deleted = 0
		';
		
		return self::constructBySql($sql);
		
	}
	
}

?>