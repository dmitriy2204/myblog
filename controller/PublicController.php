<?php 

namespace controller;

use core\Request;
use core\ServiceContainer;

class PublicController extends BaseController
{
	public function __construct(Request $request, ServiceContainer $container)
	{
		parent::__construct($request, $container);
	}

	public function response()
	{
		echo $this->template(
			'v_main', 
			[
				'title' => $this->title,
				'content' => $this->content
			]
		);
	}

		
}