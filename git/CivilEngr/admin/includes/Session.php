<?php 
	 if (session_status() == PHP_SESSION_NONE)
                    session_start();
	
	function logout($indexpage)
	{

	//2. unset the session
	$_SESSION = array();

	//3. Destroy the session cookie
	if(isset($_COOKIE[session_name()]))
	{
		setcookie(session_name(),'',time()-42000,'/');
	}

	// 4. Destroy the session
	session_destroy();


	// then lastly redirect to a page
	redirect_to("{$indexpage}");
	}

?>