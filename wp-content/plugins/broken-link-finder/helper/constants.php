<?php
	
	class MOBLC_Constants
	{
		const HOST_NAME					= "https://login.xecurify.com";		
		const DEFAULT_CUSTOMER_KEY		= "16555";
		const DEFAULT_API_KEY 			= "fFd2XcvTGDemZvbw1bcUesNJWEqKbbUq";
	
		function __construct()
		{
			$this->define_global();
		}

		function define_global()
		{
			global $moblc_db_queries,$moblc_utility,$moblc_dirname;
			$moblc_db_queries	= new MOBLC_DATABASE();
			$moblc_dirname 		= plugin_dir_path(dirname(__FILE__));
		}
		
	}
	new MOBLC_Constants;

?>