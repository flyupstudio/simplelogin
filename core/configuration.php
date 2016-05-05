<?

	$config = array('DB' => array( 'host' => 'localhost',
								   'port' => '3306', 
								   'user' => '', 
								   'password' => '', 
								   'database' => '', 
								   'type' => 'mysql' 
							), 
					'charset' => 'UTF-8', 
					'title' => '', 
					'meta-keywords' => '', 
					'meta-description' => '', 
					'admin-email' => '', 
					'manager-email' => '', 
					'info-email' => '', 
					'theme' => 'office2007', 
					'auth' => array( 'table' => 'users', 
									 'f_username' => 'username', 
									 'f_password' => 'password', 
									 'f_redirect' => 'redirect', 
									 'template' => 'login.html', 
									 'session' => 'user_account', 
									 'error' => 'Not correct login or password!' ),
					'azone_auth' => array( 'table' => 'az_users', 
									 	   'f_username' => 'username', 
									 	   'f_password' => 'password', 
									 	   'f_redirect' => 'redirect', 
									 	   'template' => 'login.html', 
									 	   'session' => 'azone_account', 
									 	   'error' => 'Not correct login or password!' ), 
					'site_url' => "http://{$_SERVER['HTTP_HOST']}/",
					'azone_url' => "http://{$_SERVER['HTTP_HOST']}/azone/",
					'absolute-path' => "{$_SERVER['DOCUMENT_ROOT']}/"
					);

?>
