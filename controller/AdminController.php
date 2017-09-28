<?php 

namespace controller;

use core\Request;
use core\ServiceContainer;

class AdminController extends BaseController
{
	public function __construct(Request $request, ServiceContainer $container)
	{
		parent::__construct($request, $container);

		$this->title .= '::AdminConsole';
	}

	public function response()
	{
		echo $this->template(
			'v_main_admin', 
			[
				'title' => $this->title,
				'content' => $this->content
			]
		);
	}
}